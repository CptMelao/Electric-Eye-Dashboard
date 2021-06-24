<?php
   session_start();
   include("db/config.php");   
   if (empty($_POST['post_username']) OR empty($_POST['post_password'])) {
    $msg = "Insira o utilizador e password";
    echo "<script>window.location = 'index.php?msg=$msg'</script>"; exit;
}
    $myusername = $_POST['post_username'];
    $mypassword =  $_POST['post_password'];
     
    $sql = "SELECT * FROM login WHERE username='$myusername' AND password='$mypassword' ";
       
     $resultado = $conexao->query($sql);  
     	 
      if ($resultado->num_rows > 0) {      
           $r = $resultado->fetch_assoc();  
		   $_SESSION['serial_disk'] = $r['serial_disk'];
		   $_SESSION['serial_global'] = $r['serial_global'];
           $_SESSION['username'] = $r['username'];
		   $_SESSION['id_login'] = $r['id_login'];		  
		   $_SESSION['type'] = $r['type']; 		   
           header('location:index.php');		   
      } else {
           $msg = "Utilizador e/ou password incorretos ";
           echo "<script>window.location = 'index.php?msg=$msg'</script>";exit;
      } 
      if ( $r['type']=='admin') {
       header('location:admin_panel.php');
      } else {
      header('location:dashboard.php');
      }      
	  
?>