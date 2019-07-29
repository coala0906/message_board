<?php
//session_start();
/* -------------------------- */
/* Check username & password  */
/* -------------------------- */
include("db_conn.php");
sleep(1); 
$userid = isset($_POST["user_name"]) ? $_POST["user_name"] : $_GET["user_name"]; 
$userpassword = isset($_POST["user_password"]) ? $_POST["user_password"] : $_GET["user_password"]; 
$nkname = isset($_POST["user_nkname"]) ? $_POST["user_nkname"] : $_GET["user_nkname"]; 
$tel = isset($_POST["user_tel"]) ? $_POST["user_tel"] : $_GET["user_tel"]; 
$email = isset($_POST["user_email"]) ? $_POST["user_email"] : $_GET["user_email"]; 
$sex = isset($_POST["user_sex"]) ? $_POST["user_sex"] : $_GET["user_sex"];
if($userid==""){
echo "帳號傳入為空值";
exit;
}; 
if($userpassword==""){
    echo "密碼傳入為空值";
    exit;
}; 
if($nkname==""){
    echo "暱稱傳入為空值";
    exit;
}; 
if($tel==""){
    echo "連絡電話傳入為空值";
    exit;
}; 
if($email==""){
    echo "email傳入為空值";
    exit;
}; 
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
    echo "請檢查email格式";
    exit; 
};
$sql_slc = "SELECT * FROM member WHERE login_id = '$userid'";
$result_slc = mysqli_query($link,$sql_slc);
$record_count = mysqli_num_rows($result_slc); 
$stmt = $link->prepare("INSERT INTO member (login_id,login_pw,mem_name,tel,email,sex) VALUES (?,?,?,?,?,?)");
$password_enc = MD5($userpassword);   
mysqli_stmt_bind_param($stmt,"ssssss",$userid,$password_enc,$nkname,$tel,$email,$sex);
//$sql = "INSERT INTO member (login_id,login_pw,mem_name,tel,email,sex) VALUES ('$userid',MD5('$userpassword'),'$nkname','$tel','$email','$sex')";
if($record_count>0){
    echo '該帳號已被註冊';
}else{
if(mysqli_stmt_execute($stmt)){
//若有這筆資料則回傳success
$_SESSION['user_name'] = $userid;
echo 'success';
mysqli_stmt_close($stmt);
     };
};
mysqli_close($link);
?>