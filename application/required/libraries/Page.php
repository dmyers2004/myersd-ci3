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

	public function add($key,$value=null,$where=null) {
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

				if ($where == null) {
					$where = 'replace';
					
					if (is_string($value)) {
						if (substr($value,0,1) == '^' || substr($value,0,1) == '$') {
							$where = substr($value,0,1);
							$value = substr($value,1);
						}
					}
				}

				$this->merge($value);

				$key = getDefault($this->config['variable_mappings'][$key],$key);

				$this->data($key,$value,$where);
			}
		}

		return $this;
	}

	/* add global data wrapper for chaining */
	public function data($key,$value,$where='overwrite') {
		data($key,$value,$where);
		
		return $this;
	}

	public function merge(&$string)
	{
		if (is_string($string)) {
			$string = str_replace('{theme}',$this->theme,$string);
			$string = str_replace('{assets}',$this->assets,$string);
		}
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
    $this->add($this->config['preset']['css'],'<link '.$this->_ary2attr($merged).' />',$where);

    return $this;
  }

  public function js($file='',$additional_attributes=array(),$where='after')
  {
    return $this->script($file,$additional_attributes,$where);
  }

  public function script($file='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$this->_prefix($file)),$additional_attributes);
    $this->add($this->config['preset']['js'],'<script '.$this->_ary2attr($merged).'></script>',$where);

    return $this;
  }

  public function meta($name='',$content='',$additional_attributes=array(),$where='after')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
    $this->add($this->config['preset']['meta'],'<meta '.$this->_ary2attr($merged).'>',$where);

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

	/* wrapper for load partial */
	public function partial($view,$data=array(),$name=null)
	{
		return $this->load->partial($view,$data,$name);
	}

	public function view($view,$data=array(),$return=false)
	{
		$this->getAuto();
				
		$html = $this->load->view($view,$data,$return);

		if ($return === true) {
			return $html;
		}

		return $this;
	}

	/* final output */
  public function build($view=null,$layout=null)
  {
		$auto = $this->getAuto();

		$view = ($view) ? $view : $auto;

		data($this->config['variable_mappings']['container'],$this->load->partial($view));

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),null,false);

		return $this;
	}

	private function getAuto()
	{
		$auto = trim($this->router->fetch_directory().str_replace('Controller','',$this->router->fetch_class()).'/'.str_replace('Action','',$this->router->fetch_method()),'/');
		$this->add('bodyClass','$ '.str_replace('/',' ',$auto));
		return $auto;
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

	/* wrapper for CI instance so you can $this-> in the library */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end class */