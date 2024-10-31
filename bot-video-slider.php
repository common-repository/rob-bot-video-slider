<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Rob-Bot Video Slider
 * Plugin URI:        http://robbotdev.com/bot-slider
 * Description:       This is an awesome plugin to insert a 100% responsive video slider into any website!
 * Version:           1.0.1
 * Author:            Rob-Bot Dev Web Consulting
 * Author URI:        http://robbotdev.com.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bot-video-slider
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();
function bxslider_adding_styles() {
wp_register_style('bxslidercss', plugins_url('includes/css/bxslider.css', __FILE__));
wp_enqueue_style('bxslidercss');
}

add_action( 'wp_enqueue_scripts', 'bxslider_adding_styles' );

function bxslider_adding_script3() {
wp_register_script('bxslider_plugin_js', plugins_url('includes/js/plugins/jquery.fitvids.js', __FILE__), array('jquery'), true);

wp_enqueue_script('bxslider_plugin_js');

}
add_action( 'wp_enqueue_scripts', 'bxslider_adding_script3' );

function bxslider_adding_script() {
wp_register_script('bxslider_custom_js', plugins_url('includes/js/bot-script.js', __FILE__), array('jquery'), true);

wp_enqueue_script('bxslider_custom_js');

}
add_action( 'wp_enqueue_scripts', 'bxslider_adding_script' );

function bxslider_adding_scripts() {
wp_register_script('bxslider', plugins_url('includes/js/jquery.bxslider.js', __FILE__), array('jquery'), true);

wp_enqueue_script('bxslider');

}
add_action( 'wp_enqueue_scripts', 'bxslider_adding_scripts' );

  

function add_video ($atts) {
    $atts = shortcode_atts(['url' => '', 'height' => 'auto'

        ], $atts);
    $html = '<li><iframe src="' . $atts['url'] . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>';
    return $html;
}
add_shortcode('video', 'add_video');

function add_slider ($atts, $content='') {
    
    $atts = shortcode_atts(array (
        'align' => 'center',
        'width' => '50%',
        'height' => 'auto'
    ), $atts);
    
    
  /*  foreach($videos as $video) :
             $return.='<li><a href="'.get_permalink().'">'.the_title("","",false).'</a></li>';
        endforeach;
  */
  if( has_shortcode( $content, 'video' ) ) {
      	  $content =  strip_tags($content);           
	        $content = do_shortcode($content);

            if ( $atts[align] == 'center') {
                return ' <style>.bx-wrapper{ width: ' . $atts[width] .'; margin-left: auto; margin-right: auto; }</style><div class="col-xs-12 bot-vid-div" style=" width:100%;"><ul class="bxslider">' . $content . ' </ul> </div>';
            }
            
            elseif ($atts[align] == 'left' ) {
                 return ' <style>.bx-wrapper{ width: ' . $atts[width] .'; margin-right: auto; }</style><div class="col-xs-12 bot-vid-div" style=" width:100%;"><ul class="bxslider">' . $content . ' </ul> </div>';
            }

            elseif ($atts[align] == 'right' ) {
                 return ' <style>.bx-wrapper{ width: ' . $atts[width] .'; margin-left: auto; }</style><div class="col-xs-12 bot-vid-div" style=" width:100%;"><ul class="bxslider">' . $content . ' </ul> </div>';
            }
             
     /*  return ' <style>.bx-wrapper{ width: ' . $atts[width] .'; }</style><div class="col-xs-12 bot-vid-div" style="text-align:'. $atts[align] .'; width:100%;"><ul class="bxslider">' . $content . ' </ul> </div>'; */
}

else {
    return '<ul class="bxslider"> <li> No Videos Found In Slider </li> </ul>';
}

}
add_shortcode('slider','add_slider' );


function enqueue_plugin_scripts($plugin_array)
{
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["bot_slider_button"] =  plugin_dir_url(__FILE__) . "includes/js/bot-button.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, "blue");
    return $buttons;
}
add_filter("mce_buttons", "register_buttons_editor");

add_action('admin_menu', 'robbot_video_plugin_create_menu');

function robbot_video_plugin_create_menu() {

	//create new top-level menu
	add_menu_page('Rob-Bot Video Slider', 'Plugin Settings', 'administrator', __FILE__, 'robbot_video_slider_settings_page' , 'dashicons-slides' );

	//call register settings function
	add_action( 'admin_init', 'register_robbot_plugin_settings' );
}


function register_robbot_plugin_settings() {
	//register our settings
	register_setting( 'robbot_plugin_settings-group', 'new_option_name' );
	register_setting( 'robbot_plugin_settings-group', 'some_other_option' );
	register_setting( 'robbot_plugin_settings-group', 'option_etc' );
}

function robbot_video_slider_settings_page() {
?>

<div class="wrap">
<h1 id="main-option-heading">Rob-Bot Video Slider</h1>
<h2 id="plugin-option-subtext">Welcome! Below are instructions to add videos to any post or page!</h2>
<p id="plugin-option-body">To begin, open the post or page that you would like to add your video to. <br> Then click the video slider button in the visual editor. <br> Finally, edit the url in the shortcode and add your video url to it! <br> You can copy and paste the [video] shortcode as many times as you want to add as many videos as you would like! </p>
<br>
<br>
<br>
<h3 id="options-plugin"> Additional Options Will Be Added In future Updates! <br> <br> You Can Visit The Plugin Homepage <a href="http://robbotdev.com/bot-slider"> Here! </a> </h3>
<br>
<h3> New Features Have Been Added! </h3>
<ul style="list-style-type:circle"> 
    <li> align: you can now choose the alignment of your video slider by editing the shortcodes align field in the text edit view of the post and page editor!  </li>
    <br>
    <li> width: the width of the slider is now adjustable! You can edit this in the text edit mode of the visual editor for both posts and pages. </li>
</ul>



</div>
<?php } ?>