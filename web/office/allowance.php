<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
$select_lang = 'kr';

?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2>
                    <? if (substr($common_page_url,0,20) == 'office/allowance/day') { echo(get_msg($select_lang, '데일리 수당 (DAB)')); } ?>
                    <? if (substr($common_page_url,0,19) == 'office/allowance/mc') { echo(get_msg($select_lang, '추천매칭 수당 (MCB)')); } ?>
                    <? if (substr($common_page_url,0,19) == 'office/allowance/re') { echo(get_msg($select_lang, '공유 수당 (REB)')); } ?>
                    <!-- <? if ($common_page_url == 'office/allowance/mc2') { echo(get_msg($select_lang, '추천매칭2 보너스 (MCB2)')); } ?> -->
                    <!-- <? if ($common_page_url == 'office/allowance/re2') { echo(get_msg($select_lang, '간접추천 보너스 (REB2)')); } ?> -->
								</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '수당')?></a>
                    </li>
                    <li class="active">
                        <strong>
										<? if (substr($common_page_url,0,20) == 'office/allowance/day') { echo(get_msg($select_lang, '데일리 수당 (DAB)')); } ?>
                    <? if (substr($common_page_url,0,19) == 'office/allowance/mc') { echo(get_msg($select_lang, '추천매칭 수당 (MCB)')); } ?>
                    <? if (substr($common_page_url,0,19) == 'office/allowance/re') { echo(get_msg($select_lang, '공유 수당 (REB)')); } ?>
                    <!-- <? if ($common_page_url == 'office/allowance/mc2') { echo(get_msg($select_lang, '추천매칭2 보너스 (MCB2)')); } ?> -->
                    <!-- <? if ($common_page_url == 'office/allowance/re2') { echo(get_msg($select_lang, '간접추천 보너스 (REB2)')); } ?> -->
                        </strong>
                    </li>
								</ol>
								<p style="color: red;">시세 : 1Point = 10원</p>
								
            </div>
        </div>
        <div id="Allowance" class="wrapper wrapper-content animated fadeInRight">

            <div class="row m-b-lg m-t-md">
                <div class="col-md-12">

                    <div class="profile-image text-center">
                        <i class="fa fa-dollar fa-5x"></i>
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?=get_msg($select_lang, '수당 정보')?>
                                </h2>
                                <table class="table m-t-md m-b-xs">
                                    <tbody>
                                        <tr>
                                            <td><strong><?=get_msg($select_lang, '총 수당')?> :</strong> <span class="font-bold text-primary">
                                                <?=number_format($mb->total_point)?></span>
																						</td>
																						<? if (substr($common_page_url,0,20) == 'office/allowance/day') {?>
																							<td><strong><?=get_msg($select_lang, '데일리 수당')?> :</strong> <?=number_format($mb->day_point)?></td>
																						<?} elseif(substr($common_page_url,0,19) == 'office/allowance/mc'){ ?>
																							<td><strong><?=get_msg($select_lang, '추천매칭 수당')?> :</strong> <?=number_format($mb->mc_point)?></td>
																						<?} elseif(substr($common_page_url,0,19) == 'office/allowance/re'){ ?>
																							<td><strong><?=get_msg($select_lang, '공유 수당')?> :</strong> <?=number_format($mb->re_point)?></td>
																						<?}?>
																				</tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '수당 목록')?></h5>
                        </div>
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-info">
                                       <strong><?=get_msg($select_lang, '총횟수')?> :</strong> <?=number_format($total_rows)?>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped m-b-xs text-center">
                                            <thead>
                                                <tr>
                                                  <? if (substr($common_page_url,0,19) == 'office/allowance/mc') { ?>
                                                    <th width="5%" class="text-center"><?=get_msg($select_lang, 'Num')?></th>
                                                    <th width="20%" class="text-center"><?=get_msg($select_lang, '수당 종류')?></th>
                                                    <th width="" class="text-center"><?=get_msg($select_lang, 'POINT')?></th>
                                                    <th width="" class="text-center">하위ID</th>
                                                    <th width="" class="text-center">하위ID LEVEL</th>
                                                    <th width="" class="text-center">하위ID 데일리수당</th>
                                                    <th width="" class="text-center">지급율</th>
                                                    <th width="30%" class="text-center">수당발생일</th>
                                                  <? } else {?>
                                                    <th width="5%" class="text-center"><?=get_msg($select_lang, 'Num')?></th>
                                                    <th width="20%" class="text-center"><?=get_msg($select_lang, '수당 종류')?></th>
                                                    <th width="" class="text-center"><?=get_msg($select_lang, 'POINT')?></th>
                                                    <th width="" class="text-center"><?=get_msg($select_lang, '매출 POINT')?></th>
                                                    <th width="" class="text-center">지급율</th>
                                                    <th width="20%" class="text-center"><?=get_msg($select_lang, '수당발생일')?></th>
                                                    <? if(substr($common_page_url,0,20) == 'office/allowance/day') {?>
                                                      <th width="20%" class="text-center"><?=get_msg($select_lang, '매출발생일')?></th>
                                                    <? } ?>
                                                  <? } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? 
                                                $i=0;
                                                foreach($item as $row) {
                                                    $i+=1; 
                                                    $num = ($total_count) - ($i-1);
                                                    $regdate	=  date("y-m-d",strtotime($row->regdate));
                                                    
                                                    if($row->kind == 'day'){
                                                        $kind = "데일리";
                                                    }
                                                    else if($row->kind == 'mc'){
                                                        $kind = "추천매칭";								
                                                    }
                                                    else if($row->kind == 're'){
                                                        $kind = "직급";								
                                                    }
																								?>
																									
                                                <tr>
                                                  <? if (substr($common_page_url,0,19) == 'office/allowance/mc') { ?>
                                                    <td><?=$num?></td>
                                                    <td><?=$kind?></td>
                                                    <td><?=number_format((float)$row->point,0)?></td>
                                                    <td><?=$row->event_id?></td>
                                                    <td><?=$row->protg?></td>
                                                    <td><?=number_format((float)$row->saved_point,0)?></td>
                                                    <td><?=($row->msg * 100)?>%</td>
                                                    <td><?=date("Y-m-d",strtotime($regdate." +9 hours"))?></td>
                                                  <? } else { ?>
                                                    <td><?=$num?></td>
                                                    <td><?=$kind?></td>
                                                    <td><?=number_format((float)$row->point,0)?></td>
                                                    <td><?=number_format((float)$row->saved_point,0)?></td>
                                                    <td><?=($row->msg * 100)?>%</td>
                                                    <td><?=date("Y-m-d",strtotime($regdate." +9 hours"))?></td>
                                                    <? if(substr($common_page_url,0,20) == 'office/allowance/day') {?>
                                                      <td>20<?=substr($row->m_order_code,0,2)."-".substr($row->m_order_code,2,2)."-".substr($row->m_order_code,4,2)?></td>
                                                    <? } ?>
                                                  <? } ?>
                                                </tr>
                                                <? } ?>
                                                <?if($i==0){?>
                                                <tr>
                                                  <? if (substr($common_page_url,0,19) == 'office/allowance/mc') { ?>
                                                    <td colspan="8" style="background-color:#fff"><?=get_msg($select_lang, '내역 없음')?></td>
                                                  <? } elseif(substr($common_page_url,0,20) == 'office/allowance/day') { ?>
                                                    <td colspan="7" style="background-color:#fff"><?=get_msg($select_lang, '내역 없음')?></td>
                                                  <? } else { ?>
                                                    <td colspan="6" style="background-color:#fff"><?=get_msg($select_lang, '내역 없음')?></td>
                                                  <? } ?>
                                                </tr>
                                                <?}?>
                                            </tbody>
                                            <tfoot>
											                      	<tr>
                                              <? if (substr($common_page_url,0,19) == 'office/allowance/mc') { ?>
                                                <td colspan="8">
                                                  <ul class="pagination" style="margin-top:10px">
                                                    <?=PAGE_URL?>
                                                  </ul>
                                                </td>
                                              <? } elseif(substr($common_page_url,0,20) == 'office/allowance/day') { ?>
                                                <td colspan="7">
                                                  <ul class="pagination" style="margin-top:10px">
                                                    <?=PAGE_URL?>
                                                  </ul>
                                                </td>
                                              <? } else { ?>
                                                <td colspan="6">
                                                  <ul class="pagination" style="margin-top:10px">
                                                    <?=PAGE_URL?>
                                                  </ul>
                                                </td>
                                              <? } ?>
                                              </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
<style>
    .pagination span{
        margin: 3px;
    }
</style>        
<script>
var ShowDetail = function (kind, regdate) {
    Common.Dialog({ url: '/office/allowance/detail', param: { kind: kind, regdate : regdate } });
}

        $(document).ready(function () {
            window.setTimeout(function () {
                feeChange('0.03', $("#btnSelectFee"));
                $("#Allowance").removeClass("fadeInRight");
            }, 1000);
        });
</script>


<link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

<script type="text/javascript">
function formCheck() {
	var f = document.reg_form;

    if ($("#reg_form").find("input:radio[name=radio_btn]:checked").length == 0) {
        alert(Common.Lang['Please select an authentication method']);
        return false;
    }

    var con = $("#reg_form").find("input:radio[name=radio_btn]:checked").val();
    $("#reg_form").find("input[name=confing]").val(con);

    if ($("#feeArea").find("button.active").length == 0) {
        document.getElementById('fee').value = "";
    }

	if(f.confing.value == ''){
        alert(Common.Lang['Please select an authentication method']);
        return false;
		
	}
	if(f.fee.value == ''){
        alert(Common.Lang['Please click the withdrawal fee button']);
        return false;
		
	}
    return true;
}


function feeChange(fee, obj) 
{    
    obj.parent().find("button").removeClass("active");
    obj.addClass("active");
	document.getElementById('fee').value = fee;
}


function formCheck2() {
	var f = document.reg_form2;

    if ($("#reg_form2").find("input:radio[name=radio_btn2]:checked").length == 0) {
        alert(Common.Lang['Please select an authentication method']);
        return false;
    }

    var con = $("#reg_form2").find("input:radio[name=radio_btn2]:checked").val();
    $("#reg_form2").find("input[name=confing]").val(con);

	if(f.confing.value == ''){
        alert(Common.Lang['Please select an authentication method']);
        return false;
		
	}
    return true;
}


function formCheck3() {
	var f = document.reg_form3;

    if ($("#reg_form3").find("input:radio[name=radio_btn3]:checked").length == 0) {
        alert(Common.Lang['Please select an authentication method']);
        return false;
    }

    var con = $("#reg_form3").find("input:radio[name=radio_btn3]:checked").val();
    $("#reg_form3").find("input[name=confing]").val(con);

	if(f.confing.value == ''){
        alert(Common.Lang['Please select an authentication method']);
        return false;
		
	}
    return true;
}

</script>
