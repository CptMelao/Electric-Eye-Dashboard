<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>EED</title>
	
  <!-- Bootstrap core CSS -->
   <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="vendor/bootstrap/css/bootstrap-webapp.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-item.css" rel="stylesheet">
 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	
</head>

<?php
  include 'db/config.php';
  session_start();
?>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
	<a> </a>
      <a class="navbar-brand" href="#">Electric Eye Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Admin Panel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_dashboard.php">Admin Dashboard
              <span class="sr-only">(current)</span>
			</a>
          </li>
			 <?php		  
		  //echo $_SESSION['utilizador'];
		  if (isset($_SESSION['username'])){		  
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
			 if (isset($_SESSION['id_login'])){			 
				 $idutilizador = $_SESSION['id_login'];				 
				 $sql = "select count(*) from login where id_login ='$idutilizador'";
				 $resultado = $conexao->query($sql);
				 $num_rows = mysqli_fetch_row($resultado)[0];
				 //echo $num_rows;
			 }
              ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  
<div class="container" style="padding-top: 20px">
  <div class="row">   
    <div class="col-lg-12">
		<div class="container-fluid px-4">
            <h3 class="mt-4">Machine Info</h3>
                    <div class="card-body">
                        <table class="table table-hover table-sm noborderattop">
                            <thead>
							  <tr>
								<th>
									<span>Utilizador</span>
								</th>
			                </thead>
							<tbody>
						
                                <?php
								$sql = "Select * from login";    
								$resultado =$conexao->query($sql);
								if ($resultado->num_rows >0) {
									while ($var = $resultado->fetch_assoc()){ 
									echo'<tr> 
									<td><a href="admin_dashboard.php?id='.$var['id_login'].'" >'.$var['username'].'<a></td>
									</tr>';
									}
										}
										$conexao->close();
								?>
							</tbody> 
                        </table>
                    </div>
                </div>
        </div>
    </div>
				
  <!-- /.container -->

  <!-- modal -->
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
