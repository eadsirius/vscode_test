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
				<h1 class="page-title">Google Otp</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Profile</a></li>
					<li class="breadcrumb-item active" aria-current="page">Google Otp</li>
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
				<h3 class="mb-0 card-title">OTP 인증</h3><br>
			</div>
			<div class="card-body">				
				<div class="col-sm-12 col-lg-12">
					
					<div class="form-group col-md-12">			
						<p class="mainText">
						이 기능은 아이폰 OS와 안드로이드 스마트폰 기기에서 지원됩니다.<br/>				
						먼저 스마트폰 (Android, iOS) App 프로그램을 설치해야합니다.</p>			
						<p class="subText1">				
							1. PlayStore(Android) 또는 AppStore(iPhone)의 Google Authenticator 앱을 다운로드하여 설치 하십시오.<br/>				
							2. 스마트폰의 시간 업데이트가 자동으로 작동하지 않으면 구글 인증 앱이 정확한 코드를 생성하지 못하므로 아래 이미지를 확인하여 정확한지 확인하십시오.			
						</p>
                	</div>	
					<div class="form-group col-md-12">					
						<div class="imgW">				
							<ul>					
								<li><img src="/assets/images/otp_img01.jpg"/><br/>iOS : Setting->General-Date/time</li>					
								<li><img src="/assets/images/otp_img02.jpg"/><br/>Android : Setting->General->Date/time</li>				
							</ul>		
						</div>
                	</div>
						
					<div class="form-group col-md-12">
						<?php if($exists) {?>				
						<form name="frmOTPRemove" autocomplete="off" action="/account/otp/remove/">					
							<div class="mainText">OTP 인증을 사용 중입니다.</div>					
							<input type="hidden" name="dataType" value="json"/>					
							<div class="input-group">						
								<label><input type="password" name="confirm" value="" autocomplete="off" placeholder="비밀번호를 입력하세요" maxlength="40"/></label>						
								<span class="input-group-btn"><button type="submit" class="btn">OTP 삭제</button></span>					
							</div>				
						</form>			
						<?php } else {?>			
						<p class="subText2">				
							3. Google Authenticator 설치가 완료 되었으면 다음 단계로 이동합니다.			
						</p>			
						<div class="formSubmitBtW"><a href="" id="otp-generator" class="btn-submit">다음단계</a></div>			
						<?php }?>
                	</div>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>	
					<div class="form-group col-md-12">	
						<div class="otpSection2 ">			
							<h4>OTP인증 사용하기</h4>			
							<p class="mainText">Google Authenticator 앱에서 "계정설정" -> "바코드스캔" 을 이용하여 바코드를 스캔 하십시오.</p>			
							<div class="imgW">				
								<ul>					
									<li class="img"><img id="otp-secure-qr" width="200" height="200"/></li>					
									<li class="con">						
										<p class="text">바코드 스캔을 이용할수<br/>없으면 아래키를 입력할 수 있습니다.</p>						
										<p class="num" id="otp-secure-code">&nbsp;</p>					
									</li>				
								</ul>			
							</div>		
						</div>		
						<div class="otpSection3 ">			
							<h4>인증번호 입력</h4>			
							<p class="mainText">OTP 인증앱에 표시된 인증번호 6자리를 입력해 주십시오.</p>			
							<form name="frmOtp" autocomplete="off">				
								<input type="hidden" name="dataType" value="json" />				
								<div class="input-group">					
									<label><input type="text" name="codeValue" value="" autocomplete="off" maxlength="6" placeholder="OTP 인증번호를 입력하세요" /></label>					
									<span class="input-group-btn"><button type="submit" class="btn">OTP 등록</button></span>				
								</div>				
								<p class="alterText">					
									<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp; 한번 실패한 인증번호는 다시 사용할 수 없습니다. 인증번호를 틀렸을 경우, [새로고침] 후 다시 시도하세요.				
								</p>			
							</form>		
						</div>	
					</div>
					
				</div>
			</div>
		</div>
		<!-- ROW-1 CLOSED -->
		
	</div>
</div>
<!-- CONTAINER CLOSED -->
			
<script type="text/javascript">	
	$(document).ready(function() {		
		var form = $('form[name="frmOtp"]');		
		$('#otp-generator').one('click', function(event) {			
			event.preventDefault();			
			this.onclick=new Function('return false;');			
			$.post('/account/otp/generator/', {'mb_id': '<?=$member['mb_id']?>', 'dataType': 'json'}, function(data) {				
				$('#otp-secure-qr').attr('src', data.qrCode);				
				$('#otp-secure-code').text(data.secretKey);				
				$('DIV.otpSection2, DIV.otpSection3').show();				
				$('#otp-generator').addClass('disabled');				
				form.attr('action', data.verifyURL);			
			});		
		});		
		form.submit(function(event) {			
			event.preventDefault();			
			if (!form.attr('action')) return false;			
			if (!form.find('INPUT[name="codeValue"]').val()) {				
				alert('인증번호를 입력하세요.');				
				
				form.find('INPUT[name="codeValue"]').focus();				
				return false;			
			}			
			$.post(form.attr('action'), form.serialize(), function(data){				
				alert(data.Message);				
				data.Ack=='Success' && (window.location.href='/account/me/level/?timestamp=' +Math.floor((new Date).getTime() / 1000) + '/#next');			
			});		
		});		
		$('form[name="frmOTPRemove"]').submit(function(event) {			
			if (!$.trim(this.confirm.value)) {				
				alert('비밀번호를 입력하세요.');				
				this.confirm.focus();				
				return false;			
			}			
		return confirm('등록된 OTP를 삭제하시겠습니까?');		
		});
	});
</script>