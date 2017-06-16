<?php 

if ($_GET) {
    $res = '<pre>';
    $res .= htmlspecialchars(print_r($_GET, true));
    $res .= '</pre>';
	$to = $_GET['Email'];
	$sum = $_GET['Amount'];
}

if ($to) {
	$subject = "МедТорг 21 - Успешное получение оплаты"; 

	$message = ' 
	<html> 
		<head> 
			<title>Обновление курса на сайте</title> 
		</head> 
		<body> 
			<p>По Вашему заказу поступила оплата на сумму ' . $sum . ' руб. Заказ передан в курьерскую службу.</p>
<p>
__________________<br>
<a href="https://mt21.ru/shop/" title="МедТорг 21" target="_blank"><img alt="МедТорг 21" style="margin-bottom:20px;border:none;" src="https://mt21.ru/shop/image/catalog/logo.png"></a><br>
С уважением,<br>
коллектив компании "МедТорг 21"</p>
		</body> 
	</html>'; 

	$headers  = "Content-type: text/html; charset=UTF-8 \r\n"; 
	$headers .= "From: <shop@mt21.ru>\r\n"; 
	$headers .= "Bcc: ".$to."\r\n"; 

	/*mail($to, $subject, $message, $headers);*/
}

$arr = array('code' => 0);
echo json_encode($arr);

?>