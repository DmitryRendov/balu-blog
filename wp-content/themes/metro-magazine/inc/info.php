<?php
/**
 * Metro Magazine Theme Info
 *
 * @package Metro_Magazine
 */

function metro_magazine_customizer_theme_info( $wp_customize ) {
	
    $wp_customize->add_section( 'theme_info' , array(
		'title'       => __( 'Information Links' , 'metro-magazine' ),
		'priority'    => 6,
		));

	$wp_customize->add_setting('theme_info_theme',array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		));
    
    $theme_info = '';
	$theme_info .= '<h3 class="sticky_title">' . __( 'Need help?', 'metro-magazine' ) . '</h3>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View demo', 'metro-magazine' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/previews/?theme=metro-magazine' ) . '" target="_blank">' . __( 'here', 'metro-magazine' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View documentation', 'metro-magazine' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/documentation/metro-magazine/' ) . '" target="_blank">' . __( 'here', 'metro-magazine' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme info', 'metro-magazine' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/wordpress-themes/metro-magazine/' ) . '" target="_blank">' . __( 'here', 'metro-magazine' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support ticket', 'metro-magazine' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/support-ticket/' ) . '" target="_blank">' . __( 'here', 'metro-magazine' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Rate this theme', 'metro-magazine' ) . ': </label><a href="' . esc_url( 'https://wordpress.org/support/theme/metro-magazine/reviews' ) . '" target="_blank">' . __( 'here', 'metro-magazine' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="more-detail row-element">' . __( 'More WordPress Themes', 'metro-magazine' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/wordpress-themes/' ) . '" target="_blank">' . __( 'here', 'metro-magazine' ) . '</a></span><br />';
	

	$wp_customize->add_control( new Metro_Magazine_Theme_Info( $wp_customize ,'theme_info_theme',array(
		'label' => __( 'About Metro Magazine' , 'metro-magazine' ),
		'section' => 'theme_info',
		'description' => $theme_info
		)));

	$wp_customize->add_setting('theme_info_more_theme',array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		));

}
add_action( 'customize_register', 'metro_magazine_customizer_theme_info' );


if( class_exists( 'WP_Customize_control' ) ){

	class Metro_Magazine_Theme_Info extends WP_Customize_Control
	{
    	/**
       	* Render the content on the theme customizer page
       	*/
       	public function render_content()
       	{
       		?>
       		<label>
       			<strong class="customize-text_editor"><?php echo esc_html( $this->label ); ?></strong>
       			<br />
       			<span class="customize-text_editor_desc">
       				<?php echo wp_kses_post( $this->description ); ?>
       			</span>
       		</label>
       		<?php
       	}
    }//editor close
    
}//class close
