<?php
/**
 * Child-Theme functions and definitions
 */

function rareradio_child_enqueue_child_styles() {
    $parent_style = 'parent-style'; 
        wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css' );
        wp_enqueue_style( 
            'child-style', 
            get_stylesheet_directory_uri() . '/style.css',
            array( $parent_style ),
            wp_get_theme()->get('Version') );
        }
    add_action( 'wp_enqueue_scripts', 'rareradio_child_enqueue_child_styles' );

    add_filter('acf/settings/remove_wp_meta_box', '__return_false');

?>