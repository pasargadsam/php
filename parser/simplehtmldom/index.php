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
			$this->path = @($parserConfigs['path'])?(strtolower($parserConfigs['path'])):0;
			$url = @($this->host)?($this->host):0;
			return ($this->storeLinks($this->getHTML($url)));
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
		foreach($html->find('#content a') as $aTag){
			$title = trim($aTag->innertext);
			$title = (strlen($title) > 0)?$title:0;
			$href = strtolower(trim($aTag->href));
			preg_match_all('/' . $this->path . '/', $href, $checkHref);
			if(in_array($this->path, $checkHref[0]) && $title != '')
				$aSrc[$title] = $href;
		}
		return $aSrc;
	}
	private function storeLinks($html){
		$floor1 = $this->getLinks($html);
		return $floor1;
	}
}

$configs = array(
	'host' => 'http://www.avval.ir/',
	'path' => 'directory'
);

$test = new parser();
$links = $test->config($configs);
$i = 1;
$g1 = array();
foreach($links as $key => $val){
	echo $i . ": " . $key . " = " . $val . "<br />";
	$g2 = $test->config(array(
		"host" => $configs['host'] . $val,
		"path" => $configs['path']
	));
	$z = 1;
	foreach ($g2 as $g2Key => $g2Val) {
		$g1[][$]
		$z++;
	}
	$i++;
}

?>