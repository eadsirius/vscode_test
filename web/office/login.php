<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$select_lang = 'kr';
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
	<script src="/assets/js/common.js?<?=today()?>"></script>
	<script src="/assets/js/lang_<?=$select_lang?>.js?<?=today()?>"></script>
</head>

<body id="login" class="gray-bg " >
<?
/*
?>
	<div class="popup-wrap" onclick="close_btn()">
	<div class="popup-overlay"></div>
	<div class="popup">
		<div class="inner">
			<div class="error-popup">
				<a href="#" class="close-btn">X</a>
				<h3 class="title">USNS 공지사항</h3>
				<p class="desc"> USNS 업그레이드 중입니다 </p>
				<p class="desc">1) 기간 : 20년06월 03인부터  06월 26일까지 입니다 </p>
				<p class="desc">2) 업그레이드 기간 중에 USNS 토큰 입금 처리가 되지 않습니다.</p>
				<p class="desc">3) 업그레이드 기간 중에 수당은 정상적으로 처리됩니다.</p>
				<p class="desc">4) 업그레이드 기간 중에 SVP 매출이 되지 않습니다. </p>
				<p class="desc">5) 업그레이드 기간 중에 SVP 재매출이 되지 않습니다. </p>
				<p class="desc">6) 업그레이드 기간 중에 회원가입은 불가능 합니다. </p>
				<p class="desc">7) 업그레이드 기간 중에 SVP출금 은 불가능 합니다. </p>
				</p>
			</div>
		</div>
	</div>
	</div>
<? */?>

	<div class="middle-box animated fadeInDown">
		<div class="row">
			<div class="ibox-content" style="background-color:#424242; margin:0 auto">
				<div class="text-center">
					<h1 class="logo-login"><img class="iamge" src="/assets/img/logo.png" /></h1>
				</div>

				<form class="m-t" role="form" action="/member/login" method="post" accept-charset="utf-8" name="member_login">
					<div class="form-group">
					<div class="dropdown" style="text-align:right">
						<!-- 	<?
							if ($select_lang == "us") {
						?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
								<img alt="Korea" src="/assets/img/lang/ico_lang_en.png"> English 
							</a>
						<?
							} elseif ($select_lang == "kr") {
						?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
								<img alt="Korea" src="/assets/img/lang/ico_lang_ko.png"> Korea 
							</a>
						<?
							} elseif ($select_lang == "cn") {
						?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
								<img alt="Korea" src="/assets/img/lang/ico_lang_cn.png"> China 
							</a>
						<?
							} else if ($select_lang == "jp") {
						?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
								<img alt="Korea" src="/assets/img/lang/ico_lang_jp.png"> Japan 
							</a>
						<?
							}
						?>-->
							<ul class="dropdown-menu animated fadeInRight m-t-xs pull-right" style="display: none;">
								<!-- <li><a href="#" onclick="fnSelectLang('us');return false;"><img alt="English" class="" src="/assets/img/lang/ico_lang_en.png"> <strong>English</strong></a></li> -->
								<!-- <li><a href="#" onclick="fnSelectLang('kr');return false;"><img alt="Korea" class="" src="/assets/img/lang/ico_lang_ko.png"> <strong>Korea</strong></a></li> -->
								<!-- <li><a href="#" onclick="fnSelectLang('cn');return false;"><img alt="China" class="" src="/assets/img/lang/ico_lang_cn.png"> <strong>China</strong></a></li> -->
								<!-- <li><a href="#" onclick="fnSelectLang('jp');return false;"><img alt="China" class="" src="/assets/img/lang/ico_lang_jp.png"> <strong>Japan</strong></a></li> -->
							</ul>
						</div> 
					</div>
					<div class="form-group">
						<div class="input-group m-b">
							<span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="id" class="form-control" style="font-size: 18px;" placeholder="<?=get_msg($select_lang, '회원 ID')?>" required="" name="member_id" id="member_id" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group m-b">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span> <input type="password" class="form-control" style="font-size: 18px;" placeholder="<?=get_msg($select_lang, '비밀번호')?>" required="" name="password" id="password" />
						</div>
						
					</div>

					<p class="m-b">
						<a href="#" data-toggle="modal" data-target="#pwCheck"><small style="color:white"><?=get_msg($select_lang, '비밀번호를 잊어버렸습니까?')?></small></a>
					</p>


					<?php if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") { ?>
						<button type="submit" style="font-size: 18px;" class="btn btn-primary block full-width m-b"><?=get_msg($select_lang, '로그인')?></button>
					<?} else { ?>
						<button type="submit" style="font-size: 18px;" class="btn btn-primary block full-width m-b"><?=get_msg($select_lang, '로그인')?></button>
						<!-- <button type="button" onclick="javascript:alert('시스템 점검으로 한시간 이후 접속이 가능합니다.');" class="btn btn-primary block full-width m-b"><?=get_msg($select_lang, '로그인')?></button> -->
					<?}?>
					

					<p class="text-muted text-center">
						<small><?=get_msg($select_lang, '회원이 아닙니까?')?></small> <a href="/member/register"><small style="color:white;"><?=get_msg($select_lang, '지금 가입하세요')?>!</small></a>
					</p>

					<hr />

					<div class="m-t text-center" style="color: white;">
						Copyright WNS &copy; 2020
					</div>
				</form>
			</div>
		</div>
	</div>



	<div class="modal inmodal" id="pwCheck" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content animated fadeIn">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<i class="fa fa-clock-o modal-icon"></i>
					<h4 class="modal-title"><?=get_msg($select_lang, '비밀번호를 잊어버렸습니까?')?></h4>
					<small><?=get_msg($select_lang, '이메일 주소를 입력하면 비밀번호가 재설정되어 이메일로 발송됩니다.')?></small>
				</div>
				<div class="modal-body">
					<form class="m-t" role="form" name="reg_form" action="/member/psearch/emailSend" method="post" onsubmit="return formCheck(this);">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="<?=get_msg($select_lang, '회원 ID')?>" required="" name="user_id" id="user_id">
							<input type="email" class="form-control" placeholder="<?=get_msg($select_lang, '이메일 주소')?>" required="" name="email" id="email">
						</div>

						<button type="submit" class="btn btn-primary block full-width m-b"><?=get_msg($select_lang, '새 비밀번호 보내기')?></button>

					</form>
				</div>
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
<script language="javascript">
$('.close_pop').click(function(){
	$('.no_popup').hide();
})

function formCheck(frm) 
{    
	if (frm.uesr_id.value == '') {
		alert(Common.Lang['Please enter an ID']);
		frm.email.focus();
		return false;
	}
	if (frm.email.value == '') {
		alert(Common.Lang['Please enter an email address']);
		frm.email.focus();
		return false;
	}
	return true;
}
var fnSelectLang = function (sel_lang) {
	Common.FnCookies("lang", sel_lang, 365);
	history.go(0);
}
</script>
</body>
</html>