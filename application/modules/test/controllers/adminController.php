<?php
class adminController extends CI_Controller {

	public function indexAction($a=null,$b=null,$c=null) {
		echo 'modules users controllers admin index';

		echo '<pre>';
		
		echo 'A: '.$a.'<br>';
		echo 'B: '.$b.'<br>';
		echo 'C: '.$c.'<br>';
		
		//print_r($this);
	}

}