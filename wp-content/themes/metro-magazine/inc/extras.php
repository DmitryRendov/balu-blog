<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Metro_Magazine
 */

if ( ! function_exists( 'metro_magazine_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function metro_magazine_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

    $byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'metro-magazine' ),
		'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
	);
	
	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'; // WPCS: XSS OK.
if( is_single ()){
	if ( is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">'; 
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text">%s</span>', 'metro-magazine' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'metro-magazine' ) );
		if ( $categories_list && metro_magazine_categorized_blog() ) {
			printf( '<span class="category">' . esc_html__( '%1$s', 'metro-magazine' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}


}

}
endif; 

if ( ! function_exists( 'metro_magazine_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function metro_magazine_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '<li>','</li><li>' ,'</li>'  );
		if ( $tags_list ) {
			echo '<ul class = "tags">';
			printf( '' . esc_html__( '%1$s', 'metro-magazine' ) . '', $tags_list ); // WPCS: XSS OK.
			echo '</ul>';
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'metro-magazine' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function metro_magazine_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'metro_magazine_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'metro_magazine_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so metro_magazine_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so metro_magazine_categorized_blog should return false.
		return false;
	}
}



/**
 * Callback function for metro_magazine List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_metro_magazines 
 */
 
 function metro_magazine_comment($comment, $args, $depth) {
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
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	
    <footer class="comment-meta">
    
        <div class="comment-author vcard">
    	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    	<?php printf( __( '<b class="fn">%s</b>', 'metro-magazine' ), get_comment_author_link() ); ?>
    	</div>
    	<?php if ( $comment->comment_approved == '0' ) : ?>
    		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'metro-magazine' ); ?></em>
    		<br />
    	<?php endif; ?>
    
    	<div class="comment-metadata commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_date(); ?>">
    		<?php
    			/* translators: 1: date, 2: time */
    			printf( __( '%s', 'metro-magazine' ), get_comment_date() ); ?></time></a><?php edit_comment_link( __( '(Edit)', 'metro-magazine' ), '  ', '' );
    		?>
    	</div>
    </footer>
    
    <div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

if ( ! function_exists( 'metro_magazine_posted_on_date' ) ) :
/**
 * Prints HTML with meta information for the current post-date
 */
function metro_magazine_posted_on_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if( is_page_template( 'template-home' )){
        $date_type = 'd/m/Y';   
	}else{
        $date_type = '';	   
	}
    
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( $date_type ) )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'metro-magazine' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if( ! function_exists( 'metro_magazine_posted_by' ) ) :
/**
 * Post posted by
*/
function metro_magazine_posted_by(){
    $byline = sprintf(
		esc_html_x( '%s', 'post author', 'metro-magazine' ),
		'<span class="author vcard"><i class="fa fa-user" aria-hidden="true"></i><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
    
    echo '<span class="byline"> ' . $byline . '</span>';
}
endif;

if( ! function_exists( 'metro_magazine_comment_count' ) ) :
/**
 * Post Comment count
*/
function metro_magazine_comment_count(){
    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comment"><i class="fa fa-comment" aria-hidden="true"></i>';
		comments_popup_link( esc_html__( 'Leave a comment', 'metro-magazine' ), esc_html__( '1 Comment', 'metro-magazine' ), esc_html__( '% Comments', 'metro-magazine' ) );
		echo '</span>';
    }
}
endif;

if( ! function_exists( 'metro_magazine_meta' ) ) :
/**
 * Post Meta Data
*/
function metro_magazine_meta( $date = false, $author = false, $comment = false ){
    if( $date || $comment || $author ){
        echo '<div class="entry-meta">';
        if( $date ) metro_magazine_posted_on();
        if( $author ) metro_magazine_posted_by();
        if( $comment ) metro_magazine_comment_count();            
        echo '</div>';
    }
}
endif;

if( ! function_exists( 'metro_magazine_colored_category' ) ) :
/**
 * Colored category
*/
function metro_magazine_colored_category(){
    $output = '';
    // Hide category for pages.
	if ( 'post' === get_post_type() ) {		
		$categories_list = get_the_category();
		if ( $categories_list ) {
		  $output .= '<div class="category-holder">';
                foreach( $categories_list as $category ){
                $color_code = get_theme_mod( 'metro_magazine_category_color_' . $category->term_id );
                    if ( $color_code ) {
                       $output .= '<a class="category" href="' . esc_url( get_category_link( $category->term_id ) ) . '" style="background:' . esc_attr( $color_code ) . '" rel="category tag">'. esc_html( $category->cat_name ) .'</a>';
                    }else{
                       $output .= '<a class="category" href="' . esc_url( get_category_link( $category->term_id ) ) . '"  rel="category tag">' . esc_html( $category->cat_name ) . '</a>';
                    }
                }
            $output .= '</div>';
            echo $output;         
		}
	}

}
endif;

if( ! function_exists( 'metro_magazine_sidebar_layout' ) ) :
/**
 * Return sidebar layouts for pages
 */
function metro_magazine_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'metro_magazine_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'metro_magazine_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
    
}
endif;

if( ! function_exists( 'metro_magazine_ads_cb' ) ) :
/**
 * Header Top
 * 
 * @since 1.0.1
*/
function metro_magazine_ads_cb(){
    $ed_header_ad = get_theme_mod( 'metro_magazine_ed_header_ad' ); //from customizer
    $ad_img       = get_theme_mod( 'metro_magazine_header_ad' ); //from customizer
    $ad_link      = get_theme_mod( 'metro_magazine_header_ad_link' ); //from customizer
    $ad_image     = wp_get_attachment_image_src( $ad_img, 'full' );
    $target       = get_theme_mod( 'metro_magazine_open_link_diff_tab', '1' ) ? 'target="_blank"' : '';
    if( $ed_header_ad && $ad_img ){ ?>
        <div class="advertise">
        	<?php if( $ad_link ) echo '<a href="' . esc_url( $ad_link ) . '" ' . $target . '>'; ?>
                <img src="<?php echo esc_url( $ad_image[0] ); ?>"  />
            <?php if( $ad_link ) echo '</a>'; ?>
        </div>
        <?php 
    } 
}
endif; 
add_action( 'metro_magazine_ads', 'metro_magazine_ads_cb' );
 
if( ! function_exists( 'metro_magazine_social_link_cb' ) ) :
/**
 * Header Top
 * 
 * @since 1.0.1
*/
function metro_magazine_social_link_cb(){
	
  $metro_magazine_button_url_fb = get_theme_mod( 'metro_magazine_facebook' );
  $metro_magazine_button_url_tw = get_theme_mod( 'metro_magazine_twitter' );
  $metro_magazine_button_url_ln = get_theme_mod( 'metro_magazine_linkedin' );
  $metro_magazine_button_url_ins = get_theme_mod( 'metro_magazine_instagram' );
  $metro_magazine_button_url_gp = get_theme_mod( 'metro_magazine_google' );
  $metro_magazine_button_url_pin = get_theme_mod( 'metro_magazine_pinterest' );
  

  ?>

	<ul class="social-networks">
		 <?php if( $metro_magazine_button_url_fb ){?>
		<li><a href="<?php echo esc_url( $metro_magazine_button_url_fb ) ?>"><i class="fa fa-facebook"></i></a></li>
		<?php } if( $metro_magazine_button_url_tw ){?>
		<li><a href="<?php echo esc_url( $metro_magazine_button_url_tw ) ?>"><i class="fa fa-twitter"></i></a></li>
		<?php } if( $metro_magazine_button_url_ln ){?>
		<li><a href="<?php echo esc_url( $metro_magazine_button_url_ln ) ?>"><i class="fa fa-linkedin"></i></a></li>
		<?php } if( $metro_magazine_button_url_ins ){?>
		<li><a href="<?php echo esc_url( $metro_magazine_button_url_ins ) ?>"><i class="fa fa-instagram"></i></a></li>
		<?php } if( $metro_magazine_button_url_gp ){?>
		<li><a href="<?php echo esc_url( $metro_magazine_button_url_gp ) ?>"><i class="fa fa-google-plus"></i></a></li>
		<?php } if( $metro_magazine_button_url_pin ){?>
		<li><a href="<?php echo esc_url( $metro_magazine_button_url_pin ) ?>"><i class="fa fa-pinterest"></i></a></li>
		<?php } ?>
	</ul>

<?php } 
endif; 
add_action( 'metro_magazine_social_link', 'metro_magazine_social_link_cb' );

add_filter( 'get_the_archive_title', 'metro_magazine_get_the_archive_title' );
if( ! function_exists( ' metro_magazine_get_the_archive_title' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function  metro_magazine_get_the_archive_title( $title ){

    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = get_the_author() ;
    }	else {
    	$title = ( single_month_title(' ',false) ); 
    }
return $title;
}
endif;


if( ! function_exists( 'metro_magazine_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function metro_magazine_change_comment_form_default_fields( $fields ){
    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );    
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><input id="author" name="author" placeholder="' . esc_attr__( 'Name*', 'metro-magazine' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><input id="email" name="email" placeholder="' . esc_attr__( 'Email*', 'metro-magazine' ) . '" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'metro-magazine' ) . '" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;
    
}
endif;
add_filter( 'comment_form_default_fields', 'metro_magazine_change_comment_form_default_fields' );

if( ! function_exists( 'metro_magazine_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function metro_magazine_change_comment_form_defaults( $defaults ){
    
    // Change the "cancel" to "I would rather not comment" and use a span instead
    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'metro-magazine' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>';
    
    $defaults['label_submit'] = esc_attr__( 'Submit', 'metro-magazine' );
    
    return $defaults;
    
}
endif;
add_filter( 'comment_form_defaults', 'metro_magazine_change_comment_form_defaults' );
