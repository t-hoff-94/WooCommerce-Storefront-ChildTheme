<?php
// add image sizes
function my_child_theme_setup() {
  add_image_size('blog_entry', 400, 257, true);
  add_image_size('blog_bg', 1000, 333, true);
}
add_action('after_setup_theme', 'my_child_theme_setup');



//Blog posts homepage
function home_blog_entries() {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
  );
  $posts = new WP_Query($args);
  ?>
  <div class="homepage-blog-entries">
    <h2 class="section-title t-center">Some Recent Articles</h2>
    <ul>
    <?php
    while($posts->have_posts()) {
      $posts->the_post(); ?>
      <li><?php get_template_part('template-parts/content-post'); ?></li>
     <?php }
    wp_reset_postdata();
     ?>
    </ul>
  </div>
<?php }
add_action('homepage', 'home_blog_entries', 35);




// Add custom banner to content-page.

function fullWidthBanner($content) { ?>
      </main>
    </div>
  </div>
  <div class="bg-grey">
    <div class="col-full">
      <p>hey</p>
    </div>
  </div>
  <div class="col-full">
    <div class="content-area">
      <div class="site-main">
<?php }

// add_action('homepage', 'fullWidthBanner', 15);





// Show group on homepage
function display_group() {
  $_cf = new WC_Product_Factory();
  $_product = $_cf->get_product(31);
  $_product_image = wp_get_attachment_image_src($_product->image_id);
  // echo "<pre>";
  // var_dump($_product_image);
  // var_dump($_product);
  // echo "</pre>";?>
  <div class="home-group row-full bg-grey">
    <div class="homepage-home-group col-full">
      <div class="content">
        <div class="columns-2 one-half">
          <?php $productGroup = get_term(21, 'product_cat', ARRAY_A); ?>
          <h2 class='section-title'><?php echo $productGroup['name']; ?></h2>
          <p><?php echo $productGroup['description']; ?></p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi semper euismod finibus. Curabitur et mauris facilisis, pellentesque mi sit amet, pellentesque est. Phasellus faucibus, lorem quis suscipit malesuada, arcu nulla hendrerit ipsum, et vulputate nibh diam ut lectus. Etiam a sem mattis ante fringilla vulputate id eu dolor. Donec aliquet quam tempor tristique efficitur. Etiam gravida massa ut fermentum semper. Aliquam ac sapien accumsan lacus volutpat volutpat vel quis sem.</p>
          <a href="<?php echo get_category_link($productGroup['term_id']); ?>">
            All CBD Skin Care Products &raquo;
          </a>
        </div>
        <?php echo do_shortcode('[products ids="32" columns="1"]'); ?>
        <!-- <?php echo do_shortcode('[product_category category="cbd-skin-care" limit="1" columns="1"]'); ?> -->
      </div>
    </div>
  </div>
<?php }
add_action('homepage', 'display_group', 25);


// Custom blog archive
function post_excerpt() {

  if(has_excerpt()) { ?>
    <p class='post-excert'><?php echo get_the_excerpt(); ?></p>
    <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="">

  <?php } else { ?>
    <p class='post-excert'><?php echo wp_trim_words(get_the_content(), 18); ?></p>
   <?php }
}

function custom_blog_page() {
  remove_action('storefront_page', 'storefront_page_header', 10);
  remove_action('storefront_loop_post', 'storefront_post_content', 30);
  remove_action('storefront_loop_post', 'storefront_post_taxonomy', 40);
  remove_action('storefront_post_header_before', 'storefront_post_meta', 10);
  add_action('storefront_loop_post', 'storefront_post_meta', 20);
  add_action('storefront_loop_post', 'post_excerpt', 40);
}
add_action('init', 'custom_blog_page');


// Remove unwanted sections such as featured products section. and footer credits.
function remove_sections() {

  remove_action('homepage', 'storefront_recent_products', 30);
  remove_action('homepage', 'storefront_featured_products', 40);
  remove_action('homepage', 'storefront_popular_products', 50);
  remove_action('homepage', 'storefront_on_sale_products', 60);
  remove_action('homepage', 'storefront_on_sale_products', 60);
  remove_action('homepage', 'storefront_best_selling_products', 70);
  remove_action('storefront_footer', 'storefront_credit', 20);
  add_action('storefront_footer', 'custom_footer_section', 30);
  // add_action('storefront_homepage', 'home_banner', 50);
}
add_action('init', 'remove_sections');


// Add Home Banner and footer section
function custom_footer_section() {
  get_template_part('template-parts/custom-footer-section');
}


// custom SVG logo
  if ( ! function_exists( 'storefront_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_site_branding() {
		get_template_part('template-parts/header-logo');
	}
}



// Products per page
  function products_per_page($products) {
    $products = 10;
    return $products;
  }
  add_filter('loop_shop_per_page', 'products_per_page', 20);


  function child_theme_files() {
    wp_enqueue_script('main-elite-hemp.js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);

    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600i|Viga');

    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  }

  add_action('wp_enqueue_scripts', 'child_theme_files');





  function child_theme_features() {
    // register_nav_menu('headerMenuLocation', 'Header Menu');
    // register_nav_menu('footerMenuOne', 'Footer One');
    // register_nav_menu('footerMenuTwo', 'Footer Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
  }

  add_action('after_setup_theme', 'child_theme_features');


  // Display currency code
  function theme_display_usd($symbol, $currency) {
    $symbol = $currency . " $";
    return $symbol;
  }
  add_filter('woocommerce_currency_symbol', 'theme_display_usd', 10, 2);


  // Change Description Title on Products
  function custom_description_tabs($tabs) {
    global $post;
    if($tabs['description']) {
      $tabs['description']['title'] = $post->post_title;
    }
    return $tabs;
  }
  add_filter('woocommerce_product_tabs', 'custom_description_tabs', 10);

  function custom_description_title($title) {
    global $post;
    $title = $post->post_title;
    return $title;
  }
  add_filter('woocommerce_product_description_heading', 'custom_description_title');



  // Add new tab for video
  function custom_display_video() {
    global $post;
    $video = get_field('video', $post->ID);
    if($video) {
      echo "<video controls>";
      echo "<source src='". $video . "'>";
      echo "</video>";
    }
  }

  function custom_video_tab($tabs) {
    global $post;
    $video = get_field('video', $post->ID);
    if($video) {
      $tabs['video'] = array(
        'title' => 'video',
        'priority' => 15,
        'callback' => 'custom_display_video',
      );
    }
    return $tabs;
  }
  add_filter('woocommerce_product_tabs', 'custom_video_tab', 11, 1);



  // Display savings
  function custom_price_percentage($price, $product) {


    if($product->get_sale_price()) {
      if($product->get_regular_price() > 100) {
        $saved = wc_price($product->get_regular_price() - $product->get_sale_price() );
          return $price . sprintf( __('<br><span class="saved-amount">Save: %s </span>', 'woocommerce'), $saved);
      } else {
        $percentage = round( ( ($product->get_regular_price() - $product->get_sale_price() ) * 100 ) / $product->get_regular_price());
        return $price . sprintf( __('<br><span class="saved-amount">Save: %s </span>', 'woocommerce'), $percentage . "%");
      }


    }
    return $price;
  }
  add_filter('woocommerce_get_price_html', 'custom_price_percentage', 10, 2);



  // Print social icons using AddThis.com
  function custom_sharing_buttons() { ?>
    <div class="addthis_inline_share_toolbox"></div>
  <?php }

  add_action('woocommerce_before_add_to_cart_form', 'custom_sharing_buttons');

  function add_custom_addthis_script() { ?>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c75926077a70355"></script>
  <?php }
  add_action('wp_footer', 'add_custom_addthis_script');



  // Display custom banner on cart page with custom fields

  function custom_cart_banner() {
    global $post;
    $image_url = get_field('banner', $post->ID);
    if($image_url) { ?>
      <div class="cart-banner">
        <img src="<?php echo $image_url ?>" alt="coupon">
      </div>
    <?php }
  }
  add_action('woocommerce_check_cart_items', 'custom_cart_banner');



  // Display 'clear cart' button

  function custom_empty_cart_button() { ?>
    <a class="button btn btn--dgrey" href="?empty-cart=true">Empty Cart</a>
  <?php }

  function custom_empty_cart() {
    if(isset($_GET['empty-cart'])) {
      global $woocommerce;
      $woocommerce->cart->empty_cart();
    }
  }
  add_action('init', 'custom_empty_cart');
  add_action('woocommerce_cart_actions', 'custom_empty_cart_button');



// Related Products in blog (AFC)
function related_products() {
  global $post;
  $related_products = get_field('related_products', $post->ID);

  if($related_products) {
    $products_ids = join($related_products, ', '); ?>
    <div class="related-products">
      <h2 class="section-title">Related Products</h2>
      <?php echo do_shortcode('[products ids="120, 118"]'); ?>
    </div>
  <?php }
}
add_action('storefront_post_content_after', 'related_products');



// Add slick slider home page

function customSliderBanner($content) {
  get_template_part('template-parts/home-slider');
}

add_action('homepage', 'customSliderBanner', 15);



//copied from storefront template functions
if ( ! function_exists( 'storefront_secondary_navigation' ) ) {
	/**
	 * Display Secondary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_secondary_navigation() {
		if ( has_nav_menu( 'secondary' ) ) {
			?>
			<nav class="secondary-navigation" role="navigation" aria-label="<?php esc_html_e( 'Secondary Navigation', 'storefront' ); ?>">
				<div class="menu-social-menu-container">
          <ul id="menu-social-menu" class="menu">
            <li class='menu-item'><i class='fa fa-search'></i>hey</li>
            <li class='menu-item'>tits</li>
          </ul>
        </div>
			</nav><!-- #site-navigation -->
			<?php
		}
	}
}








//
