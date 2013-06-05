<?php

class formController extends CI_Controller
{
    const IMAGE_UPLOAD_DIR = 'assets/uploads/images';

    public function __construct()
    {
      parent::__construct();
      $this->_supported_extensions = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
    }

    public function indexAction()
    {
			$this->data['ckeditor'] = $this->_setup_ckeditor('content');
			$this->data['content_html'] = '<h1>Hello</h1> <h2>World</h2>'; // your model property's HTML for CKEditor textarea

      $this->load->view('form',$this->data);
    }

    public function saveAction()
    {
      if (FALSE !== $this->input->post('content')) {
          // persist model for 'content' value containing uploaded file's img reference.
      }

      header('Location: /form/');
      exit();
    }

    /**
     * Output CKEditor Javascript callback function for image file uploaded
     * in $_FILES['upload']. The GET parameters must also contain the
     * CKEditorFuncNum parameter so the JavaScript callback will reference
     * the correct CKEditor instance.
     */
    public function uploadPostAction()
    {
        $callback = 'null';
        $url = '';
        $get = array();

        // for form action, pull CKEditorFuncNum from GET string. e.g., 4 from
        // /form/upload?CKEditor=content&CKEditorFuncNum=4&langCode=en
        // Convert GET parameters to PHP variables
        $qry = $_SERVER['REQUEST_URI'];
        parse_str(substr($qry, strpos($qry, '?') + 1), $get);

        if (!isset($_POST) || !isset($get['CKEditorFuncNum'])) {
            $msg = 'CKEditor instance not defined. Cannot upload image.';
        } else {
            $callback = $get['CKEditorFuncNum'];
            try {
                $url = $this->_move_image($_FILES['upload']);
                $msg = "File uploaded successfully to: {$url}";

                // Persist additions to file manager CMS here.

            } catch (Exception $e) {
                $url = '';
                $msg = $e->getMessage();
            }
        }

        $output = '<html><body><script type="text/javascript">' .
            'window.parent.CKEDITOR.tools.callFunction(' .
            $callback .
            ', "' .
            $url .
            '", "' .
            $msg .
            '");</script></body></html>';

        echo $output;
    }

    /**
     * Move uploaded file to the storage directory only if its MIME type is
     * accepted.
     *
     * @param $temp_location $_FILES array entry w/ details of local file.
     * @throws Exception When there are issues moving file to upload directory.
     */
    private function _move_image($temp_location)
    {
        $filename = basename($temp_location['name']);
        $info = pathinfo($filename);
        $ext = strtolower($info['extension']);

        if (isset($temp_location['tmp_name']) &&
            isset($info['extension']) &&
            in_array($ext, $this->_supported_extensions)) {
            $new_file_path = self::IMAGE_UPLOAD_DIR . "/$filename";
            if (!is_dir(self::IMAGE_UPLOAD_DIR) ||
                !is_writable(self::IMAGE_UPLOAD_DIR)) {
                // Attempt to auto-create upload directory.
                if (!is_writable(self::IMAGE_UPLOAD_DIR) ||
                    FALSE === @mkdir(self::IMAGE_UPLOAD_DIR, null , TRUE)) {
                    throw new Exception('Error: File permission issue, ' .
                        'please consult your system administrator');
                }
            }

            if (move_uploaded_file($temp_location['tmp_name'], $new_file_path)) {
                return '/' . $new_file_path;
            }
        }

        throw new Exception('File could not be uploaded.');
    }

    /**
     * Retrieve configuration properties for CKEditor instance. Ensure the
     * CodeIgniter helper has been copied to CI's system directory.
     *
     * @param $id HTML id="" attribute CKEditor instance is enabled for.
     *
     * @return array First parameter for display_ckeditor() function invoked
     *         in the CI view.
     */
    private function _setup_ckeditor($id)
    {
        $this->load->helper('url');
        $this->load->helper('ckeditor');

        $ckeditor = array(
            'id' => $id,
            'path' => 'assets/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '800px',
                'height' => '400px',
                'filebrowserImageUploadUrl' => '/form/upload/')
        );

        return $ckeditor;
    }
}
