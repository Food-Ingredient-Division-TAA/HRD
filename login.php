<!DOCTIPE html>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/icbplogo.png">

    <title>HRD | FID-TAA</title>

    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>
<style>
body{
	background:lightblue  url("assets/img/banner.jpg") no-repeat fixed center;
	background-size:100%;
}
</style>
<body>
<nav class="navbar navbar-default" style="background-color:#17A589;">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <a class="navbar-brand" style="color:#FFFFFF; font-weight:bold; border:1px;" href="./"><span><img width="160" src="assets/img/indofood-cbp.png"/> 
	        |&nbsp; HR MANAGEMENT SYSTEM</span></a>
    </div>
  </div>
</nav>

<div class="container">
	<div class="col-md-4 col-md-offset-4" >
		<div class="panel panel-danger">
			<div class="panel-heading" style="background-color:#17A589; color:white; font-weight:bold;">
				<h3 class="panel-title"> <b>LOGIN FORM</b></h3>
			</div>
			<div class="panel-body">
				<?php 
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$user	= isset($_POST['username'])?$_POST['username']:NULL;
					$pass	= isset($_POST['password'])?$_POST['password']:NULL;
					$p		= md5($pass);
					if($user=='' || $pass==''){
						?>
						<div class="alert alert-warning alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <?php
						  echo "<strong>Error!</strong> Form Belum Lengkap!!";
						  ?>
						</div>
						<?php
					}else{
						include "koneksi.php";
						$sqlLogin = mysqli_query($konek, "SELECT * FROM user WHERE username='$user' AND password=md5('$pass')");
						$jml=mysqli_num_rows($sqlLogin);
						$d=mysqli_fetch_array($sqlLogin);
						if($jml > 0){
							session_start();
							$_SESSION['login']		= TRUE;
							$_SESSION['id']			= $d['id_user'];
							$_SESSION['username']	= $d['username'];
							$_SESSION['nama_user']= $d['nama_user'];
							$_SESSION['level']= $d['level'];
							
							header('Location:./index.php');
						}else{
						?>
							<div class="alert alert-danger alert-dismissible" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							  <?php
							  echo "Maaf Username dan Password anda Belum Terdaftar!!!";
							  ?>
							</div>
						<?php
						}
						
					}
				}
				?>
				
				<form method="post" action="" role="form">
					<div class="form-group">
						<input type="text" class="form-control" name="username" autocomplete="off" placeholder="Username" />
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password" />
					</div>
					<div class="form-group">
						<input type="submit" style="background-color:#17A589;" class="btn btn-lg btn-primary btn-block" value="Login" />
					</div>
				</form>
				
			</div>

		</div> <!-- //panel -->
		</div>
</div>


	<footer class="footer" style="background:cream;">
      <div class="container">
        <p style="color:black; font-weight:bold;" class="text-muted"><a style="color:black; font-weight:bold;" href="https://indofood.com" target="_blank">Food Ingredients Division</a> 2022</p>
      </div>
    </footer>

<!-- Bootstrap core JavaScript -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
