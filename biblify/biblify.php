<?php
/**
 * Plugin Name: Biblify
 * Plugin URI:
 * Description: Automatically converts Bible references into external bible links
 * Version: 0.1
 * Author: Chris Burgess
 * Author URI:
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or die();

require_once dirname( __FILE__ ) . '/class-biblify.php';

new Biblify();