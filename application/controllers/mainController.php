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
		
		$ifconfig = file('/var/www/ifconfig.txt');
		$ifconfig = between('inet addr:','  Bcast:',$ifconfig[1]);
		
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
	
		$uptime = str_replace(' day','d',$uptime);
		$uptime = str_replace(' hours','h',$uptime);
		$uptime = str_replace(' minutes','m',$uptime);
		$uptime = str_replace(' seconds','s',$uptime);
	
		$tweet  = date('dmy H:i ').$ifconfig.' Uptime:'.$uptime.' '.intval((9/5)* $heat['degrees'] + 32).'F '.$cpu['current'];
		$tweet .= ' HD:'.$hdd[0]['total'].'/'.$hdd[0]['free'].'/'.$hdd[0]['used'].' '.$hdd[0]['percentage'].'% RAM:'.$ram['total'].'/'.$ram['free'].'/'.$ram['used'].' '.$ram['percentage'].'%';

		$tweet = substr($tweet,0,140);
		
		echo $tweet.chr(10);
				
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

		echo $tweet.chr(10);
		
		$this->twitter->send($tweet);
	}

	public function weatherAction() {
		$this->load->library('Twitter');

		$url = 'http://weather.yahooapis.com/forecastrss?w=12765655';

		$handle = fopen($url, "rb");
		$xml = stream_get_contents($handle);
		fclose($handle);
			
		$weatherData = simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);

		$tweet = substr(trim(substr(strip_tags($weatherData->channel->item->description),0,-66)),0,140);
		
		echo $tweet.chr(10);
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
