<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<!--app-content open-->
<div class="app-content">
	<div class="side-app">

		<!-- PAGE-HEADER -->
		<div class="page-header">
			<div>
				<h1 class="page-title">Transfer Security Settings</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Profile</a></li>
					<li class="breadcrumb-item active" aria-current="page">Transfer Security Settings</li>
				</ol>
			</div>
			<div class="d-flex  ml-auto header-right-icons header-search-icon">
				<div class="dropdown profile-1">
					<a href="#" data-toggle="dropdown" class="nav-link pr-2 leading-none d-flex">
						<span>
							<img src="/assets/images/users/10.jpg" alt="profile-user" class="avatar  profile-user brround cover-image">
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
						<div class="drop-heading">
							<div class="text-center">
								<h5 class="text-dark mb-0"><?=$this->session->userdata('member_id')?></h5>
								<small class="text-muted"><?=$mb->mobile?></small>
							</div>
						</div>
						<div class="dropdown-divider m-0"></div>
						<a class="dropdown-item" href="/member/profile">
							<i class="dropdown-icon mdi mdi-account-outline"></i> Profile
						</a>
						<a class="dropdown-item" href="/member/profile/password">
							<i class="dropdown-icon  mdi mdi-settings"></i> password
						</a>
						<a class="dropdown-item" href="/member/profile/passwordEx">
							<span class="float-right"></span>
							<i class="dropdown-icon mdi  mdi-message-outline"></i> Transfer Password
						</a>
						<a class="dropdown-item" href="/member/login/out">
							<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
						</a>
					</div>
				</div>
				<div class="dropdown d-md-flex">
					<a class="nav-link icon full-screen-link nav-link-bg">
						<i class="fe fe-maximize fullscreen-button"></i>
					</a>
				</div><!-- FULL-SCREEN -->
			</div>
		</div>
		<!-- PAGE-HEADER END -->
		
		<!-- ROW-1 OPEN -->
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Member Base info.</h3>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<li class="list-group-item active">Member ID : <?=$this->session->userdata('member_id')?></li>
							<li class="list-group-item">Name :</span> <?=$mb->name?></li>
							<li class="list-group-item">Reg.Date :</span> <?=$mb->regdate?></li>
						</ul>
					</div>
				</div>
			</div><!-- COL END -->
		</div>
		<!-- ROW-1 CLOSED -->
		
		<!-- ROW-1 OPEN -->
		<div class="card">
			<div class="card-header">
				<h3 class="mb-0 card-title">Transfer Security Settings</h3><br>
			</div>
			<div class="card-body">				
				<div class="col-sm-12 col-lg-12">
					<form name="reg_form" action="<?=current_url()?>" method="post" onsubmit="return formCheck(this);">
					<div class="form-group col-md-12">
						<label for="name" class="input-label">Current Password</label>
						<input type="password" id="password" name="password" class="form-control" required>
                	</div>
					<div class="form-group col-md-12">
						<label for="name" class="input-label">New Password</label>
						<input type="password" id="new_password" name="new_password" class="form-control" required>
                	</div>
					<div class="form-group col-md-12">
						<label for="name" class="input-label">Confirm Password</label>
						<input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" required>
                	</div>
                	
                	
					<?if($site->cfg_phone_reg == 1 and $site->cfg_phone_view == 1){?>
					<input type="hidden" name="type" id="type" value="0">
					<div class="form-group col-md-12">
						<label class="form-label">Phone Sns</label>
						<select  name="country" id="country" required itemname="Country" style="width: 100%; height: 40px;" class="form-control" onchange="mobileChange()" >
							<option value='' >Selected Country</option>
							<? foreach ($country as $row) { ?>
							<option value='<?=$row->phone_code?>' ><?=$row->country_name?></option>
							<? } ?>
						</select>
					</div>
					
					<div class="form-group col-md-12">
						<label for="name" class="input-label">Mobile Phone Number</label>
                	</div>	
					<div class="form-group col-md-12">
						<input type="text" name="mobile" id="mobile" value="<?=$mb->mobile?>" class="input10" required>
							
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="zmdi zmdi-smartphone" aria-hidden="true"></i>
						</span>
						<button type="button" class="btn btn-info" onclick="send_sms()" style="height: 46px;"><i class="fa fa-check"></i> SNS Send</button>
					</div>
						
					<div class="form-group col-md-12">
						<input type="text" name="authcode" id="authcode" maxlength="6" required placeholder="SNS CODE" class="input100">
					</div>						
					<?}?>
					
                	
					<div class="form-group col-md-12">
						<label for="name" class="input-label">Email</label>
                	</div>
					<?if($site->cfg_mail_view == 1 and $site->cfg_mail_reg == 1){ // 선인증?>
					<div class="form-group col-md-12">
						<input type="text" name="email" id="email" value="<?=$mb->email?>" class="input10" required>
							
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="zmdi zmdi-email" aria-hidden="true"></i>
						</span>
						<button type="button" class="btn btn-info" onclick="send_email()" style="height: 46px;"><i class="fa fa-check"></i> Email Send</button>
					</div>
						
					<div class="form-group col-md-12">
						<input type="text" name="mailcode" id="mailcode" maxlength="6" required placeholder="Verification code" class="input100">
					</div>
					<?}?>
					
					
					<div class="form-group">
						<input type="submit" id='btn_submit' value="Edit" class="btn btn-primary btn-lg btn-block btn-theme-colored btn-lg">
					</div>
					</form>	
					<a href="/member/profile/password"><button class="btn btn-default "><i class="fa fa-unlock-alt"></i> Password</button></a>
					<a href="/member/profile"><button class="btn btn-default "><i class="fa fa-user-plus"></i> Profile</button></a>
				</div>
			</div>
		</div>
		<!-- ROW-1 CLOSED -->
		
	</div>
</div>
<!-- CONTAINER CLOSED -->

<script language="javascript">
function formCheck(frm) {
	
    if (frm.password.value == frm.new_password.value) {
        alert("The old password and the new password are the same.");
        frm.new_password_confirm.focus();
        return false;
    }
    
    if (frm.new_password.value != frm.new_password_confirm.value) {
        alert("The new password check is incorrect.");
        frm.new_password_confirm.focus();
        return false;
    }
        
    $("#form").hide();
	var el = document.getElementById("btn_submit");
	el.disabled = 'true';
	return true;
}
</script>