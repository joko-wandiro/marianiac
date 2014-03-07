<?php get_header(); ?>

<!-- Start Content Section -->
<div class="container" id="content">
	<div class="row-fluid" id="frontpage">
		<!-- Start Content - Articles -->
<!--		<div class="span12">-->
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
				<div class="span3">
					<div class="post">
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php 
					$categories_list= "";
					if ( is_object_in_taxonomy( get_post_type(), 'category' ) ){ // Hide category text when not supported 
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( __( ', ', PHANTASMACODE_MARIANIAC_THEME) );
						if ( $categories_list ){
							$txt_categories= __("Filed under", PHANTASMACODE_MARIANIAC_THEME);
							$categories_list= sprintf('<span class="no-case">| %1$s</span> %2$s', $txt_categories, 
							$categories_list );
						}
					} // End if is_object_in_taxonomy( get_post_type(), 'category' ) 
					?>
					<div class="content"><?php the_excerpt(); ?></div>
					</div>
					<div class="post-date-button">
						<div class="row-fluid">
						<div class="span7">
						<p class="post-by">
						<?php
						$post_by = __('%1$s', PHANTASMACODE_MARIANIAC_THEME);
						printf(esc_html(get_the_date()));
						?>
						</p>
						</div>
						<div class="span5">
						<div class="read-more"><a href="<?php the_permalink(); ?>"><?php _e("Read More", 
						PHANTASMACODE_MARIANIAC_THEME); ?></a></div>
						</div>
						</div>
					</div>					
				</div>
			<?php
				$ct++;
			}
			?>
				<div class="row-fluid">
					<div class="span12">
					<div id="navigation">
					<a href="<?php echo get_bloginfo('url') . "?archive=1"; ?>"><?php _e("ALL POSTS", 
					PHANTASMACODE_MARIANIAC_THEME); ?></a>
					</div>
					</div>
				</div>
			</div>
		<?php }
		else{ ?>
			<div>
			<p><?php _e('No posts were found. Sorry!', PHANTASMACODE_MARIANIAC_THEME); ?></p>
			</div>
		<?php } ?>		
<!--		</div>-->
		<!-- End Content - Articles -->
	</div>
</div>
<!-- End Content Section -->

<?php get_footer(); ?>