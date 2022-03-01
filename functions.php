<?php
class HMA_Legenda_child
{
	function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'hma_wp_enqueue_scripts']);
		add_filter('wpo_wcpdf_invoice_title', [$this, 'hma_wpo_wcpdf_invoice_title'], 10, 2);
		add_shortcode('show_loggedin_as1', [$this, 'hma_show_loggedin_as1']);
		add_filter('yikes_woo_filter_all_product_tabs', [$this, 'hma_yikes_woo_filter_all_product_tabs'], 10, 2);
		add_action('init', [$this, 'hma_init']);
		add_filter('use_widgets_block_editor', '__return_false');
		add_filter('woocommerce_get_price_html', [$this, 'hma_woocommerce_get_price_html'], 10, 2);
		add_action('woocommerce_product_query', [$this, 'hma_woocommerce_product_query']);
		add_shortcode('hma_shop_page_terms_list', [$this, 'hma_shop_page_terms_list']);
		add_filter('widget_text', 'do_shortcode');
		add_action('wp_footer', [$this, 'hma_wp_footer']);
	}
	function hma_wp_enqueue_scripts()
	{
		wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('et-font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.css', array('fonts'));

		if (is_rtl()) {
			wp_enqueue_style("rtl-style", get_stylesheet_directory_uri() . '/rtl.css', array('parent-style'));
		}
		wp_enqueue_script('hma_legenda_child_js', get_stylesheet_directory_uri() . '/js/script.js', ['jquery'], '0.0.1', true);
		$is_product_category = $is_shop = false;
		if (is_product_category()) {
			$is_product_category = true;
		}
		if (is_shop()) {
			$is_shop = true;
		}
		wp_localize_script('hma_legenda_child_js', 'hma_legenda_child_js', [
			'is_product_category' => $is_product_category,
			'is_shop' => $is_shop,
		]);
	}
	function hma_wpo_wcpdf_invoice_title($title, $document)
	{
		$title = 'Online Proforma Invoice';
		return $title;
	}
	function hma_show_loggedin_as1($atts)
	{

		global $current_user, $user_login;

		wp_get_current_user();
		add_filter('widget_text', 'do_shortcode');
		if ($user_login)
			return ' <b>Welcome</b> <b>' . $current_user->display_name . '</b><b>!</b>';
		else
			return '<a href="' . site_url() . '/login"><b>PLEASE LOGIN TO YOUR ACCOUNT</b></a>';
	}
	function hma_yikes_woo_filter_all_product_tabs($tabs, $product)
	{

		if (isset($tabs['discount']) && !is_user_logged_in()) {
			unset($tabs['discount']);
		}

		return $tabs;
	}
	function hma_init()
	{
		$this->hma_hide_add_cart_not_logged_in();
	}
	function hma_hide_add_cart_not_logged_in()
	{
		if (!is_user_logged_in()) {

			remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
		}
	}
	function hma_etheme_wc_product_labels($product_id = '')
	{
		echo $this->hma_etheme_wc_get_product_labels($product_id);
	}
	function hma_etheme_wc_get_product_labels($product_id = '')
	{
		global $post, $wpdb, $product;
		$count_labels = 0;
		$output = '';

		if (etheme_get_option('sale_icon')) :
			if ($product->is_on_sale()) {
				$count_labels++;
				$classes = ['hma_sale_label'];
				if (is_shop() || is_product_category()) {
					$classes[] = 'hma_shop_sale_label';
				} else if (is_product()) {
					$classes[] = 'hma_product_sale_label';
				}
				$output .= '<span class="' . implode(' ', $classes) . '">-' . number_format(($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price() * 100) . '%</span>';
				// $output .= '<span class="label-icon sale-label">' . __('SSSale!', 'legenda') . '</span>';
			}
		endif;

		if (etheme_get_option('new_icon')) : $count_labels++;
			if (etheme_product_is_new($product_id)) :
				$second_label = ($count_labels > 1) ? 'second_label' : '';
				$output .= '<span class="label-icon new-label ' . $second_label . '">' . __('New!', 'legenda') . '</span>';
			endif;
		endif;
		return $output;
	}
	function hma_woocommerce_get_price_html($price, $instance)
	{
		if (is_product()) {
			global $product;
			$price = $this->hma_etheme_wc_product_labels($product->get_id());
			return $price;
		}
		return $price;
	}
	function hma_woocommerce_product_query($query)
	{
		if (is_shop() && isset($_GET['term']) && !empty($_GET['term'])) {
			$tax_query = [
				[
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => $_GET['term'],
					'operator' => 'IN'
				]
			];

			$query->set('tax_query', $tax_query);
		}
	}
	function hma_shop_page_terms_list()
	{
		ob_start();
		$term = $_GET['term'];


?>
		<form class="hma_shop_cat_filter" action="<?php echo get_permalink(wc_get_page_id('shop')) ?>">

			<ul class="hma_filter_term_0">
				<?php
				$terms0 = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0]);
				foreach ($terms0 as $term0) {
				?>
					<li>
						<label><input type="checkbox" name="term[]" <?php echo (in_array($term0->slug, $term) ? 'checked="checked"' : '') ?> value="<?php echo $term0->slug ?>"><?php echo $term0->name ?></label>
						<?php
						$terms1 = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => $term0->term_id]);
						if (!empty($terms1)) {
							$ul_classes = ['hma_filter_term_child'];
							foreach ($terms1 as $term2) {
								if (in_array($term2->slug, $term)) {
									$ul_classes[] = 'hma_filter_term_child_active';
								}
							}
						?>
							<ul class="<?php echo implode(' ', $ul_classes) ?>" data-childof="<?php echo $term0->term_id ?>">
								<a href="#" class="open_close_filtere_terms" data-childof="<?php echo $term0->term_id ?>"><i class="fa fa-plus"></i></a>
								<?php
								foreach ($terms1 as $term1) {
								?>
									<li>
										<label><input type="checkbox" name="term[]" <?php echo (in_array($term1->slug, $term) ? 'checked="checked"' : '') ?> value="<?php echo $term1->slug ?>"><?php echo $term1->name ?></label>
										<?php
										$terms2 = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => $term1->term_id]);
										if (!empty($terms2)) {
											$ul_classes = ['hma_filter_term_child'];
											foreach ($terms2 as $term2) {
												if (in_array($term2->slug, $term)) {
													$ul_classes[] = 'hma_filter_term_child_active';
												}
											}
										?>

											<ul class="<?php echo implode(' ', $ul_classes) ?> " data-childof="<?php echo $term1->term_id ?>">
												<a href="#" class="open_close_filtere_terms" data-childof="<?php echo $term1->term_id ?>"><i class="fa fa-plus"></i></a>
												<?php
												foreach ($terms2 as $term2) {
												?>
													<li>
														<label><input data type="checkbox" name="term[]" <?php echo (in_array($term2->slug, $term) ? 'checked="checked"' : '') ?> value="<?php echo $term2->slug ?>"><?php echo $term2->name ?></label>
													</li>
												<?php
												}
												?>
											</ul>
										<?php
										}
										?>
									</li>
								<?php
								}
								?>
							</ul>
						<?php
						}
						?>
					</li>
				<?php
				}
				?>
			</ul>
		</form>
<?php
		return ob_get_clean();
	}
	function hma_wp_footer()
	{
	}
}

new HMA_Legenda_child();









/* Remove Add to cart from single product page */





// // disable zxcvbn.min.js in wordpress
// add_action( 'wp_print_scripts', function () {
// 	// Deregister script about password strength meter
// 	wp_dequeue_script('zxcvbn-async');
// 	wp_deregister_script('zxcvbn-async');
// } );

// /**
//  * @snippet       Disable WooCommerce Ajax Cart Fragments On Static Homepage
//  * @how-to        Get CustomizeWoo.com FREE
//  * @author        Rodolfo Melogli
//  * @compatible    WooCommerce 3.6.4
//  * @donate $9     https://businessbloomer.com/bloomer-armada/
//  */

// add_action( 'wp_enqueue_scripts', 'bbloomer_disable_woocommerce_cart_fragments', 11 ); 

// function bbloomer_disable_woocommerce_cart_fragments() { 
//    if ( is_front_page() ) wp_dequeue_script( 'wc-cart-fragments' ); 
// }
