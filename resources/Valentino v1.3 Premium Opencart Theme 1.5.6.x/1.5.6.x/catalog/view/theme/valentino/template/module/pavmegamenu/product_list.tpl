<?php if( isset($widget_name)){
?>
<h3><span class="menu-title"><?php echo $widget_name;?></span></h3>
<?php
}?>
<div class="widget-product-list">
  <div class="widget-inner">
    
      <?php foreach ($products as $product) { ?>
      <div class="product-block w-product">
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
   
        <div class="rating"><img src="catalog/view/theme/valentino/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
     
        <div class="cart"><input type="button" value="<?php echo $this->language->get('button_cart'); ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      </div>
      <?php } ?>
  </div>
</div>