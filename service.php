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
    search($student);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    create();
}

// 透過學生編號搜尋
function search($student) {
    if (!isset($_GET['number']) || empty($_GET['number'])) {
        echo json_encode(array('msg' => '沒有輸入學生編號！'));

        return;
    }
    
	// 搜尋學生編號
	else {
		for ($i = 0, $_len = count($student); $i < $_len; $i++) {
			if ($student[$i]['number'] == $_GET['number']) {
				$search_result = $student[$i];
			}
		}
	}
    // 回傳 JSON 字串
	echo isset($search_result) ? urldecode(json_encode($search_result)) : json_encode(array('msg' => '沒有該學生！'));
}

//新建學生
function create() {
	
    if (!isset($_POST['number']) || empty($_POST['number']) ||
        !isset($_POST['name']) || empty($_POST['name']) ||
        !isset($_POST['junior']) || empty($_POST['junior']) ||
        !isset($_POST['wish']) || empty($_POST['wish'])) {
        echo json_encode(array('msg' => '學生資料未填寫完全！'));

        return;
    }
	else {
		$_CreateNumber = $_POST['number'];
		$_CreateName = $_POST['name'];
		$_CreateJunior = $_POST['junior'];
		$_CreateWish = $_POST['wish'];
		$sql_insert = "INSERT INTO student_data (number, name, junior, wish) VALUES ('$_CreateNumber','$_CreateName','$_CreateJunior','$_CreateWish')";
		$result = mysql_query($sql_insert);	
	}

    // 儲存成功，返回學生姓名
    echo json_encode(array('name' => $_POST['name']));
}



