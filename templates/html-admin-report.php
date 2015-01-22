<div class="izw-report-categories">
    <h2><?php _e( "Report by Categories", __TEXTDOMAIN__ ); ?></h2>
    <div class="izw-search-box">
        <form name="izw-search-box" action="" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
            <input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>" />
            <p>
                <select name="izw_search_key[]" multiple id="izw-search-key" data-placeholder="Select Categories">
                    <?php
                    $args = array(
                        'orderby'           => 'name',
                        'order'             => 'ASC',
                        'hide_empty'        => false,
                        'exclude'           => array(),
                        'exclude_tree'      => array(),
                        'include'           => array(),
                        'number'            => '',
                        'fields'            => 'all',
                        'slug'              => '',
                        'name'              => '',
                        'parent'            => '',
                        'hierarchical'      => true,
                        'child_of'          => 0,
                        'get'               => '',
                        'name__like'        => '',
                        'description__like' => '',
                        'pad_counts'        => false,
                        'offset'            => '',
                        'search'            => '',
                        'cache_domain'      => 'core'
                    );

                    $terms = get_terms('product_cat', $args);
                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                        foreach ( $terms as $term ) {
                            ?>
                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <input type="submit" name="izw_search" class="button button-primary" value="Search" />
            </p>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    $("#izw-search-key").chosen({width: "100px"});
                });
            </script>
        </form>
    </div>
    <div class="izw-search-data">
        <?php
            $listdata = new IZW_Report_Data();
            $listdata->prepare_items();
            $listdata->display();
        ?>
    </div>
</div><!-- END .izw-report-categories-->