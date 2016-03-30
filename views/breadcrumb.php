<ol class="breadcrumb">
    <li><a href="about.html">System Fake</a></li>
    <li class="active">
    	<?php
			switch($_REQUEST['page'])
			{
				case 'fake_url':
					echo 'Fake Url';
					break;
				case 'fake_image':
					echo 'Fake Image';
					break;
				case 'link_list':
					echo 'Danh sách link';
					break;
				case 'link_random':
					echo 'Kho link ngẫu nhiên';
					break;
				case 'account':
					echo 'Danh sách tài khoản';
					break;
				case 'setting':
					echo 'Cấu hình hệ thống';
					break;
				case 'change_pass':
					echo 'Đổi mật khẩu';
					break;
				default:
					echo 'Hệ thống giả mạo link';
					break;
			}
        ?>
    </li>
</ol>