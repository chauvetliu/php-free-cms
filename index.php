<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VV拼车采集系统</title>
<link rel="stylesheet" href="style/style.css" />
<style type="text/css">
*{padding:0px;margin:0px;}
p{font-size:18px;font-weight:bold;}
body{
	background: #fff url(images/bg.jpg) repeat top left;
}
/*全屏背景遮罩层*/
.loadingPage_bg1 {
	background:none repeat scroll 0 0 #000;
	height:100%;
	left:0; /*:rgba(0,0,0,0.5);*/
	opacity:0.7;
	filter:alpha(opacity=70);
	width:100%;
	position:absolute;
	top:0px;
	z-index:110;
}
/*局部背景遮罩*/
.loadingPage_bg {
	background:none repeat scroll 0 0 #fff;
	height:100%;
	left:0; /*:rgba(0,0,0,0.5);*/
	opacity:1;
	filter:alpha(opacity=100);
	width:100%;
	z-index:110;
}

#loadingPage {
	display:block;
	font-weight:bold;
	font-size:12px;
	color:#595959;
	height:28px;
	left:50%;
	line-height:27px;
	margin-left:-74px;
	margin-top:-14px;
	padding:10px 10px 10px 50px;
	position:absolute;
	text-align:left;
	top:50%;
	width:148px;
	z-index:111;
	background:url(images/loading.gif) no-repeat scroll 12px center #FFFFFF;
	border:2px solid #86A5AD;
}
</style>
<script type="text/javascript" src="style/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="style/CommonPerson.js"></script>
<script type="text/javascript">
$(function () {
	$("#btnFullScreenShow").unbind("click").click(function () {
		CommonPerson.Base.LoadingPic.FullScreenShow();
		$.post("crawler.php",function(data){
			alert(data);
	    	if(data=='ok'){
	    		fullHide();
	    		window.location.href="index.php";
	    	}else{
	    		fullHide();
	    		window.location.href="index.php";
	    		//alert("采集中断部分未采集成功！");
	    	}
	   });
	});

	//导出sql
	$("#ExportSql").unbind("click").click(function () {
		CommonPerson.Base.LoadingPic.ExportSql();
		$.post("export-sql.php",function(data){
	    	if(data=='ok'){
	    		fullHide();
	    		alert("导出成功，请到根目录下ExportSql文件夹查看！");
	    		//window.location.href="index.php";
	    	}
	   });
	});

	//导出Excel
	$("#ExportExcel").unbind("click").click(function () {
		window.location.href="export-excel.php";
	});

	$("#btnPartShow").live("click", function () {
		var div = 'div100';
		CommonPerson.Base.LoadingPic.PartShow(div);
		/*设置setTimeout是为了演示效果 
	   在实际应用中可以在ajax请求前调用：CommonPerson.Base.LoadingPic.PartShow(div); 来局部显示“数据正在加载中...”的loading图 
	   当ajax请求成功返回数据，在把数据填充到页面之前调用：CommonPerson.Base.LoadingPic.FullScreenHide(); 来隐藏局部loading图 
	   */
		setTimeout("partHide('" + div + "')", 3000);

	});

});

function fullHide() {
	CommonPerson.Base.LoadingPic.FullScreenHide();
}
function partHide(div) {
	CommonPerson.Base.LoadingPic.PartHide(div);
}
</script>
</head>
<body>
	<center><h1>vv拼车-恰巧网采集</h1></center>

	<input type="submit" value="点击开始采集" id="btnFullScreenShow">
	<input type="submit" value="点击导出SQL" id="ExportSql">
	<input type="submit" value="点击导出Excel" id="ExportExcel">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<th class="nosort"><h3>ID</h3></th>
				<th><h3>标题</h3></th>
				<th><h3>发布时间</h3></th>
				<th><h3>起点</h3></th>
				<th><h3>起点X</h3></th>
				<th><h3>起点Y</h3></th>
				<th><h3>终点</h3></th>
				<th><h3>终点x</h3></th>
				<th><h3>终点Y</h3></th>
				<th><h3>出发时间</h3></th>
				<th><h3>类型</h3></th>
				<!-- <th><h3>座位数</h3></th> -->
				<th><h3>联系人</h3></th>
				<th><h3>手机</h3></th>
				<th><h3>备注</h3></th>
			</tr>
		</thead>
		<tbody>

		<?php
			//连接数据库
			$dblink = mysql_connect('localhost','root','root') or die('数据库连接失败！原因'.mysql_error());
			mysql_set_charset("utf8");
			mysql_select_db("acquisition",$dblink);
			$sql = "select * from qiaqiao order by ctime desc";
			$result = mysql_query($sql,$dblink);
			while($row = mysql_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>{$row['id']}</td>";
				echo "<td>{$row['title']}</td>";
				echo "<td>{$row['addtime']}</td>";
				echo "<td>{$row['startplace']}</td>";
				echo "<td>{$row['startx']}</td>";
				echo "<td>{$row['starty']}</td>";
				echo "<td>{$row['endplace']}</td>";
				echo "<td>{$row['endx']}</td>";
				echo "<td>{$row['endy']}</td>";
				echo "<td>{$row['starttime']}</td>";
				echo "<td>{$row['type']}</td>";
				/*echo "<td>{$row['seating']}</td>";*/
				echo "<td>{$row['linkman']}</td>";
				echo "<td><img src='qiaqiao/{$row['images']}'/></td>";
				echo "<td>{$row['remarks']}</td>";
				echo "</tr>";
			}

			//6.释放结果集，并关闭数据库连接
			 mysql_free_result($result);
			 mysql_close($dblink);
		?>

		</tbody>
  </table>
	<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<span>每页数量</span>
		</div>
		<div id="navigation">
			<img src="images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<img src="images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text">当前页面<span id="currentpage"></span> 和 <span id="pagelimit"></span></div>
	</div>
	
<script type="text/javascript" src="style/script.js"></script>
<script type="text/javascript">
var sorter = new TINY.table.sorter("sorter");
sorter.head = "head";
sorter.asc = "asc";
sorter.desc = "desc";
sorter.even = "evenrow";
sorter.odd = "oddrow";
sorter.evensel = "evenselected";
sorter.oddsel = "oddselected";
sorter.paginate = true;
sorter.currentid = "currentpage";
sorter.limitid = "pagelimit";
sorter.init("table",1);
</script>

</body>
</html>