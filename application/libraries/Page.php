<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
  public $config = NULL; /* all configs local cache */

	public $template = ''; /* template to use in build method */
	public $assets = ''; /* find & replace %assets% in any strings */
	public $theme = ''; /* theme folder for views (added as a package) */

	public $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	public $default_js = array('src'=>'');
	public $default_meta = array('name'=>'','content'=>'');
	public $default_img = array();

	/* css where, js where */

  public function __construct()
  {
    $this->config = $this->load->settings('page');

		/* load in our defaults */
		$this->add('default');
  }

	public function add($key,$value=null) {
		if ($value === null) {
			foreach ((array)$this->config[$key] as $k => $v) {
				$this->add($k,$v);
			}
		} else {
			/* if the key starts with $ then it's applied to $this (page object) */
			if ($key{0} == '$') {
				if ($key == '$theme') {
					$this->theme($value);
				} else {
					$key = substr($key,1);
					$this->$key = $value;
				}
			} else {
				if ($value) {
					/* if it's not then apply it to a view variable */
					$where = $value{0};
					switch ($where) {
						case '^': /* append to current view variable */
							$value = substr($value,1);
							$where = 'before';
						break;
						case '$': /* prepend to current view variable */
							$value = substr($value,1);
							$where = 'after';
						break;
						default: /* replace what's currently in view variable */
							$where = 'overwrite';
					}
	
					/* this will try to do a mapping if a exists in $config['variables'][%key%]*/
					$this->_add($key,$value,$where);
				}
			}
		}

		return $this;
	}

	public function merge(&$string)
	{
		$string = str_replace('%theme%',$this->theme,$string);
		$string = str_replace('%assets%',$this->assets,$string);
	}

	public function img($src='',$additional_attributes=array())
	{
    $merged = (is_array($src)) ? $src : array_merge($this->img,array('src'=>$this->_prefix($src)),$additional_attributes);
		$this->merge($merged['src']);

		return $this->_ary2attr($merged);
	}

  public function css($href='',$additional_attributes=array(),$where='after')
  {
    return $this->link($href,$additional_attributes,$where);
  }

  public function link($href='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$this->_prefix($href)),$additional_attributes);
    $this->_add($this->config['preset']['css'],'<link '.$this->_ary2attr($merged).' />',$where);

    return $this;
  }

  public function js($file='',$additional_attributes=array(),$where='after')
  {
    return $this->script($file,$additional_attributes,$where);
  }

  public function script($file='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$this->_prefix($file)),$additional_attributes);
    $this->_add($this->config['preset']['js'],'<script '.$this->_ary2attr($merged).'></script>',$where);

    return $this;
  }

  public function meta($name='',$content='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
    $this->_add($this->config['preset']['meta'],'<meta '.$this->_ary2attr($merged).'>',$where);

    return $this;
  }

  /* change the template */
  public function template($name='')
  {
    $this->template = $name;

    return $this;
  }

  public function theme($name='')
  {
  	$this->theme = $name;
		$this->load->add_package_path(APPPATH.'themes/'.$name.'/', TRUE);
  	return $this;
  }

  public function assets($name='')
  {
  	$this->assets = $name;

  	return $this;
  }

	/* Add to meta, header, footer before or after what already in there */
	private function _add($which='',$what='',$where='after')
	{
		if (!empty($what)) {
			$this->merge($what);
			$var = @$this->getDefault($this->config['variable_mappings'][$which],$which);

			switch ($where) {
				case 'before':
					/* remove it if it's already there */
					$content = str_replace($what,'',$this->getVar($var));
					$this->setVar($var,$what.$content);
				break;
				case 'overwrite':
					$this->setVar($var,$what);
				break;
				default: /* append after */
					/* remove it if it's already there */
					$content = str_replace($what,'',$this->getVar($var));
					$this->setVar($var,$content.$what);
			}
		}

		return $this;
	}

	/* add view data wrapper */
	public function data($name,$value) {
		return $this->setVar($name,$value);
	}

	/* wrapper for load partial */
	public function partial($view,$data=array(),$name=null)
	{
		return $this->load->partial($view,$data,$name);
	}

	/* final output */
  public function build($view=null,$layout=null)
  {
		$auto = trim($this->router->fetch_directory().str_replace('Controller','',$this->router->fetch_class()).'/'.str_replace('Action','',$this->router->fetch_method()),'/');
		
		/* while the dynamic view finder is uber cool it does take a bit longer to process */
		$view = ($view) ? $view : $auto;

		$this->add('bodyClass','$ '.str_replace('/',' ',$auto));

		$this->setVar($this->config['variable_mappings']['container'],$this->load->partial($view));

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),null,false);

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

  private function _prefix($input)
  {
    if (substr($input,0,4) == 'http') {
      return $input;
    } elseif ($input{0} == '/') {
			return $input;
    } else {
      return $this->assets.$input;
    }
  }

  /* standard libs appendVar, getVar, setVar, getDefaultArray, getDefault */
  public function appendVar($name,$value)
  {
		$this->setVar($name,$this->getVar($name).$value);
  	return $this;
  }

  public function getVar($name)
  {
		return @get_instance()->load->_ci_cached_vars[$name];
  }

  public function setVar($name,$value)
  {
		get_instance()->load->_ci_cached_vars[$name] = $value;
		return $this;
  }

	private function getDefaultArray($array,$key,$default)
	{
		return ($array[$key]) ? $array[$key] : $default;
	}

	private function getDefault($input,$default)
	{
		return ($input) ? $input : $default;
	}

	/* wrapper for CI instance so you can $this-> in the library */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end class */