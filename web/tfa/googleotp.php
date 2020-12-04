<?php
include_once('./_common.php');


?>
<div style="background:#fbfbfb;min-height:300px;padding:10px">
	<p><span class="help">Google OTP 인증이 필요한 아이디입니다.</span></p>
	<form action="<?php echo G5_BBS_URL?>/googleotp_login.php" method="post">
		<input type="text" maxlength="6" name="otpcode" placeholder="인증코드 6자리" style="width:185px;height:32px;padding:0 10px;border:1px solid #000;" />
		<input type="submit" value="인증" style="width:40px;height:32px;padding:0 10px;border:1px solid #000;"/>
		<br /><a href="<?php echo G5_BBS_URL?>/boan.php?lost=1">인증키를 분실하셨습니까?</a>
	</form>
</div>