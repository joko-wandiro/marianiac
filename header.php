<?php
$phantasmacode_theme_marianiac_settings_vars= get_option('phantasmacode_theme_marianiac_settings_vars');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>
<head>
<meta charset="utf-8">
<title><?php wp_title( '', true, 'right' ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->
<!-- Fav and touch icons -->
<script><?php echo $phantasmacode_theme_marianiac_settings_vars['google_analytics']['code']; ?></script>
<?php wp_head(); ?>
</head>
<body <?php body_class( $class ); ?>>
<?php
if ( ! isset( $content_width ) ) $content_width = 900;
#wp_link_pages();
?>
<!-- Start Header Section -->
<div class="">
<div class="container" id="header">
	<div class="row-fluid" id="contact-information">
		<div class="span12">
		<div class="row-fluid">
			<div class="span7">
			<?php
			$phone_number= $phantasmacode_theme_marianiac_settings_vars['contact']['phone_number'];
			$email_address= $phantasmacode_theme_marianiac_settings_vars['contact']['email_address'];
			if( $phone_number || $email_address ){
			?>
			<p>
			<?php _e('Call Us', PHANTASMACODE_MARIANIAC_THEME); ?>: <?php echo ( ! empty($phone_number) ) ? $phone_number : "-"; ?> | Email: 
			<?php 
			if( ! empty($email_address) ){
			?>
				<a href="mailto:<?php echo $email_address; ?>"><?php echo $email_address; ?></a>
			<?php 
			}else{
				echo "-";
			}
			?>
			</p>
			<?php
			}
			?>			
			</div>
			<div class="span5">
			<?php get_sidebar('header'); ?>
			</div>
		</div>
		</div>
	</div>
	<div class="row-fluid" id="wrapper-logo-menu">
		<div class="span3">
		<div id="logo">
		<a class="" href="<?php echo esc_url( home_url( '/' ) ); ?>" 
		title="<?php echo __('Phantasmacode', PHANTASMACODE_MARIANIAC_THEME); ?>">
		<?php
		$image_src= wp_get_attachment_image_src($phantasmacode_theme_marianiac_settings_vars['image_url'], 'post-large');
		if( $image_src ){
		?>
		<img src="<?php echo $image_src[0]; ?>" alt="" height="54" />
		<?php
		}else{
		?>
		<img src="<?php echo PHANTASMACODE_MARIANIAC_THEME_IMAGES . "logo.png"; ?>" 
		alt="<?php echo __('Phantasmacode', PHANTASMACODE_MARIANIAC_THEME); ?>" height="54" />
		<?php
		}
		?>
		</a>
		</div>
		</div>
		<div class="span9">
		<div class="top navbar">
			<div class="navbar-inner">
				<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</a>
				<div class="nav-collapse collapse navbar-responsive-collapse">
				<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => '', 
				'menu_id'=>'menu', 'menu_class'=>'nav', 'walker'=>new PHC_Marianiac_Bootstrap_Walker_Nav_Menu)); ?>
				<?php get_search_form(); ?>
				</div><!-- /.nav-collapse -->
				</div>
			</div><!-- /navbar-inner -->
		</div>
		</div>
	</div>
</div>
</div>
<!-- End Header Section -->

<!-- Start Slider Section -->
<?php
global $wp_query;
if ( $wp_query->is_home() ) {
	get_template_part('slider');
}
?>
<!-- End Slider Section -->