<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>jQuery Ajax Demo</title>

<style type="text/css"> 
input, button, select {
    margin-bottom: 10px;
}
</style>
</head>
<body>

<h1>查詢學生</h1>
<label for="keyword">請輸入學生編號：</label>
<input type="text" id="keyword">

<button id="search">查詢</button>
<p id="searchResult"></p>

<h1>新建學生</h1>
<label for="studentNumber">請輸入學生編號：</label>
<input type="text" id="studentNumber"><br>

<label for="studentName">請輸入學生姓名：</label>
<input type="text" id="studentName"><br>

<label for="studentJunior">請輸入學生高中：</label>
<input type="text" id="studentJunior"><br>

<label for="studentWish">請輸入學生排序：</label>
<input type="text" id="studentWish"><br>

<button id="save">保存</button>
<p id="createResult"></p>


<h1>刪除學生資料</h1>
<label for="delete_keyword">請輸入學生編號：</label>
<input type="text" id="delete_keyword">

<button id="delete">刪除</button>
<p id="deleteResult"></p>

<form method="post"> 
<input type="button" value="ExcelDownload" onClick="this.form.action='ExcelDownload.php';this.form.submit();"><br>
<input type="button" value="PDFDownload" onClick="this.form.action='PDFDownload.php';this.form.submit();"> 
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/JavaScript">

$(document).ready(function() {
    $("#search").click(function() {
        $.ajax({
            type: "GET",
            url: "service.php?number= " + $("#keyword").val(),
            dataType: "json",
            success: function(data) {
                if (data.number) {
                    $("#searchResult").html(
                        '[找到學生] 學生編號：' +data.number + ', 姓名：' + data.name + ', 高中：' + data.junior + ', 排序：' + data.wish
                    );
                } else {
                    $("#searchResult").html(data.msg);
                }
            },
            error: function(jqXHR) {
                alert("發生錯誤: " + jqXHR.status);
            }
        })
    })
	
	$("#delete").click(function() {
        $.ajax({
            type: "GET",
            url: "delete.php?number= " + $("#delete_keyword").val(),
            dataType: "json",
            success: function(data) {
                if (data.number) {
                    $("#deleteResult").html(
                        '[刪除學生] 學生編號：' +data.number //+ ', 姓名：' + data.name + ', 高中：' + data.junior + ', 排序：' + data.wish
                    );
                } else {
                    $("#deleteResult").html(data.msg);
                }
            },
            error: function(jqXHR) {
                alert("發生錯誤: " + jqXHR.status);
            }
        })
    })
	/*
	$("#delete").click(function() {
        $.ajax({
            type: "GET",
            url: "delete.php?number= " + $("#delete_keyword").val(),
            dataType: "json",
            success: function(data) {
                if (data.number) {
                    $("#deleteResult").html(
                        '[刪除學生] 學生編號：' +data.number
                    );
                } else {
                    $("#deleteResult").html(data.msg);
                }
            },
            error: function(jqXHR) {
                alert("發生錯誤: " + jqXHR.status);
            }
        })
    })
	*/
    $("#save").click(function() {
        $.ajax({
            type: "POST",
            url: "service.php",
            dataType: "json",
            data: {
                name: $("#studentName").val(),
                number: $("#studentNumber").val(),
                junior: $("#studentJunior").val() ,
                wish: $("#studentWish").val()                    
            },
            success: function(data) {
                if (data.name) {
                    $("#createResult").html('學生：' + data.name + '，儲存成功！');
                } else {
                    $("#createResult").html(data.msg);
                }                   
            },
            error: function(jqXHR) {
                alert("發生錯誤: " + jqXHR.status);
            }
        })
    })
	
});
</script>

</body>
</html>