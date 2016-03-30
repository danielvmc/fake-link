<?php
	unset($_SESSION['account']);
	unset($_SESSION['full_name']);
	unset($_SESSION['time_login']);
	echo '<script>window.location="'.DOMAIN.'";</script>';
?>