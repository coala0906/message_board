<!DOCTYPE HTML>
<html>  
    <head> 
    <meta charset="UTF-8"> 
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script src="js/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
    </head> 
    <script language="javascript" script type="text/javascript">
    $(function(){
    $('#submit').mouseover(function(){$(this).css({'background':'black'})});
    $('#submit').mouseout(function(){$(this).css({'background':'#5A2626'})});
    $('#admlogout_block_fuclist').hide();
    $('#functionslct_block').hide(); 
    chkuser();  

});
function chkuser(){
    var session = "";
    if(session!=""){
       // alert("in chkuser!");
        $('#login_showname').text('Welcome!'+session);
                $('#login_success').text('You have successfully login!');
                $('#login_success').fadeIn();
                $('#error_msg_block').hide();   
                $('#admlogout_block_fuclist').fadeIn();
                $('#functionslct_block').fadeIn(); 
    }else{
        window.location.replace("admlogin.php");
        alert("尚未登入管理員");
    };
};
function admlogin(){
    <!--先取得欄位值-->
    var adm_name = $('#adm_name').val();
    var adm_password = $('#adm_password').val();
    <!--判斷有無正確填寫-->
    if(adm_name=="" && adm_password==""){
        error_alert('請輸入帳號與密碼');
        return false;
    }
    if(adm_name==""){
       error_alert('請輸入帳號');
        $('#adm_name').focus();
        return false;
    }else if(adm_password==""){
        error_alert('請輸入密碼');
        $('#adm_password').focus();
        return false;
    };
//真正的ajax動作從這裡開始
    $.ajax({
        url:"admlogin_chk.php",
        data:"adm_name="+adm_name+"&adm_password="+adm_password,
        type : "POST",
        beforeSend:function(){ 
            $('#loading_div').show(); 
            $('#admlogin_block').hide(); 
            $('#functionslct_block').hide(); 
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg =="success"){
                $('#loading_div').hide(); 
                $('#login_showname').text('Welcome!'+adm_name);
                $('#login_success').text('You have successfully login!');
                $('#admlogin_block').hide();  
                $('#functionslct_block').fadeIn();    
                //如果成功登入，就不需要再出現登入表單，而出現登出表單    
            }else
            {    
                $('#loading_div').hide(); 
                error_alert(msg);
                $('#admlogin_block').fadeIn(); 
                $('#functionslct_block').fadeIn(); 
                exit;
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
        },
        complete:function(){
            $('#admlogout_block').fadeIn();
            //complete請求完成實執行的函式，不管是success或是error
        }
    });    
};
function admlogout(){
    $.ajax({
        url:"logout.php",
        type : "POST",
        beforeSend:function(){
            $('#loadingout_div').show(); 
            $('#login_success').hide();
            $('#admlogout_block_fuclist').hide();
            $('#functionslct_block').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg=="success"){
                window.location.replace("admlogin.php");
            }else
            {    
            $('#admlogout_block_fuclist').fadeIn(); 
            $('#functionslct_block').fadeIn();
            $('#loadingout_div').hide();
               error_alert('請再登出一次');
                exit;
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
        },
        complete:function(){   
            $('#loadingout_div').hide(); 
        }
    });    
};
</script>
<div id=admlogout_block_fuclist>
<form id="admlogoutform" method="POST">
    <table id="login_table_out">
        <tr>
          <td>
            <span id="login_showname">
            <!--放登入狀態-->
            </span>
        </td>
        <td>
           <input type='button' id='submit2' value='Logout' onclick='admlogout();' /></td>
        </tr>
    </table>
    </form>
</div>
<div id="loadingout_div" style="display:none">
        Logout...please wait
    </div>
<div id="loading_div" style="display:none">
        Login...please wait
    </div>
<div id="functionslct_block">
<form id="functionslct_form">
          <tr>
          <td>
           <input type='button' id='submit' value='會員管理功能' onclick="location.href='admlogin.php'"/>
</td>
<td>
           <input type='button' id='submit' value='留言管理功能' onclick="location.href='admmsg.php'"/>
          </td>
        </tr>
</form>
</div>