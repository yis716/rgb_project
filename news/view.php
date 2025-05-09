<? 
	session_start(); 
    @extract($_POST);
    @extract($_GET);
    @extract($_SESSION);
	// $table, $num, $page, 세션변수

	include "../lib/dbconn.php";

	$sql = "select * from $table where num=$num";
	$result = mysqli_query( $connect, $sql);

    $row = mysqli_fetch_array($result);      
      // 하나의 레코드 가져오기
	
	$item_num     = $row[num];
	$item_id      = $row[id];
	$item_name    = $row[name];
  	$item_nick    = $row[nick];
	$item_hit     = $row[hit];

	$image_name[0]   = $row[file_name_0];//실제파일명 a1.jpg
	$image_name[1]   = $row[file_name_1];
	$image_name[2]   = $row[file_name_2];


	$image_copied[0] = $row[file_copied_0];	// 2022_02_22_10_43_01_0.jpg
	$image_copied[1] = $row[file_copied_1];
	$image_copied[2] = $row[file_copied_2];

    $item_date    = $row[regist_day];
	
	$item_category_1 = str_replace(" ", "&nbsp;", $row[category_1]);
	// $item_category_2 = str_replace(" ", "&nbsp;", $row[category_2]);
	$item_subject = str_replace(" ", "&nbsp;", $row[subject]);

	$item_content = $row[content];
	$is_html      = $row[is_html];

	if ($is_html!="y")
	{
		$item_content = str_replace(" ", "&nbsp;", $item_content);
		$item_content = str_replace("\n", "<br>", $item_content);
	}
	
	// for ($i=0; $i<3; $i++)
	// {
	// 	if ($image_copied[$i]) //업로드한 파일이 존재하면 0 1 2
	// 	{
	// 		$imageinfo = GetImageSize("./data/".$image_copied[$i]);
    //         //GetImageSize(서버에 업로드된 파일 경로 파일명)
    //           // => 파일의 너비와 높이값, 종류
	// 		$image_width[$i] = $imageinfo[0];  //파일너비
	// 		$image_height[$i] = $imageinfo[1]; //파일높이
	// 		$image_type[$i]  = $imageinfo[2];  //파일종류

    //     if ($image_width[$i] > 1200)
	// 			$image_width[$i] = 1200;
	// 	}
	// 	else
	// 	{
	// 		$image_width[$i] = "";
	// 		$image_height[$i] = "";
	// 		$image_type[$i]  = "";
	// 	}
	// }

	// $new_hit = $item_hit + 1;

	// $sql = "update $table set hit=$new_hit where num=$num";   // 글 조회수 증가시킴

	// 이전글
	$sql_prev = "SELECT num FROM $table WHERE num > $num ORDER BY num ASC LIMIT 1";
	$result_prev = mysqli_query($connect, $sql_prev);
	$row_prev = mysqli_fetch_array($result_prev);
	$prev_num = $row_prev['num'] ?? null;

	// 다음글
	$sql_next = "SELECT num FROM $table WHERE num < $num ORDER BY num DESC LIMIT 1";
	$result_next = mysqli_query($connect, $sql_next);
	$row_next = mysqli_fetch_array($result_next);
	$next_num = $row_next['num'] ?? null;

	mysqli_query( $connect, $sql);
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
	<!-- <script>
		function del(href) 
		{
			if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
					document.location.href = href;
			}
		}
	</script> -->
</head>

<body>
<?php echo "<p>현재글: $num / 이전글: $prev_num / 다음글: $next_num</p>"; ?>
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

					<ul class="bbs_view_ttl">
						<li>
							<i><?=$item_category_1?></i>
							<strong><?= $item_subject ?></strong>
						</li>
						<li>
							<span class="category"><?= $item_category ?>CATEGORY</span>
							<span><?= $item_date ?></span>
						</li>
						<li class="box"></li>
					</ul>

					
					<div class="bbs_view_cont">
						<!-- <= $item_content ?> -->
						<?
							for ($i=0; $i<3; $i++)  //업로드된 이미지를 출력한다
							{
								if ($image_copied[$i])	// 첨부된 파일이 있으면
								{
									$img_name = $image_copied[$i];
									$img_name = "./data/".$img_name;
									
									echo "<div class='img'><img src='$img_name' alt='첨부이미지'></div>";
								} 
								// else{
									// echo "<div class='imgdefault'><img src='$item_img = $row['file_copied_0'] ? './data/' . $row['file_copied_0'] : './data/default.jpg'; ' alt='기본이미지'></div>";
									
								// }
							}
						?>
					</div>
							
					<div class="view_btn_wrap">
						<?php if ($prev_num): ?>
						<a href="view.php?table=<?=$table?>&num=<?=$prev_num?>&page=<?=$page?>&liststyle=<?=$liststyle?>" class="view_prev">
							<span class="material-symbols-outlined">arrow_back_ios</span>
							<span>이전글</span>
						</a>
						<?php else: ?>
						<a href="#" class="view_prev disabled"><span>이전글 없음</span></a>
						<?php endif; ?>

						<a class="view_list" href="list.php?table=<?=$table?>&page=<?=$page?>&liststyle=<?=$liststyle?>">목록</a>

						<?php if ($next_num): ?>
						<a href="view.php?table=<?=$table?>&num=<?=$next_num?>&page=<?=$page?>&liststyle=<?=$liststyle?>" class="view_next">
							<span>다음글</span>
							<span class="material-symbols-outlined">arrow_forward_ios</span>
						</a>
						<?php else: ?>
						<a href="#" class="view_next disabled"><span>다음글 없음</span></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
		</main>

		<? include "../common/sub_footer.html" ?>
	</div>
	
	<script src="https://kit.fontawesome.com/f2fbef274a.js" crossorigin="anonymous"></script>
    <script src="../common/js/jquery.easing.1.3.js"></script>
    <script src="../common/js/common.js"></script>
	<script src="../common/js/jquery-1.12.4.min.js"></script>
    <script src="../common/js/jquery-migrate-1.4.1.min.js"></script>
	<script src="https://kit.fontawesome.com/cdd59ed73b.js" crossorigin="anonymous"></script>
</body>
</html>