<?php
/*
Template Name: Sitemap Page
*/
?>
<?php get_header(); ?>

<!-- Start Content Section -->
<div class="container" id="content">
	<div class="row-fluid" id="sitemap-page">
		<!-- Start Content - Articles -->
		<div class="span12">
	
		<?php if( have_posts() ){ ?>
			<div class="wrapper-posts" id="articles">
			<?php 
			global $wp_query;
			$ct= 1;
			$number_of_posts= $wp_query->post_count;
			while( have_posts() ){
				the_post();
				$post= get_post();
			?>
				<div class="post">
				<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php wp_nav_menu(array('theme_location' => 'Primary Navigation', 'menu'=>'Sitemap Page', 'container' => '', 
				'menu_id'=>'sitemap-list', 'menu_class'=>'')); ?>
				</div>
			<?php
				$ct++;
			}
			?>
			</div>			
		<?php }
		else{ ?>
			<div>
			<p><?php _e('No posts were found. Sorry!', PHANTASMACODE_MARIANIAC_THEME); ?></p>
			</div>
		<?php } ?>		
		</div>
		<!-- End Content - Articles -->
	</div>
</div>
<!-- End Content Section -->

<?php get_footer(); ?>