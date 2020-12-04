<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=get_msg($select_lang, '사용자 정보')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '프로필')?></a>
			</li>
			<li class="active">
				<strong><?=get_msg($select_lang, '사용자 정보')?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row animated fadeInRight">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-12">
							<div class="m-b-md">
								<h2><?=get_msg($select_lang, '회원 기본 정보')?></h2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<dl class="dl-horizontal xm">
								<dt><?=get_msg($select_lang, '회원 ID')?> :</dt>
								<dd class="text-primary"><?=$this->session->userdata('member_id')?></dd>
								<dt><?=get_msg($select_lang, '이름')?> :</dt>
								<dd><?=$mb->name?></dd>
								<!-- <dt><?=get_msg($select_lang, '레벨')?> :</dt> <dd><?=$bal->level?>Lv.</dd> -->
								<dt><?=get_msg($select_lang, '총 투자금')?> :</dt>
								<dd>&#8361 <?=number_format($staking->purchase_hap*10)?> 원</dd>
								<dt><?=get_msg($select_lang, '가입 날짜')?> :</dt>
								<dd><?=date("Y-m-d H:i:s",strtotime($mb->regdate." +9 hours"))?></dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '비밀번호 변경')?></h5>
				</div>
				<div class="ibox-content">
					<form id="reg_form2" name="reg_form2" action="/member/profile/password" method="post" onsubmit="return formCheck2(this);" class="form-horizontal">
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '현재 비밀번호')?> :</label>
							<div class="col-lg-9"><input type="password" id="password" name="password" class="form-control" required /></div>
						</div>
						<hr class="hr-line-dashed" style="margin:10px 0" />

						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 비밀번호')?> :</label>
							<div class="col-lg-9"><input type="password" id="new_password" name="new_password" class="form-control" required /></div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 비밀번호 확인')?> :</label>
							<div class="col-lg-9"><input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" required /></div>
						</div>
						<hr class="hr-line-dashed" />

						<button type="submit" class="btn btn-danger block full-width m-b-xxs" id='btn_submit2'><?=get_msg($select_lang, '수정')?></button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '출금비밀번호 변경')?></h5>
				</div>
				<div class="ibox-content">
					<form id="reg_form2" name="reg_form2" action="/member/profile/passwordEx" method="post" onsubmit="return formCheck2(this);" class="form-horizontal">
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '현재 비밀번호')?> :</label>
							<div class="col-lg-9"><input type="password" id="password" name="password" class="form-control"
									required /></div>
						</div>
						<hr class="hr-line-dashed" style="margin:10px 0" />

						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 비밀번호')?> :</label>
							<div class="col-lg-9"><input type="password" id="new_password" name="new_password" class="form-control"
									required /></div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 비밀번호 확인')?> :</label>
							<div class="col-lg-9"><input type="password" id="new_password_confirm" name="new_password_confirm"
									class="form-control" required /></div>
						</div>
						<hr class="hr-line-dashed" />
						<div class="form-group">
							<label class="col-lg-12 control-label">* 첫 수정일 경우 현재 비밀번호는 123456 입니다.(필히 자주 수정하세요.)</label>
							<label class="col-lg-12 control-label">* 최대 6자리 입니다.</label>
						</div>

						<button type="submit" class="btn btn-success block full-width m-b-xxs" id='btn_submit2'><?=get_msg($select_lang, '수정')?></button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '핸드폰 정보')?></h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" id="reg_form3" name="reg_form3" action="/member/profile/phone" method="post" onsubmit="return formCheck3();">
						<input type="hidden" name="type" id="type" value="<?=$mb->country?>">
						<div class="form-group m-b-xs">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '국가')?> :</label>
							<div class="col-lg-9">
								<select name="country" id="country" required itemname="Country" class="form-control m-b" onchange="mobileChange()" disabled>
									<option value=''><?=get_msg($select_lang, '국가 선택')?></option>
									<? foreach ($country as $row) { ?>
									<option value='<?=$row->phone_code?>' 
										<?if($row->phone_code == $mb->country){?>
											selected 
											<?}?> >
											<?=$row->country_name?>
										</option>
									<? } ?>
								</select>
							</div>
						</div>
						<hr class="hr-line-dashed" style="margin:0 0 10px" />
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '핸드폰 번호')?> :</label>
							<div class="col-lg-9">
								<div class="input-group m-b-sm" style="width: 100%;">
									<input type="text" class="form-control" name="mobile" id="mobile" value="<?=$mb->mobile?>" disabled />
									<!-- <span class="input-group-btn"> 
																					<button type="button" class="btn btn-info" onclick="send_sms()"><i class="fa fa-check"></i> <?=get_msg($select_lang, '문자발송')?></button> 
																				</span> -->
								</div>
							</div>
							<!-- <div class="col-lg-9 col-xs-12 pull-right"><input type="text" name="authcode" id="authcode" maxlength="6" required class="form-control" placeholder="<?=get_msg($select_lang, '문자 인증번호')?>" /></div> -->
						</div>
						<hr class="hr-line-dashed" />
						<!-- <button type="submit" class="btn btn-info block full-width m-b-xxs" id='btn_submit3'><?=get_msg($select_lang, '수정')?></button> -->
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '주소 수정')?></h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" id="reg_form3" name="reg_form3" action="/member/profile/address" method="post" onsubmit="return formCheck3();">
						<input type="hidden" name="type" id="type" value="<?=$mb->country?>">
						<div class="form-group m-b-xs">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '우편번호')?> :</label>
							<div class="col-lg-9">
								<div class="input-group m-b-sm">
									<input type="text" class="form-control" name="post" id="post" value="<?=$mb->post?>" required />
								</div>
							</div>
						</div>
						<hr class="hr-line-dashed" style="margin:0 0 10px" />
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '주소')?> :</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="address" id="address" value="<?=$mb->address?>" required />
							</div>
						</div>
						<hr class="hr-line-dashed" style="margin:0 0 10px" />
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '상세주소')?> :</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="address1" id="address1" value="<?=$mb->address1?>" required />
							</div>
						</div>
						<hr class="hr-line-dashed" />
						<button type="submit" class="btn btn-info block full-width m-b-xxs" id='btn_submit3'><?=get_msg($select_lang, '수정')?></button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '이메일 수정')?></h5>
				</div>
				<div class="ibox-content">
					<form id="reg_form" name="reg_form" action="/member/profile" method="post" onsubmit="return formCheck();" class="form-horizontal">
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '이름')?> :</label>
							<div class="col-lg-9"><input type="text" class="form-control" name="name" id="name" value="<?=$mb->name?>" required /></div>
						</div>

						<?if($site->cfg_mail_view == 1 and $site->cfg_mail_reg == 1){ // 선인증?>
						<hr class="hr-line-dashed" style="margin:10px 0" />
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '현재 이메일')?> :</label>
							<div class="col-lg-9">
								<div class="input-group m-b-sm">
									<input type="text" class="form-control" name="bf_email" id="bf_email" value="<?=$mb->email?>"required /> 
									<span class="input-group-btn"> 
										<button type="button" class="btn btn-primary"style="width:180px" onclick="before_email()">
											<i class="fa fa-check"></i><?=get_msg($select_lang, '현재 이메일로 전송')?>
										</button>
									</span>
								</div>
							</div>
							<div class="col-lg-9 pull-right"><input type="text" class="form-control" name="bf_mailcode"
									id="bf_mailcode" maxlength="6" required placeholder="<?=get_msg($select_lang, '인증번호')?>" /></div>
						</div>
						<hr class="hr-line-dashed" style="margin:10px 0" />
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 이메일')?> :</label>
							<div class="col-lg-9">
								<div class="input-group m-b-sm">
									<input type="text" class="form-control" name="email" id="email" required> 
									<span class="input-group-btn">
										<button type="button" class="btn btn-primary" style="width:180px" onclick="send_email()">
											<i class="fa fa-check"></i><?=get_msg($select_lang, '새 이메일로 전송')?>
										</button>
									</span>
								</div>
							</div>
							<div class="col-lg-9 pull-right"><input type="text" class="form-control" name="mailcode" id="mailcode" maxlength="6" required placeholder="<?=get_msg($select_lang, '인증번호')?>" /></div>
						</div>

						<?}else if($site->cfg_mail_view == 1){ // 후인증?>
						<hr class="hr-line-dashed" style="margin:10px 0" />
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 이메일')?> :</label>
							<div class="col-lg-9">
								<div class="input-group m-b-sm">
									<input type="text" class="form-control" name="email" id="email" required>
								</div>
							</div>
						</div>
						<?}?>

						<hr class="hr-line-dashed" />
						<button type="submit" class="btn btn-primary block full-width m-b-xxs" id='btn_submit'><?=get_msg($select_lang, '수정')?></button>
					</form>
				</div>
			</div>
		</div>

<!--
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '구글 OTP 등록')?></h5>
				</div>
				<div class="ibox-content">
					<div class="well">
						<h3><i class="fa fa-google-plus"></i> <?=get_msg($select_lang, '보안 절차')?></h3>
						<small style="font-size:14px"><?=get_msg($select_lang, '로그인, 출금, 비밀번호 변경 등')?></small>
					</div>
					<div class="alert alert-info" style="margin-top:-15px">
						<i class="fa fa-check-circle-o"></i>
						<?=get_msg($select_lang, 'Google Authenticator에는 프로세스가 필요하다. 지침을 따르십시오.')?>
					</div>
					<hr class="hr-line-dashed" />
					<button type="text" class="btn btn-success block full-width m-b-xxs"
						onclick="location.href='/member/profile/auth'"><?=get_msg($select_lang, '시직')?></button>
				</div>
			</div>

		</div>
-->

		<style>
			input[type="number"]::-webkit-outer-spin-button,
			input[type="number"]::-webkit-inner-spin-button {
					-webkit-appearance: none;
					margin: 0;
			}
		</style>
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '계좌번호 등록')?></h5>
				</div>
				<div class="ibox-content">
					<form id="reg_form2" name="reg_form2" action="/member/profile/bank" method="post" onsubmit="return formCheck2(this);" class="form-horizontal">
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '계좌번호')?> :</label>
							<div class="col-lg-9"><input type="number" id="bank_num" name="bank_num" class="form-control" value="<?=$mb->bank_number?>" required /></div>
						</div>
						<hr class="hr-line-dashed" style="margin:10px 0" />

						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '은행 명')?> :</label>
							<div class="col-lg-9">
							<select id="bank_name" name="bank_name" class="form-control" value="<?=$mb->bank_name?>" required> 
                <option value="">은행명을 선택해주세요.</option>
							  <?php foreach($bankList as $value){?>
                  <option value="<?=$value->bank_name?>"><?=$value->bank_name?></option>
                <?}?>
							</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label"><?=get_msg($select_lang, '예금주')?> :</label>
							<div class="col-lg-9"><input type="text" id="bank_holder" name="bank_holder" class="form-control" value="<?=$mb->bank_holder?>" required /></div>
						</div>
						<hr class="hr-line-dashed" />
						
						<button type="submit" class="btn btn-success block full-width m-b-xxs" id='btn_submit2'><?=get_msg($select_lang, '계좌번호 등록')?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>


<script type="text/javascript">
	function formCheck() {
		var f = document.reg_form;

		$("#reg_form").hide();
		var el = document.getElementById("btn_submit");
		el.disabled = 'true';
		return true;
	}

	function before_email() {

		var f = document.reg_form;

		if (f.bf_email.value == "") {
			alert("Please enter your before email.");
			f.bf_email.focus();
			return false;
		}

		check(f.bf_email.value);

		var bf = f.bf_email.value.split('@');

		$.ajax({

			url: '/member/qmail/qsend/' + bf[0] + '/' + bf[1],
			type: "get",
			dataType: "html",
			success: function (data) {
				console.log(data);
			}
		});

		alert("Verfiy Before Email Checked!");

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

			url: '/member/qmail/qsend/' + bf[0] + '/' + bf[1],
			type: "get",
			dataType: "html",
			success: function (data) {
				console.log(data);
			}
		});

		alert(Common.Lang['Verfiy Email Checked!']);

	}

	function check(email) {
		var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;

		//이메일 형식이 알파벳+숫자@알파벳+숫자.알파벳+숫자 형식이 아닐경우	
		if (exptext.test(email) == false) {

			alert(Common.Lang['This mail format is not valid.']);

			return false;

		}

	}


	function formCheck2(frm) {

		if (frm.password.value == frm.new_password.value) {
			alert(Common.Lang['The old password and the new password are the same.']);
			frm.new_password_confirm.focus();
			return false;
		}

		if (frm.new_password.value != frm.new_password_confirm.value) {
			alert(Common.Lang['The new password check is incorrect.']);
			frm.new_password_confirm.focus();
			return false;
		}

		$("#form").hide();
		var el = document.getElementById("btn_submit2");
		el.disabled = 'true';
		return true;
	}

	function send_email2() {
		var f = document.reg_form2;

		if (f.email.value == "") {
			alert(Common.Lang['Please enter your email.']);
			f.email.focus();
			return false;
		}

		check(f.email.value);

		var bf = f.email.value.split('@');

		$.ajax({

			url: '/member/qmail/qsend/' + bf[0] + '/' + bf[1],
			type: "get",
			dataType: "html",
			success: function (data) {
				console.log(data);
			}
		});

		alert(Common.Lang['Verfiy Email Checked!']);

	}


	function formCheck3() {
		var f = document.reg_form3;

		$("#reg_form3").hide();
		var el = document.getElementById("btn_submit3");
		el.disabled = 'true';
		return true;
	}

	function mobileChange() {
		var frm = document.reg_form3;

		var e = $("#country option:selected").val();


		frm.type.value = e;
	}

	function send_sms() {
		var f = document.reg_form3;

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
			url: '/member/sms?mobile=' + $('#type').val() + $('#mobile').val(),
			type: "get",
			dataType: "html",
			success: function (data) {
				console.log(data);
			}
		});

	}
</script>