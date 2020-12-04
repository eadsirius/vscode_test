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
				<h1 class="page-title">Member Info</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Profile</a></li>
					<li class="breadcrumb-item active" aria-current="page">Member Info</li>
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
				<h3 class="mb-0 card-title">Member Edit.</h3><br>
			</div>
			<div class="card-body">				
				<div class="col-sm-12 col-lg-12">
					
					<div class="form-group col-md-12">
						<label for="name" class="input-label">
						Google OTP 앱에서 QR코드를 스캔해주세요. 또는 제공된 키 입력을 선택하시고 
						<strong style="text-decoration:underline"><?php echo $secret ?></strong>을 입력해주세요.
						</label>
                	</div>	
					<div class="form-group col-md-12">
						앱 다운로드(<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko" style="text-decoration:underline">Android</a> | <a href="https://itunes.apple.com/kr/app/google-authenticator/id388497605?mt=8" style="text-decoration:underline">iOS</a>)
					</div>
						
					<div class="form-group col-md-12">
						<img src="<?php echo $qrcode?>" />
					</div>
						
					
				</div>
			</div>
		</div>
		<!-- ROW-1 CLOSED -->
		
	</div>
</div>
<!-- CONTAINER CLOSED -->

