
<!--author sv2109 (sv2109@gmail.com) license for 1 product copy granted for Lixor (nikita@mt21.ru mt21.ru)-->
<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip_" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip_" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-search-mr" class="form-horizontal">
          <ul class="nav nav-tabs">            
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-relevance" data-toggle="tab"><?php echo $tab_relevance; ?></a></li>
				    <li><a href="#tab-exclude-words" data-toggle="tab"><?php echo $tab_exclude_words; ?></a></li>
            <li><a href="#tab-replace-words" data-toggle="tab"><?php echo $tab_replace_words; ?></a></li>
            <li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
          </ul>
          <div class="tab-content">
							
            <div id="tab-general" class="tab-pane active">

              <div class="form-group">
                <label class="col-sm-2 control-label" for="key"><?php echo $text_key; ?></label>                    
                <div class="col-sm-10">
                  <input type="text" size="70" name="search_mr_options[key]" value="<?php echo isset($options['key']) ? $options['key'] : '';?>" id="key" class="form-control">
                </div>
              </div>

              <table id="general" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr height="25">
                    <td><?php echo $fields_name; ?></td>
                    <td><?php echo $search; ?></td>
                    <td><?php echo $phrase; ?></td>
                    <td><?php echo $use_morphology; ?></td>
                    <td><?php echo $use_relevance; ?></td>
                    <td><?php echo $exclude_characters; ?></td>
                    <td><?php echo $search_logic; ?></td> 
                  </tr>
                </thead>

                <tbody >

                  <?php foreach($fields as $field): ?>

                  <tr>

                    <td>
                      <?php echo $field; ?>
                    </td>

                    <td>
                      <select name="search_mr_options[fields][<?php echo $field; ?>][search]" class="form-control">
                        <option value="equally"  <?php echo (isset($options['fields'][$field]['search']) && $options['fields'][$field]['search'] == 'equally')  ? 'selected="selected"' : "" ;?>><?php echo $search_equally; ?></option>
                        <option value="contains" <?php echo (isset($options['fields'][$field]['search']) && $options['fields'][$field]['search'] == 'contains') ? 'selected="selected"' : "" ;?>><?php echo $search_contains; ?></option>
                        <option value="start"    <?php echo (isset($options['fields'][$field]['search']) && $options['fields'][$field]['search'] == 'start') ? 'selected="selected"' : "" ;?>><?php echo $search_start; ?></option>
                        <option value="0" <?php echo (isset($options['fields'][$field]['search']) && $options['fields'][$field]['search'] == '0') ? 'selected="selected"' : "" ;?>><?php echo $search_dont_search; ?></option>
                      </select>
                    </td>

                    <td>
                      <select name="search_mr_options[fields][<?php echo $field; ?>][phrase]" class="form-control">
                        <option value="cut"  <?php echo (isset($options['fields'][$field]['phrase']) && $options['fields'][$field]['phrase'] == 'cut')  ? 'selected="selected"' : "" ;?>><?php echo $phrase_cut; ?></option>
                        <option value="dont_cut"  <?php echo (isset($options['fields'][$field]['phrase']) && $options['fields'][$field]['phrase'] == 'dont_cut')  ? 'selected="selected"' : "" ;?>><?php echo $phrase_dont_cut; ?></option>
                      </select>
                    </td>

                    <td>
                      <input type="checkbox" name="search_mr_options[fields][<?php echo $field; ?>][use_morphology]" value="1" <?php echo isset($options['fields'][$field]['use_morphology']) && $options['fields'][$field]['use_morphology'] ? "checked=checked" : "" ;?>  class="form-control"/>
                    </td>              

                    <td>
                      <input type="checkbox" name="search_mr_options[fields][<?php echo $field; ?>][use_relevance]" value="1" <?php echo isset($options['fields'][$field]['use_relevance']) && $options['fields'][$field]['use_relevance'] ? "checked=checked" : "" ;?>  class="form-control"/>
                    </td>              

                    <td>
                      <input type="text" name="search_mr_options[fields][<?php echo $field; ?>][exclude_characters]" value="<?php echo isset($options['fields'][$field]['exclude_characters']) ? $options['fields'][$field]['exclude_characters'] : '';?>" size="10" class="form-control"/>
                    </td>                              

                    <td>
                      <select name="search_mr_options[fields][<?php echo $field; ?>][logic]" class="form-control">
                        <option value="OR"   <?php echo (isset($options['fields'][$field]['logic']) && $options['fields'][$field]['logic'] == 'OR')   ? 'selected="selected"' : "" ;?>><?php echo $logic_or; ?></option>
                        <option value="AND"  <?php echo (isset($options['fields'][$field]['logic']) && $options['fields'][$field]['logic'] == 'AND')  ? 'selected="selected"' : "" ;?>><?php echo $logic_and; ?></option>
                      </select>
                    </td>

                  </tr>

                  <?php endforeach; ?>

                </tbody>  

              </table>

              <br />          
              <div class="form-group">
                <label class="col-sm-2 control-label" for="key"><?php echo $min_word_length; ?></label>                    
                <div class="col-sm-10">
                  <input type="text" name="search_mr_options[min_word_length]" value="<?php echo isset($options['min_word_length']) ? $options['min_word_length'] : '' ; ?>" class="form-control"/>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="key"><?php echo $cache_results; ?></label>                    
                <div class="col-sm-10">
                  <input type="checkbox" name="search_mr_options[cache_results]" value="1" <?php echo isset($options['cache_results']) && $options['cache_results'] ? "checked=checked" : "" ;?>  class="form-control"/>
                </div>
              </div>

              <?php echo $tab_general_help; ?>
            </div>

            <div id="tab-relevance" class="tab-pane">

              <table id="relevance"  class="table table-striped table-bordered table-hover">
                <thead>
                  <tr height="25">
                    <td><?php echo $fields_name; ?></td>
                    <td><?php echo $relevance_start; ?></td>
                    <td><?php echo $relevance_phrase; ?></td>
                    <td><?php echo $relevance_word; ?></td>
                  </tr>
                </thead>

                <tbody >

                  <?php foreach($fields as $field): ?>

                  <tr>

                    <td>
                      <?php echo $field; ?>
                    </td>

                    <td>
                      <input type="text" name="search_mr_options[fields][<?php echo $field; ?>][relevance][start]" value="<?php echo isset($options['fields'][$field]['relevance']['start']) ? $options['fields'][$field]['relevance']['start'] : 0; ?>" class="form-control"/>
                    </td>              

                    <td>
                      <input type="text" name="search_mr_options[fields][<?php echo $field; ?>][relevance][phrase]" value="<?php echo isset($options['fields'][$field]['relevance']['phrase']) ? $options['fields'][$field]['relevance']['phrase'] : 0; ?>" class="form-control"/>
                    </td>              

                    <td>
                      <input type="text" name="search_mr_options[fields][<?php echo $field; ?>][relevance][word]" value="<?php echo isset($options['fields'][$field]['relevance']['word']) ? $options['fields'][$field]['relevance']['word'] : 0; ?>" class="form-control"/>
                    </td>              

                  </tr>

                  <?php endforeach; ?>

                </tbody>  

              </table>
              <?php echo $tab_relevance_help; ?>
            </div>

            <div id="tab-exclude-words" class="tab-pane">
              
              <ul id="exclude-words-languages" class="nav nav-tabs">
                <?php foreach ($languages as $language) { ?>
                <li class="active"><a href="#exclude-words-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              
              <div class="tab-content">                            
                <?php foreach ($languages as $language) { ?>
                <div id="exclude-words-language<?php echo $language['language_id']; ?>" class="tab-pane active">
                
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="exclude-words<?php echo $language['language_id']; ?>">
                      <span data-toggle="tooltip" title="" data-original-title="<?php echo $tab_exclude_words_help; ?>"><?php echo $text_exclude_words; ?></span>
                    </label>                    
                    <div class="col-sm-10">
                      <textarea name="search_mr_options[exclude_words][<?php echo $language['language_id']; ?>]" rows="5" id="exclude-words<?php echo $language['language_id']; ?>" class="form-control"></textarea>
                    </div>
                  </div>
                
                </div>
                <?php } ?>
              </div>
              
            </div>

            <div id="tab-replace-words" class="tab-pane">

              <ul id="replace-words-languages" class="nav nav-tabs">
                <?php foreach ($languages as $language) { ?>
                <li class="active"><a href="#replace-words-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              
              <div class="tab-content">                            
                <?php foreach ($languages as $language) { ?>
                <div id="replace-words-language<?php echo $language['language_id']; ?>" class="tab-pane active">
                
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="replace-words<?php echo $language['language_id']; ?>">
                      <span data-toggle="tooltip" title="" data-original-title="<?php echo $tab_replace_words_help; ?>"><?php echo $text_replace_words; ?></span>
                    </label>                    
                    <div class="col-sm-10">
                      <textarea name="search_mr_options[replace_words][<?php echo $language['language_id']; ?>]" rows="5" id="replace-words<?php echo $language['language_id']; ?>" class="form-control"></textarea>
                    </div>
                  </div>
                
                </div>
                <?php } ?>
              </div>

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