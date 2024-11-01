<?php
/**
 * @package YD_WPML-Switcher
 * @author Yann Dubois
 * @version 0.1.4
 */

/*
 Plugin Name: YD WPML Switcher
 Plugin URI: http://www.yann.com/en/wp-plugins/yd-wpml-switcher
 Description: Turn WPML language filters off on certain pages. | Funded by <a href="http://www.wellcom.fr">Wellcom</a>
 Version: 0.1.4
 Author: Yann Dubois
 Author URI: http://www.yann.com/
 License: GPL2
 */

/**
 * @copyright 2010  Yann Dubois  ( email : yann _at_ abc.fr )
 *
 *  Original development of this plugin was kindly funded by http://www.abc.fr
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 Revision 0.1.0:
 - Original beta release
 Revision 0.1.1:
 - Better regexp
 Revision 0.1.2:
 - Option page
 - Debug mode
 - Disable backlink in blog footer
 - New template function: get_cat_in_all_languages()
 - Checked WP 3.0.4 compatibility
 Revision 0.1.3:
 - disable get_terms filter
 - disable getarchives filter
 Revision 0.1.4:
 - bugfix (language selection in article admin)
 */

include_once( 'inc/yd-widget-framework.inc.php' );

/**
 * 
 * Just fill up necessary settings in the configuration array
 * to create a new custom plugin instance...
 * 
 */
$junk = new YD_Plugin( 
	array(
		'name' 				=> 'YD WPML Switcher',
		'version'			=> '0.1.3',
		'has_option_page'	=> true,
		'has_shortcode'		=> false,
		'has_widget'		=> false,
		'widget_class'		=> '',
		'has_cron'			=> false,
		'crontab'			=> array(
			'daily'			=> array( 'YD_MiscWidget', 'daily_update' ),
			'hourly'		=> array( 'YD_MiscWidget', 'hourly_update' )
		),
		'has_stylesheet'	=> false,
		'stylesheet_file'	=> 'css/yd.css',
		'has_translation'	=> false,
		'translation_domain'=> '', // must be copied in the widget class!!!
		'translations'		=> array(
			array( 'English', 'Yann Dubois', 'http://www.yann.com/' ),
			array( 'French', 'Yann Dubois', 'http://www.yann.com/' )
		),		
		'initial_funding'	=> array( 'Wellcom', 'http://www.wellcom.fr' ),
		'additional_funding'=> array(),
		'form_blocks'		=> array(
			'Main options' => array( 
				'debug_mode'	=> 'bool' 
			)
		),
		'option_field_labels'=>array(
				'debug_mode'	=> 'Debug mode'
		),
		'option_defaults'	=> array(
				'debug_mode'	=> 0
		),
		'form_add_actions'	=> array(
				//'Manually run hourly process'	=> array( 'YD_MiscWidget', 'hourly_update' ),
				//'Check latest'					=> array( 'YD_MiscWidget', 'check_update' )
		),
		'has_cache'			=> false,
		'option_page_text'	=> 'Welcome to the WPML Switcher Plugin Settings page',
		'backlinkware_text' => '<!--Features WPML Switcher plugin by YD Wordpress Developer-->',
		'plugin_file'		=> __FILE__		
 	)
);

add_action('plugins_loaded', array( 'YD_WPMLSwitcher', 'check_switch' ), 100);

/**
 * 
 * You must specify a unique class name
 * to avoid collision with other plugins...
 * 
 */
class YD_WPMLSwitcher {
	
	public $option_key = 'yd-wpml-switcher';
	
	function &getInstance() {
		static $obj;
		if (!isset($obj)) {
			$obj =&new YD_WPMLSwitcher;
		}
		return $obj;
	}
	
	function check_switch() {
		if( !is_admin() && !preg_match( '|^/[a-z]{2}/|', $_SERVER['REQUEST_URI'] ) ) self::deactivate();
	}

	function yd_add_footer() {
		$options = get_option( $this->option_key );
		if( $options['debug_mode'] ) {
			echo '<p style="text-align:center" class="yd_debugmsg"><small style="color:#F00;">' 
				. $this->msg . '</small></p>';
		}
	}

	function deactivate() {
		//if( preg_match( '|/[a-z]{2}/?$|', $_SERVER['REQUEST_URI'] ) ) return;
		//echo 'uri: ' . $_SERVER['REQUEST_URI'] . '<br/>';
		global $sitepress;
		global $wp_filter;
		$tag = 'wp_head';
		//echo get_class( $sitepress ) . '<br/>';
		$ins = self::getInstance();
		$ins->msg = 'WPML désactivé';
		add_action( 'wp_footer', array( &$ins, 'yd_add_footer' ) );
		foreach( $wp_filter as $tag => $val ) {
			//echo 'tag: ' . $tag . '<br/>';
			if( false || 
				$tag == 'posts_join' || 
				$tag == 'posts_where' || 
				$tag == 'getarchives_join' || 
				$tag == 'getarchives_where' ||
				$tag == 'get_terms' ||
				$tag == 'list_terms_exclusions' ||
				//$tag == 'term_links-category' ||
				//$tag == 'get_term' ||
				//$tag == 'get_pages' ||
				false
			) {
				foreach( $wp_filter[ $tag ] as $priority => $list ) {
					foreach( $list as $c => $f ) {
						//echo $c . ' - ';
						if( is_array( $f['function'] ) ) {
							//echo $c . ' - array<br/>';
							if( get_class( $f['function'][0] ) == get_class( $sitepress ) ) {
								//echo $tag . ' - ' . $f['function'][1] . ' - ' . $priority . '<br/>';
								$rem = array( &$sitepress, $f['function'][1] );
								$res = remove_filter( $tag, $rem, $priority );
								//echo "remove_action( '$tag', '$f' )<br/>";
								//echo 'res : ' . $res . '<br/>';
							}
						}
					}
				}
			}
		}
	}
	
	function get_cat_in_all_languages( $cat ) {
		global $wpdb;
		$p = $wpdb->prefix;
		//$p = 'wp_17_';
		if( !is_numeric( $cat ) ) {
			$cat_id = get_cat_id( $cat );
		} else {
			$cat_id = $cat;
		}
		$query = "
			SELECT
				b.element_id
			FROM
				${p}icl_translations AS a,
				${p}icl_translations AS b
			WHERE
				a.element_type = 'tax_category'
			AND a.element_id = $cat_id
			AND b.element_type = 'tax_category'
			AND b.trid = a.trid
		";
		$res = $wpdb->get_col( $query );
		return $res; // array
	}

}
?>