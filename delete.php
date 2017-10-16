<?php
// 設置資料類型 json
header('Content-Type: application/json; charset=UTF-8');

$dbhost = 'localhost';   
$dbuser = 'root';   
$dbpass = 'qcg444ntn';   
$dbname = 'insert_delete_test';

// 連結資料庫
$conn = mysql_connect($dbhost, $dbuser, $dbpass );
mysql_select_db($dbname);  
 
// query資料庫的資料 
$sql_query = "select * from student_data";
mysql_query("SET NAMES 'utf8'");
$result = mysql_query($sql_query); 

$_cnt = 0;

// 將資料庫的資料全部存在student這個陣列
while($row = mysql_fetch_array($result)) {
	$student[$_cnt]['number'] = $row['number'];
	$student[$_cnt]['name'] = urlencode($row['name']);
	$student[$_cnt]['junior'] = urlencode($row['junior']);
	$student[$_cnt]['wish'] = $row['wish'];
	$_cnt++;
}

// 判斷如果是 GET 請求，則進行搜尋；如果是 POST 請求，則進行新建
if ($_SERVER['REQUEST_METHOD'] == "GET") {
		delete_data($student);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
}

//新建學生
function delete_data($student) {
	if (!isset($_GET['number']) || empty($_GET['number'])) {
        echo json_encode(array('msg' => '沒有輸入學生編號！'));

        return;
    }
    
	// 搜尋學生編號
	else {
		for ($i = 0, $_len = count($student); $i < $_len; $i++) {
			if ($student[$i]['number'] == $_GET['number']) {
				
				$_DeleteResult = $_GET['number'];
				$sql_delete = "DELETE FROM student_data WHERE number = $_DeleteResult";
				$result = mysql_query($sql_delete);	
				
			}
		}
	}
    // 回傳 JSON 字串
	echo isset($_DeleteResult) ? json_encode(array('number' => $_DeleteResult)) : json_encode(array('msg' => '沒有該學生！'));
}


