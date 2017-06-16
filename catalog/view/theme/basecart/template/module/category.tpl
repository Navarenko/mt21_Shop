<div id="categoryList" class="list-group">
  <?php foreach ($categories as $category) { ?>
  <?php if ($category['category_id'] == $category_id  || true) { ?>
	  <?php if ($category['category_id'] != "93") { ?>
	  <a href="<?php echo $category['href']; ?>" class="list-group-item"><b><?php echo $category['name']; ?></b></a>
	  <?php } ?>
  <?php if ($category['children'] || true) { ?>
  <?php foreach ($category['children'] as $child) { ?>
  <?php if ($child['category_id'] == $child_id) { ?>
  <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp; <?php echo $child['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp; <?php echo $child['name']; ?></a>
  <?php } ?>

  <?php if($child['sister_id']){ ?>
  <?php foreach($child['sister_id'] as $sisters) { ?>
  <?php if ($sisters['category_id'] == $sisters_id) { ?>
  <a href="<?php echo $sisters['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp; <img src="//mt21.ru/shop/image/catalog/1452632917_ic_keyboard_arrow_right_48px.png"><?php echo $sisters['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $sisters['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp; <img src="//mt21.ru/shop/image/catalog/1452632917_ic_keyboard_arrow_right_48px.png"><?php echo $sisters['name']; ?></a>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  
  <?php } ?>
  <?php } ?>
  <?php } else { ?>
  <a href="<?php echo $category['href']; ?>" class="list-group-item"><?php echo $category['name']; ?></a>
  <?php } ?>
  <?php } ?>
</div>
<script>
var categoryList = document.getElementById("categoryList");
var listItems = categoryList.getElementsByTagName("a");

for (var i = 0; i < listItems.length; i++) {
  var el = listItems[i];
  var productQuantity = el.innerHTML.match(/\(([^)]+)\)/);
  var categoryName = el.innerHTML.replace(/\(\d+\)/g, "");

  if (productQuantity[1] === "0") {
    productQuantity[1] = "";
  }

  el.innerHTML = categoryName + "<span class=\"badge\">" + productQuantity[1] + "</span>";
}
</script>