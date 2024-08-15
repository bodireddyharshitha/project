<?php  
/**
 * Get image size.
 *
 * @param string $size
 * @return void
 */
function mefe_get_image_sizes( $size = '' ) {
     
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}

function mefe_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = mefe_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#f2f2f2;"></rect>
            </svg>
        </div>
        <?php
    }
}

/** Add a form field in the new category page
 * @since 1.0.0
*/
function mefe_add_category_image( $taxonomy ) { ?>
	<div class="form-field term-group">
		<label for="ba_category_image_id"><?php _e( 'Mega Elements - Addons for Elementor Image', 'mega-elements-addons-for-elementor' ); ?></label>
		<input type="hidden" id="ba_category_image_id" name="ba_category_image_id" class="custom_media_url" value="">
		<div id="category-image-wrapper"></div>
		<p>
			<input type="button" class="button button-secondary ba_tax_media_button" id="ba_tax_media_button" name="ba_tax_media_button" value="<?php _e( 'Add Image', 'mega-elements-addons-for-elementor' ); ?>" />
			<input type="button" class="button button-secondary ba_tax_media_remove" id="ba_tax_media_remove" name="ba_tax_media_remove" value="<?php _e( 'Remove Image', 'mega-elements-addons-for-elementor' ); ?>" />
		</p>
	</div>
<?php
}
	 
/*
* Save the form field
* @since 1.0.0
*/
function mefe_save_category_image( $term_id ) {
	if( isset( $_POST['ba_category_image_id'] ) && '' !== $_POST['ba_category_image_id'] ){
		$image = absint( $_POST['ba_category_image_id'] );
		add_term_meta( $term_id, 'ba_category_image_id', $image, true );
	}
}

/*
* Edit the form field
* @since 1.0.0
*/
function mefe_update_category_image( $term, $taxonomy='' ) { ?>
	<tr class="form-field term-group-wrap">
		<th scope="row">
			<label for="ba_category_image_id"><?php _e( 'Mega Elements Addons For Elementor Image', 'mega-elements-addons-for-elementor' ); ?></label>
		</th>
		<td>
			<?php $image_id = get_term_meta ( $term->term_id, 'ba_category_image_id', true ); ?>
			<input type="hidden" id="ba_category_image_id" name="ba_category_image_id" value="<?php echo esc_attr( $image_id ); ?>">
			<div id="category-image-wrapper">
				<?php if ( isset( $image_id ) && $image_id!='' ) { ?>
				<?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
				<?php } ?>
			</div>
			<p>
				<input type="button" class="button button-secondary ba_tax_media_button" id="ba_tax_media_button" name="ba_tax_media_button" value="<?php _e( 'Add Image', 'mega-elements-addons-for-elementor' ); ?>" />
				<input type="button" class="button button-secondary ba_tax_media_remove" id="ba_tax_media_remove" name="ba_tax_media_remove" value="<?php _e( 'Remove Image', 'mega-elements-addons-for-elementor' ); ?>" />
			</p>
		</td>
	</tr>
<?php
}

/*
* Update the form field value
* @since 1.0.0
*/
function mefe_updated_category_image( $term_id ) {
	if( isset( $_POST['ba_category_image_id'] ) && '' !== $_POST['ba_category_image_id'] ) {
		$image = absint( $_POST['ba_category_image_id'] );
		update_term_meta ( $term_id, 'ba_category_image_id', $image );
	} else {
		update_term_meta ( $term_id, 'ba_category_image_id', '' );
	}
}

/**
 * Column Header
 *
 * @param [type] $columns
 * @return void
 */
function mefe_custom_column_header( $columns ){
  $columns['header_name'] = 'Thumbnail'; 
  return $columns;
}


/**
 * Column value
 *
 * @param [type] $value
 * @param [type] $column_name
 * @param [type] $tax_id
 * @return void
 */
function mefe_custom_column_content( $value, $column_name, $tax_id ){
   	$img = get_term_meta( $tax_id, 'ba_category_image_id', false );
   	$ret = '';
   	if(isset($img[0]) && $img[0]!='')
	{
		$url = wp_get_attachment_image_url($img[0],'thumbnail');
		$ret = '<img src="'.esc_url($url).'" class="tax-img">';
	}
   	return $ret;
}

/*
* Add script
* @since 1.0.0
*/
function mefe_add_script() { ?>
	<script>
		jQuery(document).ready( function($) {
			function ct_media_upload(button_class) {
				var _custom_media = true,
				_orig_send_attachment = wp.media.editor.send.attachment;
				
				$('body').on('click', button_class, function(e) {
					var button_id = '#'+$(this).attr('id');
					var send_attachment_bkp = wp.media.editor.send.attachment;
					var button = $(button_id);
					_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							$('#ba_category_image_id').val(attachment.id);
							$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
							$('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
						} else {
							return _orig_send_attachment.apply( button_id, [props, attachment] );
						}
					}
					wp.media.editor.open(button);
					return false;
				});
			}
			
			ct_media_upload('.ba_tax_media_button.button'); 
			$('body').on('click','.ba_tax_media_remove',function(){
				$('#ba_category_image_id').val('');
				$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
			});

			// Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
			$(document).ajaxComplete(function(event, xhr, settings) {
				var queryStringArr = settings.data.split('&');
				if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
					var xml = xhr.responseXML;
					$response = $(xml).find('term_id').text();
					if($response!=""){
					// Clear the thumb image
					$('#category-image-wrapper').html('');
				}
			}
		});
	});
	</script>
<?php 
}

/**
 * Get base64 icon
 *
 * @return void
 */
function mefe_get_b64_icon() {
	return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSIyMC4xMjMiIHZpZXdCb3g9IjAgMCA0MCAyMC4xMjMiPg0KICA8ZyBpZD0iR3JvdXBfMTQ3NSIgZGF0YS1uYW1lPSJHcm91cCAxNDc1IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMjQwLjkzNCAtNDkwKSI+DQogICAgPGcgaWQ9Ikdyb3VwXzE0NjkiIGRhdGEtbmFtZT0iR3JvdXAgMTQ2OSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY1LjYxNCA0OTApIj4NCiAgICAgIDxyZWN0IGlkPSJSZWN0YW5nbGVfMTQ2NSIgZGF0YS1uYW1lPSJSZWN0YW5nbGUgMTQ2NSIgd2lkdGg9IjE1LjMyIiBoZWlnaHQ9IjQuMzEyIiByeD0iMi4xNTYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDApIiBmaWxsPSIjZmZmIi8+DQogICAgICA8cmVjdCBpZD0iUmVjdGFuZ2xlXzE0NjYiIGRhdGEtbmFtZT0iUmVjdGFuZ2xlIDE0NjYiIHdpZHRoPSI5LjU3MSIgaGVpZ2h0PSI0LjMxMiIgcng9IjIuMTU2IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwIDcuOTA1KSIgZmlsbD0iI2ZmZiIvPg0KICAgICAgPHJlY3QgaWQ9IlJlY3RhbmdsZV8xNDY3IiBkYXRhLW5hbWU9IlJlY3RhbmdsZSAxNDY3IiB3aWR0aD0iMTUuMzIiIGhlaWdodD0iNC4zMTIiIHJ4PSIyLjE1NiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCAxNS44MTEpIiBmaWxsPSIjZmZmIi8+DQogICAgPC9nPg0KICAgIDxyZWN0IGlkPSJSZWN0YW5nbGVfMTQ2NS0yIiBkYXRhLW5hbWU9IlJlY3RhbmdsZSAxNDY1IiB3aWR0aD0iMTkuNDA0IiBoZWlnaHQ9IjQuMzEyIiByeD0iMi4xNTYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2MS4wNTYgNDkwKSByb3RhdGUoOTApIiBmaWxsPSIjZmZmIi8+DQogICAgPHJlY3QgaWQ9IlJlY3RhbmdsZV8xNDY2LTIiIGRhdGEtbmFtZT0iUmVjdGFuZ2xlIDE0NjYiIHdpZHRoPSI5LjU3MSIgaGVpZ2h0PSI0LjMxMiIgcng9IjIuMTU2IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyNTMuMTUxIDQ5MCkgcm90YXRlKDkwKSIgZmlsbD0iI2ZmZiIvPg0KICAgIDxyZWN0IGlkPSJSZWN0YW5nbGVfMTQ2Ny0yIiBkYXRhLW5hbWU9IlJlY3RhbmdsZSAxNDY3IiB3aWR0aD0iMTkuNDA0IiBoZWlnaHQ9IjQuMzEyIiByeD0iMi4xNTYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI0NS4yNDYgNDkwKSByb3RhdGUoOTApIiBmaWxsPSIjZmZmIi8+DQogIDwvZz4NCjwvc3ZnPg0K';
}

function mefe_get_dashboard_link( $suffix = '#mega-elements-general' ) {
	return add_query_arg( [ 'page' => 'mega-elements' . $suffix ], admin_url( 'admin.php' ) );
}

/**
 * Get a list of all the allowed html tags.
 *
 * @param string $level Allowed levels are basic and intermediate
 * @return array
 */
function mefe_get_allowed_html_tags( $level = 'basic' ) {
	$allowed_html = [
		'b' => [],
		'i' => [],
		'u' => [],
		's' => [],
		'br' => [],
		'em' => [],
		'del' => [],
		'ins' => [],
		'sub' => [],
		'sup' => [],
		'code' => [],
		'mark' => [],
		'small' => [],
		'strike' => [],
		'abbr' => [
			'title' => [],
		],
		'span' => [
			'class' => [],
		],
		'strong' => [],
	];

	if ( $level === 'intermediate' ) {
		$tags = [
			'a' => [
				'href' => [],
				'title' => [],
				'class' => [],
				'id' => [],
			],
			'q' => [
				'cite' => [],
			],
			'img' => [
				'src' => [],
				'alt' => [],
				'height' => [],
				'width' => [],
			],
			'dfn' => [
				'title' => [],
			],
			'time' => [
				'datetime' => [],
			],
			'cite' => [
				'title' => [],
			],
			'acronym' => [
				'title' => [],
			],
			'hr' => [],
		];

		$allowed_html = array_merge( $allowed_html, $tags );
	}

	return $allowed_html;
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @param string $string
 * @return string
 */
function mefe_kses_intermediate( $string = '' ) {
	return wp_kses( $string, mefe_get_allowed_html_tags( 'intermediate' ) );
}


add_action( 'category_add_form_fields', 'mefe_add_category_image' );
add_action( 'created_category', 'mefe_save_category_image' );
add_action( 'category_edit_form_fields', 'mefe_update_category_image' );
add_action( 'edited_category', 'mefe_updated_category_image' );
add_filter( 'manage_edit-category_columns', 'mefe_custom_column_header', 10 );
add_action( 'manage_category_custom_column', 'mefe_custom_column_content', 10, 3 );
add_action( 'admin_footer', 'mefe_add_script' );