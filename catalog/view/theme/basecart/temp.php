<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
Start...<br>
<?php 

$to  = "<nikita@mt21.ru>" ; 

$subject = "тема письма"; 

$message ="Текст сообщения"; 
// текст сообщения, здесь вы можете вставлять таблицы, рисунки, заголовки, оформление цветом и т.п.

$filename = "price-mobium.xml";
// название файла

$filepath = "price-mobium.xml";
// месторасположение файла

//письмо с вложением состоит из нескольких частей, которые разделяются разделителем

$boundary = "--".md5(uniqid(time())); 
// генерируем разделитель

$mailheaders = "MIME-Version: 1.0;\r\n"; 
$mailheaders .="Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
// разделитель указывается в заголовке в параметре boundary 

$mailheaders .= "From: Test_mt21 <noreply@mt21.ru>\r\n"; 
//$mailheaders .= "Reply-To: nikita@mt21.ru\r\n"; 

$multipart = "--$boundary\r\n"; 
$multipart .= "Content-Type: text/html; charset=windows-1251\r\n";
$multipart .= "Content-Transfer-Encoding: base64\r\n";    
$multipart .= "\r\n";
$multipart .= chunk_split(base64_encode(iconv("utf8", "windows-1251", $message)));
// первая часть само сообщение
// Закачиваем файл 
	$fp = fopen($filepath,"r"); 
		if (!$fp) 
		{ 
			print "No file!"; 
			exit(); 
		} 
$file = fread($fp, filesize($filepath)); 
fclose($fp); 
// чтение файла

$message_part = "\r\n--$boundary\r\n"; 
$message_part .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";  
$message_part .= "Content-Transfer-Encoding: base64\r\n"; 
$message_part .= "Content-Disposition: attachment; filename=\"$filename\"\r\n"; 
$message_part .= "\r\n";
$message_part .= chunk_split(base64_encode($file));
$message_part .= "\r\n--$boundary--\r\n";
// второй частью прикрепляем файл, можно прикрепить два и более файла

$multipart .= $message_part;
mail($to,$subject,$multipart,$mailheaders);
// отправляем письмо 
//удаляем файлы через 60 сек.
if (time_nanosleep(5, 0)) {
		unlink($filepath);
}
// удаление файла











/*


$to  = "<nikita@mt21.ru>" ; 

$subject = "Заголовок письма"; 

$message = ' <p>Текст письма</p> </br> <b>1-ая строчка </b> </br><i>2-ая строчка </i> </br>';

$headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 
$headers .= "From: От кого письмо <from@example.com>\r\n"; 

mail($to, $subject, $message, $headers); 


*/















/*


	//отправляем письмо
$date = date("d-m-Y H:i:s");
//mail("design@mt21.ru", "Обновление курса на сайте - ".$date."", "Очет сгенерирован автоматически ".$date."\n\nАктуальный курс записан в файл sek_cours.txt\n— Курс составляет 1 SEK = ".$cours." RUR\n\nКурс ".round($actual_cours, 6)." записан в базу\n— Значение в базе ".$row['currency_value']."\n\nКаталог записан в файл\n— Файл price.xml"); 

$to = "nikita@mt21.ru>"; 

$subject = "Письмо с файлом"; 

$err = " | <font color=red>Ошибка 0</font> | ";

$message = ' 
<html> 
    <head> 
        <title>Письмо с файлом</title> 
    </head> 
    <body> 
	Тестовое письмо.
    </body> 
</html>'; 

$headers  = "Content-type: text/html; charset=UTF-8 \r\n"; 
$headers .= "From: Robot MT21 <noreply@mt21.ru>\r\n"; 
$headers .= "Bcc: nikita@mt21.ru\r\n"; 

 mail($to, $subject, $message, $headers);  
*/
?>
Finish!
</body>
</html>