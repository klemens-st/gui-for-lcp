<?php
/**
 * @package   gui_for_lcp
 * @author    Klemens Starybrat
 * @license   GPL-3.0
 * @link      https://github.com/zymeth25/gui-for-lcp
 * @copyright 2018 Klemens Starybrat
 *
 * @wordpress-plugin
 * Plugin Name:       GUI for List Category Posts
 * Plugin URI:        https://github.com/zymeth25/gui-for-lcp
 * Description:       This plugin adds a graphical shortcode creator for List Category Posts, accessible via the "LCP" button in WordPress editor.
 * Version:           1.0.1
 * Author:            Klemens Starybrat
 * Author URI:        https://github.com/zymeth25
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       gui-for-lcp
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://www.gnu.org/licenses/gpl-3.0.txt.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
 * Current plugin version.
 */
define( 'GUI_FOR_LCP_VERSION', '1.0.1' );

/**
 * The core plugin class that is used to define plugin's hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gflcp.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function gflcp_run() {

  $plugin = new Gflcp();
  $plugin->run();

}
gflcp_run();
