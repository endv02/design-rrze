<?php
/**
 * _rrze functions and definitions
 *
 * @package _rrze
 */

define('_RRZE_PHP_VERSION', '5.3' );

define('_RRZE_WP_VERSION', '3.5' );

define('_RRZE_THEME_OPTIONS_NAME', '_rrze_theme_options' );

require( get_template_directory() . '/inc/template-parser.php' );

require( get_template_directory() . '/inc/theme-tags.php' );

require( get_template_directory() . '/inc/theme-options.php' );

add_action( 'after_setup_theme', function() {
	if ( version_compare( PHP_VERSION, _RRZE_PHP_VERSION, '<' ) ) {
		add_action( 'admin_notices', '_rrze_php_version_error' );
		$fail = true;
	}

	if ( version_compare( $GLOBALS['wp_version'], _RRZE_WP_VERSION, '<' ) ) {
		add_action( 'admin_notices', '_rrze_wp_version_error' );
		$fail = true;
	}
    
    add_editor_style();
                
    load_theme_textdomain( '_rrze', get_template_directory() . '/languages' );
    
	add_theme_support( 'automatic-feed-links' );
    
    add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'link', 'quote', 'status' ) );
    
    add_theme_support( 'post-thumbnails' );
        
	register_default_headers( array(
		'grau' => array(
			'url' => '%2$s/images/headers/grau-header.jpg',
			'thumbnail_url' => '%2$s/images/headers/grau-thumbnail.jpg',
			'description' => __( 'Grau', '_rrze' )
		)        
        
	) );    
    
    register_nav_menu( 'bereichsmenu', __( 'Bereichsmenü', '_rrze' ) );
    
} );

add_action( 'after_setup_theme', function() {
	$defaults = array(
        'default-image' => get_stylesheet_directory_uri() . '/images/headers/grau-header.jpg',
		'width' => apply_filters( '_rrze_header_image_width', 1120 ),
		'height' => apply_filters( '_rrze_header_image_height', 160 ),
        'default-text-color' => '00425F',
        'uploads' => true,
        'wp-head-callback' => '_rrze_header_style',
        'admin-head-callback' => '_rrze_admin_header_style',
        'admin-preview-callback' => '_rrze_admin_header_image',
	);    
    
    add_theme_support( 'custom-header', $defaults );    
} );

function _rrze_php_version_error() {
	printf( '<div class="error fade"><p><b>%s</b></p></div>', sprintf( __( 'Ihre PHP-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die PHP-Version %s', '_rrze'), PHP_VERSION, _RRZE_PHP_VERSION ) );
}

function _rrze_wp_version_error() {
	printf( '<div class="error fade"><p><b>%s</b></p></div>', sprintf( __( 'Ihre Wordpress-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die Wordpress-Version %s', '_rrze'), $GLOBALS['wp_version'], _RRZE_WP_VERSION ) );
}

function _rrze_header_style() {
	$text_color = get_header_textcolor();

	if ( $text_color == HEADER_TEXTCOLOR )
		return;
	?>
	<style type="text/css">
	<?php if ( 'blank' == $text_color ) : ?>
		#site-title, #site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php else : ?>
		#site-title, #site-description {
			color: <?php printf( '#%s', $text_color ); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}

function _rrze_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1, #headimg h3 {
        font-family: "Droid Sans",Arial,Helvetica,sans-serif;
        font-weight: 400;
        padding: 0;
        margin: 0;
	}
	#headimg h1 {
        display: inline-block;
        background-color: rgba(255, 255, 255, 0.75);
        font-size: 405%;
        line-height: 56px;
        margin-top: 36px;
	}
	#headimg h3 {
        background-color: rgba(255, 255, 255, 0.55);
        font-size: 200%;
        line-height: 1em;
        margin-top: 9px;

	}
	</style>
<?php
}

function _rrze_admin_header_image() { ?>
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = 'background: none; padding-left: 0; margin-bottom: 0; color:#' . $color . ';';
		else
			$style = 'display:none;';
		?>
    <?php if ( $image ) : ?>
    <div id="headimg" style="background-image:url('<?php echo esc_url( $image ); ?>'); width:auto; max-width:1120px; height:160px;">
    <?php else: ?>
    <div id="headimg">
    <?php endif; ?>
		<h1 id="name" style="<?php echo $style; ?>"><span style="padding: 4px 4px 4px 20px; background-color: rgba(255, 255, 255, 0.75);"><?php bloginfo( 'name' ); ?></span></h1>
		<h3 id="desc" style="<?php echo $style; ?>"><span style="padding: 4px 4px 4px 20px; background-color: rgba(255, 255, 255, 0.55);"><?php bloginfo( 'description' ); ?></span></h3>
	</div>
<?php }
 
add_action( 'widgets_init', function() {    
    register_sidebar( array(
        'name' => __( 'Sidebar links', '_rrze' ),
        'id' => 'sidebar-left',
        'description'   => __( 'Dieser Bereich ist für die Menüs und die Widgets vorgesehen.', '_rrze' ),
        'before_widget' => '<div id="%1$s" class="widget-wrapper ym-vlist %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="widget-title">',
        'after_title' => '</h6>',               
    ) );

    register_sidebar( array(
        'name' => __( 'Sidebar rechts', '_rrze' ),
        'id' => 'sidebar-right',
        'description'   => __( 'Dieser Bereich ist für die Menüs und die Widgets vorgesehen.', '_rrze' ),
        'before_widget' => '<div class="widget-wrapper ym-vlist">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="widget-title">',
        'after_title' => '</h6>',      
    ));
    
    register_sidebar( array(
        'name' => __( 'Footer-Sidebar links', '_rrze' ),
        'id' => 'sidebar-footer-left',
        'description'   => __( 'Dieser Bereich ist für die Zusatzinformationen (im Footer links) vorgesehen. Hier könnten hilfreiche Links oder sonstige Informationen stehen, welche auf jeder Seite eingeblendet werden sollen. Diese Angaben werden bei der Ausgabe auf dem Drucker nicht mit ausgegeben!', '_rrze' ),
        'before_widget' => '<div id="%1$s" class="widget-wrapper ym-vlist %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="widget-title">',
        'after_title' => '</h6>',      
    ));
    
    register_sidebar( array(
        'name' => __( 'Footer-Sidebar mitte', '_rrze' ),
        'id' => 'sidebar-footer-center',
        'description'   => __( 'Dieser Bereich ist für die Zusatzinformationen (im Footer mitte) vorgesehen. Hier könnten hilfreiche Links oder sonstige Informationen stehen, welche auf jeder Seite eingeblendet werden sollen. Diese Angaben werden bei der Ausgabe auf dem Drucker nicht mit ausgegeben!', '_rrze' ),
        'before_widget' => '<div id="%1$s" class="widget-wrapper ym-vlist %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="widget-title">',
        'after_title' => '</h6>',      
    ));

    register_sidebar( array(
        'name' => __( 'Footer-Sidebar rechts', '_rrze' ),
        'id' => 'sidebar-footer-right',
        'description'   => __( 'Dieser Bereich ist für die Zusatzinformationen (im Footer rechts) vorgesehen. Hier könnten hilfreiche Links oder sonstige Informationen stehen, welche auf jeder Seite eingeblendet werden sollen. Diese Angaben werden bei der Ausgabe auf dem Drucker nicht mit ausgegeben!', '_rrze' ),
        'before_widget' => '<div id="%1$s" class="widget-wrapper ym-vlist %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="widget-title">',
        'after_title' => '</h6>',      
    ));
    
} );

add_action( 'wp_head', function() {
    $header_image = get_header_image();
    if ( $header_image )
        printf( '<style type="text/css">%1$sbody div#kopf div#title {background: url("%2$s") no-repeat scroll center top transparent;}%1$s</style>%1$s', PHP_EOL, $header_image );
} );

add_action( 'wp_head', function() {
    $options = _rrze_theme_options();
    Template_Parser::print_template( $options, 'css/layout', '<style type="text/css">', '</style>' . PHP_EOL );
} );

add_action( 'wp_head', function() {
    $options = _rrze_theme_options();
    Template_Parser::print_template( $options['color.style'], 'css/color', '<style type="text/css">', '</style>' . PHP_EOL );
} );

/**
add_action( 'admin_enqueue_scripts', function() {
    wp_enqueue_style( 'rrze-admin', sprintf('%s/css/admin.css', get_template_directory_uri() ) );
    
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'rrze-admin', sprintf( '%s/js/admin.js', get_template_directory_uri() ), array( 'wp-color-picker' ), false, true );    
} );
 * 
 */

add_action( 'wp_enqueue_scripts', function() {
    $options = _rrze_theme_options();
    
    wp_enqueue_style( 'style', get_stylesheet_uri() );
        
    wp_register_style('iehacks', sprintf('%s/css/yaml/core/iehacks.css', get_template_directory_uri() ) );
    $GLOBALS['wp_styles']->add_data( 'iehacks', 'conditional', 'lte IE 7' );
    wp_enqueue_style( 'iehacks' );
    
    wp_enqueue_script( 'jquery' );
    
    wp_register_script( 'focusfix', sprintf( '%s/css/yaml/core/js/yaml-focusfix.js', get_template_directory_uri() ), array(), false, true );
    wp_enqueue_script( 'focusfix');
    
    wp_register_script( 'base', sprintf( '%s/js/base.js', get_template_directory_uri() ), array(), false);
    wp_enqueue_script( 'base' );
    
} );

add_filter( 'wp_list_categories', function( $links ) {
    $links = str_replace('</a> (', ' (', $links );
    $links = str_replace(')', ')</a>', $links);
    return $links;
} );

add_filter( 'get_archives_link', function( $links ) {
    $links = str_replace( '</a>&nbsp;(', ' (', $links );
    $links = str_replace( ')', ')</a>', $links );
    return $links;    
} );

function _rrze_bereichsmenu( $args ) {
    // Siehe wp-includes/nav-menu-template.php
    extract( $args );

    $links = array(
        '<a href="' . home_url( '', 'http' ) . '">' . $before . __( 'Startseite', '_rrze' ) . $after . '</a>',
        );
    
    $li = array();
    foreach( $links as $link ) {
        if ( false !== stripos( $items_wrap, '<ul' ) or false !== stripos( $items_wrap, '<ol' ) )
            $li[] = is_front_page() ? "<li class='current-menu-item'>$link</li>" : "<li>$link</li>";
    }
    
    $li = implode( PHP_EOL, $li );
    
    $output = sprintf( $items_wrap, $menu_id, $menu_class, $li );
    if ( ! empty ( $container ) )
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    
    if ( $echo )
        echo $output;

    return $output;
}

function _rrze_tecmenu( $args ) {
    global $current_blog, $post;
    
    if( is_page() )
        $page = get_page( $post->ID );
    
    // Siehe wp-includes/nav-menu-template.php
    extract( $args );

    $links = array(
        '<li><a href="' . network_site_url( '/', 'http' ) . '">' . $before . __( 'Blogs@FAU', '_rrze' ) . $after . '</a></li>',
        '<li><a href="http://www.portal.uni-erlangen.de/forums/viewforum/94">' . $before . __( 'Forum', '_rrze' ) . $after . '</a></li>',
        sprintf( is_front_page() && $current_blog->path == '/hilfe/' ? '<li class="current-menu-item">%s</li>' : '<li>%s</li>', '<a href="' . network_site_url( '/hilfe/', 'http' ) . '">' . $before . __( 'Hilfe', '_rrze' ) . '</a>' ),
        sprintf( ! empty( $page ) && $page->post_name == 'kontakt' ? '<li class="current-menu-item">%s</li>' : '<li>%s</li>', '<a href="' . home_url( '/kontakt/', 'http' ) . '">' . $before . __( 'Kontakt', '_rrze' ) . $after . '</a>' ),
        '<li><a href="' . network_site_url( '/nutzungsbedingungen/', 'http' ) . '">' . $before . __( 'Nutzungsbedingungen', '_rrze' ) . $after . '</a></li>'
        );
    
    $li = array();
    foreach( $links as $link ) {
        if ( false !== stripos( $items_wrap, '<ul' ) or false !== stripos( $items_wrap, '<ol' ) )
            $li[] = $link;
    }
    
    $li = implode( PHP_EOL, $li );
    
    $output = sprintf( $items_wrap, $menu_id, $menu_class, $li );
    if ( ! empty ( $container ) )
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    
    if ( $echo )
        echo $output;

    return $output;
}

/**
 *  Advanced Custom Fields Lite
 *
 *  @Author: Elliot Condon
 *  @Author URI: http://www.elliotcondon.com/
 *  @Copyright: Elliot Condon
 */
require_once('inc/acf/acf-lite.php');

register_field_group(array (
    'id' => '5125153077283',
    'title' => __( 'Einstellungen', '_rrze' ),
    'fields' => 
    array (
        0 => 
        array (
            'key' => 'field_1',
            'label' => __( 'Titel ausblenden', '_rrze' ),
            'name' => 'titel_ausblenden',
            'type' => 'true_false',
            'order_no' => 0,
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 
            array (
                'status' => 0,
                'rules' => 
                array (
                    0 => 
                    array (
                        'field' => 'field_1',
                        'operator' => '==',
                        'value' => 'Ja',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
    ),
    'location' => 
    array (
        'rules' => 
        array (
            0 => 
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
                'order_no' => 0,
            ),
        ),
        'allorany' => 'all',
    ),
    'options' => 
    array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => 
        array (
        ),
    ),
    'menu_order' => 1,
));