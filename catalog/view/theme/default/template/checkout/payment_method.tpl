<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<br>
<?php $temp = ""; ?>
<?php $res = ""; ?>
<?php foreach ($payment_methods as $payment_method) { 
	if ($payment_method['code'] == 'yamodule') { ?>
		<?php $temp = '<div class="radio">
  <label>
	<input type="radio" name="payment_method" value="'.$payment_method['code'].'">
	'.$payment_method['title'].' '.$payment_method['logo_div'].'
</label>
</div>'; continue; ?>
	<?php } ?>
<div class="radio">
  <label>
    <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
    <?php } ?>
    <?php echo $payment_method['title'] . ' ' . $payment_method['logo_div']; ?>
    <?php if ($payment_method['terms']) { ?>
    (<?php echo $payment_method['terms']; ?>)
    <?php } ?>
  </label>
</div>
<?php if ($payment_method['code'] == 'bank_transfer') { ?>
  <?php echo '<div class="radio">
  <label>
    <input type="radio" name="payment_method" value="mymodule">
    <strong>Картой</strong>/ Visa, MasterCard, Мир - <span class="payment_method_where">сейчас онлайн</span> <div class="payment_method_logos"><img src="//mt21.ru/shop/image/visa.png"> <img src="//mt21.ru/shop/image/mastercard.png"> <img src="//mt21.ru/shop/image/mir.png"></div>
  </label>
</div>'; ?>
<?php } ?>
<?php } ?>



<?php echo $temp; ?>

<?php } ?>
<br>
<p><?php echo $text_comments; ?></p>
<p>
  <textarea name="comment" rows="4" class="form-control" placeholder="Текст комментария"><?php echo $comment; ?></textarea>
</p>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right"><?php echo $text_agree; ?>
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" />
    <?php } ?>
    &nbsp;
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<?php } ?>