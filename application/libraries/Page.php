<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
Page Events:
page.build
page.load.(partials.head) <= folder/file

Examples:
page.load.partials.start
page.load.partials.head
page.load.partials.body
page.load.partials.header
page.load.partials.center
page.load.partials.footer
page.load.partials.end

Requires:
Settings Library
Events Library

Global view "include" function
by calling this function instead of php include/require
a trigger will be thrown
in addition includes will not be loaded based show/hide values
*/
function load($file,$return=false)
{
	$ci = get_instance();

	/* let's get the show array */
	$show = $ci->page->show();

	/* strip extension if included */
	$file = preg_replace('/\.[^.]*$/', '', $file);

	/* if show[file] does not equal false then continue processing it */
	if ($show[$file] !== FALSE) {
		/* trigger pre_[view file] event ie. prepartialhead or preshoppingcart */
		events::trigger(str_replace(array('/','-','_'),array('.','',''),'page.load.'.$file),null,'array');
		
		/* load and output the file */
		$ci->load->view($file,array(),$return);
	}
}

class Page
{
  private $config = NULL; /* all configs local cache */
	private $template = ''; /* template to use in build method */
	private $theme = ''; /* theme folder for views (added as a package) */
	private $assets = ''; /* normal assets */
	private $plugins = ''; /* plugin assets */
	private $show = array();
	private $tags = array();

  public function __construct()
  {
    $this->config = $this->load->settings('page');

		/* load any database settings into the views variables */
		foreach ($this->settings->get_settings_by_group('page') as $name => $value) {
			$this->data($name,$value,'#');
		}
  }

	/* load a config file grouping (Closure Function) */
	public function config($key)
	{
		$this->config[$key]($this);

		return $this;
	}

  /* setter and getter for template */
  public function template($name=null)
  {
    $this->template = $name;
    
    return $this;
  }

	public function tag($name,$value=null) {
		/* extra steps for themes */
		if ($name == 'theme') {
			if ($value === null) {
	  		$this->load->remove_package_path($this->theme);
				$this->theme = null;
			} else {
				$theme_folder = APPPATH.'../themes/'.basename($value).'/';

				if (file_exists($theme_folder.'config.php')) {
					include($theme_folder.'config.php');
					$theme($this);
				}

				$this->load->add_package_path($theme_folder, TRUE);
		  	$this->theme = basename($value);
			}
		}
		
		/* remove or set */
		if ($value === null) {
			unset($this->tags['{'.$name.'}']);
		} else {
	    $this->tags['{'.$name.'}'] = $value;
		}
		
    return $this;		
	}

	/* getter and setter for variable mappings */
	public function map($name=null,$value=null) {
		if ($name === null) {
			return $this->config['variable_mappings'];
		}

		if ($value === null) {
			return $this->config['variable_mappings'][$name];
		}

		$this->config['variable_mappings'][$name] = $value;

		return $this;
	}

	/* hide/show/is shown wrappers for _show */
	public function hide($name=null) {
		return $this->_show($name,false);
	}

	public function show($name=null) {
		return $this->_show($name,true);
	}

	public function shown($name) {
		return $this->_show($name);
	}

	/* overwrites */
	public function set($key,$value) {
		return $this->data($key,$value);
	}

	/* appends */
	public function style($style) {
		return $this->data('style',$style,'>');
	}

	/* appends */
	public function script($script) {
		return $this->data('script',$script,'>');
	}

	/* appends (strings only) */
	public function append($key,$value) {
		return $this->data($key,$value,'>');
	}

	/* prepends (strings only) */
	public function prepend($key,$value) {
		return $this->data($key,$value,'<');
	}

	/* overwrites - really the same as set but looks more like for "functions" */
	public function func($key,$value) {
		return $this->data($key,$value);
	}

	/* clear view variable */
	public function clear($name=null) {
		if ($name != null) {
			$this->load->_ci_cached_vars[$this->map($name)] = null;
		} else {
			foreach ($this->config['variable_mappings'] as $key => $val) {
				$this->load->_ci_cached_vars[$val] = null;
			}
		}

		return $this;
	}

	/* This is majorly overloaded it is both a getting and setting */
	public function data($name=null,$value='$uNdEfInEd$',$where='#')
	{
		/* handle overloading */
		if (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->data($key,$value);
			}
			return $this;
		}

		if ($name === null) {
			return $this->load->_ci_cached_vars;
		}

		if ($value === '$uNdEfInEd$') {
			return $this->load->_ci_cached_vars[$name];
		}

		/* nothing of value even sent in? bail now */
		if ($value !== '') {
			/* ok they must want to set something */
			$name = ($this->config['variable_mappings'][$name]) ? $this->config['variable_mappings'][$name] : $name;

			/* overwrite (#) is default */
			switch ($where) {
				case '<': // Prepend
					$current = $this->load->_ci_cached_vars[$name];

					if (strpos($current, $value) !== false) {
						$value = $current;
					} else {
						$value = $value.$current;
					}
				break;
				case '>': // Append
					$current = $this->load->_ci_cached_vars[$name];

					if (strpos($current, $value) !== false) {
						$value = $current;
					} else {
						$value = $current.$value;
					}
				break;
				case '-': // Remove
					$value = str_replace($value,'',$this->load->_ci_cached_vars[$name]);
				break;
			}

			$this->load->_ci_cached_vars[$name] = $value;
		}

		return $this;
	}

  /* add a css file */
  public function css($file='',$where='>')
  {
    $merged = array_merge($this->config['default_css'],((is_string($file)) ? array('href'=>$file) : $file));
		return $this->_tag($merged,'<link',' />','css',$where);
  }

  /* add js file */
  public function js($file='',$where='>')
  {
    $merged = array_merge($this->config['default_js'],((is_string($file)) ? array('src'=>$file) : $file));
		return $this->_tag($merged,'<script','></script>','js',$where);
  }

  /* add to onready */
  public function onready($code) {
		return $this->data('onready',$code,'>');
  }

  /* add meta tag */
  public function meta($arg1='',$arg2='>',$agr3='>')
  {
		/* overload handler */
		if (is_string($arg1)) {
			$arg1 = array('name'=>$arg1,'content'=>$arg2);
			$arg2 = $arg3;
		} else {
			/* array */
			$arg3 = $arg2;
		}

		return $this->_tag($arg1,'<meta','>','meta',$arg2);
	}

	/* this will load partials, views and is chainable (if return = false) */
	public function view($view=null,$data=array(),$return=false)
	{
		$view = ($view) ? $view : $this->data('route');

		if (is_string($return)) {
			$this->load->partial($view,$data,$return);
		} else {
			$html = $this->load->view($view,$data,$return);
		}

		if ($return === true) {
			return $html;
		}

		return $this;
	}

	/* final output */
  public function build($view=null,$layout=null)
  {
		/* anyone need to process something before build? */
		events::trigger('page.build',null,'string');

		/* if they sent in a file path or nothing (ie null) then load the view file into the template "center" (mapped) */
		if ($view !== false) {
			$view = ($view) ? $view : data('route');
			$this->load->partial($view,array(),$this->config['variable_mappings']['center']);
  	}

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),array(),false);

		/* allow chaining -- of course I'm not sure where your going after final output?? */
		return $this;
	}

	/* !private functions */

  private function _tag($merged,$pre,$post,$tag,$where) {
		$attr = '';

    foreach ($merged as $name => $value) {
      $attr .= $name.'="'.$value.'" ';
    }

		$html = $pre.' '.trim($attr).$post;

		if (is_string($html)) {
			$html = str_replace(array_keys($this->tags),array_values($this->tags),$html);
		}

		if ($where === true) {
			return $html;
		}

    return $this->data($tag,$html,$where);
  }

	private function _show($name=null,$bol=null) {
		if ($name === null) {
			return $this->show;
		}

		/* strip extension if included */
		$key = preg_replace('/\.[^.]*$/', '', $name);

		if ($bol === null) {
			return $this->show[$key];
		}

		$this->show[$key] = $bol;

		return $this;
	}

	/* generic wrapper for CI instance so you can $this-> in this file */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end class */