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
				<h4 class="text-themecolor">회원관리</h4>
			</div>
			<div class="col-md-7 align-self-center text-right">
				<div class="d-flex justify-content-end align-items-center">
					<!-- <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">대시보드</li>
                            </ol> -->
					<a href="/admin/member/lists" class="btn btn-dark d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>
						회원리스트</a>
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
						<h4 class="card-title">회원정보</h4>
						<h6 class="card-subtitle">회원정보 수정 및 다양한 정보를 확인 가능합니다.</code></h6>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span
										class="hidden-xs-down">회원정보</span></a> </li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content tabcontent-border">
							<div class="tab-pane active" id="home" role="tabpanel">
								<!-- Tab1 -->
								<div class="p-20">
									<form name="reg_form" action="/admin/member/edit" method="post" onsubmit="return formCheck();">
										<input type="hidden" name="member_id_enabled" id="member_id_enabled" value="">
										<input type="hidden" name="sp_id_enabled" id="sp_id_enabled" value="">
										<input type="hidden" name="re_id_enabled" id="re_id_enabled" value="">
										<div class="form-group">
											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">접속국가</label>
												<div class="col-9">
													<select name="country" class="custom-select col-12" required itemname="온라인 접속 국가">
														<option value=''>국가 선택</option>
														<? foreach ($country as $row) { ?>
														<option value='<?=$row->phone_code?>' <?if($row->phone_code == $member->country){?>selected
															<?}?>><?=$row->country_name?></option>
														<? } ?>
													</select>
												</div>
											</div>
											<!--
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">그룹</label>
													<div class="col-9">
														<select name="office_group" class="custom-select col-12" required>
															<option value='' >그룹을 선택하세요</option>
															<? foreach ($group as $row) { ?>
															<option value='<?=$row->group_name?>' <?if($row->group_name == $member->office_group){?>selected<?}?>><?=$row->group_name?></option>
															<? } ?>
														</select>
                                        			</div>
												</div>
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">소속센터</label>
													<div class="col-9">
														<select name="is_center" class="custom-select col-12" required>
															<option value='0' >센타를 수정할 경우 선택하세요</option>
															<option value='1' >본인만 센터 수정하기</option>
															<option value='2' >본인산하 전체수정하기</option>
														</select>
														<input type="hidden" name="old_office" id="old_office" value="<?=$member->office?>" >
														<select name="office" class="custom-select col-12" required itemname="가입 센터를 선택하세요">
															<option value=''>센터를 선택하세요</option>
															<? foreach ($center as $row) { ?>
															<option value='<?=$row->office?>' <?if($row->office == $member->office){?>selected<?}?> ><?=$row->office?></option>
															<? } ?>
        												</select>
                                        			</div>
                                    			</div>                                
												-->

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">회원아이디</label>
												<div class="col-9">
													<input type="hidden" name="member_id" id="member_id" value="<?=$member->member_id?>">
													<fieldset disabled="">
														<input type="text" class="form-control" value="<?=$member->member_id?>">
													</fieldset>
												</div>
											</div>

											<?if($this->session->userdata('member_id') != 'admin' and $member->member_id != 'admin'){?>
											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">비밀번호</label>
												<div class="col-9">
													<input type="text" class="form-control" name="password" value="<?=$member->password?>">
												</div>
											</div>

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">출금비밀번호</label>
												<div class="col-9">
													<input type="text" class="form-control" name="secret" value="<?=$member->secret?>"
														maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
												</div>
												<p style="color: red; font-size:12px; font-weight:bold;padding-left:20px;">*출금 비밀번호는 숫자만 입력
													가능합니다.</p>
												<p style="color: red; font-size:12px; font-weight:bold;padding-left:20px;">*최대 6자리 입니다.</p>
											</div>
											<?}else if($this->session->userdata('member_id') == 'admin'){?>
											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">비밀번호</label>
												<div class="col-9">
													<input type="text" class="form-control" name="password" value="<?=$member->password?>">
												</div>
											</div>

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">출금비밀번호</label>
												<div class="col-9">
													<input type="text" class="form-control" name="secret" value="<?=$member->secret?>"
														maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
												</div>
												<p style="color: red; font-size:12px; font-weight:bold; padding-left:20px;">*출금 비밀번호는 숫자만 입력
													가능합니다.</p>
											</div>
											<?}?>

											<hr>
											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">추천인</label>
												<div class="col-9">
													<input type="hidden" name="old_recommend_id" id="old_recommend_id"
														value="<?=$member->recommend_id?>">
													<input type="text" class="form-control" name="recommend_id" id='recommend_id'
														onblur='recheck();' value="<?=$member->recommend_id?>" required>
													<a href="#"
														onClick="javascript:window.open('/admin/popreg/repop','popup','scrollbars=yes, resizable=no, width=600,height=600')">
														<span class="blue">이름으로 찾기</span> </a>
													<div class="reg-error" id='msg_re_id' class="msg"></div>
												</div>
											</div>
											<!--
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">후원인</label>
													<div class="col-9">	                                                	
														<input type="hidden" name="old_sponsor_id" id="old_sponsor_id" value="<?=$member->sponsor_id?>" >
	                                                	<input type="text" class="form-control" name="sponsor_id" id='sponsor_id' onblur='recheck();' value="<?=$member->sponsor_id?>" required >
														<a href="#" onClick="javascript:window.open('/admin/popreg/sppop','popup','scrollbars=yes, resizable=no, width=600,height=600')"> 
															<span class="blue">이름으로 찾기</span> </a>
														<div class="reg-error"  id='msg_sp_id' class="msg"></div>
                                        			</div>
                                                </div>
                                                -->
											<hr>

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">회원성명</label>
												<div class="col-9">
													<input type="text" class="form-control" id="name" name="name" itemname="이름"
														value="<?=$member->name?>" <?if($member->member_id != 'admin'){?> required
													<?}?> >
												</div>
											</div>

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">휴대폰번호</label>
												<div class="col-9">
													<input type="text" class="form-control" name="mobile" id="mobile" itemname="모바일"
														value="<?=$member->mobile?>">
												</div>
											</div>

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">이메일</label>
												<div class="col-9">
													<input type="text" class="form-control" name="email" id="email" temname="email"
														value="<?=$member->email?>">
												</div>
											</div>
											<hr>

											<!--
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">우편번호</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="post" id="post" temname="post"  value="<?=$member->post?>">
                                        			</div>
                                                </div>
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">주소</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="address" id="address" temname="address"  value="<?=$member->address?>">
                                        			</div>
                                                </div>
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">주소(나머지)</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="address1" id="address1" temname="address1"  value="<?=$member->address1?>">
                                        			</div>
                                                </div>
                                                <hr>												
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label" style="color: red;">직급 레벨</label>
													<div class="col-9">
														<select name="ballevel" class="custom-select col-12" required>
															<option value='1' <?if($bal->level == 1){?>selected <?}?>>1스타</option>
															<option value='2' <?if($bal->level == 2){?>selected <?}?>>2스타</option>
															<option value='3' <?if($bal->level == 3){?>selected <?}?>>3스타</option>
															<option value='4' <?if($bal->level == 4){?>selected <?}?>>4스타</option>
															<option value='5' <?if($bal->level == 5){?>selected <?}?>>5스타</option>
														</select>
                                        			</div>
												</div> 
                                                <hr> 
                                                        
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">활동여부</label>
													<div class="col-9">
														<select name="is_close" class="custom-select col-12" required>
															<option value='' >선택하세요</option>
															<option value='1' <?if($member->is_close == 1){?>selected <?}?>>활동중지</option>
															<option value='0' <?if($member->is_close == 0){?>selected <?}?>>활동재개</option>
														</select>
                                        			</div>
												</div>
                                                -->
											<?if($this->session->userdata('level') > 9){?>
											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">로그인 레벨</label>
												<div class="col-9">
													<select name="level" class="custom-select col-12" required>
													
														<option value='2' <?if($member->level == 2){?>selected
															<?}?>>일반회원</option>
														
														<option value='10' <?if($member->level == 10){?>selected
															<?}?>>관리자</option>
													</select>
												</div>
											</div>
											<?}else{?>
											<input type="hidden" name="email" id="level" temname="level" value="<?=$member->level?>">
											<?}?>
											<!-- <div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">보내기가능여부</label>
												<div class="col-9">
													<select name="type" class="custom-select col-12" required>
														<option value=''>선택하세요</option>
														<option value='0' <?if($member->type == 0){?>selected
															<?}?>>보내기 금지</option>
														<option value='1' <?if($member->type == 1){?>selected
															<?}?>>보내기 가능</option>
													</select>
												</div>
											</div>

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">출금가능여부</label>
												<div class="col-9">
													<select name="is_out" class="custom-select col-12" required>
														<option value=''>선택하세요</option>
														<option value='1' <?if($member->is_out == 1){?>selected
															<?}?>>출금중지</option>
														<option value='0' <?if($member->is_out == 0){?>selected
															<?}?>>출금가능</option>
													</select>
												</div>
											</div> -->

											<div class="form-group10 row">
												<label for="example-text-input" class="col-2 col-form-label">가입일</label>
												<div class="col-9">
													<input type="text" class="form-control" name="regdate" value="<?=$member->regdate?>" required>
												</div>
											</div>

											<hr>
											<?if($this->session->userdata('level') > 9){?>
											<input type="submit" class="btn btn-info" value="수정하기" id="btn_submit">
											<a href="/admin/member/lists" class="btn btn-secondary footable-delete">
												<span class="fas fas fa-bars" aria-hidden="true"></span></a>
											<?if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") { ?>
											<a href="/admin/member/delete/<?=$member->member_id?>" class="btn btn-secondary footable-delete">
												<span class="fas fa-trash-alt" aria-hidden="true"></span></a>
											<? } ?>
											<?}?>
										</div>
										</from>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function formCheck() {
				var f = document.reg_form;
				/*
				// 회원아이디 검사
				idcheck();
				if (document.getElementById('member_id_enabled').value != '000') {
					alert('플랜 어카운트 아이디를 입력하세요');
					document.getElementById('member_id').select();
					return false;
				}
				*/

				spcheck();
				if (document.getElementById('sp_id_enabled').value != '000') {
					alert('후원인 아이디를 입력하세요');
					document.getElementById('sponsor_id').select();
					return false;
				}

				recheck();
				if (document.getElementById('re_id_enabled').value != '000') {
					alert('추천인 아이디를 입력하세요');
					document.getElementById('recommend_id').select();
					return false;
				}

				$("#form").hide();
				//$(".wait").show();      
				document.getElementById("btn_submit").disabled = "disabled";

				return true;
			}
		</script>
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