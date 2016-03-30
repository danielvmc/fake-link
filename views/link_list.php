<?php
	include_once('views/nav.php');
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
		$cond .= ' and code like "%'.$_REQUEST['keyword'].'%" or link_full like "%'.$_REQUEST['keyword'].'%" or link_fake like "%'.$_REQUEST['keyword'].'%"';
	}
	if($_REQUEST['start_date'])
	{
		$cond .= ' and time>='.strtotime($_REQUEST['start_date']);
	}
	if($_REQUEST['end_date'])
	{
		$cond .= ' and time<='.strtotime($_REQUEST['end_date']);
	}
	$user = Database::select('select id,account_id from tf_link group by account_id');
	$total = Database::select_one('select count(*) as total from tf_link where '.$cond);
	$params = array('start_date','end_date','keyword');
	if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false)
	{
		$params = array('start_date','end_date','keyword','account_id');
	}
	$paging = System::paging($total['total'],ITEMS_PER_PAGE,$params,'link_list');
	$items = Database::select('select * from tf_link where '.$cond.' order by id desc limit '.(($_REQUEST['page_no']-1)*ITEMS_PER_PAGE).','.ITEMS_PER_PAGE.'');
?>
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                	<form name="Search" method="get" id="Search">
                    	<div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label for="start_date" class="hidden-md hidden-sm">Ngày bắt đầu:</label>
                                <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Start date" <?php if($_REQUEST['start_date']){echo 'value="'.$_REQUEST['start_date'].'"';};?>>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label for="end_date" class="hidden-md hidden-sm">Ngày kết thúc:</label>
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
                                <label class="hidden-md hidden-sm" for="keyword">Người tạo</label>
                                <select name="account_id" id="account_id" class="form-control">
                                	<option value="">Người tạo</option>
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
                	<table class="table table-hover table-condensed table-responsive hidden-xs hidden-sm">
                        <thead>
                            <tr class="active">
                                <th width="50" nowrap="nowrap">ID</th>
                                <th>Link</th>
                                <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                                <th>User</th>
                                <?php }if(COUNT_VIEWS){?>
                                <th nowrap>Lượt xem</th>
                                <?php }?>
                                <th nowrap>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $key=>$value){?>
                            <tr>
                                <td width="50" nowrap="nowrap"><?php echo $value['id'];?></td>
                                <td>
                                    <strong><a class="link-share" href="<?php echo DOMAIN.$value['code'];?>" target="_blank"><?php echo DOMAIN.$value['code'];?></a></strong>
                                    <a class="label label-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo DOMAIN.$value['code'];?>" target="_blank">Share</a>
                                    <a class="label label-danger" href="https://developers.facebook.com/tools/debug/og/object?q=<?php echo DOMAIN.$value['code'];?>" target="_blank">Debug</a>
                                    <blockquote>
                                        <div><small><kbd>FULL</kbd><a class="link-full" href="<?php echo $value['link_full']?$value['link_full']:'link_random.html';?>" target="_blank"><?php echo $value['link_full']?$value['link_full']:'Kho Random';?></a></small></div>
                                        <div><small><kbd>FAKE</kbd><a class="link-fake" href="<?php echo $value['link_fake'];?>" target="_blank"><?php echo $value['link_fake'];?></a></small></div>
                                    </blockquote>
                                </td>
                                <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                                <th><?php echo $value['account_id'];?></th>
                                <?php }if(COUNT_VIEWS){?>
                                <td nowrap><?php echo $value['hitcount'];?></td>
                                <?php }?>
                                <td nowrap><?php echo date('G:i d/m/Y',$value['time']);?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div class="hidden-md hidden-lg">
						<?php foreach($items as $key=>$value){?>
                        	<div style="word-wrap:break-word;">
                                <strong><a class="link-share" href="<?php echo DOMAIN.$value['code'];?>" target="_blank"><?php echo DOMAIN.$value['code'];?></a></strong>
                                <div>
                                	<span class="label label-success"><?php echo $value['id'];?></span>
                                    <span class="label label-success"><i class="fa fa-clock-o"></i>&nbsp;<?php echo date('d/m/Y',$value['time']);?></span>
                                    <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
                                	<span class="label label-success"><i class="fa fa-user"></i>&nbsp;<?php echo $value['account_id'];?></span>
                                    <?php }if(COUNT_VIEWS){?>
                                    <span class="label label-warning"><i class="fa fa-eye"></i>&nbsp;<?php echo $value['hitcount'];?></span>
                                    <?php }?>
                                </div>
                                <div>
                                	<a class="label label-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo DOMAIN.$value['code'];?>" target="_blank">Share</a>
                                    <a class="label label-danger" href="https://developers.facebook.com/tools/debug/og/object?q=<?php echo DOMAIN.$value['code'];?>" target="_blank">Debug</a>
                                </div>
                                <blockquote>
                                    <div><small><kbd>FULL</kbd><a class="link-full" href="<?php echo $value['link_full']?$value['link_full']:'link_random.html';?>" target="_blank"><?php echo $value['link_full']?$value['link_full']:'Kho Random';?></a></small></div>
                                    <div><small><kbd>FAKE</kbd><a class="link-fake" href="<?php echo $value['link_fake'];?>" target="_blank"><?php echo $value['link_fake'];?></a></small></div>
                                </blockquote>
                        	</div>
                        <?php }?>
                    </div>
                    <?php echo $paging;?>
                </div>
            </div>
        </div>
    </div>    
</div>