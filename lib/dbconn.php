<?
    $connect=mysqli_connect( "localhost", "iyu7716", "q1w2e3r4@", "iyu7716") or  
        die( "SQL server에 연결할 수 없습니다.");

        mysqli_select_db($connect , "iyu7716");
?>