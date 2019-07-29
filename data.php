<?php
include_once("db_conn.php");
if (isset($_GET['m_id'])){
    $m=$_GET['m_id'];
};
if(!is_numeric($m)){$comments[] = array("error_code"=>1,"reason"=>"m_id is not number"); echo json_encode($comments);exit;};//m_id傳入非數字則跳出
if ($m==-1){$comments[] = array("error_code"=>0); echo json_encode($comments);exit;};//新增留言
$q=mysqli_query($link,"select a.msg_id,a.parent_id,a.mem_id,a.msg_title,a.msg_txt,c.adm_name,a.mem_name guest_name,b.mem_name,a.tel,a.email,a.sex,a.add_time from message as a LEFT JOIN member as b ON a.mem_id=b.mem_id left join admin as c on a.adm_id=c.adm_id where a.msg_id=$m UNION all select a.msg_id,a.parent_id,a.mem_id,a.msg_title,a.msg_txt,c.adm_name,a.mem_name guest_name,b.mem_name,a.tel,a.email,a.sex,a.add_time from message as a LEFT JOIN member as b ON a.mem_id=b.mem_id left join admin as c on a.adm_id=c.adm_id where a.parent_id=$m and a.msgdel_flag='0' order by msg_id asc");//获取数据库的数据
while($row=mysqli_fetch_array($q)){
  $title = str_replace(array('<', '>'), array('&lt;', '&gt;'), $row['msg_title']);
  $txt = str_replace(array('<', '>'), array('&lt;', '&gt;'), $row['msg_txt']);
		$comments[] = array("id"=>$row['msg_id'],"mem_name"=>$row['mem_name'],"adm_name"=>$row['adm_name'],"guest_name"=>$row['guest_name'],"title"=>$title,"txt"=>$txt,"tel"=>$row['tel'],"email"=>$row['email'],"sex"=>$row['sex'],"time"=>$row['add_time'],"error_code"=>0);
}
if (mysqli_error($link)){
echo mysqli_error($link);
}else{
if(empty($comments)){
$comments[] = array("error_code"=>1,"reason"=>"no data found");
echo json_encode($comments);//以json格式编码
}else{    
echo json_encode($comments);//以json格式编码
  };
};
?>