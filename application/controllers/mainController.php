<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mainController extends MY_PublicController
{
	public function indexAction()
	{
		$this->page->build();
	}

	public function twitterAction() {
		$this->load->library('Twitter');
		
		$path = __DIR__.'/../libraries/status/';
		
		require($path.'cpu.php');
		require($path.'memory.php');
		require($path.'network.php');
		require($path.'rbpi.php');
		require($path.'storage.php');
		require($path.'uptime.php');
		require($path.'users.php');
		
		$cpu = \lib\CPU::cpu();
		$heat = \lib\CPU::heat();
		$ram = \lib\Memory::ram();
		$swap = \lib\Memory::swap();
		$connections = \lib\Network::connections();
		$ethernet = \lib\Network::ethernet();
		$distribution = \lib\Rbpi::distribution();
		$kernel = \lib\Rbpi::kernel();
		$firmware = \lib\Rbpi::firmware();
		$hostname = \lib\Rbpi::ip();
		$webserver = \lib\Rbpi::webServer();
		$hdd = \lib\Storage::hdd();
		$uptime = \lib\uptime::uptime();
		$connected = \lib\users::connected();
	
		$tweet = date('Y-m-d H:i ').$uptime.' '.$distribution.' '.$connected['ip'].$cpu['current'].' '.intval((9/5)* $heat['degrees'] + 32).'F '.$hostname;
		echo $tweet;
				
		echo '<pre>';
		
		var_dump($cpu);
		var_dump($heat);
		var_dump($ram);
		var_dump($swap);
		var_dump($connections);
		var_dump($ethernet);
		var_dump($distribution);
		var_dump($kernel);
		var_dump($firmware);
		var_dump($hostname);
		var_dump($webServer);
		var_dump($hdd);
		var_dump($uptime);
		var_dump($connected);

		
		
		$this->twitter->send($tweet);
	}

	public function createAdminAction()
	{
		//var_dump($this->auth->create_user('dmyers', 'admin@admin@.com', 'password', false));
	}

	public function viewAction()
	{
		$this->page->build('tank-auth/login_form');
	}

	public function testconfigAction()
	{
		$configs = $this->load->settings('page');
		echo '<pre>';
		print_r($configs);
	}

	public function testAction()
	{
		$data['name'] = ' Don Myers ';
		$data['age'] = ' 23 ';
		$data['id'] = 123;

		$rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|base64_encode',
			),
			array(
				'field' => 'age',
				'label' => 'Age',
				'rules' => 'trim|integer',
			),
			array(
				'field' => 'id',
				'label' => 'Id',
				'rules' => 'integer'
			),
			array(
				'field' => 'empty',
				'label' => 'Empty',
				'rules' => 'alpha',
				'default' => 'e'
			),
			array(
				'field' => 'foo',
				'label' => 'Empty',
				'rules' => 'alpha',
			)
		);

		echo '<pre>';
		echo 'Mapper'.chr(10);

		$output = array();

		//  map($filter,&$output,&$input=null,$xss = true)
		$x = $this->validate->map($rules,$output,$data);

		var_dump($output);

		var_dump($x);

		echo 'filter'.chr(10);

		$data = ' Don Myers ';
		$filter = 'trim|strtolower|base64_encode';

		$isgood = $output = $this->validate->filter($filter,$data);

		var_dump($isgood);
		var_dump($data);
	}

}
