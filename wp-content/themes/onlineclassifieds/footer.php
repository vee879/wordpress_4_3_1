<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */
?>
	<footer>

		<div class="container">
					
			<div class="full">
				
				<?php get_sidebar( 'footer-one' ); ?>

				<?php get_sidebar( 'footer-two' ); ?>

				<?php get_sidebar( 'footer-three' ); ?>

				<?php get_sidebar( 'footer-four' ); ?>

			</div>

			

		</div>
					
	</footer>

	<section class="socket">

		<div class="container">

			<div class="site-info">
				<?php 

					global $redux_demo; 
					$footer_copyright = $redux_demo['footer_copyright'];

				?>

				<?php if(!empty($footer_copyright)) { 
						echo $footer_copyright;
					} else {
				?>
				 &#x00040; 2014 Online Classifieds - by <a class="target-blank" href="http://52.26.21.8/">Group 3</a>
				<?php } ?>
				
			</div><!-- .site-info -->
			
			<div class="backtop">
				<a href="#backtop"><i class="fa fa-angle-up"></i></a>
			</div>

		</div>

	</section>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	<?php wp_footer(); ?>
</body>
</html>