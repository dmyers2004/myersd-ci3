<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
  private $CI;

	public $settings = array();

  public $js = array();
  public $css = array();
  public $meta = array();

	public $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	public $default_js = array('src'=>'');
	public $default_meta = array('name'=>'','content'=>'');

  public $config = array();

  public function __construct()
  {
    $this->CI = &get_instance();

    $this->CI->load->config('page',TRUE);
    $this->config = $this->CI->config->item('page');
		
		$this->settings = $this->config['default'];
  }

	public function load($name) {
		$this->settings = array_merge_recursive($this->settings,$this->config[$name]);
		
		/* can only be one */
		$this->settings['template'] = ($this->config[$name]['template']) ? $this->config[$name]['template'] : $this->settings['template'];
		$this->settings['body_class'] = ($this->config[$name]['body_class']) ? $this->config[$name]['body_class'] : $this->settings['body_class'];
	}

  public function css($href='',$append=array(),$first=false)
  {
    return $this->link($href,$append);
  }
  
  public function link($href='',$append=array(),$after='after')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$this->_prefix($href)),$append);
    $this->add('css','<link '.$this->_ary2attr($merged).' />',$after);

    return $this;
  }

  public function js($file='',$append=array(),$first=false)
  {
    return $this->script($file,$append);
  }
  
  public function script($file='',$append=array(),$after='after')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$this->_prefix($file)),$append);
    $this->add('js','<script '.$this->_ary2attr($merged).'></script>',$after);

    return $this;
  }

  public function meta($name='',$content='',$append=array(),$after='after')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$append);
    $this->add('js','<meta '.$this->_ary2attr($merged).'>',$after);

    return $this;
  }

  /* append onto current title */
  public function title($title=null)
  {
		$this->settings['title'] = ($title) ? $this->settings['title_separator'].$title : '';

    $this->CI->load->_ci_cached_vars[$this->config['variables']['title']] = $this->settings['title'];

    return $this;
  }

  /* change the template */
  public function template($name=null)
  {
    $this->settings['template'] = $name;
    return $this;
  }

	/* load a template (always returned) optional load into view variable */
	public function partial($view,$data=array(),$name=null)
	{
		$this->prep();
		
		$temp = $this->view($view,$data,true);
		
		if ($name) {
			$this->CI->load->_ci_cached_vars[$name] = $temp;
		}
		
		return $temp;
	}

	/* final output */
  public function build($view,$layout=null)
  {
		$this->prep();

    /* final output */
    $this->CI->load->view((($layout) ? $layout : $this->settings['template']), array($this->config['variables']['container']=>$this->CI->load->view($view,array(),true)), false);
	}

	private function add($which,$what,$where='after') {
		$md5 = md5($what);
		
		if ($where == 'after') {
    	$this->$which[$md5] = $what;
		} else {
			/* unset where every it is now */
			unset($this->$which[$md5]);
			
			/* append to front */
			$this->$which = $this->$which[$md5] + array($md5=>$this->$what);
		}

		$this->CI->_ci_cached_vars[$this->config['variables'][$which]] = implode(chr(10),$this->$which);
	}

	private function prep()
	{
    /* run the autoloaders */
    foreach ($this->settings['css'] as $css) {
    	$this->link($css);
    }
    
    foreach ($this->settings['js'] as $js) {
    	$this->script($js);
    }
    
    foreach ($this->settings['meta'] as $meta) {
    	$this->meta($meta);
    }

		foreach ($this->settings as $key => $value) {
			$this->CI->load->_ci_cached_vars[$key] = $value;
		}

		/* can only be one */
		$this->CI->_ci_cached_vars[$this->config['variables']['title']] = $this->settings['title'];
		$this->CI->_ci_cached_vars[$this->config['variables']['body_class']] = $this->settings['body_class'];
		
		print_r($this->CI->_ci_cached_vars);
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
      return base_url().$this->folder.$input;
    } else {
      return base_url().$input;
    }
  }

} /* end class */
