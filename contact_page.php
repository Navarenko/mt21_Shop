<h2 class="contact_subtitle">
    <span>Офисы ООО "МедТорг 21"</span>
</h2>
<br>
<? for ($i=1; $i <= 8; $i++) { ?>
    <div class="contact_block">
        <h2><?php echo $city_name; ?></h2>
        <b class="contact_block_subtitle">Медицинская компания "МедТорг 21"</b>
        <br>
        <span class="contact_address">г. <?php echo $city_name; ?>, <?php echo $city_address; ?></span>
        <br>
        <br>
        <span class="contact_phone">Тел: <?php echo $city_phone; ?>, <?php echo $city_alternative_phone; ?></span>
        <br>
        <a href="mailto:<?php echo $city_email; ?>@mt21.ru" class="contact_email"><?php echo $city_email; ?>@mt21.ru</a>
        <?php echo $city_yandex_map; ?>
    </div>
    <br>
<? } ?>
