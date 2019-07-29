<?php
include_once("db_conn.php");
if (isset($_POST['mem_id'])){
    $m=$_POST['mem_id'];
}else{
    echo "傳入值為空值";
    exit;
};
$s=mysqli_query($link,"SELECT mem_state FROM member WHERE mem_id=$m");
$row=mysqli_fetch_array($s);
if($row[0]==1){
    echo "該會員已停權";
    exit;  
};
$q=mysqli_query($link,"UPDATE member SET mem_state=1 where mem_id=$m");//获取数据库的数据
if($q){
    echo 'success';
}
else{
echo mysqli_error($link);
};
?>