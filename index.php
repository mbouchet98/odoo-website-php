<!DOCTYPE html>
<html lang="en">
<head>
	<title>Démarche</title>
	<meta charset="UTF-8">
	<meta http-equiv="refresh"  url="index.php" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
            crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>
            <script src="leaflet-nominatim-example/js/map.js"></script>
            <link rel="stylesheet" href="leaflet-nominatim-example/js/leaflet.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="js/leaflet.ie.css" /><![endif]-->
		<link rel="stylesheet" type="text/css" href="leaflet-nominatim-example/site.css">

		<script src="js/leaflet.js"></script>
		<script src="js/jquery-1.8.2.min.js"></script>
<style type="text/css">

	

#map {
  height: 500px;
  width: 500px;
  /*background-color: red;*/
}

</style>
</head>
<body>

<?php 

	require_once('ripcord-master/ripcord.php');
	$url = 'http://10.0.1.59:8069';
	$db = 'odoo';
	$username = 'admin';
	$password = 'NTICNTIC$79';

	$common = ripcord::client("$url/xmlrpc/2/common");
	$common->version();

	$uid = $common->authenticate($db, $username, $password, array());

	$models = ripcord::client("$url/xmlrpc/2/object");



	$data = base64_encode(file_get_contents( $_FILES["file"]["tmp_name"] ));

	$idDoc = $models->execute_kw($db, $uid, $password,'ir.attachment', 'create',array(array('status'=>'valid','archived'=>false,'document_type_id'=>1,'name'=>$_FILES['file']['name'],'datas_fname'=>$_FILES['file']['name'],'res_field'=>'image','res_model'=>'image','datas'=>$data,'db_datas'=>$data)));


	$idAddress = $models->execute_kw($db, $uid, $password,'application.information', 'create',array(array('name'=>'Adresse','type'=>'text','mode'=>'result','value_text'=>$_POST['demo'])));

	//$idAddress = $models->execute_kw($db, $uid, $password,'application.information', 'create',array(array('name'=>'Adresse','type'=>'text','mode'=>'result','value_text'=>$_POST['addr'])));

	/*$test3 = json_encode($models->execute_kw($db, $uid, $password,'application.information', 'search_read', array(),array('fields'=> array('name','type','value_text','mode'))));
	$results3 = json_decode($test3, true);

	foreach ($results3 as $result3) {
		
			echo ''.$result3['id'].' / '.$result3['name'].' / '.$result3['type'].' / '.$result3['value_text'].' / '.$result3['mode'].'</br>';
		
	}*/
	if (!empty($_POST['demo'] &&  !empty('message') && !empty('file'))) {
		if ($_POST['demo']!==""&&$_POST['message']!==""&&$_FILES['file']['name']!=="") {
			# code...
			$id = $models->execute_kw($db, $uid, $password,'website.application', 'create',array(array('recipient_id'=>1,'website_application_template_id'=>6,'attachment_ids'=>array(array(4,$idDoc,false)),'application_information_ids'=>array(array(4,$idAddress,false)),'messages_ids'=>array(array(0,false,array('text'=>$_POST['message']))))));
			unset($_POST);
			unset($_FILES);

		}else{
			echo '<div class="alert alert-danger" role="alert">veuillez remplis tout les champs et selectionner l adresse </div>';
		}
		
	}
	else{
		echo '<div class="alert alert-danger" role="alert">veuillez remplis tout les champs et selectionner l adresse </div>';
	}
	unset($_POST);
	unset($_FILES);
		
 ?>

	<div class="bg-contact100" style="background-image: url('images/bg-01.jpg');">
		<div class="container-contact100">
			<div class="wrap-contact100">
				<div class="contact100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>
				<form class="contact100-form validate-form" method="post" enctype="multipart/form-data">

					<span class="contact100-form-title">
						Déclarer ma démarche
					</span>

					<div id="results" name="results"></div>
					<div class="wrap-input100 validate-input" data-validate = "search is required">
						<input class="input100" type="text" name="addr" placeholder="search" id="addr" >

						<span class="focus-input100"></span>

						<button class="btn btn-success" type="button" onclick="addr_search();">Search</button>  
					</div>
					<!--<div class="wrap-input100 input-group col-mb-12" >
					
					<div class="validate-input col-mb-6" data-validate = "search is required ">
						
						
						<input class="input100 form-control col-mb-6" type="text" name="addr" placeholder="search" id="addr" >
						 <span class="focus-input100"></span>
						
						<div class="input-group-append">
					      <button class="btn btn-success" type="button" onclick="addr_search();">Search</button>  

					    </div>
					</div>-->

						
					

					<div id="map"></div>
						<br>
						<div><input type="hidden" name="demo" id="demo"></div>
					<div class="form-group">
				      <input type="file" class="form-control-file border" name="file"  accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/png, image/jpeg,application/octet-stream">
				    </div>
					

					<div class="wrap-input100 validate-input" data-validate = "description is required">
						<textarea class="input100" name="message" placeholder="Description"></textarea>
						<span class="focus-input100"></span>
					</div>

					<div class="container-contact100-form-btn">
						<button class="contact100-form-btn" name="envois">
							Envoyer
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php  

	

	

	?>


<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->

</html>
