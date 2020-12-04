<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<!-- navbar -->
	<div class="navbar navbar-pages">
		<div class="container">
			<div class="content">
				<h4><a href="" class="link-back"><i class="fa fa-arrow-left "></i></a> EL 보내기</h4>
			</div>
			<div class="content-right">
				<a href="/"><i class="fa fa-home"></i></a>
			</div>
		</div>
	</div>
	<!-- end navbar -->

	<!-- features -->
	<div class="features segments-page">
		<div class="container-pd">
			<div class="row">
				<div class="col-12 px-2">
					<div class="content b-shadow">
						<h4>EL 보내기</h4>
						<p>이체에 주의 하세요 한번 승인된 거래는 되 돌릴수 없습니다.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 px-2">
					<div class="content b-shadow">
						<h4>EL 잔고</h4>
						<p><?=number_format($elcBal,2)?> EL</p>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="container-pd">
			<div class="contact-contents b-shadow">
			<form name="reg" action="<?=current_url()?>" method="post" onsubmit="return formCheck(this);" class="wpcf7-form" >
			<input type="hidden" name="bal" class="form-control" value="<?=$elcBal?>" >
			<input type="hidden" name="fee" class="form-control" value="0.01" >
			<box>            
               	<div class="input-simple-2 has-icon input-red bottom-15">
				   	<input type="text" name="rev_id" id="rev_id" value="" required placeholder="받으실분의 EOS 계정을 입력하세요">
               	</div>
               	
			   	<div class="input-simple-2 has-icon input-red bottom-15">
				   <input type="text" name="count" value="" required placeholder="보낼 EL수량">
				</div>
               	
			   	<div class="input-simple-2 has-icon input-red bottom-15">
				   <input type="text" name="fee" value="0.01" placeholder="이체 수수료" disabled value="0.01">
				</div>
				<input type="submit" class="buttonWrap button button-green contactSubmitButton" value="EL 전송하기" />
				<div class="clear"></div>	
			</box>			 
			</form>
			</div>
		</div>
	</div>
	<!-- end features -->
	
<script language="javascript">
function formCheck(frm) {
    if (frm.rev_id.value == "") {
        alert("받으실 분의 아이디 또는 지갑 주소를 입력하세요");
        frm.rev_id.focus();
        return false;
    }
    if (frm.count.value == "") {
        alert("이체 하실 금액을 입력하세요");
        frm.count.focus();
        return false;
    }
    return true;
}
</script>