<?php
/**
 * Plugin Name: Title to Titletag
 * Description: Use Media Gallery title as title tag in images.
 * Plugin URI:  https://qanva.tech/title-to-titletag
 * Version:     1.0.0
 * Author:      qanva.tech, ukischkel
 * Author URI:  https://qanva.tech
 * License:		GPL v2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: title-to-titletag
 * Domain Path: languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

	add_action( 'plugins_loaded', 'ladesprachdateifuertitletag' );

		function ladesprachdateifuertitletag() {
			load_plugin_textdomain( 'title-to-titletag', false, dirname( plugin_basename(__FILE__) ) . '/languages' ); 
		} 
		
		$qanvatexteffectsdescription = __( "Use Media Gallery title as title tag in images.", "title-to-titletag" );

	class Titletagfromtitlefield{			
		const MINIMUM_PHP_VERSION = '7.0';

		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'titletagbasicinit' ) );
			add_filter( 'wp_get_attachment_image', array( $this, 'titletoimagetitle' ), 15, 2 );
		}
		
		/** read title and rewrite img tag **/
		public function titletoimagetitle( $html, $id ) {
			$titletag_attach = get_post( $id );
			if ( strpos( $html, "title=" ) ) {
					return $html;
				}
				else {
				$titletagTitle = esc_attr( $titletag_attach -> post_title );
				return str_replace( '<img', '<img title="' . $titletagTitle . '" '  , $html );      
			}
		}
		
			public function titletagbasicinit() {
				if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
					add_action( 'admin_notices', array( $this, 'titletagadminnoticeminimumphpversion' ) );
					return;
				}
			}

			public function titletagadminnoticeminimumphpversion() {
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}

				$message = sprintf(
					esc_html__( '"%1$s" requires %2$s version %3$s or greater.', 'title-to-titletag' ),
					'<strong>' . esc_html__( 'Title to Titletag', 'title-to-titletag' ) . '</strong>',
					'<strong>' . esc_html__( 'PHP', 'title-to-titletag' ) . '</strong>',
					self::MINIMUM_PHP_VERSION
				);

				printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			}
    }
	

		new Titletagfromtitlefield();
	 
