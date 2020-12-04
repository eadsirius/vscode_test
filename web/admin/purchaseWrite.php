<link href="<?=$skin_dir?>/assets/dist/css/pages/pricing-page.css" rel="stylesheet">
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
				<h4 class="text-themecolor">포인트 매출관리</h4>
			</div>
			<div class="col-md-7 align-self-center text-right">
				<div class="d-flex justify-content-end align-items-center">
					<!--
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
     <li class="breadcrumb-item active">대시보드</li>
</ol>
-->
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">매출 수정하기</h4>
						<!-- Tab panes -->
						<div class="tab-content tabcontent-border">
							<div class="p-20">
								<form name="reg_form" action="/admin/point/purchase_edit" method="post" onsubmit="return formCheck();">
									<input type="hidden" name="point_no" id="point_no" value="<?=$point_no?>">
									<input type="hidden" name="table" id="table" value="<?=$table?>">

									<input type="hidden" name="order_code" value="<?=$po->order_code?>">
									<input type="hidden" name="old_point" id="old_point" value="<?=$po->point?>">
									<input type="hidden" name="old_saved_point" id="old_saved_point" value="<?=$po->saved_point?>">
									<div class="form-group">

										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">회원이름</label>
											<div class="col-9">
												<fieldset disabled="">
													<?$name = $this->M_member->get_member_name($po->member_id);?>
													<input type="text" class="form-control" value="<?=$name?>">
												</fieldset>
											</div>
										</div>

										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">회원아이디</label>
											<div class="col-9">
												<input type="text" class="form-control" name="member_id" value="<?=$po->member_id?>" required>
											</div>
										</div>

										<input type="hidden" name="event_id" value="<?=$po->event_id?>" required>
										<!--	
        									<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">원인제공 아이디</label>
												<div class="col-9">
	                                               	<input type="text" class="form-control" name="event_id" value="<?=$po->event_id?>"required >
                                       			</div>
                                            </div>
											-->
										<input type="hidden" class="form-control" name="event_id" value="<?=$po->event_id?>" required>
										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">매출포인트</label>
											<div class="col-9">
												<div class="row" style="margin-left: 0;">
													<div class="widget style1 blue-bg">
														<div class="col-xs-10 text-center">
															<select name="point">
																<option value="<?=$po->saved_point?>"><?=number_format($po->saved_point)?></option>
																<option value="120000">120,000 ($ 1,000 )</option>
																<option value="360000">360,000 ($ 3,000 )</option>
																<option value="600000">600,000 ($ 5,000 )</option>
																<option value="1200000">1,200,000 ($ 10,000 )</option>
															</select>
														</div>
													</div>
												</div>
												<!-- <input type="text" class="form-control" name="point" value="<?=$po->point?>" required> -->
											</div>
										</div>

										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">매출금액</label>
											<div class="col-9">
												<?php if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") { ?>
												<?}?>

												<div class="row" style="margin-left: 0;">
													<div class="widget style1 blue-bg">
														<div class="col-xs-10 text-center">
															<select name="saved_point">
																<option value="<?=$po->saved_point?>"><?=number_format($po->saved_point)?></option>
																<option value="120000">120000 ($ 1,000 )</option>
																<option value="360000">360000 ($ 3,000 )</option>
																<option value="600000">600000 ($ 5,000 )</option>
																<option value="1200000">1200000 ($ 10,000 )</option>
															</select>
														</div>
													</div>
												</div>
												<!-- <input type="text" class="form-control" name="saved_point" value="<?=$po->saved_point?>"
													required readonly> -->

											</div>
										</div>
										<!--	
        									<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">분류</label>
												<div class="col-9">
                                       			</div>
                                            </div>
                                            -->
										<input type="hidden" class="form-control" name="cate" value="<?=$po->cate?>" required>
										<input type="hidden" name="old_kind" id="old_kind" value="<?=$po->kind?>">
										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">매출구분</label>
											<div class="col-9">
												<select name="kind" class="custom-select col-12" required>
													<option value='purchase' <?if($po->kind == 'purchase'){?>selected
														<?}?>>관리자매출</option>
													<!-- <option value='cash' <?if($po->kind == 'cash'){?>selected
														<?}?>>현금매출</option>
													<option value='card' <?if($po->kind == 'card'){?>selected
														<?}?>>카드매출</option>
													<option value='etc' <?if($po->kind == 'etc'){?>selected
														<?}?>>기타매출</option>
													<option value='no' <?if($po->kind == 'no'){?>selected
														<?}?>>인정매출</option> -->
													<!--<option value='apply' 		<?if($po->kind == 'apply'){?>selected<?}?>>매출신청중</option>-->
												</select>
											</div>
										</div>

										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">참조메시지</label>
											<div class="col-9">
												<input type="text" class="form-control" name="msg" value="<?=number_format($po->msg,2)?>">
											</div>
										</div>

										<div class="form-group10 row">
											<label for="example-text-input" class="col-2 col-form-label">날짜</label>
											<div class="col-9">
												<input type="text" class="form-control" name="regdate" value="<?=$po->regdate?>" required>
											</div>
										</div>

										<hr>
										<input type="submit" class="btn btn-info" value="수정하기" id="btn_submit">
									</div>
									</from>
									* 매출금액과 그에 맞는 매출 포인트를 같이 수정해주세요.<br>
									* 매출구분은 인정에서 다른 것으로 혹은 다른것에서 인정으로 바꿀 수 있습니다.
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- row -->
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
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
	© 2020 WNS © All Rights Reserved
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
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