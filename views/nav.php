<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=""><img src="skins/images/brand.png" class="img-responsive"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="fake_url.html">Fake Url</a></li>
        <li><a href="fake_image.html">Fake Image</a></li>
        <li><a href="link_list.html">Danh Sách Link</a></li>
        <li><a href="link_random.html">Kho Random</a></li>
        <?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
        <li><a href="account.html">DS Tài Khoản</a></li>
        <?php }?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<?php if(strpos(USER_ADMIN,','.$_SESSION['account'].',')!==false){?>
        <li><a href="setting.html">Cấu hình</a></li>
        <?php }?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['full_name']?$_SESSION['full_name'].'&nbsp;('.$_SESSION['account'].')':$_SESSION['account'];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="change_pass.html">Đổi mật khẩu</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.html">Thoát</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php include_once('views/breadcrumb.php');?>