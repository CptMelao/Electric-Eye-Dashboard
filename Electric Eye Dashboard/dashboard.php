<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="refresh" content="5">
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
			if (isset($_SESSION['id_login'])) {
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
  
  <!-- Page Content -->
  <div class="container" style="padding-top: 20px">
	<div class="row"> 
	   <div class="col-lg-6" style="padding-bottom: 20px">
		  <div class="card">
		    <div class="card-header">
			  <span class="lang_002">System Info</span>
			</div>
			<div class="card-body">
			 <div class="table-responsive">
			   <table class="table table-hover table-sm noborderattop">
			    <tbody>
			<?php
		$sql = "SELECT * from login WHERE id_login = '$idutilizador'";
		if ($resultado = $conexao->query($sql)) {	
			while ($row = $resultado->fetch_assoc()) {
				$serial_global = $row["serial_global"];
			}
		$resultado->free();
		}	
			
		$sql = "SELECT * from boot_info WHERE serial_boot LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {	
			while ($row = $resultado->fetch_assoc()) {
				$day = $row["day"];
				$month = $row["month"];
				$year = $row["year"];
				$hour = $row["hour"]; 
				$minute = $row["minute"]; 
				$second = $row["second"]; 
			}
		$resultado->free();
		}
		
		$sql = "SELECT * from system_info WHERE serial_system LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {
			while ($row = $resultado->fetch_assoc()) {
				$system = $row["system"];
				$node_name = $row["node_name"];
				$os_release = $row["os_release"];
				$version = $row["version"];
				$machine = $row["machine"]; 
				$system_language = $row["system_language"];
				$processor = $row["processor"];
			}
		$resultado->free();
		}
		?>
			<tr>
				<th>System</th>
				<td><?php echo $system."\n".$os_release; ?></td>
			</tr>
			<tr>
				<th>Machine Name</th>
				<td><?php echo $node_name; ?></td>
			</tr>
			<tr>
				<th>Kernel Version</th>
				<td><?php echo $version; ?></td>
			</tr>
			<tr>
				<th>Machine</th>
				<td><?php echo $machine; ?></td>
			</tr>
			<tr>
				<th>Last Boot</th>
				<td><?php echo $day."/".$month."/".$year."\n".$hour.":".$minute.":".$second; ?></td>
			</tr>
			<tr>
				<th>System Language</th>
				<td><?php echo $system_language; ?></td>
			</tr>
			<tr>
				<th>Processor</th>
				<td><?php echo $processor; ?></td>
			</tr>
		  </tbody>
		</table>
     </div>   
    </div>  
   </div>
  </div>
  
  <div class="col-lg-6" style="padding-bottom: 20px">
		  <div class="card">
		    <div class="card-header">
			  <span class="lang_002">CPU Info</span>
			</div>
			<div class="card-body">
			 <div class="table-responsive">
			   <table class="table table-hover table-sm noborderattop">
			    <tbody>
			<?php
		$sql = "SELECT * from cpu_info WHERE serial_cpu LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {	
			while ($row = $resultado->fetch_assoc()) {
				$cpu_name = $row["cpu_name"];
				$physical_cores = $row["physical_cores"];
				$total_cores = $row["total_cores"];
				$cpu_freq_max = $row["cpu_freq_max"]; 
				$cpu_freq_min = $row["cpu_freq_min"]; 
				$cpu_freq_current = $row["cpu_freq_current"]; 
			}
		$resultado->free();
		}
		?>
			<tr>
				<th>CPU Name</th>
				<td><?php echo $cpu_name; ?></td>
			</tr>
			<tr>
				<th>Physical Cores</th>
				<td><?php echo $physical_cores; ?></td>
			</tr>
			<tr>
				<th>Total Cores</th>
				<td><?php echo $total_cores; ?></td>
			</tr>
			<tr>
				<th>CPU Maximum Frequency</th>
				<td><?php echo $cpu_freq_max; ?>MHz</td>
			</tr>
			<tr>
				<th>CPU Minimum Frequency</th>
				<td><?php echo $cpu_freq_min; ?>MHz</td>
			</tr>
			<tr>
				<th>CPU Current Frequency</th>
				<td><?php echo $cpu_freq_current; ?>MHz</td>
			</tr>
		  </tbody>
		</table>
     </div>   
    </div>  
   </div>
  </div>
 
 <div class="col-lg-12" style="padding-bottom: 20px">
		  <div class="card">
		    <div class="card-header">
			  <span class="lang_002">GPU Info</span>
			</div>
			<div class="card-body">
			 <div class="table-responsive">
			   <table class="table table-hover table-sm noborderattop">
			   <thead>
				<tr>
				  <th>
				    <span>Name</span>
				  </th>
				  <th>
				    <span>Load</span>
				  </th>
				  <th>
				    <span>Free</span>
				  </th>
				  <th>
				    <span>Used</span>
				  </th>
				  <th>
				    <span>Total</span>
				  </th>
				  <th>
				    <span>Temperature</span>
				  </th>
				</tr>
			   </thead>
			   <tbody>
			 <?php
			$sql = "SELECT * from gpu_info WHERE serial_gpu LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {	
			$m=0;
			while ($row = mysqli_fetch_array($resultado)) {
			echo "<tr>
			<td>".$row["gpu_name"]."</td>
			<td>".$row["gpu_load"]."</td>
			<td>".$row["gpu_free_memory"]."MB"."</td>
			<td>".$row["gpu_used_memory"]."MB"."</td>
			<td>".$row["gpu_total_memory"]."MB"."</td>
			<td>".$row["gpu_temperature"]."ºC</td>
			</tr>";
			$m++; 
				$gpu_name = $row["gpu_name"];
				$gpu_load = $row["gpu_load"];
				$gpu_free_memory = $row["gpu_free_memory"]; 
				$gpu_used_memory = $row["gpu_used_memory"]; 
				$gpu_total_memory = $row["gpu_total_memory"]; 
				$gpu_temperature = $row["gpu_temperature"]; 
			}
		$resultado->free();
		}
		?>
		  </tbody>
		</table>
     </div>   
    </div>  
   </div>
  </div>
  
   <div class="col-lg-12" style="padding-bottom: 20px">
		  <div class="card">
		    <div class="card-header">
			  <span class="lang_002">Disk Info</span>
			</div>
			<div class="card-body">
			 <div class="table-responsive">
			   <table class="table table-hover table-sm noborderattop">
			   <thead>
				<tr>
				  <th>
				    <span>Mountpoint</span>
				  </th>
				  <th>
				    <span>Type</span>
				  </th>
				  <th>
				    <span>Total</span>
				  </th>
				  <th>
				    <span>Used</span>
				  </th>
				  <th>
				    <span>Free</span>
				  </th>
				  <th>
				    <span>Used %</span>
				  </th>
				</tr>
			   </thead>
			   <tbody>
			 <?php
			$sql = "SELECT * from disk_info WHERE serial_disk LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {	
			$k=0;
			while ($row = mysqli_fetch_array($resultado)) {
			echo "<tr>
			<td>".$row["mountpoint"]."</td>
			<td>".$row["file_type"]."</td>
			<td>".$row["total_size"]."</td>
			<td>".$row["total_used"]."</td>
			<td>".$row["total_free"]."</td>
			<td>". $row["used_percentage"]."%</td>
			</tr>";
			$k++; 	
				$mountpoint = $row["mountpoint"];
				$file_type = $row["file_type"];
				$total_size = $row["total_size"]; 
				$total_used = $row["total_used"]; 
				$total_free = $row["total_free"]; 
				$used_percentage = $row["used_percentage"]; 
			}
			$resultado->free();
			}
			?>
		  </tbody>
		</table>
     </div>   
    </div>  
   </div>
  </div>
  
  <div class="col-lg-6" style="padding-bottom: 20px">
		  <div class="card">
		    <div class="card-header">
			  <span class="lang_002">Memory Info</span>
			</div>
			<div class="card-body">
			 <div class="table-responsive">
			   <table class="table table-hover table-sm noborderattop">
			    <tbody>
			<?php
		$sql = "SELECT * from memory_info WHERE serial_memory LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {	
			while ($row = $resultado->fetch_assoc()) {
				$mem_total = $row["mem_total"];
				$mem_available = $row["mem_available"];
				$mem_used = $row["mem_used"];
				$mem_used_percent = $row["mem_used_percent"]; 
			}
		$resultado->free();
		}
		?>
			<tr>
				<th>Total</th>
				<td><?php echo $mem_total; ?></td>
			</tr>
			<tr>
				<th>Available</th>
				<td><?php echo $mem_available; ?></td>
			</tr>
			<tr>
				<th>Used</th>
				<td><?php echo $mem_used; ?></td>
			</tr>
			<tr>
				<th>Used %</th>
				
				<td><?php echo $mem_used_percent; ?>%</td>
			</tr>
		  </tbody>
		</table>
     </div>   
    </div>  
   </div>
  </div>
  
  <div class="col-lg-6" style="padding-bottom: 20px">
		  <div class="card">
		    <div class="card-header">
			  <span class="lang_002">Network Info</span>
			</div>
			<div class="card-body">
			 <div class="table-responsive">
			   <table class="table table-hover table-sm noborderattop">
			    <tbody>
			<?php
		$sql = "SELECT * from network_info WHERE serial_network LIKE '$serial_global'";
		if ($resultado = $conexao->query($sql)) {	
			while ($row = $resultado->fetch_assoc()) {
				$ip_address = $row["ip_address"];
				$mac_address = $row["mac_address"];
				$total_sent = $row["total_sent"];
				$total_received = $row["total_received"]; 
			}
		$resultado->free();
		}
		?>
			<tr>
				<th>IP Address</th>
				<td><?php echo $ip_address; ?></td>
			</tr>
			<tr>
				<th>MAC Address</th>
				<td><?php echo $mac_address; ?></td>
			</tr>
			<tr>
				<th>Total Sent</th>
				<td><?php echo $total_sent; ?></td>
			</tr>
			<tr>
				<th>Total Received</th>
				<td><?php echo $total_received; ?></td>
			</tr>
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
