<?php
/**
 * WP Budget Slider
 *
 * @package     WP Budget Slider
 * @author      Cyberpunk Interactive
 * @copyright   2020 Cyberpunk Interactive
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: WP Budget Slider
 * Plugin URI:  https://cyberpunkinteractive.com
 * Description: Standard WP Budget Slider
 * Version:     0.1
 * Author:      Cyberpunk Interactive
 * Author URI:  https://cyberpunkinteractive.com
 * Text Domain: wpbudgetslider
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */



require_once(plugin_dir_path(__FILE__) . 'classes/WPBudgetSlider.Class.php');

$wpBudgetSlider = new WPBudgetSlider();
register_activation_hook(__FILE__, [$wpBudgetSlider, 'pluginRequirementsCheck']);
