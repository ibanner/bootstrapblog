<?php

// ++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++         1. GLOBAL STUFF          ++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++

// 1.1 Add scripts and stylesheets
function sandbox_scripts() {
	wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6' );
	wp_enqueue_style( 'blog', get_template_directory_uri() . '/css/blog.css' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'sandbox_scripts' );

// 1.2 Add Google Fonts
function sandbox_google_fonts() {
				wp_register_style('OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');
				wp_enqueue_style( 'OpenSans');
		}
add_action('wp_print_styles', 'sandbox_google_fonts');

// 1.3 Theme Suppot
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

// ++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++         2. SOCIAL LINKS          ++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++

// 2.1 Add admin menu item
function custom_settings_add_menu() {
  add_menu_page( 'Social Links', 'Social Links', 'manage_options', 'custom-settings', 'custom_settings_page', null, 99);
}
add_action( 'admin_menu', 'custom_settings_add_menu' );

// 2.2 Create the settings Page
function custom_settings_page() { ?>
  <div class="wrap">
    <h1>Social Links</h1>
    <form method="post" action="options.php">
       <?php
           settings_fields('section');
           do_settings_sections('theme-options');      
           submit_button(); 
       ?>          
    </form>
  </div>
<?php }

// 2.3 Setting the specific options
// 		2.3.1 Twitter
function setting_twitter() { ?>
  <input type="text" name="twitter" id="twitter" value="<?php echo get_option('twitter'); ?>" />
<?php }

// 		2.3.2 GitHub
function setting_github() { ?>
  <input type="text" name="github" id="github" value="<?php echo get_option('github'); ?>" />
<?php }

// 		2.3.3 Facebook
function setting_facebook() { ?>
  <input type="text" name="facebook" id="facebook" value="<?php echo get_option('facebook'); ?>" />
<?php }

// 2.4 Putting the settings into the admin page we created
function custom_settings_page_setup() {
  add_settings_section('section', 'Social Media Presence', null, 'theme-options');
  add_settings_field('twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'section');
  add_settings_field('github', 'GitHub URL', 'setting_github', 'theme-options', 'section');
  add_settings_field('facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'section');

  register_setting('section', 'twitter');
  register_setting('section', 'github');
  register_setting('section', 'facebook');
}
add_action( 'admin_init', 'custom_settings_page_setup' );

// ++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++         3. AIRPORT CPT           ++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++

// 3.1 Declare Airport as a Custom Post Type

function create_airport() {

	$labels = array(
		'name'                  => _x( 'Airports', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Airport', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Airports', 'text_domain' ),
		'name_admin_bar'        => __( 'Airport', 'text_domain' ),
		'archives'              => __( 'Airport Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Airport:', 'text_domain' ),
		'all_items'             => __( 'All Airports', 'text_domain' ),
		'add_new_item'          => __( 'Add New Airport', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Airport', 'text_domain' ),
		'edit_item'             => __( 'Edit Airport', 'text_domain' ),
		'update_item'           => __( 'Update Airport', 'text_domain' ),
		'view_item'             => __( 'View Airport', 'text_domain' ),
		'search_items'          => __( 'Search Airport', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Airports list', 'text_domain' ),
		'items_list_navigation' => __( 'Airports list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Airports list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Airport', 'text_domain' ),
		'description'           => __( 'Airport Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'airport', $args );

}
add_action( 'init', 'create_airport', 0 );

// 3.2 Airport Meta-Box

function airport_meta_box_markup($object)
{
	wp_nonce_field( basename( __FILE__ ) , 'airport_nonce_field');
	
	// retrieve the _food_carbohydrates current value
	$current_cholesterol = get_post_meta( $post->ID, '_food_carbohydrates', true );

	?>
	<div class='inside'>
		<h3><?php _e( 'Carbohydrates', 'text_domain' ); ?></h3>
		<p>
			<input type="text" name="carbohydrates" value="<?php echo $current_carbohydrates; ?>" /> 
		</p>
	</div>
	<?php

}

function add_airport_meta_box()
{
    add_meta_box("airport-meta-box", "Airport Details", "airport_meta_box_markup", "airport", "side", "high", null);
}

add_action("add_meta_boxes_airport", "add_airport_meta_box");

// 3.3 Get those meta box values saved somewhere

function save_airport_meta_box( $post_id )
{
	// verify meta box nonce
	if ( !isset( $_POST['airport_nonce_field'] ) || !wp_verify_nonce( $_POST['airport_nonce_field'], basename( __FILE__ ) ) ){
		return;
	}

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

	// store custom fields values
	// carbohydrates string
	if ( isset( $_REQUEST['carbohydrates'] ) ) {
		update_post_meta( $post_id, '_food_carbohydrates', sanitize_text_field( $_POST['carbohydrates'] ) );
	}
}

add_action("save_post_airport", "save_airport_meta_box", 10, 2);
