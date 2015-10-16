<?php

/**
 * Included file to display admin options
 */


WpSolrExtensions::require_once_wpsolr_extension( WpSolrExtensions::OPTION_INDEXES, true );

// Options name
$option_name = OptionIndexes::get_option_name( WpSolrExtensions::OPTION_INDEXES );

// Options object
$option_object = new OptionIndexes();

?>

<?php
WpSolrExtensions::require_once_wpsolr_extension( WpSolrExtensions::OPTION_MANAGED_SOLR_SERVERS, true );
$is_submit_form_temporary_account = isset( $_POST['submit_form_temporary_account'] );
$form_data                        = WpSolrExtensions::extract_form_data( $is_submit_form_temporary_account, array(
		'managed_solr_service_id' => array( 'default_value' => '', 'can_be_empty' => false )
	)
);
if ( isset( $_POST['submit_form_temporary_account'] ) ) {

	$managed_solr_server = new OptionManagedSolrServer( $form_data['managed_solr_service_id']['value'] );
	$response_object     = $managed_solr_server->call_rest_create_solr_index();

	if ( isset( $response_object ) && OptionManagedSolrServer::is_response_ok( $response_object ) ) {

		$option_object->create_index(
			'free index',
			OptionManagedSolrServer::get_response_result( $response_object, 'urlScheme' ),
			OptionManagedSolrServer::get_response_result( $response_object, 'urlDomain' ),
			OptionManagedSolrServer::get_response_result( $response_object, 'urlPort' ),
			'/' . OptionManagedSolrServer::get_response_result( $response_object, 'urlPath' ) . '/' . OptionManagedSolrServer::get_response_result( $response_object, 'urlCore' ),
			OptionManagedSolrServer::get_response_result( $response_object, 'key' ),
			OptionManagedSolrServer::get_response_result( $response_object, 'secret' )
		);
	}
}

?>

<div id="solr-hosting-tab">

	<?php

	// Options data. Loaded after the POST, to be sure it contains the posted data.
	$option_data = OptionIndexes::get_option_data( WpSolrExtensions::OPTION_INDEXES );

	$subtabs = array();

	// Create the tabs from the Solr indexes already configured
	foreach ( $option_object->get_indexes() as $index_indice => $index ) {
		$subtabs[ $index_indice ] = isset( $index['index_name'] ) ? $index['index_name'] : 'Index with no name';
	}

	$subtabs['new_index'] = 'Configure another index';

	// Create subtabs on the left side
	$subtab = wpsolr_admin_sub_tabs( $subtabs );

	?>

	<div id="solr-results-options" class="wdm-vertical-tabs-content">

		<?php
		$is_new_index = false;
		if ( 'new_index' === $subtab ) {
			$is_new_index                           = true;
			$subtab                                 = $option_object->generate_uuid();
			$option_data['solr_indexes'][ $subtab ] = array();

			WpSolrExtensions::require_with( WpSolrExtensions::get_option_template_file( WpSolrExtensions::OPTION_MANAGED_SOLR_SERVERS, 'template-temporary-account-form.php' ),
				array(
					'managed_solr_service_id' => $form_data['managed_solr_service_id']['value'],
					'response_error'          => ( isset( $response_object ) && ! OptionManagedSolrServer::is_response_ok( $response_object ) ) ? OptionManagedSolrServer::get_response_error_message( $response_object ) : '',
				) );

		} else {
			// Verify that current subtab is a Solr index indice.
			if ( ! $option_object->has_index( $subtab ) ) {
				// Use the first subtab element
				$subtab = key( $subtabs );
			}

		}

		?>

		<form action="options.php" method="POST" id='settings_conf_form'>

			<?php
			settings_fields( $option_name );
			?>

			<!--  <div class="wdm_heading wrapper"><h3>Configure Solr</h3></div>-->
			<input type='hidden' id='adm_path' value='<?php echo admin_url(); ?>'>

			<?php
			foreach ( ( isset( $option_data['solr_indexes'] ) ? $option_data['solr_indexes'] : array() ) as $index_indice => $index ) {
				?>
				<div
					id="<?php echo $subtab != $index_indice ? $index_indice : "current_index_configuration_edited_id" ?>"
					class="wrapper" <?php echo $subtab != $index_indice ? "style='display:none'" : "" ?> >
					<h4 class='head_div'>Manually configure my existing Solr index</h4>

					<div class="wdm_row">
						<div class='solr_error'></div>
					</div>

					<div class="wdm_row">
						<div class='col_left'>Index name</div>

						<div class='col_right'><input type='text'
						                              placeholder="Give a name to your index"
						                              name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_name]"
								<?php echo $subtab === $index_indice ? "id='index_name'" : "" ?>
								                      value="<?php echo empty( $option_data['solr_indexes'][ $index_indice ]['index_name'] ) ? '' : $option_data['solr_indexes'][ $index_indice ]['index_name']; ?>">

							<div class="clear"></div>
							<span class='name_err'></span>
						</div>
						<div class="clear"></div>
					</div>

					<div class="wdm_row">
						<div class='col_left'>Solr Protocol</div>

						<div class='col_right'>
							<select
								name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_protocol]"
								<?php echo $subtab === $index_indice ? "id='index_protocol'" : "" ?>
								>
								<option value='http'
									<?php selected( 'http', empty( $option_data['solr_indexes'][ $index_indice ]['index_protocol'] ) ? 'http' : $option_data['solr_indexes'][ $index_indice ]['index_protocol'] ) ?>
									>http
								</option>
								<option value='https'
									<?php selected( 'https', empty( $option_data['solr_indexes'][ $index_indice ]['index_protocol'] ) ? 'http' : $option_data['solr_indexes'][ $index_indice ]['index_protocol'] ) ?>
									>https
								</option>

							</select>

							<div class="clear"></div>
							<span class='protocol_err'></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="wdm_row">
						<div class='col_left'>Solr Host</div>

						<div class='col_right'>
							<input type='text'
							       placeholder="localhost or ip adress or hostname. No 'http', no '/', no ':'"
							       name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_host]"
								<?php echo $subtab === $index_indice ? "id='index_host'" : "" ?>
								   value="<?php echo empty( $option_data['solr_indexes'][ $index_indice ]['index_host'] ) ? '' : $option_data['solr_indexes'][ $index_indice ]['index_host']; ?>">

							<div class="clear"></div>
							<span class='host_err'></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="wdm_row">
						<div class='col_left'>Solr Port</div>
						<div class='col_right'>
							<input type="text"
							       placeholder="8983 or 443 or any other port"
							       name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_port]"
								<?php echo $subtab === $index_indice ? "id='index_port'" : "" ?>
								   value="<?php echo empty( $option_data['solr_indexes'][ $index_indice ]['index_port'] ) ? '' : $option_data['solr_indexes'][ $index_indice ]['index_port']; ?>">

							<div class="clear"></div>
							<span class='port_err'></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="wdm_row">
						<div class='col_left'>Solr Path</div>
						<div class='col_right'>
							<input type='text'
							       placeholder="For instance /solr/index_name. Begins with '/', no '/' at the end"
							       name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_path]"
								<?php echo $subtab === $index_indice ? "id='index_path'" : "" ?>
								   value="<?php echo empty( $option_data['solr_indexes'][ $index_indice ]['index_path'] ) ? '' : $option_data['solr_indexes'][ $index_indice ]['index_path']; ?>">

							<div class="clear"></div>
							<span class='path_err'></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="wdm_row">
						<div class='col_left'>Key</div>
						<div class='col_right'>
							<input type='text'
							       placeholder="Optional security user if the index is protected with Http Basic Authentication"
							       name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_key]"
								<?php echo $subtab === $index_indice ? "id='index_key'" : "" ?>
								   value="<?php echo empty( $option_data['solr_indexes'][ $index_indice ]['index_key'] ) ? '' : $option_data['solr_indexes'][ $index_indice ]['index_key']; ?>">

							<div class="clear"></div>
							<span class='key_err'></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="wdm_row">
						<div class='col_left'>Secret</div>
						<div class='col_right'>
							<input type='text'
							       placeholder="Optional security password if the index is protected with Http Basic Authentication"
							       name="<?php echo $option_name ?>[solr_indexes][<?php echo $index_indice ?>][index_secret]"
								<?php echo $subtab === $index_indice ? "id='index_secret'" : "" ?>
								   value="<?php echo empty( $option_data['solr_indexes'][ $index_indice ]['index_secret'] ) ? '' : $option_data['solr_indexes'][ $index_indice ]['index_secret']; ?>">

							<div class="clear"></div>
							<span class='sec_err'></span>
						</div>
						<div class="clear"></div>
					</div>

				</div>
			<?php } // end foreach ?>

			<div class="wdm_row">
				<div class="submit">
					<input name="check_solr_status" id='check_index_status' type="button"
					       class="button-primary wdm-save"
					       value="Check Solr Status, then Save this configuration"/> <span><img
							src='<?php echo plugins_url( '../../../images/gif-load_cir.gif', __FILE__ ) ?>'
							style='height:18px;width:18px;margin-top: 10px;display: none'
							class='img-load'>

                                             <img
	                                             src='<?php echo plugins_url( '../../../images/success.png', __FILE__ ) ?>'
	                                             style='height:18px;width:18px;margin-top: 10px;display: none'
	                                             class='img-succ'/>
                                                <img
	                                                src='<?php echo plugins_url( '../../../images/warning.png', __FILE__ ) ?>'
	                                                style='height:18px;width:18px;margin-top: 10px;display: none'
	                                                class='img-err'/></span>
				</div>

				<?php if ( ! $is_new_index ) { ?>
					<input name="delete_index_configuration" id='delete_index_configuration' type="button"
					       class="button-secondary wdm-delete"
					       value="Delete this configuration"/>
				<?php } // end if ?>

			</div>
			<div class="clear"></div>

		</form>
	</div>

</div>
