<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<?php global $gdl_is_responsive ?>
	<?php if( $gdl_is_responsive ){ ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/skeleton-responsive.css">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/layout-responsive.css">	
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/skeleton.css">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/layout.css">	
	<?php } ?>
	
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie-style.php?path=<?php echo GOODLAYERS_PATH; ?>" type="text/css" media="screen, projection" /> 
		<script type="text/javascript" src="/wp-content/themes/modernize-v3-11/javascript/respond-min.js"></script>
	<![endif]-->

	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie7-style.css" /> 
	<![endif]-->	
	
	<!-- Favicon
   ================================================== -->
	<?php 
		if(get_option( THEME_SHORT_NAME.'_enable_favicon','disable') == "enable"){
			$gdl_favicon = get_option(THEME_SHORT_NAME.'_favicon_image');
			if( $gdl_favicon ){
				$gdl_favicon = wp_get_attachment_image_src($gdl_favicon, 'full');
				echo '<link rel="shortcut icon" href="' . $gdl_favicon[0] . '" type="image/x-icon" />';
			}
		} 
	?>

	<!-- Start WP_HEAD
   ================================================== -->
		
	<?php wp_head(); ?>
	
	<!-- FB Thumbnail
   ================================================== -->
	<?php
	if( is_single() ){
		$thumbnail_id = get_post_meta($post->ID,'post-option-inside-thumbnial-image', true);
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<link rel="image_src" href="' . $thumbnail[0] . '" />';
		}
	} else{
		$thumbnail_id = get_post_thumbnail_id();
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<link rel="image_src" href="' . $thumbnail[0] . '" />';		
		}
	}
	?>	
</head>
<body <?php echo body_class(); ?>>
	<?php
		$background_style = get_option(THEME_SHORT_NAME.'_background_style', 'Pattern');
		if($background_style == 'Custom Image'){
			$background_id = get_option(THEME_SHORT_NAME.'_background_custom');
			if(!empty($background_id)){
				$background_image = wp_get_attachment_image_src( $background_id, 'full' );
				echo '<div id="custom-full-background">';
				echo '<img src="' . $background_image[0] . '" alt="" />';
				echo '</div>';
			}
		}
		
		global $gdl_boxed_layout;
		if($gdl_boxed_layout == 'enable'){ 
			$all_container_class = "boxed-layout";
		}else{	
			$all_container_class = "no-boxed-layout"; 
		}		
	?>
<div class="body-wrapper">

	<?php $gdl_enable_top_navigation = get_option(THEME_SHORT_NAME.'_enable_top_navigation');
	if ( $gdl_enable_top_navigation == '' || $gdl_enable_top_navigation == 'enable' ){  ?>
	<div class="top-navigation-wrapper <?php echo $all_container_class; ?>">
		<div class="top-navigation container">
			<div class="top-navigation-left">
				<?php wp_nav_menu( array( 'theme_location' => 'top_menu' ) ); ?>
				<div class="clear"></div>
			</div>
			
			<?php 
				$top_navigation_right_text = do_shortcode( __(get_option(THEME_SHORT_NAME.'_top_navigation_right_text'), 'gdl_front_end') );
				if( $top_navigation_right_text ){
					echo '<div class="top-navigation-right">' . $top_navigation_right_text . '</div>';
				}
			?>

		</div>
		<div class="top-navigation-wrapper-gimmick"></div>
	</div>
	<?php } ?>
	
	<div class="all-container-wrapper <?php echo $all_container_class; ?>">
		<div class="header-outer-wrapper">
			<div class="header-container-wrapper container-wrapper">
				<div class="header-wrapper">
					<div class="clear"></div>
					
					<!-- Get Logo -->
					<div class="logo-wrapper">
						<?php
							echo '<a href="';
							echo  bloginfo('url');
							echo '">';
							$logo_id = get_option(THEME_SHORT_NAME.'_logo');
							$logo_attachment = wp_get_attachment_image_src($logo_id, 'full');
							$alt_text = get_post_meta($logo_id , '_wp_attachment_image_alt', true);
							if( !empty($logo_attachment) ){
								$logo_attachment = $logo_attachment[0];
							}else{
								$logo_attachment = GOODLAYERS_PATH . '/images/default-logo.png';
								$alt_text = 'default logo';
							}
							echo '<img src="' . $logo_attachment . '" alt="' . $alt_text . '"/ >';
							echo '</a>';
						?>
					</div>
						
                                       <!-- Get Announcement -->
                                       <div id="announcement">
					<?php dynamic_sidebar( 'announcement' ); ?>
					</div>
                                             

					<!-- Get Social Icons -->
					<div class="outer-social-wrapper">
						<div class="social-wrapper">
							<?php
								$gdl_social_wrapper_text = get_option(THEME_SHORT_NAME.'_social_wrapper_text');
								if( !empty($gdl_social_wrapper_text) ){
								
									echo '<div class="social-wrapper-text">' . $gdl_social_wrapper_text . '</div>';
									
								}
							?>	
							<div class="social-icon-wrapper">
								<?php
									global $gdl_icon_type;
									$gdl_social_icon = array(
										'delicious'=> array('name'=>THEME_SHORT_NAME.'_delicious', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/delicious.png'),
										'deviantart'=> array('name'=>THEME_SHORT_NAME.'_deviantart', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/deviantart.png'),
										'digg'=> array('name'=>THEME_SHORT_NAME.'_digg', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/digg.png'),
										'facebook' => array('name'=>THEME_SHORT_NAME.'_facebook', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/facebook.png'),
										'flickr' => array('name'=>THEME_SHORT_NAME.'_flickr', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/flickr.png'),
										'lastfm'=> array('name'=>THEME_SHORT_NAME.'_lastfm', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/lastfm.png'),
										'linkedin' => array('name'=>THEME_SHORT_NAME.'_linkedin', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/linkedin.png'),
										'picasa'=> array('name'=>THEME_SHORT_NAME.'_picasa', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/picasa.png'),
										'rss'=> array('name'=>THEME_SHORT_NAME.'_rss', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/rss.png'),
										'stumble-upon'=> array('name'=>THEME_SHORT_NAME.'_stumble_upon', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/stumble-upon.png'),
										'tumblr'=> array('name'=>THEME_SHORT_NAME.'_tumblr', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/tumblr.png'),
										'twitter' => array('name'=>THEME_SHORT_NAME.'_twitter', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/twitter.png'),
										'vimeo' => array('name'=>THEME_SHORT_NAME.'_vimeo', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/vimeo.png'),
										'youtube' => array('name'=>THEME_SHORT_NAME.'_youtube', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/youtube.png'),
										'google_plus' => array('name'=>THEME_SHORT_NAME.'_google_plus', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/google-plus.png'),
										'email' => array('name'=>THEME_SHORT_NAME.'_email', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/email.png'),
										'pinterest' => array('name'=>THEME_SHORT_NAME.'_pinterest', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social/pinterest.png')
										);
									
									foreach( $gdl_social_icon as $social_name => $social_icon ){
									
										$social_link = get_option($social_icon['name']);
										if( !empty($social_link) ){
										
											echo '<div class="social-icon"><a target="_blank" href="' . $social_link . '">' ;
											echo '<img src="' . $social_icon['url'] . '" alt="' . $social_name . '"/>';
											echo '</a></div>';
										
										}
										
									}
								?>
							</div>


<div id="location" class="vcard">
		<p class="telephone">Tel: <span class="tel">(203) 762-9620</span></p>
		<p class="adr"><span class="fn org">Zion's Hill Preschool Program</span><a href="https://maps.google.com/maps?q=470+Danbury+Road+Wilton,+CT+06897&daddr=470+Danbury+Rd,+Wilton,+CT+06897&oe=utf-8&client=firefox-a&hnear=0x89e802f971eff455:0xeb5fc08650a162d4,470+Danbury+Rd,+Wilton,+CT+06897&gl=us&t=m&z=16" target="_blank" title="get directions"><span class="street-address">470 Danbury Road</span><br/><span class="locality">Wilton</span>, <abbr class="region" title="Connecticut">CT</abbr> <span class="postal-code">06897</span></a></p>
</div>

						</div>


					</div>

					<div class="clear"></div>
				</div> <!-- header-wrapper -->
			</div> <!-- header-container -->
		</div> <!-- header-outer-wrapper -->
		
		<!-- Navigation and Search Form -->
		<div class="main-navigation-wrapper">
			<?php 
				if( $gdl_is_responsive ){
					echo '<div class="responsive-container-wrapper container-wrapper">';
					dropdown_menu( array('dropdown_title' => '-- Main Menu --', 'indent_string' => '- ', 'indent_after' => '','container' => 'div', 'container_class' => 'responsive-menu-wrapper', 'theme_location'=>'main_menu') );	
					echo '</div>';
				}
			?>
			<div class="navigation-wrapper">
				<div class="navigation-container-wrapper container-wrapper">
					<!-- Get Navigation -->
					<?php wp_nav_menu( array('container' => 'div', 'container_class' => 'menu-wrapper', 'container_id' => 'main-superfish-wrapper', 'menu_class'=> 'sf-menu',  'theme_location' => 'main_menu' ) ); ?>
					
					<!-- Get Search form -->
					<?php if(get_option(THEME_SHORT_NAME.'_enable_top_search','enable') == 'enable'){?>
					<div class="search-wrapper"><?php get_search_form(); ?></div> 
					<?php } ?>
					
					<div class="clear"></div>
				</div> <!-- navigation-container-wrapper -->
			</div> <!-- navigation-wrapper -->
		</div>
				
		
		<div class="container main content-container">
			<div class="header-content-wrapper">