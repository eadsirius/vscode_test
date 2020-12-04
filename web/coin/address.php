<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.3/clipboard.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
window.onload = function(){
    $(document).ready(function(){
        var clipboard = new Clipboard('.clipboard');
    });
};
</script>

<!-- Home Section start -->
<section id="banner" class="root-sec brand-bg padd-tb-40 single-banner blogpage-banner-wrap">
    <div class="container">
        <div class="row">
	        <div class="clearfix blog-banner-text blog-single-banner">
		        <div class="col-md-12">
			        <h2 class="title"><?=$mb->member_id?>님 Coin정보</h2>
			        <ul class="clearfix blog-post-meta">
				        <li>월드드림코인에 대한 정보와 내역을 확인 가능합니다.</li>
				    </ul>
				</div>
			</div>
        </div>
    </div>
</section>
<!-- #home Section end -->



<!-- About Section start -->
<section id="about" class="scroll-section root-sec grey lighten-5 about-wrap">
	<div class="container">
        <div class="row">
	        <div class="clearfix about-inner">
				
				<div class="col-sm-12 col-md-4">
					<div class="person-img wow fadeIn">
						<img class="z-depth-1" src="/data/member/<?=$mb->member_id?>.png" width="100%">
					</div>
				</div>
				<!-- about me image -->

				<div class="col-sm-12 col-md-8">
					<div class="person-info">
						<h3 class="about-subtitle">Account Information</h3>
						<h5><span>지갑주소 : <a id="addr"><?=$wallet?></a></h5>
						<h5><span>WDC 잔고 : </span> <?=number_format($bal->coin,4)?></h5>
					</div>
						<div class="clearfix card-content">
							<a data-clipboard-target="#addr" class="clipboard brand-text right waves-effect">Copy address</a>
						</div>
            	</div>
				<!-- about me info -->
			</div>
        </div>
    </div>
    <!-- .container end -->
</section>
<!-- #about Section end -->