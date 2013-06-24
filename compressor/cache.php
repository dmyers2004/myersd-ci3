<?php 

class cache {
	public $time;
	public $path;

	public function __construct($path,$time) {
		$this->path = $path;
		$this->time = $time;
	}

	public function get($key) {
    $key = $this->path.md5($key);

    if (!file_exists($key) || (filemtime($key) < (time() - $this->time))) {
      return null;
    }

    if (filesize($key) == 0) {
      return null;
    }

    return(unserialize(file_get_contents($key)));
	}

	public function set($key, $data) {
    $file = $this->path.'temp-'.md5(uniqid(md5(rand()), true));
    
    file_put_contents($file,serialize($data));
    
    rename($file,$this->path.md5($key));
	}

}
