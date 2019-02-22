<?php

// Show group on homepage
function display_group() { ?>
  <div class="row-full">
    <div class="homepage-home-group col-full">
      <div class="content">
        <div class="columns-3">
          <?php $productGroup = get_term(21, 'product_cat', ARRAY_A); ?>
          <!-- <pre><?php var_dump($productGroup); ?></pre> -->
          <h2 class='section-title'><?php echo $productGroup['name']; ?></h2>
          <p><?php echo $productGroup['description']; ?></p>
          <a href="<?php echo get_category_link($productGroup['term_id']); ?>">
            All CBD Skin Care Products &raquo;
          </a>
        </div>
      </div>
    </div>
  </div>
<?php }
add_action('homepage', 'display_group', 25);

// Custom blog archive
function post_excerpt() {
  if(has_excerpt()) {
    echo get_the_excerpt();
  } else { echo wp_trim_words(get_the_content(), 18); }
}
function post_meta() { ?>
  <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y') ?> in <?php echo get_the_category_list(', ') ?></p>
<?php }
function remove_content() {
  remove_action('storefront_loop_post', 'storefront_post_content', 30);
  // remove_action('storefront_post_header_before', 'storefront_post_meta', 10);
  add_action('storefront_loop_post', 'post_meta', 20);
  add_action('storefront_loop_post', 'post_excerpt', 30);
}
add_action('init', 'remove_content');


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

// Add Home Banner
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
