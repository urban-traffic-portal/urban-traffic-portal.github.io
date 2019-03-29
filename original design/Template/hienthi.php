<?php
	include("ketnoi.php");
	$sql="select * from GD a, banks b where a.nh_ma=b.nh_ma";
	$result= mysql_query($sql);
	
	$sql1="select * from ATM a, banks b where a.nh_ma=b.nh_ma";
	$result1= mysql_query($sql1);
	
	$sql2="Select distinct(c.nh_ma), c.nh_ten from GD a, ATM b, banks c where c.nh_ma=a.nh_ma and c.nh_ma=b.nh_ma";
	$result2=mysql_query($sql2);
	
	if(isset($_POST["btnTimKiem"])){
		$nh_ma=$_POST["cboNH"];
		$bankinh=$_POST["txtBanKinh"];
		$lat= $_POST["txtLat"];
		$lon=$_POST["txtLon"];
		
		
		if($nh_ma!=0){
			//$sql="select * from GD a, banks b where a.nh_ma=b.nh_ma and b.nh_ma='$nh_ma'";
			$sql="SELECT *, ( 6371 * acos( cos( radians($lat) ) * cos( radians( gd_lat ) ) * cos( radians( gd_lon ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( gd_lat ) ) ) ) AS distance";
			$sql.=" FROM GD a, banks b where a.nh_ma=b.nh_ma and b.nh_ma='$nh_ma' HAVING distance <= $bankinh ORDER BY distance";
			$result= mysql_query($sql);
			
			//$sql1="select * from ATM a, banks b where a.nh_ma=b.nh_ma and b.nh_ma='$nh_ma'";
			$sql1="SELECT *, ( 6371 * acos( cos( radians($lat) ) * cos( radians( atm_lat ) ) * cos( radians( atm_lon ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( atm_lat ) ) ) ) AS distance ";
			$sql1.="FROM ATM a, banks b where a.nh_ma=b.nh_ma and b.nh_ma='$nh_ma' HAVING distance <= $bankinh ORDER BY distance";
			
			$result1= mysql_query($sql1);
		}
		else{
			$sql="SELECT *, ( 6371 * acos( cos( radians($lat) ) * cos( radians( gd_lat ) ) * cos( radians( gd_lon ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( gd_lat ) ) ) ) AS distance";
			$sql.=" FROM GD a, banks b where a.nh_ma=b.nh_ma HAVING distance <= $bankinh ORDER BY distance";
			$result= mysql_query($sql);
			
			$sql1="SELECT *, ( 6371 * acos( cos( radians($lat) ) * cos( radians( atm_lat ) ) * cos( radians( atm_lon ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( atm_lat ) ) ) ) AS distance ";
			$sql1.="FROM ATM a, banks b where a.nh_ma=b.nh_ma HAVING distance <= $bankinh ORDER BY distance";
			//echo '<script language="javascript">alert("'.$sql1.'");</script>';
			$result1= mysql_query($sql1);
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
				width: 560px;
				margin: 0px;
				padding: 0px
				margin-right: 400px;
				float: left;

			}
			#directions-panel {
				height: 500px;
				float: right;
				width: 390px;
				overflow: auto;
				background-color: white;
			}

		</Style>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=vi"></script>
		<Script language="javascript">
			var map;
			var markers=[];
			var lat_center;
			var lon_center;
			var currentPosition;
			var directionsDisplay;
			var bk;
			var sent=false;
			var directionsService = new google.maps.DirectionsService();
			var lines=[];
			function getCoordinates(){
				<?php
				if(isset($_POST["btnTimKiem"])){
				?>
						lat_center= <?= $lat; ?>;
						lon_center= <?= $lon; ?>;
						bk= <?= $bankinh; ?>;
						document.forms["frmHienThi"].txtLat.value=<?= $lat; ?>;
						document.forms["frmHienThi"].txtLon.value=<?= $lon; ?>;
				<?php
					}
					else{
				?>
						lat_center= 10.016721;
						lon_center= 105.759945;
				<?php	
					}
				?>
			}
			
			function loadMap(){
				getCoordinates();
				directionsDisplay = new google.maps.DirectionsRenderer();
				var mapOptions = {
						zoom: 12,
						center: new google.maps.LatLng( lat_center, lon_center)
				};
				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);  
				directionsDisplay.setMap(map);   
				directionsDisplay.setPanel(document.getElementById('directions-panel'));

						
				google.maps.event.addListener(map, 'zoom_changed', function() {
					currentZoom = map.getZoom();
				});
				
				google.maps.event.addListener(map, "click", function(event) {
					var lat = event.latLng.lat();
					var lng = event.latLng.lng();
					// populate yor box/field with lat, lng
					document.forms["frmHienThi"].txtLat.value=lat.toFixed(6) ;
					document.forms["frmHienThi"].txtLon.value=lng.toFixed(6) ;
					
					//Remove current position from map
					removeMarker();
					//Add current position into map
					var pos= new google.maps.LatLng(lat, lng);
					var marker = new google.maps.Marker({
						position: pos,
						map: map
					});
					markers.push(marker);
					document.forms["frmHienThi"].txtLat.value=lat.toFixed(6);
					document.forms["frmHienThi"].txtLon.value=lng.toFixed(6); 
				});
				
				showATM();
				showGD();
				drawCircle();
				
			}
			
			function removeMarker(){
				for (var i = 0; i < markers.length; i++) {
						markers[i].setMap(null);
					}
					markers=[];
					document.forms["frmHienThi"].txtLat.value="";
					document.forms["frmHienThi"].txtLon.value="";
			}
			
			function addMarker(){
				var pos= new google.maps.LatLng(lat, lng);
					var marker = new google.maps.Marker({
						position: pos,
						map: map
					});
					markers.push(marker);
					document.forms["frmHienThi"].txtLat.value=lat.toFixed(6);
					document.forms["frmHienThi"].txtLon.value=lng.toFixed(6); 
			}
			
			function drawCircle(){
				<?php
					if(isset($_POST["btnTimKiem"])){
				?>
						pos= new google.maps.LatLng(lat_center, lon_center);
						marker = new google.maps.Marker({
							position: pos,
							map: map
						});
						markers.push(marker);
						
						//Add circle into googlemap
						Radius= bk * 1000;
						//alert(Radius);
						populationOptions = {
                                strokeColor: '#FF0000',
                                strokeOpacity: 0,
                                strokeWeight: 2,
                                map: map,
                                center: new google.maps.LatLng(lat_center, lon_center),
                                radius: Radius //don vi tinh bang met
                         };
                         //them circle vao map    
                         currentPosition = new google.maps.Circle(populationOptions);
                         
                         google.maps.event.addListener(currentPosition, 'click', function(ev) {
							currentPosition.setMap(null);
							//removeMarker();
						});
						
						pos= new google.maps.LatLng(lat, lng);
						marker = new google.maps.Marker({
							position: pos,
							map: map
						});
						markers.push(marker);
						document.forms["frmHienThi"].txtLat.value=lat.toFixed(6);
						document.forms["frmHienThi"].txtLon.value=lng.toFixed(6); 
				<?php
					}
				?>
			}
			
			function showGD(){
				<?php
					$i=0;
					while($dulieu= mysql_fetch_array($result)){
						$nh_ten=$dulieu["nh_ten"];
						$name= $dulieu["gd_ten"];
						$addr= $dulieu["gd_diachi"];
						$gio=$dulieu["gd_giolamviec"];
						$lat= $dulieu["gd_lat"];
						$long=$dulieu["gd_lon"];
				?>
						var image = new google.maps.MarkerImage("icon/bank.png");
						var pos= new google.maps.LatLng( <?= $lat; ?>, <?= $long;?>);
						var marker = new google.maps.Marker({
							position: pos,
							map: map,
							icon: image,
							title: "Ngân hàng: <?= $nh_ten;?>\nĐiểm giao dịch: <?= $name; ?>\nĐịa chỉ: <?= $addr; ?>\nGiờ làm việc: <?= $gio;?>"
						});								
						<?php
								$i++;
							}
						?>
						google.maps.event.addListener(marker, 'click', function(event) {
							if(document.forms["frmHienThi"].txtLat.value!=""&&document.forms["frmHienThi"].txtLon.value!=""){
								showDirections(event);
							}
						});

			}
			
			function showATM(){
				<?php
					$i=0;
					while($dulieu= mysql_fetch_array($result1)){
						$nh_ten=$dulieu["nh_ten"];
						$name= $dulieu["atm_ten"];
						$addr= $dulieu["atm_diachi"];
						$lat= $dulieu["atm_lat"];
						$long=$dulieu["atm_lon"];
				?>
						var image = new google.maps.MarkerImage("icon/atm.png");
						var pos= new google.maps.LatLng( <?= $lat; ?>, <?= $long;?>);
						var marker = new google.maps.Marker({
							position: pos,
							map: map,
							icon: image,
							title: "Ngân hàng: <?= $nh_ten;?>\nTrạm ATM: <?= $name; ?>\nĐịa chỉ: <?= $addr; ?>"
						});								
				<?php
						$i++;
					}
				?>
						google.maps.event.addListener(marker, 'click', function(event) {
								if(document.forms["frmHienThi"].txtLat.value!=""&&document.forms["frmHienThi"].txtLon.value!=""){
									showDirections(event);
								}
						});
			}
			
			function showDirections(event){
				removePolyline();
				ans= confirm("Bạn muốn hiển thị chỉ dẫn đường đi, hay tất cả đường đi?\n Nhấn Ok để hiển thị chỉ dẫn đường đi.");
				if(ans==true){
					directionsDisplay.setPanel(document.getElementById('directions-panel'));
					calcRoute(event.latLng.lat(), event.latLng.lng());
				}
				else
					showRoutes(event.latLng.lat(), event.latLng.lng());
			}
			
			function removePolyline(){
				for(i=0;i<lines.length;i++){
					lines[i].setMap(null);
				}
				directionsDisplay.setMap(null);
				directionsDisplay.setPanel(null);
			}
			
			function calcRoute(lat_des, lon_des) {
			  var start = lat_center+","+lon_center;
			  var end = lat_des+","+lon_des;
			  var request = {
				  origin:start,
				  destination:end,
				  provideRouteAlternatives: true,
				  travelMode: google.maps.TravelMode.DRIVING
			  };
			  directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				  //calculating the distance
				  var route = response.routes[0];
				  var dis=0;
				  for (var i = 0; i < route.legs.length; i++) {
					  //alert(route.legs[i].distance.value);
					  dis+=route.legs[i].distance.value;
				  }
				  //if(dis<=(bk*1000)){
					  directionsDisplay.setMap(map);
					  directionsDisplay.setDirections(response);
				  //}
				}
			  });
			}
			
			function showRoutes(lat_des, lon_des){
				  var start = lat_center+","+lon_center;
				  var end = lat_des+","+lon_des;
				  var request = {
					  origin:start,
					  destination:end,
					  provideRouteAlternatives: true,
					  travelMode: google.maps.TravelMode.DRIVING
				  };
				  directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
					  map.fitBounds(response.routes[0].bounds);
					  createPolyline(response);
					}
				  });
			}
			function createPolyline(directionResult) {
				colors=["red", "blue", "green", "black", "yellow"];
				for(var i=0;i<directionResult.routes.length;i++){
						  var line = new google.maps.Polyline({
						  path: directionResult.routes[i].overview_path,
						  strokeColor: colors[i],
						  strokeOpacity: 0.5,
						  strokeWeight: 4
					  });

				  line.setMap(map);
				  lines.push(line);
				  /*google.maps.event.addListener(line, 'click', function(event) {
						alert(line.path);
				  });*/

				}
			}
			
			function checkValidate(){
				lat=document.forms["frmHienThi"].txtLat.value;
				lon=document.forms["frmHienThi"].txtLon.value;
				
				if(lat==""||lon==""){
					alert("Vui lòng click vào bản đồ chọn vị trí hiện tại của bạn");
					return false;
				}
				return true;
			}
			
		</script>
	</head>
	<body onload="loadMap();">
		<div id="templatemo_content_wrapper">
			<form method="POST" id="frmHienThi" name="frmHienThi" onsubmit="return checkValidate();">
				<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
					<tr>
						<td align="right">Chọn ngân hàng:</td>
						<td>
							<select name="cboNH">
								<option value="0">Tất cả</option>
								<?php
									while($dulieu=mysql_fetch_array($result2)){
								?>
										<option value="<?= $dulieu["nh_ma"]; ?>"><?= $dulieu["nh_ten"]; ?></option>
								<?php
									}
								?>
							</select>
						</td>
						<td  align="right">Nhập bán kính (km):</td>
						<td><input type="text" name="txtBanKinh" required="required" /></td>
						<td><input type="submit" name="btnTimKiem" value="Tìm kiếm" /></td>
					</tr>
					<tr>
						<td colspan="5" align="center">* Lưu ý: Click vào bản đồ để chọn vị trí hiện tại của bạn</td>
					</tr>
				</table>
				<hr>
				<div id="map-canvas"></div>
				<div id="directions-panel"></div>
				<input type="hidden" name="txtLat" required="" />
				<input type="hidden" name="txtLon" required="" />
			</form>
		</div>
	</body>
</html>

