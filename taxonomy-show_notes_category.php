<?php
/**
 * The template file to display taxonomies archive
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.57
 */
?>
<h1>category show notes</h1>
<?php
// Redirect to the template page (if exists) for output current taxonomy
if ( is_category() || is_tag() || is_tax() ) {
	$rareradio_term = get_queried_object();
	global $wp_query;
	if ( ! empty( $rareradio_term->taxonomy ) && ! empty( $wp_query->posts[0]->post_type ) ) {
		$rareradio_taxonomy  = rareradio_get_post_type_taxonomy( $wp_query->posts[0]->post_type );
		if ( $rareradio_taxonomy == $rareradio_term->taxonomy ) {
			$rareradio_template_page_id = rareradio_get_template_page_id( array(
				'post_type'  => $wp_query->posts[0]->post_type,
				'parent_cat' => $rareradio_term->term_id
			) );
			if ( 0 < $rareradio_template_page_id ) {
				wp_safe_redirect( get_permalink( $rareradio_template_page_id ) );
				exit;
			}
		}
	}
}
// If template page is not exists - display default blog archive template
get_template_part( apply_filters( 'rareradio_filter_get_template_part', rareradio_blog_archive_get_template() ) );
