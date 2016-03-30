<?php
	include_once('views/nav.php');
	$is_random = Database::select_one('select * from tf_url_random');
	if(isset($_REQUEST['submit']))
	{
		extract($_REQUEST);
		$code = Database::random_string(8);
		$image = 'upload/'.$code.'_album.jpg';
		//copy('skins/images/bg_album.jpg',$image);
		if($_FILES['file_1'])
		{
			$images = array( $_GET['color'], $_GET['face'], $_GET['hat'] );

    // Allocate new image
    $img = imagecreatetruecolor(58, 75);
    // Make alpha channels work
    imagealphablending($img, true);
    imagesavealpha($img, true);

    foreach($images as $fn) {
        // Load image
        $cur = imagecreatefrompng($fn);
        imagealphablending($cur, true);
        imagesavealpha($cur, true);

        // Copy over image
        imagecopy($img, $cur, 0, 0, 0, 0, 58, 75);

        // Free memory
        imagedestroy($cur);
    }   

    header('Content-Type: image/png');  // Comment out this line to see PHP errors
    imagepng('upload/'.$img);
		}
		$link_fake = DOMAIN.$new_image;
		if(Database::query('insert into tf_link(type,link_full,link_fake,account_id,code,time) values("IMAGE'.$type.'","'.$link_full.'","'.$link_fake.'","'.$_SESSION['account'].'","'.$code.'","'.time().'")'))
		{
			System::redirect('fake_album.html?code='.$code);
		}
		else
		{
			echo '<script>alert("Xảy ra lỗi!");</script>';
		}
	}
?>
<div class="container-fluid">
    <div class="row">
    	<div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                	<form name="FakeUrl" method="post" action="" id="FakeLink" class="form-horizontal" enctype="multipart/form-data">
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
                            	<a class="btn btn-info" href="fake_album.html">Tiếp tục</a>
                            </div>
                        </div>
                        <?php
								}else{
						?>
                        <center>
                            <h3>Link share không tồn tại</h3>
                            <a class="btn btn-danger" href="fake_album.html">Tạo link</a>
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
                        <?php for($i=1;$i<=4;$i++){?>
                        <div class="form-group">
                            <label for="file_<?php echo $i;?>" class="col-sm-2 control-label">Ảnh <?php echo $i;?></label>
                            <div class="col-sm-10">
                            	<input type="file" name="file_<?php echo $i;?>" class="form-control" id="file_<?php echo $i;?>">
                            </div>
                        </div>
                        <?php }?>
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
        <div class="col-md-4">
            <div class="panel panel-default">
            	<div class="panel-heading">
                	<img src="skins/images/support.png" class="img-reponsice hidden-sm hidden-xs" width="40">
                    <font size="4">Hướng dẫn sử dụng</font>
                </div>
                <div class="panel-body">
                	<p><span class="label label-primary">Link full</span> là đường dẫn người dùng được chuyển tới khi click vào thông tin được share.</p>
                    <p>Chọn <span class="label label-primary">Ảnh</span> muốn thêm nút play. Ảnh này sẽ được resize và crop về kích thước 487x396 (kích thước hiển thị trên facebook) trước khi thêm icon.</p>
                    <p>Chọn <span class="label label-primary">Icon</span> muốn thêm lên ảnh</p>
                    <p><span class="label label-warning">Lưu ý</span> nếu <font style="font-weight:500" color="#FF3300">link full</font> để trống thì hệ thống sẽ chọn ngẫu nhiên trong <a style="font-weight:500;color:#FF3300" href="link_random.html" target="_blank">kho random</a> để chuyển hướng người dùng.</p>
                </div>
            </div>
        </div>
    </div>    
</div>