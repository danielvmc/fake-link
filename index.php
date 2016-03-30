<?php
	date_default_timezone_set('Asia/Saigon');
	define( 'ROOT_PATH', strtr(dirname( __FILE__ ) ."/",array('\\'=>'/')));
	require_once ROOT_PATH.'core/options.php';
	if(!isset($_REQUEST['page']))
	{
		if(!$_SESSION['account'])
		{
			$_REQUEST['page'] = 'login';
		}
		else
		{
			$_REQUEST['page'] = 'about';
		}
	}
	else
	{
		if(!$_SESSION['account'])
		{
			$_REQUEST['page'] = 'login';
		}
	}
	System::run_page($_REQUEST['page']);
?>