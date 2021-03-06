<?php
namespace WPO\WC\PDF_Invoices;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !class_exists( '\\WPO\\WC\\PDF_Invoices\\Settings_Debug' ) ) :

class Settings_Debug {

	function __construct()	{
		add_action( 'admin_init', array( $this, 'init_settings' ) );
		add_action( 'wpo_wcpdf_settings_output_debug', array( $this, 'output' ), 10, 1 );
		add_action( 'wpo_wcpdf_after_settings_page', array( $this, 'debug_tools' ), 10, 2 );
	}

	public function output( $section ) {
		settings_fields( "wpo_wcpdf_settings_debug" );
		do_settings_sections( "wpo_wcpdf_settings_debug" );

		submit_button();
	}

	public function debug_tools( $tab, $section ) {
		if ($tab !== 'debug') {
			return;
		}
		?>
		<form method="post">
			<input type="hidden" name="wpo_wcpdf_debug_tools_action" value="install_fonts">
			<input type="submit" name="submit" id="submit" class="button" value="<?php _e( 'Reinstall fonts', 'woocommerce-pdf-invoices-packing-slips' ); ?>">
			<?php
			if (isset($_POST['wpo_wcpdf_debug_tools_action']) && $_POST['wpo_wcpdf_debug_tools_action'] == 'install_fonts') {
				$font_path = WPO_WCPDF()->main->get_tmp_path( 'fonts' );

				// clear folder first
				if ( function_exists("glob") && $files = glob( $font_path.'/*.*' ) ) {
					$exclude_files = array( 'index.php', '.htaccess' );
					foreach($files as $file) {
						if( is_file($file) && !in_array( basename($file), $exclude_files ) ) {
							unlink($file);
						}
					}
				}

				WPO_WCPDF()->main->copy_fonts( $font_path );
				printf('<div class="notice notice-success"><p>%s</p></div>', __( 'Fonts reinstalled!', 'woocommerce-pdf-invoices-packing-slips' ) );
			}
			?>
		</form>
		<form method="post">
			<input type="hidden" name="wpo_wcpdf_debug_tools_action" value="clear_tmp">
			<input type="submit" name="submit" id="submit" class="button" value="<?php _e( 'Remove temporary files', 'woocommerce-pdf-invoices-packing-slips' ); ?>">
			<?php
			if (isset($_POST['wpo_wcpdf_debug_tools_action']) && $_POST['wpo_wcpdf_debug_tools_action'] == 'clear_tmp') {
				$tmp_path = WPO_WCPDF()->main->get_tmp_path('attachments');

				if ( !function_exists("glob") ) {
					// glob is disabled
					printf('<div class="notice notice-error"><p>%s<br><code>%s</code></p></div>', __( "Unable to read temporary folder contents!", 'woocommerce-pdf-invoices-packing-slips' ), $tmp_path);
				} else {
					$success = 0;
					$error = 0;
					if ( $files = glob($tmp_path.'*.pdf') ) { // get all pdf files
						foreach($files as $file) {
							if(is_file($file)) {
								// delete file
								if ( unlink($file) === true ) {
									$success++;
								} else {
									$error++;
								}
							}
						}

						if ($error > 0) {
							$message =  sprintf( __( 'Unable to delete %d files! (deleted %d)', 'woocommerce-pdf-invoices-packing-slips' ), $error, $success);
							printf('<div class="notice notice-error"><p>%s</p></div>', $message);
						} else {
							$message =  sprintf( __( 'Successfully deleted %d files!', 'woocommerce-pdf-invoices-packing-slips' ), $success );
							printf('<div class="notice notice-success"><p>%s</p></div>', $message);
						}
					} else {
						printf('<div class="notice notice-success"><p>%s</p></div>', __( 'Nothing to delete!', 'woocommerce-pdf-invoices-packing-slips' ) );
					}
				}
			}
			?>
		</form>
		<form method="post">
			<input type="hidden" name="wpo_wcpdf_debug_tools_action" value="delete_legacy_settings">
			<input type="submit" name="submit" id="submit" class="button" value="<?php _e( 'Delete legacy (1.X) settings', 'woocommerce-pdf-invoices-packing-slips' ); ?>">
			<?php
			if (isset($_POST['wpo_wcpdf_debug_tools_action']) && $_POST['wpo_wcpdf_debug_tools_action'] == 'delete_legacy_settings') {
				// delete options
				delete_option( 'wpo_wcpdf_general_settings' );
				delete_option( 'wpo_wcpdf_template_settings' );
				delete_option( 'wpo_wcpdf_debug_settings' );
				// and delete cache of these options, just in case...
				wp_cache_delete( 'wpo_wcpdf_general_settings','options' );
				wp_cache_delete( 'wpo_wcpdf_template_settings','options' );
				wp_cache_delete( 'wpo_wcpdf_debug_settings','options' );

				printf('<div class="notice notice-success"><p>%s</p></div>', __( 'Legacy settings deleted!', 'woocommerce-pdf-invoices-packing-slips' ) );
			}
			?>
		</form>
		<?php
		include( WPO_WCPDF()->plugin_path() . '/includes/views/dompdf-status.php' );
	}

	public function init_settings() {
		// Register settings.
		$page = $option_group = $option_name = 'wpo_wcpdf_settings_debug';

		$settings_fields = array(
			array(
				'type'			=> 'section',
				'id'			=> 'debug_settings',
				'title'			=> __( 'Debug settings', 'woocommerce-pdf-invoices-packing-slips' ),
				'callback'		=> 'section',
			),
			array(
				'type'			=> 'setting',
				'id'			=> 'legacy_mode',
				'title'			=> __( 'Legacy mode', 'woocommerce-pdf-invoices-packing-slips' ),
				'callback'		=> 'checkbox',
				'section'		=> 'debug_settings',
				'args'			=> array(
					'option_name'	=> $option_name,
					'id'			=> 'legacy_mode',
					'description'	=> __( "Legacy mode ensures compatibility with templates and filters from previous versions.", 'woocommerce-pdf-invoices-packing-slips' ),
				)
			),
			array(
				'type'			=> 'setting',
				'id'			=> 'calculate_document_numbers',
				'title'			=> __( 'Calculate document numbers (slow)', 'woocommerce-pdf-invoices-packing-slips' ),
				'callback'		=> 'checkbox',
				'section'		=> 'debug_settings',
				'args'			=> array(
					'option_name'	=> $option_name,
					'id'			=> 'calculate_document_numbers',
					'description'	=> __( "Document numbers (such as invoice numbers) are generated using AUTO_INCREMENT by default. Use this setting if your database auto increments with more than 1.", 'woocommerce-pdf-invoices-packing-slips' ),
				)
			),
			array(
				'type'			=> 'setting',
				'id'			=> 'enable_debug',
				'title'			=> __( 'Enable debug output', 'woocommerce-pdf-invoices-packing-slips' ),
				'callback'		=> 'checkbox',
				'section'		=> 'debug_settings',
				'args'			=> array(
					'option_name'	=> $option_name,
					'id'			=> 'enable_debug',
					'description'	=> __( "Enable this option to output plugin errors if you're getting a blank page or other PDF generation issues", 'woocommerce-pdf-invoices-packing-slips' ) . '<br>' .
									   __( '<b>Caution!</b> This setting may reveal errors (from other plugins) in other places on your site too, therefor this is not recommended to leave it enabled on live sites.', 'woocommerce-pdf-invoices-packing-slips' ),
				)
			),
			array(
				'type'			=> 'setting',
				'id'			=> 'html_output',
				'title'			=> __( 'Output to HTML', 'woocommerce-pdf-invoices-packing-slips' ),
				'callback'		=> 'checkbox',
				'section'		=> 'debug_settings',
				'args'			=> array(
					'option_name'	=> $option_name,
					'id'			=> 'html_output',
					'description'	=> __( 'Send the template output as HTML to the browser instead of creating a PDF.', 'woocommerce-pdf-invoices-packing-slips' ),
				)
			),
			array(
				'type'			=> 'setting',
				'id'			=> 'use_html5_parser',
				'title'			=> __( 'Use alternative HTML5 parser to parse HTML', 'woocommerce-pdf-invoices-packing-slips' ),
				'callback'		=> 'checkbox',
				'section'		=> 'debug_settings',
				'args'			=> array(
					'option_name'	=> $option_name,
					'id'			=> 'use_html5_parser',
				)
			),
		);

		// allow plugins to alter settings fields
		$settings_fields = apply_filters( 'wpo_wcpdf_settings_fields_debug', $settings_fields, $page, $option_group, $option_name );
		WPO_WCPDF()->settings->add_settings_fields( $settings_fields, $page, $option_group, $option_name );
		return;
	}

}

endif; // class_exists

return new Settings_Debug();