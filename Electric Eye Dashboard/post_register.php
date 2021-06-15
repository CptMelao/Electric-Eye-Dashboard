<?php

include('db/config.php');

 if($_POST['post_password1'] == $_POST['post_password2']){	
        
        $post_user=$_POST['post_user'];
        $post_email=$_POST['post_email'];
        $post_password=$_POST['post_password1'];        
        $tipo='user';
    
               $sql = "Insert into login(utilizador,password,email,tipo) values ('$post_user','$post_password','$post_email','$tipo')";     
               $resultado = $conexao->query($sql);
        
                  if ($resultado) {
					$msg= "BemVindoÀnossaloja";      
                  } else {
                    $msg= "Erro ao fazer o registo, tente novamente";
                  }
				  
				$conexao->close();   
                
				echo "<script>window.location='index.php?msg=$msg'</script>";
				//header("Location: index.php"); /* Redirect browser */

              
	
 }else{	 
 
	 echo "Verificar passwords...";	 
 }

?>