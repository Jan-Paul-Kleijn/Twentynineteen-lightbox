<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

function twentynineteen_lightbox_settings_init() {

  register_setting( 'twentynineteen-lightbox', 'twentynineteen_lightbox_options' );

  add_settings_section(
    'twentynineteen_lightbox_location',
    __( 'Add lightbox to the Twenty Nineteen WordPress theme', 'twentynineteen-lightbox' ),
    'twentynineteen_lightbox_location_cb',
    'twentynineteen-lightbox'
  );

  add_settings_field(
    'twentynineteen_lightbox_field_cssclassname',
    __( 'CSS Classname', 'twentynineteen-lightbox' ),
    'twentynineteen_lightbox_field_cssclassname_cb',
    'twentynineteen-lightbox',
    'twentynineteen_lightbox_location',
    [
      'label_for' => 'twentynineteen_lightbox_field_cssclassname',
      'class' => 'twentynineteen_lightbox_row',
      'twentynineteen_lightbox_custom_data' => 'custom',
    ]
  );
  add_settings_field(
    'twentynineteen_lightbox_field_gallerytype',
    __( 'Gallery type', 'twentynineteen-lightbox' ),
    'twentynineteen_lightbox_field_gallerytype_cb',
    'twentynineteen-lightbox',
    'twentynineteen_lightbox_location',
    [
      'label_for' => 'twentynineteen_lightbox_field_gallerytype',
      'class' => 'twentynineteen_lightbox_row',
      'twentynineteen_lightbox_custom_data' => 'custom',
    ]
  );
}
 
add_action( 'admin_init', 'twentynineteen_lightbox_settings_init' );
 
function twentynineteen_lightbox_location_cb( $args ) {
  echo '<p id="' . esc_attr( $args['id'] ) . '">' . esc_html_e( 'Choose where you want the lightbox to appear', 'twentynineteen-lightbox' ) . '</p>';
}
 
function twentynineteen_lightbox_field_gallerytype_cb( $args ) { 
	 $setting = get_option( 'twentynineteen_lightbox_options' );
?>
<input id="<?php echo esc_attr( $args['label_for'] ); ?>"
       type="checkbox"
       data-custom="<?php echo esc_attr( $args['twentynineteen_lightbox_custom_data'] ); ?>"
       name="twentynineteen_lightbox_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
       <?php echo array_key_exists( 'twentynineteen_lightbox_field_gallerytype', $setting ) && in_array('alignleft', $setting['twentynineteen_lightbox_field_gallerytype']) ? 'checked="checked"' : "" ?>
       value="alignleft"> <?php esc_html_e( 'Align left', 'twentynineteen-lightbox' ); ?><br />
<input id="<?php echo esc_attr( $args['label_for'] ); ?>"
       type="checkbox"
       data-custom="<?php echo esc_attr( $args['twentynineteen_lightbox_custom_data'] ); ?>"
       name="twentynineteen_lightbox_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
       <?php echo array_key_exists( 'twentynineteen_lightbox_field_gallerytype', $setting ) && in_array('aligncenter', $setting['twentynineteen_lightbox_field_gallerytype']) ? 'checked="checked"' : "" ?>
       value="aligncenter"> <?php esc_html_e( 'Align center', 'twentynineteen-lightbox' ); ?><br />
<input id="<?php echo esc_attr( $args['label_for'] ); ?>"
       type="checkbox"
       data-custom="<?php echo esc_attr( $args['twentynineteen_lightbox_custom_data'] ); ?>"
       name="twentynineteen_lightbox_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
       <?php echo array_key_exists( 'twentynineteen_lightbox_field_gallerytype', $setting ) && in_array('alignright', $setting['twentynineteen_lightbox_field_gallerytype']) ? 'checked="checked"' : "" ?>
       value="alignright"> <?php esc_html_e( 'Align right', 'twentynineteen-lightbox' ); ?><br />
<input id="<?php echo esc_attr( $args['label_for'] ); ?>"
       type="checkbox"
       data-custom="<?php echo esc_attr( $args['twentynineteen_lightbox_custom_data'] ); ?>"
       name="twentynineteen_lightbox_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
       <?php echo array_key_exists( 'twentynineteen_lightbox_field_gallerytype', $setting ) && in_array('alignwide', $setting['twentynineteen_lightbox_field_gallerytype']) ? 'checked="checked"' : "" ?>
       value="alignwide"> <?php esc_html_e( 'Wide width', 'twentynineteen-lightbox' ); ?><br />
<input id="<?php echo esc_attr( $args['label_for'] ); ?>"
       type="checkbox"
       data-custom="<?php echo esc_attr( $args['twentynineteen_lightbox_custom_data'] ); ?>"
       name="twentynineteen_lightbox_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
       <?php echo array_key_exists( 'twentynineteen_lightbox_field_gallerytype', $setting ) && in_array('alignfull', $setting['twentynineteen_lightbox_field_gallerytype']) ? 'checked="checked"' : "" ?>
       value="alignfull"> <?php esc_html_e( 'Full width', 'twentynineteen-lightbox' ); ?>
<p class="description">
  <?php esc_html_e( 'Add lightbox functionality to each image in the galleries on your website. Here you can choose which type of gallery should be given this functionality.', 'twentynineteen-lightbox' ); ?>
</p>
<?php
}

function twentynineteen_lightbox_field_cssclassname_cb( $args ) {
  $setting = get_option( 'twentynineteen_lightbox_options' );
?>
<input id="<?php echo esc_attr( $args['label_for'] ); ?>"
       type="text"
       data-custom="<?php echo esc_attr( $args['twentynineteen_lightbox_custom_data'] ); ?>"
       name="twentynineteen_lightbox_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
       value="<?php echo isset( $setting[esc_attr( $args['label_for'] )] ) ? esc_attr( $setting[esc_attr( $args['label_for'] )] ) : ''; ?>"
       placeholder="lightboxed">
<p class="description">
  <?php esc_html_e( 'Add lightbox functionality to images with a certain CSS class. Here you can define which CSS class should be given this functionality. The default CSS classname is \'lightboxed\'.', 'twentynineteen-lightbox' ); ?>
</p>
<?php
}

/**
 * top level menu
 */
function twentynineteen_lightbox_options_page() {
  // add top level menu page
  add_menu_page(
    'Twenty Nineteen Lightbox',
    '2019 Lightbox',
    'manage_options',
    'twentynineteen-lightbox',
    'twentynineteen_lightbox_options_page_cb'
//     plugin_dir_url( __FILE__ ) . 'images/poll_red.png'
  );
}
 
/**
 * register top level menu to the admin_menu action hook
 */
add_action( 'admin_menu', 'twentynineteen_lightbox_options_page' );
 
/**
 * Output the plugin options
 */
function twentynineteen_lightbox_options_page_cb() {
  // Check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }
 
  // Create error/update messages
  // Check if the user has submitted the settings
  if ( isset( $_GET['settings-updated'] ) ) {
   // Add settings saved message with the class of "updated"
    add_settings_error( 'twentynineteen_lightbox_messages', 'twentynineteen_lightbox_message', __( 'Settings Saved', 'twentynineteen-lightbox' ), 'updated' );
  }
 
  // Output error/update messages
  settings_errors( 'twentynineteen_lightbox_messages' );

  // Output the plugin options
?>
<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <form action="options.php" method="post">
<?php
// Output security fields
settings_fields( 'twentynineteen-lightbox' );
// Output setting sections and their fields
do_settings_sections( 'twentynineteen-lightbox' );
// Output save settings button
submit_button( __( 'Save Settings', 'twentynineteen-lightbox' ) );
?>
  </form>
</div>
<?php
}
