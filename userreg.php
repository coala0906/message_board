<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>會員註冊</title>
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
        error_alert('請輸入帳號與密碼');
        return false;
    }
    if(user_name==""){
        error_alert('請輸入帳號');
        $('#user_name').focus();
        return false;
    }else if(user_password==""){
        error_alert('請輸入密碼');
        $('#user_password').focus();
        return false;
    }
    if(user_nkname==""){
        error_alert('請輸入暱稱');
        $('#user_nkname').focus();
        return false;
    }
    if(user_tel==""){
        error_alert('請輸入連絡電話');
        $('#user_tel').focus();
        return false;
    }
    if(re.test(user_email)==false||user_email==""){
        error_alert('請確認email');
        $('#user_email').focus();
        return false;
    };

//真正的ajax動作從這裡開始
    $.ajax({
        url:"userreg_chk.php",
        data:"user_name="+user_name+"&user_password="+user_password+"&user_nkname="+user_nkname+"&user_tel="+user_tel+"&user_email="+user_email+"&user_sex="+user_sex,
        type : "POST",
        beforeSend:function(){
            $('#loading_div1').show(); 
            $('#userreg_block').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg =="success"){
                $('#login_success').text('註冊成功!');
                window.location.replace("index.php"); 
            }else
            {    
                error_alert("註冊失敗:"+msg);
                $('#userreg_block').fadeIn();
            }
        },
        error:function(xhr){
            alert('Ajax request 發生錯誤');
            $('#userreg_block').fadeIn();
        },
        complete:function(){
            $('#loading_div1').hide();
            //$('#user_login').hide();         
            //complete請求完成實執行的函式，不管是success或是error
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
}},
closeOnEscape: false,//按ESC不能關閉
  open: function(event, ui) {
    //隱藏「x」關閉按鈕
    $(this).parent().find('.ui-dialog-titlebar-close').hide();
  }
});
};
</script>
<div id="userreg_block" name="userreg_block">
    <form id="user_reg" method="POST">
    <table id="reg_table">
        <tr>
          <td>
            <h1>會員註冊</h1>
           <label>*帳號:</label><input type="text" name="user_name" id="user_name" class="form-control"/><br/> 
           <label>*密碼:</label><input type="password" name="user_password" id="user_password" class="form-control"/><br/>
           <label>*暱稱:</label><input type="text" name="user_nkname" id="user_nkname" class="form-control"/><br/> 
           <label>*連絡電話:</label><input type="text" name="user_tel" id="user_tel" class="form-control"/><br/> 
           <label>*email:</label><input type="text" name="user_email" id="user_email" class="form-control"/><br/> 
           <label>性別:</label><select name="user_sex" id="user_sex" class="form-control">
           <option selected="true" value="未填寫">選擇性別</option>
　          <option value="男">男</option>
　              <option value="女">女</option>
                    </select><br/>
           <input type='button' class='btn btn-primary' value='確認' onclick='userreg();'/>
           <input type='button' class='btn btn-primary' value='回首頁' onclick="location.href='index.php'"/>
          </td>
        </tr>
    </table>
    </form>
    </div>
    <div id="error_msg"></div>
    <div id="loading_div1" style="display:none;">
        Loading...please wait
    </div>
    <div id="loadingout_div" style="display:none">
       Logout...please wait
    </div>
    <div id="dialog" title="錯誤訊息"></div>
    <div id="login_success" style="display:none;">
    <!--放you are successfully login-->
    </div>

<div style="text-align: right;position: fixed;z-index:9999999;bottom: 0;width: auto;right: 1%;cursor: pointer;line-height: 0;display:block !important;"><a title="Hosted on free web hosting 000webhost.com. Host your own website for FREE." target="_blank" href="https://www.000webhost.com/?utm_source=000webhostapp&utm_campaign=000_logo&utm_medium=website&utm_content=footer_img"><img src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png" alt="www.000webhost.com"></a></div><script>function getCookie(e){for(var t=e+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}getCookie("hostinger")&&(document.cookie="hostinger=;expires=Thu, 01 Jan 1970 00:00:01 GMT;",location.reload());var notification=document.getElementsByClassName("notice notice-success is-dismissible"),hostingerLogo=document.getElementsByClassName("hlogo"),mainContent=document.getElementsByClassName("notice_content")[0],newList=["Powerful and Easy-To-Use Control Panel.","1-Click Auto Installer and 24/7 Live Support.","Free Domain, Email and SSL Bundle.","5x faster WordPress performance","Weekly Backups and Fast Response Time."];if(0<notification.length&&null!=mainContent){var googleFont=document.createElement("link");googleFontHref=document.createAttribute("href"),googleFontRel=document.createAttribute("rel"),googleFontHref.value="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600",googleFontRel.value="stylesheet",googleFont.setAttributeNode(googleFontHref),googleFont.setAttributeNode(googleFontRel);var css="@media only screen and (max-width: 768px) {.web-hosting-90-off-image-wrapper {position: absolute;} .notice_content {justify-content: center;} .web-hosting-90-off-image {opacity: 0.3;}} @media only screen and (min-width: 769px) {.notice_content {justify-content: space-between;} .web-hosting-90-off-image-wrapper {padding: 0 5%}} .content-wrapper {z-index: 5} .notice_content {display: flex; align-items: center;} * {-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;} .upgrade_button_red_sale{border: 0; border-radius: 3px; background-color: #ff123a !important; padding: 15px 55px !important; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600; color: #ffffff;} .upgrade_button_red_sale:hover{color: #ffffff !important; background: #d10303 !important;}",style=document.createElement("style"),sheet=window.document.styleSheets[0];style.styleSheet?style.styleSheet.cssText=css:style.appendChild(document.createTextNode(css)),document.getElementsByTagName("head")[0].appendChild(style),document.getElementsByTagName("head")[0].appendChild(googleFont);var button=document.getElementsByClassName("upgrade_button_red")[0],link=button.parentElement;link.setAttribute("href","https://www.hostinger.com/special/000webhost?utm_source=000webhost&utm_medium=panel&utm_campaign=000-wp"),link.innerHTML='<button class="upgrade_button_red_sale">TRANSFER NOW</button>',(notification=notification[0]).setAttribute("style","padding-bottom: 10px; padding-top: 5px; background-image: url(https://cdn.000webhost.com/000webhost/promotions/springsale/mountains-neon-background.jpg); background-color: #000000; background-size: cover; background-repeat: no-repeat; color: #ffffff; border-color: #ff123a; border-width: 8px;"),notification.className="notice notice-error is-dismissible",(hostingerLogo=hostingerLogo[0]).setAttribute("src","https://cdn.000webhost.com/000webhost/promotions/springsale/logo-hostinger-white.svg"),hostingerLogo.setAttribute("style","float: none !important; height: auto; max-width: 100%; margin: 40px 20px 10px 30px;");var h1Tag=notification.getElementsByTagName("H1")[0];h1Tag.remove();var paragraph=notification.getElementsByTagName("p")[0];paragraph.innerHTML="Fast & Secure Web Hosting. <br>Limited time offer: get an SSL certificate for FREE",paragraph.setAttribute("style",'max-width: 600px; margin-left: 30px; font-family: "Open Sans", sans-serif; font-size: 22px; font-weight: 600;');var list=notification.getElementsByTagName("UL")[0];list.setAttribute("style","max-width: 675px;");for(var listElements=list.getElementsByTagName("LI"),i=0;i<newList.length;i++)listElements[i].setAttribute("style","color:#ffffff; list-style-type: disc; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 14px; font-weight: 300; line-height: 1.5;"),listElements[i].innerHTML=newList[i];listElements[listElements.length-1].remove();var org_html=mainContent.innerHTML,new_html='<div class="content-wrapper">'+mainContent.innerHTML+'</div><div class="web-hosting-90-off-image-wrapper"><img class="web-hosting-90-off-image" src="https://cdn.000webhost.com/000webhost/promotions/springsale/web-hosting-90-off.png"></div>';mainContent.innerHTML=new_html;var saleImage=mainContent.getElementsByClassName("web-hosting-90-off-image")[0];!function(){var t=document.querySelectorAll("body.wp-admin")[0];function e(){var e=document.createElement("iframe");e.id="hgr-promo-widget",e.setAttribute("src","https://www.hostinger.com/widgets/bottom-banner-sale/000_wp_admin"),e.setAttribute("allowfullscreen",!0),e.setAttribute("frameborder",0),e.style.cssText="z-index: 2147483000 !important;position: fixed !important;bottom: 0; width: 100%;!important; left: 0!important;",e.style.opacity=0,e.onload=function(){iFrameResize({},"#hgr-promo-widget"),e.style.opacity=1},t.insertAdjacentElement("afterend",e)}if(window.iFrameResize)e();else{var n=document.createElement("script");n.type="text/javascript",t.insertAdjacentElement("afterend",n),n.onload=e,n.src="https://unpkg.com/iframe-resizer@3.6.3/js/iframeResizer.min.js"}}()}</script></body>
</html>