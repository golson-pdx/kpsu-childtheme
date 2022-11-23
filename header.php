<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( rareradio_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://use.typekit.net/zyd7ofn.css">
</head>

<body <?php	body_class(); ?>>
    <?php wp_body_open(); ?>

	<?php do_action( 'rareradio_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">
			<?php
			// Desktop header
			$rareradio_header_type = rareradio_get_theme_option( 'header_type' );
			if ( 'custom' == $rareradio_header_type && ! rareradio_is_layouts_available() ) {
				$rareradio_header_type = 'default';
			}
			get_template_part( apply_filters( 'rareradio_filter_get_template_part', "templates/header-{$rareradio_header_type}" ) );

			// Side menu
			if ( in_array( rareradio_get_theme_option( 'menu_style' ), array( 'left', 'right' ) ) ) {
				get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-navi-side' ) );
			}

			// Mobile menu
			get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-navi-mobile' ) );
			
			// Single posts banner after header
			rareradio_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {

					rareradio_show_post_banner( 'background' );

					$rareradio_post_thumbnail_type  = rareradio_get_theme_option( 'post_thumbnail_type' );
					$rareradio_post_header_position = rareradio_get_theme_option( 'post_header_position' );
					$rareradio_post_header_align    = rareradio_get_theme_option( 'post_header_align' );

					// Boxed post thumbnail
					if ( in_array( $rareradio_post_thumbnail_type, array( 'boxed', 'fullwidth') ) ) {
						ob_start();
						?>
						<div class="header_content_wrap header_align_<?php echo esc_attr( $rareradio_post_header_align ); ?>">
							<?php
							if ( 'boxed' === $rareradio_post_thumbnail_type ) {
								?>
								<div class="content_wrap">
								<?php
							}

							// Post title and meta
							if ( 'above' === $rareradio_post_header_position ) {
								rareradio_show_post_title_and_meta();
							}

							// Featured image
							rareradio_show_post_featured_image();

							// Post title and meta
							if ( in_array( $rareradio_post_header_position, array( 'under', 'on_thumb' ) ) ) {
								rareradio_show_post_title_and_meta();
							}

							if ( 'boxed' === $rareradio_post_thumbnail_type ) {
								?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
						$rareradio_post_header = ob_get_contents();
						ob_end_clean();
						if ( strpos( $rareradio_post_header, 'post_featured' ) !== false
							|| strpos( $rareradio_post_header, 'post_title' ) !== false
							|| strpos( $rareradio_post_header, 'post_meta' ) !== false
						) {
							rareradio_show_layout( $rareradio_post_header );
						}
					}
				}

				// Widgets area above page content
				$rareradio_body_style   = rareradio_get_theme_option( 'body_style' );
				$rareradio_widgets_name = rareradio_get_theme_option( 'widgets_above_page' );
				$rareradio_show_widgets = ! rareradio_is_off( $rareradio_widgets_name ) && is_active_sidebar( $rareradio_widgets_name );
				if ( $rareradio_show_widgets ) {
					if ( 'fullscreen' != $rareradio_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					rareradio_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $rareradio_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}
				}

				// Content area
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $rareradio_body_style ? '_fullscreen' : ''; ?>">

					<div id="main_page_content" class="content">
						<?php
						// Widgets area inside page content
						rareradio_create_widgets_area( 'widgets_above_content' );
