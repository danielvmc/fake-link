<?php
	session_start();
	
	error_reporting(0);
	
	define('DATA_SERVER','localhost'); //database server
	
	define('DATA_USER','root'); //database user
	
	define('DATA_PASS',''); //database password
	
	define('DATA_NAME','fake'); //database name
	
	require_once 'system.php';
	require_once 'database.php';
	
	$options = Database::select('select * from tf_options');
	foreach($options as $key=>$value)
	{
		define($value['id'],$value['value']);
	}
	if((time()-$_SESSION['time_login'])>(60*60)) //set time exists session
	{
		System::logout();
	}

?>