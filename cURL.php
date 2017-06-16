<?php
  if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'https://mt21.ru/shop/index.php?route=mshpo/ajax/push');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "ACTION='addPush'&tokens='APA91bH7SDsDjJyleWv6IH-ZVQyKXwGrWbY9rJXcbi0FOL22ZfaIPCj0ruBhVQJkWS7zLKxtYN7VLo8crwBwVmnIb-iFq9YamwWfN8oKoYQfo-lWuzJa2fs'&push='test push'");
    $out = curl_exec($curl);
    echo $out;
    curl_close($curl);
  }
?>