<?php
session_start();
/* -------------------------- */
/* Check username & password  */
/* -------------------------- */
include("db_conn.php");
sleep(1); 
$userid = isset($_POST["user_name"]) ? $_POST["user_name"] : $_GET["user_name"]; 
$password = isset($_POST["user_password"]) ? $_POST["user_password"] : $_GET["user_password"]; 
if($stmt = $link->prepare("SELECT login_id,mem_state,sex,mem_id,tel,email,mem_name FROM member WHERE login_id = ? and login_pw = ?")){
$password_enc =  MD5($password);   
mysqli_stmt_bind_param($stmt,"ss",$userid,$password_enc);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $login_id,$mem_state,$sex,$mem_id,$tel,$email,$mem_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if($login_id==""){
  //無資料回傳no data
    echo '帳號或密碼錯誤';
}else if($mem_state==1){
  //停權會員
   echo '該會員已停權';
}else{
   //若有這筆資料則回傳success
    $_SESSION['user_name'] = $userid;
    $_SESSION['user_nkname'] = $mem_name;
    $_SESSION['mem_id'] = $mem_id;
    $_SESSION['tel'] = $tel;
    $_SESSION['email'] = $email;
    $_SESSION['user_sex'] = $sex;
    echo 'success';
}; 
};
mysqli_close($link);
?>