<?php
$xmlstr = file_get_contents ("https://mt21.ru/shop/xml/Ostatki.xml");
$import_items = new SimpleXMLElement($xmlstr);
$flag = false;
$stock_status = 0;
foreach ($import_items->Sklad->item as $item) {
	if ($item->ref != "") {
		if (substr_count($item->ref, $model) || substr_count($model, $item->ref)) {
			$stock_status = $item->Ostatok;
			$flag = true;
			break;
		}
	}
}
if ($stock_status <= 2) {
	$xmlstr = file_get_contents ("https://mt21.ru/shop/xml/OstatkiSLS.xml");
	$import_items = new SimpleXMLElement($xmlstr);
	foreach ($import_items->Sklad->item as $item) {
		if ($item->ref != "") {
			if (substr_count($item->ref, $model) || substr_count($model, $item->ref)) {
				$stock_status += $item->Ostatok;
				$flag = true;
				break;
			}
		}
	}
}
?>