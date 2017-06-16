<?php echo $header; ?>

<script>
/*	function connectWebViewJavascriptBridge(callback) {
		if (window.WebViewJavascriptBridge)
			callback(WebViewJavascriptBridge)
		else
			document.addEventListener('WebViewJavascriptBridgeReady', function() {
				callback(WebViewJavascriptBridge)
			}, false);
	}
	connectWebViewJavascriptBridge(function(bridge){
		bridge.send('<?=json_encode(array('ACTION'=>"ORDER_SUCCESS"))?>');
	});
	function MSHP_orderContinue(){
		connectWebViewJavascriptBridge(function(bridge){
			bridge.send('<?=json_encode(array('ACTION'=>"CLOSE"))?>');
		});
	}

	<?if($_SESSION['MSHP_SENDER']){?>
		connectWebViewJavascriptBridge(function(bridge){
			bridge.send('<?=json_encode(array('ACTION'=>"NEW_LOGIN",'LOGIN'=>$_SESSION['MSHP_SENDER']['LOGIN'],'PASSWORD'=>$_SESSION['MSHP_SENDER']['PASSWORD']))?>');
		});
	<?
		unset($_SESSION['MSHP_SENDER']);
	}?>
*/	
</script>

<div class="container">
  <div class="row">
    <div id="content" class="<?php echo $class; ?>">
      <h1><?php echo $heading_title; ?></h1>
      <div style='text-align:center;'>
		<input type='button' class="button" value='<?=$button_continue?>'>
	  </div>
   </div>
</div>