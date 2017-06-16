<?php

/*
// SxGeo - для гео привязки
include("SxGeo.php");
$SxGeo = new SxGeo(); // Режим по умолчанию, файл бд SxGeo.dat
$arr_city = $SxGeo->get($_SERVER["REMOTE_ADDR"]);    // выполняет getCountry либо getCity в зависимости от типа
*/

function get_SxGeo() {
    include $_SERVER['DOCUMENT_ROOT'].'/shop/SxGeo.php';
    $SxGeo = new SxGeo(); // Режим по умолчанию, файл бд SxGeo.dat
    return $SxGeo->get($_SERVER["REMOTE_ADDR"]);    // выполняет getCountry либо getCity в зависимости от типа
}

function get_region_data() {
    return array(
        "regions" => array(
            0 => "default",
            1 => "Москва",
            2 => "Санкт-Петербург",
            3 => "Нижегородская область",
            4 => "Республика Башкортостан",
            5 => "Республика Татарстан",
            6 => "Свердловская область",
            7 => "Челябинская область",
            8 => "Воронежская область"
        ),
        "city_name" => array(
            0 => "Россия",
            1 => "Москва",
            2 => "Санкт-Петербург",
            3 => "Нижний Новгород",
            4 => "Уфа",
            5 => "Казань",
            6 => "Екатеринбург",
            7 => "Челябинск",
            8 => "Воронеж"
        ),
        "priority" => array(
            0 => 0,
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 6,
            5 => 5,
            6 => 7,
            7 => 8,
            8 => 4
        ),
        "phone" => array(
            0 => "8 800 100-71-43",
            1 => "+7 (495) 645-77-87",
            2 => "+7 (812) 649-4-777",
            3 => "+7 (831) 439-76-49",
            4 => "+7 (347) 266-11-41",
            5 => "+7 (843) 239-11-41",
            6 => "+7 (343) 361-91-81",
            7 => "+7 (351) 750-08-03",
            8 => "+7 (473) 229-42-72"
        ),
        "alternative_phone" => array(
            0 => "",
            1 => "+7 (495) 645-91-22, 8 800 100-71-43 (бесплатно по России)",
            2 => "+7 (812) 677-31-95",
            3 => "+7 (930) 071-77-08",
            4 => "+7 (905) 359-12-65",
            5 => "+7 (904) 765-36-82",
            6 => "+7 (904) 380-69-59",
            7 => "+7 (963) 475-88-80",
            8 => "+7 (920) 410-88-26"
        ),
        "clear_phone" => array(
            0 => "88001007143",
            1 => "+74956457787",
            2 => "+78126494777",
            3 => "+78314397649",
            4 => "+73472661141",
            5 => "+78432391141",
            6 => "+73433619181",
            7 => "+73517500803",
            8 => "+74732294272"
        ),
        "address" => array(
            0 => '',
            1 => 'Проспект Вернадского 39, БЦ "Вернадский"',
            2 => 'Площадь Александра Невского, д. 2, БЦ "Москва"',
            3 => 'ул. Большая Покровская, д. 71-а',
            4 => 'ул. Ленина, 26, здание "Башпотребсоюз"',
            5 => 'ул. Право-Булачная, 35/2, БЦ "Булак"',
            6 => 'ул. Малышева, 51, БЦ "Высоцкий"',
            7 => 'ул. Труда, 78, БЦ "NEWTON"',
            8 => 'ул. Кирова, 4, БЦ "Эдельвейс"'
        ),
        "yandex_map" => array(
            0 => '',
            1 => '<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=gWyYUu_M73_nLKhn9J-Lqmn3z1DnV9S9&amp;width=100%&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor"></script>',
            2 => '<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=0-SU10vQ549NrdYcnBOGU6Rt_EahifLf&amp;width=100%&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor"></script>',
            3 => '<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=ytIQ_BDblzga9KZvN7T4q3cc32InuWjc&amp;width=100%&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor"></script>',
            4 => '<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=mDkbFOIf7bnW4_3rgy8NXcYBPSLZhhqE&amp;width=100%&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor"></script>',
            5 => '<script type="text/javascript" charset="utf-8" async="" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=grJP6CaongrxzikcdupYA3Rmj4jj-4vv&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>',
            6 => '<script type="text/javascript" charset="utf-8" async="" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=n9JiPqVzjGiyPzAAyPvOjlHQXM-Zu2ry&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>',
            7 => '<script type="text/javascript" charset="utf-8" async="" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=aIPFdlRH4USgWsNMxb5gyiaTUSgEoukV&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>',
            8 => '<script type="text/javascript" charset="utf-8" async="" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=lVDd24LNoslSKXio3uIqKRDVqofebJWx&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>'
        ),
        "email" => array(
            0 => "info",
            1 => "info",
            2 => "spb",
            3 => "nn",
            4 => "ufa",
            5 => "kz",
            6 => "ekb",
            7 => "chl",
            8 => "vrn"
        ),
        "slide_img" => array(
            0 => "",
            1 => "msk",
            2 => "spb",
            3 => "nn",
            4 => "ufa",
            5 => "kzn",
            6 => "ekb",
            7 => "chl",
            8 => "vrn"
        )
    );
}

function get_region_phone_number() {
    $arr_region_data = get_region_data();
    $arr_cities = $arr_region_data['city_name'];
    $current_city = get_SxGeo()['city']['name_ru'];
    $phone = $arr_region_data['phone'][0];
    foreach ($arr_cities as $key => $value) {
        if ($current_city == $arr_cities[$key]) {
            $phone = $arr_region_data['phone'][$key];
            break;
        }
    }
    return $phone;
}

function get_region_clear_phone_number() {
    $arr_region_data = get_region_data();
    $arr_cities = $arr_region_data['city_name'];
    $current_city = get_SxGeo()['city']['name_ru'];
    $phone = $arr_region_data['clear_phone'][0];
    foreach ($arr_cities as $key => $value) {
        if ($current_city == $arr_cities[$key]) {
            $phone = $arr_region_data['clear_phone'][$key];
            break;
        }
    }
    return $phone;
}

function test() {
    return 'Москва';
}

function is_my_region() {
    $is_my_region = false;
    $arr_region_data = get_region_data();
    $arr_cities = $arr_region_data['city_name'];
    $SxGeo = new SxGeo();
    $current_city = $SxGeo->get($_SERVER["REMOTE_ADDR"])['city']['name_ru'];
    if ($current_city == $arr_cities[1]) {
        $is_my_region = true;
    }
    return $is_my_region;
}

function get_cur_city () {
    return get_SxGeo()['city']['name_ru'];
}

function get_key() {
    $arr_region_data = get_region_data();
    $arr_cities = $arr_region_data['city_name'];
    $SxGeo = new SxGeo();
    $current_city = $SxGeo->get($_SERVER["REMOTE_ADDR"])['city']['name_ru'];
    foreach ($arr_cities as $key => $value) {
        if ($current_city == $arr_cities[$key]) {
            return $key;
        }
    }
    return 0;
}

function get_key_iferror() {
    $arr_region_data = get_region_data();
    $arr_cities = $arr_region_data['city_name'];
    //$SxGeo = new SxGeo();
    $current_city = get_SxGeo()['city']['name_ru'];
    foreach ($arr_cities as $key => $value) {
        if ($current_city == $arr_cities[$key]) {
            return $key;
        }
    }
    return 0;
}

function get_contact_page() {
    $contact_page = '<h2 class="contact_subtitle">
    <span>Офисы ООО "МедТорг 21"</span>
    </h2>
    <br>';
    $key = get_key();
    $arr_region_data = get_region_data();
    if ($key != 0) {
        $contact_page .= get_contact_block($key, true);
    }
    for ($i = 1; $i < count($arr_region_data['priority']); $i++) {
        if ($i != $key) {
            $contact_page .= get_contact_block($i, false);
        }
    }
    return $contact_page;
}

function get_contact_block($key, $is_my_region) {
    $arr_region_data = get_region_data();
    $city_name = $arr_region_data['city_name'][$key];
    $city_address = $arr_region_data['address'][$key];
    $city_phone = $arr_region_data['phone'][$key];
    $city_alternative_phone = $arr_region_data['alternative_phone'][$key];
    $city_email = $arr_region_data['email'][$key];
    $checked = "";
    if ($is_my_region) $checked = "checked";
    $city_yandex_map = '<section class="ac-container">
  <div>
    <input id="ac-'.$key.'" name="accordion-1" type="checkbox" '.$checked.' />
    <label for="ac-'.$key.'">Показать на карте <i class="fa fa-caret-down" aria-hidden="true"></i></label>
    <article class="ac-medium">
      ' . $arr_region_data['yandex_map'][$key] . '
    </article>
  </div>
</section>';

    return '<div class="contact_block">
        <h2>' . $city_name . '</h2>
        <b class="contact_block_subtitle">Медицинская компания "МедТорг 21"</b>
        <br>
        <span class="contact_address">г. ' . $city_name . ', ' . $city_address . '</span>
        <br>
        <br>
        <span class="contact_phone">Тел: ' . $city_phone . ', ' . $city_alternative_phone . '</span>
        <br>
        <a href="mailto:' . $city_email . '@mt21.ru" class="contact_email">' . $city_email . '@mt21.ru</a>
        ' . $city_yandex_map . '
    </div>
    <br>';
}

function get_delivery_page() {
    $delivery_page = '<div class="row">
    <div class="col-md-6">
        <h3>Бесплатная доставка</h3>
        <p>';
    $key = get_key();
    $arr_region_data = get_region_data();
    $delivery_page .= get_list_cities($key, true);
    $delivery_page .= '.<br>Доставка собственной службой логистики.</p>
        <br><h3>Доставка транспортной компанией</h3>
        <p>Регионы России и СНГ.<br>Доставка транспортными компаниями:<br><b>Мэйджор Экспресс</b><br><b>DHL</b>.</p>
        <br><h3>Самовывоз</h3>
        Также можете самостоятельно забрать Ваш заказ в нашем офисе:';
    if ($key != 0) {
        $delivery_page .= get_contact_short_info($key);
    }
    for ($i = 1; $i < count($arr_region_data['priority']); $i++) {
        if ($i != $key) {
            $delivery_page .= get_contact_short_info($i);
        }
    }
    $delivery_page .= '</div>
    <div class="col-md-6"><b><b><img src="https://mt21.ru/about/img/page9-auto.jpg" class="page9-auto"></b></b></div>
</div>';
    return $delivery_page;
}

function get_list_cities($key, $need_regions) {
    $arr_region_data = get_region_data();
    $list_cities = "";
    if ($key != 0) {
        $list_cities .= '<b>'.$arr_region_data['city_name'][$key];
        if ((($key == 1) || ($key == 2)) && ($need_regions)) $list_cities .= ' и область';
        $list_cities .= ',</b> ';
    }
    $count_arr_region_data = count($arr_region_data['priority']);
    for ($i = 1; $i < $count_arr_region_data; $i++) {
        if ($i != $key) {
            $list_cities .= $arr_region_data['city_name'][$i];
            if ((($i == 1) || ($i == 2)) && ($need_regions)) $list_cities .= ' и область';
            if ($i != $count_arr_region_data - 1) $list_cities .= ', ';
        }
    }
    return $list_cities;
}

function get_contact_short_info($key) {
    $arr_region_data = get_region_data();
    $city_name = $arr_region_data['city_name'][$key];
    $city_address = $arr_region_data['address'][$key];
    $city_phone = $arr_region_data['phone'][$key];
    $city_alternative_phone = $arr_region_data['alternative_phone'][$key];
    return '
        <br><br>
        <b>' . $city_name . '</b>, ' . $city_address . '
        <br><span>Телефон</span>: ' . $city_phone . ', ' . $city_alternative_phone;
}

?>