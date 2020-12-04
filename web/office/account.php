<?php
$select_lang = 'kr';
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-12">
    <h2><?=get_msg($select_lang, '계정 정보')?></h2>
    <ol class="breadcrumb">
      <li>
        <a href="/"><?=get_msg($select_lang, '홈')?></a>
      </li>
      <li>
        <a><?=get_msg($select_lang, '계정')?></a>
      </li>
      <li class="active">
        <strong><?=get_msg($select_lang, '계정 정보')?></strong>
      </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5><?=get_msg($select_lang, '계정 정보')?></h5>
        </div>
        <div class="ibox-content">
          <form method="get" class="form-horizontal">
            <div class="form-group">
              <label class="col-lg-2 control-label"><?=get_msg($select_lang, '멤버 ID')?> :</label>
              <div class="col-lg-10">
                <p class="form-control-static font-bold text-primary"><?=$mb->member_id?></p>
              </div>
            </div>
            <div class="hr-line-dashed" style="margin:10px 0"></div>

            <div class="form-group">
              <label class="col-lg-2 control-label"><?=get_msg($select_lang, '추천')?> :</label>
              <div class="col-lg-10">
                <p class="form-control-static"><?=$mb->recommend_id?></p>
              </div>
            </div>
            <div class="hr-line-dashed" style="margin:10px 0"></div>
          </form>
        </div>

        <div class="ibox-content">
          <form method="get" class="form-horizontal">

            <div class="form-group">
              <label class="col-lg-2 control-label"><?=get_msg($select_lang, '누적 매출')?> :</label>
              <div class="col-lg-10">
                <p class="form-control-static">&#8361; <?=number_format($mb->total_sales*10,0)?> 원</p>
              </div>
            </div>
            <div class="hr-line-dashed" style="margin:10px 0"></div>

            <div class="form-group">
              <label class="col-lg-2 control-label"><?=get_msg($select_lang, '수당')?> :</label>
              <div class="col-lg-10">
                <p class="form-control-static"><?=number_format($mb->active_total_point,0)?> P </p>
              </div>
            </div>
            <div class="hr-line-dashed" style="margin:10px 0"></div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5><?=get_msg($select_lang, '추천 정보')?>.</h5>
        </div>
        <div class="ibox-content">

          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-info">
                <strong><?=get_msg($select_lang, '추천 수')?> :</strong> <?=$reCnt?> 명 / 총매출액 :
                <?= number_format($recommend_total->total_sales);?> P
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-striped m-b-xs text-center">
                  <thead>
                    <tr>
                      <th width="20%" class="text-center"><?=get_msg($select_lang, '아이디')?></th>
                      <th width="" class="text-center"><?=get_msg($select_lang, '이름')?></th>
                      <th width="20%" class="text-center"><?=get_msg($select_lang, '총매출액 ')?></th>
                      <th width="20%" class="text-center"><?=get_msg($select_lang, '첫매출액 (첫매출날짜)')?></th>
                      <th width="20%" class="text-center"><?=get_msg($select_lang, '가입날짜')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <? 
												$i=0;
												foreach($history as $row) {
													$i+=1; 
													$regdate	=  date("y-m-d",strtotime($row->regdate));
												?>
                    <tr>
                      <td class="text-center"><?=$row->member_id?></td>
                      <td class="text-center"><?=$row->name?></td>
                      <td class="text-center"><?=number_format($row->total_point,0)?></td>
                      <td class="text-center"><?=number_format($row->point,0)?> (<?=$row->sales_regdate?>)</td>
                      <td class="text-center"><?=$row->regdate?></td>
                    </tr>
                    <? } ?>
                    <?if($i==0){?>
                    <tr>
                      <td colspan="5" class="text-center"><?=get_msg($select_lang, '내역 없음')?></td>
                    </tr>
                    <?}?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
