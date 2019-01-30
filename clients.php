<?php
/**
 * Template Name: Client Area
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

include('controllers/ClientsController.php');

get_header();

?>

<div class="wrap">
    <div id="primary" class="content-area" style="padding-top: 0;">
        <main id="main" class="site-main" role="main">
            <div class="row d-print-none">
                <div class="col">
                    <h4>Client Area</h4>
                </div>
                <?php
                if (isset($currentUser->name)) {
                ?>
                <div class="col" style="text-align: right;font-size: 0.75em;">
                    <span>
                        Logged in as 
                        <?php echo "{$currentUser->name} - {$currentUser->facility_name}"; ?> |    
                    </span>
                    <form method="POST" action="<?php echo get_site_url().'/clients/'; ?>" id="client_logout_link" style="display: inline-block;">
                        <input type="hidden" name="api_code" value="1">
                        <a href="#" onclick="document.getElementById('client_logout_link').submit();">Logout</a>
                    </form>
                </div>
                <?php
                }
                ?>

            </div>
            <?php
                include($COEPageURI['clients'][$COEPage]);
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .wrap -->


<?php 

include('views/clients/dialogs.php');

get_footer();

include('views/clients/js.php');

?>