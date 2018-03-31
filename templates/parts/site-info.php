<?php
/**
 * Displays the footer site info.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="site-info-wrapper">

		<div class="container">

			<?php

			/**
			 * Fires inside the `.site-info` element.
			 *
			 * @hooked primer_add_footer_navigation - 5
			 * @hooked primer_add_social_navigation - 7
			 * @hooked primer_add_credit - 10
			 *
			 * @since 1.0.0
			 */
			do_action( 'primer_site_info' );

			?>

		</div>

</div><!-- .site-info-wrapper -->
