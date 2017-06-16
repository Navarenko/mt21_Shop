<?php echo $header; ?>
<div class="container">
 <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> content_category_products"><?php echo $content_top; ?>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>

	<div class="row">
        <div class="col-sm-2 block_type_sorting">
          <div class="btn-group hidden-xs">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-sm-10 text-right text_sort">
            <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
            <ul class="sortandshuffle">
                <!-- Basic sort controls consisting of asc/desc button and a select -->
                <select data-sortOrder data-sortAsc>
                    <option value="sort">
                        <?php echo $text_default; ?>
                    </option>
                    <option value="model">
                        <?php echo $text_model_asc; ?>
                    </option>
                    <option value="domIndex">
                        <?php echo $text_name_asc; ?>
                    </option>
                </select>
            </ul>
        </div>
		<!-- <div class="col-sm-2 col-md-offset-5 text-right text_sort">
			<label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
        </div>
        <div class="col-sm-3 text-right">
          <select id="input-sort" class="form-control" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div> -->
    </div>
        <?php foreach ($filter_controls as $id_filter_controls => $array_filter_controls) {
            if($category_id == $id_filter_controls) { ?>
                <div class="row filter_controls">
                    <ul class="simplefilter">
                        <label class="control-label" for="input-limit"><?php echo $text_filter; ?></label>
                        <li class="active" data-filter="all"><?php echo $text_filter_all; ?></li>
                        <?php foreach ($array_filter_controls as $data_filter => $value_data_filter) { ?>
                            <li data-filter="<?php echo $data_filter; ?>">Ø <?php echo $value_data_filter; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php break;
            }
        } ?>

      <?php if ($thumb || $description) { ?>
      <hr>
		<?php } ?>
		<h2><?php echo $heading_title; ?></h2>
      <?php if ($categories) { ?>
      <h3><?php echo $text_refine; ?></h3>
      <?php if (count($categories) <= 4) { ?>
      <div class="row">
		<?php foreach ($categories as $category) { ?>


        <div class="col-sm-4">
            <!-- <a href="<?php echo $category['href']; ?>" class="list-group-item"><?php echo $category['name']; ?></a> -->
            <a href="<?php echo $category['href']; ?>">
                <div class="product-thumb table_in_category">
                    <div class="image">
                            <img src="https://mt21.ru/shop/image/<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive">
                    </div>
                    <div>
                        <div class="caption">
                            <h4><?php echo $category['name']; ?></h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>

		<?php } ?>
      </div>
      <?php } else { ?>
		<div class="row">
		<?php foreach ($categories as $category) { ?>

        <div class="col-sm-4">
            <a href="<?php echo $category['href']; ?>">
                <div class="product-thumb table_in_category">
                    <div class="image">
                        <img src="https://mt21.ru/shop/image/<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive">
                    </div>
                    <div>
                        <div class="caption">
                            <h4><?php echo $category['name']; ?></h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>

		<?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php if ($products) { ?>


      <br />
      <div class="row filtr-container">
        <?php foreach ($products as $product) {
          if ($product['model'] == 24860) $product['data_category'] = "2, 3";  //Исключение для одновременно 2-х платформ ?>
        <div class="product-layout product-list col-xs-12" data-category="<?php echo $product['data_category']; ?>" data-sort="<?php echo $product['data_sort']; ?>" data-model="<?php echo $product['model']; ?>">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
				<p><?php echo $text_model; ?> <?php echo $product['model']; ?></p>
				<?php if ($product['price']) { ?>

				<?php
					$class_special_price = '';
					if ($groupid > 2) {
						$class_special_price = 'catalog_special_price_block';
						include_once 'myscript.php';
						$text_cur_special_prise = getCurSale($groupid);
						$multiplier = 1 - ($text_cur_special_prise / 100);
				}?>
                <p class="price <?php echo $class_special_price; ?>">
                  <?php if (!$product['special']) { ?>

                <?php if (isset($currency_plus_show_base_price_cat) and $currency_plus_show_base_price_cat > 0 and isset($product['base_price']) and !empty($product['base_price'])) { ?>
					<?php if ($groupid > 2) { ?>
							<nobr><?php echo round($product['int_base_price'] * $multiplier, 2); ?>€</nobr>
					<?php } else { ?>
							<nobr><?php echo $product['base_price']; ?></nobr>
					<?php } ?>
				<?php } ?>
				<?php if ($groupid > 2) {
					echo ' = <span class="bold_text">' . $product['price'] . '</span> <sup class="catalog_text_special_prise">-' . $text_cur_special_prise . '%</sup>';
				} else {
					echo ' = <span class="bold_text">' . $product['price'] . '</span>';
				}?>

                  <?php } else { ?>
                  <p class="text-danger"><strong>

                <?php echo $product['special']; ?>

                <?php if (isset($currency_plus_show_base_price_cat) and $currency_plus_show_base_price_cat > 0 and isset($product['base_special']) and !empty($product['base_special'])) { ?>
                    <nobr>(<?php echo $product['base_special']; ?>)</nobr>
                <?php } ?>


                <?php if (isset($currency_plus_show_base_price_cat) and $currency_plus_show_base_price_cat > 0 and isset($product['base_special']) and !empty($product['base_special'])) { ?>
                    <nobr>(<?php echo $product['base_special']; ?>)</nobr>
                <?php } ?>
            </strong></p>
                  <?php } ?>
                </p>
                <?php } ?>

                <!-- <p><?php echo $product['description']; ?></p> -->
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>

              </div>
			<div class="category_block_btn-group">
              <div class="btn-group">
                <button type="button" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-bookmark"></i></button>
                <!-- <button type="button" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-bar-chart"></i></button> -->
              </div>
					<?php $minimum = 1; ?>
				<input type="text" name="quantity" value="<?php echo $minimum; ?>" size="1" class="item-<?php echo $product['product_id']; ?> input-quantity" />
				<span class="input-quantity_item"><?php echo $entry_qty_pcs; ?></span>
				<button type="button" class="btn btn-default" onclick="addQtyToCart('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
				<script type="text/javascript">
					function addQtyToCart(product_id) {
					  var qty = $('.item-' + product_id).val();
					  if ((parseFloat(qty) != parseInt(qty)) || isNaN(qty)) {
						qty = 1;
					  }
					  cart.add(product_id, qty);
					}
				</script>
			</div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><!-- <?php echo $results; ?> <br> --><br>
		<? echo $cur_cours . ' ' . date("d.m.y") . ': <span>1 EUR = ' . round(file_get_contents("https://mt21.ru/export-price/sek_cours.txt"), 2) . ' RUR</span>'; ?></div>
        <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="//mt21.ru/shop/catalog/view/theme/basecart/js/jquery.filterizr.js"></script>
<script src="//mt21.ru/shop/catalog/view/theme/basecart/js/controls.js"></script>
<!-- Kick off Filterizr -->
<script type="text/javascript">
    $(function() {
        //Initialize filterizr with default options
        $('.filtr-container').filterizr('sort', 'sort', 'asc');
    });
</script>
<?php echo $footer; ?>