<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<!--app-content open-->
<div class="app-content">
	<div class="side-app">

		<!-- PAGE-HEADER -->
		<div class="page-header">
			<div>
				<h1 class="page-title">Transfer</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Bitcoin</a></li>
					<li class="breadcrumb-item active" aria-current="page">Transfer</li>
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
						<h3 class="card-title">Bitcoin Information</h3>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<li class="list-group-item active">Address : <?=$wallet->wallet?></li>
							<li class="list-group-item">Bitcoin Balance : <?=number_format($bal->coin,4)?>Btc</li>
						</ul>
						<a href="/token/send/lists"><input type="button" value="Transfer List" class="btn btn-info btn-sm mb-1"></a>
					</div>
				</div>
			</div><!-- COL END -->
		</div>
		<!-- ROW-1 CLOSED -->
		
		<!-- ROW-1 OPEN -->
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Bitcoin Deposit</h3>
					</div>
					<div class="card-body">
						
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 1HBtc = <?=$site->cfg_usd?>USD<br>
						</div>
						<div class="alert alert-info" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-bell-o mr-2" aria-hidden="true"></i>The Withdraw fee is 0%.
						</div>
						
						<div class="example">
						<form name="reg" action="<?=current_url()?>" method="post" onsubmit="return formCheck(this);">
						<input type="hidden" name="send_persent" id="send_persent" value="<?=$site->cfg_send_persent?>" >
						<input type="hidden" name="rev_id_enabled" id="rev_id_enabled" value="" >
						<article class="post clearfix mb-30 pb-30">
							<div class="entry-content border-1px p-20">
								<div class="form-group col-md-12">
									<label>Recipient Wallet Address</label>
									<input type="text" name="rev_id" id="rev_id" value="<?=@$addr?>" class="form-control" required onblur='addresscheck();'>
                				</div>
								<div class="form-group col-md-8">
									<label>Number of BTC to Trans</label>
									<input type="text" name="count" id="count" value="" required class="form-control" required onkeyup='call()'>
                				</div>
								<div class="form-group col-md-8">
									<label>Fee.</label>
									<input type="text" name="fee" id="fee" value="" class="form-control" required>
                				</div>
								<div class="form-group col-md-8">
									<label>Actual transfer amount</label>
									<input type="text" name="amount" id="amount" value="" class="form-control" required>
                				</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block">Deposit Trans</button>
								</div>	
                    		</div>
						</article>	 
						</form>
						</div>
					</div>
				</div>
			</div><!-- COL END -->
		</div>
		
	</div>
</div>
<!-- CONTAINER CLOSED -->
 	
<script language="javascript">

function formCheck(frm) {
    if (frm.rev_id.value == "") {
        alert("Enter your wallet address");
        frm.rev_id.focus();
        return false;
    }
    if (frm.count.value == "") {
        alert("Please enter the transfer quantity");
        frm.count.focus();
        return false;
    }
    return true;
}

function call()
{
	if(document.getElementById("count").value)
	{
		var count 		= parseFloat(document.getElementById('count').value);
		var persent 	= parseFloat(document.getElementById('send_persent').value);
		var fee 		= 0;
		var amount 		= 0;
		
    	addresscheck();
		if (document.getElementById('rev_id_enabled').value == '000') 
		{
			document.getElementById('fee').value = fee;
			document.getElementById('amount').value = parseInt(document.getElementById('count').value);
		}
		else
		{
			fee = parseFloat(count * persent);
			amount = parseFloat(count - fee);
			
			document.getElementById('fee').value = fee;
			document.getElementById('amount').value = amount;
		}
	}
}
</script>