<?php
/**
 * Displays the footer widget areas.
 *
 * @package Primer
 * @since   1.0.0
 */

$sidebars = primer_get_active_footer_sidebars();

if ( $sidebars ) :

	?>
	<div class="container footer-widget-area">

	<?php foreach ( $sidebars as $sidebar ) : ?>

		<div class="footer-widget">

			<?php dynamic_sidebar( $sidebar ); ?>

		</div>

	<?php endforeach; ?>

	</div>
	<?php

endif;
