<?php
	header('Content-Type: application/json; charset=utf-8');
	define( 'BASE_PATH', dirname(__FILE__) . '/' );
	require_once('../../../../wp-load.php');
	
	$metakeys = explode(',', trim(get_option('metakeys')));
	//$postkeys = explode(',', trim(get_option('postkeys')));
	$encryption = trim(get_option('encryptionkey'));
	$seed = "";
	if(sizeof($_GET) > 0)
	{
		foreach($_GET as $get)
		{
			$seed = $get;
			break;
		}
	}
	
	$enckey = md5(trim($encryption)."".$seed);
	if(!empty($_GET['token']) && $_GET['token'] == $enckey)
	{
		$feed = array();
		//$feed["Seed"] = md5(trim($encryption)."item");
		if(!empty($_GET['themes']) && $_GET['themes'] == 'on')
		{
			// SET UP JSON FORMAT
			$feed["Active Theme"] = wp_get_theme()->Name;
			
			// GET INSTALLED THEMES
			require_once("../../../../wp-includes/theme.php");							
			$themes = wp_get_themes();
			foreach ($themes as $theme)
				$feed["Installed Themes"][] = $theme->Name;
		}
		
		if(!empty($_GET['plugins']) && $_GET['plugins'] == 'on')
		{
			//GET INSTALLED/ACTIVE PLUGINS
			require_once("../../../../wp-admin/includes/plugin.php");
			$plugins = get_plugins();
			$apl=get_option('active_plugins');
			$activated_plugins=array();
			foreach ($apl as $p){
				if(isset($plugins[$p]))
					$feed["Active Plugins"][] = $plugins[$p]['Name'];
			}
			foreach($plugins as $plugin)
				$feed["Installed Plugins"][] = $plugin['Name'];
		}
		
		if(!empty($_GET['categories']) && $_GET['categories'] == 'on')
		{
			//GET ALL POST CATEGORIES
			require_once("../../../../wp-includes/category.php");
			$cats = get_categories();
			foreach($cats as $cat)
				$feed["Post Categories"][] = $cat;
		}
		
		if(!empty($_GET['post_types']) && $_GET['post_types'] == 'on')
		{
			//GET ALL POST TYPES
			$posttypes = get_post_types();
			foreach($posttypes as $posttype)
				$feed["Post Types"][] = $posttype;
		}
		//GET ALL POSTS
		require_once("../../../../wp-includes/post.php");
		$paged = get_query_var('paged');
		
		/*
			'numberposts' => 5, 
			'offset' => 0,
			'category' => 0, 
			'orderby' => 'date',
			'order' => 'DESC', 
			'include' => array(),
			'exclude' => array(), 
			'meta_key' => '',
			'meta_value' =>'', 
			'post_type' => 'post',
			'suppress_filters' => true
		*/
		
		$dposttype = 'post';
		$dcategory = 0;
		
		if(isset($_GET['post_type']))
			$dposttype = $_GET['post_type'];
			
		if(isset($_GET['category']))
			$dcategory = $_GET['category'];
		
		$args = array(
				'numberposts'       => -1,
				'category' 					=> $dcategory, 
				'orderby'           => 'post_date',
				'order'             => 'ASC',
				'post_type'         => $dposttype,
				'post_status'       => 'publish',
				'suppress_filters'  => true
		);
		$posts = get_posts($args);
		$i = 0;
		foreach($posts as $post)
		{
			$feed["Posts"][$i] = $post;

			$images = get_attached_media('image');
			//$feed["Posts"][$i]->images = array();
			//for($j = 0; $j < sizeof($images); $j++)
			//{
			//	$feed["Posts"][$i]->images[$j]['id'] = $images[$j];
			//	$feed["Posts"][$i]->images[$j]['url'] = $images[$j];
			//}
			$feed["Posts"][$i]->images = array();
			$k = 0;
			foreach($images as $image)
			{
				$feed["Posts"][$i]->images[$k]['id'] = $image->ID;
				$feed["Posts"][$i]->images[$k]['link'] = $image->guid;
				$feed["Posts"][$i]->images[$k]['mime'] = $image->post_mime_type;
				$k++;
			}
			
			if(sizeof($metakeys) > 0 && $metakeys[0] != "")
			{
				$feed["Posts"][$i]->meta = array();
				for($j = 0; $j < sizeof($metakeys); $j++)
				{
					$feed["Posts"][$i]->meta[$metakeys[$j]] = get_post_meta($post->ID, $metakeys[$j]);
				}
			}
			else
			{
				$feed["Posts"][$i]->meta = get_post_meta($post->ID);
			}
			$i++;
		}
		
		echo json_encode($feed, JSON_PRETTY_PRINT);
	}
	else
	{
		echo 'UNAUTHORISED REQUEST!';
	}
?>