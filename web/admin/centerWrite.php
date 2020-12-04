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
                        <h4 class="text-themecolor">센타관리</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <!--
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
     <li class="breadcrumb-item active">대시보드</li>
</ol>
-->
                            <a href="/admin/center/lists" class="btn btn-dark d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i> 센타리스트</a>
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
                                <h4 class="card-title">센타정보</h4>
                                <h6 class="card-subtitle">센타정보 수정 및 삭제 가능합니다.</code></h6>
                                
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="home" role="tabpanel">
										<!-- Tab1 -->
                                        <div class="p-20">
											<script type="text/javascript" src="<?=$skin_dir?>/assets/js/register.js?<?=nowdate()?>"></script>
											<form name="reg_form" action="/admin/center/edit" method="post" onsubmit="return formCheck();">
											<input type="hidden" name="center_no" id="center_no" value="<?=$center->center_no?>">
											<input type="hidden" name="member_id_enabled" id="member_id_enabled" value="" >
											<input type="hidden" name="re_id_enabled" id="re_id_enabled" value="" >
                                            <div class="form-group">                             
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">센타장아이디</label>
													<div class="col-9">
														<input type="text" class="form-control" name="member_id" id="member_id" value="<?=$center->member_id?>">
                                        			</div>
                                                </div>
                                                        
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">센타추천인</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="recommend_id" id='recommend_id' required onblur='recheck();' value="<?=$center->office_recommend_id?>">
														<a href="#" onClick="javascript:window.open('/admin/popreg/repop','popup','scrollbars=yes, resizable=no, width=600,height=600')"> 
															<span class="blue">이름으로 찾기</span> </a>
														<div class="reg-error"  id='msg_re_id' class="msg"></div>
                                        			</div>
                                                </div>  
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">센타명</label>
													<div class="col-9">
	                                                	<input type="hidden" class="form-control" name="old_office" id="old_office" value="<?=$center->office?>">
	                                                	<input type="text" class="form-control" name="office" id="office" required itemname="센타명"  value="<?=$center->office?>">
                                        			</div>
                                                </div>
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">연락처</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="mobile" id="mobile" required itemname="모바일"  value="<?=$center->mobile?>">
                                        			</div>
                                                </div>
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">FX</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="fax" id="fax" itemname="fax"  value="<?=$center->fax?>">
                                        			</div>
                                                </div>
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">센타주소지</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="addr1" id="addr1" value="<?=@$center->addr1?>"d>
                                        			</div>
                                                </div>
                                                        
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">운영여부</label>
													<div class="col-9">
														<select name="state" class="custom-select col-12" required>
															<option value='' >선택하세요</option>
															<option value='운영중' <?if($center->state == '운영중'){?>selected <?}?>>운영중</option>
															<option value='운영중지' <?if($center->state == '운영중지'){?>selected <?}?>>운영중지</option>
														</select>
                                        			</div>
												</div>
												
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">가입일</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="regdate" value="<?=$center->regdate?>"required >
                                        			</div>
                                                </div>
                                                 
                                                <hr> 
												<input type="submit" class="btn btn-info" value="수정하기" id="btn_submit">
												<a href="/admin/center/lists" class="btn btn-secondary footable-delete">
													<span class="fas fas fa-bars" aria-hidden="true"></span></a>
												<a href="/admin/center/del/<?=$center->center_no?>" class="btn btn-secondary footable-delete">
													<span class="fas fa-trash-alt" aria-hidden="true"></span></a>
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
 
	recheck();        
	if (document.getElementById('re_id_enabled').value != '000') {
		alert('추천인 아이디를 입력하세요');
		document.getElementById('recommend_id').select();
		return false;
   	}
   									
   	//$("#form").hide();
   	//$(".wait").show();      
   	//document.getElementById("btn_submit").disabled = "disabled";
       
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
