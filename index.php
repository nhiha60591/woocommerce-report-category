<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 1/22/2015
 * Time: 3:04 PM
 */
/*
Plugin Name: Woocommerce Report Categories
Plugin URI: https://github.com/nhiha60591/izweb-import/
Description: Import File from zip file
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
        function __construct(){
            $this->defines();
            add_action( 'init', array( $this, 'init') );
            add_filter( 'woocommerce_reports_charts', array( $this, 'add_report_tab') );
        }
        function init(){

        }
        function defines(){
            define( '__TEXTDOMAIN__', 'izweb-report-category' );
        }
        function add_report_tab( $reports ){
            $reports['category'] = array(
                'title'  => __( 'Sale Categories', 'woocommerce' ),
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
        function get_report(){
            $assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
            wp_enqueue_script( 'chosen' );
            wp_enqueue_script( 'wc-chosen' );
            wp_enqueue_style( 'woocommerce_chosen_styles', $assets_path . 'css/chosen.css' );
            include("includes/class-list-report-data.php");
            include("templates/html-admin-report.php");
        }
    }
    new IZW_Report();
endif;