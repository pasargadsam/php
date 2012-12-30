<?php

class mysqldb
{
	function __construct(){
		/*$configs = array(
			"dbHost" => "127.0.0.1",
			"dbUser" => "root",
			"dbPass" => "password",
			"dbName" => "moneycalc"
		);
		$this->config($configs);*/
		//
	}
	public function config($configs = array()){
		$keys = array('dbHost', 'dbUser', 'dbPass', 'dbName');
		if(is_array($configs)){
			foreach($configs as $configKey => $configValue){
				if(in_array($configKey, $keys)){
					$this->configs = $configs;
				}
			}
		}
	}
	public function connect(){
		if(@$this->configs){
			$this->connection = mysql_connect(
				$this->configs['dbHost'],
				$this->configs['dbUser'],
				$this->configs['dbPass']
			);
			if($this->connection){
				mysql_select_db($this->configs['dbName']);
				return "connected";
			}
		} else {
			die("Error in Site configuration");
		}
	}
	public function disconnect(){
		if(@$this->configs){
			if($this->connection){
				mysql_close($this->connection);
				return "disconnected";
			}
		} else {
			die("Error in Site configuration");
		}
	}
	public function insert($data = array()){
		if(is_array($data)){
			$tbl = (@$data['tbl'])?$data['tbl']:0;
			if($tbl){
				$query = "INSERT INTO " . $data['tbl'] . " (";
				foreach($data as $col => $value){
					if($col != 'tbl'){
						if(strlen(trim($value)) > 0)
							$query .= $col . ", ";
					}
				}
				$query .= "timestamp) VALUES(";
				foreach($data as $col => $value){
					if($col != 'tbl'){
						if(strlen(trim($value)) > 0)
							$query .= "'" . mysql_real_escape_string($value) . "', ";
					}
				}
				$query .= "'" . time() . "')";
				mysql_query("SET NAMES UTF8");
				$run = mysql_query($query);
				$result = ($run)?(mysql_insert_id()):0;
				return $result;
			}
		}else {
			die("Error in Data configuration");
		}
	}
	public function select($data = array()){
		$keys = array('tbl, req', 'order', 'where');
		if(is_array($data)){
			$access = 0;
			foreach($data as $key => $val){
				$access = (in_array($key, $keys))?1:0;
			}
			$tbl = (@$data['tbl'])?$data['tbl']:0;
			$req = (@$data['req'] && is_array($data['req']))?$data['req']:0;
			if($access && $tbl && $req){
				$query = "SELECT ";
				for($i=0; $i<count($data['req']); $i++){
					$query .= $data['req'][$i];
					if($i != count($data['req']) - 1)
						$query .= ", ";
				}
				$query .= " FROM " . $tbl;
				if(@$data['where'] && is_array($data['where']) && count($data['where']) > 0){
					$query .= " WHERE ";
					foreach($data['where'] as $key => $val){
						$query .= $key . "='" . $val . "'";
					}
				}
				if(@$data['order'] && trim($data['order']) != ''){
					$query .= " ORDER BY " . $data['order'] . " ";
				}
				mysql_query("SET NAMES UTF8");
				$run = mysql_query($query);
				$result = array();
				if($run && mysql_num_rows($run) > 0){
					while($fetch = mysql_fetch_assoc($run)){
						$result[] = $fetch;
					}
				}
				return $result;
			}
		}else {
			die("Error in Data configuration");
		}
	}
	public function run($query){
		mysql_query("SET NAMES UTF8");
		$run = mysql_query($query);
		$result = ($run)?$run:0;
		return $result;
	}
}

/*$moneycalc = new moneycalc();

$moneycalc->dbConnect();

$receipt = array(
	"tbl" => "receipt",
	"exp" => "sandwich",
	"val" => "8500",
	"cmt" => "",
	// "dt" => $calendar->mktime(null, null, null, 10, 07, 1391),
	"dt" => ""
);

$settle = array(
	"tbl" => "settle",
	"exp" => "دریافتی تیماتک",
	"val" => "420000",
	"cmt" => "",
	// "dt" => $calendar->mktime(null, null, null, 10, 07, 1391),
	"dt" => ""
);

// $moneycalc->insert($receipt);

function exportHTML($select){
	if(count($select) > 0){
		$total = 0;
		$showHTML = "<table border='1px'>";
		for($i=0; $i<count($select); $i++){
			if($i == 0){
				$showHTML .= "<tr style='font-weight:bold'>";
				$showHTML .= "<td>no</td>";
				foreach($select[$i] as $col => $val){
					$showHTML .= "<td>" . $col . "</td>";
				}
				$showHTML .= "</tr>";
			}
			$showHTML .= "<tr>";
			$showHTML .= "<td>" . ($i + 1) . "</td>";
			foreach($select[$i] as $col => $val){
				$showHTML .= "<td>" . $val . "</td>";
				if($col == 'val'){
					$total += $val;
				}
			}
			$showHTML .= "</tr>";
			if($i == count($select) - 1){
				$showHTML .= "<tr>";
				$showHTML .= "<td colspan='2'>Total</td>";
				$showHTML .= "<td colspan='2'>" . $total . "</td>";
				$showHTML .= "</tr>";
			}
		}
		$showHTML .= "</table>";
		return $showHTML;
	}
}

$selectReceipt = array(
	"tbl" => "receipt",
	"req" => array('exp', 'val', 'dt'),
	// "find" => array(),
	"order" => "dt asc"
	// "limit" => ""
);
$selectSettle = array(
	"tbl" => "settle",
	"req" => array('exp', 'val', 'dt'),
	// "find" => array(),
	"order" => "dt asc"
	// "limit" => ""
);

$select = $moneycalc->select($selectSettle);
$select = exportHTML($select);
echo $select . "<hr />";

$select = $moneycalc->select($selectReceipt);
$select = exportHTML($select);
echo $select;



$moneycalc->dbDisconnect();*/

?>