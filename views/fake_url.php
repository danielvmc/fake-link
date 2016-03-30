<?php
	include_once('views/nav.php');
	$is_random = Database::select_one('select * from tf_url_random');
	if(isset($_REQUEST['submit']))
	{
		extract($_REQUEST);
		$code = Database::random_string(8);
		if(Database::query('insert into tf_link(type,link_full,link_fake,account_id,code,time) values("URL","'.$link_full.'","'.$link_fake.'","'.$_SESSION['account'].'","'.$code.'","'.time().'")'))
		{
			System::redirect('fake_url.html?code='.$code);
		}
		else
		{
			echo '<script>alert("Xảy ra lỗi!");</script>';
		}
	}
?>
<div class="container-fluid">
    <div class="row">
    	<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                	<form name="FakeUrl" method="post" action="" id="FakeLink" class="form-horizontal">
                    	<?php
                        	if($_REQUEST['code']){
								if(Database::select_one('select id from tf_link where code="'.$_REQUEST['code'].'"'))
								{
						?>
                        <div class="form-group">
                            <label for="link_share" class="col-sm-2 control-label">Link share</label>
                            <div class="col-sm-10">
                                <input name="link_share" value="<?php echo DOMAIN.$_REQUEST['code'];?>" class="form-control" id="link_share" onclick="this.select();">
                            </div>
                        </div>
                        <div class="form-group">
                        	<div class="col-sm-offset-2 col-sm-10">
                            	<a class="btn btn-info" href="fake_url.html">Tiếp tục</a>
                            </div>
                        </div>
                        <?php
								}else{
						?>
                        <center>
                            <h3>Link share không tồn tại</h3>
                            <a class="btn btn-danger" href="fake_url.html">Tạo link</a>
                        </center>
                        <?php
								}
							}else{
						?>
                        <div class="form-group">
                            <label for="link_full" class="col-sm-2 control-label">Link full</label>
                            <div class="col-sm-10">
                            	<?php if(!$is_random){?>
                                <input type="url" name="link_full" class="form-control" id="link_full" placeholder="Link full" required="required">
                                <?php }else{?>
                            	<input type="url" name="link_full" class="form-control" id="link_full" placeholder="Link full">
                                <?php }?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link_fake" class="col-sm-2 control-label">Link fake</label>
                            <div class="col-sm-10">
                            	<input type="url" name="link_fake" class="form-control" id="link_fake" placeholder="Link fake" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            	<button type="submit" name="submit" id="submit" class="btn btn-success">Tạo link</button>
                            </div>
                        </div>
                        <?php }?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
            	<div class="panel-heading">
                	<img src="skins/images/support.png" class="img-reponsice hidden-sm hidden-xs" width="40">
                    <font size="4">Hướng dẫn sử dụng</font>
                </div>
                <div class="panel-body">
                	<p><span class="label label-primary">Link full</span> là đường dẫn người dùng được chuyển tới khi click vào thông tin được share.</p>
                    <p><span class="label label-primary">Link fake</span> là đường dẫn các trang mạng chia sẻ sử dụng để lấy thông tin hiển thị.</p>
                    <p><span class="label label-warning">Lưu ý</span> nếu <font style="font-weight:500" color="#FF3300">link full</font> để trống thì hệ thống sẽ chọn ngẫu nhiên trong <a style="font-weight:500;color:#FF3300" href="link_random.html" target="_blank">kho random</a> để chuyển hướng người dùng.</p>
                    <p><span class="label label-warning">Lưu ý</span> nếu khi share hiển thị không như mong muốn, hãy sử dụng <a href="https://developers.facebook.com/tools/debug/" target="_blank"><strong>tool debug</strong></a> của facebook để fix thông tin hiển thị. Nếu vẫn không được xin vui lòng <a href="https://www.facebook.com/quysuthanhtien" target="_blank">inbox</a>.</p>
                </div>
            </div>
        </div>
    </div>    
</div>