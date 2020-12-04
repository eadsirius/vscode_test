<?php
$select_lang = 'kr';
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WNS</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/custom.css?<?=nowdate()?>" rel="stylesheet">
    <script src="/assets/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/common.js?<?=today()?>"></script>
    <script type="text/javascript" src="/assets/js/lang_kr.js?<?=today()?>"></script>
    <script type="text/javascript" src="/assets/js/register.js?<?=today()?>"></script>
</head>

<body id="login" class="gray-bg register">
    <div class="middle-box animated fadeInDown">
        <div class="row">
            <div class="ibox-content b-r-sm" style="background-color: #424242;">
                <div class="text-center">
                    <h1 class="logo-login"><img alt="XMINING" class="iamge" src="/assets/img/logo.png" /></h1>
                </div>

                <form name="reg_form" class="m-t" role="form" action="/member/register" method="post" onsubmit="return formCheck();">
                    <input type="hidden" name="office" id="office" value="company">
                    <input type="hidden" name="regdate" id="regdate" value="<?=$regdate?>">
                    <input type="hidden" name="type" id="type" value="0">
                    <input type="hidden" name="member_id_enabled" id="member_id_enabled" value="" >
                    <input type="hidden" name="sp_id_enabled" id="sp_id_enabled" value="" >
                    <input type="hidden" name="re_id_enabled" id="re_id_enabled" value="" >

                    <div class="form-group m-b-sm">
                        <!-- <div class="dropdown" style="text-align:right">
                        <?
                            if ($select_lang == "us") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_en.png"> English <b class="caret"></b>
                            </a>
                        <?
                            } elseif ($select_lang == "kr") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_ko.png"> Korea <b class="caret"></b>
                            </a>
                        <?
                            } elseif ($select_lang == "cn") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_cn.png"> China <b class="caret"></b>
                            </a>
                        <?
                            } else if ($select_lang == "jp") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_jp.png"> Japan <b class="caret"></b>
                            </a>
                        <?
                            }
                        ?>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs pull-right">
                                <li><a href="#" onclick="fnSelectLang('us');return false;"><img alt="English" class="" src="/assets/img/lang/ico_lang_en.png"> <strong>English</strong></a></li>
                                <li><a href="#" onclick="fnSelectLang('kr');return false;"><img alt="Korea" class="" src="/assets/img/lang/ico_lang_ko.png"> <strong>Korea</strong></a></li>
                                <li><a href="#" onclick="fnSelectLang('cn');return false;"><img alt="China" class="" src="/assets/img/lang/ico_lang_cn.png"> <strong>China</strong></a></li>
                                <li><a href="#" onclick="fnSelectLang('jp');return false;"><img alt="China" class="" src="/assets/img/lang/ico_lang_jp.png"> <strong>Japan</strong></a></li>
                            </ul>
                        </div> -->
                    </div>

                    <div class="form-group m-b-sm">
                        <select class="form-control m-b" name="country" id="country" required="">
														<!-- <option value='' ><?=get_msg($select_lang, '국가 선택')?></option> -->
                            <? foreach ($country as $row) { ?>
                            <option value='<?=$row->phone_code?>' ><?=$row->country_name?></option>
                            <? } ?>
                        </select>
                    </div>
                   
                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <!-- <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="id" class="form-control" placeholder="<?=get_msg($select_lang, '회원 ID')?>" required="" id="member_id" name="member_id" onblur='idcheck();' /> -->
                            <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="id" class="form-control" placeholder="<?=get_msg($select_lang, '회원 ID')?>" required="" id="member_id" name="member_id" />
                        </div>
                        <div class="reg-error" id='msg_member_id' class="msg"></div>
                    </div>

                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span> <input type="password" class="form-control" placeholder="<?=get_msg($select_lang, '비밀번호')?>" required="" name="password" id="password" />
                        </div>
                    </div>

                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span> <input type="password" class="form-control" placeholder="<?=get_msg($select_lang, '비밀번호 확인')?>" required="" name="password2" id="password2" />
                        </div>
                    </div>

                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="id" class="form-control" placeholder="<?=get_msg($select_lang, '추천인 ID')?>" required="" name="recommend_id" id='recommend_id' value="<?=$this->uri->segment(3)?>" onblur='recheck();' />
                        </div>
                        <div class="reg-error"  id='msg_re_id' class="msg"></div>
                    </div>
					
					<!--
                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="id" class="form-control" placeholder="<?=get_msg($select_lang, '후원인 ID')?>" required="" name="sponsor_id" id='sponsor_id' value="" onblur='spcheck();' />
                        </div>
                        <div class="reg-error"  id='msg_sp_id' class="msg"></div>
                    </div>
                    -->
                    <hr class="m-t-sm m-b-sm" />

                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user-o"></i></span> <input type="text" class="form-control" placeholder="<?=get_msg($select_lang, '이름')?>" required="" name="name" id="name" />
                        </div>
                    </div>

                    <?if($site->cfg_phone_reg == 1 and $site->cfg_phone_view == 1){?>
                    <div class="input-group m-b-sm">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span> <input type="text" class="form-control" name="mobile" id="mobile" required="" placeholder="<?=get_msg($select_lang, '핸드폰')?>"> <span class="input-group-btn"> <button type="button" class="btn btn-success" onclick="send_sms()"><i class="fa fa-check"></i> <?=get_msg($select_lang, '문자 발송')?></button> </span>
                    </div>
                    <div class="form-group m-b">
                        <input type="text" class="form-control" placeholder="<?=get_msg($select_lang, '문자 인증번호')?>" required="" name="authcode" id="authcode" />
                    </div>
                    <?}else if($site->cfg_phone_view == 1){?>
                    <div class="form-group m-b-sm">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user-o"></i></span> <input type="text" class="form-control" name="mobile" id="mobile" placeholder="<?=get_msg($select_lang, '핸드폰')?>" />
                        </div>
                    </div>
                    <?}?>

                    <?if($site->cfg_mail_view == 1 and $site->cfg_mail_reg == 1){ // 선인증?>
                    <div class="input-group m-b-sm">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span> <input type="text" class="form-control" name="email" id="email" placeholder="<?=get_msg($select_lang, '이메일')?>" required=""> <span class="input-group-btn"> <button type="button" class="btn btn-success" onclick="send_email()"><i class="fa fa-check"></i> <?=get_msg($select_lang, '이메일 발송')?></button> </span>
                    </div>
                    <div class="form-group m-b">
                        <input type="text" class="form-control" placeholder="<?=get_msg($select_lang, '인증번호')?>" required="" name="mailcode" id="mailcode" maxlength="6" />
                    </div>
                    <?}else if($site->cfg_mail_view == 1 and $site->cfg_mail_log == 1){ // 후인증?>
                    <div class="input-group m-b-sm">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span> <input type="text" class="form-control" name="email" id="email" placeholder="<?=get_msg($select_lang, '이메일')?>" required=""> 
                    </div>
                    <?}else if($site->cfg_mail_view == 1){ // 후인증?>
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span> <input type="text" class="form-control" name="email" id="email" placeholder="<?=get_msg($select_lang, '이메일')?>" required=""> 
                    <?}?>	
					
					<div class="checkbox">
						<label style="color: white;">
							<input type="checkbox" name="optionsCheckboxes" required />
							안내 사항을 읽었고 이에 동의 합니다.
							<!-- (<a href="/member/personal">자세히보기</a>) -->
						</label>
					</div>

                    <button type="submit" class="btn btn-primary block full-width m-b"><?=get_msg($select_lang, '가입')?></button>

                    <p class="text-muted text-center">
                        <small style="color:white;"><?=get_msg($select_lang, '이미 가입한 계정이 있습니까?')?></small> <a href="/member/login"><small><?=get_msg($select_lang, '로그인')?></small></a>
                    </p>

                    <hr />

                    <div class="m-t text-center" style="color:white;">
                        Copyright WNS &copy; 2020
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Mainly scripts -->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/assets/js/inspinia.js"></script>
<script src="/assets/js/plugins/pace/pace.min.js"></script>

<script type="text/javascript">

function formCheck() 
{
		var f = document.reg_form;

    // idcheck();
    // if (document.getElementById('member_id_enabled').value != '000') {
    //     alert(Common.Lang['Member ID']);
    //     document.getElementById('member_id').select();
    //     return false;
    // }
 
    recheck();        
    if (document.getElementById('re_id_enabled').value != '000') {
        alert(Common.Lang['Chked The Referral ID']);
        document.getElementById('recommend_id').select();
        return false;
    }
	
	/*
    spcheck();        
    if (document.getElementById('sp_id_enabled').value != '000') {
        alert(Common.Lang['Chked The Team ID']);
        document.getElementById('sponsor_id').select();
        return false;
    }
    */
    
    if (f.password.value == "") {
        alert(Common.Lang['New Password']);
        f.password.focus();
        return false;
    }


    if (f.password2.value == "") {
        alert(Common.Lang['Cofirm Password']);
        f.password2.focus();
        return false;
    }
	
	/*
    if (f.authkey.value == "") {
        alert("SMS 인증코드를 입력하세요.");
        f.authkey.focus();
        return false;
    }

    if (f.mobile.value == "") {
        alert("핸드폰 번호를 입력하세요.");
        f.mobile.focus();
        return false;
    }
    */
}

function mobileChange() 
{
    var frm = document.reg_form;
    
    var e = $("#country option:selected").val();
    
	
	frm.type.value = e;
}

function send_sms() {
    var f = document.reg_form;

    if (f.mobile.value == "") {
        alert(Common.Lang['Please enter your cell phone number.']);
        f.mobile.focus();
        return false;
    }

    if (f.country.value == "") {
        alert(Common.Lang['Please select a country']);
        f.country.focus();
        return false;
    }
        
    $.ajax({	    
        url:'/member/sms?mobile=' + $('#type').val() + $('#mobile').val(),
        type: "get",
        dataType:"html",
        success: function(data){
            console.log(data);
        }
    });

}

function send_email() {
    var f = document.reg_form;

    if (f.email.value == "") {
        alert(Common.Lang['Please enter your email.']);
        f.email.focus();
        return false;
    }
       
    check(f.email.value);
    
    var bf = f.email.value.split('@');
    
    $.ajax({
	        
        url:'/member/qmail/qsend/' + bf[0] +'/' +bf[1],
        type: "get",
        dataType:"html",
        success: function(data){
            console.log(data);
        }
    });
    
    alert(Common.Lang['Verfiy Email Checked!']);

}	
	
function check(email) 
{
    var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;

    //이메일 형식이 알파벳+숫자@알파벳+숫자.알파벳+숫자 형식이 아닐경우	
    if(exptext.test(email)==false){		
        alert(Common.Lang['This mail format is not valid.']);
        return false;
    }
}

$("#member_id").keyup(function(evt){
	var regType1 = /^[a-z0-9+]*$/;
		v = $(this).val();
		if (!regType1.test(v)) {
			$(this).val(v.replace(/[^\d]/g,''));
		}
	});




var fnSelectLang = function (sel_lang) {
    Common.FnCookies("lang", sel_lang, 365);
    history.go(0);
}
</script>

</body>

</html>