<?php
/**
 * The template for displaying the header.
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Primer
 * @since   1.0.0
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">	

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php

	/**
	 * Fires inside the `<body>` element.
	 *
	 * @since 1.0.0
	 */
	do_action( 'primer_body' );

	?>

	<div id="page" class="hfeed site">

		<?php

		/**
		 * Fires before the `<header>` element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_before_header' );

		?>

		<header id="masthead" class="site-header" role="banner">
			<?php

			/**
			 * Render the video header element
			 *
			 * @hooked primer_video_header - 5
			 *
			 * @since 1.7.0
			 */
			do_action( 'primer_before_header_wrapper' );

			?>

			<div class="site-header-wrapper">
				<div class="site-title-wrapper">

					<a href="http://127.0.0.1/thfine2/" class="custom-logo-link" rel="home" itemprop="url"><img width="180px" src="http://127.0.0.1/thfine2/wp-content/uploads/2018/03/thfine2.svg" class="custom-logo" alt="Shandong ThFine Chemical Co.,Ltd" itemprop="logo"></a>
					
				</div>
				<?php

						/**
						 * Fires after the `<header>` element.
						 *
						 * @hooked primer_add_primary_navigation - 11
						 *
						 * @since 1.0.0
						 */
						do_action( 'primer_after_header' );

						?>
                <form role="search" method="get" class="search-form" action="http://127.0.0.1/thfine2/">
					<label>
						<span class="screen-reader-text">Search for:</span>
						<input type="search" class="search-field" placeholder="Search …" value="" name="s">
					</label>
					<input type="submit" class="search-submit" value="Search">
			    </form>
			</div><!-- .site-header-wrapper -->

			<?php

			/**
			 * Fires inside the `<div class="site-header-wrapper">` element.
			 *
			 * @since 1.0.0
			 */
			do_action( 'primer_after_site_header_wrapper' );

			?>

		</header><!-- #masthead -->


<?php if( is_front_page() ){ ?>
	    <div id="site-banner">
	    	<div id="site-banner-text"><h2>ThFine focus chemical AAAAA</h2></div>
	    </div>
	    <?php } ?>
		<div id="content" class="site-content">
			