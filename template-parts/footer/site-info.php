<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<?php
	if ( function_exists( 'the_privacy_policy_link' ) ) {
		the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
	}
	?>
	<img src="<?php bloginfo('template_url'); ?>-child/i/aphl-logo.png">
	&copy;
	<a href="<?php echo esc_url( __( 'https://github.com/APHL-Global-Health/', 'twentyseventeen' ) ); ?>" class="imprint">
		<?php printf( __( '%s', 'twentyseventeen' ), 'Association of Public Health Laboratories' ); ?>
	</a>
</div><!-- .site-info -->
