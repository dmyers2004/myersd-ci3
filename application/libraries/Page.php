<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
  public $config = array(); /* all config */
  public $settings = array('js'=>array(),'css'=>array(),'meta'=>array(),'data'=>array()); /* array of current settings */

	public $template = ''; /* template to use on build */
	public $folder = ''; /* folder to look in for all page view files */
	public $assets = '';
	public $separator = ' / ';

	public $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	public $default_js = array('src'=>'');
	public $default_meta = array('name'=>'','content'=>'');

  public function __construct()
  {
		/* load using the magic settings file -> database */
    $this->config = $this->load->settings('page');

		$this->separator = $this->config['title.separator']

		/* raw base value (strings) injected into view variables */
		$this->base();

		/* load in our defaults */
		$this->load('default');
  }

	private function base() {
		foreach ($this->config['base'] as $key => $value) {
			$this->setVar($this->config[$key],$value);
		}
	}

	public function load($grouping)
	{
		$group = $this->config[$grouping];
		
		foreach ((array)$group['meta'] as $value) {
			$this->meta($value);
		}

		foreach ((array)$group['css'] as $value) {
			$this->link($value);
		}

		foreach ((array)$group['js'] as $value) {
			$this->script($value);
		}

		foreach ((array)$group['data'] as $key => $value) {
			$this->setVar($key,$value);
		}

		/* append any new title sections */
		$this->title($group['title']);

		/* change the template and folders if new values are present */
		$this->template = $this->getDefault($group['template'],$this->template);
		$this->folder = $this->getDefault($group['folder'],$this->folder);
		$this->assets = $this->getDefault($group['assets'],$this->assets);

		return $this;
	}

  public function css($href='',$additional_attributes=array(),$after='after')
  {
    return $this->link($href,$additional_attributes,$after);
  }

  public function link($href='',$additional_attributes=array(),$after='after')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$this->_prefix($href)),$additional_attributes);
    $this->add('meta','<link '.$this->_ary2attr($merged).' />',$after);

    return $this;
  }

  public function js($file='',$additional_attributes=array(),$after='after')
  {
    return $this->script($file,$additional_attributes,$after);
  }

  public function script($file='',$additional_attributes=array(),$after='after')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$this->_prefix($file)),$additional_attributes);
    $this->add('footer','<script '.$this->_ary2attr($merged).'></script>',$after);

    return $this;
  }

  public function meta($name='',$content='',$additional_attributes=array(),$after='after')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
    $this->add('meta','<meta '.$this->_ary2attr($merged).'>',$after);

    return $this;
  }

  /* append onto current title */
  public function title($title=null)
  {
		if ($title) {
			$this->add('title',$this->separator.$title);
		}

    return $this;
  }

	/* add body class */
  public function addBodyClass($class=null)
  {
		$this->add('page_body_class',$class);
		
    return $this;
  }

	/* change the title separator */
  public function separator($separator=null)
  {
    $this->separator = $separator;

    return $this;
  }

  /* change the template */
  public function template($name=null)
  {
    $this->template = $name;

    return $this;
  }

  /* change the view look up folder */
	public function folder($folder=null)
	{
		$this->folder = $folder;

		return $this;
	}
	
	/* change the default assets folder (off web root) */
	public function assets($folder=null)
	{
		$this->assets = $folder;

		return $this;
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

		$this->setVar($this->config['variables.container'],$this->load->partial($this->folder.$view));

    /* final output */
    $this->load->view((($layout) ? $layout : $this->folder.$this->template),null,false);

		return $this;
	}

	/* Add to meta, header, footer before or after what already in there */
	public function add($which='',$what=null,$where='after')
	{
		if (!empty($what)) {
			$var = $this->getDefault($this->config['variables.'.$which],$which);
	
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