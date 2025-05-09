<? session_start(); ?>
<meta charset="utf-8">
<?
	@extract($_POST);
	@extract($_GET);
	@extract($_SESSION);
	// 새글삽입 $table, $liststyle, 폼입력값, 세션변수
	// 수정하기 $table, 폼입력값, 세션변수, $mode, $num, $page, $liststyle

	//폼
	// $subject = '제목'
	// $content = '내용'
	// $upfile[0] = 'a1.jpg'
	// $upfile[1] = 'a2.jpg'
	// $upfile[2] = 'a3.jpg'

	//삭제 체크 시
	// del_file[0]
	// del_file[1]
	// del_file[2]


	// if(!$userid) {
	// 	echo("
	// 		<script>
	// 			window.alert('로그인 후 이용해 주세요.')
	// 			history.go(-1)
	// 		</script>
	// 	");
	// 	exit;
	// }

	$id = $userid ?? 'guest';    // 로그인 안 한 경우 guest 처리
	$name = $username ?? '비회원';
	$nick = $usernick ?? '비회원';

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
	/*   단일 파일 업로드 
	$upfile_name	 = $_FILES["upfile"]["name"];
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
	$upfile_type     = $_FILES["upfile"]["type"];
	$upfile_size     = $_FILES["upfile"]["size"];
	$upfile_error    = $_FILES["upfile"]["error"];
	*/

	//$_FILES["upfile"]["name"][0];
	//$_FILES["upfile"]["name"][1];
	//$_FILES["upfile"]["name"][2];


	// 다중 파일 업로드
	$files = $_FILES["upfile"]; //최대3개
	//$files[0], $files[1], $files[2]
	$count = count($files["name"]); //업로드된 파일개수 3

	$upload_dir = './data/';  //업로드될 서버 저장경로

	for ($i=0; $i<$count; $i++) //0~2
	{
		$upfile_name[$i]     = $files["name"][$i];  // 실제 이미지 파일 이름 a1.jpg
		$upfile_tmp_name[$i] = $files["tmp_name"][$i];	// 임시파일이름.tmp
		$upfile_type[$i]     = $files["type"][$i];	// image/jpeg
		$upfile_size[$i]     = $files["size"][$i];	// 파일 용량
		$upfile_error[$i]    = $files["error"][$i];	// 에러유무
      
		$file = explode(".", $upfile_name[$i]); // a1.jpg
		$file_name = $file[0];  //a1
		$file_ext  = $file[1];  //jpg

		if (!$upfile_error[$i]) //에러가 발생되지 않으면
		{
			$new_file_name = date("Y_m_d_H_i_s");
                   // 2019_03_22_10_07_15
			$new_file_name = $new_file_name."_".$i;
                 // 2019_03_22_10_07_15_0
			$copied_file_name[$i] =    $new_file_name.".".$file_ext;  
               // 2019_03_22_10_07_15_0.jpg
			$uploaded_file[$i] =    $upload_dir.$copied_file_name[$i];
               // ./data/2019_03_22_10_07_15_0.jpg

			if( $upfile_size[$i]  > 500000 ) {	// 정확히 하려면 1024 x 500
				echo("
				<script>
					alert('업로드 파일 크기가 지정된 용량(500KB)을 초과합니다!\\n파일 크기를 체크해주세요!');
					history.go(-1)
				</script>
				");
				exit;
			}

			if ( ($upfile_type[$i] != "image/gif")		&&
				 ($upfile_type[$i] != "image/jpeg")		&&
				 ($upfile_type[$i] != "image/pjpeg")	&&
				 ($upfile_type[$i] != "image/png")		&&
				 ($upfile_type[$i] != "image/x-png") )
			{
				echo("
					<script>
						alert('JPG와 GIF, PNG 이미지 파일만 업로드 가능합니다!');
						history.go(-1)
					</script>
					");
				exit;
			}

			if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) )
                
            // move_uploaded_file(임시저장파일명,실제저장할 서버경로 파일명 )    => 파일 업로드
            //파일을 업로드하고 업로드 처리가 안 되었을때 메시    
			{
				echo("
					<script>
						alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
						history.go(-1)
					</script>
				");
				exit;
			}
		}
	}

	include "../lib/dbconn.php";       // dconn.php 파일을 불러옴

	if ($mode=="modify")	// 수정일때
	{
		$num_checked = count($_POST['del_file']);	// 3 (삭제 checkbox의 value 갯수)
		$position = $_POST['del_file'];
		//$position[0]=0 , $position[1]=1, $position[2]=2

		for($i=0; $i<$num_checked; $i++)                      // delete checked item
		{
			$index = $position[$i];	// 0 1 2 (삭제 checkbox의 value값)
			$del_ok[$index] = "y"; 
			// $del_ok[0]='y', $del_ok[1]='y', $del_ok[2]='y'
		}

		$sql = "select * from $table where num=$num";   // get target record
		$result = mysqli_query( $connect, $sql);
		$row = mysqli_fetch_array($result);

		for ($i=0; $i<$count; $i++)					// 3 (업데이트 된 파일 갯수)
		{

			$field_org_name = "file_name_".$i;	// file_name_0
			$field_real_name = "file_copied_".$i;	// file_copied_0

			$org_name_value = $upfile_name[$i];	// a1.jpg
			$org_real_value = $copied_file_name[$i];	// 2022_02_22_10_43_01_0.jpg

			if ($del_ok[$i] == "y")	// 삭제 체크 된 것이 있으면
			{
				$delete_field = "file_copied_".$i;	// file_copied_0
				$delete_name = $row[$delete_field];	// $row[file_copied_0] -> 2022_02_22_10_43_01_0.jpg
				
				$delete_path = "./data/".$delete_name;	// 경로
				// $delete_path = './data/2022_02_22_10_43_01_0.jpg'
				unlink($delete_path); 	// 업로드 파일 삭제

				$sql = "update $table set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value'  where num=$num";
				mysqli_query( $connect, $sql);  // $sql 에 저장된 명령 실행
			}
			else	// 첨부파일 삭제를 하지 않았을 경우
			{
				if (!$upfile_error[$i])
				{
					$sql = "update $table set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value'  where num=$num";
					mysqli_query( $connect, $sql);  // $sql 에 저장된 명령 실행					
				}
			}

		}
		
	// 	$category_1 = htmlspecialchars($category_1);
	// 	// $category_2 = htmlspecialchars($category_2);
	// 	$subject = htmlspecialchars($subject);
	// 	$content = htmlspecialchars($content);

	// 	$category_1 = str_replace("'", "&#039;", $category_1);
	// 	// $category_2 = str_replace("'", "&#039;", $category_2);
	// 	$subject = str_replace("'", "&#039;", $subject);
	// 	$content = str_replace("'", "&#039;", $content);

	// 	//category_1='$category_1', category_2='$category_2',
	// 	$sql = "update $table set subject='$subject', category_1='$category_1', content='$content' where num=$num";
	// 	mysqli_query( $connect, $sql);  // $sql 에 저장된 명령 실행
	// }
	// else //새글쓰기이면
	// {
	// 	if ($html_ok=="y")
	// 	{
	// 		$is_html = "y";
	// 	}
	// 	else
	// 	{
	// 		$is_html = "";
	// 	}
		
	// 	$category_1 = htmlspecialchars($category_1);
	// 	// $category_2 = htmlspecialchars($category_2);
	// 	$subject = htmlspecialchars($subject);
	// 	$content = htmlspecialchars($content);

	// 	$category_1 = str_replace("'", "&#039;", $category_1);
	// 	// $category_2 = str_replace("'", "&#039;", $category_2);
	// 	$subject = str_replace("'", "&#039;", $subject);
	// 	$content = str_replace("'", "&#039;", $content);



		$html_ok=$row[is_html];

		if ($html_ok=="y")
		{
			$is_html = "y";
			$category_1 = htmlspecialchars($category_1);
			// $category_2 = htmlspecialchars($category_2);
			$subject = str_replace("'", "&#039;", $subject);
			$contents = str_replace("'", "&#039;", $contents);
			//$subject = str_replace('"', "&quot;", $subject);
			//$contents = str_replace('"', "&quot;", $contents);
			$subject = str_replace("&", "&amp;", $subject);
			$contents = str_replace("&", "&amp;", $contents);
		}
		else
		{
			$is_html = "";
			$category_1 = str_replace("'", "&#039;", $category_1);
			// $category_2 = str_replace("'", "&#039;", $category_2);
			$subject = htmlspecialchars($subject);
			$contents = htmlspecialchars($contents);
			$subject = str_replace("'", "&#039;", $subject);
			$contents = str_replace("'", "&#039;", $contents);
		}
		
		$sql = "update $table set subject='$subject', category_1='$category_1', content='$content' where num=$num";
		mysqli_query( $connect, $sql);  // $sql 에 저장된 명령 실행
	}
	else {
		if ($html_ok == "y") {
			$is_html = "y";
			$category_1 = htmlspecialchars($category_1);
			$category_1 = str_replace("'", "&#039;", $category_1);
			$subject = str_replace("'", "&#039;", $subject);
			$content = str_replace("'", "&#039;", $content);
			$subject = str_replace("&", "&amp;", $subject);
			$content = str_replace("&", "&amp;", $content);
		} else {
			$is_html = "";
			$category_1 = htmlspecialchars($category_1);
			$category_1 = str_replace("'", "&#039;", $category_1);
			$subject = htmlspecialchars($subject);
			$content = htmlspecialchars($content);
			$subject = str_replace("'", "&#039;", $subject);
			$content = str_replace("'", "&#039;", $content);
		}

		$sql = "INSERT INTO $table (
			id, name, nick, subject, category_1, content, regist_day, hit, is_html,
			file_name_0, file_name_1, file_name_2,
			file_copied_0, file_copied_1, file_copied_2
		) VALUES (
			'$id', '$name', '$nick', '$subject', '$category_1', '$content', '$regist_day', 0, '$is_html',
			'$upfile_name[0]', '$upfile_name[1]', '$upfile_name[2]',
			'$copied_file_name[0]', '$copied_file_name[1]', '$copied_file_name[2]'
		)";
		mysqli_query($connect, $sql);
	}

	mysqli_close($connect);                // DB 연결 끊기

	echo "
		<script>
			location.href = 'list.php?table=$table&page=$page&liststyle=$liststyle';
		</script>
	";
?>

  
