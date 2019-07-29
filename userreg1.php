<?php
//include("db_conn.php");  //include db connection 將來可能會用到
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>welcome!</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<script language="javascript">
$(function(){
    $('#submit').mouseover(function(){$(this).css({'background':'black'})});
    $('#submit').mouseout(function(){$(this).css({'background':'#5A2626'})});
});


function userreg(){
    <!--先取得欄位值-->
    var user_name = $('#user_name').val();
    var user_password = $('#user_password').val();
    var user_nkname = $('#user_nkname').val();
    var user_tel = $('#user_tel').val();
    var user_email = $('#user_email').val();
    var user_sex = $('#user_sex').val();
    const re = /^(([.](?=[^.]|^))|[\w_%{|}#$~`+!?-])+@(?:[\w-]+\.)+[a-zA-Z.]{2,63}$/;
    <!--判斷有無正確填寫-->
    if(user_name=="" && user_password==""){
        $('#error_msg').text('Please enter your ID & password');
        return false;
    }
    if(user_name==""){
        $('#error_msg').text('Please enter your ID');
        $('#user_name').focus();
        return false;
    }else if(user_password==""){
        $('#error_msg').text('Please enter your password');
        $('#user_password').focus();
        return false;
    }
    //if(re.test(user_email)==false||user_email==""){
       // $('#error_msg').text('Please check your email');
       // $('#user_email').focus();
      //  return false;
    //}
;
//真正的ajax動作從這裡開始
    $.ajax({
        url:"userreg_chk.php",
        data:"user_name="+user_name+"&user_password="+user_password"&user_nkname="+user_nkname"&user_tel="+user_tel"&user_email="+user_email"&user_sex="+user_sex,
        type : "POST",
        beforeSend:function(){
            $('#loading_div').show(); 
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg =="success"){
                $('#login_showname').text('Welcome!'+user_name);
                $('#login_success').text('You have successfully login!');
                $('#login_success').fadeIn();
                $('#error_msg').hide();
                $('#user_login').hide();     
                $('#user_logout').fadeIn();
                //如果成功登入，就不需要再出現登入表單，而出現登出表單    
            }else
            {    
                $('#error_msg').show();
                $('#error_msg').html('Please Login again,<br/>沒有此用戶或密碼不正確');
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
        },
        complete:function(){
            $('#loading_div').hide();
            //$('#user_login').hide();         
            //complete請求完成實執行的函式，不管是success或是error
        }
    });    
};
</script>
<body>
<div id="login_block">
    <form id="user_reg" method="POST">
    <table id="reg_table">
        <tr>
          <td>
           <label>帳號:</label><input type="text" name="user_name" id="user_name"/><br/> 
           <label>密碼:</label><input type="password" name="user_password" id="user_password"/><br/>
           <label>暱稱:</label><input type="text" name="user_nkname" id="user_nkname"/><br/> 
           <label>連絡電話:</label><input type="text" name="user_tel" id="user_tel"/><br/> 
           <label>email:</label><input type="text" name="user_email" id="user_email"/><br/> 
           <label>性別:</label><select name="user_sex">
           <option value=""></option>
　<option value="男">男</option>
　<option value="女">女</option>
</select><br/>  
           <input type='button' id='submit' value='確認' onclick='userreg();'/>
          </td>
        </tr>
    </table>
    </form>
    <div id="error_msg"></div>
    <div id="loading_div" style="display:none">
        <img src="ajax_loader.gif"><br/>Login...please wait
    </div>
    <div id="loadingout_div" style="display:none">
        <img src="ajax_loader.gif"><br/>Logout...please wait
    </div>
    <div id="login_success" style="display:none;">
    <!--放you are successfully login-->
    </div>
</div>
</body>
</html>
