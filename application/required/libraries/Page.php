<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
  public $config = NULL; /* all configs local cache */

	public $template = ''; /* template to use in build method */
	public $theme = ''; /* theme folder for views (added as a package) */

	public $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	public $default_js = array('src'=>'');
	public $default_meta = array('name'=>'','content'=>'');
	public $default_img = array();
	
	public $added = array();

  public function __construct()
  {
    $this->config = $this->load->settings('page');

		/* load in our defaults if any */
		$this->load('default');		

		/* load in the config as variables if it's a string */
		foreach ($this->config as $name => $value) {
			if (is_string($value)) {
				$this->set($name,$value);
			}
		}
  }
	
	public function load($key) {
		$this->config[$key]($this,get_instance());
		
		return $this;
	}

	/* clear already loaded data
			options include
			$which + $clear:
				key + name (Common names: footer, meta, bodyClass, title, header)
				value + exact value
				where + <,>, #
				type + variable, meta, css, js
	*/
	public function clear($which,$clear) {
		foreach ($this->added as $hash => $record) {
			if ($record[$which] == $clear) {
				unset($this->added[$hash]);	
			}
		}
	
		return $this;
	}

	public function set($key,$value,$where='#') {
		return $this->add($key,$value,$where,'variable');
	}

	public function append($key,$value) {
		return $this->add($key,$value,'>','variable');
	}

	public function prepend($key,$value) {
		return $this->add($key,$value,'<','variable');
	}
	
  public function css($href='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$href),$additional_attributes);
		return $this->tag($merged,'<link',' />','css',$where,$additional_attributes);
  }  
  
  public function js($file='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$file),$additional_attributes);
		return $this->tag($merged,'<script','></script>','js',$where,$additional_attributes);
  }  
  
  public function meta($name='',$content='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
		return $this->tag($merged,'<meta','>','meta',$where,$additional_attributes);
	}
	  
  /* change the template */
  public function template($name='')
  {
    $this->template = $name;
    return $this;
  }
	
	/* add theme folder (CI package) */
  public function theme($name='')
  {
  	$this->theme = $name;
		$this->load->add_package_path(APPPATH.'themes/'.$name.'/', TRUE);
  	return $this;
  }
	
	/* wrapper for chain-able load partial */
	public function partial($view,$data=array(),$name=null)
	{
		$html = $this->load->partial($view,$data,$name);
		
		if ($name == null) {
			return $html;	
		}
		
		return $this;
	}
	
	/* wrapper for chain-able load view with automagic */
	public function view($view=null,$data=array(),$return=false)
	{
		$view = ($view) ? $view : getData('automagic');
				
		$html = $this->load->view($view,$data,$return);

		if ($return === true) {
			return $html;
		}

		return $this;
	}

	/* final output */
  public function build($view=null,$layout=null)
  {
		/* let's process our stuff */
		foreach ($this->added as $record) {
			data(getDefault($this->config['variable_mappings'][$record['key']],$record['key']),$record['value'],$record['where']);
		}

		/* anyone need to process something before build? */
		events::trigger('pre_build',$this,'array');

		/* if they sent in a file path or nothing (ie null) then load the view file into the template "container" */
		if ($view !== false) {
			$this->load->partial((($view) ? $view : getData('automagic')),array(),$this->config['variable_mappings']['container']);
  	}

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),array(),false);

		/* allow chaining -- of course I'm not sure where your going after final output?? */
		return $this;
	}

  private function tag($merged,$pre,$post,$tag,$where,$additional_attributes) {
		$html = $pre.' '.$this->_ary2attr($merged).$post;

		if ($where === true || $additional_attributes === true) {
			return $html;
		}
    
    return $this->add($this->config['preset'][$tag],$html,$where,$tag);
  }

	/* heavy lifter */
	private function add($key,$value=null,$where='#',$type='generic') {
		
		/* add it to the to be processed array - the key should (basically) keep from adding the same thing twice */
		$this->added[@md5($value.$key.$type.$where)] = array('key'=>$key,'value'=>$value,'where'=>$where,'type'=>$type);

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

	/* generic wrapper for CI instance so you can $this-> in this file */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end class */