<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
  private $CI;

  public $config = array(); /* all config */
  public $settings = array('js'=>array(),'css'=>array(),'meta'=>array(),'data'=>array()); /* array of current settings */

	public $template; /* template to use */

	public $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	public $default_js = array('src'=>'');
	public $default_meta = array('name'=>'','content'=>'');

  public function __construct()
  {
    $this->CI = &get_instance();

    $this->CI->load->config('page',TRUE);
    $this->config = $this->CI->config->item('page');
		
		/* set the title */
		$this->setVar($this->config['variables']['title'],$this->config['application']['title']);
		
		/* load in our defaults */
		$this->load('default');
  }

	public function load($grouping)
	{
		$group = $this->config[$grouping];

		if (is_array($group['js'])) {
			$this->settings['js'] = array_merge($this->settings['js'],$group['js']);
			foreach ($this->settings['js'] as $value) {
				$this->script($value);
			}
		}

		if (is_array($group['css'])) {
			$this->settings['css'] = array_merge((array)$this->settings['css'],$group['css']);
			foreach ($this->settings['css'] as $value) {
				$this->link($value);
			}
		}

		if (is_array($group['meta'])) {
			$this->settings['meta'] = array_merge((array)$this->settings['meta'],$group['meta']);
			foreach ($this->settings['meta'] as $value) {
				$this->meta($value);
			}
		}

		if (is_array($group['data'])) {
			$this->settings['data'] = array_merge((array)$this->settings['data'],$group['data']);
			foreach ($this->settings['data'] as $key => $value) {
				$this->setVar($key,$value);
			}
		}

		$this->template = $this->getDefault($group['template'],$this->template);

		return $this;
	}

  public function css($href='',$additional_attributes=array(),$after='after')
  {
    return $this->link($href,$additional_attributes,$after);
  }

  public function link($href='',$additional_attributes=array(),$after='after')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$this->_prefix($href)),$additional_attributes);
    $this->add('header','<link '.$this->_ary2attr($merged).' />',$after);

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
    $this->add('header','<meta '.$this->_ary2attr($merged).'>',$after);

    return $this;
  }

  /* append onto current title */
  public function title($title=null)
  {
		$this->setVar($this->config['variables']['title'],$this->getVar($this->config['variables']['title']).$this->config['application']['title_separator'].$title);

    return $this;
  }

  /* change the template */
  public function template($name=null)
  {
    $this->template = $name;
    return $this;
  }

	/* load a template (always returned) optional load into view variable */
	public function partial($view,$data=array(),$name=null)
	{
		/* always return */
		$partial = $this->view($view,$data,true);

		/*
		if name is provided then place directly into the view variable
		and return to allow chaining
		*/
		if ($name) {
			$this->setVar($name,$partial);
			return $this;
		}

		/* return the partial */
		return $partial;
	}

	/* final output */
  public function build($view,$layout=null)
  {
		$this->setVar($this->config['variables']['container'],$this->CI->load->view($view,null,true));
		$template = ($layout) ? $layout : $this->template;

    /* final output */
    $this->CI->load->view($template, null, false);

		return $this;
	}

	/* Add to css, js, meta, header, footer before or after what already in there */
	public function add($which,$what,$where='after')
	{
		$var = $this->getDefault($this->config['variables'][$which],$which);
		
		switch ($where) {
			case 'before':
				/* remove it if it's already there */
				$content = str_replace($what,'',$this->getVar($var));
				$this->setVar($var,$what.$content);			
			break;
			case 'overwrite':
				$this->setVar($var,$what);			
			break;
			default: /* append */
				/* remove it if it's already there */
				$content = str_replace($what,'',$this->getVar($var));
				$this->setVar($var,$content.$what);
		}

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
      return $this->config['assets'].$input;
    }
  }

  /* standard libs  getVar, setVar, setDefault */
  private function getVar($name)
  {
		return $this->CI->load->_ci_cached_vars[$name];
  }

  private function setVar($name,$value)
  {
		$this->CI->load->_ci_cached_vars[$name] = $value;
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


} /* end class */