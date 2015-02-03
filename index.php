<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 1/22/2015
 * Time: 3:04 PM
 */
/*
Plugin Name: Woocommerce Report Categories
Plugin URI: https://github.com/nhiha60591/woocommerce-report-category
Description: Report Sale by categories
Version: 1.0.1
Author: Huu Hien
Author URI: https://github.com/nhiha60591
Text Domain: izweb-report-category
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( ! class_exists( 'IZW_Report' ) ) :
    class IZW_Report{
        /**
         * Construct Class
         */
        function __construct(){
            $this->defines();
            add_action( 'init', array( $this, 'init') );
            add_filter( 'woocommerce_reports_charts', array( $this, 'add_report_tab') );
        }

        /**
         * Set Init Function
         */
        function init(){
            $this->register_taxonomy();
            wp_register_style( 'izw-report-style', plugins_url( 'assets/admin/style.css', __FILE__ ) );
            wp_register_script( 'izw-report-script', plugins_url( 'assets/admin/js/admin.js', __FILE__ ) );
        }

        /**
         * Define Constant
         */
        function defines(){
            define( '__TEXTDOMAIN__', 'izweb-report-category' );
        }

        /**
         * Add Report Tab
         *
         * @param $reports
         * @return mixed
         */
        function add_report_tab( $reports ){
            $reports['category'] = array(
                'title'  => __( 'Sale by Categories', 'woocommerce' ),
                'reports' => array(
                    "categories" => array(
                        'title'       => __( 'Sale Categories', 'woocommerce' ),
                        'description' => '',
                        'hide_title'  => true,
                        'callback'    => array( $this, 'get_report' )
                    ),
                )
            );
            return $reports;
        }

        /**
         * Load Report List Page
         */
        function get_report(){
            $assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
            wp_enqueue_script( 'chosen' );
            wp_enqueue_script( 'wc-chosen' );
            wp_enqueue_script( 'izw-report-script' );
            wp_enqueue_style( 'woocommerce_chosen_styles', $assets_path . 'css/chosen.css' );
            wp_enqueue_style( 'izw-report-style' );
            include("includes/class-list-report-data.php");
            include("templates/html-admin-report.php");
        }

        /**
         * Register Taxonomy
         */
        function register_taxonomy(){
            // Add new taxonomy, make it hierarchical (like categories)
            $labels = array(
                'name'              => _x( 'Locations', 'taxonomy general name' ),
                'singular_name'     => _x( 'Location', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Locations' ),
                'all_items'         => __( 'All Locations' ),
                'parent_item'       => __( 'Parent Location' ),
                'parent_item_colon' => __( 'Parent Location:' ),
                'edit_item'         => __( 'Edit Location' ),
                'update_item'       => __( 'Update Location' ),
                'add_new_item'      => __( 'Add New Location' ),
                'new_item_name'     => __( 'New Location Name' ),
                'menu_name'         => __( 'Locations' ),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'location' ),
            );

            register_taxonomy( 'location', array( 'product' ), $args );
        }
    }
    new IZW_Report();
endif;