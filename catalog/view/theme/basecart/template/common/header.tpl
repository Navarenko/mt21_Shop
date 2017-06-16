<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="no-js">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-itunes-app" content="app-id=1156645281">
<meta name="google-play-app" content="app-id=com.google.android.youtube">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="www.navarenko.ru">
<title><?php
if (substr_count($_SERVER['REQUEST_URI'], "delivery")) {
	echo $text_delivery;
} else if (substr_count($_SERVER['REQUEST_URI'], "contacts")) {
	echo $text_contacts;
} else if (substr_count($_SERVER['REQUEST_URI'], "special-offers")) {
	echo $text_offers;
} else if (substr_count($_SERVER['REQUEST_URI'], "convenient-payment")) {
	echo $text_title_block_3;
} else if (substr_count($_SERVER['REQUEST_URI'], "lifetime-warranty")) {
	echo $text_title_block_2;
} else {
	echo $title; 
}

?></title>
<base href="<?php echo $base; ?>" />

<script src="//mt21.ru/shop/catalog/view/theme/basecart/js/respond.min.js"></script> 
<!--[if IE 8]> <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> <![endif]-->
	<script src="//mt21.ru/shop/catalog/view/theme/basecart/js/jquery.filterizr.min.js"></script>

<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<link href="catalog/view/theme/basecart/css/bootstrap.min.css" rel="stylesheet">
<link href="catalog/view/theme/basecart/css/font-awesome.min.css" rel="stylesheet">
<link href="catalog/view/theme/basecart/css/datedropper.css" rel="stylesheet">


<!-- START basecart module -->

<?php
  if ($theme == "basecart_module_themedefault") {
      include "catalog/view/theme/basecart/css/bootswatch/default.tpl";
  } elseif ($theme == "basecart_module_themecerulean") {
      include "catalog/view/theme/basecart/css/bootswatch/cerulean.tpl";
  } elseif ($theme == "basecart_module_themecosmo") {
      include "catalog/view/theme/basecart/css/bootswatch/cosmo.tpl";
  } elseif ($theme == "basecart_module_themecyborg") {
      include "catalog/view/theme/basecart/css/bootswatch/cyborg.tpl";
  } elseif ($theme == "basecart_module_themedarkly") {
      include "catalog/view/theme/basecart/css/bootswatch/darkly.tpl";
  } elseif ($theme == "basecart_module_themeflatly") {
      include "catalog/view/theme/basecart/css/bootswatch/flatly.tpl";
  } elseif ($theme == "basecart_module_themejournal") {
      include "catalog/view/theme/basecart/css/bootswatch/journal.tpl";
  } elseif ($theme == "basecart_module_themelumen") {
      include "catalog/view/theme/basecart/css/bootswatch/lumen.tpl";
  } elseif ($theme == "basecart_module_themepaper") {
      include "catalog/view/theme/basecart/css/bootswatch/paper.tpl";
  } elseif ($theme == "basecart_module_themereadable") {
      include "catalog/view/theme/basecart/css/bootswatch/readable.tpl";
  } elseif ($theme == "basecart_module_themesandstone") {
      include "catalog/view/theme/basecart/css/bootswatch/sandstone.tpl";
  } elseif ($theme == "basecart_module_themesimplex") {
      include "catalog/view/theme/basecart/css/bootswatch/simplex.tpl";
  } elseif ($theme == "basecart_module_themeslate") {
      include "catalog/view/theme/basecart/css/bootswatch/slate.tpl";
  } elseif ($theme == "basecart_module_themespacelab") {
      include "catalog/view/theme/basecart/css/bootswatch/spacelab.tpl";
  } elseif ($theme == "basecart_module_themesuperhero") {
      include "catalog/view/theme/basecart/css/bootswatch/superhero.tpl";
  } elseif ($theme == "basecart_module_themeunited") {
      include "catalog/view/theme/basecart/css/bootswatch/united.tpl";
  } elseif ($theme == "basecart_module_themeyeti") {
      include "catalog/view/theme/basecart/css/bootswatch/yeti.tpl";
  }
?>

<!-- END basecart module -->

<link href="catalog/view/theme/basecart/css/main.css" rel="stylesheet">

<script src="catalog/view/theme/basecart/js/jquery.min.js"></script>
<script src="catalog/view/theme/basecart/js/bootstrap.min.js"></script>
<script src="catalog/view/theme/basecart/js/common.js"></script>

<link  href="catalog/view/theme/basecart/css/fotorama.css" rel="stylesheet"> 
<script src="catalog/view/theme/basecart/js/fotorama.js"></script>

<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>">
<?php } ?>
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>">
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

<script type="text/javascript" charset="utf-8" src="//ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js"></script>  

<script type="text/javascript" charset="utf-8" src="https://mt21.ru/shop/catalog/view/theme/basecart/js/jquery.tubular.js"></script>
<script type="text/javascript" charset="utf-8" src="https://mt21.ru/shop/catalog/view/theme/basecart/js/mission-control.js"></script>
<!-- дата доставки -->
<script type="text/javascript" src="https://mt21.ru/shop/catalog/view/theme/basecart/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://mt21.ru/shop/catalog/view/theme/basecart/js/bootstrap-datetimepicker.min.js"></script>
<link href="https://mt21.ru/shop/catalog/view/theme/basecart/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="https://mt21.ru/shop/catalog/view/theme/basecart/css/CreativeButtons/component.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://mt21.ru/shop/catalog/view/theme/basecart/css/CSS3Accordion.css" />

<script type="text/javascript">
$(function() {
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});
	$('#toTop').click(function() {
	$('body,html').animate({scrollTop:0},800);
	});
});
</script>

	<script src="catalog/view/theme/basecart/js/datedropper.js"></script>
</head>
<body class="<?php echo $class; ?>">
<!-- <?php if ($_SERVER['REQUEST_URI'] == "/shop/delivery") echo "delivery"; ?> -->
<header>
<?php if ($nav == "basecart_module_navinverse") { ?>
<?php $class = 'navbar-inverse'; ?>
<?php } else { ?>
<?php $class = 'navbar-default'; ?>
<?php } ?>
<nav class="navbar <?php echo $class; ?>">
  <div class="container">
	<div class="row">
	<div class="col-md-7">
     <div class="navbar-header">
		<p class="mob_text_cours">1 EUR = <? echo round(file_get_contents("https://mt21.ru/export-price/sek_cours.txt"), 4); ?> RUR</p>
		<p class="mob_text_phone">+7 (495) 645-77-87</p>
		  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>

	</div>

<?php if ($categories) { ?>
		<div class="collapse navbar-collapse navbar-ex1-collapse">

		<ul class="nav navbar-nav">
			<li><a href="https://mt21.ru/" target="_blank"><img src="https://mt21.ru/shop/image/catalog/in_new_window_icon_white.png" class="link_new_tab"> <?php echo $text_home; ?></a></li>
			<!-- <li><a href="https://mt21.ru/shop"><?php echo $text_price; ?></a></li> -->
			<li class="dropdown">
			  <a href="https://mt21.ru/shop" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $text_price; ?><span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li><a href="https://mt21.ru/shop/surgical_components/"><?php echo $text_products1; ?></a></li>
				<li><a href="https://mt21.ru/shop/index.php?route=product/category&path=63"><?php echo $text_products2; ?></a></li>
				<li><a href="https://mt21.ru/shop/index.php?route=product/category&path=64"><?php echo $text_products3; ?></a></li>
			  </ul>
			</li>
			<li><a href="https://mt21.ru/shop/special-offers"><?php echo $text_offers; ?></a></li>
			<li><a href="https://mt21.ru/shop/delivery"><?php echo $text_delivery; ?></a></li>
			<li><a href="https://mt21.ru/shop/contacts"><?php echo $text_contacts; ?></a></li>
			</ul>

		</div>

	</div>



		<div class="col-md-2">
			<div class="eur_block <? echo file_get_contents('https://mt21.ru/export-price/color_eur.txt'); ?>">
				<p class="numb_course">
					<? echo $normal_course; ?>
				</p>
				<p class="name_course">
					EUR (<?php echo $text_course; ?>)<br>
					<? echo date("d.m.y"); ?>
				</p>
			</div>
		</div>

		<div class="col-md-3">
			<div class="navbar-right"><span class="work_time">9:30</span> - <span class="work_time">18:00</span><span class="work_phonenumber"> <? print($phone); ?></span></div>
		</div>

    <?php } ?>
	</div>
   </div>
  </div>
</nav>
<div id="second_top_menu" class="container">
	<div class="row">
		<div class="col-md-2">
			<a class="navbar-brand" href="https://mt21.ru/shop/"><img src="https://mt21.ru/shop/image/catalog/logo_mini.png" title="Мой Магазин" alt="Мой Магазин" class="img-responsive"></a>
		</div>
		<div class="col-md-7">
			<nav class="block_search"><?php echo $search; ?></nav>
			<div class="btn_basket">
				<?php echo $cart; ?>
			</div>
			<div class="btn_registration">
				<a href="https://mt21.ru/shop/index.php?route=account/login" class="btn btn-default btn-enter"><i class="fa fa-user"></i><span class="name_text_login">  <?php echo $text_login; ?></span></a>
			</div>
		</div>
		<div class="col-md-3 btn_registration">
			<a href="https://mt21.ru/shop/index.php?route=account/login" class="btn btn-default btn-enter"><i class="fa fa-user"></i>  <?php echo $text_login; ?></a>
		</div>
	</div>
</div>

</header>