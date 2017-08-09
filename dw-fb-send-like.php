<?php
/*
Plugin Name: DW Fb Send/Like
Plugin URI: http://www.danielwoolnough.com/product/dw-fb-send-like/
Description: Adds a Facebook Send and Like button to your WordPress posts and/or pages. Nice & Simple to use configuration.
Version: 1.1
Author: Daniel Woolnough
Author URI: http://www.danielwoolnough.com/

function get_open_graph_tags() {

function get_first_image() {
global $post, $posts;
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
$first_img = $matches [1] [0];

return $first_img;
}

?>
	<!--Facebook Open Graph Tags by darkomitrovic.com-->
	
<head>
	<meta property="og:title" content="<?php echo get_the_title($post->post_parent) ?>" />
	<meta property="og:url" content="<?php echo get_permalink($post->ID) ?>" />
	<meta property="og:image" content="<?php echo get_first_image() ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
	<meta property="fb:app_id" content="225857277429503" />
	<meta property="fb:admins" content="1144531016" />
	<meta property="fb:page_id" content="105035636233014" />
	<!--Facebook Open Graph Tags-->
<?php
}


add_action('wp_head', 'get_open_graph_tags');


function fb_like_send_button($content) {
	global $post;

	$url = get_permalink($post->ID);
	$send = get_option('dw_fb_send_like_button_send');
	$layout = get_option('dw_fb_send_like_button_layout');
	$width = get_option('dw_fb_send_like_button_width');
	$show_faces = get_option('dw_fb_send_like_button_face');
	$colorscheme = get_option('dw_fb_send_like_button_colorscheme');
	$action = get_option('dw_fb_send_like_button_verb');
	$font = get_option('dw_fb_send_like_button_font');
	$position = get_option('dw_fb_send_like_button_position');
	
	$language = get_option("dw_fb_send_like_button_language");
	if($language == '') { $language = 'en_US'; }
	
	
	//if POST & PAGE checked
	if (get_option('dw_fb_send_like_button_post') == 'yes' && get_option('dw_fb_send_like_button_page') == 'yes') {
		if((is_single) || (is_page())){
			$button .= '
			<div id="fb-root"></div>
			<script>
			<!--
			  window.fbAsyncInit = function() {
				FB.init({appId: "224955984185367", status: true, cookie: true, xfbml: true});
			  };
			  (function() {
				var e = document.createElement("script"); e.async = true;
				e.src = document.location.protocol +
				  "//connect.facebook.net/'.$language.'/all.js";
				document.getElementById("fb-root").appendChild(e);
			  }());
			-->
			</script>
			<fb:like href="'.$url.'" send="'.$send.'" layout="'.$layout.'" width="'.$width.'" show_faces="'.$show_faces.'" colorscheme="'.$colorscheme.'" action="'.$action.'" font="'.$font.'"></fb:like>
			';
		}
	}
	//if POST checked
	else if (get_option('dw_fb_send_like_button_post') == 'yes' && (is_single()) ) {
			$button .= '
			<div id="fb-root"></div>
			<script>
			  window.fbAsyncInit = function() {
				FB.init({appId: "224955984185367", status: true, cookie: true, xfbml: true});
			  };
			  (function() {
				var e = document.createElement("script"); e.async = true;
				e.src = document.location.protocol +
				  "//connect.facebook.net/'.$language.'/all.js";
				document.getElementById("fb-root").appendChild(e);
			  }());
			</script>
			<fb:like href="'.$url.'" send="'.$send.'" layout="'.$layout.'" width="'.$width.'" show_faces="'.$show_faces.'" colorscheme="'.$colorscheme.'" action="'.$action.'" font="'.$font.'"></fb:like>
			';
	}
	//if PAGE checked
	else if (get_option('dw_fb_send_like_button_page') == 'yes' && (is_page()) ) {
			$button .= '
			<div id="fb-root"></div>
			<script>
			  window.fbAsyncInit = function() {
				FB.init({appId: "224955984185367", status: true, cookie: true, xfbml: true});
			  };
			  (function() {
				var e = document.createElement("script"); e.async = true;
				e.src = document.location.protocol +
				  "//connect.facebook.net/'.$language.'/all.js";
				document.getElementById("fb-root").appendChild(e);
			  }());
			</script>
			<fb:like href="'.$url.'" send="'.$send.'" layout="'.$layout.'" width="'.$width.'" show_faces="'.$show_faces.'" colorscheme="'.$colorscheme.'" action="'.$action.'" font="'.$font.'"></fb:like>
			';
	}
	//NON checked
	else {
		$button .= '';
	}


	//Position
	if ($position == 'before') {
		$content=$button.$content;
	}
	else if ($position == 'after') {
		$content=$content.$button;
	}
	else if ($position == 'both') {
		$content=$button.$content.$button;
	}

	return $content;
}

add_action('the_content', 'fb_like_send_button');




/* Runs when plugin is activated */
register_activation_hook(__FILE__,'dw_fb_send_like_button_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'dw_fb_send_like_button_remove' );

function dw_fb_send_like_button_install() {
	/* Creates new database field */
	add_option("dw_fb_send_like_button_post", 'yes', '', 'yes');
	add_option("dw_fb_send_like_button_page", 'yes', '', 'yes');
	add_option("dw_fb_send_like_button_send", 'true', '', 'yes');
	add_option("dw_fb_send_like_button_layout", 'standard', '', 'yes');
	add_option("dw_fb_send_like_button_width", '450', '', 'yes');
	add_option("dw_fb_send_like_button_face", 'true', '', 'yes');
	add_option("dw_fb_send_like_button_verb", 'like', '', 'yes');
	add_option("dw_fb_send_like_button_colorscheme", 'light', '', 'yes');
	add_option("dw_fb_send_like_button_font", '', '', 'yes');
	add_option("dw_fb_send_like_button_position", 'after', '', 'yes');
	add_option("dw_fb_send_like_button_language", 'en_US', '', 'yes');
}

function dw_fb_send_like_button_remove() {
	/* Deletes the database field */
	delete_option('dw_fb_send_like_button_post');
	delete_option('dw_fb_send_like_button_page');
	delete_option('dw_fb_send_like_button_send');
	delete_option('dw_fb_send_like_button_layout');
	delete_option('dw_fb_send_like_button_width');
	delete_option('dw_fb_send_like_button_face');
	delete_option('dw_fb_send_like_button_verb');
	delete_option('dw_fb_send_like_button_colorscheme');
	delete_option('dw_fb_send_like_button_font');
	delete_option('dw_fb_send_like_button_position');
	delete_option('dw_fb_send_like_button_language');
}




if ( is_admin() ){
	/* Call the html code */
	add_action('admin_menu', 'dw_fb_send_like_button_admin_menu');
	
	function dw_fb_send_like_button_admin_menu() {
	add_options_page('Facebook Send/Like Options', ' DW Fb Send/Like', 'administrator',
	'dw-fb-send-like', 'dw_fb_send_like_button_html_page');
	}
}




function dw_fb_send_like_button_html_page() {
?>
			
</head>

<div class="wrap">
	<form method="post" action="options.php" id="options">
	<?php wp_nonce_field('update-options'); ?>
	<div id="icon-options-general" class="icon32">
	<br />
	</div>	
	<h2>DW Fb Send/Like </h2>
	
	<div class="postbox-container" style="width:100%;">
		<div class="metabox-holder">
			<div class="postbox">
				<h3 class="hndle"><span>About The Plugin</span></h3>
          		  <div style="margin:20px;">
          		  <div class="inside">
          		  	<p>DW Fb Send/Like plugin, lets you add Facebook like and/or send buttons to your 
          		  	posts and/or pages. The plugin has a simple interface to customise the buttons.</p>
       		     </div>
					  You are able to add Facebook send and/or like buttons to your posts and/or pages, 
					  the option to insert the button to any posts, pages or both, 
					  the otion to insert the button after the content, before the content or both, 
					  the plugin automatically include Open Graph Tags, 
					  you can display buttons in different languages and
					  it has a very simple configuration.
				<div class="inside">
        	    	<p>If you have any problems or questions, please visit <a href="http://www.danielwoolnough.me.uk/">
       		     	Daniel Woolnough</a> and post on the forum or use a support ticket.</p>
       		     </div>
       		     </div>
			</div>
			
		<div class="postbox">
            <h3 class="hndle"><span>Donate</span></h3>
            <div style="margin:20px;">
            <div class="inside">
				<p>Since you got this plugin for free of charge, (if you didn't, get a refund), Please consider donating any small amount. 
	               All donations are appreciated. Thank you for your generosity.</p>
	               <a href="http://www.danielwoolnough.me.uk/contact/coffee/" target="_blank"><img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_GB/i/btn/btn_donate_LG.gif" width="92" height="26"></a>
	            </div>
            </div>
		</div>
		
        <div class="postbox">
				
				<h3 class="hndle"><span>DW Fb Send/Like Options</span></h3>
				
				<div style="margin:20px;">
				
					<p>
						<label>Show Buttons On</label>
						<div style="margin:-27px 0 0 140px;">
							<input name="dw_fb_send_like_button_post" type="checkbox" value="yes" <?php if (get_option('dw_fb_send_like_button_post') == 'yes') {echo 'checked="checked"';} ?> />
							<label>Posts</label>
							<br />
							<input name="dw_fb_send_like_button_page" type="checkbox" value="yes" <?php if (get_option('dw_fb_send_like_button_page') == 'yes') {echo 'checked="checked"';} ?> /> 
							<label>Pages</label>
						</div>
					</p>

					<p>
						<label>Where To Show</label>
						<div style="margin:-30px 0 0 140px;">
						<select name="dw_fb_send_like_button_position">
							<option value="after" <?php if (get_option('dw_fb_send_like_button_position') == 'after') {echo 'selected="selected"';} ?>>after</option>
							<option value="before" <?php if (get_option('dw_fb_send_like_button_position') == 'before') {echo 'selected="selected"';} ?>>before</option>
							<option value="both" <?php if (get_option('dw_fb_send_like_button_position') == 'both') {echo 'selected="selected"';} ?>>after and before</option>
						</select>
						</div>
					</p>



					<br />
				
					<p>
						<label>Show Send Button?</label>
						<div style="margin:-28px 0 0 140px;">
							<input type="radio" name="dw_fb_send_like_button_send" value="true" <?php if (get_option('dw_fb_send_like_button_send') == 'true') {echo 'checked="checked"';} ?> />
							<label>Yes</label>
							<input type="radio" name="dw_fb_send_like_button_send" value="false"  <?php if (get_option('dw_fb_send_like_button_send') == 'false') {echo 'checked="checked"';} ?> />		
							<label>No</label>
						</div>
					</p>

					<p>
						<label>Button Layout Style</label>
						<div style="margin:-30px 0 0 140px;">
						<select name="dw_fb_send_like_button_layout">
							<option value="standard" <?php if (get_option('dw_fb_send_like_button_layout') == 'standard') {echo 'selected="selected"';} ?>>standard</option>
							<option value="button_count" <?php if (get_option('dw_fb_send_like_button_layout') == 'button_count') {echo 'selected="selected"';} ?>>button_count</option>
							<option value="box_count" <?php if (get_option('dw_fb_send_like_button_layout') == 'box_count') {echo 'selected="selected"';} ?>>box_count</option>
						</select>
						</div>
					</p>

					<p>
						<label>Box Width</label>
						<div style="margin:-35px 0 0 140px;">
			  			<input type="text" name="dw_fb_send_like_button_width" value="450" />
						</div>
					</p>
				
					<p>
						<label>Show Faces?</label>
						<div style="margin:-29px 0 0 140px;">
							<input type="radio" name="dw_fb_send_like_button_face" value="true"  <?php if (get_option('dw_fb_send_like_button_face') == 'true') {echo 'checked="checked"';} ?> />		
							<label>Yes</label>
							<input type="radio" name="dw_fb_send_like_button_face" value="false"  <?php if (get_option('dw_fb_send_like_button_face') == 'false') {echo 'checked="checked"';} ?> />		
							<label>No</label>
						</div>
					</p>
		
					<p>
						<label>Like or Reccomend?</label>
						<div style="margin:-30px 0 0 140px;">
						<select name="dw_fb_send_like_button_verb">
							<option value="like" <?php if (get_option('dw_fb_send_like_button_verb') == 'like') {echo 'selected="selected"';} ?>>like</option>
							<option value="recommend" <?php if (get_option('dw_fb_send_like_button_verb') == 'recommend') {echo 'selected="selected"';} ?>>recommend</option>
						</select>
						</div>
					</p>
				
					<p>
						<label>Light or Dark?</label>
						<div style="margin:-30px 0 0 140px;">
						<select name="dw_fb_send_like_button_colorscheme">
							<option value="light" <?php if (get_option('dw_fb_send_like_button_colorscheme') == 'light') {echo 'selected="selected"';} ?>>light</option>
							<option value="dark" <?php if (get_option('dw_fb_send_like_button_colorscheme') == 'dark') {echo 'selected="selected"';} ?>>dark</option>
						</select>
						</div>
					</p>

					<p>
						<label>Font</label>
						<div style="margin:-30px 0 0 140px;">
						<select name="dw_fb_send_like_button_font">
							<option value="" <?php if (get_option('dw_fb_send_like_button_font') == '') {echo 'selected="selected"';} ?>>&nbsp;</option>
							<option value="arial" <?php if (get_option('dw_fb_send_like_button_font') == 'arial') {echo 'selected="selected"';} ?>>arial</option>
							<option value="lucida grande" <?php if (get_option('dw_fb_send_like_button_font') == 'lucida grande') {echo 'selected="selected"';} ?>>lucida grande</option>
							<option value="segoe ui" <?php if (get_option('dw_fb_send_like_button_font') == 'segoe ui') {echo 'selected="selected"';} ?>>segoe ui</option>
							<option value="tahoma" <?php if (get_option('dw_fb_send_like_button_font') == 'tahoma') {echo 'selected="selected"';} ?>>tahoma</option>
							<option value="trebuchet ms" <?php if (get_option('dw_fb_send_like_button_font') == 'trebuchet ms') {echo 'selected="selected"';} ?>>trebuchet ms</option>
							<option value="verdana" <?php if (get_option('dw_fb_send_like_button_font') == 'verdana') {echo 'selected="selected"';} ?>>verdana</option>
						</select>
						</div>
					</p>

					<br />

					<p>
												<label>Language</label>
						<div style="margin:-30px 0 0 140px;">
						<select name="fb_like_send_button_language">
<option value="" <?php if (get_option('fb_like_send_button_language') == '') {echo 'selected="selected"';} ?>>&nbsp;</option>
<option value='af_ZA' <?php if (get_option('fb_like_send_button_language') == 'af_ZA') {echo 'selected="selected"';} ?>>Afrikaans</option>
<option value='sq_AL' <?php if (get_option('fb_like_send_button_language') == 'sq_AL') {echo 'selected="selected"';} ?>>Albanian</option>
<option value='ar_AR' <?php if (get_option('fb_like_send_button_language') == 'ar_AR') {echo 'selected="selected"';} ?>>Arabic</option>
<option value='hy_AM' <?php if (get_option('fb_like_send_button_language') == 'hy_AM') {echo 'selected="selected"';} ?>>Armenian</option>
<option value='eu_ES' <?php if (get_option('fb_like_send_button_language') == 'eu_ES') {echo 'selected="selected"';} ?>>Basque</option>
<option value='be_BY' <?php if (get_option('fb_like_send_button_language') == 'be_BY') {echo 'selected="selected"';} ?>>Belarusian</option>
<option value='bn_IN' <?php if (get_option('fb_like_send_button_language') == 'bn_IN') {echo 'selected="selected"';} ?>>Bengali</option>
<option value='bs_BA' <?php if (get_option('fb_like_send_button_language') == 'bs_BA') {echo 'selected="selected"';} ?>>Bosanski</option>
<option value='bg_BG' <?php if (get_option('fb_like_send_button_language') == 'bg_BG') {echo 'selected="selected"';} ?>>Bulgarian</option>
<option value='ca_ES' <?php if (get_option('fb_like_send_button_language') == 'ca_ES') {echo 'selected="selected"';} ?>>Catalan</option>
<option value='zh_CN' <?php if (get_option('fb_like_send_button_language') == 'zh_CN') {echo 'selected="selected"';} ?>>Chinese</option>
<option value='cs_CZ' <?php if (get_option('fb_like_send_button_language') == 'cs_CZ') {echo 'selected="selected"';} ?>>Czech</option>
<option value='da_DK' <?php if (get_option('fb_like_send_button_language') == 'da_DK') {echo 'selected="selected"';} ?>>Danish</option>
<option value='en_US' <?php if (get_option('fb_like_send_button_language') == 'en_US') {echo 'selected="selected"';} ?>>English</option>
<option value='eo_EO' <?php if (get_option('fb_like_send_button_language') == 'eo_EO') {echo 'selected="selected"';} ?>>Esperanto</option>
<option value='et_EE' <?php if (get_option('fb_like_send_button_language') == 'et_EE') {echo 'selected="selected"';} ?>>Estonian</option>
<option value='et_EE' <?php if (get_option('fb_like_send_button_language') == 'et_EE') {echo 'selected="selected"';} ?>>Estonian</option>
<option value='fi_FI' <?php if (get_option('fb_like_send_button_language') == 'fi_FI') {echo 'selected="selected"';} ?>>Finnish</option>
<option value='fo_FO' <?php if (get_option('fb_like_send_button_language') == 'fo_FO') {echo 'selected="selected"';} ?>>Faroese</option>
<option value='tl_PH' <?php if (get_option('fb_like_send_button_language') == 'tl_PH') {echo 'selected="selected"';} ?>>Filipino</option>
<option value='fr_FR' <?php if (get_option('fb_like_send_button_language') == 'fr_FR') {echo 'selected="selected"';} ?>>French</option>
<option value='fy_NL' <?php if (get_option('fb_like_send_button_language') == 'fy_NL') {echo 'selected="selected"';} ?>>Frisian</option>
<option value='gl_ES' <?php if (get_option('fb_like_send_button_language') == 'gl_ES') {echo 'selected="selected"';} ?>>Galician</option>
<option value='ka_GE' <?php if (get_option('fb_like_send_button_language') == 'ka_GE') {echo 'selected="selected"';} ?>>Georgian</option>
<option value='de_DE' <?php if (get_option('fb_like_send_button_language') == 'de_DE') {echo 'selected="selected"';} ?>>German</option>
<option value='zh_CN' <?php if (get_option('fb_like_send_button_language') == 'el_GR') {echo 'selected="selected"';} ?>>Greek</option>
<option value='he_IL' <?php if (get_option('fb_like_send_button_language') == 'he_IL') {echo 'selected="selected"';} ?>>Hebrew</option>
<option value='hi_IN' <?php if (get_option('fb_like_send_button_language') == 'hi_IN') {echo 'selected="selected"';} ?>>Hindi</option>
<option value='hr_HR' <?php if (get_option('fb_like_send_button_language') == 'hr_HR') {echo 'selected="selected"';} ?>>Hrvatski</option>
<option value='hu_HU' <?php if (get_option('fb_like_send_button_language') == 'hu_HU') {echo 'selected="selected"';} ?>>Hungarian</option>
<option value='is_IS' <?php if (get_option('fb_like_send_button_language') == 'is_IS') {echo 'selected="selected"';} ?>>Icelandic</option>
<option value='id_ID' <?php if (get_option('fb_like_send_button_language') == 'id_ID') {echo 'selected="selected"';} ?>>Indonesian</option>
<option value='ga_IE' <?php if (get_option('fb_like_send_button_language') == 'ga_IE') {echo 'selected="selected"';} ?>>Irish</option>
<option value='it_IT' <?php if (get_option('fb_like_send_button_language') == 'it_IT') {echo 'selected="selected"';} ?>>Italian</option>
<option value='ja_JP' <?php if (get_option('fb_like_send_button_language') == 'ja_JP') {echo 'selected="selected"';} ?>>Japanese</option>
<option value='ko_KR' <?php if (get_option('fb_like_send_button_language') == 'ko_KR') {echo 'selected="selected"';} ?>>Korean</option>
<option value='ku_TR' <?php if (get_option('fb_like_send_button_language') == 'ku_TR') {echo 'selected="selected"';} ?>>Kurdish</option>
<option value='la_VA' <?php if (get_option('fb_like_send_button_language') == 'la_VA') {echo 'selected="selected"';} ?>>Latin</option>
<option value='lv_LV' <?php if (get_option('fb_like_send_button_language') == 'lv_LV') {echo 'selected="selected"';} ?>>Latvian</option>
<option value='fb_LT' <?php if (get_option('fb_like_send_button_language') == 'fb_LT') {echo 'selected="selected"';} ?>>Leet Speak</option>
<option value='lt_LT' <?php if (get_option('fb_like_send_button_language') == 'lt_LT') {echo 'selected="selected"';} ?>>Lithuanian</option>
<option value='mk_MK' <?php if (get_option('fb_like_send_button_language') == 'mk_MK') {echo 'selected="selected"';} ?>>Macedonian</option>
<option value='ms_MY' <?php if (get_option('fb_like_send_button_language') == 'ms_MY') {echo 'selected="selected"';} ?>>Malay</option>
<option value='ml_IN' <?php if (get_option('fb_like_send_button_language') == 'ml_IN') {echo 'selected="selected"';} ?>>Malayalam</option>
<option value='nl_NL' <?php if (get_option('fb_like_send_button_language') == 'nl_NL') {echo 'selected="selected"';} ?>>Nederlands</option>
<option value='ne_NP' <?php if (get_option('fb_like_send_button_language') == 'ne_NP') {echo 'selected="selected"';} ?>>Nepali</option>
<option value='nb_NO' <?php if (get_option('fb_like_send_button_language') == 'nb_NO') {echo 'selected="selected"';} ?>>Norwegian</option>
<option value='ps_AF' <?php if (get_option('fb_like_send_button_language') == 'ps_AF') {echo 'selected="selected"';} ?>>Pashto</option>
<option value='fa_IR' <?php if (get_option('fb_like_send_button_language') == 'fa_IR') {echo 'selected="selected"';} ?>>Persian</option>
<option value='pl_PL' <?php if (get_option('fb_like_send_button_language') == 'pl_PL') {echo 'selected="selected"';} ?>>Polish</option>
<option value='pt_PT' <?php if (get_option('fb_like_send_button_language') == 'pt_PT') {echo 'selected="selected"';} ?>>Portugese</option>
<option value='pa_IN' <?php if (get_option('fb_like_send_button_language') == 'pa_IN') {echo 'selected="selected"';} ?>>Punjabi</option>
<option value='ro_RO' <?php if (get_option('fb_like_send_button_language') == 'ro_RO') {echo 'selected="selected"';} ?>>Romanian</option>
<option value='ru_RU' <?php if (get_option('fb_like_send_button_language') == 'ru_RU') {echo 'selected="selected"';} ?>>Russian</option>
<option value='sk_SK' <?php if (get_option('fb_like_send_button_language') == 'sk_SK') {echo 'selected="selected"';} ?>>Slovak</option>
<option value='sl_SI' <?php if (get_option('fb_like_send_button_language') == 'sl_SI') {echo 'selected="selected"';} ?>>Slovenian</option>
<option value='es_LA' <?php if (get_option('fb_like_send_button_language') == 'es_LA') {echo 'selected="selected"';} ?>>Spanish</option>
<option value='sr_RS' <?php if (get_option('fb_like_send_button_language') == 'sr_RS') {echo 'selected="selected"';} ?>>Srpski</option>
<option value='sw_KE' <?php if (get_option('fb_like_send_button_language') == 'sw_KE') {echo 'selected="selected"';} ?>>Swahili</option>
<option value='sv_SE' <?php if (get_option('fb_like_send_button_language') == 'sv_SE') {echo 'selected="selected"';} ?>>Swedish</option>
<option value='ta_IN' <?php if (get_option('fb_like_send_button_language') == 'ta_IN') {echo 'selected="selected"';} ?>>Tamil</option>
<option value='te_IN' <?php if (get_option('fb_like_send_button_language') == 'te_IN') {echo 'selected="selected"';} ?>>Telugu</option>
<option value='th_TH' <?php if (get_option('fb_like_send_button_language') == 'th_TH') {echo 'selected="selected"';} ?>>Thai</option>
<option value='tr_TR' <?php if (get_option('fb_like_send_button_language') == 'tr_TR') {echo 'selected="selected"';} ?>>Turkish</option>
<option value='uk_UA' <?php if (get_option('fb_like_send_button_language') == 'uk_UA') {echo 'selected="selected"';} ?>>Ukrainian</option>
<option value='vi_VN' <?php if (get_option('fb_like_send_button_language') == 'vi_VN') {echo 'selected="selected"';} ?>>Vietnamese</option>
<option value='cy_GB' <?php if (get_option('fb_like_send_button_language') == 'cy_GB') {echo 'selected="selected"';} ?>>Welsh</option>
						</select>
						</div>
					</p>

				</div>
				
			</div>
		</div>
	</div>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="fb_like_send_button_post,fb_like_send_button_page,fb_like_send_button_send,fb_like_send_button_layout,fb_like_send_button_width,fb_like_send_button_face,fb_like_send_button_verb,fb_like_send_button_colorscheme,fb_like_send_button_font,fb_like_send_button_position,fb_like_send_button_language" />


	<div class="submit"><input type="submit" class="button-primary"  value="<?php _e('Save Changes') ?>" /></div>
	
	</form>
</div>

<?php
}
?>