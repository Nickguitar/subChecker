<?php
$timeout = 1; // timeout em segundos;  aumenta se tua net for lixo
 
 
ini_set('default_socket_timeout', $timeout);
 
if(PHP_SAPI != "cli"){
	die("Run me on commandline plz.");
}
 
if($argc < 2){
	die("\e[92m
  Usage: php subCheck.php <list.txt> [-v]
  <list.txt> = List of domains to be checked (one per line)
  -v = Log only valid domains (optional)
  
  Ex:
  fulano:~$ php subCheck.php sites.txt -v > list.txt
  
\e[93mCoded by Nicholas Ferreira\033[0m
\033[0m
 
");
}else{
 
	if(isset($argv[2]) and $argv[2] == "-v"){
		$v = true;
	}else{
		$v = false;
	}
 
	$fp = fopen($argv[1], "r");
	$read = fread($fp, filesize($argv[1]));
	$list = explode(PHP_EOL, $read);
	fclose($fp);
 
	echo "Testing " . count($list) . " URLs\r\n";
 
	foreach($list as $site){
		if(!preg_match("/[0-9]/", explode(".", $site)[0])){ //remove subdominios lixo com ip
			joao_testa("http://".$site);
		}
	}
}
 
function joao_testa($url){
	GLOBAL $v;
	$header = @get_headers($url); //fulaniza sem printar erro
	if($header){ 
		echo "[+]".$url." - [".$header[0]."]\r\n";
		//print_r ($header);
	}else{
		if(!$v){
			echo "[-]".$url."\r\n";
		}
	}
}
 
?>
