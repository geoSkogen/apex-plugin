<?php

class Apex_Menu {

	/**

	 * Menu slug

	 *

	 * @var string

	 */

	protected $slug = 'apex-menu';

	/**

	 * URL for assets

	 *

	 * @var string

	 */

	protected $assets_url;

	/**

	 * Apex_Menu constructor.

	 *

	 * @param string $assets_url URL for assets

	 */

	public function __construct( $assets_url ) {

		$this->assets_url = $assets_url;

		add_action( 'admin_menu', array( $this, 'add_page' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets' ) );

	}

	/**

	 * Add CF Popup submenu page

	 *

	 * @since 0.0.3

	 *

	 * @uses "admin_menu"

	 */

	public function add_page(){

		add_menu_page(

			__( 'Apex Page', 'text-domain' ),

			__( 'Apex Page', 'text-domain' ),

			'manage_options',

			$this->slug,

			array( $this, 'render_admin' ) );

	}

	/**

	 * Register CSS and JS for page

	 *

	 * @uses "admin_enqueue_scripts" action

	 */

	public function register_assets()

	{

		wp_register_script( $this->slug, $this->assets_url . '/js/admin.js', array( 'jquery' ) );

		//wp_register_style( $this->slug, $this->assets_url . '/css/admin.css' );

		wp_localize_script( $this->slug, 'APEX', array(

			'strings' => array(

				'saved' => __( 'Settings Saved', 'text-domain' ),

				'error' => __( 'Error', 'text-domain' )

			),

			'api'     => array(

				'url'   => esc_url_raw( rest_url( 'apex-api/v1/settings' ) ),

				'nonce' => wp_create_nonce( 'wp_rest' )

			)

		) );

	}

	/**

	 * Enqueue CSS and JS for page

	 */

	public function enqueue_assets(){

		if( ! wp_script_is( $this->slug, 'registered' ) ){

			$this->register_assets();

		}

		wp_enqueue_script( $this->slug );

		wp_enqueue_style( $this->slug );

	}

	/**

	 * Render plugin admin page

	 */

   public function render_admin(){

   		$this->enqueue_assets();

   		?>

   		<form id="apex-form">

   			<div id="feedback">

   			</div>

   			<div>

   				<label for="industry">

   					<?php esc_html_e( 'Industry', 'text-domain' ); ?>

   				</label>

   				<input id="industry" type="text" />

   			</div>

   			<div>

   				<label for="amount">

   					<?php esc_html_e( 'Amount', 'text-domain' ); ?>

   				</label>

   				<input id="amount" type="number" min="0" max="100" />

   			</div>

   			<?php submit_button( __( 'Save', 'text-domain' ) ); ?>

   		</form>


   		<?php

   	}

}
