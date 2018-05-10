<?php
	/*
		一个简单的获取当前一周的课程表的示例
		请修改$xh及$pass变量为你的教务系统学号及密码
		https://github.com/TLingC/GDUF-QZAPI
	*/
	$xh = "";
	$pass = "";
	header("Content-type: text/html; charset=utf-8");
	function getData($url, $token = "")
	{
		$ch = curl_init();
		$timeout = 3;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'token:' . $token
		));
		$handles = curl_exec($ch);
		curl_close($ch);
		return json_decode($handles,true);
	}
	$data = getData("http://jwxt.gduf.edu.cn/app.do?method=authUser&xh=" . $xh . "&pwd=" . $pass);
	if($data['token'] == -1) exit($data['msg']);
	print_r($data);
	echo "<br/><br/>";
	$token = $data['token'];
	$data = getData("http://jwxt.gduf.edu.cn/app.do?method=getCurrentTime&currDate=" . date("Y-m-d"), $token);
	print_r($data);
	echo "<br/><br/>";
	$data = getData("http://jwxt.gduf.edu.cn/app.do?method=getKbcxAzc&xh=" . $xh . "&xnxqid=" . $data['xnxqh'] . "&zc=" . $data['zc'], $token);
	print_r($data);
?>