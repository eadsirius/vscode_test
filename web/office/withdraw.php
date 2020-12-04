<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=get_msg($select_lang, '출금')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '출금')?></a>
			</li>
			<li class="active">
				<strong><?=get_msg($select_lang, '출금')?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row m-b-lg m-t-md">
		<div class="col-md-12">

			<div class="profile-image text-center">
				<i class="fa fa-exchange fa-5x"></i>
			</div>
			<div class="profile-info">
				<div class="">
					<div>
						<h2 class="no-margins">
							<?=get_msg($select_lang, '출금 내역')?>
						</h2>
						<table class="table m-t-md m-b-xs">
							<tbody>
								<tr>
									<td><strong><?=get_msg($select_lang, '수당 총액')?> :</strong> <span
											class="font-bold text-primary"><?=number_format($bal->total_point,0)?> P</span></td>
									<td><strong><?=get_msg($select_lang, '총 출금 POINT')?> :</strong> <?=number_format($bal->Withdrawn_point,0)?> P</td>
									<td><strong><?=get_msg($select_lang, '총 출금 신청 POINT')?> :</strong> <?=number_format($bal->withdraw_point,0)?> P</td>
									<td><strong><?=get_msg($select_lang, '출금가능 POINT')?> :</strong> <?=number_format($bal->total_point-$bal->withdraw_point,0)?> P
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '출금 신청')?></h5>
				</div>
				<div class="ibox-content">

					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-success alert-dismissable">
								<?$msg = ' Point를 출금하면 WNS로 자동전환되어 출금됩니다. 인출 수수료는' .$site->cfg_send_persent*100 .'% 입니다.';?>
								<?$msg1 = '최소 출금금액은 ' .number_format($site->cfg_send_point) .'P 입니다.';?>
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								<i class="fa fa-check-circle-o"></i> <?=get_msg($select_lang, $msg)?><br>
								<i class="fa fa-check-circle-o"></i> <?=get_msg($select_lang, $msg1)?>
							</div>
							<form name="reg_form" action="/office/withdraw/exchange" method="post" onsubmit="return formCheck();"
								class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label"><?=get_msg($select_lang, '출금 가능 잔액')?></label>
									<div class="col-sm-10">
										<select class="form-control m-b" name="price" id="price">
											<option value="$bal->total_point"><?=number_format($bal->total_point-$bal->withdraw_point,0)?> P</option>
										</select>
									</div>
								</div>
									<input type="hidden" name="radio_btn" id="radio_btn" value="p" checked>
									<input type="hidden" name="confing" id="confing" required>
							
										<!-- <div class="i-checks"><label> <input type="radio" name="radio_btn" id="radio_btn" value="p"> <i></i>
												<?=get_msg($select_lang, '출금 비밀번호')?> </label></div>
										<div class="i-checks"><label> <input type="radio" name="radio_btn" id="radio_btn" value="g"> <i></i>
												<?=get_msg($select_lang, '구글 OTP')?> </label></div> -->
								
								<hr class="hr-line-dashed" />
								<button type="submit"
									class="btn btn-lg btn-block btn-primary m-t-md"><?=get_msg($select_lang, '출금 신청')?></button>
								<!-- <button type="button" class="btn btn-lg btn-block btn-primary m-t-md"><?=get_msg($select_lang, '출금 신청')?></button> -->
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>
<link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
	$(document).ready(function () {
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	});
</script>

<script type="text/javascript">
	function formCheck() {
		document.getElementById('confing').value
		var f = document.reg_form;
		var radio_btn = document.getElementsByName("radio_btn");

		//라디오 버튼이 체크되었나 확인하기 위한 변수
		var radio_btn_check = 0;
		for (var i = 0; i < radio_btn.length; i++) {
			//만약 라디오 버튼이 체크가 되어있다면 true
			if (radio_btn[i].checked == true) {
				//라디오 버튼 값
				var con = radio_btn[i].value;
				radio_btn_check++;
			}
		}

		if (typeof con == "undefined") {
			con = "";
		}
		document.getElementById('confing').value = con;


		$("#form").hide();
		//$(".wait").show();      
		document.getElementById("btn_submit").disabled = "disabled";
		return true;
	}

	function CheckAll() {
		var f = document.reg_form;
		var radio_btn = document.getElementsByName("radio_btn");

		//라디오 버튼이 체크되었나 확인하기 위한 변수
		var radio_btn_check = 0;
		for (var i = 0; i < radio_btn.length; i++) {
			//만약 라디오 버튼이 체크가 되어있다면 true
			if (radio_btn[i].checked == true) {
				//라디오 버튼 값
				var con = radio_btn[i].value;
				radio_btn_check++;
			}
		}


		document.getElementById('confing').value = con;
	}


	function feeChange(fee, obj) {
		obj.parent().find("button").removeClass("active");
		obj.addClass("active");
		document.getElementById('fee').value = fee;
	}
</script>