<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hệ thống quản lý điểm giao dịch và trạm ATM các ngân hàng địa bàn Tp Cần Thơ</title>
<meta name="keywords" content="Lin Photo, free website template, XHTML CSS layout" />
<meta name="description" content="Lin Photo, free website template, free XHTML CSS layout provided by templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="templatemo_container">
	<div id="templatemo_banner">
    	<div id="logo"></div>
    </div> <!-- end of banner -->
    <div id="templatemo_menu">
        <ul>
            <li><a href="index.php?page=trangchu.php"><span></span>Trang chủ</a></li>
            <li><a href="index.php?page=quanlynganhang.php"><span></span>Ngân hàng</a></li>
            <li><a href="index.php?page=quanlydiemgd.php"><span></span>Điểm giao dịch</a></li>
            <li><a href="index.php?page=quanlyatm.php"><span></span>Trạm ATM</a></li>
            <li><a href="index.php?page=hienthi.php"><span></span>Tìm kiếm</a></li>            
        </ul>   
	</div> <!-- end of menu -->
	<?php 
		if(isset($_GET["page"]))
			include($_GET["page"]); 
		else
			include("trangchu.php");
	?>
    
    <div id="templatemo_footer">
        
        <div class="margin_bottom_10"></div>
        
        Copyright © <a href="#">Lương Hoàng Hướng</a> | <a href="#" target="_parent">Nguyễn Võ Thông Thái</a> | <a href="#" target="_parent">Trần Công Nghị</a>
        
        <div class="margin_bottom_10"></div>
        
        <a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" width="88" height="31" vspace="8" border="0" /></a>
                <a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px"  src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" vspace="8" border="0" /></a>
                
   	</div> <!-- end of footer -->
</div> <!-- end of container -->
<div align=center>This template  downloaded form <a href='http://all-free-download.com/free-website-templates/'>free website templates</a></div></body>
</html>
