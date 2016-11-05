<?php
   $servername = "localhost";
   $username = "root";
   $pwds = "mango592016";
   $dbname = "mangostore";

   $link = mysqli_connect($servername,$username,$pwds,$dbname);
   if(!$link)
   {
     die("Fail to connect Database: " . mysqli_connect_error());
   }
    //Change character set to utf8
    mysqli_set_charset($link,"utf8");
?>
