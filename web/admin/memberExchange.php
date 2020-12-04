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
                            <a href="/admin/member/lists" class="btn btn-dark d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> 회원리스트</a>
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
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-xs-down">매출등록하기</span></a> </li>
                                    <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-xs-down">매출등록용 포인트충전하기</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-xs-down">수당 출금해주기</span></a> </li>-->
                                </ul>
                                
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="home" role="tabpanel">
										<!-- Tab1 -->
                                        <div class="p-20">
											<form name="reg_form" action="/admin/member/addPuchase" method="post" onsubmit="return formCheck('puchase');">
	                                        <input type="hidden" 	name="name" 			id="name" 				value="<?=$member->name?>">
											<input type="hidden" 	name="member_no" 		id="member_no" 			value="<?=$member->member_no?>" >
											<input type="hidden" 	name="member_wallet" 	id="member_wallet" 		value="<?=@$wallet->wallet?>" >
                                            <div class="form-group">        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">회원아이디</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="member_id" id="member_id" required itemname="rev"  value="<?=$member->member_id?>">
                                        			</div>
                                                </div>
                                                        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">추천인아이디</label>
													<div class="col-9">
														<input type="hidden" 	name="old_recommend_id" 	id="old_recommend_id" 	value="<?=$member->recommend_id?>">
	                                                	<input type="text" class="form-control" name="recommend_id" id="recommend_id" required itemname="rev"  value="<?=$member->recommend_id?>">
                                        			</div>
                                                </div>
                                                <!--      										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">후원인아이디</label>
													<div class="col-9">
														<input type="hidden" 	name="old_sponsor_id" 	id="old_sponsor_id" 	value="<?=$member->sponsor_id?>">
														<input type="text" class="form-control" name="sponsor_id" id="sponsor_id" value="<?=$member->sponsor_id?>" required>
                                        			</div>
                                                </div>
                                                -->                                             
                                                <hr> 
                                                							
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">매출횟수</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="puchase_cnt" id="puchase_cnt" required readonly itemname="count"  value="<?=$puchase_cnt?>">
                                        			</div>
                                                </div>
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">매출구분</label>
													<div class="col-9">
														<select name="kind" class="custom-select col-12" required>
															<option value='complete' >POINT 매출</option>
															<!--<option value='card' >카드매출</option>
															<option value='loan' >외상매출</option>
															<option value='etc' >기타매출</option>-->
															<option value='no' >인정매출</option>
														</select>
                                        			</div>
                                                </div>
                                                							
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">매출금액</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="count" itemname="count"  value="">
                                        			</div>
                                                </div>                                              
                                                <hr> 
                                                							
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">메모란</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="msg" itemname="memo"  value="관리자등록">
                                        			</div>
                                                </div>                                             
                                                <hr> 
                                                							
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">매출날자</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="regdate" itemname="date"  value="<?=$regdate?>">
                                        			</div>
                                                </div>                                             
                                                <hr> 
                                                
												<input type="submit" class="btn btn-info" value="매출등록" id="btn_submit">
                                            </div>
                    						</form>
                                            <p style="color: blue;">매출 금액을 입력하시면 금액에 맞게 POINT포인트를 뺍니다. 원화표기 매출 금액을 입력해주세요</p>
                                            <p>메모란은 입력할 메모가 있으면 지금글을 지우고 다시 입력하세요.</p>
                                        </div>
                                    </div>
                                    
									<!-- Tab2 
                                    <div class="tab-pane p-20" id="profile" role="tabpanel">
                                        <div class="p-20">
											<form name="add_form" action="/admin/member/addPoint" method="post" onsubmit="return formCheck('point');">
											<input type="hidden" name="member_no" id="member_no" value="<?=$member->member_no?>" >
                                            <div class="form-group">        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">회원아이디</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="member_id" id="member_id" required itemname="rev"  value="<?=$member->member_id?>">
                                        			</div>
                                                </div>
                                                
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">현재 POINT 보유량</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="POINT" id="POINT" required itemname="rev"  value="<?=$bal->point?>" readonly >
                                        			</div>
                                                </div>
                                                
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">전송구분</label>
													<div class="col-9">
														<select name="kind" class="custom-select col-12" required itemname="전송구분">
															<option value='POINT_a'>매출등록 POINT 충전하기</option>
															<option value='POINT_m'>매출등록 POINT 빼내기</option>
        												</select>
                                        			</div>
                                                </div>
                                                
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">수량</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="count" id="count" required itemname="count">
                                        			</div>
                                                </div>                                                 
                                                <hr> 
												<input type="submit" class="btn btn-info" value="전송하기" id="btn_submit">
                                            </div>
                    						</form>
                                            <p>충전하기 할 경우에는 그냥 충전을 해줍니다. / 빼내기 할 경우 어드민에게 보냅니다.</p>
                                        </div>
                                    </div>
                                    -->
									<!-- Tab3
                                    <div class="tab-pane p-20" id="messages" role="tabpanel">
                                        <div class="p-20">
											<form name="reg_form" action="/admin/member/addCoin" method="post" onsubmit="return formCheck('coin');">
											<input type="hidden" name="rev_no" id="rev_no" value="<?=$member->member_no?>" >
	                                        <input type="hidden" class="form-control" name="wallet" id="wallet" required itemname="wallet"  value="<?=@$wallet->wallet?>">
                                            <div class="form-group">        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">회원아이디</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="rev_id" id="rev_id" required itemname="rev"  value="<?=$member->member_id?>">
                                        			</div>
                                                </div>  
                                                
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">현재 출금가능 금액</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="total_point" id="total_point" required itemname="rev"  value="<?=$bal->total_point?>" readonly >
                                        			</div>
                                                </div>
                                                        										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">출금금액</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="point" id="point" required itemname="point"  value="" onkeyup='call()'>
                                        			</div>
                                                </div>             										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">출금 수수료</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="fee" id="fee" required itemname="fee"  value="">
                                        			</div>
                                                </div>               										
        										<div class="form-group10 row">
													<label for="example-text-input" class="col-2 col-form-label">실지급금액</label>
													<div class="col-9">
	                                                	<input type="text" class="form-control" name="amount" id="amount" required itemname="amount"  value="">
                                        			</div>
                                                </div>                                          
                                                <hr> 
												<input type="submit" class="btn btn-info" value="출금해주기" id="btn_submit">
                                            </div>
                    						</form>
                                            <p>코인과 포인트의 교환이 가능합니다.</p>
                                        </div>                                  
									</div> -->                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
<script type="text/javascript">
function formCheck(formName) 
{
    if(formName == 'coin'){
		var count = document.getElementById('count').value;  
    }
    else if(formName == 'point'){
		var count = document.getElementById('po_count').value;   
    }
    else if(formName == 'coin'){
		var count = document.getElementById('count').value;   
    }
    
	if(count == ''){
       	alert(formName + ' Please enter quantity of purchase');
		return false;
	}

    if(confirm("전송하시겠습니까?")) {
        return true;
    }

    return false;

}

function call()
{
	if(document.getElementById("amount").value)
	{
		var amount 	= parseFloat(document.getElementById('amount').value);
		var point = 0;
		
		point = amount * 1;
			
		document.getElementById('point').value = point;
	}
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
            © 2019 USP
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
