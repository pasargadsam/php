<?php
	
class parser
{
	function __construct(){
		/*
			PHP PARSER
			Author: Aref Mirhoseini
			Created: Tue 25 Dec 2012
			Modified: Tue 25 Dec 2012
		*/
	}
	public function parse($url){
		$dom = new DOMDocument();
		@$dom->loadHTMLFile($url);
		$nodes = $dom->getElementsByTagName('*');
		$result = array();
		$denied = array('head', 'title', 'meta', 'style', 'script', 'link', 'body');
		foreach($nodes as $node){
			$childs = $node->childNodes;
			foreach($childs as $child){
				if($child->nodeType == 1){
					if(!in_array($child->nodeName, $denied)){
						$obj = $child->childNodes;
						foreach($obj as $tbl){
							if($tbl->nodeType == 1)
								$result[] = json_encode(array(
									'name' => $tbl->nodeName
									// 'value' => $child->nodeValue,
									// 'childs' => count($tbl->childNodes)
								));
						}
					}
						/*$result[] = json_encode(array(
							'name' => $child->nodeName,
							'value' => $child->nodeValue,
							'childs' => count($child->childNodes)
						));*/
				}
			}
		}
		return $result;
	}
}

$parser = new parser();
$setUrl = $parser->parse('http://95.38.61.77');
print_r($setUrl);

/*
Array ( 
	[0] => {"name":"head","value":"To Parse","childs":1} 
	[1] => {"name":"body","value":"\n\t\tHello World\n\t\tI want to parse this page with php\n\t","childs":1} 
	[2] => {"name":"meta","value":"","childs":1} 
	[3] => {"name":"title","value":"To Parse","childs":1} 
	[4] => {"name":"h1","value":"Hello World","childs":1} 
	[5] => {"name":"p","value":"I want to parse this page with php","childs":1} )
*/

?>