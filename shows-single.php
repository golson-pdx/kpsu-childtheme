<?php
 /* Template Name: Shows Template */ 
 /* Template Post Type: post, page, mp-event */

get_header();

while ( have_posts() ) {
	the_post();

	// Prepare theme-specific vars:

	// Full post loading
	$full_post_loading        = rareradio_get_value_gp( 'action' ) == 'full_post_loading';

	// Prev post loading
	$prev_post_loading        = rareradio_get_value_gp( 'action' ) == 'prev_post_loading';

	// Position of the related posts
	$rareradio_related_position = rareradio_get_theme_option( 'related_position' );

	// Type of the prev/next posts navigation
	$rareradio_posts_navigation = rareradio_get_theme_option( 'posts_navigation' );
	$rareradio_prev_post        = false;

	if ( 'scroll' == $rareradio_posts_navigation ) {
		$rareradio_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $rareradio_prev_post ) {
			$rareradio_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $rareradio_prev_post ) {
				$rareradio_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $rareradio_prev_post ) ) {
		rareradio_storage_set_array( 'options_meta', 'post_thumbnail_type', 'default' );
		if ( rareradio_get_theme_option( 'post_header_position' ) != 'below' ) {
			rareradio_storage_set_array( 'options_meta', 'post_header_position', 'above' );
		}
		rareradio_sc_layouts_showed( 'featured', false );
		rareradio_sc_layouts_showed( 'title', false );
		rareradio_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $rareradio_related_position, 'inside' ) === 0 ) {
		ob_start();
	}
	?>
	
	<div class="new-div">
		<h2>About the Show</h2>
	</div>
	
	<!--<div class="cats">-->
	
	<?php
	//Categories
    $taxonomy = 'mp-event_category';
    $terms = get_terms($taxonomy); // Get all terms of a taxonomy
    $eventcat;
    
    if ( $terms && !is_wp_error( $terms ) ) :
    ?>
            <?php foreach ( $terms as $term ) { 
                if($term->name == get_the_title()) {
                    $eventcat = $term->slug;
                }?>
            <?php } ?>
    <?php endif;?>

    <!--<p>Cat slug=
    <?php //echo $eventcat ?>
    </p>

    <i>End of ignore</i>-->
    

	<?php
	// Display post's content
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', get_post_format() ), get_post_format() );

	// If related posts should be inside the content
	if ( strpos( $rareradio_related_position, 'inside' ) === 0 ) {
		$rareradio_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'rareradio_action_related_posts' );
		$rareradio_related_content = ob_get_contents();
		ob_end_clean();

		$rareradio_related_position_inside = max( 0, min( 9, rareradio_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $rareradio_related_position_inside ) {
			$rareradio_related_position_inside = mt_rand( 1, 9 );
		}
		
		$rareradio_p_number = 0;
		$rareradio_related_inserted = false;
		for ( $i = 0; $i < strlen( $rareradio_content ) - 3; $i++ ) {
			if ( $rareradio_content[ $i ] == '<' && $rareradio_content[ $i + 1 ] == 'p' && in_array( $rareradio_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$rareradio_p_number++;
				if ( $rareradio_related_position_inside == $rareradio_p_number ) {
					$rareradio_related_inserted = true;
					$rareradio_content = ( $i > 0 ? substr( $rareradio_content, 0, $i ) : '' )
										. $rareradio_related_content
										. substr( $rareradio_content, $i );
				}
			}
		}
		if ( ! $rareradio_related_inserted ) {
			$rareradio_content .= $rareradio_related_content;
		}

		rareradio_show_layout( $rareradio_content );
	}
	
	//Show Notes
	?>
	<h2>Latest Show Notes</h2>
	<div class="show-notes columns_wrap posts_container columns_padding_bottom">
	    <?php
	        $category = get_the_title();
            $args = array(
                'post_type' => 'show-notes',
                '$max_num_pages' => 4,
                'category_name' => $category
            );
        
            $post_query = new WP_Query($args);
        
            if($post_query->have_posts() ) {
                while($post_query->have_posts() ) {
                    $post_query->the_post();
                    ?>
                     <div class="column-1_4">
                        <div class="show-note">
                            <h5 class="post_title entry-title">
                                <a href="<?php the_permalink(); ?>" role="link">
                                    <?php the_title(); ?>
                                </a>
                            </h5>
                            <p class="shownotes-data" data-wahfont="18"><span class="author"><?php the_author(); ?></span><br><span class="date"><?php echo get_the_date('m/d/Y'); ?></span></p>
                        </div>
                    </div>
                    <?php
                    }
                     wp_reset_postdata();
                }
            else {?>
                <p>No show notes yet for this show.</p>
                <?php
            }
        ?>
	</div>
	<div class="show-notes-link">
	    <a href="https://kpsu.org/redesign/show_notes_category/<?php echo $eventcat ?>">All Show Notes <span class="icon-arrow-right-alt" data-wahfont="21">&nbsp;</span></a>
	</div>
	<?php
	
	// Author bio
	?>
		<div class="bio">
		<?php
            $userDisplay = get_post_meta($post->ID, 'DJ Name', true);
            $userBio = get_post_meta($post->ID, 'DJ Bio', true);
            $userImg = get_post_meta($post->ID, 'DJ Avatar', true);
        ?>
        
        <div class="author_info scheme_dark author vcard heylol" itemprop="author" itemscope itemtype="//schema.org/Person">
            <div class="columns_wrap posts_container columns_padding_bottom">
            <div class="child-author_description column-1_2">
        		<h5 class="child-author_title" itemprop="name">
        		<?php
        			// Translators: Add the author's name in the <span>
        			echo wp_kses_data( sprintf( __( 'About %s', 'rareradio' ), '<span class="fn">' . $userDisplay . '</span>' ) );
        		?>
        		</h5>
        
        		<div class="child-author_bio" itemprop="description">
        			<?php echo wp_kses( wpautop( $userBio ), 'rareradio_kses_content' ); ?>
        		</div><!-- .author_bio -->
        
        	</div><!-- .author_description -->
        	<div class="child-author_avatar_wrap column-1_2">
        		<div class="child-author_avatar" itemprop="image">
        		    <img src="<?php echo $userImg ?>" alt="<?php echo $userDisplay ?> "/>
        		</div><!-- .author_avatar -->
        	</div>
        	</div>
        
        </div><!-- .author_info -->
		</div>
	<?php


	if ( 'scroll' == $rareradio_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $rareradio_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $rareradio_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $rareradio_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
