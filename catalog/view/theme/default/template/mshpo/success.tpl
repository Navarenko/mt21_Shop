<script>
	function connectWebViewJavascriptBridge(callback) {
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
</script>

<style>
	.result {
		text-align: center;
		max-width: 500px;
		margin: 0 auto;
		line-height: 1;
	}
	.result h1{
		margin: 0;
		font-size: 30px;
	}	
	.result p{
		font-size: 18px;
	}	
	.ok {
		background: url('/shop/catalog/view/theme/default/image/ok.png') center center no-repeat;
		width: 100%;
		height: 200px;
		margin-top: 30px;
	}
	/*input[type=button], .button {
	
		background-color: #E90514;
		width: 200px;
		height: 60px;
		color: #ffffff;
		border-radius: 8px;
		-webkit-border-radius: 8px;
		moz-border-radius: 8px;
		cursor: pointer;
		border: 0;
		margin-top: 50px;
		font-size: 18px;
		font-weight: bold;
	}*/
	
	input[type=button], .button {
	
		background-color: #E90514;
		background: -moz-linear-gradient(top, #E90514, #E90514);
		background: -webkit-linear-gradient(top, #E90514, #E90514);
		background: -o-linear-gradient(top, #E90514, #E90514);
		background: -ms-linear-gradient(top, #E90514, #E90514);
		background: linear-gradient(top, #E90514, #E90514);
		width: 200px;
		height: 60px;
		color: #ffffff;
		border-radius: 8px;
		-webkit-border-radius: 8px;
		moz-border-radius: 8px;
		cursor: pointer;
		border: 0;
		margin-top: 50px;
		font-size: 18px;
		font-weight: bold;
	}
</style>

<div>
  <div class="result">
	<div class="ok"></div>
	<h1><?php echo $heading_title; ?></h1>
	<p><?php echo $contact_message; ?></p>
	<input type='button' class="button" value='<?=$button_main?>' onclick='MSHP_orderContinue()'>
  </div>
</div>