<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php 
	if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        header('X-UA-Compatible: IE=9');
	global $redux_demo; 
	$favicon = $redux_demo['favicon']['url'];
	?>

	<?php if (!empty($favicon)) : ?>
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
	<?php endif; ?>

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<?php 

$layout = $redux_demo['layout-version'];

?>

<body <?php if($layout == 2){ ?>id="boxed" <?php } ?> <?php body_class(); ?>>
    
    <?php 
        global $redux_demo;
        $trns_post_ad_title = $redux_demo['trns_post_ad_title'];
        $trns_account_title = $redux_demo['trns_account_title'];
        $trns_login_title = $redux_demo['trns_login_title'];
        $trns_logout_title = $redux_demo['trns_logout_title'];
        $trns_register_title = $redux_demo['trns_register_title'];
    ?>
	<div id="top-menu-block">

		<div class="container">

			<?php 			

			$header_version = $redux_demo['header-version'];

			?>

			<?php if($header_version == 1) { ?>

			<div class="main_menu">
				<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => 'false')); ?>
			</div>

			<?php } elseif($header_version == 2) { ?>				
			
			<div id="register-login-block-top">
				<ul class="ajax-register-links inline">
					<?php 
						if ( is_user_logged_in() ) {

						$profile = $redux_demo['profile'];						
						
						$new_post = $redux_demo['new_post'];

					?>
					<li class="first">
						<a href="<?php echo $new_post; ?>" class="ctools-use-modal ctools-modal-ctools-ajax-register-style"><?php echo $trns_post_ad_title; ?></a>
					</li>
					
					<li class="first">
						<a href="<?php echo $profile; ?>" class="ctools-use-modal ctools-modal-ctools-ajax-register-style" title="Profile"><?php echo $trns_account_title; ?></a>
					</li>
					
					<li class="last">
						<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="ctools-use-modal ctools-modal-ctools-ajax-register-style" title="Logout"><?php echo $trns_logout_title; ?></a>
					</li>
					<?php } else { 

						$login = $redux_demo['login'];
						$register = $redux_demo['register'];
					?>
					<li class="first">
						<a href="<?php echo $register; ?>" class="ctools-use-modal ctools-modal-ctools-ajax-register-style" title="Register"><?php echo $trns_register_title; ?></a>
					</li>
					<li class="last login">
						<a href="<?php echo $login; ?>" class="ctools-use-modal ctools-modal-ctools-ajax-register-style" title="Login"><?php echo $trns_login_title; ?></a>
					</li>
				<?php } ?>
				</ul>  
			</div>

			<?php } ?>

			<div class="top-social-icons">

				<?php 

					$facebook_link = $redux_demo['facebook-link'];
					$twitter_link = $redux_demo['twitter-link'];
					$dribbble_link = $redux_demo['dribbble-link'];
					$flickr_link = $redux_demo['flickr-link'];
					$github_link = $redux_demo['github-link'];
					$pinterest_link = $redux_demo['pinterest-link'];
					$youtube_link = $redux_demo['youtube-link'];
					$google_plus_link = $redux_demo['google-plus-link'];
					$linkedin_link = $redux_demo['linkedin-link'];
					$tumblr_link = $redux_demo['tumblr-link'];
					$vimeo_link = $redux_demo['vimeo-link'];

				?>

				<?php if(!empty($facebook_link)) { ?>

					<a class="target-blank" href="<?php echo $facebook_link; ?>"><i class="fa fa-facebook"></i></a>

				<?php } ?>

				<?php if(!empty($twitter_link)) { ?>

					<a class="target-blank" href="<?php echo $twitter_link; ?>"><i class="fa fa-twitter"></i></a>

				<?php } ?>

				<?php if(!empty($dribbble_link)) { ?>

					<a class="target-blank" href="<?php echo $dribbble_link; ?>"><i class="fa fa-dribbble"></i></a>

				<?php } ?>

				<?php if(!empty($flickr_link)) { ?>

					<a class="target-blank" href="<?php echo $flickr_link; ?>"><i class="fa fa-flickr"></i></a>

				<?php } ?>

				<?php if(!empty($github_link)) { ?>

					<a class="target-blank" href="<?php echo $github_link; ?>"><i class="fa fa-github"></i></a>

				<?php } ?>

				<?php if(!empty($pinterest_link)) { ?>

					<a class="target-blank" href="<?php echo $pinterest_link; ?>"><i class="fa fa-pinterest"></i></a>

				<?php } ?>

				<?php if(!empty($youtube_link)) { ?>

					<a class="target-blank" href="<?php echo $youtube_link; ?>"><i class="fa fa-youtube"></i></a>

				<?php } ?>

				<?php if(!empty($google_plus_link)) { ?>

					<a class="target-blank" href="<?php echo $google_plus_link; ?>"><i class="fa fa-google-plus"></i></a>

				<?php } ?>

				<?php if(!empty($linkedin_link)) { ?>

					<a class="target-blank" href="<?php echo $linkedin_link; ?>"><i class="fa fa-linkedin"></i></a>

				<?php } ?>

				<?php if(!empty($tumblr_link)) { ?>

					<a class="target-blank" href="<?php echo $tumblr_link; ?>"><i class="fa fa-tumblr"></i></a>

				<?php } ?>

				<?php if(!empty($vimeo_link)) { ?>

					<a class="target-blank" href="<?php echo $vimeo_link; ?>"><i class="fa fa-vimeo-square"></i></a>

				<?php } ?>

			</div>

		</div>

	</div>
																		
	<header id="navbar">

		<div class="container">

			<?php if($header_version == 2 ) { ?>

			<a class="logo pull-left" href="<?php echo home_url(); ?>" title="Home">
				<?php $logo = $redux_demo['logo']['url']; if (!empty($logo)) { ?>
					<img src="<?php echo $logo; ?>" alt="Logo" />
				<?php } else { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" />
				<?php } ?>
			</a>

			<div id="version-two-menu" class="main_menu">
				<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => 'false')); ?>
			</div>

			

			<?php } ?>
				
		</div>

	</header><!-- #masthead -->