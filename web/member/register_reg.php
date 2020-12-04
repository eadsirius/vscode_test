<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$login_id = $this->session->userdata('member_id');
?>
<script type="text/javascript" src="/assets/js/register.js?<?=today()?>"></script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><?=get_msg($select_lang, '팀 Binary')?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="/"><?=get_msg($select_lang, '홈')?></a>
            </li>
            <li>
                <a><?=get_msg($select_lang, '계정')?></a>
            </li>
            <li class="active">
                <a><?=get_msg($select_lang, '팀 Binary')?></a>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?=get_msg($select_lang, 'Sponsor Invite Register.')?></h5>
                </div>
                <div class="ibox-content">
				<form name="reg_form" class="form-horizontal" action="<?=current_url()?>" method="post" onsubmit="return formCheck();">
					<input type="hidden" name="regdate" 			id="regdate" 			value="<?=$regdate?>">
					<input type="hidden" name="type" 				id="type" 				value="0">
					<input type="hidden" name="member_id_enabled" 	id="member_id_enabled" 	value="" >
					<input type="hidden" name="sp_id_enabled" 		id="sp_id_enabled" 		value="" >
					<input type="hidden" name="re_id_enabled" 		id="re_id_enabled" 		value="" >
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '국가')?> :</label>
                        <div class="col-lg-9">
                            <select class="form-control m-b-sm" name="country" id="country" required itemname="Country" onchange="mobileChange()">
								<option value='' ><?=get_msg($select_lang, '국가 선택')?></option>
								<? foreach ($country as $row) { ?>
								<option value='<?=$row->phone_code?>' ><?=get_msg($select_lang, $row->country_name)?></option>
								<? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed" style="margin:-10px 0 10px"></div>
					
					<?if($site->cfg_id_email == 0 and $site->cfg_id_phone == 0){?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '회원 ID')?> :</label>
                        <div class="col-lg-9"><input type="text" class="form-control" id="member_id" name="member_id" onblur='idcheck();' placeholder="<?=get_msg($select_lang, '6자 이상')?>" required /></div>
						<div class="reg-error pull-right m-r-md" id='msg_member_id' class="msg"></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
					<?}?>
                    
                    <div class="form-group">
                    	<label class="col-lg-3 control-label"><?=get_msg($select_lang, '추천인 ID')?> :</label>
                        <div class="col-lg-9"><input type="text" class="form-control" name="recommend_id" id='recommend_id' value="<?=@$re_id?>" onblur='recheck();' required readonly /></div>
						<div class="reg-error pull-right m-r-md"  id='msg_re_id' class="msg"></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '후원인 아이디')?> :</label>
                        <div class="col-lg-9">
							<input type="text" class="form-control" name="sponsor_id" id='sponsor_id' value="<?=@$sp_id?>" onblur='spcheck();' required readonly />
                        </div>
						<div class="reg-error pull-right m-r-md"  id='msg_sp_id' class="msg"></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
                                
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '비밀번호')?> :</label>
                        <div class="col-lg-9"><input type="password" class="form-control" name="password" id="password" required /></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '비밀번호 확인')?> :</label>
                        <div class="col-lg-9"><input type="password" class="form-control" name="password2" id="password2" required /></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
                    
                    <div class="form-group">
                    	<label class="col-lg-3 control-label"><?=get_msg($select_lang, '이름')?> :</label>
						<div class="col-lg-9"><input type="text" class="form-control" name="name" id="name" required /></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>

					<?if($site->cfg_phone_reg == 1 and $site->cfg_phone_view == 1){?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '핸드폰')?> :</label>
                        <div class="col-lg-9">
                            <div class="input-group m-b-xxs">
                                <input type="text" class="form-control" name="mobile" id="mobile" required> 
                                <span class="input-group-btn"> <button type="button" class="btn btn-success" onclick="send_sms()"><i class="fa fa-check"></i> <?=get_msg($select_lang, '문자 발송')?></button> </span>
                            </div>
                        </div>
                        <div class="col-lg-9 pull-right"><input type="text" class="form-control" name="authcode" id="authcode" maxlength="6" required placeholder="<?=get_msg($select_lang, '인증번호')?>" /></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
					
					<?}else if($site->cfg_phone_view == 1){?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '핸드폰')?> :</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="mobile" id="mobile" required> 
                        </div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>
					<?}?>
					
					<?if($site->cfg_mail_view == 1 and $site->cfg_mail_reg == 1){ // 선인증?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '이메일')?> :</label>
                        <div class="col-lg-9">
                            <div class="input-group m-b-xxs">
                                <input type="text" class="form-control" name="email" id="email" required> 
                                <span class="input-group-btn"> <button type="button" class="btn btn-success" onclick="send_email()"><i class="fa fa-check"></i> <?=get_msg($select_lang, '이메일 발송')?></button> </span>
                            </div>
                        </div>
                        <div class="col-lg-9 pull-right"><input type="text" class="form-control" name="mailcode" id="mailcode" maxlength="6" required placeholder="<?=get_msg($select_lang, '인증번호')?>" /></div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>

					<?}else if($site->cfg_mail_view == 1 and $site->cfg_mail_log == 1){ // 후인증?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '이메일')?> :</label>
                        <div class="col-lg-9">
	                        <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                    <div class="hr-line-dashed" style="margin:10px 0"></div>

					<?}else if($site->cfg_mail_view == 1 ){ // 후인증?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=get_msg($select_lang, '이메일')?> :</label>
                        <div class="col-lg-9">
	                        <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
					<?}?>

                    <div class="hr-line-dashed" style="margin:10px 0 15px"></div>
                    <button type="submit" class="btn btn-primary block full-width m-b-xxs" data-loading-text="Please wait..."><?=get_msg($select_lang, '등록')?></button>
                </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <img src="/assets/img/img_sponsor.png" width="100%" height="auto" alt="" />
        </div>
    </div>
</div>

<script type="text/javascript">
function formCheck() 
{
	var f = document.reg_form;
	

<?if($site->cfg_id_email == 0 and $site->cfg_id_phone == 0){?>
    idcheck();
    if (document.getElementById('member_id_enabled').value != '000') {
        alert(Common.Lang['Member ID']);
        document.getElementById('member_id').select();
        return false;
    }
<?}?>
	
    recheck();        
    if (document.getElementById('re_id_enabled').value != '000') {
        alert(Common.Lang['Chked The Referral ID']);
        document.getElementById('recommend_id').select();
        return false;
    }
							
	spcheck();
	if (document.getElementById('sponsor_id').value != '') {										        
		if (document.getElementById('sp_id_enabled').value != '000') {
			alert('<?=get_msg($select_lang, '후원인 아이디를 입력하세요')?>');
			document.getElementById('sponsor_id').select();
			return false;
    	}
    }
    
	//var regType1 = /^[A-Za-z0-9+]{6,30}$/;
	//var regType1 = /^[A-Za-z0-9+]*$/;
	//if (regType1.test(document.getElementById('member_id').value)) { alert('아이디가 조건에 맞지 않습니다'); }


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
    if (f.mobile.value == "") {
        alert("핸드폰 번호를 입력하세요.");
        f.mobile.focus();
        return false;
    }
*/    
//    $("#form").hide();
	//$(".wait").show();      
	document.getElementById("btn_submit").disabled = "disabled";
    return true;
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
        alert("Please enter your email.");
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

</script>
