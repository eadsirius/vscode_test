<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang');
?>


<!-- Start main-content -->
<div class="main-content">
    <!-- Section: home -->
    <section id="home" class="divider bg-lighter">
	    <div class="display-table">
		    <div class="display-table-cell">
			    <div class="container pb-50">
				    <div class="row">
					    <div class="col-md-6 col-md-push-3">
						    <div class="text-center mb-20"><a href="/" class=""><img alt="" src="/assets/images/uce1.png" width="200"></a></div>
						    <div class="bg-lightest border-1px p-25">
							    <h4 class="text-theme-colored text-uppercase m-0">Forgot password</h4>
							    <div class="line-bottom mb-20"></div>
								<p>비밀번호 초기화 - 인증번호를 입력해주세요.</p>
								
								<form name="reg" action="/member/psearch/presult" method="post" onsubmit="return formCheck(this);" class="form_normal">
								<input type="hidden" name="mobile" value="<?=$mobile?>">
								<input type="hidden" name="revsns" value="<?=$revsns?>">
									<div class="col-sm-12">
										<div class="form-group mb-10">
											<label for="name" class="input-label">SNS 인증번호*</label>
											<input type="text" name="sns" class="form-control" required>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group mb-10">
											<label for="name" class="input-label">새 비밀번호*</label>
											<input type="password" name="new_password" class="form-control" required>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group mb-10">
											<label for="name" class="input-label">새 비밀번호 확인*</label>
											<input type="password" name="new_password_confirm" class="form-control" required>
										</div>
									</div>
									<div class="form-group mb-0 mt-20" style="margin-left: 15px;">
										<button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">비밀번호 생성하기</button>
                    				</div>
                    			</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>  
<!-- end main-content -->


<script language="javascript">
function formCheck(frm) 
{    
    if (frm.new_password.value != frm.new_password_confirm.value) {
        alert("새 비밀번호 확인이 틀립니다.");
        frm.new_password_confirm.focus();
        return false;
    }
    return true;
}
</script>