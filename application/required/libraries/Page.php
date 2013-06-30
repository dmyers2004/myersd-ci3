<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
page events include

pre_page_build
pre_partial/filename

Note: All __ (double) replaced with _ (single)

To not load a view
$page->hide('_partials/filename');

To allow it again (default to show all)
$page->show('_partials/filename');

You can also:
$page->set('lspan',0);

*/

/* global function! */
function load($file)
{
	$ci = get_instance();
	$show = $ci->page->show();
	$file = preg_replace('/\.[^.]*$/', '', $file);
	if ($show[$file] !== FALSE) {
		/* trigger pre/[view file] to be loaded event(s) */
		events::trigger(str_replace('__','_','pre_'.$file),null,'array');
		echo $ci->load->partial($file);
	}
}

class Page
{
  private $config = NULL; /* all configs local cache */

	private $template = '_templates/default'; /* template to use in build method */
	private $theme = ''; /* theme folder for views (added as a package) */

	private $default_css = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
	private $default_js = array('src'=>'');
	private $default_meta = array('name'=>'','content'=>'');
	private $show = array();
	private $added = array();

  public function __construct()
  {
    $this->config = $this->load->settings('page');

		/* load in our defaults if any */
		$this->load_config('default');		

		/* load in the config as variables if it's a string */
		foreach ($this->config as $name => $value) {
			if (is_string($value)) {
				$this->set($name,$value);
			}
		}
  }
	
	public function load_config($key) {
		$this->config[$key]($this);
		
		return $this;
	}

	public function hide($name=null) {
		return $this->_show($name,false);
	}

	public function show($name=null) {
		return $this->_show($name,true);
	}

	public function config($name) {
		return $this->config[$name];	
	}

	/* clear already loaded data
			options include
			$which + $clear:
				key + name (Common names: footer, meta, bclass, title, header)
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

	/* overwrites */
	public function set($key,$value,$where='#') {
		return $this->add($key,$value,$where,'variable');
	}

	/* appends */
	public function append($key,$value) {
		return $this->add($key,$value,'>','variable');
	}

	/* prepends */
	public function prepend($key,$value) {
		return $this->add($key,$value,'<','variable');
	}
	
  /* add a css file */
  public function css($href='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($href)) ? $href : array_merge($this->default_css,array('href'=>$href),$additional_attributes);
		return $this->tag($merged,'<link',' />','css',$where,$additional_attributes);
  }  
  
  /* add js file */
  public function js($file='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($file)) ? $file : array_merge($this->default_js,array('src'=>$file),$additional_attributes);
		return $this->tag($merged,'<script','></script>','js',$where,$additional_attributes);
  }  
  
  /* add meta tag */
  public function meta($name='',$content='',$additional_attributes=array(),$where='>')
  {
    $merged = (is_array($name)) ? $name : array_merge($this->default_meta,array('name'=>$name,'content'=>$content),$additional_attributes);
		return $this->tag($merged,'<meta','>','meta',$where,$additional_attributes);
	}
	  
  /* change the template */
  public function template($name=null)
  {
		if ($name == null) {
			return $this->template;	
		}
		
    $this->template = $name;
    return $this;
  }
	
	/* add theme folder (CI package) */
  public function theme($name=null)
  {
		if ($name == null) {
			return $this->theme;
		}
		
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
	
	/* wrapper for chain-able load view with auto route */
	public function view($view=null,$data=array(),$return=false)
	{
		$view = ($view) ? $view : getData('route');
				
		$html = $this->load->view($view,$data,$return);

		if ($return === true) {
			return $html;
		}

		return $this;
	}

	/* final output */
  public function build($view=null,$layout=null)
  {

		/* anyone need to process something before build? */
		events::trigger('pre_page_build',null,'array');

		/* if they sent in a file path or nothing (ie null) then load the view file into the template "center" (mapped) */
		if ($view !== false) {
			$this->load->partial((($view) ? $view : getData('route')),array(),$this->config['variable_mappings']['center']);
  	}

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),array(),false);

		/* allow chaining -- of course I'm not sure where your going after final output?? */
		return $this;
	}

	/* private functions */

  private function tag($merged,$pre,$post,$tag,$where,$additional_attributes) {
		$html = $pre.' '.$this->_ary2attr($merged).$post;

		if ($where === true || $additional_attributes === true) {
			return $html;
		}
    
    return $this->add($tag,$html,$where,$tag);
  }

	private function add($key,$value=null,$where='#',$type='generic') {
		
		/* add it to the to be processed array - the key should (basically) keep from adding the same thing twice */
		$hash = @md5($key.$value.$where.$type);
		
		if (!isset($this->added[$hash])) {
			data(getDefault($this->config['variable_mappings'][$key],$key),$value,$where);
			$this->added[$hash] = true;
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

	private function _show($name,$bol) {
		if ($name == null) {
			return $this->show;	
		}
		$this->show[preg_replace('/\.[^.]*$/', '', $name)] = $bol; 
	
		return $this;	
	}

	/* generic wrapper for CI instance so you can $this-> in this file */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end class */