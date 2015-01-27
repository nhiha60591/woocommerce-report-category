<div class="izw-report-categories">
    <h2><?php _e( "Report by Categories", __TEXTDOMAIN__ ); ?></h2>
    <?php
        $listdata = new IZW_Report_Data();
        $listdata->prepare_items();
    ?>
    <form name="izw-search-box" action="" method="get">
    <div class="izw-row" id="izw-row">
        <div class="izw-column">
            <div class="izw-information">
                <div class="izw-counter">
                    <p>Viewing: <?php echo implode( ", ", $listdata->view_type ); ?></p>
                    <p>Total Nr of Beds: <?php echo $listdata->beds_total; ?></p>
                </div>
                <div class="izw-money">
                    <h2>Money received Total: <?php echo wc_price( $listdata->received_total); ?></h2>
                    <h3>Money outstanding Total: <?php echo wc_price( $listdata->outstanding_total ); ?></h3>
                </div>
            </div>
        </div><!-- END .izw-column -->
        <div class="izw-column">
            <div class="izw-dropdown">
                <select name="izw_promoter">
                    <option value="">Select Promoter</option>
                    <?php
                    $bookable_products = array( '' => __( 'N/A', 'woocommerce-bookings' ) );
                    $promoterargs = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'product_type',
                                'field'    => 'slug',
                                'terms'    => 'booking'
                            )
                        ),
                    );
                    $promoter = new WP_Query( $promoterargs );
                    if( $promoter->have_posts() ){
                        while( $promoter->have_posts() ):
                            $promoter->the_post();
                        ?>
                            <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
                        <?php
                        endwhile;
                    }
                    ?>
                </select>
                <select name="izw_location">
                    <option value="">Select Location</option>
                    <?php
                    $args = array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => false,
                        'exclude' => array(),
                        'exclude_tree' => array(),
                        'include' => array(),
                        'number' => '',
                        'fields' => 'all',
                        'slug' => '',
                        'name' => '',
                        'parent' => '',
                        'hierarchical' => true,
                        'child_of' => 0,
                        'get' => '',
                        'name__like' => '',
                        'description__like' => '',
                        'pad_counts' => false,
                        'offset' => '',
                        'search' => '',
                        'cache_domain' => 'core'
                    );

                    $terms = get_terms('location', $args);
                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            ?>
                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div><!-- END .izw-column -->
        <div class="izw-column">
            <div class="izw-search-box">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>"/>
                    <input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>"/>
                    <p>
                        <select name="izw_search_key[]" multiple id="izw-search-key" data-placeholder="Select Categories">
                            <?php
                            $args = array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'exclude' => array(),
                                'exclude_tree' => array(),
                                'include' => array(),
                                'number' => '',
                                'fields' => 'all',
                                'slug' => '',
                                'name' => '',
                                'parent' => '',
                                'hierarchical' => true,
                                'child_of' => 0,
                                'get' => '',
                                'name__like' => '',
                                'description__like' => '',
                                'pad_counts' => false,
                                'offset' => '',
                                'search' => '',
                                'cache_domain' => 'core'
                            );

                            $terms = get_terms('product_cat', $args);
                            if (!empty($terms) && !is_wp_error($terms)) {
                                foreach ($terms as $term) {
                                    ?>
                                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="submit" name="izw_search" class="button button-primary" value="Search"/>
                    </p>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            $("#izw-search-key").chosen({width: "80%"});
                        });
                    </script>
            </div><!-- END .izw-search-box -->
        </div><!-- END .izw-column -->
    </div><!-- END .izw-row -->
    </form>
    <div class="izw-search-data">
        <?php
            $listdata->display();
        ?>
    </div>
</div><!-- END .izw-report-categories-->