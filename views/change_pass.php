<?php
	include_once('views/nav.php');
	if(isset($_REQUEST['submit']) and $_REQUEST['submit']=='Change')
	{
		extract($_REQUEST);
		if($account = Database::select_one('select * from tf_account where account_id = "'.$_SESSION['account'].'" and password = "'.md5($password).'"'))
		{
			if($password_1)
			{
				Database::query('update tf_account set password = "'.md5($password_1).'" where id='.$account['id']);
				echo '<script>alert("Đổi mật khẩu thành công");location="change_pass.html";</script>';
			}
		}
		else
		{
			echo '<script>alert("Mật khẩu cũ không đúng");location="change_pass.html";</script>';
		}
	}
?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-sm-6 col-sm-offset-3">
        	<form name="ChangePass" method="post" id="ChangePass">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu hiện tại" required="required">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_1" class="form-control" id="password_1" placeholder="Mật khẩu mới">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-success" id="submit" value="Change">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>