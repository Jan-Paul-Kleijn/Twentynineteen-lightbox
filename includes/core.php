<?php

/**
 * Core PHP functions for implementing options in lightbox functionality
 */

// Load options in the pages as a JSON var, via 'wp_head' hook.
if(! is_admin() ) {
  function twentynineteen_lightbox_insert_settings_in_js() {
    echo "<script>window.twentynineteen_lightbox_options = " . json_encode(load_twentynineteen_lightbox_defaults()) . ";</script>";
  }
  add_action( 'wp_head', 'twentynineteen_lightbox_insert_settings_in_js' );
}

// Check options for empty values and, if so, replace with default values 
function load_twentynineteen_lightbox_defaults() {
  $opt = get_option('twentynineteen_lightbox_options');
  $defaults = array(
    'twentynineteen_lightbox_field_cssclassname' => 'lightboxed',
    'twentynineteen_lightbox_field_gallerytype' => []
  );
  return wp_parse_args_multitype($opt, $defaults);
}


/**
 * Load Javascript and CSS assets
 */

function enqueue_twentynineteen_lightbox_assets() {
  wp_enqueue_style( 'twentynineteen-lightbox-style', BTNL_PLUGIN_URL . '/assets/css/style.css' );
  wp_register_script( 'twentynineteen-lightbox-script', BTNL_PLUGIN_URL . '/assets/js/script.js', array( 'jquery' ) );
  wp_enqueue_script( 'twentynineteen-lightbox-script' );
}
add_action('wp_enqueue_scripts', 'enqueue_twentynineteen_lightbox_assets');


/**
 Helper functions
 */

// Combine options and defaults, where defaults replace empty options.
// Also valid for multidimensional (e.g. checkbox groups) arrays.
function wp_parse_args_multitype( &$optns, $dflts ) {
  $options = (array) $optns;
  $defaults = (array) $dflts;
  $result = $defaults;
  $buffer = [];
  foreach ( $options as $key => &$value ) {
    if ( is_array( $value ) && isset( $result[ $key ] ) ) {
      $result[ $key ] = wp_parse_args_multitype( $value, $result[ $key ] );
    } else {
      $buffer[ $key ] = ($value == '' ? $result[ $key ] : $value);
      $result[ $key ] = $value;
    }
  }
  return array_map("unserialize", array_unique(array_map("serialize", array_merge($result, $buffer))));
}
