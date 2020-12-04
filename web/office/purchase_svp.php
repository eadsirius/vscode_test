<?php
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
                        <strong><?=get_msg($select_lang, 'SVP재매출하기')?></strong>
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
                                <span><?=get_msg($select_lang, 'WNS Token')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->token,4)?> WNS</h3>
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
                                <span><?=get_msg($select_lang, '전환포인트')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->point,4)?> P</h3>
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
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->volume)?> P</h3>
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
                                <span><?=get_msg($select_lang, '받은 수당 총합계')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal->su_day + $bal->su_re + $bal->su_re2 + $bal->su_mc + $bal->su_mc2,4)?> P</h3>
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
                                <span><?=get_msg($select_lang, '사용가능 총 합계')?></span>
                                <h3 class="font-bold" style="font-size:20px;"><?=number_format($bal_Withdraw,4)?> P</h3>
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
                                                <strong><?=get_msg($select_lang, '현재 매출 P')?> :</strong> <span class="font-bold text-primary"><?=number_format($bal->volume)?> P<!--<i class="fa fa-rub"></i>--></span>
                                            </p>
											<hr class="hr-line-dashed" style="margin:10px 0" />
                                            <p style="font-size:14px; line-height:1.7em; margin-bottom:0;">
                                                <strong><?=get_msg($select_lang, '추가적립 가능 P')?> :</strong> <span class="font-bold text-primary"><?=number_format($bal_Withdraw)?> 
																								P<!-- <i class="fa fa-rub"></i>--></span> 
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
                            <h5><?=get_msg($select_lang, 'Stakes Package Add')?></h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" name="reg_form" action="/office/purchase/svp_ok" method="post" >
                                <input type="hidden" 	name="point_no" 				id="point_no" 				value="<?=$po->point_no?>" required >
                                
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '패키지')?> :</label>
                                    <div class="col-lg-9"><p class="form-control-static"><?=str_replace('PK' , 'PK', $po->type)?>Level</p></div>
                                </div>
                                <hr class="hr-line-dashed" style="margin:10px 0" />
                                
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '현재 적립 가능 P')?> :</label>
                                    <div class="col-lg-9"><p class="form-control-static"><?=number_format($bal_Withdraw)?></p></div>
                                    <input type="hidden" name="cansvp" id="cansvp" value="<?=$bal_Withdraw?>">
                                </div>
                                <hr class="hr-line-dashed" style="margin:10px 0" />
                                
                                <input type="hidden" name="purchase_kind" id="purchase_kind" value="send" />
                                <div id="sendAddressArea2" class="form-group has-success" >
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '추가적립 할 P')?></label>
																		<div class="col-lg-9"><input type="text" class="form-control" name="count" id="count" value="" required /></div>
																		<p style="color:red; font-size:11px; font-weight:bold; padding-left:100px;">*수당금액 3000SVP 이상 재매출 가능합니다.</p>
                                </div>
                                
                                <hr class="hr-line-dashed" style="margin:10px 0" />
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                       <button class="btn btn-primary " type="submit" id='btn_submit'>
                                        <!-- <button class="btn btn-primary " id="submitbutton1" name="submitbutton1" type="button" > -->
                                        	<i class="fa fa-check"></i>&nbsp;<?=get_msg($select_lang, 'P 추가적립하기')?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

<script type="text/javascript">
$(document).ready(function() {
    $('#btn_submit').click(function() {
       var svp = Number($('#count').val());
       var cansvp = Number($('#cansvp').val());
      
        if($('#count').val() == "") {
            alert("SVP를 입력해주세요.");
            return false;
        }
        if(svp > cansvp) {
            alert("현재 적립 가능한 SVP보다 많이 입력할 수 없습니다.");
            return false;
        }
        if(svp < 3000) {
            alert("추가적립 할 SVP는 최소 3,000 P 입니다.");
            return false;
        } 
            // document.getElementByName("reg_form").submit();
        


    })
    
});

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