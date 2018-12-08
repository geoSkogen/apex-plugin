<?php

class Apex_API {

	/**

	 * Add routes

	 */

	public function add_routes( ) {

		register_rest_route( 'apex-api/v1', '/settings',

			array(

				'methods'         => 'POST',

				'callback'        => array( $this, 'update_settings' ),

				'args' => array(

					'industry' => array(

						'type' => 'string',

						'required' => false,

						'sanitize_callback' => 'sanitize_text_field'

					),

					'amount' => array(

						'type' => 'integer',

						'required' => false,

						'sanitize_callback' => 'absint'

					)

				),

				'permissions_callback' => array( $this, 'permissions' )

			)

		);

		register_rest_route( 'apex-api/v1', '/settings',

			array(

				'methods'         => 'GET',

				'callback'        => array( $this, 'get_settings' ),

				'args'            => array(

				),

				'permissions_callback' => array( $this, 'permissions' )

			)

		);

	}

	/**

	 * Check request permissions

	 *

	 * @return bool

	 */

	public function permissions(){

		return current_user_can( 'manage_options' );

	}

	/**

	 * Update settings

	 *

	 * @param WP_REST_Request $request

	 */

	public function update_settings( WP_REST_Request $request ){

		$settings = array(

			'industry' => $request->get_param( 'industry' ),

			'amount' => $request->get_param( 'amount' )

		);

		Apex_Settings::save_settings( $settings );

		return rest_ensure_response( Apex_Settings::get_settings())->set_status( 201 );

	}

	/**

	 * Get settings via API

	 *

	 * @param WP_REST_Request $request

	 */

	public function get_settings( WP_REST_Request $request ){

		return rest_ensure_response( Apex_Settings::get_settings());

	}

}
