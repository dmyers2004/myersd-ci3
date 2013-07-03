<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
page events triggered are:

pre_page_build - when build method is called
pre_partial/filename - is called when the load global function is called ie. pre_partials/header

Note: All __ (double) replaced with _ (single)

method: config(group)
	Load config Closure group from config file
	#chainable

method: data();
	returns all view variables

method: data(name);
	returns this return variable

method: data(name,value);
	sets this view variable to $value (overwriting)
	#chainable

method: data(name,value,where)
	sets this view variable to $value
	if where is < prepends $value in front of everything already in this variable (only works with strings)
	if where is > appends $value behind everything already in this variable (only works with strings)
	where default is to overwrite
	#chainable

method: func($name,closure)
	sets a variable to a closure function
	#chainable

method: hide(name)
	prevent a view file named name from loading
	ex. hide('_partials/nav');
	#chainable

method: show(name)
	allow a view file named name to load
	ex. show('_partials/nav');
	#chainable

method: shown(name)
	return if a loaded view is show

method: set(name,value)
	set a variable named name with value - overwrite (anything can be "set" to a variable)
	#chainable

method: append($name,value)
	appends a value to a view variable named name (strings only)
	(behind everything in there)
	#chainable

method: prepend
	prepends a value to a view variable named name (strings only)
	(in front of everything in there)
	#chainable

method: css([array|file],[<|>|#|-])
	if an array it is converted into name/value pairs
	if a string it is used as src value and merged with the page defaults
	by default this is appended to the css variable (>)
	other options include:
	 prepend (<)
	 overwrite (#)
	 remove (-)
	 append (>)
	#chainable

method: js([array|file],[<|>|#|-])
	if a array it is converted into name/value pairs
	if a string it is used as href value and merged with the page defaults
	by default this is appended to the js variable (>)
	other options include:
	 prepend (<)
	 overwrite (#)
	 remove (-)
	 append (>)
	#chainable

method: meta([array|name],[content|where],where)
	if a array it is converted into name/value pairs
	if name & content are strings they are converted to name and content
	by default this is appended to the meta variable (>)
	other options include:
	 prepend (<)
	 overwrite (#)
	 remove (-)
	 append (>)
	#chainable

method: theme(name) !todo overloaded now
	adds a new CodeIgniter Package which can be used as a "theme"
	this package is in the format apppath/themes/#name#/view/#new view file(s)#
	if name not included the current theme will be returned
	#chainable unless name not included

@@@method: remove_theme(name)
	remove the current method from the CodeIgniter packages
	#chainable

method: template(name)
	change the template to name
	if name not included the current theme will be returned
	#chainable unless name not included

@@@method: partial(view,data,variable)
	load a view file using the data array (if included)
	if variable is set the view file will be automatically loaded into the variable
	if not it will be returned
	#chainable unless variable is not used

method: view(view,data,return)

method: build(view,layout)
	build and output the final page
	if view is false the auto "content" loader won't be run
	if view is a view file ex. /admin/view/index it will be used for the "content"
	if layout is included it will be used for the final template
	if layout is not included the one in the view variable will be used


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

/*
Global view "include" function
by calling this function instead of php include/require
a trigger will be thrown
in addition includes will not be loaded based show/hide values
*/
function load($file)
{
	$ci = get_instance();
	$show = $ci->page->show();
	$file = preg_replace('/\.[^.]*$/', '', $file); /* strip extension if included */
	if ($show[$file] !== FALSE) {
		/* trigger pre/[view file] event */
		events::trigger(str_replace('__','_','pre_'.$file),null,'array');
		/* load the file */
		$ci->load->view($file,array(),false);
	}
}

class Page
{
  private $config = NULL; /* all configs local cache */
	private $template = '_templates/default'; /* template to use in build method */
	private $theme = ''; /* theme folder for views (added as a package) */
	private $show = array();

  public function __construct()
  {
    $this->config = $this->load->settings('page');

		/* load in our defaults if any */
		$this->config('default');

		/* load any database settings into the views */
		foreach ($this->settings->get_settings_by_group('page') as $name => $value) {
			$this->data($name,$value,'#');
		}
  }

	/* load a config file config grouping (Closure Function) */
	public function config($key)
	{
		$this->config[$key]($this);

		return $this;
	}

  /* setter and getter for template */
  public function template($name=null)
  {
		/* nothing sent in so return the current template */
		if ($name === null) {
			return $this->template;
		}

    $this->template = $name;
    return $this;
  }

	/* getter and setter for theme folder (CI package) */
  public function theme($name=null,$remove=false)
  {
		/* if remove */
		if ($remove) {

			$this->theme = null;
  		$this->load->remove_package_path(APPPATH.'themes/'.$name.'/');

		} else {

			/* nothing sent in so return the current theme */
			if ($name === null) {
				return $this->theme;
			}

	  	$this->theme = $name;
			$this->load->add_package_path(APPPATH.'themes/'.$name.'/', TRUE);
		}

  	return $this;
  }

	/* getter and setter for variable mappings */
	public function map($name=null,$value=null) {
		if ($name === null) {
			return $this->config['variable_mappings'];
		}

		if ($value === null) {
			return $this->config['variable_mappings'][$name];
		}

		$this->config['variable_mappings'][$name] = $value;

		return $this;
	}

	/* hide/show/is shown wrappers for _show */
	public function hide($name=null) {
		return $this->_show($name,false);
	}

	public function show($name=null) {
		return $this->_show($name,true);
	}

	public function shown($name) {
		return $this->_show($name);
	}

	/* overwrites */
	public function set($key,$value) {
		return $this->data($key,$value);
	}

	/* appends (strings only) */
	public function append($key,$value) {
		return $this->data($key,$value,'>');
	}

	/* prepends (strings only) */
	public function prepend($key,$value) {
		return $this->data($key,$value,'<');
	}

	/* overwrites - really the same as set but looks more like for "functions" */
	public function func($key,$value) {
		return $this->data($key,$value);
	}

	/* This is majorly overloaded it is both a getting and setting */
	public function data($name=null,$value='$uNdEfInEd$',$where='#')
	{
		/* handle overloading */
		if ($name === null) {
			return $this->load->_ci_cached_vars;
		}

		if ($value === 'undefined') {
			return $this->load->_ci_cached_vars[$name];
		}

		/* nothing of value even sent in? bail now */
		if ($value !== '') {
			/* ok they must want to set something */
			$name = ($this->config['variable_mappings'][$name]) ? $this->config['variable_mappings'][$name] : $name;
	
			/* overwrite (#) is default */
			switch ($where) {
				case '<': // Prepend
					$current = $this->load->_ci_cached_vars[$name];
	
					if (strpos($current, $value) !== false) {
						$value = $current;
					} else {
						$value = $value.$current;
					}
				break;
				case '>': // Append
					$current = $this->load->_ci_cached_vars[$name];
	
					if (strpos($current, $value) !== false) {
						$value = $current;
					} else {
						$value = $current.$value;
					}
				break;
				case '-': // Remove
					$value = str_replace($value,'',$this->load->_ci_cached_vars[$name]);
				break;
			}
	
			$this->load->_ci_cached_vars[$name] = $value;
		}

		return $this;
	}

  /* add a css file */
  public function css($file='',$where='>')
  {
    $merged = array_merge($this->config['default_css'],((is_string($file)) ? array('href'=>$file) : $file));
		return $this->_tag($merged,'<link',' />','css',$where);
  }

  /* add js file */
  public function js($file='',$where='>')
  {
    $merged = array_merge($this->config['default_js'],((is_string($file)) ? array('src'=>$file) : $file));
		return $this->_tag($merged,'<script','></script>','js',$where);
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

		return $this->_tag($arg1,'<meta','>','meta',$where);
	}

	/* this will load partials, views and is chainable (if return = false) */
	public function view($view=null,$data=array(),$return=false)
	{
		$view = ($view) ? $view : $this->data('route');

		if (is_string($return)) {
			$this->load->partial($view,$data,$return);
		} else {
			$html = $this->load->view($view,$data,$return);
		}

		if ($return === true) {
			return $html;
		}

		return $this;
	}

	/* final output */
  public function build($view=null,$layout=null)
  {

		/* anyone need to process something before build? */
		events::trigger('pre_page_build',null,'string');

		/* if they sent in a file path or nothing (ie null) then load the view file into the template "center" (mapped) */
		if ($view !== false) {
			$this->load->partial((($view) ? $view : $this->data('route')),array(),$this->config['variable_mappings']['center']);
  	}

    /* final output */
    $this->load->view((($layout) ? $layout : $this->template),array(),false);

		/* allow chaining -- of course I'm not sure where your going after final output?? */
		return $this;
	}

	/* !private functions */

  private function _tag($merged,$pre,$post,$tag,$where) {
		$attr = '';

    foreach ($merged as $name => $value) {
      $attr .= $name.'="'.$value.'" ';
    }

		$html = $pre.' '.trim($attr).$post;

		if (is_string($html)) {
			$html = str_replace('{theme}',$this->theme,$html);
		}

		if ($where === true) {
			return $html;
		}

    return $this->data($tag,$html,$where);
  }

	private function _show($name,$bol=null) {
		if ($name === null) {
			return $this->show;
		}

		$key = preg_replace('/\.[^.]*$/', '', $name);

		if ($bol === null) {
			return $this->show[$key];
		}

		$this->show[$key] = $bol;

		return $this;
	}

	/* generic wrapper for CI instance so you can $this-> in this file */
	public function __get($var)
	{
		return get_instance()->$var;
	}

} /* end class */