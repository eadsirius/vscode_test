<link href="<?=$skin_dir?>/assets/node_modules/wizard/steps.css" rel="stylesheet">
<!--alerts CSS -->
<link href="<?=$skin_dir?>/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row page-titles">
			<div class="col-md-5 align-self-center">
				<h4 class="text-themecolor">환경설정</h4>
			</div>
			<div class="col-md-7 align-self-center text-right">
				<div class="d-flex justify-content-end align-items-center">
					<!-- <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item ">Dashboard</li>
                                <li class="breadcrumb-item active">Config</li>
                            </ol> -->
				</div>
			</div>
		</div>


		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body wizard-content">
						<h4 class="card-title">환경설정</h4>
						<h6 class="card-subtitle">홈페이지 및 수당 등 설정을 할 수 있습니다.</h6>
						<form name="reg_form" action="/<?=uri_string()?>" method="post" class="tab-wizard wizard-circle">
							<input type="hidden" id="cfg_no" name="cfg_no" value="1">
							<!-- Step 1 -->
							<h6>기본설정</h6>
							<section>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">사이트이름 :</label>
											<input type="text" class="form-control" id="cfg_site" name="cfg_site" value="<?=$site->cfg_site?>"> 
											</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">관리자 :</label>
											<input type="text" class="form-control" id="cfg_admin" name="cfg_admin" value="<?=$site->cfg_admin?>"> 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">사이트 소재지 :</label>
											<select class="custom-select form-control" id="cfg_country" name="cfg_country">
												<option value='USA'>United States</option>
												<option value='ENG'>England</option>
												<option value='CAN'> Canada (Français)</option>
												<option value='APM'>България</option>
												<option value='JAP'>日本</option>
												<option value='KOR' selected="selected">대한민국</option>
												<option value='CHA'>中国</option>
												<option value='THA'>ฉันจะจำค</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">사이트 기본언어 :</label>
											<select class="custom-select form-control" id="cfg_language" name="cfg_language">
												<option value='us' <?if($site->cfg_language == 'us'){?> selected="selected"
													<?}?> >England</option>
												<option value='jp' <?if($site->cfg_language == 'jp'){?> selected="selected"
													<?}?> >日本</option>
												<option value='kr' <?if($site->cfg_language == 'kr'){?> selected="selected"
													<?}?> >대한민국</option>
												<option value='cn' <?if($site->cfg_language == 'cn'){?> selected="selected"
													<?}?> >中国</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">운영개시일 :</label>
											<input type="date" class="form-control" id="regdate" name="regdate" value="<?=$site->regdate?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">스마트컨트렉트주소 :</label>
											<input type="text" class="form-control" id="cfg_contract" name="cfg_contract"
												value="<?=$site->cfg_contract?>"> </div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">코인(토큰)이름 :</label>
											<input type="text" class="form-control" id="cfg_coin" name="cfg_coin"
												value="<?=$site->cfg_coin?>"> </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">입금받을 회사지갑주소 :</label>
											<input type="text" class="form-control" id="cfg_address" name="cfg_address"
												value="<?=$site->cfg_address?>"> </div>
									</div>
								</div>

								<!-- <div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">코인(토큰) USD 시세 :</label>
											<input type="text" class="form-control" id="cfg_usd" name="cfg_usd" value="<?=$site->cfg_usd?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">코인(토큰) WON 시세 :</label>
											<input type="text" class="form-control" id="cfg_won" name="cfg_won" value="<?=$site->cfg_won?>">
										</div>
									</div>
								</div> -->

								<!-- <div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">이더리움 USD 시세 :</label>
											<input type="text" class="form-control" id="cfg_eth_usd" name="cfg_eth_usd"
												value="<?=$site->cfg_eth_usd?>"> </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">이더리움 WON 시세 :</label>
											<input type="text" class="form-control" id="cfg_eth_won" name="cfg_eth_won"
												value="<?=$site->cfg_eth_won?>"> </div>
									</div>
								</div> -->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">출금최소POINT :</label>
											<input type="text" class="form-control" id="cfg_send_point" name="cfg_send_point"
												value="<?=$site->cfg_send_point?>"> </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title">출금수수료(%) :</label>
											<input type="text" class="form-control" id="cfg_send_persent" name="cfg_send_persent"
												value="<?=$site->cfg_send_persent*100?>"> </div>
									</div>
								</div>
							</section>

							<!-- Step 1 -->

							<!-- Step 2 -->
							<h6>매출설정</h6>
							<section>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label for="title">데일리 지급율(%) :</label>
											<input type="text" class="form-control" name="cfg_lv1_day" value="<?=$site->cfg_lv1_day*100?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label for="title">추천1대 지급율(%) :</label>
											<input type="text" class="form-control" name="cfg_lv1_re" value="<?=$site->cfg_lv1_re*100?>"> </div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="title">추천2대 지급율(%) :</label>
											<input type="text" class="form-control" name="cfg_lv1_re1" value="<?=$site->cfg_lv1_re1*100?>"> </div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="title">추천3대 지급율(%):</label>
											<input type="text" class="form-control" name="cfg_lv1_re2" value="<?=$site->cfg_lv1_re2*100?>"> </div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label for="title">공유 수당(%) : 4대 ~ 10대</label>
											<input type="text" class="form-control" name="cfg_re" value="<?=$site->cfg_re*100?>"> </div>
									</div>
								</div>
							</section>

						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- Right sidebar -->
		<!-- ============================================================== -->
		<!-- .right-sidebar -->
		<div class="right-sidebar">
			<div class="slimscrollright">
				<div class="rpanel-title"> Service Panel <span><i class="fas fa-times right-side-toggle"></i></span> </div>
				<div class="r-panel-body">
					<ul id="themecolors" class="m-t-20">
						<li><b>With Light sidebar</b></li>
						<li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme working">1</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
						<li class="d-block m-t-30"><b>With Dark sidebar</b></li>
						<li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Right sidebar -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Container fluid  -->
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer">
	© 2020 WNS TOKEN
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->



<script src="<?=$skin_dir?>/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?=$skin_dir?>/assets/node_modules/popper/popper.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?=$skin_dir?>/assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?=$skin_dir?>/assets/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?=$skin_dir?>/assets/dist/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="<?=$skin_dir?>/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="<?=$skin_dir?>/assets/dist/js/custom.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/moment/moment.js"></script>
<!-- This Page JS -->
<script src="<?=$skin_dir?>/assets/node_modules/wizard/jquery.steps.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/wizard/jquery.validate.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/sweetalert/sweetalert.min.js"></script>

<script>
	//Custom design form example
	$(".tab-wizard").steps({
		headerTag: "h6",
		bodyTag: "section",
		transitionEffect: "fade",
		titleTemplate: '<span class="step">#index#</span> #title#',
		labels: {
			finish: "Submit"
		},
		onFinished: function (event, currentIndex) {

			document.reg_form.submit();
			return true;



			//window.location.href = '/admin/config/';

		}
	});
</script>