<?php
/**
 * Template Name: Thermometers
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

if (!is_user_logged_in()) {
    get_header();
    echo "<div class='calibration-login'>";
    echo "<p>Sign in to access this content!</p>";
    wp_login_form(array('echo' => true));
    echo "</div>";
    get_footer();
}else{

    include('controllers/ThermometersController.php');

get_header();

?>

<div class="wrap">
    <div id="primary" class="content-area" style="padding-top: 0;">
        <main id="main" class="site-main" role="main">
            <div class="row d-print-none">
                <div class="dropdown">
                    <button class="btn btn-outline-light" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="oi" data-glyph="menu" title="menu" aria-hidden="true" style="color: #000;"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/conditioned-chambers/">Conditioned Chambers</a>
                    </div>
                </div>
                <div class="col">
                    <h4>Thermometers</h4>
                </div>
                <div class="col" style="text-align: right;font-size: 0.75em;">
                    <span>
                        Logged in as <?php echo $currentUser->display_name; ?> |    
                        <a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
                    </span>
                </div>
            </div>
            <?php
                include($COEPageURI['thermometers'][$COEPage]);
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .wrap -->


<?php 

    include('views/thermometers/dialogs.php');

    get_footer();

    include('views/thermometers/js.php');

}
?>