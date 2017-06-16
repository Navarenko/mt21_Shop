<?php
define("LESHA", "APA91bH7SDsDjJyleWv6IH-ZVQyKXwGrWbY9rJXcbi0FOL22ZfaIPCj0ruBhVQJkWS7zLKxtYN7VLo8crwBwVmnIb-iFq9YamwWfN8oKoYQfo-lWuzJa2fs");
define("MARY", "APA91bFtjpAX5602W2h16j9fdRSDl8id21goFmgyf24SVnmmdmhCY-UsVlH4iAmH3kPojen1Vk1kndMdst2ULdG_iusKhW_5NZTHWd3hulXHFOtdTgnOzQQ");
define("IVAN", "APA91bEKNdRBLzFWMLrNK3z0AJaJ74qULd4P12hzY6Q6to6OQrNEDB8zWuITU0mC01o0H02u_sLBJkpq66qkGStZ84La_liUZCM6BtgsNueuhqC6H4cB81E");
define("NIKITA", "c71b574e 6d2026c3 7e63ed67 99a16707 70867532 388c2af8 1c5dbd9e 0706d929");

$tocens = LESHA.','.MARY; /* получатели через запятую. Например $tocens = LESHA.','.MARY; */
$push_text = "Текущее время 11:10"; /* Текст пуша */

header("Location: https://mt21.ru/shop/index.php?route=mshpo/ajax/push&ACTION=addPush&tokens=".$tocens."&push=".$push_text); 
exit;
?>