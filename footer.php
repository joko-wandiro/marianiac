<!-- Start Footer Section -->

<!-- Start SiteMap Footer Menu Section -->
<div class="full-block black">
<div class="container" id="footer">
	<div class="row-fluid">
		<div class="span12">
		<?php wp_nav_menu(array('menu'=>'SiteMap', 'container' => '', 
		'menu_id'=>'sitemap-footer-menu', 'menu_class'=>'nav', 'walker'=>new PHC_Marianiac_SiteMap_Footer_Nav_Menu, 
		'items_wrap' => '<div  id="%1$s" class="%2$s row-fluid">%3$s</div>')); ?>
		</div>
	</div>
</div>
</div>
<!-- End SiteMap Footer Menu Section -->

<!-- Start Copyright Section -->
<div class="full-block darker-black">
<div class="container" id="footer">
	<div class="row-fluid" id="copyright">
		<div class="span12">
		<h3>Marianiac WordPress theme, Copyright (&copy;) 2014 <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo bloginfo("name"); ?></a>. 
		Powered by <a href="http://wordpress.org/">WordPress</a>.</h3>
		</div>
	</div>
</div>
</div>
<!-- End Copyright Section -->

<!-- End Footer Section -->
<?php
wp_footer();
?>
</body>
</html>