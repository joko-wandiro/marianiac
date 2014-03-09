<?php get_header(); ?>

<!-- Start Content Section -->
<div class="container" id="content">
	<div class="row-fluid">
		<!-- Start Content - Articles -->
		<div class="span12">
		<?php if( have_posts() ){ ?>
			<div class="wrapper-posts" id="articles">
			<h1 class="page-title"><?php printf( __('Search Results for: %s', PHANTASMACODE_MARIANIAC_THEME), 
			'<span class="highlight">' . get_search_query() . '</span>' ); ?></h1>
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
				<?php 
				$categories_list= "";
				if ( is_object_in_taxonomy( get_post_type(), 'category' ) ){ // Hide category text when not supported 
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', PHANTASMACODE_MARIANIAC_THEME) );
					if ( $categories_list ){
						$txt_categories= __("Filed under", PHANTASMACODE_MARIANIAC_THEME);
						$categories_list= sprintf('<span class="no-case">| %1$s</span> %2$s', $txt_categories, 
						$categories_list );
					} // End if categories 
				} // End if is_object_in_taxonomy( get_post_type(), 'category' ) 
				?>				
				<p class="post-by">
				<span class="icon-custom-calendar">&nbsp;</span>
				<?php
				$post_by = __('%2$s %3$s', PHANTASMACODE_MARIANIAC_THEME);
				printf($post_by, get_the_author(), esc_html(get_the_date()), $categories_list);
				?>
				</p>
				<?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				?>
				<div class="post-feature-image"><?php the_post_thumbnail("featured_image"); ?></div>
				<?php
				}
				?>
				<div class="content"><?php the_excerpt(); ?></div>
				<div class="read-more"><a href="<?php the_permalink(); ?>"><?php _e("Read More", 
				PHANTASMACODE_MARIANIAC_THEME); ?></a></div>
				</div>
			<?php
				$ct++;
			}
			?>
				<div id="navigation">
				<?php
				// Navigation Page
				$next_posts_link_text= __("&lt; Older Entries", PHANTASMACODE_MARIANIAC_THEME);
				$previous_posts_link_text= __("Newer Entries &gt;", PHANTASMACODE_MARIANIAC_THEME);
				$navigations= array("previous_posts_link", "next_posts_link");
				foreach( $navigations as $nav ){
					$text= $nav . "_text";
					$class= $nav;
					if( $class == "previous_posts_link" ){
						$class= "previous_posts_link pull-right";
					}
				?>
				<div class="<?php echo str_replace("_", "-", $class); ?>"><?php $nav($$text); ?></div>
				<?php
				}
				?>
				</div>
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
