<?php
/**
 * Overwritten functions
 *
 */

/**
 * Footer Credits
 *
 */
function metro_magazine_footer_credit(){
    echo '<div class="footer-b">';
        echo '<div class="container">';
            echo '<div class="site-info">';
                esc_html_e( '&copy;&nbsp;', 'metro-magazine' );
                echo esc_html( date_i18n( 'Y' ), 'metro-magazine' );
                esc_html_e( '&nbsp;', 'metro-magazine' );
                echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( 'Anna Filipova' ) . '</a>';
                esc_html_e( '.&nbsp;', 'metro-magazine' );
                printf( esc_html__( '%s', 'metro-magazine' ), 'Шаблон <noindex><a href="'. esc_url( __( 'http://raratheme.com/wordpress-themes/metro-magazine/', 'metro-magazine' ) ) .'" rel="nofollow" target="_blank">'. esc_html__( 'Metro Magazine', 'metro-magazine' ) .'</a>. ' );
                printf( esc_html__( 'Powered by %s', 'metro-magazine' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'metro-magazine' ) ) .'"  rel="nofollow" target="_blank">'. esc_html__( 'WordPress', 'metro-magazine' ) . '</a></noindex>' );
            echo '</div>';
        echo '</div>';
    echo '</div>';
}


?>