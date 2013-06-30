<?php
/*

CREATE TABLE `nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `text` varchar(64) DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `sort` tinyint(2) unsigned DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
)

$privs = array('/parent','/file','/edit/cut','/edit/copy','/windows/a','/permission/*');

$menu[] = array('id'=>16,'resource'=>'/parent','url'=>'/','text'=>'Project','parent_id'=>0,'class'=>'brand');
$menu[] = array('id'=>1	,'resource'=>'/file','url'=>'/cookies/','text'=>'File','parent_id'=>0);
$menu[] = array('id'=>6	,'resource'=>'/edit','url'=>'','text'=>'Edit','parent_id'=>0);
$menu[] = array('id'=>11,'resource'=>'/windows','url'=>'/menu/windows','text'=>'Windows','parent_id'=>0);
$menu[] = array('id'=>17,'resource'=>'/permission','url'=>'','text'=>'Permission','parent_id'=>0);

$menu[] = array('id'=>18	,'resource'=>'/permission/users','url'=>'/admin/user','text'=>'Users','parent_id'=>17);
$menu[] = array('id'=>19	,'resource'=>'/permission/groups','url'=>'/admin/group','text'=>'Groups','parent_id'=>17);
$menu[] = array('id'=>20	,'resource'=>'/permission/access','url'=>'/admin/access','text'=>'Access','parent_id'=>17);

$menu[] = array('id'=>2	,'resource'=>'/file/open','url'=>'/file/open','text'=>'Open','parent_id'=>1);
$menu[] = array('id'=>3	,'resource'=>'/file/save','url'=>'/file/save','text'=>'Save','parent_id'=>1);
$menu[] = array('id'=>4	,'resource'=>'/file/close','url'=>'/file/close','text'=>'Close','parent_id'=>1);
$menu[] = array('id'=>5	,'resource'=>'/file/quit','url'=>'/file/quit','text'=>'Quit','parent_id'=>1);

$menu[] = array('id'=>7	,'resource'=>'/edit/cut','url'=>'/eat/edit/cut','text'=>'Cut','parent_id'=>6);
$menu[] = array('id'=>8	,'resource'=>'/edit/copy','url'=>'/edit/copy','text'=>'Copy','parent_id'=>6);
$menu[] = array('id'=>9	,'resource'=>'/edit/paste','url'=>'/edit/paste','text'=>'Paste','parent_id'=>6);
$menu[] = array('id'=>10,'resource'=>'/edit/undo','url'=>'/edit/undo','text'=>'Undo','parent_id'=>6);

$menu[] = array('id'=>12,'resource'=>'/windows/a','url'=>'/windows/a','text'=>'Window A','parent_id'=>11);
$menu[] = array('id'=>13,'resource'=>'/windows/b','url'=>'/windows/b','text'=>'Window B','parent_id'=>11);
$menu[] = array('id'=>14,'resource'=>'/windows/c','url'=>'/windows/c','text'=>'Window C','parent_id'=>11);
$menu[] = array('id'=>15,'resource'=>'/windows/d','url'=>'/windows/d','text'=>'Window D','parent_id'=>11);

*/
class Menubar
{
	protected $filtered = array(); /*	 filtered menu array */

	public function __construct()
	{
		$this->load->model('menubar_model');
		
		events::register('pre_partials/nav',array($this,'tohtml'));
	}

	public function tohtml($data) {
		$menu = $this->get_active();
		$roles = get_instance()->auth->get_user_roles();
		
		data('navigation_menu',$this->render($roles,$menu));
	}

	public function render($privs = null,$menus = null)
	{
		/* let's pad the select all below */
		$p = array();
		foreach ((array) $privs as $r) {
			if (substr($r,-1) == '*') {
				$p[] = $r . '/*/*/*/*';
			} else {
				$p[] = $r;
			}
		}

		// recurse menus for access fills $this->filtered
		$this->generate_access_list($p,$menus);

		$menu = array();

		foreach ($this->filtered as $record) {
			$menu[$record['parent_id']][$record['id']] = $record;
		}

		return $this->build_tbs_menu($menu);
	}

	protected function build_tbs_menu($menu)
	{
		$html = '';
		
		if (is_array($menu) && isset($menu[0])) {
			/* now generate the bootstrap menu */
			$html = '';
			foreach ($menu[0] as $key => $item) {
				if (isset($menu[$key])) {
					/* has children */
					$html .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">';
					$html .= $item['text'].' <b class="caret"></b></a><ul class="dropdown-menu">';
					foreach ($menu[$key] as $key2 => $item2) {
						$html .= '<li><a class="'.$menu[$key][$key2]['class'].'" href="'.$menu[$key][$key2]['url'].'">'.$menu[$key][$key2]['text'].'</a></li>';
					}
					$html .= '</ul></li>';
				} else {
					/* no children */
					$html .= '<li><a class="'.@$item['class'].'" href="'.@$item['url'].'">'.@$item['text'].'</a></li>';
				}
			}
		}

		return $html;
	}

	/**
	 * generate_access_list function.
	 *
	 * @param Array $privileges
	 * @param Array $menus
	 * @param Integer (default: 0) parent
	 * @return void
	 */
	protected function generate_access_list($privs,$menu,$parent=0)
	{
		foreach ($menu as $key => $value) {
			if ($value['parent_id'] == $parent) {
				foreach ($privs as $priv) {
					if ($this->checkuri($value['resource'],$priv)) {
						$this->filtered[] = $value;
						$this->generate_access_list($privs,$menu,$value['id']);
						break;
					}
				}
			}
		}

	}

	/**
	 * Permissions - stand alone functions
	 *
	 * @param String URI /file/open
	 * @param String /file/* or /file/open
	 */
	protected function checkuri($uri,$priv)
	{
		$uri = explode('/',trim($uri,'/'));
		$priv = explode('/',trim($priv,'/'));

		foreach ($uri as $key => $value) {
			if ($priv[$key] != $uri[$key] && $priv[$key] != '*') {
				return false;
			}
		}

		/*	all good! */
		return true;
	}

	/* wrappers for the model pass thru */
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->menubar_model, $method) ) {
			throw new Exception('Undefined method menubar::' . $method . '() called');
		}

		return call_user_func_array( array($this->menubar_model, $method), $arguments);
	}

	/* wrapper for CI instance */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end menubar class */
