<?php
	include("ketnoi.php");
	$sql="select * from banks";
	$result2=mysql_query($sql);
	$sql1="select * from ATM a, banks b where a.nh_ma=b.nh_ma";
	$result1=mysql_query($sql1);
	$nh_ma="";
	$maatm="";
	$tenatm="";
	$diachi="";
	$lon="";
	$lat="";
	if(isset($_POST["btnThem"])){
		$nh_ma=$_POST["cboNH"];
		$maatm=$_POST["txtMaATM"];
		$tenatm=$_POST["txtTenATM"];
		$diachi=$_POST["txtDiaChi"];
		$lon=$_POST["txtLon"];
		$lat=$_POST["txtLat"];
			
		$sql="Insert into ATM values('$maatm', '$tenatm', '$diachi', $lon, $lat, '$nh_ma')";
		$result=mysql_query($sql);
		if($result){
			echo '<script language="javascript">alert("Thêm thành công!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlyatm.php">';
		}
		else{
			echo '<script language="javascript">alert("Thêm thất bại, vui lòng kiểm tra lại!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlyatm.php">';
		}
	}
	if(isset($_POST["btnCapNhat"])){
		$nh_ma=$_POST["cboNH"];
		$maatm=$_POST["txtMaATM"];
		$tenatm=$_POST["txtTenATM"];
		$diachi=$_POST["txtDiaChi"];
		$lon=$_POST["txtLon"];
		$lat=$_POST["txtLat"];
		$sql="Update ATM set atm_ten='$tenatm', atm_diachi='$diachi', atm_lon=$lon, atm_lat=$lat, nh_ma='$nh_ma' where atm_ma='$maatm'";
		$kq_capnhat=mysql_query($sql);
		if($kq_capnhat){
			echo '<script language="javascript">alert("Cập nhật thành công!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlyatm.php">';
		}
		else{
			echo '<script language="javascript">alert("Cập nhật thất bại, vui lòng kiểm tra lại!");</script>';
			echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlyatm.php">';
		}
	}
	$atm_ma="";
	if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="xoa"){
		if(isset($_GET["atm_ma"]) && $_GET["atm_ma"]!=""){
			$atm_ma=$_GET["atm_ma"];
			$sql="DELETE FROM `ATM` WHERE `atm_ma`='$atm_ma'";
			$kq=mysql_query($sql);
			if($kq)
			{
				echo '<script language="javascript">alert("Xóa thành công!");</script>';
				echo '<meta http-equiv="refresh" content="0;URL=index.php?page=quanlyatm.php">';
			}
			else
			{
				echo '<script language="javascript">alert("Xóa thất bại!'.$sql.'");</script>';
				echo '<meta http-equiv="refresh" content="3;URL=index.php?page=quanlyatm.php">';
			}
		}
	}
	if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
		if(isset($_GET["atm_ma"]) && $_GET["atm_ma"]!=""){
			$maatm=$_GET["atm_ma"];
			$sql="Select * from ATM where atm_ma='$maatm'";
			$result=@mysql_query($sql);
			$tenatm=@mysql_result($result, 0, 1);
			$diachi=@mysql_result($result, 0, 2);
			$lon1=@mysql_result($result, 0, 3);
			$lat1=@mysql_result($result, 0, 4);
			$nh_ma=@mysql_result($result, 0, 5);
			
		}
	}
?>
<html>
	<head>
		<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Quản lý trạm ATM</title>
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
					document.forms["frmThemATM"].txtLat.value=lat.toFixed(6) ;
					document.forms["frmThemATM"].txtLon.value=lng.toFixed(6) ;
				});
				showMarker();
			}
			function showMarker(){
				<?php
					$i=0;
					while($dulieu= mysql_fetch_array($result1)){
						$nh_ten=$dulieu["nh_ten"];
						$name= $dulieu["atm_ten"];
						$addr= $dulieu["atm_diachi"];
						$lat= $dulieu["atm_lat"];
						$long=$dulieu["atm_lon"];
				?>
						var pos= new google.maps.LatLng( <?= $lat; ?>, <?= $long;?>);
						var marker = new google.maps.Marker({
							position: pos,
							map: map,
							title: "Ngân hàng: <?= $nh_ten;?>\nTrạm ATM: <?= $name; ?>\nĐịa chỉ: <?= $addr; ?>"
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
			<form method="POST" id="frmThemATM" name="frmThemATM">
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
						<td align="right">Mã trạm ATM:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtMaATM" value="<?= $maatm; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtMaATM"/>
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td align="right">Trạm ATM:</td>
						<td>
							<?php
								if(isset($_GET["chucnang"]) && $_GET["chucnang"]=="capnhat"){
							?>
									<input name="txtTenATM"  value="<?= $tenatm; ?>" />
							<?php
								}
								else{
							?>
								<input name="txtTenATM" />
							<?php
								}
							?>
						</td>
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
						<th>Trạm ATM</th>
						<th>Địa chỉ</th>
						<th>Ngân hàng</th>
						<th></th>
						<th></th>
					</tr>
					<?php
						$sql1="select * from ATM a, banks b where a.nh_ma=b.nh_ma";
						$result1=mysql_query($sql1);
						while($dulieu=@mysql_fetch_array($result1)){
							$ma=$dulieu["atm_ma"];
							$ten=$dulieu["atm_ten"];
							$diachi=$dulieu["atm_diachi"];
							$nh_ten=$dulieu["nh_ten"];
					?>
							<tr>
								<td align="center"><?= $ten; ?></td>
								<td align="center"><?= $diachi; ?></td>
								<td align="center"><?= $nh_ten; ?></td>
								<td align="center"><a href="index.php?page=quanlyatm.php&chucnang=capnhat&atm_ma=<?= $ma; ?>"><img src="icon/edit.png" align="middle"/></a></td>
								<td align="center"><a onclick="return confirm('Bạn có chắc chắn xóa không?')" href="index.php?page=quanlyatm.php&chucnang=xoa&atm_ma=<?= $ma; ?>"><img src="icon/delete.png" align="middle" /></a></td>
							</tr>
					<?php
						}
					?>
				</table>
			</form>
		</div>
	</body>
</html>
