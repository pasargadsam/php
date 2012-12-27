<?php
include('./simple_html_dom.php');

class parser
{
	function __construct(){
		//
	}
	public function config($configs){
		$keys = array('host', 'path');
		if(is_array($configs)){
			foreach($configs as $key => $config){
				if(in_array($key, $keys)){
					$parserConfigs = $configs;
				}
			}
		}
		if(@$parserConfigs){
			$this->host = @($parserConfigs['host'])?($parserConfigs['host']):0;
			$this->path = @($parserConfigs['path'])?($parserConfigs['path']):0;
			$url = @($this->host && $this->path)?($this->host . $this->path):0;
			print_r($this->storeLinks($this->getHTML($url)));
		} else {
			die("Error: non-authenticade array keys");
		}
	}
	private function getHTML($url){
		$html = file_get_html($url);
		return $html;
	}
	private function getLinks($html){
		$aSrc = array();
		foreach($html->find('#content a') as $aTag1){
			$href1 = trim(substr($aTag1->href, 1));
			$herf1 = (($href1 != '')?$href1:0);
			if($href1){
				$aSrc[] = $this->host . $href1;
			}
		}
		return $aSrc;
	}
	private function storeLinks($html){
		$floor1 = $this->getLinks($html);
		$floor2 = array();
		for($f1=0; $f1<count($floor1); $f1++){
			$floor2 = $this->getLinks($this->getHTML($floor1[$f1]));
		}
		return $floor1;
	}
}

$configs = array(
	'host' => 'http://www.avval.ir/',
	'path' => 'Directory'
);

$test = new parser();
$test->config($configs);

?>