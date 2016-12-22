<?php
/**
 * Dynamic Styles
*/

function metro_magazine_dynamic_css(){
    
    $color_scheme = get_theme_mod( 'metro_magazine_color_scheme', '#bfbfbf' );
    
    echo "<style type='text/css' media='all'>"; ?>
    
    a {
        color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    a:hover,
    a:focus,
    .section-two .post .entry-header .entry-meta a:hover,
    .section-two .post .entry-header .entry-meta a:focus,
    .section-two .post .entry-header .entry-title a:hover,
    .section-two .post .entry-header .entry-title a:focus,
    .section-three .post .entry-header .entry-meta a:hover,
    .section-three .post .entry-header .entry-meta a:focus,
    .section-three .post .entry-header .entry-title a:hover,
    .section-three .post .entry-header .entry-title a:focus,
    .section-four .post .entry-header .entry-meta a:hover,
    .section-four .post .entry-header .entry-meta a:focus,
    .section-four .post .entry-header .entry-title a:hover,
    .section-four .post .entry-header .entry-title a:focus,
    .section-five .post .entry-meta a:hover,
    .section-five .post .entry-meta a:focus,
    .section-five .post .entry-title a:hover,
    .section-five .post .entry-title a:focus,
    .section-five .post .btn-detail a:hover,
    .section-five .post .btn-detail a:focus,
    #primary .post .entry-meta a:hover,
    #primary .post .entry-meta a:focus,
    #primary .post .entry-header .entry-title a:hover,
    #primary .post .entry-header .entry-title a:focus,
    #primary .post .entry-footer .btn-readmore:hover,
    #primary .post .entry-footer .btn-readmore:focus,
    .widget ul li a:hover,
    .widget ul li a:focus{
        color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;    
    }
    
    .main-navigation .current_page_item > a,
    .main-navigation .current-menu-item > a,
    .main-navigation .current_page_ancestor > a,
    .main-navigation .current-menu-ancestor > a,
    .main-navigation li:hover > a,
    .main-navigation li.focus > a,
    .main-navigation ul li a:hover,
    .main-navigation ul li a:focus{
        border-top-color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
        color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    .main-navigation ul ul :hover > a,
    .main-navigation ul ul .focus > a {
    	background: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    	color: #fff;
    }
    
    .all-post .post .entry-title a:hover,
    .all-post .post .entry-title a:focus{
        color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    
    .section-two .header .header-title a:hover,
    .section-two .header .header-title a:focus,
    .section-three .header .header-title a:hover,
    .section-three .header .header-title a:focus,
    .videos .header .header-title a:hover,
    .videos .header .header-title a:focus{
        text-decoration: none;
        color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    .section-five .btn-holder a:before{
        border-color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
        background: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    .pagination .current,
    .pagination a:hover,
    .pagination a:focus,
    .widget.widget_calendar caption{
        background: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    #secondary .widget.widget_rss ul li a,
    #secondary .widget.widget_text ul li a{
        color: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    .widget.widget_tag_cloud a:hover,
    .widget.widget_tag_cloud a:focus{
        background: <?php echo metro_magazine_sanitize_hex_color( $color_scheme ); ?>;
    }
    
    
    <?php echo "</style>";
}

/**
 * Function for sanitizing Hex color 
 */
function metro_magazine_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}