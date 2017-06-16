
<!--author sv2109 (sv2109@gmail.com) license for 1 product copy granted for Lixor (nikita@mt21.ru mt21.ru)-->
<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
          <ul class="nav nav-tabs">            
            <li class="active"><a href="#tab-category" data-toggle="tab"><?php echo $tab_category; ?></a></li>
            <li><a href="#tab-manufacturer" data-toggle="tab"><?php echo $tab_manufacturer; ?></a></li>
            <li><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
          </ul>
          <div class="tab-content">
            
            <div id="tab-category" class="tab-pane active">
              
              <!--
              <div class="form-group">
                <label class="col-sm-2 control-label" for="key"><?php echo $text_key; ?></label>                    
                <div class="col-sm-10">
                  <input type="text" size="70" name="attribute_select_options[key]" value="<?php echo isset($options['key']) ? $options['key'] : '';?>" id="key" class="form-control">
                </div>
              </div>
              -->
              
              <table id="categories"  class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>            
                    <td class="left" width="250"></td>              
                    <?php foreach($customer_groups as $group): ?>
                      <td class="left"><?php echo $group['name']; ?></td>
                    <?php endforeach; ?>
                  </tr>
                  </thead>

                  <tbody>

                  <?php foreach($categories as $category): ?>

                    <tr>
                      <td class="left"><?php echo $category['name']; ?></td>              

                      <?php foreach($customer_groups as $group): ?>
                        <td class="left">
                          <div class="col-sm-1">
                          +/-
                          </div>
                          <div class="col-sm-7">  
                            <input type="text" name="group_price[category][<?php echo $category['category_id']; ?>][<?php echo $group['customer_group_id']; ?>]" value="<?php echo isset($categories_price[$category['category_id']][$group['customer_group_id']]) ? $categories_price[$category['category_id']][$group['customer_group_id']]['price'] : '';?>" class="price-value form-control"> 
                          </div>
                          <div class="col-sm-2">
                            <select name="group_price_type[category][<?php echo $category['category_id']; ?>][<?php echo $group['customer_group_id']; ?>]"  class="price-type form-control">
                              <option value="1" <?php echo (isset($categories_price[$category['category_id']][$group['customer_group_id']]) 
                                    && $categories_price[$category['category_id']][$group['customer_group_id']]['type'] == 1) 
                                 ? "selected='selected'" : '';?>>%</option>
                              <option value="2" <?php echo (isset($categories_price[$category['category_id']][$group['customer_group_id']]) 
                                    && $categories_price[$category['category_id']][$group['customer_group_id']]['type'] == 2) 
                                 ? "selected='selected'" : '';?>><?php echo $currency; ?></option>
                            </select>  
                          </div>
                          <div class="col-sm-2">
                            <?php if($group['customer_group_id'] == 1): //default group ?>                  
                              <a class="refresh-price btn btn-default" data-category_id="<?php echo $category['category_id']; ?>" title="<?php echo $refresh_link_title;?>"><i class="fa fa-refresh"></i></a>                  
                            <?php endif; ?>
                           </div>
                        </td>
                      <?php endforeach; ?>

                    </tr>

                  <?php endforeach; ?>

                </tbody>
              </table>        
                
            </div>
            
            <div id="tab-manufacturer" class="tab-pane">

              <table id="manufacturers" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>            
                  <td class="left" width="250"></td>              
                  <?php foreach($customer_groups as $group): ?>
                    <td class="left"><?php echo $group['name']; ?></td>
                  <?php endforeach; ?>
                </tr>
                </thead>

                <tbody>

                <?php foreach($manufacturers as $manufacturer): ?>

                  <tr>
                    <td class="left"><?php echo $manufacturer['name']; ?></td>              

                    <?php foreach($customer_groups as $group): ?>
                      <td class="left">
                        <div class="col-sm-1">
                          +/-
                        </div>
                        <div class="col-sm-9">
                          <input type="text" name="group_price[manufacturer][<?php echo $manufacturer['manufacturer_id']; ?>][<?php echo $group['customer_group_id']; ?>]" value="<?php echo isset($manufacturers_price[$manufacturer['manufacturer_id']][$group['customer_group_id']]) ? $manufacturers_price[$manufacturer['manufacturer_id']][$group['customer_group_id']]['price'] : '';?>" class="price-value form-control">
                        </div>
                        <div class="col-sm-2">
                          <select name="group_price_type[manufacturer][<?php echo $manufacturer['manufacturer_id']; ?>][<?php echo $group['customer_group_id']; ?>]"  class="price-type form-control">
                            <option value="1" <?php echo (isset($manufacturers_price[$manufacturer['manufacturer_id']][$group['customer_group_id']]) 
                                  && $manufacturers_price[$manufacturer['manufacturer_id']][$group['customer_group_id']]['type'] == 1) 
                               ? "selected='selected'" : '';?>>%</option>
                            <option value="2" <?php echo (isset($manufacturers_price[$manufacturer['manufacturer_id']][$group['customer_group_id']]) 
                                  && $manufacturers_price[$manufacturer['manufacturer_id']][$group['customer_group_id']]['type'] == 2) 
                               ? "selected='selected'" : '';?>><?php echo $currency; ?></option>
                          </select>  
                        </div>
                      </td>
                    <?php endforeach; ?>

                  </tr>

                <?php endforeach; ?>

              </tbody>
              </table>                                    
              
						</div>	
            
            <div id="tab-general" class="tab-pane">
              <table id="key" class="table table-striped table-bordered table-hover">
                  <tr>
                    <td width="250"><?php echo $text_key; ?></td>
                      <td>
                        <input type="text" size="70" name="group_price_options[key]" value="<?php echo isset($options['key']) ? $options['key'] : '';?>"  class="form-control">
                      </td>
                  </tr>
                </table>
            </div>

            <div id="tab-support" class="tab-pane">
              <?php echo $support_text; ?>
            </div>
                                                      
					</div>
        </form>
      </div>
    </div>
  </div>
	
  <div id="copyright">author sv2109 (sv2109@gmail.com) license for 1 product copy granted for Lixor (nikita@mt21.ru mt21.ru)</div>
  
</div>
<?php echo $footer; ?>

<script type="text/javascript">
$(document).ready(function(){

  $('a.refresh-price').click(function(){
    
    if (!confirm('<?php echo $refresh_link_confirm; ?>')) {
      return false;
    } 
    
    var category_id = $(this).data('category_id');
    var price_value = $('.price-value', $(this).parent().parent()).val();
    var price_type  = $('.price-type', $(this).parent().parent()).val();
    
    $.ajax({
      url: 'index.php?route=module/group_price/updateDbPrice&token=<?php echo $token; ?>&category_id=' + encodeURIComponent(category_id) + '&price_value=' + encodeURIComponent(price_value) + '&price_type=' + encodeURIComponent(price_type),
      dataType: 'json',
      success: function(json) {
        $('.alert').remove();

        if (json['error']) {
          $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        } 

        if (json['success']) {
          $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>' + json['success'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
        }	
      }
    });    
    
    return false;    
  });
});
</script> 