<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理員留言</title>
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script src="js/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<script language="javascript" script type="text/javascript">
$(function(){
    var m = -1;
    $('#submit').mouseover(function(){$(this).css({'background':'black'})});
    $('#submit').mouseout(function(){$(this).css({'background':'#5A2626'})});
    $('#admreg_block').hide(); 
    $('#error_msg_block').hide();
    $('#admlogin_block').hide();
    $('#admlogout_block').hide();
    $('#userpost_form_block').hide();
    $('#msglist_block').hide();
    chkuser();  
    if(m==-1){
    document.getElementById( 'userpost_form_h1' ).innerHTML = "發表留言";
    }else{
    document.getElementById( 'userpost_form_h1' ).innerHTML = "回覆留言";
    };
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
                $('#userpost_form_block').fadeIn();
                loadmessage();
                $('#msglist_block').fadeIn();
                document.getElementById( 'adm_nkname' ).value = '';
                document.getElementById( 'adm_sex' ).value = '';
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
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg =="success"){
                $('#loading_div').hide(); 
                $('#login_showname').text('Welcome!'+adm_name);
                $('#login_success').text('You have successfully login!');
                $('#admlogin_block').hide();     
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
            $('#admlogout_block').hide();
            $('#msglist_block').hide();
            $('#userpost_form_block').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg=="success"){
                window.location.replace("admlogin.php");
            }else
            {    
            $('#admlogout_block').fadeIn(); 
            $('#msglist_block').fadeIn();
            $('#userpost_form_block').fadeIn();
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
function refresh_code(){ 
           document.getElementById("imgcode").src="captcha.php"; 
};
function postData(){
    const re = /^(([.](?=[^.]|^))|[\w_%{|}#$~`+!?-])+@(?:[\w-]+\.)+[a-zA-Z.]{2,63}$/;
    var name = $('#adm_nkname').val();
    var sex = $('#adm_sex').val();
    var title = $('#title').val();
    var message = $('#message').val();
    var checkword = $('#checkword').val();
    var mid = $('#mid').val();
    var dataString = "nkname="+ name + "&title=" + title + "&message=" + message + "&sex=" + sex + "&checkword=" + checkword + "&mid=" + mid;
    <!--判斷有無正確填寫-->
    if(name==""){
        error_alert('請輸入暱稱');
        $('#nkname').focus();
        return false;
    };
    if(title==""){
        error_alert('請輸入留言主題');
        $('#title').focus();
        return false;
    };
    if(message==""){
        error_alert('請輸入留言內容');
        $('#message').focus();
        return false;
    };
    if(checkword==""){
        error_alert('請檢查驗證碼');
        $('#checkword').focus();
        return false;
    };
    $.ajax({  
        type: "POST",  
         url: "post.php",  
        data: dataString,   
         success: function(data) {
              console.log('OK: ' + data);  
              if (data>=1){
                window.location.assign(window.location.href);
              }else if(data==0){
                window.location.replace("admmsg.php");
              }else{
                error_alert(data);
              }; 
        },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + data);
         }
      });
    return true;
};
function loadmessage(){
var comments = $("#comments");
$.getJSON("data.php?m_id=-1", function(json) {
                    $.each(json, function(index, array) {
                        if(array["mem_name"]!=null){ var txt = "<div class='panel panel-default'><div class='panel-heading'><input type='text' class='form-control' name='title' id='user_title"+array["id"]+"' value='"+array["title"]+"'></div><table class='table'><tr><td width='50%'>會員_" +array["mem_name"] + ":<textarea class='form-control' name='user_message' id='user_message"+array["id"]+"'>"+ array["txt"] +"</textarea></td><td width='50%'>" +  array["time"] + "<br/><input type='button' id='button_s' value='確認修改' onclick='admmsgupd("+array["id"]+");'/><br/><input type='button' id='button_s' value='確認刪除' onclick='admmsgdel("+array["id"]+");'/></td></tr></div>";};
                        if(array["guest_name"]!=null){ var txt = "<div class='panel panel-default'><div class='panel-heading'><input type='text' class='form-control' name='title' id='user_title"+array["id"]+"' value='"+array["title"]+"'></div><table class='table'><tr><td width='50%'>訪客_" +array["guest_name"] + ":<textarea class='form-control' name='user_message' id='user_message"+array["id"]+"'>"+ array["txt"] +"</textarea></td><td width='50%'>" +  array["time"] + "<br/><input type='button' id='button_s' value='確認修改' onclick='admmsgupd("+array["id"]+");'/><br/><input type='button' id='button_s' value='確認刪除' onclick='admmsgdel("+array["id"]+");'/></td></tr></div>";};
                        if(array["adm_name"]!=null){ var txt = "<div class='panel panel-default'><div class='panel-heading'><input type='text' class='form-control' name='title' id='user_title"+array["id"]+"' value='"+array["title"]+"'></div><table class='table'><tr><td width='50%'>管理員_" +array["adm_name"] + ":<textarea class='form-control' name='user_message' id='user_message"+array["id"]+"'>"+ array["txt"] +"</textarea></td><td width='50%'>" +  array["time"] + "<br/><input type='button' id='button_s' value='確認修改' onclick='admmsgupd("+array["id"]+");'/></td></tr></div>";};
                       if(array["error_code"]=="1"){window.location.replace('admmsg.php?p=1');};
                       comments.append(txt);
                    });
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
function admmsgupd(id){
    var title = $('#user_title'+id).val();
    var message = $('#user_message'+id).val();
    var dataString = "mid="+ id + "&title=" + title + "&message=" + message;
    <!--判斷有無正確填寫-->
    if(title==""){
        error_alert('請輸入留言主題');
        $('#title').focus();
        return false;
    };
    if(message==""){
        error_alert('請輸入留言內容');
        $('#message').focus();
        return false;
    };
    $.ajax({  
        type: "POST",  
         url: "admmsgupd_chk.php",  
        data: dataString,   
         success: function(data) {
              console.log('OK: ' + data);  
              if (data=='success'){
                alert("留言修改成功");
              }else{
                alert(data);
              }; 
        },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + data);
         }
      });
    return true;
};
function admmsgdel(id){
    var dataString = "mid="+ id;
    $.ajax({  
        type: "POST",  
         url: "admmsgdel_chk.php",  
        data: dataString,   
         success: function(data) {
              console.log('OK: ' + data);  
              if (data=='success'){
                alert("留言刪除成功");
                window.location.assign(window.location.href);
              }else{
                alert(data);
              }; 
        },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + data);
         }
      });
    return true;
};
</script>
<body>
    <div class="container">
<div id=admlogout_block class="row">
    <table id="login_table_out" class="rwd-trble">
        <tr>
          <td>
            <span id="login_showname">
            <!--放登入狀態-->
            </span>
        </td>
        <td>
           <input type='button' id='submit2' value='Logout' onclick='admlogout();' /></td>
           <td>
           <input type='button' id='submit2' value='回留言列表' onclick="location.href='admmsg.php'" /></td>
           <td>
           <input type='button' id='submit2' value='回功能選單' onclick="location.href='admfucslct.php'" /></td>
        </tr>
    </table>
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
        Login...please wait
    </div>
    <div class="container">
    <div id="msglist_block" class="row">
    <div id="comments" class="col-md-9 col-md-offset-1"></div>
</div>
</div>
<div id="dialog" title="錯誤訊息"></div>
<div id="f_error_msg_block">
    <div id="error_msg"></div></div>
    <div class="container">
    <div class="userpost_form_block row" id="userpost_form_block">
        <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-default"><div class="panel-heading"><strong class="panel-heading">
            <h1 id="userpost_form_h1"></h1></strong></div>
            <table class="table rwd-table">
            <tr><td><label for="adm_nkname" class="control-label">*暱稱</label>
           <input name="adm_nkname" class="form-control" type="text" id="adm_nkname"/></td>
           <td><label for="adm_sex" class="control-label">性別</label>
            <select class="form-control" name="adm_sex" id="adm_sex">
                <option selected="true" value="未填寫">選擇性別</option>
　              <option value="男">男</option>
　              <option value="女">女</option>
                    </select></td></tr>
           <tr><td><label for="title" class="control-label">*留言主題</label><textarea class="form-control" name="title" id="title"></textarea></td>
            <td><label for="message" class="control-label">*留言內容</label><textarea class="form-control" name="message" id="message"></textarea></td></tr>
               <input name="mid" type="hidden" id="mid" value="-1"/>
              <tr><td><label for="checkword" class="control-label"> 點擊圖片可以更換驗證碼</label><img id="imgcode" src="captcha.php" onclick="refresh_code()" /></td>
              <td><label for="imgcode" class="control-label"> 請輸入圖中字樣(不區分大小寫)：</label>
              <input type="text" class="form-control" name="checkword" id="checkword" size="10" maxlength="10"/></td></tr>
                <tr><td><input type='button' id='submit2' value='送出' onclick='postData();'/></td><td></td></tr>
                </table>
            </div>
</div>
</div>
</div>
    </div>
<div style="text-align: right;position: fixed;z-index:9999999;bottom: 0;width: auto;right: 1%;cursor: pointer;line-height: 0;display:block !important;"><a title="Hosted on free web hosting 000webhost.com. Host your own website for FREE." target="_blank" href="https://www.000webhost.com/?utm_source=000webhostapp&utm_campaign=000_logo&utm_medium=website&utm_content=footer_img"><img src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png" alt="www.000webhost.com"></a></div><script>function getCookie(e){for(var t=e+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}getCookie("hostinger")&&(document.cookie="hostinger=;expires=Thu, 01 Jan 1970 00:00:01 GMT;",location.reload());var notification=document.getElementsByClassName("notice notice-success is-dismissible"),hostingerLogo=document.getElementsByClassName("hlogo"),mainContent=document.getElementsByClassName("notice_content")[0],newList=["Powerful and Easy-To-Use Control Panel.","1-Click Auto Installer and 24/7 Live Support.","Free Domain, Email and SSL Bundle.","5x faster WordPress performance","Weekly Backups and Fast Response Time."];if(0<notification.length&&null!=mainContent){var googleFont=document.createElement("link");googleFontHref=document.createAttribute("href"),googleFontRel=document.createAttribute("rel"),googleFontHref.value="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600",googleFontRel.value="stylesheet",googleFont.setAttributeNode(googleFontHref),googleFont.setAttributeNode(googleFontRel);var css="@media only screen and (max-width: 768px) {.web-hosting-90-off-image-wrapper {position: absolute;} .notice_content {justify-content: center;} .web-hosting-90-off-image {opacity: 0.3;}} @media only screen and (min-width: 769px) {.notice_content {justify-content: space-between;} .web-hosting-90-off-image-wrapper {padding: 0 5%}} .content-wrapper {z-index: 5} .notice_content {display: flex; align-items: center;} * {-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;} .upgrade_button_red_sale{border: 0; border-radius: 3px; background-color: #ff123a !important; padding: 15px 55px !important; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600; color: #ffffff;} .upgrade_button_red_sale:hover{color: #ffffff !important; background: #d10303 !important;}",style=document.createElement("style"),sheet=window.document.styleSheets[0];style.styleSheet?style.styleSheet.cssText=css:style.appendChild(document.createTextNode(css)),document.getElementsByTagName("head")[0].appendChild(style),document.getElementsByTagName("head")[0].appendChild(googleFont);var button=document.getElementsByClassName("upgrade_button_red")[0],link=button.parentElement;link.setAttribute("href","https://www.hostinger.com/special/000webhost?utm_source=000webhost&utm_medium=panel&utm_campaign=000-wp"),link.innerHTML='<button class="upgrade_button_red_sale">TRANSFER NOW</button>',(notification=notification[0]).setAttribute("style","padding-bottom: 10px; padding-top: 5px; background-image: url(https://cdn.000webhost.com/000webhost/promotions/springsale/mountains-neon-background.jpg); background-color: #000000; background-size: cover; background-repeat: no-repeat; color: #ffffff; border-color: #ff123a; border-width: 8px;"),notification.className="notice notice-error is-dismissible",(hostingerLogo=hostingerLogo[0]).setAttribute("src","https://cdn.000webhost.com/000webhost/promotions/springsale/logo-hostinger-white.svg"),hostingerLogo.setAttribute("style","float: none !important; height: auto; max-width: 100%; margin: 40px 20px 10px 30px;");var h1Tag=notification.getElementsByTagName("H1")[0];h1Tag.remove();var paragraph=notification.getElementsByTagName("p")[0];paragraph.innerHTML="Fast & Secure Web Hosting. <br>Limited time offer: get an SSL certificate for FREE",paragraph.setAttribute("style",'max-width: 600px; margin-left: 30px; font-family: "Open Sans", sans-serif; font-size: 22px; font-weight: 600;');var list=notification.getElementsByTagName("UL")[0];list.setAttribute("style","max-width: 675px;");for(var listElements=list.getElementsByTagName("LI"),i=0;i<newList.length;i++)listElements[i].setAttribute("style","color:#ffffff; list-style-type: disc; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 14px; font-weight: 300; line-height: 1.5;"),listElements[i].innerHTML=newList[i];listElements[listElements.length-1].remove();var org_html=mainContent.innerHTML,new_html='<div class="content-wrapper">'+mainContent.innerHTML+'</div><div class="web-hosting-90-off-image-wrapper"><img class="web-hosting-90-off-image" src="https://cdn.000webhost.com/000webhost/promotions/springsale/web-hosting-90-off.png"></div>';mainContent.innerHTML=new_html;var saleImage=mainContent.getElementsByClassName("web-hosting-90-off-image")[0];!function(){var t=document.querySelectorAll("body.wp-admin")[0];function e(){var e=document.createElement("iframe");e.id="hgr-promo-widget",e.setAttribute("src","https://www.hostinger.com/widgets/bottom-banner-sale/000_wp_admin"),e.setAttribute("allowfullscreen",!0),e.setAttribute("frameborder",0),e.style.cssText="z-index: 2147483000 !important;position: fixed !important;bottom: 0; width: 100%;!important; left: 0!important;",e.style.opacity=0,e.onload=function(){iFrameResize({},"#hgr-promo-widget"),e.style.opacity=1},t.insertAdjacentElement("afterend",e)}if(window.iFrameResize)e();else{var n=document.createElement("script");n.type="text/javascript",t.insertAdjacentElement("afterend",n),n.onload=e,n.src="https://unpkg.com/iframe-resizer@3.6.3/js/iframeResizer.min.js"}}()}</script></body>
</html>