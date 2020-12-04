<?php
include_once('./_common.php');
?>
<div style="background:#fbfbfb;min-height:300px;padding:10px">
<?php if($_GET['type']==3){ ?>
	<span class="help">OTP 연결을 해제하기 위해, 아이디와 이메일을 입력해주세요.</span>
	<form action="<?php echo G5_BBS_URL?>/googleotp_remove_update.php" method="post">
		<input type="hidden" name="type" value="3" />
		<input type="text" name="mb_id" placeholder="아이디" style="width:185px;height:32px;padding:0 10px;border:1px solid #000;" />
		<input type="text" name="email" placeholder="이메일" style="width:185px;height:32px;padding:0 10px;border:1px solid #000;" />
		<input type="submit" value="인증" style="width:40px;height:32px;padding:0 10px;border:1px solid #000;"/>
	</form>
<?php } elseif($_GET['type']==2){ ?>
	<span class="help">OTP 연결을 해제하기 위해, 아이디와 보안코드를 입력해주세요.</span>
	<form action="<?php echo G5_BBS_URL?>/googleotp_remove_update.php" method="post">
		<input type="hidden" name="type" value="2" />
		<input type="text" name="mb_id" placeholder="아이디" style="width:185px;height:32px;padding:0 10px;border:1px solid #000;" />
		<input type="text" name="otpcode" placeholder="보안코드 6자리" style="width:185px;height:32px;padding:0 10px;border:1px solid #000;" />
		<input type="submit" value="인증" style="width:40px;height:32px;padding:0 10px;border:1px solid #000;"/>
	</form>
<?php } else { 
	if($member['mb_level']>1){
?>
	<span class="help">OTP 연결을 해제하기 위해, 인증코드 6자리를 입력해주세요.</span>
	<form action="<?php echo G5_BBS_URL?>/googleotp_remove_update.php" method="post">
		<input type="hidden" name="type" value="1" />
		<input type="text" maxlength="6" name="otpcode" placeholder="인증코드 6자리" style="width:185px;height:32px;padding:0 10px;border:1px solid #000;" />
		<input type="submit" value="인증" style="width:40px;height:32px;padding:0 10px;border:1px solid #000;"/>
	</form>
<?php }	else {
	alert("로그인 상태에서만 해제할 수 있습니다.");
	}
} ?>
</div>