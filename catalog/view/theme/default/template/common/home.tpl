<?php echo $header; ?>
</div>

<div id="top_slider">
    <div class="fotorama container-fluid" data-width="100%" data-height="640px" data-fit="cover" data-arrows="true" data-swipe="false" data-nav="false" data-autoplay="10000" data-loop="true">

        <div data-img="//mt21.ru/shop/image/catalog/kamin.png">
            <div class="blackcat">
            </div>
            <div class = "col-sm-12 centering">
                <br><h1><? echo $text_title_slide_3; ?></h1>
                <h3><? echo $text_ad_slide_3; ?></h3>
                <a href="https://mt21.ru/shop/Surgical_components" class="btn btn-default"><? echo $text_cat_1; ?></a>
                <a href="https://mt21.ru/shop/Orthopedics" class="btn btn-default" style="margin-left: 10px;margin-right: 10px;"><? echo $text_cat_2; ?></a>
                <a href="https://mt21.ru/shop/Instruments" class="btn btn-default"><? echo $text_cat_3; ?></a>
                <!-- <?php if (!$logged) { ?><a href="https://mt21.ru/shop/index.php?route=account/register" class="btn btn-default"><?php echo $text_create_account; ?></a><?php } ?> -->
            </div>
            <div class="tv2"><div class="screen mute" id="tv2"></div>
            </div>
        </div>

        <!-- <div data-img="//mt21.ru/shop/image/catalog/spring.png">
            <div class="blackcat">
            </div>
            <div class = "col-sm-12 centering">
                <h1><? echo $text_title_slide_1; ?></h1>
                <h3><? echo $text_ad_slide_1; ?></h3>
                <a href="https://mt21.ru/shop/Orthopedics/Cement-retained_restorations" class="btn btn-default"><?php echo $text_special_offers; ?></a>
            </div>
            <div class="tv"><div class="screen mute" id="tv"></div>
            </div>
        </div> -->

        <div data-img="//mt21.ru/shop/image/catalog/slider_app.png">
            <div class="col-sm-6 mockup_phone"></div>
            <div class = "col-sm-6 text_download_app">
                <img class="text1_download_app" src="//mt21.ru/shop/image/catalog/text1.png"><br>
                <a href="https://play.google.com/store/apps/details?id=com.ipol.mt21" target="_blank" class="img_downl_app_android"><?php echo '<img src="/templates/theme1390/images/Android.png">'; ?></a>
                <a href="https://itunes.apple.com/ru/app/id1156645281" target="_blank" class="img_downl_app_ios"><?php echo '<img src="/templates/theme1390/images/iOS.png">'; ?></a>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?><?php echo $content_bottom; ?>
            <!-- <nav><?php echo $search; ?></nav> -->
            <div class="home_blocktext">
                <span><? echo $text_title_h1; ?></span>
                <h1>ASTRA TECH Implant System</h1>

                <!--<p>В нашем интернет-магазине Вы можете приобрести зубные импланты, а также все, что связанно с дентальной имплантологией. Специально для Вас мы разработали систему с технически удобной и понятной схемой заказа, которая сама предлагает покупателю наиболее подходящие сочетания хирургических и ортопедических компонентов.</p>
                <p>При регистрации и покупке продукции через интернет-магазин Вы получаете возможность сделать первый <b>заказ со скидкой 5%</b>.</p>
                br><br><font color="red"><b>Уважаемые клиенты, в связи с переходом на Евро в нашем интернет-магазине производится обновление каталога, возможны ошибки, заказ товара желательно производить у менеджеров компании по телефону.</b></font-->
                <br>
                <? echo $text_main; ?>

                <!-- <div>
                    <div class="jshop_categ width33">
                      <div class="category">
                           <div class="image">
                                <a href="/magazin/hirurgiya"><img class="jshop_img" src="https://mt21.ru/components/com_jshopping/files/img_categories/img30151_1331884671_2.jpg" alt="Хирургия" title="Хирургия"></a>
                           </div>
                           <div>
                               <h2 class="category_title"><a class="product_link" href="/magazin/hirurgiya">Хирургия</a></h2>
                               <p class="category_short_description"></p>
                           </div>
                       </div>
                    </div>
                    <div class="jshop_categ width33">
                      <div class="category">
                           <div class="image">
                                <a href="/magazin/ortopedia"><img class="jshop_img" src="https://mt21.ru/components/com_jshopping/files/img_categories/cat2.jpg" alt="Ортопедия" title="Ортопедия"></a>
                           </div>
                           <div>
                               <h2 class="category_title"><a class="product_link" href="/magazin/ortopedia">Ортопедия</a></h2>
                               <p class="category_short_description"></p>
                           </div>
                       </div>
                    </div>
                    <div class="jshop_categ width33">
                      <div class="category">
                           <div class="image">
                                <a href="/magazin/instrumentary"><img class="jshop_img" src="https://mt21.ru/components/com_jshopping/files/img_categories/cat3.jpg" alt="Инструментарий" title="Инструментарий"></a>
                           </div>
                           <div>
                               <h2 class="category_title"><a class="product_link" href="/magazin/instrumentary">Инструментарий</a></h2>
                               <p class="category_short_description"></p>
                           </div>
                       </div>
                    </div>
                </div> -->

                <!-- <img src="//mt21.ru/shop/image/catalog/imp1 (1).png" style="width: 100%;">
                <img src="https://mt21.ru/app_img/app_bg.png" style="width: 100%;">-->

                <br><br><br>
                <div class="row advantages">
                    <a href="https://mt21.ru/shop/delivery">
                        <div class="col-md-4 text_ad_block">
                            <img src="https://mt21.ru/shop/image/catalog/1455653663_transport-delivery.png" class="">
                            <h4><? echo $text_title_block_1; ?></h4>
                            <div class="adv-text"><? echo $text_ad_block_1; ?></div>
                        </div>
                    </a>
                    <a href="https://mt21.ru/shop/lifetime-warranty">
                        <div class="col-md-4 text_ad_block">
                            <img src="https://mt21.ru/shop/image/catalog/1455653776_checked-checklist-notepad.png">
                            <h4><? echo $text_title_block_2; ?></h4>
                            <div class="adv-text"><? echo $text_ad_block_2; ?></div>
                        </div>
                    </a>
                    <a href="https://mt21.ru/shop/convenient-payment">
                        <div class="col-md-4 text_ad_block">
                            <img src="https://mt21.ru/shop/image/catalog/1455653780_credit-card.png">
                            <h4><? echo $text_title_block_3; ?></h4>
                            <div class="adv-text"><? echo $text_ad_block_3; ?></div>
                        </div>
                    </a>
                </div>
                <br><br><br><br>


                <!-- <div style="height: 400px; margin: 0 auto;">
                    <div style="float: left; width: 400px; text-align: left; font-size: 12pt; line-height: 1.5; margin-left: 76px;">
                        <font style="font-size: 20pt; font-weight: bold;">Новое мобильное приложение!</font><br>
                        <font style="font-size: 24pt; color: #cc0000; font-weight: bold;">«МедТорг21» v2.0</font><br><br>
                        Представляем Вам новое мобильное приложение «МедТорг21» v2.0 для телефонов и планшетов. Удобный интерфейс и актуальный каталог нашего интернет магазина, позволят Вам совершать покупки с максимальным комфортом.
                        <br><br>
                    </div>
                    <div style="float: left;">
                        <img src="/app_img/app_bg.png">
                    </div>
                </div> -->


                <!--<div class="row">
                         <div class="col-sm-4">
                            <div class="card">
                              <div class="card-block">
                                <h4 class="card-title">Хирургия</h4>
                                <h6 class="card-subtitle text-muted">Описание Хирургия</h6>
                              </div>
                              <img src="https://mt21.ru/components/com_jshopping/files/img_categories/img30151_1331884671_2.jpg" alt="Card image">
                              <div class="card-block">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="card-link">Подробнее</a>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                              <div class="card-block">
                                <h4 class="card-title">Ортопедия</h4>
                                <h6 class="card-subtitle text-muted">Описание Ортопедия</h6>
                              </div>
                              <img src="https://mt21.ru/components/com_jshopping/files/img_categories/cat2.jpg" alt="Card image">
                              <div class="card-block">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="card-link">Подробнее</a>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                              <div class="card-block">
                                <h4 class="card-title">Инструментарий</h4>
                                <h6 class="card-subtitle text-muted">Описание Инструментарий</h6>
                              </div>
                              <img src="https://mt21.ru/components/com_jshopping/files/img_categories/cat3.jpg" alt="Card image">
                              <div class="card-block">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="card-link">Card link</a>
                              </div>
                            </div>
                        </div>
                </div> -->

            </div>
        </div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>