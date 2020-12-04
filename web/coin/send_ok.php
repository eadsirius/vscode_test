<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<!-- navbar -->
	<div class="navbar navbar-pages">
		<div class="container">
			<div class="content">
				<h4><a href="" class="link-back"><i class="fa fa-arrow-left "></i></a> ELC 보내기결과</h4>
			</div>
			<div class="content-right">
				<a href="/"><i class="fa fa-home"></i></a>
			</div>
		</div>
	</div>
	<!-- end navbar -->

	<!-- features -->
	<div class="features segments-page">
		<div class="container-pd">
			<div class="row">
				<div class="col-12 px-2">
					<div class="content b-shadow">
						<h4>ELC 현재 잔고</h4>
						<p><?=number_format($elcBal,2)?> ELC</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6 px-2">
					<div class="content b-shadow">
						<h4>받으신분</h4>
						<p><?=$rev_id?></p>
					</div>
				</div>
				<div class="col-6 px-2">
					<div class="content b-shadow">
						<h4>ELC 보낸수량</h4>
						<p><?=number_format($send_count,2)?> ELC</p>
					</div>
				</div>
				<a href="/"><input type="button" class="buttonWrap button button-green contactSubmitButton" value="결과확인" /></a>
			</div>
		</div>
	</div>
	<!-- end features -->