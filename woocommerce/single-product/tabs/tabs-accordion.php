<?php
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : $selectIds = '#collapse-tab-0'; ?>
    
    <div class="wc-tabs-wrapper" id="woocommerce-tabs" data-ride="carousel">
        <div id="woocommerce-accordion">

            <?php $i = 0;
            foreach ($product_tabs as $key => $product_tab): $in = ($i == 0) ? 'show' : '';
                $arrow = ($i == 0) ? 'minus' : 'plus';
                $expanded = ($i == 0) ? true : false;
                $i++; ?> 
                <div class="panel">

                    <div class="tabs-title" id="xptheme-wc-tab-<?php echo esc_attr($key); ?>">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapse-tab-<?php echo esc_attr($i); ?>" aria-expanded="true" aria-controls="collapse-tab-<?php echo esc_attr($i); ?>">
                        <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($product_tab['title']), $key); ?>
                        <i class="icons xp-icon xp-icon-<?php echo esc_attr($arrow); ?>-square"></i>
                        </button>
                      </h5>
                    </div> 

                    <div id="collapse-tab-<?php echo esc_attr($i); ?>" class="collapse <?php echo esc_attr($in); ?>" aria-labelledby="xptheme-wc-tab-<?php echo esc_attr($key); ?>" data-bs-parent="#woocommerce-accordion">
                      <div class="entry-content">
                        <?php call_user_func($product_tab['callback'], $key, $product_tab); ?>
                      </div>
                    </div>

                </div>
            <?php $selectIds .= ',#collapse-tab-' . $i; endforeach ?>

        </div>

        <?php do_action('woocommerce_product_after_tabs'); ?>
    </div>

    <script type="text/javascript">
        jQuery(function ($) {
            var selectIds = $('<?php echo trim($selectIds); ?>');
            selectIds.on('show.bs.collapse hidden.bs.collapse', function (e) {
                $(this).prev().find('.icons').toggleClass('xp-icon-minus-square xp-icon-plus-square');
            })
        });
    </script>


<?php endif; ?>
