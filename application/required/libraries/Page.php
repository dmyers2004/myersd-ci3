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
				$this->variable($name,$value);
			}
		}
  }
	
	public function load($key) {
		$this->config[$key]($this,get_instance());
	}

	public function clear($which,$clear) {
		foreach ($this->added as $hash => $record) {
			if ($record[$which] == $clear) {
				unset($this->added[$hash]);	
			}
		}
	
		return $this;
	}

	/* add global data wrapper for chaining */
	public function variable($key,$value,$where='#') {
		$this->add($key,$value,$where,'variable');
		
		return $this;
	}
	
	public function append($key,$value) {
		$this->add($key,$value,'>','variable');
		
		return $this;
	}

	public function prepend($key,$value) {
		$this->add($key,$value,'<','variable');
		
		return $this;
	}
	
	public function property($key,$value) {
		$this->add($key,$value,'#','property');
		
		return $this;
	}

	public function object($key,$value) {
		$this->add($key,$value,'#','object');
		
		return $this;
	}
	
	/* attach css */
  public function css($href='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$href),$additional_attributes);
		$html = '<link '.$this->_ary2attr($merged).' />';
		if ($where === true) {
			return $html;	
		}
    $this->add($this->config['preset']['css'],'<link '.$this->_ary2attr($merged).' />',$where,'css');

    return $this;
  }

	/* add js */
  public function js($file='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$file),$additional_attributes);
		$html = '<script '.$this->_ary2attr($merged).'></script>';
		if ($where === true) {
			return $html;	
		}
    $this->add($this->config['preset']['js'],$html,$where,'js');

    return $this;
  }

	/* attach meta data */
  public function meta($name='',$content='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
		$html = '<meta '.$this->_ary2attr($merged).'>';
		if ($where === true) {
			return $html;	
		}
    $this->add($this->config['preset']['meta'],$html,$where,'meta');

    return $this;
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
	
	/* wrapper for load partial */
	public function partial($view,$data=array(),$name=null)
	{
		$html = $this->load->partial($view,$data,$name);
		
		if ($name == null) {
			return $html;	
		}
		
		return $this;
	}
	
	/* wrapper for load view with automagic */
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
		events::trigger('pre_build',$this,'array');
		$this->pre_build();

		if ($view !== false) {
			$view = ($view) ? $view : getData('automagic');
			data($this->config['variable_mappings']['container'],$this->load->partial($view));
  	}

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),null,false);

		/* allow chaining -- of course I'm not sure where your going after final output?? */
		return $this;
	}

	/* private internal function below */
	private function pre_build() {
		
		foreach ($this->added as $record) {
			switch ($record['type']) {
				case 'object':
				case 'meta':
				case 'css':
				case 'js':
				case 'variable':
				break;
				case 'property':
					if ($record['key'] == 'theme') {
						/* need to add the CI package so this is special */
						$this->theme($record['value']);
					} else {
						$this->$record['key'] = $record['value'];
					}
				break;
			}
			
			data(getDefault($this->config['variable_mappings'][$record['key']],$record['key']),$record['value'],$record['where']);
		}
	}
	
	/* heavy lifter */
	private function add($key,$value=null,$where=null,$type='generic') {
		
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