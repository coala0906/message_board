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
    $('#admreg_block').hide(); 
    $('#error_msg_block').hide();
    $('#admlogout_block').hide();
    $('#memberlist_block').hide();  
    $('#memberdata_block').hide(); 
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
                $('#admlogin_block').hide();     
                $('#admlogout_block').fadeIn();
                loadmember();
                $('#memberlist_block').fadeIn();
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
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg =="success"){
                $('#loading_div').hide(); 
                $('#login_showname').text('Welcome!'+adm_name);
                $('#login_success').text('You have successfully login!');
                $('#admlogin_block').hide();   
                window.location.replace("admfucslct.php");  
                //如果成功登入，就不需要再出現登入表單，而出現登出表單    
            }else
            {    
                $('#loading_div').hide(); 
                error_alert(msg);
                $('#admlogin_block').fadeIn(); 
                exit;
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
            $('#admlogin_block').fadeIn(); 
        },
        complete:function(){
            //$('#admlogout_block').fadeIn();
                // loadmember();
                //$('#memberlist_block').fadeIn();
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
            $('#error_msg').text('Logout...please wait..');
            $('#admlogout_block').hide();
            $('#memberlist_block').hide();
            $('#memberdata_block').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg=="success"){
                $('#admlogin_block').fadeIn();     
            }else
            {    
            $('#admlogout_block').fadeIn(); 
            $('#loadingout_div').hide();
            $('#memberlist_block').fadeIn();  
               error_alert('請再登出一次');
                exit;
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
            $('#memberlist_block').fadeIn();  
        },
        complete:function(){   
            $('#loadingout_div').hide(); 
        }
    });    
};
function admreg(msg){
    if(msg=="new"){
                $('#error_msg_block').hide();   
                $('#admlogin_block').hide();   
                $('#admreg_block').fadeIn(); }
    else if(msg=="submit"){
    <!--先取得欄位值-->
    var adm_reg_name = $('#adm_reg_name').val();
    var adm_reg_password = $('#adm_reg_password').val();
    var adm_reg_nkname = $('#adm_reg_nkname').val();
    var adm_reg_sex = $('#adm_reg_sex').val();
    <!--判斷有無正確填寫-->
    if(adm_reg_name=="" && adm_reg_password==""){
        error_alert('請輸入帳號與密碼');
        return false;
    };
    if(adm_reg_name==""){
        error_alert('請輸入帳號');
        $('#adm_reg_name').focus();
        return false;
    };
    if(adm_reg_password==""){
        error_alert('請輸入密碼');
        $('#adm_reg_password').focus();
        return false;
    };
    if(adm_reg_nkname==""){
        error_alert('請輸入暱稱');
        $('#adm_reg_password').focus();
        return false;
    };
    $.ajax({
        url:"admreg_chk.php",
        data:"adm_reg_name="+adm_reg_name+"&adm_reg_password="+adm_reg_password+"&adm_reg_sex="+adm_reg_sex+"&adm_reg_nkname="+adm_reg_nkname,
        type : "POST",
        beforeSend:function(){ 
            $('#login_success').hide();
            $('#admreg_block').hide();
            $('#user_logout').hide();
            $('#loading_div').show(); 
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg=="success"){
                $('#error_msg_block').hide();
                $('#admreg_block').hide();
                $('#admlogin_block').fadeIn();
            }else
            {    
               error_alert(msg);
               $('#admreg_block').fadeIn();
                $('#error_msg_block').hide();
              
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
            $('#admreg_block').fadeIn();
        },
        complete:function(){
            $('#loadingout_div').hide();
            $('#user_login').fadeIn(); 
            $('#loading_div').hide();     
        }
    });  
    };
};
function loadmember(){
var comments = $("#comments");
var loadlist_record = document.getElementById("loadlist_record").value;
//alert("loadmember:"+loadlist_record);
if (loadlist_record!="1"){
$.getJSON("memberlist.php", function(json) {
    document.getElementById("loadlist_record").value = "1";
                    $.each(json, function(index, array) {
                        if(array["state"]==0){var status = "正常";
                        }
                    else{var status = "已停權";
                        };
                        var txt = "<div class='panel panel-default'><div class='panel-heading'><strong class='panel-heading'>" +"會員帳號:"+ array["login_id"] + "</strong></div><table class='table rwd-table'><tr><td width='50%'>會員暱稱:" + array["name"]+ 
                        "</td><td width='50%'>聯絡方式:" + array["tel"] + "</td></tr><tr><td width='50%'>會員性別:"+ array["sex"] 
                        +"</td><td width='50%'>Email:"+ array["email"] +"</td></tr><tr><td width='50%'>會員狀態:" + status + "</td><td width='50%'></td></tr><tr><td width='50%'><input type='button' id='button_s' value='編輯會員資料' onclick='memdata("+array["id"]+");'/></td><td width='50%'><input type='button' id='button_s' value='停權該會員' onclick='memdel("+array["id"]+");'/></td></tr></table></div>";
                        comments.append(txt);
                    });
                });  
              };
};
function memdel(id){
//alert(id);
    $.ajax({
        url:"memdel_chk.php",
        data:"mem_id="+id,
        type : "POST",
        beforeSend:function(){ 
            //$('#login_success').hide();
           // $('#error_msg').text('please wait..');
           // $('#user_logout').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            
            if(msg=="success"){
                document.getElementById( "comments").innerHTML   =   " "//清空loadmember資料
                document.getElementById("loadlist_record").value = "2"; //讓loadmember function重新執行
                loadmember();
                alert("會員停權成功");
                //$('#error_msg_block').hide();
                //$('#admreg_block').hide();
                //$('#admlogin_block').fadeIn();
            }else
            {    
               alert(msg);
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
        },
        complete:function(){
           // $('#loadingout_div').hide();
           // $('#user_login').fadeIn();     
        }
    });  
};
function memdata(id){
    //alert(id);
       $('#memberlist_block').hide();
       $('#memberdata_block').fadeIn();
       document.getElementById("user_id").value = id;
       if(id==-1){
        document.getElementById("memberdata_h1").innerHTML="新增會員";
        document.getElementById("user_name").value = "";
        document.getElementById("user_nkname").value = "";
        document.getElementById("user_tel").value = "";
        document.getElementById("user_sex").value = "未填寫";
        document.getElementById("user_email").value = "";
       }else{
        document.getElementById("memberdata_h1").innerHTML="編輯會員資料";
       };
       $.getJSON("memberlist.php?mem_id="+ id, function(json) {
                    $.each(json, function(index, array) {
                        document.getElementById("user_name").value = array["login_id"];
                        document.getElementById("user_nkname").value = array["name"];
                        document.getElementById("user_tel").value = array["tel"];
                        document.getElementById("user_sex").value = array["sex"];
                        document.getElementById("user_email").value = array["email"];
                    });
                }); 
};
function returnlist(){
    window.location.assign(window.location.href);
};
function memupd(){
    $('#error_msg_block').hide();
    <!--先取得欄位值-->
    var user_name = $('#user_name').val();
    var user_password = $('#user_password').val();
    var user_nkname = $('#user_nkname').val();
    var user_tel = $('#user_tel').val();
    var user_email = $('#user_email').val();
    var user_sex = $('#user_sex').val();
    var user_id = $('#user_id').val();
    const re = /^(([.](?=[^.]|^))|[\w_%{|}#$~`+!?-])+@(?:[\w-]+\.)+[a-zA-Z.]{2,63}$/;
    <!--判斷有無正確填寫-->
    if(user_name==""){
        $('#user_name').focus();
       error_alert('請輸入帳號');
        return false;
    };
    if(user_nkname==""){
        $('#user_nkname').focus();
       error_alert('請輸入暱稱');
        return false;
    };
    if(user_tel==""){
        $('#user_tel').focus();
       error_alert('請輸入連絡電話');
        return false;
    };
    if(re.test(user_email)==false||user_email==""){
       error_alert('請檢查email');
        $('#user_email').focus();
        return false;
    };
    $.ajax({
        url:"memupd_chk.php",
        data:"mem_id="+user_id+"&user_name="+user_name+"&user_nkname="+user_nkname+"&user_tel="+user_tel+"&user_email="+user_email+"&user_password="+user_password+"&user_sex="+user_sex,
        type : "POST",
        beforeSend:function(){ 
            $('#error_msg_block').hide();
            //$('#login_success').hide();
           // $('#error_msg').text('please wait..');
           // $('#user_logout').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            
            if(msg=="success"){
                //document.getElementById("user_name")   =  user_name; 
                //document.getElementById("user_nkname")   =  user_nkname; 
                //document.getElementById("user_tel")   =  user_tel; 
                //document.getElementById("user_email")   =  user_email; 
                //document.getElementById("user_sex")   =  user_sex; 
                if(user_id==-1){
                    alert('新增成功');
                }else{
                   alert('修改成功');
              };
                
            }else
            {    
               error_alert(msg);
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
        },
        complete:function(){
           // $('#loadingout_div').hide();
           // $('#user_login').fadeIn();     
        }
    });  
};
function error_alert(err_msg){
    var insertDiv = document.getElementById("dialog")
    insertDiv.innerHTML = "<p>"+err_msg+"</p>";
    $( "#dialog" ).dialog({    
modal: true,
buttons: {
Ok: function() {
$( this ).dialog( "close" );
}
},
closeOnEscape: false,//按ESC不能關閉
  open: function(event, ui) {
    //隱藏「x」關閉按鈕
    $(this).parent().find('.ui-dialog-titlebar-close').hide();
  }
});
};
</script>
<body> 
    <div class="container">
<div id="admlogout_block" class="row">
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
           <td>
           <input type='button' id='submit2' value='新增會員' onclick='memdata(-1);' /></td>
           <td>
           <input type='button' id='submit2' value='回功能選單' onclick="location.href='admfucslct.php'" /></td>
        </tr>
    </table>
    </form>
    </div>
    </div>
    <div id="loadingout_div" style="display:none">
        Logout...please wait
    </div>

    <div id="admlogin_block">
    <form id="user_login" method="POST">
    <table id="login_table">
           <tr>
          <td><h1>管理者登入</h1></td>
        </tr>
        <tr>
          <td><label>帳號:</label><input type="text" name="adm_name" id="adm_name" class="form-control"/><br/></td>
        </tr>
        <tr>
        <td><label>密碼:</label><input type="password" name="adm_password" id="adm_password" class="form-control"/><br/></td>
        </tr>
        <tr>
        <td><input type='button' id='submit' value='登入' onclick='admlogin();'/></td>
        </tr>
        <tr>
        <td><input type='button' id='submit' value='註冊' onclick='admreg("new");'/></td>   
           </tr>
    </table>
    </form>
</div>
<div id="loading_div" style="display:none">
        Loading...please wait
    </div>
    <div id="admreg_block">
    <form id="adm_reg" method="POST">
    <table id="reg_table">
        <tr>
          <td><h1>管理者註冊</h1></td>
          </tr>
          <td>
           <label>*帳號:</label><input type="text" name="adm_reg_name" id="adm_reg_name" class="form-control"/><br/> 
           <label>*密碼:</label><input type="password" name="adm_reg_password" id="adm_reg_password" class="form-control"/><br/>
           <label>*暱稱:</label><input type="text" name="adm_reg_nkname" id="adm_reg_nkname" class="form-control"/><br/> 
           <label>性別:</label><select name="adm_reg_sex" id="adm_reg_sex" class="form-control">
           <option selected="true" value="未填寫">選擇性別</option>
　          <option value="男">男</option>
　              <option value="女">女</option>
                    </select><br/>
           <input type='button' id='submit' value='確認' onclick='admreg("submit");'/>
           <input type='button' id='submit' value='回登入頁面' onclick='returnlist();'/>
          </td>
        </tr>
    </table>
    </form>
</div>
<div id="error_msg_block">
<div id="error_msg"></div>
</div>
<div class="container">
<div id="memberlist_block" class="row">
    <input type="hidden" id="loadlist_record" name="loadlist_record">
<div id="comments"></div>
</div>
</div>
<div id="memberdata_block">
<form id="memberdata_form">
          <tr>
          <td>
            <h1 id="memberdata_h1"></h1><br/>
           <label>*帳號:</label><input type="text" name="user_name" id="user_name" class="form-control"/><br/> 
           <label>*密碼:</label><input type="password" name="user_password" id="user_password" class="form-control"/><br/>
           <label>*暱稱:</label><input type="text" name="user_nkname" id="user_nkname" class="form-control"/><br/> 
           <label>*連絡電話:</label><input type="text" name="user_tel" id="user_tel" class="form-control"/><br/> 
           <label>*email:</label><input type="text" name="user_email" id="user_email" class="form-control"/><br/> 
           <input type="hidden" name="user_id" id="user_id"/>
           <label>性別:</label><select name="user_sex" id="user_sex" class="form-control">
           <option selected="true" value="未填寫">選擇性別</option>
　          <option value="男">男</option>
　              <option value="女">女</option>
                    </select><br/>
           <input type='button' id='submit' value='確認' onclick='memupd();'/>
           <input type='button' id='submit' value='回列表' onclick='returnlist();'/>
          </td>
        </tr>
</form>
</div>
<div id="dialog" title="錯誤訊息"></div>
<body> 
</html>