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


