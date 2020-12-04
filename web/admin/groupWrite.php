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
                                <h4 class="card-title"><?=$title?></h4>
                                <h6 class="card-subtitle">그룹정보 수정 및 삭제 가능합니다.</code></h6>
                                
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="home" role="tabpanel">
										<!-- Tab1 -->
                                        <div class="p-20">
											<script type="text/javascript" src="<?=$skin_dir?>/assets/js/register.js?<?=nowdate()?>"></script>
											<form name="reg_form" action="/admin/center/groupEdit" method="post" onsubmit="return formCheck();">
											<input type="hidden" name="group_no" id="group_no" value="<?=$group->group_no?>">
											<input type="hidden" name="member_id_enabled" id="member_id_enabled" value="" >
                                            <div class="form-group">     
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">접속국가</label>
													<div class="col-9">
														<select  name="country" class="custom-select col-12" required itemname="온라인 접속 국가">
														<option value='USA' <?if($group->country == 'USA'){?>selected<?}?>>United States</option>
														<option value='ENG' <?if($group->country == 'ENG'){?>selected<?}?>>England</option>
														<option value='CAN' <?if($group->country == 'CAN'){?>selected<?}?>> Canada (Français)</option>
														<option value='JPN' <?if($group->country == 'JPN'){?>selected<?}?>>日本</option>
														<option value='KOR' <?if($group->country == 'KOR'){?>selected<?}?>>대한민국</option>
														<option value='CHA' <?if($group->country == 'CHA'){?>selected<?}?>>中国</option>
														<option value='THA' <?if($group->country == 'THA'){?>selected<?}?>>ฉันจะจำค</option>
        												</select>
                                        			</div>
                                                </div>                              
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">그룹장아이디</label>
													<div class="col-9">
														<input type="text" class="form-control" name="member_id" id="member_id" value="<?=$group->member_id?>">
                                        			</div>
                                                </div>
        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">그룹명</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="group_name" id="group_name" required itemname="group"  value="<?=$group->group_name?>">
                                        			</div>
                                                </div>
												
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">가입일</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="regdate" value="<?=$group->regdate?>"required >
                                        			</div>
                                                </div>
                                                 
                                                <hr> 
												<input type="submit" class="btn btn-info" value="수정하기" id="btn_submit">
												<a href="/admin/center/grouplists" class="btn btn-secondary footable-delete">
													<span class="fas fas fa-bars" aria-hidden="true"></span></a>
												<a href="/admin/center/groupDel/<?=$group->group_no?>" class="btn btn-secondary footable-delete">
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
