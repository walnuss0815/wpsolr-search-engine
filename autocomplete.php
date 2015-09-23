<?php

// Load WPML class
WpSolrExtensions::load();

function wdm_return_solr_rows() {
	global $wpsolr_theme_api;

	if ( isset( $_POST['security'] )
	     && wp_verify_nonce( $_POST['security'], 'nonce_for_autocomplete' )
	) {

		$input = isset( $_POST['word'] ) ? $_POST['word'] : '';

		if ( '' != $input ) {

			$input = strtolower( $input );

			try {

				$result = $wpsolr_theme_api->get_suggestions( $input );
				echo json_encode( $result );

			} catch ( Exception $e ) {
				echo json_encode(
					array(
						'message' => htmlentities( $e->getMessage() )
					)
				);
			}
		}

	}

	die();
}

add_action( 'wp_ajax_wdm_return_solr_rows', 'wdm_return_solr_rows' );
add_action( 'wp_ajax_nopriv_wdm_return_solr_rows', 'wdm_return_solr_rows' );

