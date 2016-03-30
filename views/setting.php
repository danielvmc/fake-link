<link rel="stylesheet" href="skins/css/chosen.min.css">
<script src="skins/js/chosen.jquery.min.js"></script>
<?php
	include_once('views/nav.php');
	if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false)
	{
		if(isset($_REQUEST['submit']) and $_REQUEST['submit']=='submit')
		{		
			$user_admin = '';
			$user_insert = '';
			if($_REQUEST['USER_ADMIN'])
			{	
				foreach($_REQUEST['USER_ADMIN'] as $k=>$v)
				{
					$user_admin .= $v.',';
				}
			}
			if($_REQUEST['USER_INSERT'])
			{
				foreach($_REQUEST['USER_INSERT'] as $k_=>$v_)
				{
					$user_insert .= $v_.',';
				}
			}
			$sql = 'UPDATE tf_options
					SET value = (case when id = "DOMAIN" then "'.($_REQUEST['DOMAIN']?$_REQUEST['DOMAIN']:'http://sfake.link/').'"
									when id = "COUNT_VIEWS" then "'.($_REQUEST['COUNT_VIEWS']?1:0).'"
									when id = "ITEMS_PER_PAGE" then "'.($_REQUEST['ITEMS_PER_PAGE']?$_REQUEST['ITEMS_PER_PAGE']:20).'"
									when id = "USER_ADMIN" then "'.($user_admin?','.$user_admin:',admin,').'"
									when id = "USER_INSERT" then "'.($user_insert?','.$user_insert:',admin,').'"
					end)';
			Database::query($sql);
			System::redirect('setting.html');
		}
		$options = Database::select('select * from tf_options');
		$account = Database::select('select * from tf_account');
		foreach($options as $key=>$value)
		{
			if(!$_REQUEST[$value['id']])
			{
				$_REQUEST[$value['id']] = $value['value'];
			}
		}
?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-7">
        	<div class="panel panel-default">
            	<div class="panel-heading">Thông tin cấu hình</div>
                <div class="panel-body">
                	<form name="Setting" method="post" id="Setting" class="form-horizontal">
                        <div class="form-group">
                            <label for="DOMAIN" class="col-sm-4 control-label">Tên miền</label>
                            <div class="col-sm-8">
                            	<input type="url" name="DOMAIN" id="DOMAIN" class="form-control" <?php echo 'value="'.$_REQUEST['DOMAIN'].'"';?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tài khoản admin</label>
                            <div class="col-sm-8">
                            	<select name="USER_ADMIN[]" data-placeholder="Chọn tài khoản" class="chosen-select" multiple>
										<?php foreach($account as $keya=>$valuea){?>
                                        <option <?php if(strpos(USER_ADMIN,','.$valuea['account_id'].',')!==false){echo 'selected="selected"';}?> value="<?php echo $valuea['account_id'];?>"><?php echo $valuea['account_id'];?></option>
                                        <?php }?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tài khoản thêm kho random</label>
                            <div class="col-sm-8">
                            	<select name="USER_INSERT[]" data-placeholder="Chọn tài khoản" class="chosen-select" multiple="multiple">
									<?php foreach($account as $keya=>$valuea){?>
                                    <option <?php if(strpos(USER_INSERT,','.$valuea['account_id'].',')!==false){echo 'selected="selected"';}?> value="<?php echo $valuea['account_id'];?>"><?php echo $valuea['account_id'];?></option>
                                    <?php }?>
                                </select>
                                <script>
                                 $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="COUNT_VIEWS" class="col-sm-4 control-label">Tính lượt truy cập</label>
                            <div class="col-sm-8">
                            	<div class="onoffswitch">
                                    <input type="checkbox" name="COUNT_VIEWS" class="onoffswitch-checkbox" id="COUNT_VIEWS" <?php if($_REQUEST['COUNT_VIEWS']==1){echo 'checked';}?>>
                                    <label class="onoffswitch-label" for="COUNT_VIEWS"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ITEMS_PER_PAGE" class="col-sm-4 control-label">Số bản ghi trên trang</label>
                            <div class="col-sm-8">
                            	<input name="ITEMS_PER_PAGE" type="number" id="ITEMS_PER_PAGE" <?php echo 'value="'.$_REQUEST['ITEMS_PER_PAGE'].'"';?> class="form-control" style="width:100px">
                            </div>
                        </div>
                        <div class="form-group">
                        	<div class="col-sm-offset-4 col-sm-10">
                            	<button type="submit" name="submit" class="btn btn-success" value="submit">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
        	<div class="panel panel-default">
            	<div class="panel-heading">
                	<img src="skins/images/support.png" class="img-reponsice hidden-sm hidden-xs" width="40">
                    <font size="4">Thông tin cơ bản</font>
                </div>
                <div class="panel-body">
                	<p><span class="label label-primary">Tên miền</span> có cấu trúc <a>http://domain.com/</a></p>
                    <p><span class="label label-primary">Tài khoản admin</span> là các tài khoản được phép sử dụng tất cả các tính năng.</p>
                    <p><span class="label label-primary">Tài khoản thêm kho random</span> là các tài khoản ngoài tính năng fake thì được thêm link vào kho random. Không được thêm tài khoản, cấu hình.</p>
                    <p><span class="label label-primary">Tính lượt truy cập</span> nếu bật sẽ đếm số lượng người truy cập vào link khi share. Ảnh hưởng tới tốc độ chuyển hướng người dùng.</p>
                    <p><span class="label label-primary">Số bản ghi trên trang</span> là giới hạn hiển thị trên 1 trang, nếu tổng bản ghi lớn hơn số này thì sẽ phân trang.</p>
                </div>
            </div>
        </div>
    </div>    
</div>
<?php }else{?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
	                <center><img src="skins/images/na.png" class="img-responsive"></center>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>