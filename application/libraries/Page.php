<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
  public $config = array(); /* all configs local cache */

	public $template = ''; /* template to use in build method */

	public $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	public $default_js = array('src'=>'');
	public $default_meta = array('name'=>'','content'=>'');
	
	/* css where, js where */

  public function __construct()
  {
		/* load using the magic settings file -> database */
    $this->config = $this->load->settings('page');

		/* load in our defaults */
		$this->load('default');
  }
  
	public function load($grouping)
	{
		foreach ($this->config[$grouping] as $key => $value) {
			$this->add($key,$value);
		}

		return $this;
	}

	public function add($key,$value) {
		/* if the key starts with $ then it's applied to $this (page object) */
		if ($key{0} == '$') {
			$key = substr($key,1);
			$this->$key = $value;
		} else {
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

  public function css($href='',$additional_attributes=array(),$where='after')
  {
    return $this->link($href,$additional_attributes,$where);
  }

  public function link($href='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$this->_prefix($href)),$additional_attributes);
    $this->_add('meta','<link '.$this->_ary2attr($merged).' />',$where);

    return $this;
  }

  public function js($file='',$additional_attributes=array(),$where='after')
  {
    return $this->script($file,$additional_attributes,$where);
  }

  public function script($file='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$this->_prefix($file)),$additional_attributes);
    $this->_add('footer','<script '.$this->_ary2attr($merged).'></script>',$where);

    return $this;
  }

  public function meta($name='',$content='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
    $this->_add('meta','<meta '.$this->_ary2attr($merged).'>',$where);

    return $this;
  }

  /* change the template */
  public function template($name=null)
  {
    $this->template = $name;

    return $this;
  }
  
	/* Add to meta, header, footer before or after what already in there */
	private function _add($which='',$what='',$where='after')
	{
		if (!empty($what)) {
			$var = $this->getDefault($this->config['variable_mappings'][$which],$which);
	
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
		return $this->load->partial($this->folder.$view,$data,$name);
	}

	/* final output */
  public function build($view=null,$layout=null)
  {		
		/* while the dynamic view finder is uber cool it does take a bit longer to process */
		$view = ($view) ? $view : trim($this->router->fetch_directory().str_replace('Controller','',$this->router->fetch_class()).'/'.str_replace('Action','',$this->router->fetch_method()),'/');

		$this->setVar($this->config['variable_mappings']['container'],$this->load->partial($this->folder.$view));

    /* final output */
    $this->load->view((($layout) ? $layout : $this->folder.$this->template),null,false);

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
  private function appendVar($name,$value)
  {
		$this->setVar($name,$this->getVar($name).$value);
  	return $this;
  }
  
  private function getVar($name)
  {
		return get_instance()->load->_ci_cached_vars[$name];
  }

  private function setVar($name,$value)
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