<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 1/22/2015
 * Time: 3:38 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class IZW_Report_Data extends WP_List_Table{

    /** ************************************************************************
     * Normally we would be querying data from a database and manipulating that
     * for use in your list table. For this example, we're going to simplify it
     * slightly and create a pre-built array. Think of this as the data that might
     * be returned by $wpdb->query().
     *
     * @var array
     **************************************************************************/
    var $example_data = array(
        array(
            'ID'                => 1, //Render a checkbox instead of text
            'name'              => 'Name',
            'email'             => 'nhiha60591@gmail.com',
            'phone'             => '01649 787 224',
            'promoter'          => 'T-Shirt',
            'booking_type'      => 'Jean',
            'payments'          => 100,
            'remaining'         => 200,
            'start_date'        => '2014-08-01',
            'end_date'          => '2014-09-15',
        ),
    );


    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct(){
        global $status, $page;

        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'report',     //singular name of the listed records
            'plural'    => 'reports',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );

    }


    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title()
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as
     * possible.
     *
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     *
     * For more detailed insight into how columns are handled, take a look at
     * WP_List_Table::single_row_columns()
     *
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){
        switch($column_name){
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
    function column_ID($item){
        //Return the Booking ID contents
        return sprintf('<a href="%1$s"><strong>#%2$s</strong></a>',
            /*$1%s*/ get_the_permalink( $item['ID'] ),
            /*$2%s*/ $item['ID']
        );
    }
    function column_name($item){

        return sprintf('<a href="%1$s"><strong>%2$s</strong></a>',
            /*$1%s*/ get_the_permalink( $item['ID'] ),
            /*$2%s*/ $item['name']
        );
    }
    function column_email($item){

        return sprintf('%1$s',
            /*$1%s*/ $item['email']
        );
    }
    function column_phone($item){

        return sprintf('%1$s',
            /*$1%s*/ $item['phone']
        );
    }
    function column_promoter($item){

        return sprintf('%1$s',
            /*$1%s*/ $item['promoter']
        );
    }
    function column_booking_type($item){

        return sprintf('<strong>%1$s</strong>',
            /*$1%s*/ $item['booking_type']
        );
    }
    function column_payments($item){

        return sprintf('%1$s',
            /*$1%s*/ wc_price( $item['payments'] )
        );
    }
    function column_remaining($item){

        return sprintf('%1$s',
            /*$1%s*/ wc_price( $item['remaining'] )
        );
    }
    function column_start_date($item){

        return sprintf('%1$s',
            /*$1%s*/ date( 'M jS Y', strtotime( $item['start_date'] ) )
        );
    }
    function column_end_date($item){

        return sprintf('%1$s',
            /*$1%s*/ date( 'M jS Y', strtotime( $item['end_date'] ) )
        );
    }

    function get_columns(){
        $columns = array(
            'ID'                => 'Booking ID', //Render a checkbox instead of text
            'name'              => 'Name',
            'email'             => 'Email',
            'phone'             => 'Phone Number',
            'promoter'          => 'Promoter (Product Category)',
            'booking_type'      => 'Booking Type (Product)',
            'payments'          => 'Payments',
            'remaining'         => 'Remaining',
            'start_date'        => 'Start Date',
            'end_date'          => 'End Date',
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'name'     => array('name',false),     //true means it's already sorted
            'email'    => array('email',false),
            'ID'  => array('ID',false)
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {



    }

    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 10;



        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();


        /**
         * REQUIRED. Finally, we build an array to be used by the class for column
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);


        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();


        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example
         * package slightly different than one you might build on your own. In
         * this example, we'll be using array manipulation to sort and paginate
         * our data. In a real-world implementation, you will probably want to
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        $data = array();
        if( isset( $_REQUEST['izw_search'])){
            $data = $this->example_data;
            print_r( $_REQUEST );
        }else {
            $orderargs = array(
                'post_type' => 'shop_order',
                'posts_per_page' => -1,
                'post_status' => array('wc-pending', 'wc-processing', 'wc-on-hold', 'wc-completed', 'wc-cancelled', 'wc-refunded', 'wc-failed')
            );
            $order_data = new WP_Query($orderargs);
            if ($order_data->have_posts()) {
                foreach ($order_data->posts as $orderitem) {
                    $order = new WC_Order($orderitem->ID);
                    $promoter = wp_get_post_terms($orderitem->ID, 'promoter');
                    $booking = '';
                    foreach ($order->get_items() as $item) {
                        $product = get_post($item['product_id']);
                        $booking .= '<a href="' . get_the_permalink($item['product_id']) . '">' . $product->post_title . '</a>';
                    }
                    if (is_wp_error($promoter)) {
                        $promoter = '<strong>' . $promoter->get_error_message() . '</strong>';
                    }
                    $data[] = array(
                        'ID' => $orderitem->ID, //Render a checkbox instead of text
                        'name' => $order->billing_first_name . " " . $order->billing_last_name,
                        'email' => $order->billing_email,
                        'phone' => $order->billing_phone,
                        'promoter' => $promoter,
                        'booking_type' => $booking,
                        'payments' => $order->get_subtotal(),
                        'remaining' => $order->get_total(),
                        'start_date' => $orderitem->post_date,
                        'end_date' => '2014-09-15',
                    );
                }
            }
            wp_reset_postdata();
        }


        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         *
         * In a real-world situation involving a database, you would probably want
         * to handle sorting by passing the 'orderby' and 'order' values directly
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');


        /***********************************************************************
         * ---------------------------------------------------------------------
         * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
         *
         * In a real-world situation, this is where you would place your query.
         *
         * For information on making queries in WordPress, see this Codex entry:
         * http://codex.wordpress.org/Class_Reference/wpdb
         *
         * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
         * ---------------------------------------------------------------------
         **********************************************************************/


        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently
         * looking at. We'll need this later, so you should always include it in
         * your own package classes.
         */
        $current_page = $this->get_pagenum();

        /**
         * REQUIRED for pagination. Let's check how many items are in our data array.
         * In real-world use, this would be the total number of items in your database,
         * without filtering. We'll need this later, so you should always include it
         * in your own package classes.
         */
        $total_items = count($data);


        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);



        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where
         * it can be used by the rest of the class.
         */
        $this->items = $data;


        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }

}