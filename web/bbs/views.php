<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, $title)?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '게시판')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, $title)?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row animated fadeInRight">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>[<?=$item->category?>] <?=$item->subject?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
									<table class="table table-striped">
									</thead>
									<tbody>
										<tr>
											<td><?=@$item->contents?></td>
										</tr>
										
									<?if($table == "qna"){?>
										<tr>
											<th data-field="id"><p>문의답변</p></th>
										</tr>
										<tr>
											<td><?=@$item->memo?></td>
										</tr>
									<?}?>
									
										<tr>
											<th data-field="id"><p>Date : <?=$item->regdate?></p></th>
										</tr>
									</tbody>
									</table>
								</div>
								<div class="wrap-content b-shadow" style="margin-left: 20px;">
								<?if($title == '1:1문의'){?>
									<a href="/bbs/edit/<?=$table?>/<?=$item->bbs_no?>" class="button ">수정</a>	
									<a href="/bbs/del/<?=$table?>/<?=$item->bbs_no?>" class="button ">삭제</a>
								<?}?>     
					   
                                <a href="/bbs/lists/<?=$bbs_name?>" class="btn btn-info">목록으로</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>