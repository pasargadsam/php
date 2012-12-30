<?php
include('./simple_html_dom.php');
require('cls.php');

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
			$url = @($this->host)?($this->host . $this->path):0;
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
			$href = strtolower(trim($aTag->href));
			$href = trim(substr($href, 1));
			$regex = "(<([\w]+)[^>]*>)(.*?)(<\/\\2>)";
			$title = preg_replace('/' . $regex . '/', "", $title);
			if($title != '' && $href != '')
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

$mysqldb = new mysqldb;
$mysqldb->config(array(
	"dbHost" => "127.0.0.1",
	"dbUser" => "root",
	"dbPass" => "password",
	"dbName" => "avval.ir"
));
$mysqldb->connect();
foreach($links as $key => $val){
	$dataToInsert = array(
		"tbl" => "directories",
		"title" => $key,
		"path" => $val,
		"rel" => 0
	);
	if($id = $mysqldb->insert($dataToInsert)){
		getNew($id, $key, $val, $test, $mysqldb);
	}
}
function getNew($id, $key, $val, $parser, $mysqldb){
	$configs = array(
		'host' => 'http://www.avval.ir/',
		'path' => $val
	);
	$newResults = array();
	$links = $parser->config($configs);
	foreach($links as $key => $val){
		$dataToInsert = array(
			"tbl" => "directories",
			"title" => $key,
			"path" => $val,
			"rel" => $id
		);
		if($newid = $mysqldb->insert($dataToInsert)){
			$newResults[$newid] = $val;
		}
	}
	$newResults2 = array();
	if(count($newResults) > 0){
		foreach ($newResults as $arrKey => $arrVal) {
			preg_match_all('/\\/a\\./', $arrVal, $checkArrVal);
			$stop = count($checkArrVal[0]);
				if(!$stop){
				$links2 = $parser->config(array(
					'host' => 'http://www.avval.ir/',
					'path' => $arrVal
				));
				foreach($links2 as $key2 => $val2){
					$dataToInsert1 = array(
						"tbl" => "directories",
						"title" => $key2,
						"path" => $val2,
						"rel" => $arrKey
					);
					if($newid2 = $mysqldb->insert($dataToInsert1)){
						$newResults[$newid2] = $val2;
					}
				}
			}
		}
	}
	$newResults3 = array();
	if(count($newResults2) > 0){
		foreach ($newResults2 as $arrKey2 => $arrVal2) {
			preg_match_all('/\\/a\\./', $arrVal2, $checkArrVal2);
			$stop = count($checkArrVal2[0]);
				if(!$stop){
				$links3 = $parser->config(array(
					'host' => 'http://www.avval.ir/',
					'path' => $arrVal2
				));
				foreach($links3 as $key3 => $val3){
					$dataToInsert2 = array(
						"tbl" => "directories",
						"title" => $key3,
						"path" => $val3,
						"rel" => $arrKey2
					);
					if($newid3 = $mysqldb->insert($dataToInsert1)){
						$newResults3[$newid3] = $val3;
					}
				}
			}
		}
	}
}
$mysqldb->disconnect();
echo "Parsed!";
?>