<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '구매')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '구매')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, '구매')?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row m-b">
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bitcoin fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span>WNS Token</span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->token,2)?> WNS</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-exchange fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, 'WNS Token에서 전환된 포인트')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->point,2)?> P</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-history fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, 'WNS Stakes')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->volume,2)?> P</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-sitemap fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, '총 수당')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->total_point,2)?> P</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, 'WNS Stakes')?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-success m-b-sm">
                                        <div class="panel-heading">
                                            <?=get_msg($select_lang, '적립 정보')?>
                                        </div>
                                        <div class="panel-body">
                                            <p style="font-size:14px; line-height:1.7em; margin-bottom:0;">
                                                <strong><?=get_msg($select_lang, 'Point')?> :</strong> <span class="font-bold text-primary"><?=number_format($bal->point)?> <i class="fa fa-rub"></i></span>
                                            </p>
                                            <hr class="hr-line-dashed" style="margin:10px 0" />
                                            <p style="font-size:14px; line-height:1.7em; margin-bottom:0;">
                                                <strong><?=get_msg($select_lang, '현재 스테이킹 중인 Point')?> :</strong> <?=number_format($bal->volume)?> P
                                            </p>
                                            <hr class="hr-line-dashed" style="margin:10px 0" />
                                            <p style="font-size:14px; line-height:1.7em; margin-bottom:0;">
                                                <strong><?=get_msg($select_lang, '회원 ID')?> :</strong> <?=$this->session->userdata('member_id')?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '스테이킹 할 포인트 수량을 넣어주세요.')?></h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" name="reg_form" action="/office/purchase/purchase_ok" method="post" onsubmit="return formCheck(this);">
                                <!--
	                            <input type="hidden" 	name="thing" 				id="thing" 				value="<?=$thing?>" required >
                                <input type="hidden" 	name="purchase_start" 		id="purchase_start" 	value="<?=$purchase_start?>" required >
                                <input type="hidden"  	name="purchase_end" 		id="purchase_end" 		value="<?=$purchase_end?>" required >
                                -->
                                <input type="hidden"  	name="cash" 				id="cash" 				value="<?=$cash?>" required >
                                <input type="hidden"  	name="level" 				id="level" 				value="<?=$level?>" required >
                                
                                <!--div class="form-group">
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '패키지')?> :</label>
                                    <div class="col-lg-9"><p class="form-control-static"><?=str_replace('PK' , 'PK', $thing)?></p></div>
                                </div>
                                <hr class="hr-line-dashed" style="margin:10px 0" /-->
                                
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '최소 적립 Point')?> :</label>
                                    <div class="col-lg-9"><p class="form-control-static"><?=number_format($purchase_start)?> P</p></div>
                                </div>
                                <hr class="hr-line-dashed" style="margin:10px 0" />
                                
                                <input type="hidden" name="purchase_kind" id="purchase_kind" value="send" />
                                <div id="sendAddressArea2" class="form-group has-success" >
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '적립할 Point')?></label>
                                    <!-- <div class="col-lg-9"><input type="text" class="form-control" name="count" id="count" value="" required /></div> -->
                                    <select class="col-lg-4" name="count" id="count" style="font-size: 18px;">
                                        <option value="120000">$ 1,000 (= 120,000 P)</option>
                                        <option value="360000">$ 3,000 (= 360,000 P)</option>
                                        <option value="600000">$ 5,000 (= 600,000 P)</option>
                                        <option value="1200000">$ 10,000 (= 1,200,000 P)</option>
                                    </select>

                                </div>
                                
                                <hr class="hr-line-dashed" style="margin:10px 0" />
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                        <button class="btn btn-primary " type="submit" id='btn_submit'>
                                        <!-- <button class="btn btn-primary " id="submitbutton" name="submitbutton" type="button" > -->
                                        	<!-- <i class="fa fa-check"></i>&nbsp;<?=str_replace('QM' , 'X', $thing)?> <?=get_msg($select_lang, '적립완료')?></button> -->
                                        	<i class="fa fa-check"></i>&nbsp;<?=get_msg($select_lang, '적립완료')?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
<script type="text/javascript">
function formCheck(frm)
{
	var f = document.reg_form;
    
    if (frm.count.value == "") {
        alert("Please enter the P");
        frm.amount.focus();
        return false;
    }
    
	document.getElementById("btn_submit").disabled = "disabled";
	return true;
}

function call()
{
	if(document.getElementById("amount").value)
	{
		var amount 		= parseFloat(document.getElementById('amount').value);
		var cash 		= parseFloat(document.getElementById('cash').value);
		var count 		= 0;
		
		count = parseFloat(amount / 10);
		document.getElementById('count').value = count;
	}
}


<?if($site->cfg_phone_out == 1){?>
function mobileChange() 
{
    var frm = document.reg_form;
    
    var e = $("#country option:selected").val();

	frm.type.value = e;
}

function send_sms() {
    var f = document.reg_form;

    if (f.mobile.value == "") {
        alert("Please enter your cell phone number.");
        f.mobile.focus();
        return false;
    }

    if (f.country.value == "") {
        alert("Please select a country");
        f.country.focus();
        return false;
    }
        
    $.ajax({	    
        url:'/member/sms?mobile=' + $('#type').val() + $('#mobile').val(),
        type: "get",
        dataType:"html",
        success: function(data){
            console.log(data);
        }
    });

}
<?}?>

</script>