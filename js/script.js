jQuery(() => {
    if (hma_legenda_child_js.is_product_category == 1 || hma_legenda_child_js.is_shop == 1) {
        jQuery(document).on('click', '.hma_shop_cat_filter input[type="checkbox"]', function(e) {
                jQuery('.hma_shop_cat_filter').submit()
            })
            /************* */
        jQuery(document).on('click', '.open_close_filtere_terms', function(e) {
                e.preventDefault();
                let target = jQuery(`.hma_filter_term_child[data-childof="${jQuery(this).data('childof')}"]`);
                (target.hasClass(`hma_filter_term_child_active`) == false ? target.addClass(`hma_filter_term_child_active`) : target.removeClass(`hma_filter_term_child_active`))
                jQuery('.hma_filter_term_child_active>a .fa').addClass('fa-minus').removeClass('fa-plus');
            })
            /********************** */
        jQuery('.hma_filter_term_child_active>a .fa').addClass('fa-minus').removeClass('fa-plus');
    }


})