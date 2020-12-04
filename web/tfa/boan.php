<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div style="background:#fbfbfb;min-height:300px;padding:10px">
	<h1>2단계 로그인 인증</h1>
		<p><span class="help">2단계 인증을 설정하여 계정을 보호하세요.</span></p>
<?php if($member['mb_10']){ ?>
		<div style="background:#dddddd;padding:15px;">
			<a href="<?php echo G5_BBS_URL ?>/googleotp_remove.php?type=1" class="btn_admin" style="padding:5px 10px;">OTP 해제하기 #1</a>
			<span class="help">인증코드 입력을 통해 OTP 연결을 해제합니다.</span>
		</div>
		<div style="background:#dddddd;padding:15px;;margin-top:10px;">
			<a href="<?php echo G5_BBS_URL ?>/googleotp_remove.php?type=2" class="btn_admin" style="padding:5px 10px;">OTP 해제하기 #2</a>
			<span class="help">보안토큰 입력을 통해 OTP 연결을 해제합니다.</span>
		</div>
		<div style="background:#dddddd;padding:15px;;margin-top:10px;">
			<a href="<?php echo G5_BBS_URL ?>/googleotp_remove.php?type=3" class="btn_admin" style="padding:5px 10px;">OTP 해제하기 #3</a>
			<span class="help">이메일 인증을 통해 OTP 연결을 해제합니다.</span>
		</div>
<?php } else { ?>
		<div style="background:#dddddd;padding:15px;">
			<a href="<?php echo G5_BBS_URL ?>/googleotp_register.php" class="btn_admin" style="padding:5px 10px;">OTP 등록하기</a>
			<span class="help">새 OTP를 등록합니다. 반드시 Google OTP(Google Authenticator) 프로그램을 설치한 후 진행해주세요. 다운로드(<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko" style="text-decoration:underline">Android</a> | <a href="https://itunes.apple.com/kr/app/google-authenticator/id388497605?mt=8" style="text-decoration:underline">iOS</a>)</span>
		</div>
<?php } ?>
</div>