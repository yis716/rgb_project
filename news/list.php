<? 
	session_start(); 
	@extract($_POST);
	@extract($_GET);
	@extract($_SESSION);

	$table = "news";	// sql문에서 table명을 변수로 처리
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>News&Notice</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
	<link rel="stylesheet" href="../common/css/common.css">
    <link rel="stylesheet" href="./css/news.css">
	<script src="../common/js/jquery-1.12.4.min.js"></script>
    <script src="../common/js/jquery-migrate-1.4.1.min.js"></script>
</head>
<?
	include "../lib/dbconn.php";

    
   	if (!$scale)
    	$scale=5;			// 한 화면에 표시되는 글 수

    
    if ($mode=="search") // 검색모드일때
	{
		if(!$search)
		{
			echo("
				<script>
					window.alert('검색할 단어를 입력해 주세요!');
					history.go(-1);
				</script>
			");
			exit;
		}

		$sql = "select * from $table where $find like '%$search%' order by num desc";
	}
	else // 기본리스트
	{
		$sql = "select * from $table order by num desc";
	}

	$result = mysqli_query( $connect, $sql);

	$total_record = mysqli_num_rows($result); // 전체 글 수

	// 전체 페이지 수($total_page) 계산 
	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	if (!$page)                 // 페이지번호($page)가 0 일 때
		$page = 1;              // 페이지 번호를 1로 초기화
 
	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      
	$number = $total_record - $start;
?>
<body>
	<div class="skipNav">
        <a href="#content">본문 바로가기</a>
        <a href="#gnb">글로벌 네비게이션 바로가기</a>   
    </div>

	<div class="wrap">

		<? include '../common/sub_header.html' ?>
		
		<main id="content" class="container news">
			<div class="title">
				<!-- <h2>News&Notice</h2> -->
				<h3>NEWS & NOTICE</h3>
                <p>
                    플럭시티의<br>
                    <strong>최신 소식들을 만나보세요.</strong>
                </p>
			</div>
			<div class="content_area">
				<div class="photo_bbs_wrap">
										
					<div class="bbs_lst">
						<ul class="lst_cont">
							<?		
								for ($i = $start; $i < $start + $scale && $i < $total_record; $i++)                    
								{
									mysqli_data_seek($result, $i);         
									$row = mysqli_fetch_array($result);

									$item_num     = $row['num'];
									$item_subject = str_replace(" ", "&nbsp;", $row['subject']);
									$item_content = mb_substr(strip_tags($row['content']), 0, 60, 'utf-8');
									$item_date    = substr($row['regist_day'], 0, 50);
									// $item_hit     = $row['hit'];
									$item_category = str_replace(" ", "&nbsp;", $row['category_1']);
									$item_img     = $row['file_copied_0'] ? './data/' . $row['file_copied_0'] : './data/default.jpg';
							?>
							<li>
								<a href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>&liststyle=<?=$liststyle?>">
									<div class="img"><img src="<?=$item_img?>" alt="첨부된 이미지"></div>
									<div class="cont">
										<span class="category"><?= $item_category ?>CATEGORY</span>
										<strong><?= $item_subject ?></strong>
										<p><?= $item_content ?></p>										
										<span class="regDate"><?= $item_date ?></span>
										<a class="aBtn" href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>&liststyle=<?=$liststyle?>">
											<div>
												<span>원문 바로가기</span>
												<span class="material-symbols-outlined">
													arrow_forward_ios
												</span>
											</div>
										</a>
										<!-- <span><= $item_regist_day ?></span> -->
									</div>
								</a>
							</li>
							<? $number--; } ?>
						</ul>
					</div>

					<div class="page_num">
						<!-- 이전 페이지 -->
						<?php if ($page > 1): ?>
						<a class="prev" href="list.php?page=<?=($page-1)?>&scale=<?=$scale?>&liststyle=<?=$liststyle?>">
							<span class="material-symbols-outlined">arrow_back_ios</span>
						</a>
						<?php else: ?>
						<span class="prev disabled">
							<span class="material-symbols-outlined">arrow_back_ios</span>
						</span>
						<?php endif; ?>

						<!-- 페이지 번호 -->
						<?php
							for ($i = 1; $i <= $total_page; $i++) {
								if ($page == $i) {
									echo "<span class='active'>{$i}</span>";
								} else {
									echo "<span><a href='list.php?page={$i}&scale={$scale}&liststyle={$liststyle}'>{$i}</a></span>";
								}
							}
						?>

						<!-- 다음 페이지 -->
						<?php if ($page < $total_page): ?>
						<a class="next" href="list.php?page=<?=($page+1)?>&scale=<?=$scale?>&liststyle=<?=$liststyle?>">
							<span class="material-symbols-outlined">arrow_forward_ios</span>
						</a>
						<?php else: ?>
						<span class="next disabled">
							<span class="material-symbols-outlined">arrow_forward_ios</span>
						</span>
						<?php endif; ?>
					</div>

					<!-- <div class="btn_wrap">
						<a href="list.php?table=<=$table?>&page=<=$page?>&liststyle=<=$liststyle?>">목록</a>
						
						<a href="write_form.php?table=<=$table?>&liststyle=<=$liststyle?>" class='active'>글쓰기</a>
						
					</div> -->

				</div>
			</div>
		
		</main>
		<?
			if (!$liststyle){
				$liststyle = 'list';	// 리스트 스타일
				echo "
					<script>
						$('.lst_style li').removeClass('active');
						$('.lst_style li:eq(0)').addClass('active');
					</script>
				";
			} else if($liststyle == 'box'){
				$liststyle = 'box';	// 리스트 스타일
				echo "
					<script>
						$('.lst_style li').removeClass('active');
						$('.lst_style li:eq(1)').addClass('active');
						$('.bbs_lst').addClass('box');
					</script>
				";
		
			}
		?>
		<? include "../common/sub_footer.html" ?>
		
	</div>

	<script src="https://kit.fontawesome.com/f2fbef274a.js" crossorigin="anonymous"></script>
    <script src="../common/js/jquery.easing.1.3.js"></script>
    <script src="../common/js/common.js"></script>
</body>
</html>
	