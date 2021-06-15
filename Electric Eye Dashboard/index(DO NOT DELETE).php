<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>
	
    
	<!-- <link rel="stylesheet" href="css/shop-item.css">
	

  <!-- Bootstrap core CSS -->
   <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <!-- <link href="css/shop-item.css" rel="stylesheet">
  
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
	<link rel="stylesheet" type='text/css' href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type='text/css' href="vendor/bootstrap/css/bootstrap-webapp.css">
</head>

<body>
<?php
  include 'db/config.php';
  session_start();
?>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
	<a> </a>
      <a class="navbar-brand" href="#">Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Sobre nós</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Serviços</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contactos</a>
          </li>
		  
		  <?php		  
		  //echo $_SESSION['utilizador'];
		  if (isset($_SESSION['utilizador'])){		  
			  echo '<li class="nav-item">';
			  echo '<a class="nav-link" href="post_logout.php"><i class="fa fa-user-alt"></i>  Sair</a>';
			  echo '</li>';		  
		  }else{
			  echo '<li class="nav-item">';
			  echo '<a class="nav-link" href="#modallogin" data-toggle="modal" data-target="#modallogin"><i class="fa fa-user-alt"></i></a>';
			  echo '</li>';
		  }	  
		  ?>
		  
		  <li class="nav-item">		     
             <?php	
			 if (isset($_SESSION['idutilizador'])){			 
				 $idutilizador = $_SESSION['idutilizador'];				 
				 $sql = "select count(*) from carrimho where idutilizador ='$idutilizador'";
				 $resultado = $conexao->query($sql);
				 $num_rows = mysqli_fetch_row($resultado)[0];
				 //echo $num_rows;
			 			 
				 if ($num_rows > 0) {
					 echo '<li class="nav-item">';				 
					 echo '<a class="nav-link" href="carrinho.php"><i class="fa fa-cart-plus"></i></a>';
					 echo '</li>';
					 echo '<li class="nav-item">';	
					 echo'<span class="badge badge-light">'. $num_rows . '</span>';
				     echo '<li>';	
				  }
			 }
              ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-6">
        <h1 class="my-4">Dashboard</h1>
			<div style="width: 100%; height: 100px; float: left;"> 
		<table style="width:100%">
			<tr>
				<th><h3>System Info</h3></th>
			</tr>
			
		
		<?php
      $sql = "SELECT * from system_info";
		if ($resultado = $conexao->query($sql)) {
			
			while ($row = $resultado->fetch_assoc()) {
				$system = $row["system"];
				$node_name = $row["node_name"];
				$os_release = $row["os_release"];
				$version = $row["version"];
				$machine = $row["machine"]; 
				$processor = $row["processor"];
				
				echo $system.'<br />';
				echo $node_name.'<br />';
				echo $os_release.'<br />';
				echo $version.'<br />';
				echo $machine.'<br />';
				echo $processor.'<br />';
			}
		$resultado->free();
		}
		?>
			<tr>
				<th>System</th>
				<td><?php echo $system; ?></td>
			</tr>
			<tr>
				<th>Machine Name</th>
				<td><?php echo $node_name; ?></td>
			</tr>
			<tr>
				<th>Operating System</th>
				<td><?php echo $os_release; ?></td>
			</tr>
			<tr>
				<th>Version</th>
				<td><?php echo $version; ?></td>
			</tr>
			<tr>
				<th>Machine</th>
				<td><?php echo $machine; ?></td>
			</tr>
			<tr>
				<th>Processor</th>
				<td><?php echo $processor; ?></td>
			</tr>
		</table>
		  </div>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-6">
			<div style="width: 100%; height: 100px; float: left;"> 
		<table style="width:100%">
			<tr>
				<th><h3>System Info</h3></th>
			</tr>
			<tr>
				<th>System</th>
				<td><?php echo $system; ?></td>
			</tr>
			<tr>
				<th>Machine Name</th>
				<td><?php echo $node_name; ?></td>
			</tr>
			<tr>
				<th>Operating System</th>
				<td><?php echo $os_release; ?></td>
			</tr>
			<tr>
				<th>Version</th>
				<td><?php echo $version; ?></td>
			</tr>
			<tr>
				<th>Machine</th>
				<td><?php echo $machine; ?></td>
			</tr>
			<tr>
				<th>Processor</th>
				<td><?php echo $processor; ?></td>
			</tr>
		</table>
		  </div>
      </div>
  </div>
  <!-- /.container -->
  
  <!-- Modal -->
<div class="modal fade" id="modallogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>        
      </div>
      <div class="modal-body">
        <form class="modal-content animate" action="post_login.php" method="post">
			<div class="container">
			  <div class="form-group">
			  <label for="uname"><b>Email</b></label>
			  <input type="text" class="form-control" name="post_email" placeholder="Insira o utilizador" name="uname" required>
              </div>			  
			  <div class="form-group">
			  <label for="psw"><b>Password</b></label>
			  <input type="password" class="form-control" name="post_password" placeholder="Insira a Password" name="psw" required>
			  </div>
			  
			  <div class="form-group text-right">
			  <button type="submit" class="btn btn-primary">Login</button>
			  </div>
			</div>
		 </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <span class="psw">Não está registado <a href="register.php">Registe-se!</a></span>
	  </div>
    </div>
  </div>
</div>
  
  
  

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
