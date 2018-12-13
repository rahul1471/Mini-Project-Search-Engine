<?php
include("config.php");

$agent=$_SERVER['HTTP_USER_AGENT'];
$ip=$_SERVER['REMOTE_ADDR'];



function insert($agent, $ip) {
	global $con;

	$query = $con->prepare("INSERT INTO user(agent,ip)
							VALUES(:agent, :ip)");

	$query->bindParam(":agent", $agent);
	$query->bindParam(":ip", $ip);
	


	return $query->execute();

}




?>	
