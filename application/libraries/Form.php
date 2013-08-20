<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Form
{
	private $CI;
	private $config;

	public function __construct() {
		$this->CI = get_instance();
		$this->CI->load->library('form_validation');

    $this->config = $this->load->settings('form');
	}

	/* new function */
	public function map($name,&$output,&$input = null)
	{
		$input = ($input) ? $input : $this->post();

		$fields = $this->get_config('map.'.$name);
		if ($fields === false) return false;

		foreach ($fields as $field => $extras) {
			$value = $input[$field];

			/* you can/should do light filtering here - leave the specific stuff for the model */
			run_one($extras['filter'],$value,false);

			$mappedfield = ($extras['mapped']) ? $extras['mapped'] : $field;

			$output[$mappedfield] = $value;
		}

		return $this;
	}

	/* new function */
	public function filter($name,&$value,$dieonfail=true)
	{
		$rule = $this->get_config('filter.'.$name);
		if ($rule === false) return false;

		$pass = $this->run_one($rule,$value,$dieonfail);

		/* return the pass boolean */
		return $pass;
	}

	/* calls validate function on model! */
	public function validate($classmethod,&$output) {
		if (strpos($classmethod,'::') === false) {
			$modelname = $classmethod;
			$method = 'validate';
		} else {
			list($modelname,$method) = explode('::',$classmethod);
		}

		return $this->CI->$modelname->$method($output);
	}

	public function forged() {
		events::trigger('form.forged',null,'array');

		show_error('<strong>Forged Request Detected</strong> If you clicked on a link and arrived here...that is bad.',404);
		die();
	}

	private function run_one($rule,&$input,$dieonfail=true) {
		if (empty($rule)) {
			return true;			
		}

		if (empty($input)) {
			if (preg_match('/ifempty\[(.*?)\]/',$rule, $matches)) {
				$input = $matches[1];
			}
		}

		/* make sure it's reset - incase it's already loaded and used we need it empty */
		$this->CI->form_validation->reset_validation();

		/* setup a bogus array for testing - set_data before set_rule!! */
		$this->CI->form_validation->set_data(array($name=>$input));

		/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
		$this->CI->form_validation->set_rules($name, 'form input filter', $rule);

		/* run the validation and capture output fail (false) */
		$pass = $this->CI->form_validation->run();

		/* recapture the processed variable */
		$input = set_value($name);

		/* log the error if any */
		if ($pass === false) {
			log_message('debug','Form Library: "'.$value.'" Errors:"'.validation_errors().'" Filter"'.$rule.'"');

			if ($dieonfail) {
				$this->forged();
			}
		}

		return $pass;
	}

	private function get_config($name) {
		$config = $this->config[$name];

		if (empty($config)) {
			log_message('debug','Form Library: Config '.$name.' Not Found');
			return false;
		}

		return $config;
	}

} /* end Form */