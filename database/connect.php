<?php 

  $connect = mysqli_connect('127.0.0.1', 'root', '', 'aviasales');

  if ($connect) {
    mysqli_query($connect, "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
  } else {
    header('Location: 404.php');
  }

?>