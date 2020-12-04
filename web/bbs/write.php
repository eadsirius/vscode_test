<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="/data/plugin/ckeditor/ckeditor.js"></script>

	<!-- navbar -->
	<div class="navbar navbar-pages">
		<div class="container">
			<div class="content">
				<h4><a href="" class="link-back"><i class="fa fa-arrow-left "></i></a><?=$title?> 글쓰기</h4>
			</div>
			<div class="content-right">
				<a href="/"><i class="fa fa-home"></i></a>
				<a href="/member/login/out"><i class="fa fa-power-off"></i></a>
			</div>
		</div>
	</div>
	<!-- end navbar -->

	<!-- sign up -->
	<div class="sign-up segments-page">
		<div class="container">
			<div class="content b-shadow">
			<form name="writeForm" id="writeForm" action="<?current_url()?>" method="post" enctype="multipart/form-data">	
				<input type="hidden" name="member_id" 	value="<?=$member->member_id?>" />	
				<input type="hidden" name="name" 		value="<?=$member->name?>" /> 	
				<input type="hidden" name="email" 	value="<?=$member->email?>" /> 
				<input type="hidden" name="category" 	value="<?=$title?>" /> 
				
				<div class="content" style="text-align: left;">
					<h5>제목</h5>
					<div class="form-group">	
						<input type="text" name="subject" value="<?=@$item->subject?>">
					</div>
					
					<h5>내용</h5>
					<div class="form-group">		
						<textarea name="contents" id="contents" cols="30" rows="10" style="width:100%;min-height:150px"  placeholder="내용을 입력하세요"><?=@$item->contents?></textarea>
						<script>
						CKEDITOR.replace( 'contents' );
        					</script>
					</div>
				</div>
				
				<?if($cat > 0){?>
					<button type="submit" class="button">글수정</button>
				<?}else{?>
					<button type="submit" class="button">글작성</button>
				<?}?>
			<a href="/bbs/lists/<?=$table?>" class="button ">목록으로</a>
			</form>
			</div>
		</div>
	</div>
	<!-- end sign up -->