<?php
$link=mysqli_connect("localhost","root","rootadmin","message_board");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//mysqli_select_db("message_board");
mysqli_query($link,"SET NAMES 'utf8'");
//set taiwan zone
date_default_timezone_set("Asia/Taipei");
?>