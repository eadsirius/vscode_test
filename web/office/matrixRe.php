<?php
$select_lang = 'kr';
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--app-content open-->
<div class="app-content">
	<div class="side-app">

		<!-- PAGE-HEADER -->
		<div class="page-header">
			<div>
				<h1 class="page-title">Referral introducer</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Account</a></li>
					<li class="breadcrumb-item active" aria-current="page">Referral introducer</li>
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
		
<link rel="StyleSheet" href="/assets/css/tree.css" type="text/css">
<script type="text/javascript" src="/assets/css/tree.js"></script>

		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					
					<div class="card-header">
						<h3 class="card-title">Referral introducer</h3>
					</div>
					<div class="card-body">
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $free->office_group?>
								
				
							<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i><font size=3>Total Sub Account : <?=$reTotal?>Person</font>
						</div>
						
						<br><br>
						
<script type="text/javascript">
<!--
var Tree = new Array;
<?for($i=0;$i<$no; $i++){?>
	Tree[<?=$i?>] = "<?=$list[$i]?>";
<?}?>
//-->
</script>

<div class="tree">
<script type="text/javascript">
<!--
	createTree(Tree);
//-->
</script>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>