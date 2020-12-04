<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-12">
    <h2><?=get_msg($select_lang, '매출하기')?></h2>
    <ol class="breadcrumb">
      <li>
        <a href="/"><?=get_msg($select_lang, '홈')?></a>
      </li>
      <li>
        <a><?=get_msg($select_lang, '매출관리')?></a>
      </li>
      <li class="active">
        <strong><?=get_msg($select_lang, '매출하기')?></strong>
      </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row m-b">
    <p style="margin-top: 10px; margin-left: 15px;">지급율은 총포인트 ÷ (Active 매출 X 2) X 100 입니다. </p>
    <div class="row m-b">
      <div class="col-lg-3 col-md-6">
        <div class="widget style1 navy-bg">
          <div class="row">
            <div class="col-xs-12 text-center">
              <span>Active 매출</span>
            </div>
            <div class="col-xs-12 text-right">
              <h3 class="font-bold" style="font-size:20px;"><?=number_format($mb->active_point)?> P</h3>
              <p><?=number_format($mb->active_point * 10) ?>원</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="widget style1 navy-bg">
          <div class="row">
            <div class="col-xs-12 text-center">
              <span>총포인트 (지급율)</span>
            </div>
            <div class="col-xs-12 text-right">
              <h3 class="font-bold" style="font-size:20px; ">
                <?=number_format($mb->active_total_point)?> P (
                <?=$total_percent?>%)</h3>
              <p><?=number_format($mb->active_total_point*10 )?>원 (
                <?=$total_percent?>%)</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="widget style1 navy-bg">
          <div class="row">
            <div class="col-xs-12 text-center">
              <span>데일리 수당</span>
            </div>
            <div class="col-xs-12 text-right">
              <h3 class="font-bold" style="font-size:20px;"><?=number_format($mb->active_daily_point)?> P</h3>
              <p><?=number_format($mb->active_daily_point * 10)?>원 (
                <?=$daily_percent?>%)</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="widget style1 navy-bg">
          <div class="row">
            <div class="col-xs-12 text-center">
              <span>추천매칭 수당</span>
            </div>
            <div class="col-xs-12 text-right">
              <h3 class="font-bold" style="font-size:20px;"><?=number_format($mb->active_mc_point)?> P</h3>
              <p><?=number_format($mb->active_mc_point * 10)?>원 (
                <?=$mc_percent?>%)</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="widget style1 navy-bg">
          <div class="row">
            <div class="col-xs-12 text-center">
              <span>공유 수당</span>
            </div>
            <div class="col-xs-12 text-right">
              <h3 class="font-bold" style="font-size:20px;"><?=number_format($mb->active_re_point)?> P</h3>
              <p><?=number_format($mb->active_re_point * 10)?>원 (
                <?=$re_percent?>%)</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row landing-page">
      <div class="col-lg-4">
        <ul class="pricing-plan list-unstyled white-bg no-margins qm1 pricing-plan1">
          <li class="pricing-title">
            데일리 수당
          </li>
          <li class="pricing-price daily-price">
            <ul>
              <li>매출금액</li>
              <li>일수익률</li>
              <li>데일리수당</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>100 만원</li>
              <li>1 %</li>
              <li>&#8361; 10,000</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>300 만원</li>
              <li>1 %</li>
              <li>&#8361; 30,000</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>700 만원</li>
              <li>1 %</li>
              <li>&#8361; 70,000</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>1000 만원</li>
              <li>1 %</li>
              <li>&#8361; 100,000</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>3000 만원</li>
              <li>1 %</li>
              <li>&#8361; 300,000</li>
            </ul>
          </li>

        </ul>
      </div>

      <div class="col-lg-4">
        <ul class="pricing-plan list-unstyled white-bg no-margins qm2 pricing-plan2">
          <li class="pricing-title">
            추천매칭 수당
          </li>
          <li class="pricing-price daily-price">
            <ul>
              <li>레벨</li>
              <li>보상</li>
              <li>기준</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>1대</li>
              <li>30%</li>
              <li>데일리 기준</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>2대</li>
              <li>20%</li>
              <li>데일리 기준</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>3대</li>
              <li>10%</li>
              <li>데일리 기준</li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="col-lg-4">
        <ul class="pricing-plan list-unstyled white-bg no-margins qm2 pricing-plan2">
          <li class="pricing-title">
            공유 수당
          </li>
          <li class="pricing-price daily-price">
            <ul>
              <li>레벨</li>
              <li>보상</li>
              <li>기준</li>
            </ul>
          </li>
          <li>
            <ul>
              <li>4대~10대</li>
              <li>0.1%</li>
              <li>매출, 재매출 기준</li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="col-lg-12">
        <ul class="pricing-plan list-unstyled white-bg no-margins qm1 pricing-plan1">
          <span class="btn btn-outline m-sm"> <?=get_msg($select_lang, '관리자에게 매출등록을 문의하십시오')?></span>
        </ul>
      </div>
    </div>

  </div>

  <script type="text/javascript">
    function formCheck(formName) {
      if (formName == 'PK1') {
        var amount = document.getElementById('send_amount1').value;
        var point = document.getElementById('point1').value;
      } else if (formName == 'PK2') {
        var amount = document.getElementById('send_amount2').value;
        var point = document.getElementById('point2').value;
      } else if (formName == 'PK3') {
        var amount = document.getElementById('send_amount3').value;
        var point = document.getElementById('point3').value;
      } else if (formName == 'PK4') {
        var amount = document.getElementById('send_amount4').value;
        var point = document.getElementById('point4').value;
      }

      //	if(amount < point){
      //    	alert(formName + ' Please enter quantity of purchase');
      //	}


      //    if(confirm("Do you want to buy with Bitcoin?\n\nPurchasing will not be reversible.")) {
      /* return true 하게 되는 경우 다음 구문이 필요 없게 됨.*/
      //        $targetForm.hide();
      document.getElementById("btn_submit1").disabled = "disabled";
      document.getElementById("btn_submit2").disabled = "disabled";
      document.getElementById("btn_submit3").disabled = "disabled";
      //        document.getElementById("btn_submit4").disabled = "disabled";

      return true;
      //    }

      //    return false;

    }

    function comma(str) {
      str = String(str);
      return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    }

    function givenfees(formName) {

      if (formName == 'reg_form1') {
        var count = document.getElementById('count1').value;
        var usd = document.getElementById('usd1').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount1').value = comma(amount);

        document.getElementById('amount2').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount6').value = '';
        document.getElementById('amount7').value = '';
        document.getElementById('amount8').value = '';

        document.getElementById('count2').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form2') {
        var count = document.getElementById('count2').value;
        var usd = document.getElementById('usd2').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount2').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount6').value = '';
        document.getElementById('amount7').value = '';
        document.getElementById('amount8').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form3') {
        var count = document.getElementById('count3').value;
        var usd = document.getElementById('usd3').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount3').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount2').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount6').value = '';
        document.getElementById('amount7').value = '';
        document.getElementById('amount8').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count2').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form4') {
        var count = document.getElementById('count4').value;
        var usd = document.getElementById('usd4').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount4').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount2').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount6').value = '';
        document.getElementById('amount7').value = '';
        document.getElementById('amount8').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count2').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form5') {
        var count = document.getElementById('count5').value;
        var usd = document.getElementById('usd5').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount5').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount2').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count2').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form6') {
        var count = document.getElementById('count6').value;
        var usd = document.getElementById('usd6').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount6').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount2').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount7').value = '';
        document.getElementById('amount8').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count2').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count7').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form7') {
        var count = document.getElementById('count7').value;
        var usd = document.getElementById('usd7').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount7').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount2').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount6').value = '';
        document.getElementById('amount8').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count2').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count8').value = '';
      } else if (formName == 'reg_form8') {
        var count = document.getElementById('count8').value;
        var usd = document.getElementById('usd8').value;

        var amount = usd * count;
        amount = amount.toFixed(2);
        document.getElementById('amount8').value = comma(amount);

        document.getElementById('amount1').value = '';
        document.getElementById('amount2').value = '';
        document.getElementById('amount3').value = '';
        document.getElementById('amount4').value = '';
        document.getElementById('amount5').value = '';
        document.getElementById('amount6').value = '';
        document.getElementById('amount7').value = '';

        document.getElementById('count1').value = '';
        document.getElementById('count2').value = '';
        document.getElementById('count3').value = '';
        document.getElementById('count4').value = '';
        document.getElementById('count5').value = '';
        document.getElementById('count6').value = '';
        document.getElementById('count7').value = '';
      }
    }

  </script>
