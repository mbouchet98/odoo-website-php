<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Odoo Login</title>
  
  
  
      <link rel="stylesheet" href="style.css">

  
</head>

<body>
	<?php
    require_once('ripcord-master/ripcord.php');
	$url = 'http://10.0.1.59:8069';
	$db = 'odoo';
	$username = $_POST['login'];
	$password = $_POST['password'];

	$common = ripcord::client("$url/xmlrpc/2/common");
	$common->version();

	$uid = $common->authenticate($db, $username, $password, array());

	if ($uid == "") {
		echo "Veuillez verifier que vous êtes bien un utilisateur, on si votre mot de passe et/ou identifiant sont correcte";
	}else{
		 echo $uid; 
 		 
 		 header('Location: ContactFrom_v12/index.php'); 

	}

	$models = ripcord::client("$url/xmlrpc/2/object");
    

   
	?>
  <div class="panda">
  	
  <div class="ear"></div>
  <div class="face">
    <div class="eye-shade"></div>
    <div class="eye-white">
      <div class="eye-ball"></div>
    </div>
    <div class="eye-shade rgt"></div>
    <div class="eye-white rgt">
      <div class="eye-ball"></div>
    </div>
    <div class="nose"></div>
    <div class="mouth"></div>
  </div>
  <div class="body"> </div>
  <div class="foot">
    <div class="finger"></div>
  </div>
  <div class="foot rgt">
    <div class="finger"></div>
  </div>
</div>
<form action="index.php" method="post">
  <div class="hand"></div>
  <div class="hand rgt"></div>
  <h1>Odoo Login</h1>
  
  <div class="form-group">
    <input required="required" class="form-control" name="login"/>
    <label class="form-label">Username    </label>
  </div>
  <div class="form-group">
    <input id="password" type="password" required="required" class="form-control" name="password"/>
    <label class="form-label">Password</label>
    <p class="alert">Invalid Credentials..!!</p>
    <button class="btn">Login </button>
  </div>
</form>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  

    <script  src="./script.js"></script>




</body>

</html>
