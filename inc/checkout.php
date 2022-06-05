<?php 



  add_filter( 'woocommerce_form_field_args',  'wc_form_field_args',10,3 );


  function wc_form_field_args($args, $key, $value) {

    $args['input_class'] = array( 'form-control' );

    return $args;
  }


class CheckoutUpload {

  public function __construct() {
    
    //delete file
    add_action( 'wp_ajax_file_del', [$this, 'delete_file' ] );
    add_action( 'wp_ajax_nopriv_file_del', [$this, 'delete_file' ] );
  
    //upload file
    add_action( 'wp_ajax_upload_file', [ $this,'upload_file' ] );
    add_action( 'wp_ajax_nopriv_upload_file', [$this, 'upload_file' ] );

        //upload file
    add_action( 'wp_ajax_thank_field_upload', [ $this,'thank_field_upload' ] );
    add_action( 'wp_ajax_nopriv_thank_field_upload', [$this, 'thank_field_upload' ] );
  }

  public function thank_field_upload() {
    error_log('thank upload');
    error_log(print_r($_POST,true));
    $nonce = isset( $_GET['nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';

    // if ( !wp_verify_nonce( $nonce, 'checkout-custom-upload-nonce' ) ) {
    //     die( 'error' );
    // }

    $post_data = wp_unslash( $_POST );

    $file = isset( $_FILES['file'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_FILES['file'] ) ) : [];

    $upload = array(
        'name'     => isset( $file['name'] ) ? $file['name'] : '',
        'type'     => isset( $file['type'] ) ? $file['type'] : '',
        'tmp_name' => isset( $file['tmp_name'] ) ? $file['tmp_name'] : '',
        'error'    => isset( $file['error'] ) ? $file['error'] : '',
        'size'     => isset( $file['size'] ) ? $file['size'] : '',
    );

    header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );

    $attach = $this->handle_upload( $upload );

    if ( $attach['success'] ) {
        $response         = [ 'success' => true ];
        
        if( isset($_POST['order_id'] ) ) {
            // update_post_meta( $_POST['order_id'], 'thank_field',$attach['attach_id'] );
            update_post_meta( $_POST['order_id'], 'cv_field',$attach['attach_id'] );
        }
        
        $response['html'] = $this->attach_html( $attach['attach_id'] );
      
        echo $response['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    
    } else {
        echo 'error'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    exit;
  }

  public function delete_file() {
    // check_ajax_referer( 'checkout-custom-upload-nonce', 'nonce' );

    $post_data = wp_unslash( $_POST );
    $attach_id  = isset( $post_data['attach_id'] ) ? intval( $post_data['attach_id'] ) : 0;
    $attachment = get_post( $attach_id );

    //post author or editor role
    if ( get_current_user_id() == $attachment->post_author || current_user_can( 'delete_private_pages' ) ) {
        wp_delete_attachment( $attach_id, true );
    }

    echo 'success';
    exit;
  }

  public function upload_file() {
    error_log('upload file');
    error_log(print_r($_POST,true));
    $nonce = isset( $_GET['nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';

    if ( !wp_verify_nonce( $nonce, 'checkout-custom-upload-nonce' ) ) {
        die( 'error' );
    }

    $post_data = wp_unslash( $_POST );

    $file = isset( $_FILES['file'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_FILES['file'] ) ) : [];

    $upload = array(
        'name'     => isset( $file['name'] ) ? $file['name'] : '',
        'type'     => isset( $file['type'] ) ? $file['type'] : '',
        'tmp_name' => isset( $file['tmp_name'] ) ? $file['tmp_name'] : '',
        'error'    => isset( $file['error'] ) ? $file['error'] : '',
        'size'     => isset( $file['size'] ) ? $file['size'] : '',
    );

    header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );

    $attach = $this->handle_upload( $upload );

    if ( $attach['success'] ) {
        $response         = [ 'success' => true ];
        $response['html'] = $this->attach_html( $attach['attach_id'] );
        echo $response['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        echo 'error'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    exit;
  }


  public function handle_upload( $upload_data ) {
      $uploaded_file = wp_handle_upload( $upload_data, ['test_form' => false] );

      // If the wp_handle_upload call returned a local path for the image
      if ( isset( $uploaded_file['file'] ) ) {
          $file_loc  = $uploaded_file['file'];
          $file_name = basename( $upload_data['name'] );
          $file_type = wp_check_filetype( $file_name );

          $attachment = [
              'post_mime_type' => $file_type['type'],
              'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
              'post_content'   => '',
              'post_status'    => 'inherit',
          ];

          $attach_id   = wp_insert_attachment( $attachment, $file_loc );
          $attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );

          wp_update_attachment_metadata( $attach_id, $attach_data );
          return ['success' => true, 'attach_id' => $attach_id];
      }

      return ['success' => false, 'error' => $uploaded_file['error']];
  }

  public function attach_html( $attach_id, $type = NULL ) {
    if ( ! $type ) {
        $type = isset( $_GET['type'] ) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : 'image';
    }

    $attachment = get_post( $attach_id );

    if ( !$attachment ) {
        return;
    }

    if ( wp_attachment_is_image( $attach_id ) ) {
        $image = wp_get_attachment_image_src( $attach_id, 'thumbnail' );
        $image = $image[0];
    } else {
        $image = wp_mime_type_icon( $attach_id );
    }

    // $html = '<li class="ui-state-default image-wrap thumbnail">';
    $html = '<li class="image-wrap thumbnail">';
    $html .= sprintf( '<div class="attachment-name"><img src="%s" alt="%s" /></div>', $image, esc_attr( $attachment->post_title ) );
    $html .= sprintf( '<input type="hidden" name="%s" value="%d">', $type, $attach_id );
    $html .= '<div class="caption">';
    $html .= sprintf( '<a href="" class="attachment-delete" data-attach_id="%d"> Remove Image </a>', $attach_id );
    // $html .= sprintf( '<span class="drag-file"> <img src="%s" /> </span>', CONTACTUM_ASSETS . '/images/move-img.png');
    $html .= '</div>';
    $html .= '</li>';

    return $html;
  }

}

new CheckoutUpload();

add_action( 'wp_enqueue_scripts', 'farid_checkout_scripts'  );

add_action( 'admin_enqueue_scripts', 'admin_checkout_scripts'  );

function admin_checkout_scripts() {
  wp_register_script('wc-checkout-admin-custom-upload', get_template_directory_uri() .'/js/admin-upload.js', ['jquery'], false, true );
  wp_enqueue_script('wc-checkout-admin-custom-upload');

  wp_localize_script( 'wc-checkout-admin-custom-upload', 'checkout_admin_custom_upload',
    [
        'ajaxurl'        => admin_url( 'admin-ajax.php' ),
        'nonce'          => wp_create_nonce( "checkout-admin-custom-upload-nonce" ),
    ]
  );
}

if( !function_exists('farid_checkout_scripts') ) {

    function farid_checkout_scripts() {
        
        wp_register_script('wc-checkout-custom-upload', get_template_directory_uri() .'/js/upload.js', ['jquery', 'plupload-handlers', 'jquery-ui-sortable'], false, true );
        
        wp_enqueue_script('wc-checkout-custom-upload');

        wp_localize_script( 'wc-checkout-custom-upload', 'checkout_custom_upload',
            [
                'ajaxurl'        => admin_url( 'admin-ajax.php' ),
                'nonce'          => wp_create_nonce( "checkout-custom-upload-nonce" ),
                'plupload'   => [
                    'url'              => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'checkout-custom-upload-nonce' ),
                    'flash_swf_url'    => includes_url( 'js/plupload/plupload.flash.swf' ),
                    'filters'          => [
                        [
                            'title'      => __( 'Allowed Files', 'contactum' ),
                            'extensions' => '*',
                        ],
                    ],
                    'multipart'        => true,
                    'urlstream_upload' => true,
                    'warning'          => __( 'Maximum number of files reached!', 'contactum' ),
                    'size_error'       => __( 'The file you have uploaded exceeds the file size limit. Please try again.', 'contactum' ),
                    'type_error'       => __( 'You have uploaded an incorrect file type. Please try again.', 'contactum' ),
                ],
                
                'error_message' => __( 'Please fix the errors to proceed', 'contactum' )
            ]
        );

    }
}


// add_action('woocommerce_after_order_notes', 'custom_checkout_field');

add_action ( 'woocommerce_before_thankyou', 'custom_thank_field', 10, 1 );


function custom_checkout_field( $checkout ) { 
    $unique_id = 'featured_image';
  ?>
        <div id="<?php echo $unique_id; ?>-upload-container">
            <div class="attachment-upload-filelist" data-type="file" data-required="required">
                <a id="<?php echo $unique_id; ?>-pickfiles" class="button file-selector" href=""> <?php _e( 'Select File', '' ); ?></a>
                <ul class="attachment-list thumbnails"></ul>
            </div>
        </div><!-- .container -->
<?php

        $script = ";(function($) {
            $(document).ready( function() {
                var uploader = new Uploader(
                    '{$unique_id}-pickfiles',
                    '{$unique_id}-upload-container',
                    1,
                    'cv_field',
                    '*',
                    1000000,
                    'cv_field'
                );
            });
        })(jQuery);";

        wp_add_inline_script( 'wc-checkout-custom-upload', $script );

 }


function custom_thank_field( $order_id ) { 
    $unique_id = 'featured_image';
  ?>
        <div id="<?php echo $unique_id; ?>-upload-container">
            <div class="attachment-upload-filelist" data-type="file" data-required="required">
                <a id="<?php echo $unique_id; ?>-pickfiles" data-form_id="<?php echo $order_id; ?>" class="button file-selector" href=""> <?php _e( 'Select File', '' ); ?></a>
                <ul class="attachment-list thumbnails"></ul>
            </div>
        </div><!-- .container -->
<?php

        $script = ";(function($) {
            $(document).ready( function() {
                var uploader = new Uploader(
                    '{$unique_id}-pickfiles',
                    '{$unique_id}-upload-container',
                    1,
                    'thank_field_upload',
                    '*',
                    1000000,
                    'thank_field_upload'
                );
            });
        })(jQuery);";

        wp_add_inline_script( 'wc-checkout-custom-upload', $script );

 }

// add_action('woocommerce_checkout_process', 'customised_checkout_field_process');

function customised_checkout_field_process() {
    error_log(print_r(isset($_POST['cv_field']),true));
  if ( !isset( $_POST['cv_field'] ) ) {
    wc_add_notice(__('Please upload Cv Field') , 'error');
  }
}


// add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');

function custom_checkout_field_update_order_meta( $order_id ) {
  error_log(print_r($_POST,true));

  if (!empty($_POST['cv_field'])) {
    update_post_meta($order_id, 'cv_field',sanitize_text_field($_POST['cv_field']));
  }
}




class CheckoutOrderMetaBox {

  public function __construct() {

    add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
  }

  public function add_metabox()
  {
    add_meta_box('wooccm-order-files', esc_html__('Order Files', 'woocommerce-checkout-manager'), array($this, 'add_metabox_content'), 'shop_order', 'normal', 'default');
  }

  public function add_metabox_content( $post ) {

      if ( $order = wc_get_order( $post->ID ) ) {

       $attachment_id = get_post_meta( $order->get_id(), 'cv_field', true );
       // $attachment_id = get_post_meta( $order->get_id(), 'thank_field', true );
?>

<div class="wooccm_order_attachments_wrapper" class="wc-metaboxes-wrapper">
  <table cellpadding="0" cellspacing="0" class="wooccm_order_attachments" style="width:100%; text-align: left;">
    <thead>
      <tr>
        <th><?php esc_html_e('Image', 'woocommerce-checkout-manager'); ?></th>
        <th><?php esc_html_e('Filename', 'woocommerce-checkout-manager'); ?></th>
        <th><?php esc_html_e('Extension', ' woocommerce-checkout-manager'); ?></th>
        <th class="column-actions"></th>
      </tr>
    </thead>
    <tbody class="product_images">
      <?php
          $image_attributes = wp_get_attachment_url($attachment_id);
          $filename = basename($image_attributes);
          $wp_filetype = wp_check_filetype($filename);
          ?>
          <tr class="image">
            <td class="thumb">
              <div class="wc-order-item-thumbnail">
                <?php echo wp_get_attachment_link($attachment_id, '', false, false, wp_get_attachment_image($attachment_id, array(38, 38), false)); ?>
              </div>
            </td>
            <td><?php echo wp_get_attachment_link($attachment_id, '', false, false, preg_replace('/\.[^.]+$/', '', $filename)); ?></td>
            <td><?php echo strtoupper($wp_filetype['ext']); ?></td>
            <td class="column-actions" nowrap>
              <!-- <a href="<?php //echo esc_url($image_attributes2[0]); ?>" target="_blank" class="button"><?php //esc_html_e('Download', 'woocommerce-checkout-manager'); ?></a> -->
              <a class="button attachment-delete" data-attachment_id="<?php echo esc_attr($attachment_id); ?>" data-tip="<?php esc_html_e('Delete', 'woocommerce-checkout-manager'); ?>"><?php esc_html_e('Delete', 'woocommerce-checkout-manager'); ?></a>
            </td>
          </tr>
    </tbody>
  </table>
</div>
  
<?php
        // include WOOCCM_PLUGIN_DIR . 'includes/view/backend/meta-boxes/html-order-uploads.php';
      }
  }

}

new CheckoutOrderMetaBox();



add_filter( 'woocommerce_email_attachments', 'attach_order_files_to_order_email', 10, 4 );


function attach_order_files_to_order_email( $attachments, $email_id, $object, $email_obj ) {
 
  // Only attach files to Completed Order email, otherwise return early.
  // if ( 'customer_completed_order' != $email_id ) {
  //   return $attachments;
  // }
    
  $attachment_id = get_post_meta( $object->get_id(), 'cv_field', true );
  $attachments = get_attached_file( $attachment_id );

  return $attachments;
}

