<?php
	Class Database
	{
		static $conn_id = false;
		static function connect($server,$user,$pass,$data)
		{
			if($conn = mysql_connect($server,$user,$pass,true))
			{
				if($conn_id = mysql_select_db($data,$conn))
				{
					//connect success
				}
				else
				{
					System::logout();
					System::run_page('not_connect_database');
				}
			}
			else
			{
				System::logout();
				System::run_page('not_connect_server');
			}
		}
		static function query($sql)
		{
			return mysql_query($sql);
		}
		static function select($sql)
		{
			$items = mysql_query($sql);
			$rows = array();
			$i = 0;
			while($row = @mysql_fetch_assoc($items))
			{
				$rows[$i] = $row;
				$i++;
			}
			return $rows;
		}
		static function select_one($sql)
		{
			$result = Database::select($sql);
			return $result[0];
		}
		static function random_string($len=8)
		{
			$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
			$max=strlen($base)-1;
			$activatecode='';
			mt_srand((double)microtime()*1000000);
			while (strlen($activatecode)<$len+1)
			  $activatecode.=$base{mt_rand(0,$max)};	  
			return $activatecode;
		}
	}
	$db = new Database;
	Database::connect(DATA_SERVER,DATA_USER,DATA_PASS,DATA_NAME);
?>