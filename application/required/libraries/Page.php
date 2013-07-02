<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
page events triggered are:

pre_page_build - when build method is called
pre_partial/filename - is called when the load global function is called ie. pre_partials/header

Note: All __ (double) replaced with _ (single)

method: config($group)
	Load config Closure group from config file

method: data();
	returns all view variables

method: data($name);
	returns this return variable

method: data($name,$value);
	sets this view variable to $value (overwriting)
	returns $page

method: data($name,$value,$where="#")
	sets this view variable to $value
	$where = < prepends $value in front of everything already in this variable (only works with strings)
	$where = > appends $value behind everything already in this variable (only works with strings)
	returns $page

method: 


To not load a view
$page->hide('_partials/filename');

To allow it again (default to show all)
$page->show('_partials/filename');

You can also:
$page->set('lspan',0);

Requires

Data Library
Settings Library
Events Library

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

	private $show = array();
	private $added = array();

  public function __construct()
  {
    $this->config = $this->load->settings('page');

		/* load in our defaults if any */
		$this->config('default');		

		/* load in the config as variables if it's a string */
		foreach ($this->config as $name => $value) {
			if (is_string($value)) {
				$this->set($name,$value);
			}
		}
  }
	
	/* overloaded! get and set */
	public function data($name=null,$value=null,$where='#')
	{
		$ci = get_instance();

		if ($value === null) {
			if ($name == null) {
				return $this->load->_ci_cached_vars;
			}
			
			return $this->load->_ci_cached_vars[$name];
		}
	
		/* overwrite (#) is default */
		switch ($where) {
			case '<': // Prepend
				$value = $value.$this->load->_ci_cached_vars[$name];
			break;
			case '>': // Append
				$value = $this->load->_ci_cached_vars[$name].$value;
			break;
			case '-': // Remove
				$value = str_replace($value,'',$this->load->_ci_cached_vars[$name]);
			break;
		}
	
		$this->load->_ci_cached_vars[$name] = $value;
		
		return $this;
	}

	public function config($key) {
		$this->config[$key]($this);
		
		return $this;
	}

	public function mapped($name) {
		return $this->config['variable_mappings'][$name];
	}

	public function hide($name=null) {
		return $this->_show($name,false);
	}

	public function show($name=null) {
		return $this->_show($name,true);
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
  public function css($file='',$where='>')
  {
		$file = (is_string($file)) ? array('href'=>$file) : $file;
    $merged = array_merge($this->config['default_css'],$file);
		return $this->tag($merged,'<link',' />','css',$where);
  }  
  
  /* add js file */
  public function js($file='',$where='>')
  {
		$file = (is_string($file)) ? array('src'=>$file) : $file;
    $merged = array_merge($this->config['default_js'],$file);
		return $this->tag($merged,'<script','></script>','js',$where);
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
		
		return $this->tag($arg1,'<meta','>','meta',$where);
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
		$view = ($view) ? $view : $this->data('route');
				
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
			$this->load->partial((($view) ? $view : $this->data('route')),array(),$this->config['variable_mappings']['center']);
  	}

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),array(),false);

		/* allow chaining -- of course I'm not sure where your going after final output?? */
		return $this;
	}

	/* private functions */

  private function tag($merged,$pre,$post,$tag,$where) {
		$html = $pre.' '.$this->_ary2attr($merged).$post;

		if ($where === true) {
			return $html;
		}
    
    return $this->add($tag,$html,$where,$tag);
  }

	private function add($key,$value=null,$where='#',$type='generic') {
		
		/* add it to the to be processed array - the key should (basically) keep from adding the same thing twice */
		$hash = @md5($key.$value.$where.$type);
		
		if (!isset($this->added[$hash])) {
			$key = ($this->config['variable_mappings'][$key]) ? $this->config['variable_mappings'][$key] : $key;
			$this->data($key,$value,$where);
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