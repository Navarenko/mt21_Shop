<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
           
	    <ul class="nav nav-tabs">
	 	   <li class="active"><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
	 	   <li><a href="#tab-statistic" data-toggle="tab"><?php echo $tab_statistic; ?></a></li>
		   <li><a href="#tab-push" data-toggle="tab" id="tab_cont_edit4"><?php echo $tab_push; ?></a></li>
	    </ul>
		  
		  <div class="tab-content">
			<!-- settings -->
			<div class="tab-pane active" id="tab-settings">	
			
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
				<div class="col-sm-10">
				  <select name="mshpo_status" id="input-status" class="form-control">
					<?php if ($mshpo_status) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				  </select>
				</div>
			  </div>
			 
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_phone" value="<?php echo $phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone" class="form-control" />
				  <?php if ($error_phone) { ?>
				  <div class="text-danger"><?php echo $error_phone; ?></div>
				  <?php } ?>
				</div>
			  </div>
			 
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
				<div class="col-sm-10">
				<select name="mshpo_order_status" id="input-order-status" class="form-control">
				  <option value="*"></option>
				  <?php if ($mshpo_order_status == '0') { ?>
				  <option value="0" selected="selected"><?php echo $text_missing; ?></option>
				  <?php } else { ?>
				  <option value="0"><?php echo $text_missing; ?></option>
				  <?php } ?>
				  <?php foreach ($order_statuses as $order_status) { ?>
				  <?php if ($order_status['order_status_id'] == $mshpo_order_status) { ?>
				  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				  <?php } else { ?>
				  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				  <?php } ?>
				  <?php } ?>
				</select>
				</div>
			</div>		  

			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-min_price"><?php echo $entry_min_price; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_min_price" value="<?php echo $min_price; ?>" placeholder="<?php echo $entry_min_price; ?>" id="input-min_price" class="form-control" />
				  <?php if ($error_min_price) { ?>
				  <div class="text-danger"><?php echo $error_min_price; ?></div>
				  <?php } ?>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-banner_time"><?php echo $entry_banner_time; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_banner_time" value="<?php echo $banner_time; ?>" placeholder="<?php echo $entry_banner_time; ?>" id="input-banner_time" class="form-control" />
				  <?php if ($error_banner_time) { ?>
				  <div class="text-danger"><?php echo $error_banner_time; ?></div>
				  <?php } ?>
				</div>
			  </div>

			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-banner-iphone"><?php echo $entry_banner_iphone; ?></label>
				<div class="col-sm-10">
				  <select name="mshpo_banner_id_iphone" id="input-banner-iphone" class="form-control">
					<option value=""><?php echo $empty_option; ?></option>
					<?php foreach ($banners as $banner) { ?>
					<?php if ($banner['banner_id'] == $banner_id_iphone) { ?>
					<option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-banner-ipad"><?php echo $entry_banner_ipad; ?></label>
				<div class="col-sm-10">
				  <select name="mshpo_banner_id_ipad" id="input-banner-ipad" class="form-control">
					<option value=""><?php echo $empty_option; ?></option>
					<?php foreach ($banners as $banner) { ?>
					<?php if ($banner['banner_id'] == $banner_id_ipad) { ?>
					<option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-url_uppstore"><?php echo $entry_url_uppstore; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_url_uppstore" value="<?php echo $url_uppstore; ?>" placeholder="<?php echo $entry_url_uppstore_help; ?>" id="input-url_uppstore" class="form-control" />
				  <?php if ($error_url_uppstore) { ?>
					<div class="text-danger"><?php echo $error_url_uppstore; ?></div>
				  <?php } ?>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-url_googleplay"><?php echo $entry_url_googleplay; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_url_googleplay" value="<?php echo $url_googleplay; ?>" placeholder="<?php echo $entry_url_googleplay_help; ?>" id="input-url_googleplay" class="form-control" />
				  <?php if ($error_url_googleplay) { ?>
					<div class="text-danger"><?php echo $error_url_googleplay; ?></div>
				  <?php } ?>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-url_appid"><?php echo $entry_url_appid; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_url_appid" value="<?php echo $url_appid; ?>" id="input-url_appid" class="form-control" />
				  <?php if ($error_url_appid) { ?>
					<div class="text-danger"><?php echo $error_url_appid; ?></div>
				  <?php } ?>
				</div>
			  </div>

			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-url_appargument"><?php echo $entry_url_appargument; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="mshpo_url_appargument" value="<?php echo $url_appargument; ?>" id="input-url_appargument" class="form-control" />
				  <?php if ($error_url_appargument) { ?>
					<div class="text-danger"><?php echo $error_url_appargument; ?></div>
				  <?php } ?>
				</div>
			  </div>

			  <div class="form-group">
				<label class="col-sm-2 control-label" for="entry-push-status"><?php echo $entry_push_status; ?></label>
				<div class="col-sm-10">
				  <select name="mshpo_push_status" id="entry-push-status" class="form-control">
					<option value="0" <?php if (0 == $push_status) { ?>selected<?php } ?>>Dev</option>
					<option value="1" <?php if (1 == $push_status) { ?>selected<?php } ?>>Dis</option>
				  </select>
				</div>
			  </div>			  
			  
			</div>
			
			<!-- settings -->
			<div class="tab-pane" id="tab-statistic">

				<script type='text/javascript'>
				
					var IPOLMSHP_wndSend=false;//окно отсыла пуш-информации
					var IPOLMSHP_maxMsgSize=105;//максимальный размер пуша
					var IPOLMSHP_tokens=false;//токены, которые отсылаем
					$(document).ready(function(){//подписка на события, инициализация датапикера
						$('[name="selectTerm"]').on('click',function(){
							if($('#IPOLMSHP_rb6').prop('checked'))
								$('#IPOLMSHP_day').css('visibility','');
							else
								$('#IPOLMSHP_day').css('visibility','hidden');
							if($('#IPOLMSHP_rb7').prop('checked'))
								$('#IPOLMSHP_dayReg').css('visibility','');
							else
								$('#IPOLMSHP_dayReg').css('visibility','hidden');	
							if($('#IPOLMSHP_rb8').prop('checked'))
								$('#IPOLMSHP_dayLast').css('visibility','');
							else
								$('#IPOLMSHP_dayLast').css('visibility','hidden');		
						});
						
						$('#IPOLMSHP_ISudid').on('change',function(){
							if($(this).prop('checked'))
								$('#IPOLMSHP_udid').css('display','');
							else
								$('#IPOLMSHP_udid').css('display','none');
						})
						
						$('.IPOLMSHP_4dp').datetimepicker({
							// changeMonth: true,
							// changeYear: true,
							// format: 'dd.mm.yy',
							// dayNamesMin:[<? echo $IPOLMSHP_STAT_WEEKDAYS?>],
							// monthNamesShort:[<? echo $IPOLMSHP_STAT_MONTHDAYS?>],
							// maxDate: 0,
							// showOtherMonths: true,
							// firstDay:1,
							pickTime: false,
						});

						
						// $("#IPOLMSHP_dayFrom").on("dp.change",function (e) {
						  // $("#IPOLMSHP_dayTo").data("DateTimePicker").setMaxDate(e.date);
						// });						
						
						// $('#IPOLMSHP_dayFrom').datetimepicker('option','onClose',function(selectedDate){$("#IPOLMSHP_dayTo").datetimepicker("option","minDate",selectedDate);});
						// $('#IPOLMSHP_dayTo').datetimepicker('option','onClose',function(selectedDate){$("#IPOLMSHP_dayFrom").datetimepicker("option","maxDate",selectedDate);});
						//это к странице push.php, но dr все равно один
						// $('#IPOLMSHP_pushTermsFrom').datetimepicker('option','onClose',function(selectedDate){$("#IPOLMSHP_pushTermsTo").datetimepicker("option","minDate",selectedDate);});
						// $('#IPOLMSHP_pushTermsTo').datetimepicker('option','onClose',function(selectedDate){$("#IPOLMSHP_pushTermsFrom").datetimepicker("option","maxDate",selectedDate);});
						
					});
					 
					function IPOLMSHP_callForData()//запрос статистики
					{
						// $('[onclick="IPOLMSHP_callForData();"]').css('visibility','hidden');
						var day=$('[name="selectTerm"]:checked').val();
						switch(day)
						{
							case 'spec': 
								if(!isNaN(parseInt($('#IPOLMSHP_dayFrom').val().trim())) || !isNaN(parseInt($('#IPOLMSHP_dayTo').val().trim())))
									day='spec'+$('#IPOLMSHP_dayFrom').val().trim()+"|"+$('#IPOLMSHP_dayTo').val().trim();
								else day=false;
								break;
							case 'regi':
								if(!isNaN(parseInt($('#IPOLMSHP_dayFromReg').val().trim())) || !isNaN(parseInt($('#IPOLMSHP_dayToReg').val().trim())))
									day='regi'+$('#IPOLMSHP_dayFromReg').val().trim()+"|"+$('#IPOLMSHP_dayToReg').val().trim();
								else day='regi';
								break;
							case 'last':
								if(!isNaN(parseInt($('#IPOLMSHP_dayFromLast').val().trim())) || !isNaN(parseInt($('#IPOLMSHP_dayToLast').val().trim())))
									day='last'+$('#IPOLMSHP_dayFromLast').val().trim()+"|"+$('#IPOLMSHP_dayToLast').val().trim();
								else day='last';
								break;
						}
						
						if(typeof day==='undefined')
								day=false;
							
						var uiUnic='';
						if($('#IPOLMSHP_unic').prop('checked'))
							uiUnic='&IS_UNIC=Y';
						
						var udid='';
						if($('#IPOLMSHP_ISudid').prop('checked'))
							udid='&UDID='+$('#IPOLMSHP_udid').val().trim();
						
						var detail='';
						if($('#IPOLMSHP_detail').prop('checked'))
							detail='&DETAIL=Y';
							
						var noNoToken='';
						if($('#IPOLMSHP_noNoToken').prop('checked'))
							noNoToken='&NNT=Y';
						
						// $('#placeForTable_fieldset').hide();
						
						$.ajax({
							url: '<? echo $pathToAjaxStat?>',
							type:'POST',
							data:'ACTION=getstat&DAY='+day+uiUnic+udid+detail+noNoToken,
							success:function(data){ //console.log(data);
								// $('[onclick="IPOLMSHP_callForData();"]').css('visibility','visible');
								$('#placeForTable').html(data);
								// $('#placeForTable_fieldset').show();
							},
							error: function(a,b,c)
							{
								alert(b+" "+c);
							}
						})
					}

					function IPOLMSHP_delStat()//удаление статистики
					{
						// $('[onclick="IPOLMSHP_delStat();"]').css('visibility','hidden');
						var term=$('#IPOLMSHP_dayDel').val();
						var allowDel=false;
						if(term.length>0 && confirm('<? echo $IPOLMSHP_STAT_CONFIRM_DEL_PERIOD_1?> '+term+' <? echo $IPOLMSHP_STAT_CONFIRM_DEL_PERIOD_2?>'))
							allowDel=true;
						if(term.length<=0 && confirm('<? echo $IPOLMSHP_STAT_CONFIRM_DEL_ALL?>'))
						{
							allowDel=true;
							term='all';
						}
						if(allowDel)
						{
							$.ajax({
								url:'<? echo $pathToAjaxStat?>',
								type:'POST',
								data:'ACTION=delstat&TERM='+term,
								success: function(data){
									//console.log(data);
									$('#IPOLMSHP_dayDel').val('');
									// $('[onclick="IPOLMSHP_delStat();"]').css('visibility','visible');
									alert(data);
								},
								error: function(a,b,c)
								{
									alert(b+" "+c);
								}
							});
						}
					}
					
					//выборка для пушей
					function IPOLMSHP_clickTable(which)//ставим чекбокс при клике на табличку
					{
						var offset = $(which).position().top;
						// var LEFT = $(which).offset().left;		
						var obj;
						obj = $('#hlpr_'+$(which).attr('id').substr(4));
						// LEFT -= parseInt( parseInt(obj.css('width'))/2 );
						obj.css({
							top: (offset+15)+'px',
							// left: LEFT,
							right: 0,
							display: 'block'
						});	
						return false;
					}
					
					function IPOLMSHP_onCheckBoxClick(which)//кликаем на чекбокс
					{
						var value=which.attr('value');
						var isChecked=which.prop('checked');
						$('[onchange^="IPOLMSHP_onCheckBoxClick("]').each(function(){
							if($(this).val()===value)
							{
								if(isChecked)
									$(this).prop('checked',true);
								else
									$(this).removeProp('checked');
							}
						});
					}
					function IPOLMSHP_selectAll()//выбираем все чекбоксы
					{
						var hrefSel=$('[onclick^="IPOLMSHP_selectAll("]');
						if(hrefSel.hasClass('IPOLMSHP_red'))
						{
							$('[onchange^="IPOLMSHP_onCheckBoxClick("]').attr("checked",false).removeProp('checked');
							hrefSel.removeClass('IPOLMSHP_red');
							hrefSel.attr('title','<? echo $IPOLMSHP_STAT_MARKALL?>');
						}
						else
						{
							$('[onchange^="IPOLMSHP_onCheckBoxClick("]').attr("checked","checked").prop('checked',true);
							hrefSel.addClass('IPOLMSHP_red');
							hrefSel.attr('title','<? echo $IPOLMSHP_STAT_DEMARKALL?>');
						}
					}
					function IPOLMSHP_prepDataForSend()
					{
						IPOLMSHP_tokens=[];
						var curValue=false;
						$('[onchange^="IPOLMSHP_onCheckBoxClick("]').each(function(){
							if($(this).prop('checked'))
							{
								curValue=$(this).val();
								if($.inArray(curValue, IPOLMSHP_tokens)===-1)
									IPOLMSHP_tokens.push(curValue);
							}
						});
					}
					
					function IPOLMSHP_windowShow(){//показываем окно, вносим туда количество получателей
						IPOLMSHP_tokens=[];
						if($('#IPOLMSHP_tokenPlace').val())
							IPOLMSHP_tokens.push($('#IPOLMSHP_tokenPlace').val());
						else
							IPOLMSHP_prepDataForSend();
						if(IPOLMSHP_tokens.length>0)
						{
							var strOfHtml="<? echo $IPOLMSHP_STAT_WDBESNDD_1?>"+IPOLMSHP_tokens.length+"<? echo $IPOLMSHP_STAT_WDBESNDD_2?><br><textarea class='form-control' onkeyup='IPOLMSHP_countNumbers(event)' id='IPOLMSHP_pushText' cols='50' rows='4'></textarea><div><? echo $IPOLMSHP_STAT_LEFT?> <span id='IPOLMSHP_signsPlace'>"+IPOLMSHP_maxMsgSize+"</span> <? echo $IPOLMSHP_STAT_SIGNS?></div>";
							
							$("#pushWindow div.modal-body").html(strOfHtml);
							
							$("#pushWindow_link").click();
							
							
						}
						else alert("<? echo $IPOLMSHP_STAT_ERRCHSTOK?>");
					}
					function IPOLMSHP_countNumbers(event)//считает, сколько символов надо записать
					{
						var numbers=IPOLMSHP_maxMsgSize-($('#IPOLMSHP_pushText').val().length);
						if(numbers<0)
						{
							$('#IPOLMSHP_signsPlace').parent().html("<? echo $IPOLMSHP_STAT_TOMCH?> <span id='IPOLMSHP_signsPlace'>"+Math.abs(numbers)+"</span> <? echo $IPOLMSHP_STAT_SIGNS?>");
							// $('#IPOLMSHP_sendButton').css('visibility','hidden');
						}
						else
						{
							$('#IPOLMSHP_signsPlace').parent().html("<? echo $IPOLMSHP_STAT_LEFT?> <span id='IPOLMSHP_signsPlace'>"+numbers+"</span> <? echo $IPOLMSHP_STAT_SIGNS?>");
							// $('#IPOLMSHP_sendButton').css('visibility','visible');
						}
					}
					function IPOLMSHP_initPush()
					{
						if(IPOLMSHP_tokens.length<=0){alert('<? echo $IPOLMSHP_STAT_ERRCHSTOK?>');return;}
						if($('#IPOLMSHP_pushText').val().trim().length>IPOLMSHP_maxMsgSize){alert('<? echo $IPOLMSHP_STAT_ERRMCHPUSH?>');return;}
						if($('#IPOLMSHP_pushText').val().trim().length<=0){alert('<? echo $IPOLMSHP_STAT_ERRNOPUSH?>');return;}
						
						// $('#IPOLMSHP_sendButton').css('visibility','hidden');
						IPOLMSHP_sendRequest(0);
					}
					
					function IPOLMSHP_sendRequest(start)
					{
						var sendedTokens='';
						for(var i=start; i<IPOLMSHP_tokens.length;i++)
						{
							if(i%10!==0 || i==start)
								sendedTokens+=IPOLMSHP_tokens[i]+",";
							if((i%10===0 && i!=start) || i==(IPOLMSHP_tokens.length)-1)
							{
								var curI=i;
								i=IPOLMSHP_tokens.length;
								$.ajax({
									url:'<? echo $pathToAjaxPush?>',
									data: 'ACTION=addPush&tokens='+sendedTokens+'&push='+$('#IPOLMSHP_pushText').val().trim(),
									type:'POST',
									success: function(data){ console.log(data);
										if(data.indexOf('%done%')!==-1&&curI!=(IPOLMSHP_tokens.length)-1)//следующая партия
											IPOLMSHP_sendRequest(curI++);
										else{
											var srt='';//есть оповещение
											if(data.indexOf('srt{')!==-1){
												srt=data.substr(data.indexOf('srt{')+4);
												srt=srt.substr(0,srt.indexOf('}'));
											}
											if(data.indexOf('%done%')===-1)
											{
												if(data.indexOf('%error while inputting data%')===-1)
													alert('<? echo $IPOLMSHP_STAT_PUSHFAILURE?> '+srt);
												else
													alert('<? echo $IPOLMSHP_STAT_PUSHSQLERR?> '+srt);
											}
											else
											{
												if(srt=='')
													alert('<? echo $IPOLMSHP_STAT_PUSHDONE?>');
												else
													alert('<? echo $IPOLMSHP_STAT_PUSHSNDERR?> '+srt);
											}
											// $('#IPOLMSHP_sendButton').css('visibility','visible');
											// IPOLMSHP_wndSend.Close();
											$("#pushWindow .close").click();
										}
									}
								});
							}
						}
					}
				</script>

				<style type="text/css">
				
					#placeForTable{
						padding-top:10px;
						position: relative;
					}
					#IPOLMSHP_pushText{
						margin: 5px 0;
					}
					.IPOLMSHP_red{
						color:red!important;
					}
					.tableWithUdids td{
						width:20px;
					}
					.tableWithUdids tr td:first-child{
						width:300px;
					}
					
					.b-popup {
						background-color: #FEFEFE;
						border: 1px solid #9A9B9B;
						box-shadow: 0px 0px 10px #B9B9B9;
						display: none;
						font-size: 12px;
						padding: 19px 13px 15px;
						position: absolute;
						top: 38px;
						width: 300px;
						z-index: 12;
					}
					
					.b-popup .pop-text {
						margin-bottom: 10px;
						color: #000;
						text-align: left;
						word-wrap: break-word;
						font-size: 11px;
					}

					.b-popup .close {
						cursor: pointer;
						height: 10px;
						position: absolute;
						right: 4px;
						top: 4px;
						width: 10px;
					}
					
				</style>		
								
				<fieldset>
					<legend><? echo $IPOLMSHP_STAT_TERMS?></legend> 
						<div class="form-group">
						  <label class="col-sm-2 control-label"><? echo $IPOLMSHP_STAT_TERMS_APPEAR?></label>
						  <div class="col-sm-10">
						  
							<label class="radio-inline"><input type='radio' value='day' name='selectTerm' id='IPOLMSHP_rb1'> <? echo $IPOLMSHP_STAT_TERMS_TODAY?></label><br>
							<label class="radio-inline"><input type='radio' value='week' name='selectTerm' id='IPOLMSHP_rb2'> <? echo $IPOLMSHP_STAT_TERMS_WEEK?></label><br>
							<label class="radio-inline"><input type='radio' value='month' name='selectTerm' id='IPOLMSHP_rb3'> <? echo $IPOLMSHP_STAT_TERMS_MONTH?></label><br>
							<label class="radio-inline"><input type='radio' value='year' name='selectTerm' id='IPOLMSHP_rb4'> <? echo $IPOLMSHP_STAT_TERMS_YEAR?></label><br>
							<label class="radio-inline"><input type='radio' value='' name='selectTerm' id='IPOLMSHP_rb5'> <? echo $IPOLMSHP_STAT_TERMS_WHOLE?></label><br>
							<label class="radio-inline"><input type='radio' value='spec' name='selectTerm' id='IPOLMSHP_rb6'> <? echo $IPOLMSHP_STAT_TERMS_PERIOD?></label><span id='IPOLMSHP_day' style='visibility:hidden'><? echo $IPOLMSHP_STAT_FROM?><input type='text'  id='IPOLMSHP_dayFrom' class='IPOLMSHP_4dp' size='11'><? echo $IPOLMSHP_STAT_TO?><input type='text'  id='IPOLMSHP_dayTo' class='IPOLMSHP_4dp' size='11'></span><br>
							<br><br>
							<label class="radio-inline control-label" for="IPOLMSHP_rb7"><input type='radio' value='regi' name='selectTerm' id='IPOLMSHP_rb7'> <? echo $IPOLMSHP_STAT_TERMS_REGISTER?><span data-toggle="tooltip" title="" data-original-title="<?echo $IPOLMSHP_POPUP_FIRSTVISIT?>"></span></label> <a href='#' class='PropHint' onclick='return module_popup_virt("pop-FIRSTVISIT", this);'></a><span id='IPOLMSHP_dayReg' style='visibility:hidden'><? echo $IPOLMSHP_STAT_FROM?><input type='text'  id='IPOLMSHP_dayFromReg' class='IPOLMSHP_4dp' size='11'><? echo $IPOLMSHP_STAT_TO?><input type='text'  id='IPOLMSHP_dayToReg' class='IPOLMSHP_4dp' size='11'></span><br>
							<label class="radio-inline control-label" for="IPOLMSHP_rb8"><input type='radio' value='last' name='selectTerm' id='IPOLMSHP_rb8'> <? echo $IPOLMSHP_STAT_TERMS_LAST?><span data-toggle="tooltip" title="" data-original-title="<?echo $IPOLMSHP_POPUP_LASTVISIT?>"></span></label> <a href='#' class='PropHint' onclick='return module_popup_virt("pop-LASTVISIT", this);'></a><span id='IPOLMSHP_dayLast' style='visibility:hidden'><? echo $IPOLMSHP_STAT_FROM?><input type='text'  id='IPOLMSHP_dayFromLast' class='IPOLMSHP_4dp' size='11'><? echo $IPOLMSHP_STAT_TO?><input type='text'  id='IPOLMSHP_dayToLast' class='IPOLMSHP_4dp' size='11'></span><br>

						  </div>
						</div>
				</fieldset>
				
				<fieldset>
					<legend><? echo $IPOLMSHP_STAT_SETUPS?></legend>
						<div class="form-group">
						  <label class="col-sm-2 control-label"></label>
						  <div class="col-sm-10">
							<div class="well well-sm" style="height: 150px; overflow: auto;">
								<div class="checkbox">
									<label class="control-label" for='IPOLMSHP_unic'><input type='checkbox' id='IPOLMSHP_unic'> <? echo $IPOLMSHP_STAT_SETUPS_UNIC?><span data-toggle="tooltip" title="" data-original-title="<?echo $IPOLMSHP_POPUP_UNIC?>"></span></label>					
								</div>
								<div class="checkbox">
									<label for='IPOLMSHP_ISudid'><input type='checkbox' id='IPOLMSHP_ISudid'> <? echo $IPOLMSHP_STAT_SETUPS_UDID?></label> <input type='text' size='36' id='IPOLMSHP_udid' style='display:none'>					
								</div>	 			
								<div class="checkbox">
									<label for='IPOLMSHP_detail'><input type='checkbox' id='IPOLMSHP_detail'> <? echo $IPOLMSHP_STAT_SETUPS_DETAIL?></label>				
								</div>
								<div class="checkbox">
									<label for='IPOLMSHP_noNoToken'><input type='checkbox' id='IPOLMSHP_noNoToken'> <? echo $IPOLMSHP_STAT_SETUPS_NONOTOKEN?></label>				
								</div>				
							</div>
						  </div>
						  <div class="col-sm-12">
							<button type="button" class="btn btn-default btn-md pull-right" onclick='IPOLMSHP_callForData();'><? echo $IPOLMSHP_STAT_SHOW?></button>
						  </div>
						</div>
				</fieldset>  

				<fieldset id='placeForTable_fieldset'>
					<legend><? echo $IPOLMSHP_TAB_STAT?></legend>
						<div class="form-group">
						  <label class="col-sm-2 control-label"></label>
						  <div class="table-responsive col-sm-10">				
							<div id='placeForTable'></div> 
						  </div>
						</div>
				</fieldset>  
					
				<fieldset>
					<legend><? echo $IPOLMSHP_STAT_CLEAR_STAT?></legend>	

						<div class="form-group">
						  <label class="col-sm-2 control-label"><? echo $IPOLMSHP_STAT_CLEAR_DATE?></label>
						  <div class="col-sm-10">
							<input type='text' style='width: 100px; float: left; margin-right: 20px;' id='IPOLMSHP_dayDel' class='form-control IPOLMSHP_4dp' size='11'>
							 <input type='button' class="btn btn-default btn-md" value='<? echo $IPOLMSHP_STAT_CLEAR ?>' onclick='IPOLMSHP_delStat();'>			
						  </div>
						</div>
				</fieldset>
				
				</div>
				
				<!-- pushes -->
				<div class="tab-pane" id="tab-push">		  
					
					<script type='text/javascript'>
						$(document).ready(function(){
							$("#tab_cont_edit4").on('click',IPOLMSHP_pushFilter);
						});

						function IPOLMSHP_toggleTokens(which)
						{
							$(which).siblings('div').slideToggle(function(){
								if($(this).css('display')=='none')
									which.html('<? echo $IPOLMSHP_PUSH_SHOW ?>');
								else
									which.html('<?echo $IPOLMSHP_PUSH_HIDE ?>');
							});
						}
						
						function IPOLMSHP_pushFilter()
						{
							// $("[onclick^='IPOLMSHP_pushFilter(']").css('visibility','hidden');
							$.ajax({
								url: '<?=$pathToAjaxPush?>',
								type:'POST',
								data:'ACTION=getpush&DAYFROM='+$('#IPOLMSHP_pushTermsFrom').val()+'&DAYTO='+$('#IPOLMSHP_pushTermsTo').val()+"&TOKEN="+$('#IPOLMSHP_tokenSearch').val(),
								success:function(data){
									// $("[onclick^='IPOLMSHP_pushFilter(']").css('visibility','visible');
									$('#placeForTablePushes').html(data);
								},
								error: function(a,b,c)
								{
									alert(b+" "+c);
								}
							})
						}
						
						function IPOLMSHP_clearPush()
						{
							var selected=$('.IPOLMSHP_checkPush:checked');
							if(selected.length>0)
							{
								var ids=[];
								selected.each(function(i){
									ids[i] = $(this).val();
								});
								
								ids = ids.join();
								
								if(!ids){alert('<? echo $IPOLMSHP_STAT_ERRPUSHCK ?>');return;}
								// $("[onclick^='IPOLMSHP_clearPush(']").css('visibility','hidden');
								console.log(ids);
								$.ajax({
									url: '<?=$pathToAjaxPush?>',
									data: 'ACTION=delPush&IDS='+ids,
									type: 'POST',
									success:function(data){
										// $("[onclick^='IPOLMSHP_clearPush(']").css('visibility','visible');
										if(data=='noIds')
											alert('<? echo $IPOLMSHP_STAT_ERRPUSHCK ?>');
										else
											alert(data);
										IPOLMSHP_pushFilter();
									}
								});
							}
							else
								alert('<? echo $IPOLMSHP_STAT_ERRPUSHCK ?>');
						}
						
						function IPOLMSHP_showDetals(which,date)
						{
							var obj = $('#IPOLMSHP_infoToken');
							// obj.children('.pop-text').html('/bitrix/images/ipol.korzinkaMobile/ajax.gif');
							obj.css({
								top: (parseInt($(which).position().top)+15)+'px',
								// left: $(which).offset().left-parseInt(parseInt(obj.css('width'))/2),
								// left: 0,
								right: '50px',
								display: 'block'
							});
							
							$.ajax({
								url: '<?=$pathToAjaxPush?>',
								type: 'POST',
								data: 'ACTION=getParams&TOKEN='+$(which).html()+"&DATE="+date,
								success: function(data){
									obj.children('.pop-text').html(data);
								},
							});
							
							return false;
						}
					</script>
					
					
					
					<fieldset>
						<legend><? echo $IPOLMSHP_TAB_PUSH_TITLE?></legend> 
							<div class="form-group">
							  <label class="col-sm-2 control-label"><? echo $IPOLMSHP_PUSH_FILTER?></label>
							  <div class="col-sm-10">
							  
								<? echo $IPOLMSHP_PUSH_TERMS?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $IPOLMSHP_STAT_FROM ?> <input type='text' id='IPOLMSHP_pushTermsFrom' class='IPOLMSHP_4dp form-control' style="display: inline; width: 100px;" size="9"><? echo $IPOLMSHP_STAT_TO ?><input type='text' id='IPOLMSHP_pushTermsTo' class='IPOLMSHP_4dp form-control' style="display: inline; width: 100px;" size="9">
								<br><br><? echo $IPOLMSHP_PUSH_TOKENS?> <input type='text' id='IPOLMSHP_tokenSearch' class="form-control" style="display: inline; width: 300px;" size="36">
								<input type='button' class='btn btn-default pull-right' onclick='IPOLMSHP_pushFilter()' value='<? echo $IPOLMSHP_PUSH_DOFILT ?>'>
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="col-sm-2 control-label"><? echo $IPOLMSHP_PUSH_TABLE?></label>
							  <div class="col-sm-10">
							  
								<div id='placeForTablePushes'></div>
								<div class="b-popup" style="display:none" id='IPOLMSHP_infoToken'><div class="pop-text"></div><div class="close" onclick="$(this).closest('.b-popup').hide();return false;">x</div></div>

							  </div>
							  
							</div>							

					</fieldset>					
	
				</div>		
				
				
				</div>
			</form>
		</div> 
      </div>
 
    </div>
</div>


<!-- modals -->
<!-- push modal -->
<a id="pushWindow_link" href="#pushWindow" class="btn btn-primary" data-toggle="modal" style="display: none;">push</a>
<div id="pushWindow" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title"><? echo $IPOLMSHP_STAT_WNDTITLE?></h4>
      </div>
      <div class="modal-body" >
		<!-- content -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="IPOLMSHP_sendButton" onclick="IPOLMSHP_initPush()"><? echo $IPOLMSHP_STAT_WNDSND?></button>
      </div>
    </div>
  </div>
</div>


<?php echo $footer; ?>