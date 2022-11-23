<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

							// Widgets area inside page content
							rareradio_create_widgets_area( 'widgets_below_content' );
							?>
						</div><!-- </.content> -->
					<?php

					// Show main sidebar
					get_sidebar();

					$rareradio_body_style = rareradio_get_theme_option( 'body_style' );
					?>
					</div><!-- </.content_wrap> -->
					<?php

					// Widgets area below page content and related posts below page content
					$rareradio_widgets_name = rareradio_get_theme_option( 'widgets_below_page' );
					$rareradio_show_widgets = ! rareradio_is_off( $rareradio_widgets_name ) && is_active_sidebar( $rareradio_widgets_name );
					$rareradio_show_related = is_single() && rareradio_get_theme_option( 'related_position' ) == 'below_page';
					if ( $rareradio_show_widgets || $rareradio_show_related ) {
						if ( 'fullscreen' != $rareradio_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $rareradio_show_related ) {
							do_action( 'rareradio_action_related_posts' );
						}

						// Widgets area below page content
						if ( $rareradio_show_widgets ) {
							rareradio_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $rareradio_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				rareradio_show_post_banner('footer');
			}
			// Footer
			$rareradio_footer_type = rareradio_get_theme_option( 'footer_type' );
			if ( 'custom' == $rareradio_footer_type && ! rareradio_is_layouts_available() ) {
				$rareradio_footer_type = 'default';
			}
			get_template_part( apply_filters( 'rareradio_filter_get_template_part', "templates/footer-{$rareradio_footer_type}" ) );
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>
	
	<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	
	<script src="https://public.radio.co/playerapi/jquery.radiocoplayer.min.js"></script>
    <script>
        //jQuery(document).ready(function($) {
            //jQuery('ul.tabs').tabs();
        //});
    
    //initialise the plugin with the element
        $('.radioplayer').radiocoPlayer();
    </script>-->

</body>
</html>