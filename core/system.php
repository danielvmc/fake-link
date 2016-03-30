<?php
class System
{
	static function run_page($page)
	{
		if($page)
		{
			if(file_exists('views/'.$page.'.php'))
			{
				$_REQUEST['page'] = $page;
				$file = 'views/'.$page.'.php';
			}
			else
			{
				$_REQUEST['page'] = '404';
				$file = 'views/404.php';
			}
		}
		require_once 'views/header.php';
		require_once $file;
		require_once 'views/footer.php';
		exit();
	}
	static function paging($total,$items_per_page,$params,$url)
	{
		$html = '';
		$_REQUEST['page_no'] = $_REQUEST['page_no']?$_REQUEST['page_no']:1;
		$total_page = ceil($total/$items_per_page);
		$uri = '';
		foreach($params as $param)
		{
			$uri .= '&'.$param.'='.$_REQUEST[$param];
		}
		if($total_page>1)
		{
			$html = '<center><nav>';
			$html .= '<ul class="pagination pagination-sm">';
			if($_REQUEST['page_no']>1)
			{
				$html .= '<li><a href="'.$url.'.html?page_no='.($_REQUEST['page_no']-1).$uri.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			else
			{
				$html .= '<li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			for($i=1;$i<=$total_page;$i++){
				if($_REQUEST['page_no']==$i)
				{
					$html .= '<li class="disabled"><a>'.$i.'</a></li>';
				}
				else
				{
					$html .= '<li><a href="'.$url.'.html?page_no='.$i.$uri.'">'.$i.'</a></li>';
				}
			}
			if($_REQUEST['page_no']<$total_page)
			{
				$html .= '<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			else
			{
				$html .= '<li class="disabled"><a aria-label="Next"><span aria-hidden="true">&raquo</span></a></li>';
			}
			$html .= '</ul>';
			$html .= '</nav></center>';
		}
		return $html;
	}
	static function logout()
	{
		unset($_SESSION['account']);
		unset($_SESSION['full_name']);
		unset($_SESSION['time_login']);
	}
	static function debug($array)
	{
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
	static function redirect($url)
	{
		echo '<script>location="'.$url.'";</script>';
	}
}
?>