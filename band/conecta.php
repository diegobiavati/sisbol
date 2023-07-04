<?php
    $server ="localhost";
    $user="root";
    $password="vertrigo";
    $dbname="cta";
    mysql_connect($server,$user,$password) or die(mysql_error());
    mysql_select_db($dbname) or die(mysql_error());
?>
 