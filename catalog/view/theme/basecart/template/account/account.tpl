<?php echo $header; ?>
<div class="container">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      <div class="row">
      	<div class="col-sm-4">
	      	<a href="<?php echo $edit; ?>" class="top_line_menu_link">
	      		<div class="top_line_menu"><?php echo $text_edit; ?></div>
	      	</a>
      	</div>
      	<div class="col-sm-4">
	      	<a href="<?php echo $wishlist; ?>" class="top_line_menu_link">
	      		<div class="top_line_menu"><?php echo $text_wishlist; ?></div>
	      	</a>
      	</div>
      	<div class="col-sm-4">
	      	<a href="<?php echo $order; ?>" class="top_line_menu_link">
	      		<div class="top_line_menu"><?php echo $text_order; ?></div>
	      	</a>
      	</div>
      </div>
      <br>
      <h2><?php echo $text_edit; ?></h2>
      <div class="row">
      	<div class="col-sm-9 cart_client">
      		<div class="row">
      			<div class="col-sm-12 text-right">
      				<a href="<?php echo $edit; ?>"><?php echo $text_edit_cart; ?></a>
      			</div>
      			<div class="col-sm-3 hidden-sm hidden-xs">
      				<img src="https://mt21.ru/images/avatar.png">
      			</div>
      			<div class="col-sm-3 col-xs-5 text-right">
      				<?php echo $text_full_name; ?>:<br>
      				E-mail:<br>
      				<?php echo $text_phone; ?>:<br>
      				<?php echo $text_password; ?>:
      			</div>
      			<div class="col-sm-6 col-xs-7">
      				<?php echo $user_name; ?><br>
      				<?php echo $user_email; ?><br>
      				<?php echo $user_telephone; ?><br>
      				<a href="<?php echo $password; ?>"><?php echo $text_edit_password; ?></a>
      			</div>
      		</div>
      	</div>
      </div>
	<br>
	<h2><?php echo $text_address; ?></h2>
	<p class="text_address"><a href="<?php echo $address; ?>"><?php echo $user_address; ?></a></p>
	<br>
	<h2><?php echo $text_my_newsletter; ?></h2>
	<p class="text_address"><a href="<?php echo $newsletter; ?>"><?php if ($user_newsletter) { ?><i class="fa fa-check-square-o" aria-hidden="true"></i><?php } else { ?><i class="fa fa-square-o" aria-hidden="true"></i><?php } ?></a> <?php echo $text_check_newsletter; ?></p>

<!--
      <div class="row">
        <div class="col-sm-4">
          <h2><?php echo $text_my_account; ?></h2>
          <ul class="list-group">
            <li class="list-group-item"><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
            <li class="list-group-item"><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          </ul>

		

        </div>
        <div class="col-sm-4">
          <h2><?php echo $text_my_orders; ?></h2>
          <ul class="list-group">
            <li class="list-group-item"><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <!-- <li class="list-group-item"><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li> -->
            <?php if ($reward) { ?>
            <li class="list-group-item"><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
            <?php } ?>
            <!-- <li class="list-group-item"><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li> -->
            <!-- <li class="list-group-item"><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li> -->
            <!-- <li class="list-group-item"><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li> -->
 <!--         </ul>
        </div>
        <div class="col-sm-4">
          <h2><?php echo $text_my_newsletter; ?></h2>
          <ul class="list-group">
            <li class="list-group-item"><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
          </ul>
        </div>
      </div>
-->
      <?php echo $content_bottom; ?>
    </div>
	<div class="col-sm-3" style="
		margin-bottom: 15px;
	">
		<a href="<?php echo $logout; ?>" class="list-group-item"><?php echo $text_logout; ?></a>
	</div>
    <?php echo $column_right; ?>
  </div>
</div>
<?php echo $footer; ?>