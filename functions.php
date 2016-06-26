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

class Airport_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'airport-meta-box',
			__( 'Airport Details', 'text_domain' ),
			array( $this, 'render_metabox' ),
			'airport',
			'side',
			'low'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'airport_nonce_action', 'airport_nonce' );

		// Retrieve an existing value from the database.
		$airport_iata_code = get_post_meta( $post->ID, 'airport_iata_code', true );
		$airport_vip_lounge = get_post_meta( $post->ID, 'airport_vip_lounge', true );

		// Set default values.
		if( empty( $airport_iata_code ) ) $airport_iata_code = '';
		if( empty( $airport_vip_lounge ) ) $airport_vip_lounge = 'False';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="airport_iata_code" class="airport_iata_code_label">' . __( 'IATA Code', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="airport_iata_code" name="airport_iata_code" class="airport_iata_code_field" placeholder="' . esc_attr__( 'e.g. TLV', 'text_domain' ) . '" value="' . esc_attr__( $airport_iata_code ) . '">';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="airport_vip_lounge" class="airport_vip_lounge_label">' . __( 'VIP Lounge', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="airport_vip_lounge" name="airport_vip_lounge" class="airport_vip_lounge_field" value="' . $airport_vip_lounge . '" ' . checked( $airport_vip_lounge, 'checked', false ) . '> ' . __( 'Is there a VIP lounge', 'text_domain' ) . '</label>';
		echo '			<span class="description">' . __( 'Is there a VIP lounge available?', 'text_domain' ) . '</span>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['airport_nonce'] ) ? $_POST['airport_nonce'] : '';
		$nonce_action = 'airport_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Sanitize user input.
		$airport_new_iata_code = isset( $_POST[ 'airport_iata_code' ] ) ? sanitize_text_field( $_POST[ 'airport_iata_code' ] ) : '';
		$airport_new_vip_lounge = isset( $_POST[ 'airport_vip_lounge' ] ) ? 'checked'  : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'airport_iata_code', $airport_new_iata_code );
		update_post_meta( $post_id, 'airport_vip_lounge', $airport_new_vip_lounge );

	}

}

new Airport_Meta_Box;
