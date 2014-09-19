<?php

/*
Plugin Name: GCM Slider
Plugin URI: http://goldcoastmultimedia.com.au
Description: Base on BX Slider
Version: 1.0
Author: GCM
Author URI: http://goldcoastmultimedia.com.au
*/

$wordpress_gcm_slider = new GCMSlider();
class GCMSlider {
    var $post_type = 'gcm-slider';
    
    function __construct() {
        add_action('init', array(&$this, 'init'));
        add_shortcode('gcmslider', array(&$this, 'shortcode'));
    }
    
    function init() {
        $labels = array(
            'name'               => 'GCM Home Slider',
            'singular_name'      => 'GCM Home Slider',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Slider',
            'edit_item'          => 'Edit Slider',
            'new_item'           => 'New Slider',
            'all_items'          => 'All Sliders',
            'view_item'          => 'View Sliders',
            'search_items'       => 'Search Sliders',
            'not_found'          => 'No sliders found',
            'not_found_in_trash' => 'No sliders found in Trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'GCM Home Slider'
        );

            $args = array(
                'labels'             => $labels,
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'gcm-slider' ),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => 20,
                'supports'           => array( 'title', 'editor' )
            );

            register_post_type( $this->post_type, $args );
          
            // Register scripts and styles
            wp_enqueue_script( 'jquery' );
            wp_register_script( 'bxslider',plugins_url( 'js/jquery.bxslider.min.js' , __FILE__ ), array('jquery') );
            wp_register_style( 'bxslider', plugins_url( 'css/jquery.bxslider.css' , __FILE__ ) );
            wp_enqueue_style( 'bxslider' );
            wp_enqueue_script('bxslider');
    }
    
    function shortcode() {
        $args = array(
            'post_type' => 'gcm-slider',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $query = new WP_Query( $args );
        ob_start(); 
        ?>

        <?php if ( $query->have_posts() ) : ?>
        <ul class="bxslider">
            <?php while( $query->have_posts() ) : $query->the_post(); ?>
            <li>
            <?php echo get_the_content(); ?>
            </li>
            <?php endwhile; ?>
        </ul>
        <?php endif; ?>

        <?php
        /* Restore original Post Data */
        wp_reset_postdata();
        return ob_get_clean(); 
    }
    
}