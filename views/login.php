<?php
	if(isset($_REQUEST['submit']))
	{
		extract($_REQUEST);
		$_REQUEST['error'] = 1;
		if($account = Database::select_one('select * from tf_account where account_id="'.$account.'" and password=md5("'.$password.'")'))
		{
			$_REQUEST['error'] = 0;
			$_SESSION['account'] = $account['account_id'];
			$_SESSION['full_name'] = $account['full_name'];
			$_SESSION['time_login'] = time();
			if(isset($_SERVER['REQUEST_URI']) and $_SERVER['REQUEST_URI']!='/')
			{
				$href = trim($_SERVER['REQUEST_URI'],'/');
			}
			else
			{
				$href ='about.html';
			}
			System::redirect($href);
		}
	}
?>
<div class="container">
	<div class="row">
    	<div class="col-md-4 col-md-offset-4">
        	<div class="form-login">
            	<div class="brand">
                	<a href="" target="_blank"><img src="skins/images/logo.png"></a>
                    <h2>Hệ thống fake link</h2>
                </div>
                <p><center>Đăng nhập tài khoản</center></p>
                <?php
					if($_REQUEST['error'])
					{
						echo '<p class="alert alert-danger">Thông tin đăng nhập không chính xác!</p>';
					}
                ?>
                <form name="form" method="post" class="form-validation">
                    <div class="form-group">
                        <label class="sr-only" for="inputAccount">Tài khoản</label>
                        <input type="text" class="form-control" id="inputAccount" name="account" required="" <?php if($_REQUEST['account']){echo 'value="'.$_REQUEST['account'].'"';}else{echo 'placeholder="Tài khoản"';}?>>        
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputPassword">Mật khẩu</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" required="" <?php if($_REQUEST['password']){echo 'value="'.$_REQUEST['password'].'"';}else{echo 'placeholder="Mật khẩu"';}?>>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</div>