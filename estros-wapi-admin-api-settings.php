<?php

if (isset($_POST['wapi_prefs']))
{
	update_option('encryptionkey', $_POST['encryptionkey']);	
	update_option('metakeys', $_POST['metakeys']);
	update_option('postkeys', $_POST['postkeys']);
}
?>
<h3>Preferences</h3>

<form name="wapiform" method="POST" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
  <strong>Encryption Key:</strong><br />
  <input type="text" value="<?php echo esc_attr( get_option('encryptionkey') ); ?>" id="encryptionkey" name="encryptionkey" ><br />
  <strong>List of meta keys to include. (key1,key2,key3) :</strong><br />
  <input type="text" value="<?php echo esc_attr( get_option('metakeys') ); ?>" id="metakeys" name="metakeys" ><br />
  <div style="font-size:10px;"> Custom post types come with plenty of meta data. In order to skip some unnecessary data you have to define a list of keys.</div>
  <!--
  <strong>List of post data to include. (key1,key2,key3) :</strong><br />
  <input type="text" value="<?php echo esc_attr( get_option('postkeys') ); ?>" id="postkeys" name="postkeys" ><br />
  <div style="font-size:10px;"> Posts come with plenty of  data. In order to skip some unnecessary data you have to define a list of keys.</div>
  -->
	<input type="hidden" value="YES" id="wapi_prefs" name="wapi_prefs" >
  
  <?php submit_button("Save Preferences"); ?>
  <br />
</form>
