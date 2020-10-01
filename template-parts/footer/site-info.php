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
	<img style="height:10%;width:10%;" src="<?php bloginfo('template_url'); ?>-child/i/coat_of_arms.png">
	&copy;
	<a href="<?php echo esc_url( __( 'https://nphl.go.ke/', 'twentyseventeen' ) ); ?>" class="imprint">
		<?php printf( __( '%s', 'twentyseventeen' ), 'National Public Health Laboratory' ); ?>
	</a>
</div><!-- .site-info -->
