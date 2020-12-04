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
				<h1 class="page-title">Transfer List</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Bitcoin</a></li>
					<li class="breadcrumb-item active" aria-current="page">Transfer List</li>
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
						<h3 class="card-title">Transfer List</h3>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<li class="list-group-item active">Address : <?=$wallet?></li>
							<li class="list-group-item">BTC Balance : <?=number_format($bal->coin,4)?>BTC</li>
							<li class="list-group-item">Member ID : <?=$this->session->userdata('member_id')?></li>
						</ul>
				        <table class="table table-bordered"> 
					    <thead> 
						    <tr> 
							    <th>#</th> 
							    <th>BTC</th> 
							    <th>Address</th> 
							    <th>Date</th> 
							</tr> 
						</thead> 
						<tbody> 
						<? 
						$i=0;
						foreach($item as $row) {
							$i+=1; 
							$regdate	=  date("y-m-d",strtotime($row->regdate));
						?>
							<tr> 
								<th scope="row"><?=$i?></th> 
								<td><?=number_format($row->point,4)?></td> 
								<td><?=$row->event_address?></td> 
								<td><?=$row->regdate?></td> 
							</tr>
						<? } ?>
						<?if($i==0){?>
							<tr>
								<td colspan="5" height="50px;">No history.</td>
							</tr>
						<?}?>
						</tbody> 
						</table> 
					</div>
				</div>
			</div><!-- COL END -->
		</div>
		<!-- ROW-1 CLOSED -->
		
	</div>
</div>
<!-- CONTAINER CLOSED -->