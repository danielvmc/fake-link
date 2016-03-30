<?php
	include_once('views/nav.php');
	if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false)
	{
		//insert
		if(isset($_REQUEST['submit']) and $_REQUEST['submit']=='Insert')
		{
			extract($_REQUEST);
			if($_REQUEST['a']=='e')
			{
				$sql = 'update tf_account SET account_id="'.$account_id.'" ';
				if($password){ $sql .= ' ,password="'.md5($password).'" ';}
				if($full_name){$sql .= ' ,full_name="'.$full_name.'"';}
				$sql .= ' WHERE id = '.$i;
				Database::query($sql);
				System::redirect('account.html');
			}
			else
			{
				if(Database::select_one('select id from tf_account where account_id="'.$account_id.'"'))
				{
					echo '<script>alert("Tài khoản đã tồn tại");</script>';
				}
				else
				{
					Database::query('insert into tf_account(account_id,password,full_name,time) values("'.$account_id.'","'.md5($password).'","'.$full_name.'","'.time().'")');
					System::redirect('account.html');
				}
			}
		}
		//delete
		if($_REQUEST['a']=='d' and $_REQUEST['i'])
		{
			Database::query('delete from tf_account where id='.$_REQUEST['i']);
			System::redirect('account.html');
		}
		//edit
		if($_REQUEST['a']=='e' and $_REQUEST['i'])
		{
			if($account = Database::select_one('select * from tf_account where id='.$_REQUEST['i']))
			{
				foreach($account as $ka=>$va)
				{
					if(!$_REQUEST[$ka])
					{
						$_REQUEST[$ka] = $va;
					}
				}
			}
		}
		//search
		$cond = '1';
		if($_REQUEST['keyword'])
		{
			$cond .= ' and account_id like "%'.$_REQUEST['keyword'].'%" or full_name like "%'.$_REQUEST['keyword'].'%"';
		}
		$total = Database::select_one('select count(*) as total from tf_account where '.$cond);
		$paging = System::paging($total['total'],ITEMS_PER_PAGE,array('keyword'),'account');
		$items = Database::select('select * from tf_account where '.$cond.' order by id desc limit '.(($_REQUEST['page_no']-1)*ITEMS_PER_PAGE).','.ITEMS_PER_PAGE.'');
?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-5">
        	<form name="InsertAccount" method="post" id="InsertAccount">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-sm-6">
                        	<div class="form-group">
                        		<input type="text" name="account_id" class="form-control" id="account_id" placeholder="Tài khoản" required="required" <?php if($_REQUEST['account_id']){echo 'value="'.$_REQUEST['account_id'].'"';} if($_REQUEST['a']=='e'){echo ' readonly="readonly"';}?>>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        	<div class="form-group">
                        		<input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu" <?php if(!$_REQUEST['password']){echo 'required="required"';}?>>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        	<div class="form-group">
                        		<input type="text" name="full_name" class="form-control" id="full_name" placeholder="Tên hiển thị" <?php if($_REQUEST['full_name']){echo 'value="'.$_REQUEST['full_name'].'"';}?>>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        	<div class="form-group">
                        		<button type="submit" name="submit" class="btn btn-success" id="submit" value="Insert">Lưu</button>
                                <?php if($_REQUEST['a']=='e'){?>
									<a class="btn btn-danger" href="account.html">Hủy</a>
								<?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form name="Search" method="get" id="Search">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <input type="search" name="keyword" class="form-control" id="keyword" placeholder="Từ khóa" <?php if($_REQUEST['keyword']){echo 'value="'.$_REQUEST['keyword'].'"';};?>>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div><button type="submit" name="submit" id="submit" class="btn btn-success">Search</button>&nbsp;<a href="account.html">Clear</a></div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <div style="word-wrap:break-word;">
						<?php foreach($items as $key=>$value){?>
                        <div class="well well-sm">
                                <strong><?php echo $value['account_id'].($value['full_name']?' - '.$value['full_name']:'');?></strong>
                            <div class="pull-right">
                                <a href="account.html?a=e&i=<?php echo $value['id'];?>"><i class="fa fa-edit"></i></a>
                                <a onclick="if(confirm('Bạn chắc chắn muốn xóa?')==true){return true;}else{return false;}" href="?a=d&i=<?php echo $value['id'];?>" style="color:#d9534f"><i class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                        <?php }?>
                     </div>
                     <?php echo $paging;?>
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