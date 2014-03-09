<?php
define('PHANTASMACODE_MARIANIAC_THEME_TEMP_URL', get_bloginfo('template_url') . "/");
define('PHANTASMACODE_MARIANIAC_THEME_TEMPPATH', get_bloginfo('stylesheet_directory'));
define('PHANTASMACODE_MARIANIAC_THEME_JS_PATH', PHANTASMACODE_MARIANIAC_THEME_TEMP_URL . "/js/");
define('PHANTASMACODE_MARIANIAC_THEME_CSS_PATH', PHANTASMACODE_MARIANIAC_THEME_TEMP_URL . "/css/");
define('PHANTASMACODE_MARIANIAC_THEME_IMAGES', PHANTASMACODE_MARIANIAC_THEME_TEMPPATH . "/images/");
define('PHANTASMACODE_MARIANIAC_THEME_IMAGES_FLAT_SOCIAL_MEDIA_ICONS', PHANTASMACODE_MARIANIAC_THEME_TEMPPATH . "/images/flat_social_media_icons/");
define('PHANTASMACODE_MARIANIAC_THEME_IMAGES_BANNER', PHANTASMACODE_MARIANIAC_THEME_IMAGES . "banner/");
define('PHANTASMACODE_MARIANIAC_THEME', "phantasmacode-marianiac-theme");
define('PHANTASMACODE_MARIANIAC_THEME_IDENTIFIER', "marianiac");

/*// Start Sample Hooks Action and Filter for Camera Jquery Plugin 
add_action("phc_camera_load_scripts_and_styles", "custom_phc_camera_load_scripts_and_styles");
function custom_phc_camera_load_scripts_and_styles(){
//	echo "custom_phc_camera_load_scripts_and_styles";
}

add_action("phc_camera_widget_load_scripts_and_styles", "custom_phc_camera_widget_load_scripts_and_styles");
function custom_phc_camera_widget_load_scripts_and_styles(){
	wp_enqueue_style('style_css', PHANTASMACODE_MARIANIAC_THEME_TEMP_URL.'camera_new_skin.css', FALSE);
}

add_action("phc_camera_before_init", "custom_phc_camera_before_init");
function custom_phc_camera_before_init(){
	echo "<p>custom_phc_camera_before_init</p>";
}

add_action("phc_camera_after_init", "custom_phc_camera_after_init");
function custom_phc_camera_after_init(){
	echo "<p>custom_phc_camera_after_init</p>";
}

add_filter("phc_camera_properties", "custom_phc_camera_properties", 10, 3);
function custom_phc_camera_properties($camera_properties, $post, $type){
	if( $type == "widget" ){
		$camera_properties['thumbnails']= 'false';
	}
	return $camera_properties;
}
// End Sample Hooks Action and Filter for Camera Jquery Plugin*/

//add_action('wp', 'phantasmacode_insert_article');
function phantasmacode_insert_article() {
    global $post;
	$post_array= $post->to_array();
	$post_custom= get_post_custom($post_array['ID']);
	for( $i=2; $i<=25; $i++ ){
		unset($post_array['ID']);
		// Insert Sample Data for Article
//		$post_array['post_title']= "Article Title" . $i;
//		$post_array['post_content']= "Content Testing Article " . $i;
		// Insert Sample Data for Stuff
		$post_array['post_title']= "Article " . $i;
//		$post_array['post_content']= "Content Article " . $i;
		$res= wp_insert_post($post_array);
		foreach( $post_custom as $custom_key=>$custom_value ){
			add_post_meta($res, $custom_key, $custom_value[0], TRUE);
		}
	}
}

add_action('wp', 'theme_enqueue_scripts_404');
function theme_enqueue_scripts_404() {
	global $pagenow, $wp_scripts, $wp_query;
		
	if( is_404() ){
		wp_enqueue_style('page_not_found_css', PHANTASMACODE_MARIANIAC_THEME_CSS_PATH.'page-not-found.css', FALSE);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}
}

function query_post_for_homepage( $query ) {
	$archive= get_query_var('archive');
	
    if ( $query->is_home() ) {
		if( $archive ){
			$query->is_home= FALSE;
			$query->is_archive= TRUE;
			return;
		}
		
		$query->set( 'posts_per_page', 4 );
		$phantasmacode_theme_marianiac_settings_vars= get_option('phantasmacode_theme_marianiac_settings_vars');
		if( isset($phantasmacode_theme_marianiac_settings_vars['slider']) && ! empty($phantasmacode_theme_marianiac_settings_vars['slider']) ){
			// Enqueue the Camera Scripts and Styles
			wp_enqueue_style(PHC_CAMERA_ID_SCRIPT . '_camera_css', 
			PHC_CAMERA_PATH_URL_CSS . "camera/camera.css");
			
			wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_mobile_js', 
			PHC_CAMERA_PATH_URL_JS . "camera/jquery.mobile.customized.min.js", 
			array("jquery"), '', FALSE);
			wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_easing_js', 
			PHC_CAMERA_PATH_URL_JS . "camera/jquery.easing.1.3.js", 
			array("jquery"), '', FALSE);
			wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_camera_js', 
			PHC_CAMERA_PATH_URL_JS . "camera/camera.min.js", 
			array("jquery"), '', FALSE);
		}
		return;
    }
}
add_action('pre_get_posts', 'query_post_for_homepage');

add_action("init", "theme_enqueue_scripts");
function theme_enqueue_scripts(){
	global $pagenow, $wp_scripts;
	
	if( ! is_admin() && ! in_array($pagenow, array('wp-login.php', 'wp-register.php')) ){ // FrontEnd Site
		// Add Javascript Files
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap_js', PHANTASMACODE_MARIANIAC_THEME_JS_PATH. 'bootstrap.min.js');
		wp_enqueue_script('bootstrap_jwdropdown', PHANTASMACODE_MARIANIAC_THEME_JS_PATH. 'bootstrap.jwdropdown.min.js');
		wp_enqueue_script('main_js', PHANTASMACODE_MARIANIAC_THEME_JS_PATH. 'main.js');

		// Add Stylesheet Files
		wp_enqueue_style('style_css', PHANTASMACODE_MARIANIAC_THEME_TEMP_URL.'style.css', FALSE);
		wp_enqueue_style('sidebar_css', PHANTASMACODE_MARIANIAC_THEME_CSS_PATH.'sidebar.css', array('contact-form-7', 'wc-shortcodes-style'));
		wp_enqueue_style('font_css', 'http://fonts.googleapis.com/css?family=Duru+Sans', FALSE);
	}
}

// Add Support for Featured Images 
if( function_exists('add_theme_support') ){
	add_theme_support('post-thumbnails');
	add_image_size('featured_image', 960, 0);
	add_image_size('stuff_thumbnail', 220, 220, TRUE);
}

add_filter('cancel_comment_reply_link', 'custom_cancel_comment_reply_link', 10, 3);
function custom_cancel_comment_reply_link($arg1, $arg2, $arg3) {
	$replytocom= get_query_var('replytocom');
	if( ! empty($replytocom) ){
		return '<a rel="nofollow" id="cancel-comment-reply-link" class="btn" href="' . $arg2 . '">Cancel</a>';
	}
	return $arg1;
}

// Set Post Per Page
add_action('pre_get_posts', 'phantasmacode_theme_pre_get_posts', 10, 1);
function phantasmacode_theme_pre_get_posts($query){
	global $pagename, $post;
    if ( ! is_admin() ){
		$post_type= isset($query->query['post_type']) ? $query->query['post_type'] : "";
		
		// Archive Page
		if ( is_archive() && $post_type == "stuff" ){
			$query->set('posts_per_page', 8);
		}
        return;
	}
}

// Set Excerpt Length
add_filter('excerpt_length', 'custom_excerpt_length', 999);
function custom_excerpt_length( $length ) {
	return 25;
}

// Set Excerpt More
add_filter('excerpt_more', 'phantasmacode_theme_excerpt_more', 10);
function phantasmacode_theme_excerpt_more($more) {
	return '...';
}

add_theme_support( 'automatic-feed-links' );
add_theme_support('nav-menus');
// Register Nav Menus
if( function_exists('register_nav_menus') ){
	register_nav_menus(array(
	'primary'=>__('Primary Navigation', PHANTASMACODE_MARIANIAC_THEME),
	'secondary'=>__('Secondary Navigation', PHANTASMACODE_MARIANIAC_THEME),
	));
}

// Register Sidebar
if( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name'=>__('Primary Sidebar', PHANTASMACODE_MARIANIAC_THEME),
		'id'=>'primary-widget-area',
		'description'=>__('The Primary Widget Area', PHANTASMACODE_MARIANIAC_THEME),
		'before_widget'=>'<div class="widget">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget">',
		'after_title'=>'</h3>'
	));
	register_sidebar(array(
		'name'=>__('Header Widgets', PHANTASMACODE_MARIANIAC_THEME),
		'id'=>'header-widgets-area',
		'description'=>__('The Header Widgets Area', PHANTASMACODE_MARIANIAC_THEME),
		'before_widget'=>'<div class="widget header-widgets">',
		'after_widget'=>'</div>',
		'before_title'=>'<h3 class="title-widget">',
		'after_title'=>'</h3>'
	));
}
		
// Start Override Menu
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
function add_menu_parent_class($items){
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach( $items as $item ){
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'dropdown';
			$item->hasChild= TRUE;
		}
	}
	
	return $items;
}

class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array('sub-menu', 'dropdown-menu');
		$class_names = implode( ' ', $classes );
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		if( $item->hasChild ){
			$attributes.= ' class="' . esc_attr("dropdown-toggle") . '" data-toggle="' . esc_attr('') . '"';
		}
		$item_output .= '<a'. $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if( $item->hasChild ){
			$item_output.= '<b class="caret"></b>';
		}
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

class SiteMap_Footer_Nav_Menu extends Walker_Nav_Menu {
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if( $item->hasChild ){
			$output .= "</div>\n";
		}else{
			$output .= "</li>\n";
		}		
	}
		
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array();
		$classes = array('sitemap-footer-menu');
		$class_names = implode( ' ', $classes );
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if( $item->hasChild ){
			$class_names= "class=\"span3\"";
			$output .= $indent . '<div' . $id . $value . $class_names .'>';
		}else{
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
		}
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		if( $item->hasChild ){
			$attributes.= ' class="' . esc_attr("dropdown-toggle") . '" data-toggle="' . esc_attr('') . '"';
		}
		
		if( $item->hasChild ){
			$item_output .= '<h3>';
		}else{
			$item_output .= '<a'. $attributes . '>';
		}
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if( $item->hasChild ){
		}
		
		if( $item->hasChild ){
			$item_output .= '</h3>';
		}else{
			$item_output .= '</a>';
		}		
		$item_output .= $args->after;
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
// End Override Menu

// Pagination Bootstrap - Support structure Bootstrap
function bootstrap_pagination($pagination=array()){
	if( !empty($pagination) ){
?>
	<div class="pagination">
	<ul>
<?php
	foreach( $pagination as $paging ){
		$current= "";
		$pattern= "#current#";
		if( preg_match($pattern, $paging) ){
			$current= "current";
		}
		
		$pattern_link= "#(prev|next)#";
		$class_add= ( preg_match($pattern_link, $paging) ) ? " block" : "";
?>
		<li class="<?php echo $current . $class_add; ?>">
		<?php
		if( ! preg_match($pattern_link, $paging) ){
		?>
		<?php echo $paging; ?>
		<?php
		}else{
			$patterns= array('&laquo; Previous', 'Next &raquo;');
			$replacements= array('<i class="icon-arrows-pagination-left"></i>', 
			'<i class="icon-arrows-pagination-right"></i>');
			echo str_replace($patterns, $replacements, $paging);
		}
		?>
		</li>
<?php
	}
?>
	</ul>
	</div>
<?php
	}
}

function phantasmacode_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="row-fluid">
		<div class="span1">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div>
		<div class="span11">
		<div class="comment-author vcard">
		<h2><?php echo get_comment_author_link(); ?></h2>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 
		PHANTASMACODE_MARIANIAC_THEME) ?></em>
		<br />
		<?php endif; ?>
		
		<div class="comment-meta commentmetadata">
		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
		printf( __('%1$s at %2$s', PHANTASMACODE_THEME), get_comment_date(),  get_comment_time()) ?></a>
		<?php edit_comment_link(__('(Edit)', PHANTASMACODE_MARIANIAC_THEME),'  ','' ); ?>
		</div>

		<div class="comment-text"></div>
		<?php comment_text() ?>

		<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 
		'max_depth' => $args['max_depth']))) ?>
		</div>		
		</div>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
        }
		
function bootstrap_archive_news_pagination($pagination=array()){
	if( !empty($pagination) ){
?>
	<div class="pagination">
	<ul>
<?php
	foreach( $pagination as $paging ){
		$current= "";
		$pattern= "#current#";
		if( preg_match($pattern, $paging) ){
			$current= "current";
		}
		
		$pattern_link= "#(prev|next)#";
?>
		<li class="<?php echo $current; ?>">
		<?php echo $paging; ?>
		</li>
<?php
	}
?>
	</ul>
	</div>
<?php
	}
}

// Filter the "Thank you" text displayed in the admin footer.
add_filter( 'admin_footer_text', 'wpse_edit_text', 11 );
function wpse_edit_text($content) {
    return "Developed by <a href='http://www.phantasmacode.com/'>www.phantasmacode.com</a>";
}

// MultiPostThumbnails
if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(
		array(
			'label'=>'Stuff Archive Image',
			'id'=>'stuff-archive-image',
			'post_type'=>'stuff'
    	)
	);
}

// Support Shortcode on Widget Text
add_filter('widget_text', 'do_shortcode');

//WP_Widget_Recent_Posts
add_action('init', 'phantasmacode_rewrite');
function phantasmacode_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

// Buffer Output
function buffer_output($function_name=""){
	ob_start();
	$function_name();
	$res = ob_get_contents();
	ob_end_clean();

	return $res;
}

// Add Bootstrap Class into Form
add_filter( 'wpcf7_form_class_attr', 'wpcf7_form_class_attr' );
function wpcf7_form_class_attr($class){
	return $class . " form-horizontal";
}

if (function_exists('camera_main_ss_add')) {
	add_action('admin_init','camera_main_ss_add');
}

// Add Extra Query Vars
add_filter('query_vars', 'add_extra_vars');
function add_extra_vars($public_query_vars) {
	$public_query_vars[] = 'replytocom';
	$public_query_vars[] = 'archive';
	return $public_query_vars;
}

// Add Rewrite Rules Extra
add_action('init', 'wp_rewrite_extra');
function wp_rewrite_extra() {
    global $wp_rewrite;
    add_rewrite_rule('archive/([0-9]+)/?$', 'index.php?archive=1&paged=$matches[1]', 'top');
    $wp_rewrite->flush_rules(); // !!!
}

add_filter( 'locale', 'marianiac_theme_localized' );
function marianiac_theme_localized( $locale )
{
	if ( isset( $_GET['lang'] ) )
	{
		$lang= $_GET['lang'] . "_" . strtoupper($_GET['lang']);
		return esc_attr($lang);
	}

	return $locale;
}

add_action('after_setup_theme', 'marianiac_setup');
function marianiac_setup(){
	load_theme_textdomain(PHANTASMACODE_MARIANIAC_THEME, 
	get_template_directory() . '/languages');
}

require_once('pages/theme-options.php');
require_once('pages/phc_widget_social_media.php');
?>