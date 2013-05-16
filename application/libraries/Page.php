<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
  $this->template->link(href/array,array); - CSS
  $this->template->script(file/array,array); - SCRIPT
  $this->template->meta(name/array,content,array); - Meta Tags
  $this->template->extra(string) ; - anything else
*/
class Page
{
  private $CI;

  public $js = array();
  public $css = array();
  public $meta = array();
  public $extra = array();
  public $config = array();
  public $template = 'default';
  public $body_id = '';

  public function __construct()
  {
    $this->CI = &get_instance();

    $this->CI->load->config('page',TRUE);
    $this->config = $this->CI->config->item('page');

    $this->title();
    $this->template();

    /* run the autoloaders */
    foreach ($this->config['autoload.css'] as $css) $this->link($css);
    foreach ($this->config['autoload.js'] as $js) $this->script($js);
    foreach ($this->config['autoload.meta'] as $meta) $this->meta($meta);
  }

  public function css($href='',$append=array())
  {
    return $this->link($href,$append);
  }
  
  public function link($href='',$append=array())
  {
    $merged = (is_array($href)) ? $href : array_merge($this->config['default.css'],array('href'=>$this->_prefix($href,$this->config['css.folder'])),$append);
    $this->css[md5(serialize($merged))] = '<link '.$this->_ary2attr($merged).' />';
    $this->CI->data->page_css = implode(chr(10),$this->css);

    return $this;
  }

  public function js($file='',$append=array())
  {
    return $this->script($file,$append);
  }
  
  public function script($file='',$append=array())
  {
    $merged = (is_array($file)) ? $file : array_merge($this->config['default.js'],array('src'=>$this->_prefix($file,$this->config['js.folder'])),$append);
    $this->js[md5(serialize($merged))] = '<script '.$this->_ary2attr($merged).'></script>';
    $this->CI->data->page_js = implode(chr(10),$this->js);

    return $this;
  }

  public function meta($name='',$content='',$append=array())
  {
    $merged = (is_array($name)) ? $name : array_merge($this->config['default.meta'],array('name'=>$name,'content'=>$content),$append);
    $this->meta[md5(serialize($merged))] = '<meta '.$this->_ary2attr($merged).'>';
    $this->CI->data->page_meta = implode(chr(10),$this->meta);

    return $this;
  }

  public function extra($extra='')
  {
    $this->extra[md5(serialize($extra))] = $extra;
    $this->CI->data->page_extra = implode(chr(10),$this->extra);

    return $this;
  }

  public function title($title=null)
  {
    $this->CI->data->page_title = ($title) ? $title : $this->config['title'];

    return $this;
  }

  public function template($name=null)
  {
    $this->template = ($name) ? $name : $this->config['default.template'];

    return $this;
  }

  public function body($view,$name=null)
  {
    if ($name === TRUE) return $this->CI->load->view('/'.$view, $this->CI->data, TRUE);
    
    $name = ($name) ? $name : $this->config['body'];
    $this->CI->data->$name = $this->CI->load->view('/'.$view, $this->CI->data, TRUE);

    return $this;
  }

  public function partial($view,$name)
  {
    if ($name === TRUE) return $this->body($this->config['partials.folder'].'/'.$view,TRUE);

    $this->body($this->config['partials.folder'].'/'.$view,$name);

    return $this;
  }

  public function build()
  {
    $class = substr($this->CI->router->class,0,-11);
    $method = $this->CI->router->method;
    
    $this->CI->data->page_body_id = (empty($this->body_id)) ? $class.'_'.$method : $this->body_id;
        
    $name = $this->config['body'];

    if (empty($this->CI->data->$name)) $this->body($class.'/'.$method);

    $this->CI->load->view($this->config['templates.folder'].'/'.$this->template, NULL , FALSE);
    
    return $this;
  }

  private function _ary2attr($array)
  {
    $output = '';
    foreach ((array) $array as $name => $value) {
      $output .= $name.'="'.$value.'" ';
    }

    return trim($output);
  }

  private function _prefix($input,$asset)
  {
    if (substr($input,0,4) == 'http') {
      return $input;
    } elseif ($input{0} == '/') {
      return base_url().$this->folder.$input;
    } else {
      return base_url().$asset.$input;
    }
  }

} /* end class */
