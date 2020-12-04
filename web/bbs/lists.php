<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '공지사항')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '게시판')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, '공지사항')?></strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, $title)?></h5>
                        </div>
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-info">
                                       <strong><?=get_msg($select_lang, '총 건수')?> :</strong> <?=number_format($total_count)?>건
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped m-b-xs text-center">
                                        <thead>
                                            <tr>
                                                <th width="20%" class="text-center"><?=get_msg($select_lang, '번호')?></th>
                                                <th width="" class="text-center"><?=get_msg($select_lang, '제목')?></th>
												<?if($title == "1:1문의"){?>
                                            	<th width="" class="text-center"><?=get_msg($select_lang, '답변여부')?></th>
												<?}?>
                                                <th width="30%" class="text-center"><?=get_msg($select_lang, '날짜')?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
	                                    <? 
										$i = $total_count;
										foreach ($item as $row) :
											// $i+=1; 
											$regdate	=  date("y-m-d",strtotime($row->regdate));
					
											if($title == "1:1문의"){
												if($row->comment_count > 0){
													$answer = "답변완료";
												}
												else{
													$answer = "답변준비중";							
												}
											}
										?>
											
										<tr>
											<?if($title == "공지사항"){?>
											<td><b><?=$i?></b></td>
											<?}?>
											<td>
												<strong><a href="/bbs/views/<?=$bbs_name?>/<?=$row->bbs_no?>"><?=$row->subject?></a></strong>
											</td>
											<?if($title == "1:1문의"){?>
											<th data-field="id"><?=$answer?></th>
											<?}?>
											<td><?=$regdate?></td>
										</tr>
										<?
										$i--;
										endforeach
    									?> 
										<?$i = $total_count;
										if($i==0){?>
										<tr>
											<td colspan="3" height="50px;">내용이 없습니다.</td>
										</tr>
										<?}?>
                                        </tbody>										
                                        <tfoot>
											<tr>
                                                <td colspan="5">
                                                    <ul class="pagination" style="margin-top:10px">
													<?=PAGE_URL?>
													</ul>
                                                </td>
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

