<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="buttons"><div class="pull-right">
                    <a onclick="update_currency('currency');" data-toggle="tooltip" title="<?php echo $button_updatecurrency;?>" class="btn btn-info"><i class="fa fa-usd"></i></a>
                    <a onclick="update_currency('product');" data-toggle="tooltip" title="<?php echo $button_updateproduct;?>" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                    <button type="submit" form="form-currency" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency" class="form-horizontal">
                        <input type="hidden" name="<?php echo $name; ?>_license" size="50" value="<?php echo ${$name.'_license'}; ?>" >

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
                            <li><a href="#tab-currency" data-toggle="tab"><?php echo $tab_currency; ?></a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-general">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo $entry_charcode; ?></label>
                                    <div class="col-sm-10">
                                        <select name="<?php echo $name; ?>_charcode" class="form-control">
                                            <option value="RUB" <?php if (!isset(${$name.'_charcode'}) or (isset(${$name.'_charcode'}) and ${$name.'_charcode'} == 'RUB')) { echo 'selected';}?>><?php echo $text_rub; ?></option>
                                            <option value="UAH" <?php if (isset(${$name.'_charcode'}) and ${$name.'_charcode'} == 'UAH') { echo 'selected';}?> ><?php echo $text_uah; ?></option>
                                            <option value="BYR" <?php if (isset(${$name.'_charcode'}) and ${$name.'_charcode'} == 'BYR') { echo 'selected';}?> ><?php echo $text_byr; ?></option>
                                            <option value="KZT" <?php if (isset(${$name.'_charcode'}) and ${$name.'_charcode'} == 'KZT') { echo 'selected';}?> ><?php echo $text_kzt; ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo $entry_round; ?></label>
                                    <div class="col-sm-10">
                                        <select name="<?php echo $name; ?>_round" class="form-control">
                                            <option value=""><?php echo $text_noround; ?></option>
                                            <option value="digitx9" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digitx9') { echo 'selected';}?> ><?php echo $text_digitx9; ?></option>
                                            <option value="digit99" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit99') { echo 'selected';}?> ><?php echo $text_digit99; ?></option>
                                            <option value="digit01" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit01') { echo 'selected';}?> ><?php echo $text_digit01; ?></option>
                                            <option value="digit001" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit001') { echo 'selected';}?> ><?php echo $text_digit001; ?></option>
                                            <option value="digit1" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit1') { echo 'selected';}?> ><?php echo $text_digit1; ?></option>
                                            <option value="digit5" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit5') { echo 'selected';}?> ><?php echo $text_digit5; ?></option>
                                            <option value="digit9" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit9') { echo 'selected';}?> ><?php echo $text_digit9; ?></option>
                                            <option value="digit10" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit10') { echo 'selected';}?> ><?php echo $text_digit10; ?></option>
                                            <option value="digit50" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit50') { echo 'selected';}?> ><?php echo $text_digit50; ?></option>
                                            <option value="digit100" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit100') { echo 'selected';}?> ><?php echo $text_digit100; ?></option>
                                            <option value="digit1000" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit1000') { echo 'selected';}?> ><?php echo $text_digit1000; ?></option>
                                            <option value="digit10000" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit10000') { echo 'selected';}?> ><?php echo $text_digit10000; ?></option>
                                            <option value="digit100000" <?php if (isset(${$name.'_round'}) and ${$name.'_round'} == 'digit100000') { echo 'selected';}?> ><?php echo $text_digit100000; ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_currency; ?>"><?php echo $entry_currency; ?></span></label>
                                    <div class="col-sm-10">
                                        <select name="config_currency" class="form-control">
                                            <?php foreach ($currencies as $currency) { ?>
                                            <?php if ($currency['code'] == $config_currency) { ?>
                                            <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_currency_auto; ?>"><?php echo $entry_currency_auto; ?></span></label>
                                    <div class="col-sm-10">
                                        <?php if ($config_currency_auto) { ?>
                                        <input type="radio" name="config_currency_auto" value="1" checked="checked" />
                                        <?php echo $text_yes; ?>
                                        <input type="radio" name="config_currency_auto" value="0" />
                                        <?php echo $text_no; ?>
                                        <?php } else { ?>
                                        <input type="radio" name="config_currency_auto" value="1" />
                                        <?php echo $text_yes; ?>
                                        <input type="radio" name="config_currency_auto" value="0" checked="checked" />
                                        <?php echo $text_no; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab-design">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <td colspan="2"><h3><?php echo $entry_show_base_price; ?></h3></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td width="300"><?php echo $entry_show_base_price_product; ?></td>
                                            <td class="text-left"><input type="checkbox" name="<?php echo $name; ?>_show_base_price" value="1" <?php if (isset(${$name.'_show_base_price'}) and ${$name.'_show_base_price'}) { ?>checked="checked"<?php } ?> /></td>
                                        </tr>
                                        <tr>
                                            <td width="300"><?php echo $entry_show_base_price_cat; ?></td>
                                            <td class="text-left"><input type="checkbox" name="<?php echo $name; ?>_show_base_price_cat" value="1" <?php if (isset(${$name.'_show_base_price_cat'}) and ${$name.'_show_base_price_cat'}) { ?>checked="checked"<?php } ?> /></td>
                                        </tr>
                                        <tr>
                                            <td width="300"><?php echo $entry_show_base_price_search; ?></td>
                                            <td class="text-left"><input type="checkbox" name="<?php echo $name; ?>_show_base_price_search" value="1" <?php if (isset(${$name.'_show_base_price_search'}) and ${$name.'_show_base_price_search'}) { ?>checked="checked"<?php } ?> /></td>
                                        </tr>
                                        <tr>
                                            <td width="300"><?php echo $entry_show_base_price_brand; ?></td>
                                            <td class="text-left"><input type="checkbox" name="<?php echo $name; ?>_show_base_price_brand" value="1" <?php if (isset(${$name.'_show_base_price_brand'}) and ${$name.'_show_base_price_brand'}) { ?>checked="checked"<?php } ?> /></td>
                                        </tr>
                                        <tr>
                                            <td width="300"><?php echo $entry_show_base_price_special; ?></td>
                                            <td class="text-left"><input type="checkbox" name="<?php echo $name; ?>_show_base_price_special" value="1" <?php if (isset(${$name.'_show_base_price_special'}) and ${$name.'_show_base_price_special'}) { ?>checked="checked"<?php } ?> /></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab-currency">

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-left"><?php echo $column_title; ?></td>
                                        <td class="text-left"><?php echo $column_code; ?></td>
                                        <td class="text-right"><?php echo $column_value; ?></td>
                                        <td class="text-right"><?php echo $column_nominal; ?></td>
                                        <td class="text-right"><?php echo $column_value_official; ?></td>
                                        <td class="text-right"><?php echo $column_total_products; ?></td>
                                        <td class="text-left"><?php echo $column_date_modified; ?></td>
                                        <td class="text-right"><?php echo $column_action; ?></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($currencies) { ?>
                                        <?php foreach ($currencies as $currency) { ?>
                                            <tr>
                                                <td class="text-left" width="30%"><?php echo $currency['title']; ?></td>
                                                <td class="text-left" width="30%"><?php echo $currency['code']; ?></td>
                                                <td class="text-right" width="10%"><?php echo $currency['value']; ?></td>
                                                <td class="text-right" width="10%"><?php echo $currency['nominal']; ?></td>
                                                <td class="text-right" width="10%"><?php echo $currency['value_official']; ?></td>
                                                <td class="text-right" width="10%"><?php echo $currency['total_products']; ?></td>
                                                <td class="text-left"><?php echo $currency['date_modified']; ?></td>
                                                <td class="text-right">
                                                    <?php foreach ($currency['action'] as $action) { ?>
                                                    <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                                    <?php } ?>

                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7"></td>
                                            <td class="text-left"><button type="button" onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--

    function update_currency(type) {
        $.ajax({
            url:'<?php echo HTTP_CATALOG; ?>index.php?route=wgi/currency_plus&type='+type,
            dataType: 'json',
            complete: function() {
                window.location.href = 'index.php?route=module/currency_plus&token=<?php echo $token; ?>';
            },

            error: function(xhr, ajaxOptions, thrownError) {
                /* alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText); */
            }
        });
    }
    //--></script>

<?php echo $footer; ?>