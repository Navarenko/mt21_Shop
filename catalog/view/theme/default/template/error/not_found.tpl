<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		<div class="row error_content">
			<div class="col-sm-3 only_error_404">
				<img src="https://mt21.ru/shop/image/sign-error.png">
			</div>
			<div class="col-sm-9">
			  <h1><?php echo $heading_title; ?></h1>
			  <h2 class="only_error_404"><?php if (isset($heading_subtitle)) echo $heading_subtitle; ?></h2>
			  <p><?php  if (isset($heading_subtitle)) echo $text_error; ?></p>
			  <div class="buttons only_error_404">
				<?php { ?>
				<div><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php if (isset($button_home)) echo $button_home; else echo "Home"; ?></a></div>
				<?php } ?>
			  </div>
			</div>
		</div>	
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>