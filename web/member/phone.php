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
				<h1 class="page-title">Mobile Info</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Profile</a></li>
					<li class="breadcrumb-item active" aria-current="page">Mobile Info</li>
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
						</ul>
					</div>
				</div>
			</div><!-- COL END -->
		</div>
		<!-- ROW-1 CLOSED -->
		
		<!-- ROW-1 OPEN -->
		<div class="card">
			<div class="card-header">
				<h3 class="mb-0 card-title">Mobile Edit.</h3><br>
			</div>
			<div class="card-body">				
				<div class="col-sm-12 col-lg-12">
					<form name="reg_form" action="<?=current_url()?>" method="post" onsubmit="return formCheck();">

					<input type="hidden" name="type" id="type" value="<?=$mb->country?>">
					<div class="form-group col-md-12">
						<label class="form-label">Phone Sns</label>
						<select  name="country" id="country" required itemname="Country" style="width: 100%; height: 40px;" class="form-control" onchange="mobileChange()" >
							<option value='' >Selected Country</option>
							<? foreach ($country as $row) { ?>
							<option value='<?=$row->phone_code?>' <?if($row->phone_code == $mb->country){?>selected<?}?> ><?=$row->country_name?></option>
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
					
					<div class="form-group">
						<input type="submit" id='btn_submit' value="Edit" class="btn btn-primary btn-lg btn-block btn-theme-colored btn-lg">
					</div>
					</form>	
				</div>
			</div>
		</div>
		<!-- ROW-1 CLOSED -->
		
	</div>
</div>
<!-- CONTAINER CLOSED -->

<script type="text/javascript">
function formCheck() 
{	
	var f = document.reg_form;
        
    $("#form").hide();
	var el = document.getElementById("btn_submit");
	el.disabled = 'true';
	return true;
}


function mobileChange() 
{
    var frm = document.reg_form;
    
    var e = $("#country option:selected").val();
    
	
	frm.type.value = e;
}

function send_sms() {
    var f = document.reg_form;

    if (f.mobile.value == "") {
        alert("Please enter your cell phone number.");
        f.mobile.focus();
        return false;
    }

    if (f.country.value == "") {
        alert("Please select a country");
        f.country.focus();
        return false;
    }
        
    $.ajax({	    
        url:'/member/sms?mobile=' + $('#type').val() + $('#mobile').val(),
        type: "get",
        dataType:"html",
        success: function(data){
            console.log(data);
        }
    });

}
</script>