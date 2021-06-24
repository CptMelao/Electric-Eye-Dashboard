<?php
    $servidor = 'remotemysql.com';
    $utilizador = 'akG9Dvp8mp';
    $password = 'daQAeSuxgJ';
    $basededados = 'akG9Dvp8mp';

    $conexao = mysqli_connect($servidor, $utilizador, $password, $basededados);

    if ($conexao -> connect_error) {
      die("Erro ao ligar à base de dados: " .$conexao -> connect_error);
    }
    mysqli_set_charset($conexao, "utf8");
?>