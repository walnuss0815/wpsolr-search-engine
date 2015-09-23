<?php
/**
 * Plugin Name: Apache Solr search by WPSOLR
 * Description: Search is the secret weapon of the biggest websites. WPSOLR brings you the same technology, but for free.
 * Version: 5.4
 * Author: WPSOLR.COM
 * Plugin URI: http://www.wpsolr.com
 * License: GPL2
 */

require_once 'ajax_solr_services.php';
require_once 'dashboard_settings.php';
require_once 'autocomplete.php';

/* Include Solr clients */
require_once 'classes/solr/wpsolr-index-solr-client.php';
require_once 'classes/solr/wpsolr-search-solr-client.php';

/* Include the theme api */
require_once 'classes/themes/wpsolr-theme-api.php';

// Define a global WPSOLR theme api object
$wpsolr_theme_api = new WPSolrThemeApi();

/* Register Solr settings from dashboard
 * Add menu page in dashboard - Solr settings
 * Add solr settings- solr host, post and path
 *
 */
add_action( 'wp_head', 'check_default_options_and_function' );
add_action( 'admin_menu', 'fun_add_solr_settings' );
add_action( 'admin_init', 'wpsolr_admin_init' );


/*
 * Display Solr errors in admin when a save on a post can't index to Solr
 */
function solr_post_save_admin_notice() {
	if ( $out = get_transient( get_current_user_id() . 'error_solr_post_save_admin_notice' ) ) {
		delete_transient( get_current_user_id() . 'error_solr_post_save_admin_notice' );
		echo "<div class=\"error\"><p>(WPSOLR) Error while indexing this post/page in Solr:<br><br>$out</p></div>";
	}

	if ( $out = get_transient( get_current_user_id() . 'updated_solr_post_save_admin_notice' ) ) {
		delete_transient( get_current_user_id() . 'updated_solr_post_save_admin_notice' );
		echo "<div class=\"updated\"><p>(WPSOLR) $out</p></div>";
	}

	if ( $out = get_transient( get_current_user_id() . 'wpml_some_languages_have_no_solr_index_admin_notice' ) ) {
		delete_transient( get_current_user_id() . 'wpml_some_languages_have_no_solr_index_admin_notice' );
		echo "<div class=\"error\"><p>(WPSOLR) $out</p></div>";
	}

}

add_action( 'admin_notices', "solr_post_save_admin_notice" );

/*
 * Add/remove document to/from Solr index when status changes to/from published
 * We have to use action 'save_post', as it is used by other plugins to trigger meta boxes save
 */
function add_remove_document_to_solr_index( $post_id, $post, $update ) {

	// If this is just a revision, don't go on.
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// If this is just a new post opened in editor, don't go on.
	if ( 'auto-draft' == $post->post_status ) {
		return;
	}

	try {
		if ( 'publish' == $post->post_status ) {
			// post published, add/update it from Solr index

			$solr = WPSolrIndexSolrClient::create();

			$solr->index_data( 1, $post );

			// Display confirmation in admin
			set_transient( get_current_user_id() . 'updated_solr_post_save_admin_notice', 'Post/page indexed in Solr' );

		} else {
			// post unpublished, remove it from Solr index
			$solr = WPSolrIndexSolrClient::create();

			$solr->delete_document( $post );

			// Display confirmation in admin
			set_transient( get_current_user_id() . 'updated_solr_post_save_admin_notice', 'Post/Page deleted from Solr' );
		}

	} catch ( Exception $e ) {
		set_transient( get_current_user_id() . 'error_solr_post_save_admin_notice', htmlentities( $e->getMessage() ) );
	}

}

add_action( 'save_post', 'add_remove_document_to_solr_index', 10, 3 );

/*
 * Add an attachment to Solr
 */
add_action( 'add_attachment', 'add_attachment_to_solr_index', 10, 3 );
function add_attachment_to_solr_index( $attachment_id ) {

	// Index the new attachment
	try {
		$solr = WPSolrIndexSolrClient::create();

		$solr->index_data( 1, get_post( $attachment_id ) );

		set_transient( get_current_user_id() . 'updated_solr_post_save_admin_notice', 'Attachment added to Solr' );

	} catch ( Exception $e ) {

		set_transient( get_current_user_id() . 'error_solr_post_save_admin_notice', htmlentities( $e->getMessage() ) );
	}

}

/*
 * Delete an attachment from Solr
 */
add_action( 'delete_attachment', 'delete_attachment_to_solr_index', 10, 3 );
function delete_attachment_to_solr_index( $attachment_id ) {

	// Remove the attachment from Solr index
	try {
		$solr = WPSolrIndexSolrClient::create();

		$solr->delete_document( get_post( $attachment_id ) );

		set_transient( get_current_user_id() . 'updated_solr_post_save_admin_notice', 'Attachment deleted from Solr' );

	} catch ( Exception $e ) {

		set_transient( get_current_user_id() . 'error_solr_post_save_admin_notice', htmlentities( $e->getMessage() ) );
	}

}


/* Replace WordPress search
 * Default WordPress will be replaced with Solr search
 */


function check_default_options_and_function() {
	global $wpsolr_theme_api;

	if ( ! $wpsolr_theme_api->has_search_form_template() ) {

		add_filter( 'get_search_form', 'solr_search_form' );

	}
}


/* Create default page template for search results
*/
add_shortcode( 'solr_search_shortcode', 'fun_search_indexed_data' );
add_shortcode( 'solr_form', 'fun_dis_search' );
function fun_dis_search() {
	echo solr_search_form();
}


register_activation_hook( __FILE__, 'my_register_activation_hook' );
function my_register_activation_hook() {

	/*
	 * Migrate old data on plugin update
	 */
	WpSolrExtensions::require_once_wpsolr_extension( WpSolrExtensions::OPTION_INDEXES, true );
	$option_object = new OptionIndexes();
	$option_object->migrate_data_from_v4_9();
}


add_action( 'admin_notices', 'curl_dependency_check' );
function curl_dependency_check() {
	if ( ! in_array( 'curl', get_loaded_extensions() ) ) {

		echo "<div class='updated'><p><b>cURL</b> is not installed on your server. In order to make <b>'Solr for WordPress'</b> plugin work, you need to install <b>cURL</b> on your server </p></div>";
	}


}

function solr_search_form() {
	global $wpsolr_theme_api;

	$ad_url = admin_url();

	$search_que = isset( $_GET['search'] ) ? $_GET['search'] : '';

	// Get localization options
	$localization_options = OptionLocalization::get_options();

	$wdm_typehead_request_handler = 'wdm_return_solr_rows';

	$get_page_info = $wpsolr_theme_api->get_search_page();
	$ajax_nonce    = wp_create_nonce( "nonce_for_autocomplete" );


	$url = get_permalink( $get_page_info->ID );
	// Filter the search page url. Used for multi-language search forms.
	$url = apply_filters( WpSolrFilters::WPSOLR_FILTER_SEARCH_PAGE_URL, $url, $get_page_info->ID );

	$form = "<div class='cls_search' style='width:100%'><form action='$url' method='get'  class='search-frm2' >";
	$form .= '<input type="hidden" value="' . $wdm_typehead_request_handler . '" id="path_to_fold">';
	$form .= '<input type="hidden"  id="ajax_nonce" value="' . $ajax_nonce . '">';

	$form .= '<input type="hidden" value="' . $ad_url . '" id="path_to_admin">';
	$form .= '<input type="hidden" value="' . $search_que . '" id="search_opt">';

	$form .= '
       <div class="ui-widget search-box">
 	<input type="hidden"  id="ajax_nonce" value="' . $ajax_nonce . '">
        <input type="text" placeholder="' . OptionLocalization::get_term( $localization_options, 'search_form_edit_placeholder' ) . '" value="' . $search_que . '" name="search" id="search_que" class="search-field sfl1" autocomplete="off"/>
	<input type="submit" value="' . OptionLocalization::get_term( $localization_options, 'search_form_button_label' ) . '" id="searchsubmit" style="position:relative;width:auto">
        <div style="clear:both"></div>
        </div>
	</div>
       </form>';


	return $form;

}

add_action( 'plugins_loaded', 'my_plugins_loaded' );
function my_plugins_loaded() {
	/*
	global $g_wpsolr_extensions;

	// Load active extensions
	if ( ! isset( $g_wpsolr_extensions ) ) {
		$g_wpsolr_extensions = new WpSolrExtensions();
	}
	*/

	/*
	 * Load WPSOLR text domain to the Wordpress languages plugin directory (WP_LANG_DIR/plugins)
	 * Copy your .mo files there
	 * Example: /htdocs/wp-includes/languages/plugins/wpsolr-fr_FR.mo or /htdocs/wp-content/languages/plugins/wpsolr-fr_FR.mo
	 * You can find our template file in this plugin's /languages/wpsolr.pot file
	 */
	load_plugin_textdomain( 'wpsolr', false, false );
}

