<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="inner-header divider parallax layer-overlay overlay-white-4" data-bg-img="/assets/images/bg/bg2.jpg" style="background-image: background-position: 50% 57px;">
    <div class="container pt-10 pb-10">
        <!-- Section Content -->
        <div class="section-content">
	        <div class="row">
		        <div class="col-md-12 text-center">
			        <h2 class="title"><?=$this->session->userdata('member_id')?> Connected</h2>
				</div>
			    <ol class="breadcrumb text-center text-black mt-10">
				    <li style="font-size: 24px;">1HCoin = <?=$site->cfg_usd?>USD</li>
				</ol>
			</div>
        </div>
    </div>
</section>
<!-- Section: Calculator -->
<section>
    <div class="container">
        <div class="section-content">
	        <div class="row">
		        <div class="col-md-12">
			        <div class="about-details mb-sm-30">
				        <h2 class="mt-0 text-theme-colored">HCoin Transfer Result.</h2>
						<p>HCoin Transfer Result.</p>
						<p>The transfer fee is <?=$site->cfg_send_persent * 100?>%.</p>
				        <div class="diamond-line-left-theme-colored2"></div>
						<div class="heading-line-bottom">
							<h4>Trans info.</h4>
        				</div>
						<div class="list-group">
							<a class="list-group-item active">Address : <?=$wallet->wallet?></a>
							<a class="list-group-item">HCoin Balance : <?=number_format($bal->coin,4)?>HCoin</a>
							<a class="list-group-item">Member ID : <?=$this->session->userdata('member_id')?></a>
						</div>
						<div class="heading-line-bottom">
							<h4>Recipient info.</h4>
        				</div>
						<div class="list-group">
							<a class="list-group-item active">Address : <?=$rev_wallet?></a>
							<a class="list-group-item">Rev : <?=$rev_id?></a>
						</div>
						<div class="heading-line-bottom">
							<h4>Transfer info.</h4>
        				</div>
						<div class="list-group">
							<a class="list-group-item active">Send : <?=number_format($count,4)?>HCoin</a>
							<a class="list-group-item">Fee : <?=number_format($fee,4)?>HCoin</a>
							<a class="list-group-item">Total Send : <?=number_format($send_count,4)?>HCoin</a>
						</div>
					</div>
					<a href="/token/send/lists"><input type="button" value="Transfer Result" class="btn btn-default btn-theme-colored btn-lg"></a>
				</div>
			</div>
        </div>
    </div>
</section>
<!-- end main-content -->