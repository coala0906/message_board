<?php
include_once("db_conn.php");
if (isset($_GET['mem_id'])){
    $m=$_GET['mem_id'];
}else{
	$m="";
};
if ($m!=""){
	$q=mysqli_query($link,"SELECT * FROM member WHERE mem_id=$m");//获取数据库的数据
}else{
$q=mysqli_query($link,"SELECT * FROM member");//获取数据库的数据
};
while($row=mysqli_fetch_array($q)){
		$comments[] = array("id"=>$row['mem_id'],"login_id"=>$row['login_id'],"name"=>$row['mem_name'],"tel"=>$row['tel'],"email"=>$row['email'],"state"=>$row['mem_state'],"sex"=>$row['sex']);
}
if (mysqli_error($link)){
echo mysqli_error($link);
}else{
echo json_encode($comments);//以json格式编码

};
?>