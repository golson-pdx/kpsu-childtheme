<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */
?>

<?php
    $user = get_user_by("login","studentmediadeveloper2");
    $userId = $user->ID;
    $userName = $user->user_login;
    $userEmail = $user->user_email;
    $userDisplay = $user->display_name;
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
			<?php echo wp_kses( wpautop( get_user_meta($userId, 'description', true) ), 'rareradio_kses_content' ); ?>
			<?php do_action( 'rareradio_action_user_meta' ); ?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( $userId ) ); ?>" rel="author">
													<?php
													// Translators: Add the author's name in the <span>
													printf( esc_html__( 'View all posts by %s', 'rareradio' ), '<span class="author_name">' . esc_html( $userDisplay ) . '</span>' );
													?>
			</a>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->
	<div class="child-author_avatar_wrap column-1_2">
		<div class="child-author_avatar" itemprop="image">
			<?php
			$rareradio_mult = rareradio_get_retina_multiplier();
			echo get_avatar( $userEmail, 370 * $rareradio_mult );
			?>
		</div><!-- .author_avatar -->
	</div>
	</div>

</div><!-- .author_info -->
