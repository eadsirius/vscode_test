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
                                                    <input type="text" class="form-control" id="cfg_site" name="cfg_site" value="<?=$site->cfg_site?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">사이트관리자 :</label>
                                                    <input type="text" class="form-control" id="cfg_admin" name="cfg_admin" value="<?=$site->cfg_admin?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">사이트 소재지 :</label>
                                                    <select class="custom-select form-control" id="cfg_country" name="cfg_country">
														<option value='USA' >United States</option>
														<option value='ENG' >England</option>
														<option value='CAN' > Canada (Français)</option>
														<option value='APM' >България</option>
														<option value='JAP' >日本</option>
														<option value='KOR' selected="selected" >대한민국</option>
														<option value='CHA' >中国</option>
														<option value='THA' >ฉันจะจำค</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">운영개시일 :</label>
                                                    <input type="date" class="form-control" id="regdate" name="regdate" value="<?=$site->regdate?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">코인(토큰)이름 :</label>
                                                    <input type="text" class="form-control" id="cfg_pay" name="cfg_pay" value="<?=$site->cfg_pay?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">기본 레버리지 :</label>
                                                    <input type="text" class="form-control" id="cfg_pay_change" name="cfg_pay_change" value="<?=$site->cfg_pay_change?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">USD 시세 :</label>
                                                    <input type="text" class="form-control" id="cfg_usd" name="cfg_usd" value="<?=$site->cfg_usd?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">WON 시세 :</label>
                                                    <input type="text" class="form-control" id="cfg_won" name="cfg_won" value="<?=$site->cfg_won?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">출금수수료 :</label>
                                                    <input type="text" class="form-control" id="cfg_send_persent" name="cfg_send_persent" value="<?=$site->cfg_send_persent?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">외상매출 변제 비율 :</label>
                                                    <input type="text" class="form-control" id="cfg_back_persent" name="cfg_back_persent" value="<?=$site->cfg_back_persent?>"> </div>
                                            </div>
                                        </div>
                                    </section>
                                    
                                    <!-- Step 2 -->
                                    <h6>매출및기본수당</h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">1레벨 매출 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_point" value="<?=$site->cfg_level1_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">1레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_leverage" value="<?=$site->cfg_level1_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">1레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_total" value="<?=$site->cfg_level1_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">1레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_airdrop" value="<?=$site->cfg_level1_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">1레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_re_persent" value="<?=$site->cfg_level1_re_persent?>"> </div>
                                            </div>
                                        </div>
	                                    
	                                    
	                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">데일리수당(주지급) :</label>
                                                    <input type="text" class="form-control" id="cfg_day_persent" name="cfg_day_persent" value="<?=$site->cfg_day_persent?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">리더십보너스 :</label>
                                                    <input type="text" class="form-control" id="cfg_leader_persent" name="cfg_leader_persent" value="<?=$site->cfg_leader_persent?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">센타비 :</label>
                                                    <input type="text" class="form-control" id="cfg_ct_persent" name="cfg_ct_persent" value="<?=$site->cfg_ct_persent?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">센타소개비 :</label>
                                                    <input type="text" class="form-control" id="cfg_ct_re_persent" name="cfg_ct_re_persent" value="<?=$site->cfg_ct_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업1차 시작대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll1_start" name="cfg_roll1_start" value="<?=$site->cfg_roll1_start?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업1차 끝대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll1_end" name="cfg_roll1_end" value="<?=$site->cfg_roll1_end?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업1차 지급율:</label>
                                                    <input type="text" class="form-control" id="cfg_roll1_point" name="cfg_roll1_point" value="<?=$site->cfg_roll1_point?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업2차 시작대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll2_start" name="cfg_roll2_start" value="<?=$site->cfg_roll2_start?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업2차 끝대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll2_end" name="cfg_roll2_end" value="<?=$site->cfg_roll2_end?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업2차 지급율:</label>
                                                    <input type="text" class="form-control" id="cfg_roll2_point" name="cfg_roll2_point" value="<?=$site->cfg_roll2_point?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업3차 시작대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll3_start" name="cfg_roll3_start" value="<?=$site->cfg_roll3_start?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업3차 끝대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll3_end" name="cfg_roll3_end" value="<?=$site->cfg_roll3_end?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업3차 지급율:</label>
                                                    <input type="text" class="form-control" id="cfg_roll3_point" name="cfg_roll3_point" value="<?=$site->cfg_roll3_point?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업4차 시작대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll4_start" name="cfg_roll4_start" value="<?=$site->cfg_roll4_start?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업4차 끝대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll4_end" name="cfg_roll4_end" value="<?=$site->cfg_roll4_end?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업4차 지급율:</label>
                                                    <input type="text" class="form-control" id="cfg_roll4_point" name="cfg_roll4_point" value="<?=$site->cfg_roll4_point?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업5차 시작대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll5_start" name="cfg_roll5_start" value="<?=$site->cfg_roll5_start?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업5차 끝대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll5_end" name="cfg_roll5_end" value="<?=$site->cfg_roll5_end?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업5차 지급율:</label>
                                                    <input type="text" class="form-control" id="cfg_roll5_point" name="cfg_roll5_point" value="<?=$site->cfg_roll5_point?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업6차 시작대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll6_start" name="cfg_roll6_start" value="<?=$site->cfg_roll6_start?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업6차 끝대수:</label>
                                                    <input type="text" class="form-control" id="cfg_roll6_end" name="cfg_roll6_end" value="<?=$site->cfg_roll6_end?>"> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">롤업6차 지급율:</label>
                                                    <input type="text" class="form-control" id="cfg_roll6_point" name="cfg_roll6_point" value="<?=$site->cfg_roll6_point?>"> </div>
                                            </div>
                                        </div>
                                    </section>
                                    
                                    <!-- Step 3 -->
                                    <h6>직급설정</h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">1레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_point" value="<?=$site->cfg_level1_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">1레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_leverage" value="<?=$site->cfg_level1_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">1레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_total" value="<?=$site->cfg_level1_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">1레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_airdrop" value="<?=$site->cfg_level1_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">1레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level1_re_persent" value="<?=$site->cfg_level1_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">2레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level2_point" value="<?=$site->cfg_level2_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">2레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level2_leverage" value="<?=$site->cfg_level2_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">2레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level2_total" value="<?=$site->cfg_level2_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">2레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control"  name="cfg_level2_airdrop" value="<?=$site->cfg_level2_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">2레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level2_re_persent" value="<?=$site->cfg_level2_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">3레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level3_point" value="<?=$site->cfg_level3_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">3레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level3_leverage" value="<?=$site->cfg_level3_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">3레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level3_total" value="<?=$site->cfg_level3_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">3레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control"  name="cfg_level3_airdrop" value="<?=$site->cfg_level3_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">3레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level3_re_persent" value="<?=$site->cfg_level3_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">4레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level4_point" value="<?=$site->cfg_level4_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">4레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level4_leverage" value="<?=$site->cfg_level4_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">4레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level4_total" value="<?=$site->cfg_level4_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">4레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control"  name="cfg_level4_airdrop" value="<?=$site->cfg_level4_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">4레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level4_re_persent" value="<?=$site->cfg_level4_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">5레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level5_point" value="<?=$site->cfg_level5_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">5레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level5_leverage" value="<?=$site->cfg_level5_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">5레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level5_total" value="<?=$site->cfg_level5_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">5레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control"  name="cfg_level5_airdrop" value="<?=$site->cfg_level5_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">5레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level5_re_persent" value="<?=$site->cfg_level5_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">6레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level6_point" value="<?=$site->cfg_level6_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">6레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level6_leverage" value="<?=$site->cfg_level6_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">6레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level6_total" value="<?=$site->cfg_level6_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">6레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control"  name="cfg_level6_airdrop" value="<?=$site->cfg_level6_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">6레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level6_re_persent" value="<?=$site->cfg_level6_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">7레벨 몸값 :</label>
                                                    <input type="text" class="form-control" name="cfg_level7_point" value="<?=$site->cfg_level7_point?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">7레벨 레버리지 :</label>
                                                    <input type="text" class="form-control" name="cfg_level7_leverage" value="<?=$site->cfg_level7_leverage?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">7레벨 PO :</label>
                                                    <input type="text" class="form-control" name="cfg_level7_total" value="<?=$site->cfg_level7_total?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">7레벨 에어드롭 :</label>
                                                    <input type="text" class="form-control"  name="cfg_level7_airdrop" value="<?=$site->cfg_level7_airdrop?>"> </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">7레벨 추천지급율 :</label>
                                                    <input type="text" class="form-control" name="cfg_level7_re_persent" value="<?=$site->cfg_level7_re_persent?>"> </div>
                                            </div>
                                        </div>
                                        
                                    </section>
                                    
                                    <!-- Step 4 -->
                                    <h6>MCV설정</h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title">MCV 수당탈 자격 :</label>
                                                    <input type="text" class="form-control" id="mcv_su_limit" name="mcv_su_limit" value="<?=$site->mcv_su_limit?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">MCV 추천1대 :</label>
                                                    <input type="text" class="form-control" id="mcv_re1" name="mcv_re1" value="<?=$site->mcv_re1?>"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">MCV 추천2대 :</label>
                                                    <input type="text" class="form-control" id="mcv_re2" name="mcv_re2" value="<?=$site->mcv_re2?>"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV A-Step 수당 :</label>
                                                    <input type="text" class="form-control" name="mcv_step1" value="<?=$site->mcv_step1?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV A-Step 몸값 :</label>
                                                    <input type="text" class="form-control" name="mcv_step1_sale" value="<?=$site->mcv_step1_sale?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">A-Step 직1대 합산매수:</label>
                                                    <input type="text" class="form-control" name="mcv_step1_re1_volume" value="<?=$site->mcv_step1_re1_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">A-Step 직2대 합산매수 :</label>
                                                    <input type="text" class="form-control" name="mcv_step1_re2_volume" value="<?=$site->mcv_step2_re1_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">A-Step 직1대 1만개이상자:</label>
                                                    <input type="text" class="form-control" name="mcv_step1_re1_count" value="<?=$site->mcv_step1_re1_count?>"> </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV B-Step 수당 :</label>
                                                    <input type="text" class="form-control" name="mcv_step2" value="<?=$site->mcv_step2?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV B-Step 몸값 :</label>
                                                    <input type="text" class="form-control" name="mcv_step2_sale" value="<?=$site->mcv_step2_sale?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">B-Step 직1대 합산매수:</label>
                                                    <input type="text" class="form-control" name="mcv_step2_re1_volume" value="<?=$site->mcv_step2_re1_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">B-Step 직2대 합산매수 :</label>
                                                    <input type="text" class="form-control" name="mcv_step2_re2_volume" value="<?=$site->mcv_step2_re2_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">B-Step 직1대 1만개이상자:</label>
                                                    <input type="text" class="form-control" name="mcv_step2_re1_count" value="<?=$site->mcv_step2_re1_count?>"> </div>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV C-Step 수당 :</label>
                                                    <input type="text" class="form-control" name="mcv_step3" value="<?=$site->mcv_step3?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV C-Step 몸값 :</label>
                                                    <input type="text" class="form-control" name="mcv_step3_sale" value="<?=$site->mcv_step3_sale?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">C-Step 직1대 합산매수:</label>
                                                    <input type="text" class="form-control" name="mcv_step3_re1_volume" value="<?=$site->mcv_step3_re1_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">C-Step 직2대 합산매수 :</label>
                                                    <input type="text" class="form-control" name="mcv_step3_re2_volume" value="<?=$site->mcv_step3_re2_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">C-Step 직1대 1만개이상자:</label>
                                                    <input type="text" class="form-control" name="mcv_step3_re1_count" value="<?=$site->mcv_step3_re1_count?>"> </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV D-Step 수당 :</label>
                                                    <input type="text" class="form-control" name="mcv_step4" value="<?=$site->mcv_step4?>"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="title">MCV D-Step 몸값 :</label>
                                                    <input type="text" class="form-control" name="mcv_step4_sale" value="<?=$site->mcv_step4_sale?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">D-Step 직1대 합산매수:</label>
                                                    <input type="text" class="form-control" name="mcv_step4_re1_volume" value="<?=$site->mcv_step4_re1_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">D-Step 직2대 합산매수 :</label>
                                                    <input type="text" class="form-control" name="mcv_step4_re2_volume" value="<?=$site->mcv_step4_re2_volume?>"> </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">D-Step 직1대 1만개이상자:</label>
                                                    <input type="text" class="form-control" name="mcv_step4_re1_count" value="<?=$site->mcv_step4_re1_count?>"> </div>
                                            </div>
                                            * 직1대 합산매수 0이고 직2대 합산매수 0보다 크면 직1대+직2대 합산으로 인식합니다.
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
            © 2019 UCE TOKEN
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