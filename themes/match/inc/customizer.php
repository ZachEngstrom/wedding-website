<?php
/**
 * Match Theme Customizer
 *
 * @package Match
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function match_customize_register ( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

	// Theme Options Panel
	$wp_customize->add_panel( 'match_theme_options', array(
	    'title'     => esc_html__( 'Theme Options', 'match' ),
	    'priority'  => 1,
	) );

	// Theme Support Section
	$wp_customize->add_section( 'match_support', array(
		'title'       => esc_html__( 'Theme Support', 'match' ),
		'description' => esc_html__( 'Thanks for your interest in Match! If you have any questions or run into any trouble, please visit us the following links. We will get you fixed up!', 'match' ),
		'panel'       => 'match_theme_options',
		'priority'    => 1,
	) );

	// Theme
	$wp_customize->add_setting ( 'match_theme_about', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Match_Button_Control(
			$wp_customize,
			'match_theme_about',
			array(
				'label'         => esc_html__( 'Match Theme', 'match' ),
				'section'       => 'match_support',
				'type'          => 'button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'http://dovethemes.com/match-lite/',
				'button_target' => '_blank',
			)
		)
	);

	// Support
	$wp_customize->add_setting ( 'match_theme_support', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Match_Button_Control(
			$wp_customize,
			'match_theme_support',
			array(
				'label'         => esc_html__( 'Match Support', 'match' ),
				'section'       => 'match_support',
				'type'          => 'button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'http://dovethemes.com/contact/',
				'button_target' => '_blank',
			)
		)
	);

	// Theme Pro Section
	$wp_customize->add_section( 'match_pro', array(
		'title'       => esc_html__( 'Match Pro', 'match' ),
		'description' => esc_html__( 'Match Pro is premium WordPress theme with priority email support and lot of exciting features. Please visit the link below to know more about Match premium theme.', 'match' ),
		'panel'       => 'match_theme_options',
		'priority'    => 2,
	) );

	// Theme
	$wp_customize->add_setting ( 'match_pro_about', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Match_Button_Control(
			$wp_customize,
			'match_pro_about',
			array(
				'label'         => esc_html__( 'Match Pro', 'match' ),
				'section'       => 'match_pro',
				'type'          => 'button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'http://dovethemes.com/match/',
				'button_target' => '_blank',
			)
		)
	);
}
add_action( 'customize_register', 'match_customize_register' );

/**
 * Button Control Class
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class WP_Match_Button_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'button';

		/**
		 * HTML tag to render button object.
		 *
		 * @var  string
		 */
		protected $button_tag = 'button';

		/**
		 * Class to render button object.
		 *
		 * @var  string
		 */
		protected $button_class = 'button button-primary';

		/**
		 * Link for <a> based button.
		 *
		 * @var  string
		 */
		protected $button_href = 'javascript:void(0)';

		/**
		 * Target for <a> based button.
		 *
		 * @var  string
		 */
		protected $button_target = '';

		/**
		 * Click event handler.
		 *
		 * @var  string
		 */
		protected $button_onclick = '';

		/**
		 * ID attribute for HTML tab.
		 *
		 * @var  string
		 */
		protected $button_tag_id = '';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
			<span class="center">
				<?php
				// Print open tag
				echo '<' . esc_html( $this->button_tag );

				// button class
				if ( ! empty( $this->button_class ) ) {
					echo ' class="' . esc_attr( $this->button_class ) . '"';
				}

				// button or href
				if ( 'button' == $this->button_tag ) {
					echo ' type="button"';
				} else {
					echo ' href="' . esc_url( $this->button_href ) . '"' . ( empty( $this->button_tag ) ? '' : ' target="' . esc_attr( $this->button_target ) . '"' );
				}

				// onClick Event
				if ( ! empty( $this->button_onclick ) ) {
					echo ' onclick="' . esc_js( $this->button_onclick ) . '"';
				}

				// ID
				if ( ! empty( $this->button_tag_id ) ) {
					echo ' id="' . esc_attr( $this->button_tag_id ) . '"';
				}

				echo '>';

				// Print text inside tag
				echo esc_html( $this->label );

				// Print close tag
				echo '</' . esc_html( $this->button_tag ) . '>';
				?>
			</span>
		<?php
		}
	}

}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function match_customize_preview_js() {
	wp_enqueue_script( 'match_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140120', true );
}
add_action( 'customize_preview_init', 'match_customize_preview_js' );
