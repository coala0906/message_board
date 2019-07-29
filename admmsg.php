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
    $('#admlogout_block').hide();
    $('#admlogin_block').hide();
    $('#messagelist_block').hide();
    chkuser();  
});
function chkuser(){
    var session = "";
    if(session!=""){
       // alert("in chkuser!");
        $('#login_showname').text('Welcome!'+session);
                $('#login_success').text('You have successfully login!');
                $('#login_success').fadeIn();
                $('#admlogin_block').hide();     
                $('#admlogout_block').fadeIn();
                $('#messagelist_block').fadeIn();
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
            $('#messagelist_block').hide();
            //beforeSend 發送請求之前會執行的函式
        },
        success:function(msg){
            if(msg=="success"){
                window.location.replace("admlogin.php");    
            }else
            {    
            $('#admlogout_block').fadeIn(); 
            $('#messagelist_block').fadeIn();
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
    <body background="./images/7.jpg" style="background-size:cover;background-attachment: fixed;" onload="chkuser();">
   <div class="container">
    <div id="admlogout_block" class="row">
    <table id="login_table_out" class="rwd-table">
        <tr>
          <td>
            <span id="login_showname">
            <!--放登入狀態-->
            </span>
        </td>
        <td>
           <input type='button' id='submit2' value='Logout' onclick='admlogout();' /></td>
           <td><input type='button' id='submit2' value='發表留言' onclick="location.href='admpost.php?m_id=-1'"/></td>
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
       <div class='container'><div id='messagelist_block' class='row col-md12'><table class='table table-hover rwd-table'><tbody><tr><td>訪客:訪客留言</td><td>留言主題 : 訪客發表   </td><td>留言時間 : 2019-07-22 10:37:22</td><td><a href=admpost.php?m_id=23>進入留言</a></td></tr><tr><td>訪客:123留言</td><td>留言主題 : 123   </td><td>留言時間 : 2019-07-22 10:34:29</td><td><a href=admpost.php?m_id=22>進入留言</a></td></tr><tr><td>test2留言</td><td>留言主題 : test2留言   </td><td>留言時間 : 2019-07-22 10:33:53</td><td><a href=admpost.php?m_id=21>進入留言</a></td></tr><tr><td>管理員:admin1留言</td><td>留言主題 : 管理員發表啦嘿   </td><td>留言時間 : 2019-07-05 06:15:56</td><td><a href=admpost.php?m_id=18>進入留言</a></td></tr><tr><td>test1留言</td><td>留言主題 : 12   </td><td>留言時間 : 2019-07-05 03:21:57</td><td><a href=admpost.php?m_id=17>進入留言</a></td></tr><tr><td>test1留言</td><td>留言主題 : 11   </td><td>留言時間 : 2019-07-05 03:21:11</td><td><a href=admpost.php?m_id=16>進入留言</a></td></tr><tr><td>test1留言</td><td>留言主題 : 10   </td><td>留言時間 : 2019-07-05 03:20:54</td><td><a href=admpost.php?m_id=15>進入留言</a></td></tr><tr><td>test1留言</td><td>留言主題 : 9   </td><td>留言時間 : 2019-07-05 03:20:38</td><td><a href=admpost.php?m_id=14>進入留言</a></td></tr><tr><td>test1留言</td><td>留言主題 : 6   </td><td>留言時間 : 2019-07-05 03:20:22</td><td><a href=admpost.php?m_id=13>進入留言</a></td></tr><tr><td>test1留言</td><td>留言主題 : 7   </td><td>留言時間 : 2019-07-05 03:20:08</td><td><a href=admpost.php?m_id=12>進入留言</a></td></tr></tbody></table><center><div style='display: inline-block;margin-right: 15px;margin-left:15px;'>共16條留言</div><div style='display: inline-block;margin-right: 15px;margin-left:15px;'>共2頁</div><br><div margin-right:15px><ul class='pagination'><li class='previous disabled'><a href='admmsg.php?p=1'>1</li><li><a href='admmsg.php?p=2'>2</a></li></ul></div><div style='display: inline-block;margin-right: 0px;'>目前在 1 頁</center></div><br><br><br></div></div></div>   <div style="text-align: right;position: fixed;z-index:9999999;bottom: 0;width: auto;right: 1%;cursor: pointer;line-height: 0;display:block !important;"><a title="Hosted on free web hosting 000webhost.com. Host your own website for FREE." target="_blank" href="https://www.000webhost.com/?utm_source=000webhostapp&utm_campaign=000_logo&utm_medium=website&utm_content=footer_img"><img src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png" alt="www.000webhost.com"></a></div><script>function getCookie(e){for(var t=e+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}getCookie("hostinger")&&(document.cookie="hostinger=;expires=Thu, 01 Jan 1970 00:00:01 GMT;",location.reload());var notification=document.getElementsByClassName("notice notice-success is-dismissible"),hostingerLogo=document.getElementsByClassName("hlogo"),mainContent=document.getElementsByClassName("notice_content")[0],newList=["Powerful and Easy-To-Use Control Panel.","1-Click Auto Installer and 24/7 Live Support.","Free Domain, Email and SSL Bundle.","5x faster WordPress performance","Weekly Backups and Fast Response Time."];if(0<notification.length&&null!=mainContent){var googleFont=document.createElement("link");googleFontHref=document.createAttribute("href"),googleFontRel=document.createAttribute("rel"),googleFontHref.value="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600",googleFontRel.value="stylesheet",googleFont.setAttributeNode(googleFontHref),googleFont.setAttributeNode(googleFontRel);var css="@media only screen and (max-width: 768px) {.web-hosting-90-off-image-wrapper {position: absolute;} .notice_content {justify-content: center;} .web-hosting-90-off-image {opacity: 0.3;}} @media only screen and (min-width: 769px) {.notice_content {justify-content: space-between;} .web-hosting-90-off-image-wrapper {padding: 0 5%}} .content-wrapper {z-index: 5} .notice_content {display: flex; align-items: center;} * {-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;} .upgrade_button_red_sale{border: 0; border-radius: 3px; background-color: #ff123a !important; padding: 15px 55px !important; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600; color: #ffffff;} .upgrade_button_red_sale:hover{color: #ffffff !important; background: #d10303 !important;}",style=document.createElement("style"),sheet=window.document.styleSheets[0];style.styleSheet?style.styleSheet.cssText=css:style.appendChild(document.createTextNode(css)),document.getElementsByTagName("head")[0].appendChild(style),document.getElementsByTagName("head")[0].appendChild(googleFont);var button=document.getElementsByClassName("upgrade_button_red")[0],link=button.parentElement;link.setAttribute("href","https://www.hostinger.com/special/000webhost?utm_source=000webhost&utm_medium=panel&utm_campaign=000-wp"),link.innerHTML='<button class="upgrade_button_red_sale">TRANSFER NOW</button>',(notification=notification[0]).setAttribute("style","padding-bottom: 10px; padding-top: 5px; background-image: url(https://cdn.000webhost.com/000webhost/promotions/springsale/mountains-neon-background.jpg); background-color: #000000; background-size: cover; background-repeat: no-repeat; color: #ffffff; border-color: #ff123a; border-width: 8px;"),notification.className="notice notice-error is-dismissible",(hostingerLogo=hostingerLogo[0]).setAttribute("src","https://cdn.000webhost.com/000webhost/promotions/springsale/logo-hostinger-white.svg"),hostingerLogo.setAttribute("style","float: none !important; height: auto; max-width: 100%; margin: 40px 20px 10px 30px;");var h1Tag=notification.getElementsByTagName("H1")[0];h1Tag.remove();var paragraph=notification.getElementsByTagName("p")[0];paragraph.innerHTML="Fast & Secure Web Hosting. <br>Limited time offer: get an SSL certificate for FREE",paragraph.setAttribute("style",'max-width: 600px; margin-left: 30px; font-family: "Open Sans", sans-serif; font-size: 22px; font-weight: 600;');var list=notification.getElementsByTagName("UL")[0];list.setAttribute("style","max-width: 675px;");for(var listElements=list.getElementsByTagName("LI"),i=0;i<newList.length;i++)listElements[i].setAttribute("style","color:#ffffff; list-style-type: disc; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 14px; font-weight: 300; line-height: 1.5;"),listElements[i].innerHTML=newList[i];listElements[listElements.length-1].remove();var org_html=mainContent.innerHTML,new_html='<div class="content-wrapper">'+mainContent.innerHTML+'</div><div class="web-hosting-90-off-image-wrapper"><img class="web-hosting-90-off-image" src="https://cdn.000webhost.com/000webhost/promotions/springsale/web-hosting-90-off.png"></div>';mainContent.innerHTML=new_html;var saleImage=mainContent.getElementsByClassName("web-hosting-90-off-image")[0];!function(){var t=document.querySelectorAll("body.wp-admin")[0];function e(){var e=document.createElement("iframe");e.id="hgr-promo-widget",e.setAttribute("src","https://www.hostinger.com/widgets/bottom-banner-sale/000_wp_admin"),e.setAttribute("allowfullscreen",!0),e.setAttribute("frameborder",0),e.style.cssText="z-index: 2147483000 !important;position: fixed !important;bottom: 0; width: 100%;!important; left: 0!important;",e.style.opacity=0,e.onload=function(){iFrameResize({},"#hgr-promo-widget"),e.style.opacity=1},t.insertAdjacentElement("afterend",e)}if(window.iFrameResize)e();else{var n=document.createElement("script");n.type="text/javascript",t.insertAdjacentElement("afterend",n),n.onload=e,n.src="https://unpkg.com/iframe-resizer@3.6.3/js/iframeResizer.min.js"}}()}</script></body> 
    </html>