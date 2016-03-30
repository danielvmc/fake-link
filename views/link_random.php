<?php
	include_once('views/nav.php');
	if(strpos(USER_INSERT,','.$_SESSION['account'].',')!==false)
	{
		//insert
		if(isset($_REQUEST['submit']) and $_REQUEST['submit']=='Insert')
		{
			extract($_REQUEST);
			Database::query('insert into tf_url_random(url,account_id,time) values("'.$url.'","'.$_SESSION['account'].'","'.time().'")');
			System::redirect('link_random.html');
		}
		//delete
		if($_REQUEST['a']=='d' and $_REQUEST['i'])
		{
			Database::query('delete from tf_url_random where id='.$_REQUEST['i']);
			System::redirect('link_random.html');
		}
		//search
		if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false)
		{
			$cond = '1';
			if($_REQUEST['account_id'])
			{
				$cond = 'account_id="'.$_REQUEST['account_id'].'"';
			}
		}
		else
		{
			$cond = 'account_id="'.$_SESSION['account'].'"';
		}
		if($_REQUEST['keyword'])
		{
			$cond .= ' and url like "%'.$_REQUEST['keyword'].'%"';
		}
		if($_REQUEST['start_date'])
		{
			$cond .= ' and time>='.strtotime($_REQUEST['start_date']);
		}
		if($_REQUEST['end_date'])
		{
			$cond .= ' and time<='.strtotime($_REQUEST['end_date']);
		}
		$user = Database::select('select id,account_id from tf_url_random group by account_id');
		$total = Database::select_one('select count(*) as total from tf_url_random where '.$cond);
		$params = array('start_date','end_date','keyword');
		if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false)
		{
			$params = array('start_date','end_date','keyword','account_id');
		}
		$paging = System::paging($total['total'],ITEMS_PER_PAGE,$params,'link_random');
		$items = Database::select('select * from tf_url_random where '.$cond.' order by id desc limit '.(($_REQUEST['page_no']-1)*ITEMS_PER_PAGE).','.ITEMS_PER_PAGE.'');
?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-12">
        	<form name="InsertRandom" method="post" id="InsertRandom">
                <div class="panel panel-default">
                	<div class="panel-heading">Thêm mới</div>
                    <div class="panel-body">
                        <div class="col-sm-11">
                        	<div class="form-group">
                        		<input type="url" name="url" class="form-control" id="url" placeholder="Url" required="required">
                            </div>
                        </div>
                        <div class="col-sm-1">
                        	<div class="form-group">
                        		<button type="submit" name="submit" class="btn btn-success" id="submit" value="Insert">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<div class="row">
    	<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form name="Search" method="get" id="Search">
                    	<div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label for="start_data" class="hidden-md hidden-sm">Ngày bắt đầu:</label>
                                <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Start date" <?php if($_REQUEST['start_date']){echo 'value="'.$_REQUEST['start_date'].'"';};?>>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label for="start_data" class="hidden-md hidden-sm">Ngày kết thúc:</label>
                                <input type="date" name="end_date" class="form-control" id="end_date" placeholder="End date" <?php if($_REQUEST['end_date']){echo 'value="'.$_REQUEST['end_date'].'"';};?>>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label class="hidden-md hidden-sm" for="keyword">Từ khóa</label>
                                <input type="search" name="keyword" class="form-control" id="keyword" placeholder="Từ khóa" <?php if($_REQUEST['keyword']){echo 'value="'.$_REQUEST['keyword'].'"';};?>>
                            </div>
                        </div>
                        <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label class="hidden-md hidden-sm" for="keyword">Người thêm</label>
                                <select name="account_id" id="account_id" class="form-control">
                                	<option value="">Người thêm</option>
                                	<?php foreach($user as $key=>$value){?>
                                    <option value="<?php echo $value['account_id'];?>"><?php echo $value['account_id'];?></option>
                                    <?php }?>
                                </select>
                                <?php if($_REQUEST['account_id']){echo '<script>document.getElementById("account_id").value="'.$_REQUEST['account_id'].'";</script>';};?>
                            </div>
                        </div>
                        <?php }?>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                            	<label class="hidden-md hidden-sm hidden-xs">&nbsp;</label>
                                <div><button type="submit" name="submit" id="submit" class="btn btn-success">Search</button>&nbsp;<a href="link_random.html">Clear</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                	<?php echo $paging;?>
                	<table class="table table-hover table-condensed table-responsive hidden-xs">
                        <thead>
                            <tr class="active">
                                <th width="50" nowrap="nowrap">ID</th>
                                <th>Link</th>
                                <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                                <th width="5%" nowrap="nowrap">User</th>
                                <?php }?>
                                <th width="1%" nowrap="nowrap">Ngày tạo</th>
                                <th width="5%" nowrap="nowrap" style="text-align:center"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $key=>$value){?>
                            <tr>
                                <td width="50" nowrap="nowrap"><?php echo $value['id'];?></td>
                                <td>
                                    <strong><a class="link-share" href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['url'];?></a></strong>
                                </td>
                                <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                                <td width="5%" nowrap="nowrap"><?php echo $value['account_id'];?></td>
                                <?php }?>
                                <td width="1%" nowrap="nowrap"><?php echo date('G:i d/m/Y',$value['time']);?></td>
                                <td width="5%" nowrap="nowrap" align="center"><a onclick="if(confirm('Bạn chắc chắn muốn xóa?')==true){return true;}else{return false;}" href="?a=d&i=<?php echo $value['id'];?>" style="color:#d9534f"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div class="hidden-lg hidden-md hidden-sm">
                    	<?php foreach($items as $key=>$value){?>
                        <div class="well well-sm" style="word-wrap:break-word;">
                        	<strong><a class="link-share" href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['url'];?></a></strong>
                            <div>
                            	<span class="label label-success"><?php echo $value['id'];?></span>
                                <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                                <span class="label label-warning"><i class="fa fa-user"></i>&nbsp;<?php echo $value['account_id'];?></span>
                                <?php }?>
                                <span class="label label-success"><i class="fa fa-clock-o"></i>&nbsp;<?php echo date('d/m/Y',$value['time']);?></span>
                                <span class="label label-danger"><a onclick="if(confirm('Bạn chắc chắn muốn xóa?')==true){return true;}else{return false;}" href="?a=d&i=<?php echo $value['id'];?>" style="color:#fff;"><i class="fa fa-trash-o"></i></a></span>
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