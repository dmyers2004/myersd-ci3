<?php
class mainController extends CI_Controller {

	public function indexAction($a=null,$b=null,$c=null) {
		echo 'modules users controllers welcome index';
		
		echo __DIR__;

		echo '<pre>';
		
		echo 'A: '.$a.'<br>';
		echo 'B: '.$b.'<br>';
		echo 'C: '.$c.'<br>';
		
		//print_r($this);
	}
	
	public function cookiesAction($a=null,$b=null,$c=null) {
		echo 'modules users controllers welcome index';
		
		echo __DIR__;

		echo '<pre>';
		
		echo 'A: '.$a.'<br>';
		echo 'B: '.$b.'<br>';
		echo 'C: '.$c.'<br>';
		
		//print_r($this);
	}

}