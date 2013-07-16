<?php

class MY_Output extends CI_Output {

	public function json($data=array())
	{
		$this
			->set_header('Cache-Control: no-cache, must-revalidate')
			->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT')
			->set_content_type('application/json','utf=8')
			->set_output(json_encode($data));
	}

}