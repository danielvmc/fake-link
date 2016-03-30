<?php 
	require('core/options.php');
	if($fuck = Database::select_one('select * from tf_link where code="'.$_REQUEST['code'].'"'))
	{
		if($fuck['link_full'])
		{
			$link_full = $fuck['link_full'];
		}
		else
		{
			$fuck1 = Database::select_one('select url from tf_url_random order by rand()');
			$link_full = $fuck1['url'];
		}
		if(COUNT_VIEWS)
		{
			$session = 'hitcount';
			if(isset($_SESSION['hitcount']))
			{
				$items = array_flip(explode(',',$_SESSION['hitcount']));
			}
			else
			{
				$items = array();	
			}
			$id = $fuck['id'];
			if(!isset($items[$id]))
			{
				Database::query('update tf_link set hitcount = hitcount+1 where id='.$id);
				$items[$id] = $id;
				$_SESSION['hitcount'] = implode(',',array_keys($items));
			}	
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:url" content="<?php echo $fuck['link_fake'];?>"/>
<script>window.location="<?php echo $link_full;?>";</script>
<title>Loading...</title>
</head>
<body>
Loading...
</body>
</html>
<?php
	}
?>
