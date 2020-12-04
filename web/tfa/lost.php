<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div style="background:#fbfbfb;min-height:300px;padding:10px">
	<h1>2단계 로그인 인증</h1>
		<p><span class="help">OTP를 분실하셨습니까?</span></p>
		<div style="background:#dddddd;padding:15px;;margin-top:10px;">
			<a href="<?php echo G5_BBS_URL ?>/googleotp_remove.php?type=2" class="btn_admin" style="padding:5px 10px;">OTP 분실 복원 #1</a>
			<span class="help">보안토큰 입력을 통해 OTP 연결을 해제합니다.</span>
		</div>
		<div style="background:#dddddd;padding:15px;;margin-top:10px;">
			<a href="<?php echo G5_BBS_URL ?>/googleotp_remove.php?type=3" class="btn_admin" style="padding:5px 10px;">OTP 분실 복원 #2</a>
			<span class="help">이메일 인증을 통해 OTP 연결을 해제합니다.</span>
		</div>
</div>