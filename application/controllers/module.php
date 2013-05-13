<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends CI_Controller {

	public function _remap($module_folder, $options = array()) {
		/* let's find the controller */
		
		$foo = $this->config->config['modules_locations'];
		$module_base = ($foo) ? $foo : APPPATH.'modules/';
		
		switch(count($options)) {
			case 0:
				list($controller,$method) = $this->_get_defaults($this->router->routes['default_controller']);
				$params = array();
			break;
			case 1:
				list($controller,$method) = $this->_get_defaults($this->router->routes['default_controller']);
				$controller = array_shift($options);
				$params = array();
			break;
			case 2:
				$controller = array_shift($options);
				$method = array_shift($options);
				$params = array();
			break;
			default:
				$controller = array_shift($options);
				$method = array_shift($options);
				$params = $options;
		}

		/*
		echo '<pre>Module Base: '.$module_base.chr(10);
		echo '<pre>Module Folder: '.$module_folder.chr(10);
		echo '<pre>Controller: '.$controller.chr(10);
		echo '<pre>Method: '.$method.chr(10);
		echo '<pre>Params: '.print_r($params,true).chr(10);
		*/
		
		return $this->_load_controller($module_base.$module_folder,$controller,$method,$params,false);
	}

	private function _get_defaults($default='') {
		return (strpos($default,'/') === false) ? array($default,'index') : explode('/',$default);
	}
	
	private function _load_controller($folder,$controller,$method='index',$params=array()) {
		$file = $folder.'/controllers/'.$controller.'.php';
		
		if (file_exists($file)) {
		
			/* include our class file */
			include($file);
			
			/* build our controller */
			$module_controller = new $controller();
		
			/* does this method exists on this object */
			if (is_callable(array($module_controller,$method))) {
		
				/* add module to the path */
				$this->load->add_package_path($folder,TRUE);
		
				/* call method on object */
				return call_user_func_array(array($module_controller,$method),$params);
			}
		}

		/* throw router 404 if it's there */
		if (!$die) {
			list($controller,$method) = $this->_get_defaults($this->router->routes['404_override']);
			return $this->_load_controller(APPPATH,$controller,$method,$params,true);
		}

		/* if all else fails throw standard 404 */
		show_404();
	}

}