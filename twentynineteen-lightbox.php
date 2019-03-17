<?php
/**
 * Plugin Name: Twenty Nineteen Lightbox
 * Plugin URI: http://www.biggee.nl/wordpress-plugins/twentynineteen-lightbox
 * Description: Add lightbox to the Twenty Nineteen theme
 * Version: 1.0
 *
 * Author:      Jan-Paul Kleijn
 * Author URI:  http://www.biggee.nl
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Text Domain: twentynineteen-lightbox
 * Domain Path: /languages
 *
 * @package    Biggee
 * @author     Jan-Paul Kleijn <jan-paul.kleijn@biggee.nl>
 * @since      1.0.0
 * @license    GPL-2.0+
 */

/*  Copyright 2018, Jan-Paul Kleijn (email: jan-paul.kleijn@biggee.nl)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

! defined( 'ABSPATH' ) && exit;

// Plugin folder URL.
if ( ! defined( 'BTNL_PLUGIN_URL' ) ) {
	define( 'BTNL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin directory
if ( ! defined( 'BTNL_PLUGIN_DIR' ) ) {
	define( 'BTNL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

function twentynineteen_lightbox_plugins_loaded() {
  require_once BTNL_PLUGIN_DIR . '/includes/core.php';
 	if ( is_admin() ) {
 	  require_once BTNL_PLUGIN_DIR . '/includes/admin.php';
  }
    load_plugin_textdomain( 'twentynineteen-lightbox', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'twentynineteen_lightbox_plugins_loaded' );
