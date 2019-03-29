<?php
	include("ketnoi.php");
	$nh_ma="";
	$nh_ten="";
	if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="xoa"){
		if(isset($_GET["nh_ma"]) && $_GET["nh_ma"]!=""){
			$nh_ma=$_GET["nh_ma"];
			$sql1="DELETE FROM `GD` WHERE `nh_ma`='$nh_ma'";
			$kq1=mysql_query($sql1);
			$sql2="DELETE FROM `ATM` WHERE `nh_ma`='$nh_ma'";
			$kq2=mysql_query($sql2);
			$sql="DELETE FROM `banks` WHERE `nh_ma`='$nh_ma'";
			$kq=mysql_query($sql);
			if($kq&&$kq1&&$kq2)
			{
				echo '<script language="javascript">alert("Xóa thành công!");</script>';
				echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlynganhang.php">';
			}
			else
			{
				echo '<script language="javascript">alert("Xóa thất bại!");</script>';
				echo '<meta http-equiv="refresh" content="3;URL=index.php?page=quanlynganhang.php">';
			}
		}
	}
	if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
		if(isset($_GET["nh_ma"]) && $_GET["nh_ma"]!=""){
			$nh_ma=$_GET["nh_ma"];
			$sql="Select * from banks where nh_ma='$nh_ma'";
			$result=mysql_query($sql);
			$nh_ten=mysql_result($result, 0, 1);
		}
	}
	if(isset($_POST["btnThem"]))
	{
		$nh_ma=$_POST["txtMaNH"];
		$nh_ten=$_POST["txtTenNH"];
		//Kiem tra ma
		$sql="Select * from banks where nh_ma='$nh_ma'";
		$result=mysql_query($sql);
		if(@mysql_num_rows($result)>0){
			echo '<script language="javascript">alert("Mã ngân hàng đã tồn tại!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
		}
		else{
			//Kiem tra ten
			$sql="Select * from banks where nh_ten='$nh_ten'";
			$result=mysql_query($sql);
			if(@mysql_num_rows($result)>0){
				echo '<script language="javascript">alert("Tên ngân hàng đã tồn tại!");</script>';
				echo '<meta http-equiv="refresh" content="0;URL=index.php">';
			}
			else{
				$sql="Insert into banks values('$nh_ma','$nh_ten')";
				$result=mysql_query($sql);
				if($result){
					echo '<script language="javascript">alert("Thêm thành công!");</script>';
					echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlynganhang.php">';
				}
				else{
					echo '<script language="javascript">alert("Thêm thất bại, vui lòng kiểm tra lại!");</script>';
					echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlynganhang.php">';
				}
			}
		}
	}
	if(isset($_POST["btnCapNhat"])){
		$nh_ma=$_POST["txtMaNH"];
		$nh_ten=$_POST["txtTenNH"];
		$sql="Select * from banks where nh_ten='$nh_ten' and nh_ma!='$nh_ma'";
		$result=mysql_query($sql);
		if(@mysql_num_rows($result)>0){
			echo '<script language="javascript">alert("Tên ngân hàng đã tồn tại!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
		}
		else{
			$sql="Update banks set nh_ten='$nh_ten' where nh_ma='$nh_ma'";
			$result=mysql_query($sql);
			if($result){
				echo '<script language="javascript">alert("Cập nhật thành công!");</script>';
				echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlynganhang.php">';
			}
			else{
				echo '<script language="javascript">alert("Cập nhật thất bại, vui lòng kiểm tra lại!");</script>';
				echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlynganhang.php">';
			}
		}
	}
	$sql="Select * from banks";
	$result= mysql_query($sql);
?>
<html>
	<head>
		<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Quản lý ngân hàng</title>
	</head>
	<body>
		<div id="templatemo_content_wrapper">
			<form method="post" id="frmThemNH" name="frmThemNH">
				<table border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td align="right">Mã ngân hàng:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input type="text" name="txtMaNH" value="<?= $nh_ma; ?>" readonly="" />
							<?php
								}
								else{
							?>
								<input type="text" name="txtMaNH"/>
							<?php
								}
							?>
							
						</td>
					</tr>
					<tr>
						<td align="right">Tên ngân hàng:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input type="text" name="txtTenNH" value="<?= $nh_ten; ?>" />
							<?php
								}
								else{
							?>
								<input type="text" name="txtTenNH"/>
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input type="submit" name="btnCapNhat" value="Cập nhật" /> 
							<?php
								}
								else{
							?>
								<input type="submit" name="btnThem" value="Thêm" /> 
							<?php
								}
							?>
							
							<input type="reset" value="Hủy" />
						</td>
					</tr>
				</table>
			</form>
			<br>
			<br>
			<form id="frmDSNH" name="frmDSNH">
				<table border="1" cellspacing="0" cellpadding="0" align="center" width="100%" >
					<tr>
						<th>Mã ngân hàng</th>
						<th>Tên ngân hàng</th>
						<th>Cập nhật</th>
						<th>Xóa</th>
					</tr>
					<?php
						while($dulieu= mysql_fetch_array($result)){
							$ma= $dulieu["nh_ma"];
							$ten=$dulieu["nh_ten"];
					?>
					<tr>
						<td align="center"><?= $ma; ?></td>
						<Td align="center"><?= $ten; ?></Td>
						<td align="center"><a href="index.php?page=quanlynganhang.php&chucnang=capnhat&nh_ma=<?= $ma; ?>"><img src="icon/edit.png" align="middle"/></a></td>
						<td align="center"><a onclick="return confirm('Bạn có chắc chắn xóa không?')"  href="index.php?page=quanlynganhang.php&chucnang=xoa&nh_ma=<?= $ma; ?>"><img src="icon/delete.png" align="middle" /></a></td>
					</tr>
					<?php
						}
					?>
				</table>
			</form>
		</div>
	</body>
</html>
