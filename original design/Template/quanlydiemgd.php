<?php
	include("ketnoi.php");
	$sql="select * from banks";
	$result2=mysql_query($sql);
	$sql1="select * from GD a, banks b where a.nh_ma=b.nh_ma";
	$result1=mysql_query($sql1);
	$nh_ma="";
	$magd="";
	$tengd="";
	$diachi="";
	$giolamviec="";
	$lon="";
	$lat="";
	$trusochinh="";
	if(isset($_POST["btnThem"])){
		$nh_ma=$_POST["cboNH"];
		$magd=$_POST["txtMaGD"];
		$tengd=$_POST["txtTenGD"];
		$diachi=$_POST["txtDiaChi"];
		$giolamviec=$_POST["txtGioLamViec"];
		$lon=$_POST["txtLon"];
		$lat=$_POST["txtLat"];
		$trusochinh=0;
		if(isset($_POST["chkTruSoChinh"]))
			$trusochinh=1;
			
		$sql="Insert into GD values('$magd', '$tengd', $trusochinh, '$diachi', '$giolamviec', $lon, $lat, '$nh_ma')";
		$result=mysql_query($sql);
		if($result){
			echo '<script language="javascript">alert("Thêm thành công!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlydiemgd.php">';
		}
		else{
			echo '<script language="javascript">alert("Thêm thất bại, vui lòng kiểm tra lại!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlydiemgd.php">';
		}
	}
	if(isset($_POST["btnCapNhat"])){
		$nh_ma=$_POST["cboNH"];
		$magd=$_POST["txtMaGD"];
		$tengd=$_POST["txtTenGD"];
		$diachi=$_POST["txtDiaChi"];
		$giolamviec=$_POST["txtGioLamViec"];
		$lon=$_POST["txtLon"];
		$lat=$_POST["txtLat"];
		$trusochinh=0;
		if(isset($_POST["chkTruSoChinh"]))
			$trusochinh=1;
		$sql="Update GD set gd_ten='$tengd', gd_trusochinh=$trusochinh, gd_diachi='$diachi', gd_giolamviec='$giolamviec', gd_lon=$lon, gd_lat=$lat, nh_ma='$nh_ma' where gd_ma='$magd'";
		$kq_capnhat=mysql_query($sql);
		if($kq_capnhat){
			echo '<script language="javascript">alert("Cập nhật thành công!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlydiemgd.php">';
		}
		else{
			echo '<script language="javascript">alert("Cập nhật thất bại, vui lòng kiểm tra lại!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlydiemgd.php">';
		}
	}
	$gd_ma="";
	if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="xoa"){
		if(isset($_GET["gd_ma"]) && $_GET["gd_ma"]!=""){
			$gd_ma=$_GET["gd_ma"];
			$sql="DELETE FROM `GD` WHERE `gd_ma`='$gd_ma'";
			$kq=mysql_query($sql);
			if($kq)
			{
				echo '<script language="javascript">alert("Xóa thành công!");</script>';
				echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlydiemgd.php">';
			}
			else
			{
				echo '<script language="javascript">alert("Xóa thất bại!'.$sql.'");</script>';
				echo '<meta http-equiv="refresh" content="3;URL=index.php?page=quanlydiemgd.php">';
			}
		}
	}
	if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
		if(isset($_GET["gd_ma"]) && $_GET["gd_ma"]!=""){
			$magd=$_GET["gd_ma"];
			$sql="Select * from GD where gd_ma='$magd'";
			$result=@mysql_query($sql);
			$tengd=@mysql_result($result, 0, 1);
			$trusochinh=@mysql_result($result, 0, 2);
			$diachi=@mysql_result($result, 0, 3);
			$giolamviec=@mysql_result($result, 0, 4);
			$lon1=@mysql_result($result, 0, 5);
			$lat1=@mysql_result($result, 0, 6);
			$nh_ma=@mysql_result($result, 0, 7);
			
		}
	}
?>
<html>
	<head>
		<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Quản lý điểm giao dịch</title>
		<Style>
			div#map-canvas{
				height: 500px;
				width: 100%;
			}
		</Style>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=vi"></script>
		<Script language="javascript">
			var map;
			function loadMap(){
				var mapOptions = {
						zoom: 12,
						center: new google.maps.LatLng(10.016721, 105.759945)
				};
				map = new google.maps.Map(document.getElementById('map-canvas'),
							mapOptions);      
						
				google.maps.event.addListener(map, 'zoom_changed', function() {
					currentZoom = map.getZoom();
				});
				google.maps.event.addListener(map, "click", function(event) {
					var lat = event.latLng.lat();
					var lng = event.latLng.lng();
					// populate yor box/field with lat, lng
					document.forms["frmThemDiemGD"].txtLat.value=lat.toFixed(6) ;
					document.forms["frmThemDiemGD"].txtLon.value=lng.toFixed(6) ;
				});
				showMarker();
			}
			function showMarker(){
				var infowindow; 
				<?php
					$i=0;
					while($dulieu= mysql_fetch_array($result1)){
						$nh_ten=$dulieu["nh_ten"];
						$name= $dulieu["gd_ten"];
						$addr= $dulieu["gd_diachi"];
						$gio=$dulieu["gd_giolamviec"];
						$lat= $dulieu["gd_lat"];
						$long=$dulieu["gd_lon"];
				?>
								
						var pos= new google.maps.LatLng( <?= $lat; ?>, <?= $long;?>);
						var marker = new google.maps.Marker({
							position: pos,
							map: map,
							title: "Ngân hàng: <?= $nh_ten;?>\nĐiểm giao dịch: <?= $name; ?>\nĐịa chỉ: <?= $addr; ?>\nGiờ làm việc: <?= $gio;?>"
						});								
						<?php
								$i++;
							}
						?>
			}
		</script>
	</head>
	<body onload="loadMap();">
		<div id="templatemo_content_wrapper">
			<form method="POST" id="frmThemDiemGD" name="frmThemDiemGD">
				<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
					<tr>
						<td align="right">Ngân hàng:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<select name="cboNH">
									<?PHP
										while($dulieu=mysql_fetch_array($result2)){
											if($dulieu["nh_ma"]==$nh_ma){
									?>
												<option selected="" value="<?= $dulieu["nh_ma"]; ?>"><?= $dulieu["nh_ten"]; ?></option>
									<?php
											}
											else{
									?>
												<option value="<?= $dulieu["nh_ma"]; ?>"><?= $dulieu["nh_ten"]; ?></option>
									<?php
											}
										}
									?>
									</select>
							<?php
								}
								else{
							?>
								<select name="cboNH">
								<?PHP
									while($dulieu=mysql_fetch_array($result2)){
								?>
										<option value="<?= $dulieu["nh_ma"]; ?>"><?= $dulieu["nh_ten"]; ?></option>
								<?php
									}
								?>
								</select>
							<?php
								}
							?>
						</td>
						<td align="right">Mã điểm giao dịch:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtMaGD" value="<?= $magd; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtMaGD"/>
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td align="right">Điểm giao dịch:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtTenGD"  value="<?= $tengd; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtTenGD" />
							<?php
								}
							?>
						</td>
						<td align="right">Trụ sở chính:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
									if($trusochinh==1)
							?>
									<input type="checkbox" value="1" name="chkTruSoChinh" checked="" />
							<?php
								}
								else{
							?>
								<input type="checkbox" value="1" name="chkTruSoChinh" />
							<?php
								}
							?>
							
						</td>
					</tr>
					<tr>
						<td align="right">Địa chỉ:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtDiaChi"  value="<?= $diachi; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtDiaChi" />
							<?php
								}
							?>
						</td>
						<td align="right">Giờ làm việc:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtGioLamViec" value="<?= $giolamviec; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtGioLamViec" />
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td align="right">Lat:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtLat"  value="<?= $lat1; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtLat"  />
							<?php
								}
							?>
						</td>
						<td align="right">Lon:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtLon" value="<?= $lon1; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtLon" />
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="4">
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input type="submit" name="btnCapNhat" value="Cập nhật" /> 
							<?php
								}
								else{
							?>
								<input type="submit" name="btnThem" value="Thêm"/>
							<?php
								}
							?>
							<input type="reset" value="Hủy"/>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="4">
							*Lưu ý: Click vào bản đồ để chọn tọa độ Lon-Lat.
						</td>
					</tr>
				</table>
				<hr>
				<div id="map-canvas"></div>
				<hr>
				<table border="1" cellspacing="0" cellpadding="0" align="center" width="100%">
					<tr>
						<th>Điềm giao dịch</th>
						<th>Địa chỉ</th>
						<th>Ngân hàng</th>
						<th></th>
						<th></th>
					</tr>
					<?php
						$sql1="select * from GD a, banks b where a.nh_ma=b.nh_ma Order by a.nh_ma";
						$result1=mysql_query($sql1);
						while($dulieu=@mysql_fetch_array($result1)){
							$ma=$dulieu["gd_ma"];
							$ten=$dulieu["gd_ten"];
							$diachi=$dulieu["gd_diachi"];
							$nh_ten=$dulieu["nh_ten"];
					?>
							<tr>
								<td align="center"><?= $ten; ?></td>
								<td align="center"><?= $diachi; ?></td>
								<td align="center"><?= $nh_ten; ?></td>
								<td align="center"><a href="index.php?page=quanlydiemgd.php&chucnang=capnhat&gd_ma=<?= $ma; ?>"><img src="icon/edit.png" align="middle"/></a></td>
								<td align="center"><a onclick="return confirm('Bạn có chắc chắn xóa không?')" href="index.php?page=quanlydiemgd.php&chucnang=xoa&gd_ma=<?= $ma; ?>"><img src="icon/delete.png" align="middle" /></a></td>
							</tr>
					<?php
						}
					?>
				</table>
			</form>
		</div>
	</body>
</html>
