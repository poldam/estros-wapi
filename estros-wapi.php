<?php
/**
 * Plugin Name: Estros Wordpress API
 * Plugin URI: http://estros.gr
 * Description: Passes as json info about selected posts Plugin.
 * Version: 1.0
 * Author: Estros.gr
 * Author URI: http://estros.gr
 * License: GPL2
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'BASE_PATH', dirname(__FILE__) . '/' );

 
function wapi_admin(){
  add_menu_page( 'Estros Api Connector', 'E API C', 'administrator', 'estros-wapi', 'wapi_init', '
dashicons-carrot' );
}

add_action('admin_menu', 'wapi_admin');
 
function wapi_init(){
  ?>
  <div class="wrap">
    <div style="padding:5px; display: inline-block; width:42%;">   
    <h2>All that WebCare Needs!</h2>
      <div class="welcome-panel">
				<a href="https://estros.gr" target="_blank">
          <img src="http://estros.gr/logo.png" height="45">
        </a>
        <div style="width:100%; font-size: 18px; font-weight: bold;">Plugin Description</div>
        <p>Passes as json info about selected posts Plugin (through: 'wp-content/plugins/estros-wapi/json/json.php').</p> 
      </div>
      <div class="welcome-panel">
        <?php
        if($_GET['settings-updated'])
        {
        ?>
          <div style="font-size: 12px; border: 2px #1EA1CC solid;padding:2px;background-color: #2EA2CC; color: white;">Your settings have been saved</div><br>
        <?php
        }
        ?>
        <?php include 'estros-wapi-admin-api-settings.php'; ?>
      </div>
  	</div>
    <div class="welcome-panel" style="vertical-align: top; width: 53%; display: inline-block;">
      <p>Με σήμα το καρότο!</p>
      <p>
      	<h2>Encryption and arguments</h2>
        <strong>post_type</strong> (optional): pass the post_type you want to retrieve (returns published posts). Default post_type is 'post'.<br />
        <strong>category</strong> (optional): pass tehj post category you want to retrieve. Default category is 0, return posts from all categories.<br />
        <strong>token</strong> (mandatory): token is created after hashing the concatenated result of the first argument and the encryption key set in the preferences section.<br />
        <strong>themes</strong> (optional): get inbformation about installed themes and active theme (themes=on).<br />
        <strong>plugins</strong> (optional): get inbformation about installed plugins and active plugins (plugins=on).<br />
        <strong>categories</strong> (optional): get all the post categories (category list) that have at least one post (categories=on).<br />
        <strong>post_types</strong> (optional): get all the post types available (post_types=on).<br />
      </p>
      <p><h3>Demo Key and hash</h3>
      <strong>Key:</strong> polyvios<br />
      <strong>First argument:</strong> post_type=page<br />
     	<strong>Hash:</strong> token=f61805147c8aeaaa3385c2d3583d4b0f<br />
      For 'item' posts use the link:<br />
      /wp-content/plugins/estros-wapi/json/json.php?post_type=item&token=088c3a238c08ac374cb10827fd648b1b
      </p>
  	</div>
  </div>
  <?php
}

add_action( 'admin_init', 'wapi_plugin_settings' );
function wapi_plugin_settings() {
  register_setting( 'wapi-plugin-settings-group', 'encryptionkey' );
	register_setting( 'wapi-plugin-settings-group', 'metakeys' );
	register_setting( 'wapi-plugin-settings-group', 'postkeys' );
}
add_action( 'wp_enqueue_scripts', 'visitorsmapwptuts_scripts_important', 5 );
//add_shortcode('estros-visitorsmap', 'visitorsmapform');