<?php 
session_start();
session_unset();
sleep(2);
echo 'success';
?>