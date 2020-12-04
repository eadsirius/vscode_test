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
		          <button type="button" class="btn btn-dark d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact"><i class="fa fa-plus-circle"></i> 회원추가하기</button>
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
		      <div class="col-12">
		        <div class="card">
		          <div class="card-body">
		            <h4 class="card-title">회원관리 | 총회원수 <?=number_format($total_count)?>명</h4>
		            <h6 class="card-subtitle">회원의 매출등 상세내역을 확인하실수 있습니다.</h6>
		            <p style="color:red;">Depth는 촤상위인 admin계정이 1일때 회원이 현재 몇대에 있는지를 보여줍니다.</p>
								<span style="font-weight: bold; font-size:16px; color:red;">1 Point = 10 원</span>
		            <!-- Add Contact Popup Model -->
		            <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		              <script type="text/javascript" src="<?=$skin_dir?>/assets/js/register.js?<?=nowdate()?>"></script>

		              <div class="modal-dialog">
		                <div class="modal-content">
		                  <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                  </div>
		                  <div class="modal-body">
		                    <form name="reg_form" action="/admin/member/addMember" method="post" onsubmit="return formCheck();">
		                      <input type="hidden" name="member_id_enabled" id="member_id_enabled" value="">
		                      <input type="hidden" name="sp_id_enabled" id="sp_id_enabled" value="">
		                      <input type="hidden" name="re_id_enabled" id="re_id_enabled" value="">
		                      <input type="hidden" name="office" id="office" value="본사">
		                      <div class="form-group">
		                        <div class="form-group10 row">
		                          <label for="example-text-input" class="col-2 col-form-label">접속국가</label>
		                          <div class="col-9">
		                            <select name="country" class="custom-select col-12" required itemname="온라인 접속 국가">
		                              <option value='82'>KOREA REPUBLIC OF</option>
		                              <? foreach ($country as $row) { ?>
		                              <option value='<?=$row->phone_code?>'><?=$row->country_name?></option>
		                              <? } ?>
		                            </select>
		                          </div>
		                        </div>
		                        <div class="form-group10 row">
		                          <label for="example-text-input" class="col-2 col-form-label">회원아이디</label>
		                          <div class="col-9">
		                            <input type="text" class="form-control" name="member_id" id="member_id" value="<?=@$new_id?>" required onblur='idcheck();'>
		                            <div class="reg-error" id='msg_member_id' class="msg"></div>
		                          </div>
		                        </div>

		                        <div class="form-group10 row">
		                          <label for="example-text-input" class="col-2 col-form-label">비밀번호</label>
		                          <div class="col-9">
		                            <input type="text" class="form-control" name="password" value="1234">
		                          </div>
		                        </div>

		                        <div class="form-group10 row">
		                          <label for="example-text-input" class="col-2 col-form-label">추천인</label>
		                          <div class="col-9">
		                            <input type="text" class="form-control" name="recommend_id" id='recommend_id' required onblur='recheck();'>
		                            <a href="#" onClick="javascript:window.open('/admin/popreg/repop','popup','scrollbars=yes, resizable=no, width=600,height=600')">
		                              <span class="blue">이름으로 찾기</span> </a>
		                            <div class="reg-error" id='msg_re_id' class="msg"></div>
		                          </div>
		                        </div>
		                        <div class="form-group10 row">
		                          <label for="example-text-input" class="col-2 col-form-label">회원성명</label>
		                          <div class="col-9">
		                            <input type="text" class="form-control" id="name" name="name" required itemname="이름">
		                          </div>
		                        </div>
		                        <div class="form-group10 row">
		                          <label for="example-text-input" class="col-2 col-form-label">휴대폰번호</label>
		                          <div class="col-9">
		                            <input type="text" class="form-control" name="mobile" id="mobile" required itemname="모바일" placeholder="휴대폰번호(숫자만입력)">
		                          </div>
		                        </div>
		                        <!--div class="form-group10 row">
															<label for="example-text-input" class="col-2 col-form-label">가입일</label>
															<div class="col-9">
	                                                        	<input type="text" class="form-control" name="regdate" value="<?=date("Y-m-d");?>" id="popupDatepickerStart" required >
                                        					</div>
                                                        </div-->
		                      </div>
		                      <div class="modal-footer">
		                        <input type="submit" class="btn btn-info waves-effect" value="등록하기" id="btn_submit">
		                      </div>
		                    </form>
		                  </div>
		                </div>
		                <!-- /.modal-content -->
		              </div>
		              <!-- /.modal-dialog -->
		              <script type="text/javascript">
		                function formCheck() {
		                  var f = document.reg_form;

		                  // 회원아이디 검사
		                  idcheck();
		                  /*
										if (document.getElementById('member_id_enabled').value != '000') {
											alert('아이디를 입력하세요');
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
		                  $("#form").hide();
		                  //$(".wait").show();      
		                  document.getElementById("btn_submit").disabled = "disabled";

		                  return true;
		                }

		              </script>
		            </div>


		            <div class="row">
		              <div class="col-sm-12 col-md-6">
		                <div class="dataTables_length">
		                  <form name='fsearch' method='post' action="<?=SEARCH_URL?>">
		                    <select class="custom-select col-12" id="inlineFormCustomSelect" style="width: 100px; height: 28px;" id='st' name='st'>
		                      <!-- <option value='office_group' <?if($st=='office_group' ){?>selected
														<?}?>>그룹별로찾기</option> -->
		                      <!-- <option value='office' <?if($st=='office' ){?>selected
														<?}?>>센터별로찾기</option> -->
		                      <option value='recommend_id' <?if($st=='recommend_id' ){?>selected
		                        <?}?>>추천인아이디</option>
		                      <!-- <option value='sponsor_id' <?if($st=='sponsor_id' ){?>selected
														<?}?>>후원인아이디</option> -->
		                      <option value='member_id' <?if($st=='member_id' ){?>selected
		                        <?}?>>아이디</option>
		                      <option value='name' <?if($st=='name' or $st=='' ){?>selected
		                        <?}?>>성명</option>
		                    </select>
		                    <input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc" value="<?=$search?>">

		                    <input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
		                    <button type="button" class="btn1 btn-primary" style="height: 28px;background:#2962FF;border-color:#2962FF" onclick="location.href='/admin/member/lists'">초기화</button>
		                    <button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/member/<?=@$search?>/<?=@$st?>" style="color: #ffffff;">Excel</a>
		                    </button>
		                  </form>


		                </div>
		              </div>
		              <div class="col-sm-12 col-md-6">
		                <div class="dataTables_filter">
		                  <?$list_per = $this->session->userdata('list_page');?>
		                  <select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
		                    <option value="">0</option>
		                    <option value="/admin/config/page/10/member" <?if($list_per==10){?>selected
		                      <?}?>>10</option>
		                    <option value="/admin/config/page/25/member" <?if($list_per==25){?>selected
		                      <?}?>>25</option>
		                    <option value="/admin/config/page/50/member" <?if($list_per==50){?>selected
		                      <?}?>>50</option>
		                    <option value="/admin/config/page/100/member" <?if($list_per==100){?>selected
		                      <?}?>>100</option>
		                  </select>
		                </div>
		              </div>
		            </div>
		            <br>

		            <table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
		              <thead>
		                <tr class="txt_center">
		                  <th>번호</th>
		                  <th>아이디</th>
		                  <th>이름</th>
		                  <th>Depth</th>
		                  <th>추천인</th>
		                  <th>매출</th>
		                  <th>총수당 (P)</th>
		                  <th>가입일</th>
		                  <th>비고</th>
		                </tr>
		              </thead>
		              <tbody>
		                <?
											$i = $total_count;
											foreach ($item as $row) :
												?>
		                <tr>
		                  <td class="txt_right"><?=number_format($i)?></td>
		                  <td class="txt_left"><span class="bold"><?=$row->member_id?></span></td>
		                  <td class="txt_left"><?=@$row->name?></td>
		                  <td class="txt_right"><?=$row->dep?></td>
		                  <td class="txt_left"><?=$row->recommend_id?></td>
		                  <td class="txt_right" style="color: red;">&#8361; <?=number_format($row->volume*10)?> 원</td>
		                  <td class="txt_right"><?=number_format($row->total_su,0)?></td>
		                  <td class="txt_center"><?=date("Y-m-d H:i:s",strtotime($row->regdate." +9 hours"))?></td>
		                  <td>

		                    <?if($this->session->userdata('level') >= 8){?>
		                    <a href="/admin/member/write/<?=$row->member_id?>" class="btn btn-secondary footable-edit">
		                      <span class="fas fa-pencil-alt" aria-hidden="true"></span></a>
		                    <?}?>
		                  </td>
		                </tr>
		                <?
								$i--;
								endforeach
    							?>
		              </tbody>
		            </table>
		            <div id="pages"><?=PAGE_URL?></div>
		            <!--p style="margin-top: 20px;">
									본인매출 색깔에 따라 매출구분이 됩니다. 외상/인정매출=붉은색, 현금매출=파란색, 카드매출=초록색, 기타매출=검정색, 매출금액 0이면 매출등록 안한 표시
								</p-->
		          </div>
		        </div>
		      </div>
		    </div>
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
		<!-- Editable -->
		<script src="<?=$skin_dir?>/assets/node_modules/jquery-datatables-editable/jquery.dataTables.js"></script>
		<script src="<?=$skin_dir?>/assets/node_modules/datatables/media/js/dataTables.bootstrap.js"></script>
		<script src="<?=$skin_dir?>/assets/node_modules/tiny-editable/mindmup-editabletable.js"></script>
		<script src="<?=$skin_dir?>/assets/node_modules/tiny-editable/numeric-input-example.js"></script>
		<script>
		  $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
		  $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
		  $(document).ready(function() {
		    $('#editable-datatable').DataTable();
		  });

		</script>
