<? 
	session_start(); 
    @extract($_POST);
    @extract($_GET);
    @extract($_SESSION);

	include "../lib/dbconn.php";

	if ($mode=="modify") {
		$sql = "select * from $table where num=$num";
		$result = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($result);

		$item_category_1  = $row['category_1'];
		$item_nick        = $row['nick'];
		$item_subject     = $row['subject'];
		$item_content     = $row['content'];

		$item_file_0 = $row['file_name_0'];
		$item_file_1 = $row['file_name_1'];
		$item_file_2 = $row['file_name_2'];

		$copied_file_0 = $row['file_copied_0'];
		$copied_file_1 = $row['file_copied_1'];
		$copied_file_2 = $row['file_copied_2'];
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>NEWS & NOTICE</title>
	<link rel="stylesheet" href="../common/css/common.css">
	<link rel="stylesheet" href="./css/news.css">
	<script>
		function check_input() {
			if (document.getElementById("guest_name") && !document.board_form.guest_name.value) {
				alert("이름을 입력하세요!");
				document.board_form.guest_name.focus();
				return;
			}
			if (!document.board_form.category_1.value) {
				alert("카테고리를 입력하세요!");
				document.board_form.category_1.focus();
				return;
			}
			if (!document.board_form.subject.value) {
				alert("제목을 입력하세요!");
				document.board_form.subject.focus();
				return;
			}
			if (!document.board_form.content.value) {
				alert("내용을 입력하세요!");
				document.board_form.content.focus();
				return;
			}
			document.board_form.submit();
		}
	</script>
</head>
<body>
	<div class="wrap">
		<? include '../common/sub_header.html' ?>

		<main id="content" class="container news">
			<div class="title">
				<h3>NEWS & NOTICE</h3>
				<p>플럭시티의<br><strong>최신 소식들을 만나보세요.</strong></p>
			</div>

			<div class="content_area">
				<div class="photo_bbs_wrap">
				<? if($mode=="modify"){ ?>
					<form name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>&liststyle=<?=$liststyle?>" enctype="multipart/form-data">
				<? } else { ?>
					<form name="board_form" method="post" action="insert.php?table=<?=$table?>&liststyle=<?=$liststyle?>" enctype="multipart/form-data">
				<? } ?>
						<ul class="bbs_write_top">
							<? if (!$userid) { ?>
							<li>
								<dl>
									<dt><label for="guest_name">이름</label></dt>
									<dd><input type="text" name="guest_name" id="guest_name" placeholder="이름을 입력하세요" required></dd>
								</dl>
							</li>
							<? } ?>

							<li>
								<dl>
									<dt><label for="category_1">카테고리</label></dt>
									<dd><input type="text" name="category_1" id="category_1" placeholder="카테고리를 입력하세요" value="<?=$item_category_1?>" required></dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt><label for="subject">제목</label></dt>
									<dd><input type="text" name="subject" id="subject" value="<?=$item_subject?>" required></dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt><label for="content">내용</label></dt>
									<dd>
										<? if($userid && $mode != "modify"){ ?>
										<div class="check">
											<input type="checkbox" name="html_ok" id="html_ok" value="y">
											<label for="html_ok">HTML 쓰기</label>
										</div>
										<? } ?>
										<textarea name="content" id="content" required><?=$item_content?></textarea>
									</dd>
								</dl>
							</li>

							<? for($i=1;$i<=3;$i++){ 
								$file_var = 'item_file_'.($i-1);
								$copied_var = 'copied_file_'.($i-1);
							?>
							<li>
								<dl>
									<dt><label for="file<?=$i?>">이미지파일<?=$i?></label></dt>
									<dd>
										<input type="file" id="file<?=$i?>" name="upfile[]">
										<? if ($mode=="modify" && $$file_var) { ?>
										<div class="delete_ok">
											<?=$$file_var?> 파일이 등록되어 있습니다.
											<div class="check">
												<input type="checkbox" id="del_file<?=$i?>" name="del_file[]" value="<?=($i-1)?>">
												<label for="del_file<?=$i?>">삭제</label>
											</div>
										</div>
										<? } ?>
									</dd>
								</dl>
							</li>
							<? } ?>
						</ul>

						<div class="btn_wrap">
							<a href="list.php?table=<?=$table?>&page=<?=$page?>&liststyle=<?=$liststyle?>">목록</a>
							<a href="#" onclick="check_input()" class="active">완료</a>
						</div>
					</form>
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
</body>
</html>
