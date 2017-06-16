<img src="image/footer_rainbow (1).png" class="footer_rainbow">
<div id="footer_container">
<div class="container">
  
			<?php if ($ya_metrika_active){ ?>
				<?php echo $yandex_metrika; ?>
				<script type="text/javascript">
					var old_addCart = cart.add;
					cart.add = function (product_id, quantity)
					{
						var params_cart = new Array();
						params_cart['name'] = 'product id = '+product_id;
						params_cart['quantity'] = quantity;
						params_cart['price'] = 0;
						old_addCart(product_id, quantity);
						metrikaReach('metrikaCart', params_cart);
					}

					$('#button-cart').on('click', function() {
						var params_cart = new Array();
						params_cart['name'] = 'product id = '+ $('#product input[name="product_id"]').val();
						params_cart['quantity'] = $('#product input[name="quantity"]').val();
						params_cart['price'] = 0;
						metrikaReach('metrikaCart', params_cart);
					});

					function metrikaReach(goal_name, params) {
					for (var i in window) {
						if (/^yaCounter\d+/.test(i)) {
							window[i].reachGoal(goal_name, params);
						}
					}
				}
				</script>
			<?php } ?>
			<footer>
			
      <div class="row">
        <?php if ($informations) { ?>
        <div class="col-sm-4">
          <!-- <h4><?php echo $text_information; ?></h4>
          <ul class="list-group">
            <?php foreach ($informations as $information) { ?>
            <li class="list-group-item"><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
            <?php } ?>
          </ul> -->
			<p><?php echo $text_download_app; ?>:</p>
			<a href="https://itunes.apple.com/ru/app/id1156645281" target="_blank"><img src="https://mt21.ru/shop/image/catalog/ios_b.png"></a>&nbsp&nbsp&nbsp
			<a href="https://play.google.com/store/apps/details?id=com.ipol.mt21" target="_blank"><img src="https://mt21.ru/shop/image/catalog/an_b.png"></a>
        </div> 

		<div class="col-sm-2">
          <h4><?php echo $text_information; ?></h4>
		  <ul class="list-group">
			  <li class="list-group-item"><a href="https://mt21.ru/shop/delivery"><?php echo $text_delivery; ?></a></li>
			  <li class="list-group-item"><a href="https://mt21.ru/shop/contacts"><?php echo $text_about_us; ?></a></li>
		  </ul>
          <!-- <ul class="list-group">
            <?php foreach ($informations as $information) { ?>
            <li class="list-group-item"><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
            <?php } ?>
          </ul> -->
        </div> 
		
        <?php } ?>
        <div class="col-sm-2">
          <h4><?php echo $text_service; ?></h4>
          <ul class="list-group">
            <li class="list-group-item"><a href="//mt21.ru/shop/contacts"><?php echo $text_contact; ?></a></li>
			  <li class="list-group-item"><a href="//mt21.ru/pdf/Complaint_form.pdf" target="_blank"><?php echo $text_complaint_form; ?><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i></a></li>
            <!-- <li class="list-group-item"><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li> -->
            <!-- <li class="list-group-item"><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li> -->
          </ul>
        </div>
        <!-- <div class="col-sm-2">
          <h4><?php echo $text_extra; ?></h4>
          <ul class="list-group">
            <li class="list-group-item"><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
          </ul>
        </div> -->
        <div class="col-sm-2">
          <h4><?php echo $text_title_account; ?></h4>
          <ul class="list-group">
            <li class="list-group-item"><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
          </ul>
        </div>
		<div class="col-sm-2">
			<form action="https://mt21.ru/shop/index.php?route=common/language/language" method="post" enctype="multipart/form-data" id="language">
				<div class="choose_lang">
					<a type="button" class="btn language-select" name="ru"><img src="https://mt21.ru/shop/image/catalog/rus.png"></a>&nbsp&nbsp&nbsp
					<a type="button" class="btn language-select" name="en"><img src="https://mt21.ru/shop/image/catalog/eng.png"></a>
					
				</div>
			  <input type="hidden" name="code" value="">
			  <input type="hidden" name="redirect" value="https://mt21.ru/shop/index.php?route=common/home">
			</form>
			
		</div>
      </div>
	<hr>
	<p id="copyright">ООО "<?php echo $text_medtorg; ?>"  © 2010-<? echo date("o"); ?> <?php echo $text_all_rights; ?><br></p>
	<div class="block_friendlinks">
		<img src="https://mt21.ru/shop/image/catalog/mt21.png">
		<img src="https://mt21.ru/shop/image/catalog/dentsply.png">
		<img src="https://mt21.ru/shop/image/catalog/astra tech.png">	
	</div>
  </footer>
</div>
</div>


<script src="https://mt21.ru/shop/catalog/view/theme/basecart/js/CreativeButtons/classie.js"></script>
<script>
	var buttons7Click = Array.prototype.slice.call( document.querySelectorAll( '#btn-click button' ) ),
			buttons9Click = Array.prototype.slice.call( document.querySelectorAll( 'button.btn-8g' ) ),
			totalButtons7Click = buttons7Click.length,
			totalButtons9Click = buttons9Click.length;

	buttons7Click.forEach( function( el, i ) { el.addEventListener( 'click', activate, false ); } );
	buttons9Click.forEach( function( el, i ) { el.addEventListener( 'click', activate, false ); } );

	function activate() {
		var self = this, activatedClass = 'btn-activated';

		if( classie.has( this, 'btn-7h' ) ) {
			// if it is the first of the two btn-7h then activatedClass = 'btn-error';
			// if it is the second then activatedClass = 'btn-success'
			activatedClass = buttons7Click.indexOf( this ) === totalButtons7Click-2 ? 'btn-error' : 'btn-success';
		}
		else if( classie.has( this, 'btn-8g' ) ) {
			// if it is the first of the two btn-8g then activatedClass = 'btn-success3d';
			// if it is the second then activatedClass = 'btn-error3d'
			activatedClass = buttons9Click.indexOf( this ) === totalButtons9Click-2 ? 'btn-success3d' : 'btn-error3d';
		}

		if( !classie.has( this, activatedClass ) ) {
			classie.add( this, activatedClass );
			setTimeout( function() { classie.remove( self, activatedClass ) }, 1000 );
		}
	}

</script>

<div id = "block_toTop">
	<div id = "toTop" > <i class="fa fa-2x fa-angle-double-up"></i> </ div >
</ div >

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = '7z3XgYlvX4';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter20012410 = new Ya.Metrika({
                    id:20012410,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/20012410" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body></html>