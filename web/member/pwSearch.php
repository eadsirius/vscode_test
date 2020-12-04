<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang');
?>
<!-- BACKGROUND-IMAGE -->
<div class="login-img">
	<!-- GLOABAL LOADER -->
	<div id="global-loader">
		<img src="/assets/images/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- /GLOABAL LOADER -->

	<!-- PAGE -->
	<div class="page">
		<div class="">
		    <!-- CONTAINER OPEN -->
			<div class="col col-login mx-auto">
				<div class="text-center">
					<img src="/assets/images/qmW.png" class="header-brand-img" alt="">
				</div>
			</div>
			<div class="container-login100">
				<div class="wrap-login100 p-6" style="width: 100%">
					<form name="reg_form" action="/member/psearch/emailSend" method="post" onsubmit="return formCheck(this);" class="form_normal">
						<span class="login100-form-title">
							Forgot password
						</span>
						<div class="col-sm-12">
							<div class="form-group mb-10">
								<label for="name" class="input-label">Email*</label>
								<input type="text" name="email" id="email" class="form-control" required>
							</div>
						</div>
						<div class="form-group mb-0 mt-20" style="margin-left: 15px;">
							<button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Email Send</button>
                    	</div>
					</form>
				</div>
			</div>
			<!-- CONTAINER CLOSED -->
		</div>
	</div>
	<!-- End PAGE -->

</div>
<!-- BACKGROUND-IMAGE CLOSED -->



<script language="javascript">
function formCheck(frm) 
{    
    if (frm.email.value == '') {
        alert("Please enter an email address");
        frm.email.focus();
        return false;
    }
    return true;
}
</script>