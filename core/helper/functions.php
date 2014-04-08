<?php

/**
 * @version    $Id$
 * @package    IG PageBuilder
 * @author     InnoGears Team <support@www.innogears.com>
 * @copyright  Copyright (C) 2012 www.innogears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.www.innogears.com
 * Technical Support:  Feedback - http://www.www.innogears.com
 */
/**
 * Helper class of shortcode
 */
if ( ! class_exists( 'IG_Pb_Helper_Functions' ) ) {

	class IG_Pb_Helper_Functions {

		// Translating in Javascript
		static function js_translation() {
			$default = array(
				'site_url'              => site_url(),
				'delete_row'            => __( 'Are you sure you want to delete the whole row including all elements it contains?', IGPBL ),
				'delete_column'         => __( 'Are you sure you want to delete the whole column including all elements it contains?', IGPBL ),
				'delete_element'        => __( 'Are you sure you want to delete the element?', IGPBL ),
				'table'                 => array(
					'table1' => __( "A table must has atleast 1 columns. You can't remove this column", IGPBL ),
					'table2' => __( "A table must has atleast 2 rows. You can't remove this row", IGPBL ),
					'table3' => __( "Row span/Column span can't be negative", IGPBL ),
				),
				'saving'                => __( 'Saving content! Please wait a moment.', IGPBL ),
				'error_tinymce'         => __( 'Having error on loading TinyMCE.', IGPBL ),
				'settings'              => __( 'Settings', IGPBL ),
				'page_modal'            => __( 'Page Modal', IGPBL ),
				'convertText'           => __( 'Convert to ', IGPBL ),
				'shortcodes'            => array(
					'audio1'     => __( 'No audio source selected', IGPBL ),
					'googlemap1' => __( 'Select Destination Marker', IGPBL ),
					'video1'     => __( 'No video file selected', IGPBL ),
				),
				'noneTxt'               => __( 'None', IGPBL ),
				'invalid_link'          => __( 'The link is invalid', IGPBL ),
				'noItem'                => __( 'No %s found', IGPBL ),
				'singleEntry'           => __( 'Single %s', IGPBL ),
				'copy'                  => __( 'copy', IGPBL ),
				'itemFilter'            => __( '%s Filter', IGPBL ),
				'startFrom'             => __( 'Start From', IGPBL ),
				'menu'                  => __( 'Menu', IGPBL ),
				'filterBy'              => __( 'Filter By', IGPBL ),
				'attributes'            => __( 'Attributes', IGPBL ),
				'attribute'             => __( 'Attribute', IGPBL ),
				'option_attribute'      => __( 'Option Attribute', IGPBL ),
				'deactivatePb'          => __( 'After turning off, the content built with PageBuilder will be parsed to plain HTML code and inserted to default editor. Are you sure you want to turn PageBuilder off?', IGPBL ),
				'no_title'              => __( '(Untitled)', IGPBL ),
				'inno_shortcode'        => __( 'Inno Shortcodes', IGPBL ),
				'inno_icon'             => IG_Pb_Helper_Functions::path( 'assets/innogears' ) . '/images/ig-pgbldr-icon-black.png',
				'asset_url'             => IG_PB_URI . 'assets/innogears/',
				'prtbl_item_cell'       => IG_Pb_Helper_Functions::get_element_item_html(
						array(
							'element_wrapper' => 'li',
							'modal_title'     => 'data-modal-title="IG_OPTIONS_ATTRIBUTES"',
							'element_type'    => 'data-el-type="element"',
							'name'            => 'Item_pricingtable Item',
							'shortcode'       => 'ig_item_pricingtable',
							'shortcode_data'  => 'IG_SHORTCODE_CONTENT',
							'content_class'   => 'jsn-item-content',
							'content'         => 'IG_CONTENT',
							'action_btn'      => 'edit',
							'is_prtbl'        => TRUE,
						)
					),
				'prtbl_item_cell_label' => IG_Pb_Helper_Functions::get_element_item_html(
						array(
							'element_wrapper'       => 'li',
							'modal_title'           => 'data-modal-title="IG_OPTIONS_ATTRIBUTES"',
							'element_type'          => 'data-el-type="element"',
							'name'                  => 'Pricingtablelabel Item',
							'shortcode'             => 'ig_item_pricingtablelabel',
							'shortcode_data'        => 'IG_SHORTCODE_CONTENT',
							'content_class'         => 'jsn-item-content',
							'content'               => 'IG_CONTENT',
							'exclude_gen_shortcode' => 'exclude_gen_shortcode',
							'has_preview'           => FALSE,
						)
					),
				'limit_title'           => __( 'You used up to 50 characters', IGPBL ),
				'select_layout'         => __( 'The whole content of current Post will be replaced by content of selected Page item. Do you want to continue?', IGPBL ),
				'disabled'              => array(
					'deactivate' => __( 'Deactivate element', IGPBL ),
					'reactivate' => __( 'Activate element', IGPBL ),
				),
				'button'                => array(
					'select' => __( 'Select', IGPBL ),
				),
				'layout'                => array(
					'modal_title'           => __( 'Select template', IGPBL ),
					'upload_layout_success' => __( 'Upload successfully', IGPBL ),
					'upload_layout_fail'    => __( 'Upload fail', IGPBL ),
					'delete_layout_success' => __( 'Page is deleted successfully', IGPBL ),
					'delete_layout_fail'    => __( 'Fail. Can\'t delete layout', IGPBL ),
					'delete_group'          => __( 'All pages in this group will be remove. Do you want to continue ?', IGPBL ),
					'delete_layout'         => __( 'This page will be remove. Do you want to continue ?', IGPBL ),
					'no_layout_name'        => __( 'Template name can not be null' ),
					'name_exist'            => __( 'Template name exists. Please choose another one.' ),
				),
				'custom_css'            => array(
					'modal_title' => __( 'Custom CSS', IGPBL ),
					'file_not_found' => __( "File doesn't exist", IGPBL ),
				),
				'element_not_existed' => __( 'Element not existed!', IGPBL ),
			);

			return apply_filters( 'ig_pb_js_translation', $default );
		}

		/**
		 * Enqueue assets for shortcodes
		 * @global type $Ig_Sc_By_Providers
		 *
		 * @param type  $this_    :   current shortcode object
		 * @param type  $extra    :   require_frontend_js/ require_js
		 * @param type  $post_fix :   _frontend/ ''
		 */
		public static function shortcode_enqueue_assets( $this_, $extra, $post_fix = '' ) {
			global $post;
			// check if this is backend or frontend
			$side = IG_Pb_Helper_Functions::is_preview() ? 'admin' : 'wp';

			$extra_js = isset( $this_->config['exception'] ) && isset( $this_->config['exception'][$extra] ) && is_array( $this_->config['exception'][$extra] );
			$assets   = array_merge( $extra_js ? $this_->config['exception'][$extra] : array(), array( str_replace( 'ig_', '', $this_->config['shortcode'] ) . $post_fix ) );
			foreach ( $assets as $asset ) {

				if ( wp_script_is( $asset, 'registered' ) ) {
					IG_Init_Assets::load( $asset );
				} else {
					global $Ig_Sc_By_Providers;
					if ( empty( $Ig_Sc_By_Providers ) ) {
						continue;
					}

					// load assets file in common assets directory of provider
					$default_assets = self::assets_default( $this_, $asset );

					// if can't find the asset file, search in /assets folder of the shortcode
					if ( ! $default_assets ) {

						// get path of directory contains all shortcodes of provider
						$shortcode_dir = IG_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'shortcode_dir' );

						if ( $shortcode_dir == IG_PB_LAYOUT_PATH ) {
							// this is core PB
							$sc_path = IG_PB_ELEMENT_PATH;
							$sc_uri  = IG_PB_URI . basename( $sc_path );
						} else {
							$plugin_path   = IG_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'path' );
							$plugin_uri    = IG_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'uri' );
							$shortcode_dir = IG_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'shortcode_dir' );
							$shortcode_dir = is_array( $shortcode_dir ) ? $shortcode_dir[0] : $shortcode_dir;
							$sc_path = $plugin_path . basename( $shortcode_dir );

							if ( is_dir( $sc_path ) ) {
								$sc_uri = $plugin_uri . basename( $shortcode_dir );
							} else {
								$sc_path = $plugin_path;
								$sc_uri  = $plugin_uri;
							}
						}

						$ext_regex = '/\.(js|css)$/';
						if ( preg_match( $ext_regex, $asset ) ) {
							// load assets in directory of other shortcodes
							$require_sc = preg_replace( $ext_regex, '', $asset );
							self::assets_specific_shortcode( $require_sc, $asset, $sc_path, $sc_uri );
						} else {
							// auto load js/css file in directory of current shortcode
							$exts = array( 'js', 'css' );

							foreach ( $exts as $ext ) {
								$require_sc = $this_->config['shortcode'];
								$file       = $asset . ".$ext";

								// if this asset is processed, leave it
								if ( in_array( $file, (array) $_SESSION['processed-assets'][$post->ID][$side]['assets'] ) ) {
									return;
								}

								// enqueue or add to cache file
								self::assets_specific_shortcode( $require_sc, $file, $sc_path, $sc_uri );

								// store it as processed asset
								$_SESSION['processed-assets'][$post->ID]['assets'][$side][] = $file;
							}
						}
					}
				}
			}
		}

		/**
		 * Get assest file in IG PageBuilder assets directory
		 *
		 * @param type $this_
		 * @param type $js_file
		 */
		static private function assets_default( $this_, $js_file ) {
			global $Ig_Sc_By_Providers, $post;

			// if this asset is processed, leave it
			if ( in_array( $js_file, (array) $_SESSION['processed-assets'][$post->ID][$side]['assets'] ) ) {
				return;
			}

			// get js directory of InnoGears
			$inno_gears    = array_values( IG_Pb_Helper_Shortcode::this_provider() );
			$inno_gears_js = $inno_gears[0]['js_shortcode_dir'];

			// get js directory of shortcodes
			$js_dir = IG_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'js_shortcode_dir' );
			if ( empty( $js_dir ) || ! count( $js_dir ) ) {
				// if doesn't have a js dir, assign InnoGears js dir
				$js_dir = $inno_gears_js;
			}
			$file_path = $js_dir['path'] . '/' . $js_file;
			$file_uri  = $js_dir['uri'] . '/' . $js_file;

			// if file doesn't exist, try to get it in IGPB js dir
			if ( ! file_exists( $file_path ) ) {
				$file_path = $inno_gears_js['path'] . '/' . $js_file;
				$file_uri  = $inno_gears_js['uri'] . '/' . $js_file;
			}

			if ( file_exists( $file_path ) ) {
				self::asset_enqueue_( $file_uri, $js_file, $file_path );

				// store it as processed asset
				$_SESSION['processed-assets'][$post->ID][$side]['assets'][] = $js_file;

				return true;
			}

			return false;
		}

		/**
		 * Get assets in specific shortcode folder
		 *
		 * @param type $require_sc
		 * @param type $js_file
		 * @param type $sc_path
		 * @param type $sc_uri
		 */
		static private function assets_specific_shortcode( $require_sc, $js_file, $sc_path, $sc_uri ) {
			$sc_path = rtrim( $sc_path, '/' );
			$sc_uri  = rtrim( $sc_uri, '/' );

			// get parent shortcode name
			$require_sc = preg_replace( '/(ig_|item_)/', '', $require_sc );

			// get type of asset file
			$type = strpos( $js_file, '.js' ) ? 'js/' : 'css/';

			// get path & uri
			$file_path = $sc_path . "/$require_sc/assets/$type" . $js_file;
			$file_uri  = $sc_uri . "/$require_sc/assets/$type" . $js_file;

			if ( file_exists( $file_path ) ) {
				self::asset_enqueue_( $file_uri, $js_file, $file_path );
			}
		}

		/**
		 * Enqueue script/style
		 *
		 * @param unknown $file_uri
		 * @param unknown $js_file
		 */
		static private function asset_enqueue_( $file_uri, $js_file, $file_path ) {
			$enqueue = 0;
			if ( is_admin() ) {
				$enqueue = 1;
			} else {
				$ig_pb_settings_cache = get_option( 'ig_pb_settings_cache', 'enable' );
				if ( $ig_pb_settings_cache == 'enable' ) {
					self::store_assets_info( preg_replace( '/[_.]/', '-', $js_file ), $file_uri, $file_path );
				} else {
					$enqueue = 1;
				}
			}
			if ( $enqueue ) {
				if ( strpos( $file_uri, '.js' ) !== false )
					wp_enqueue_script( preg_replace( '/[_.]/', '-', $js_file ), $file_uri );
				else {
					wp_enqueue_style( preg_replace( '/[_.]/', '-', $js_file ), $file_uri );
				}
			}
		}

		/**
		 * Store handle to Session
		 *
		 * @global type $wp_scripts
		 *
		 * @param type  $handle
		 */
		static function store_assets_info( $handle, $src = '', $file_path = '' ) {
			global $wp_scripts, $post;
			$handle_object = array();

			if ( empty ( $_SESSION['ig-pb-assets-frontend'] ) )
				$_SESSION['ig-pb-assets-frontend'] = array();
			if ( empty ( $_SESSION['ig-pb-assets-frontend'][$post->ID] ) )
				$_SESSION['ig-pb-assets-frontend'][$post->ID] = array();

			if ( ! ( empty ( $wp_scripts ) && empty ( $wp_scripts->registered ) ) ) {
				if ( array_key_exists( $handle, $wp_scripts->registered ) ) {
					$handle_object = $wp_scripts->registered[$handle];
					$src           = $handle_object['src'];
				}
			}

			$type = ( substr( $src, - 2 ) == 'js' ) ? 'js' : 'css';
			if ( empty ( $_SESSION['ig-pb-assets-frontend'][$post->ID][$type] ) )
				$_SESSION['ig-pb-assets-frontend'][$post->ID][$type] = array();

			if ( ! array_key_exists( $handle, $_SESSION['ig-pb-assets-frontend'][$post->ID][$type] ) ) {
				//				// Dependency
				//				if( isset ( $handle_object['deps'] ) ) {
				//					$deps = $handle_object['deps'];
				//					foreach ($deps as $other_handle) {
				//						self::store_assets_info( $other_handle );
				//					}
				//				}
				$modified_time                                                   = filemtime( $file_path );
				$_SESSION['ig-pb-assets-frontend'][$post->ID][$type][$file_path] = $modified_time;
			}

		}

		/**
		 * remove HTML/PHP tag & other tag in ID of an element
		 *
		 * @param type $string
		 *
		 * @return type
		 */
		static function remove_tag( $string ) {
			$string = strip_tags( $string );
			$string = str_replace( '-value-', '', $string );
			$string = str_replace( '-type-', '', $string );

			return $string;
		}

		/**
		 * Get post excerpt (can't use WP excerpt function, because post content contains IGPB shortcodes)
		 *
		 * @param type $post_content
		 *
		 * @return type
		 */
		static function post_excerpt( $post_content ) {
			$excerpt = IG_Pb_Helper_Shortcode::remove_ig_shortcodes( $post_content );

			return strip_tags( $excerpt );
		}

		/**
		 * Js for fancybox
		 *
		 * @param type $selector
		 *
		 * @return type
		 */
		static function fancybox( $selector, $options = array() ) {
			$default = array(
				'type'          => '',
				'autoScale'     => 'false',
				'transitionIn'  => 'elastic',
				'transitionOut' => 'elastic',
			);
			$options = array_merge( $default, $options );
			$data    = array();
			foreach ( $options as $key => $value ) {
				$value  = is_string( $value ) ? "'$value'" : $value;
				$data[] = "'$key' : $value";
			}
			$data = implode( ',', $data );

			$script  = "<script type='text/javascript'>";
			$script .= "( function ($ ) {
				$( document ).ready( function () {
					$( '$selector' ).fancybox( { $data } );
				});
			})( jQuery )";
			$script .= '</script>';

			return $script;
		}

		/**
		 * Social share links
		 *
		 * @param type $social_networks
		 *
		 * @return type
		 */
		static function social_links( $social_networks, $permalink, $title, $thumb, $excerpt ) {
			$all_socials     = array(
				'facebook'   => array( 'link' => 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $permalink . '&p[images][0]=' . $thumb . '&p[title]=' . $title . '&p[summary]=' . $excerpt ),
				'twitter'    => array( 'link' => 'http://twitter.com/home/?status=' . $title . ' - ' . $permalink ),
				'googleplus' => array( 'link' => 'https://plus.google.com/share?url=' . $permalink ),
			);
			$links           = array();
			$social_networks = array_filter( $social_networks );
			foreach ( $social_networks as $network ) {
				if ( isset( $all_socials[$network] ) ) {
					$network_info = $all_socials[$network];
					$links[]      = "<li><a href='{$network_info['link']}' target='_blank' class='$network social-link'></a></li>";
				}
			}
			ob_start();
			?>
			<script type='text/javascript'>
				(function ($) {
					$(document).ready(function () {
						$('.social-link').unbind('click').click(function (e) {
							e.preventDefault();
							var w = 600, h = 600;
							var left = (screen.width / 2) - (w / 2);
							var top = (screen.height / 2) - (h / 2);
							window.open($(this).attr('href'), "_blank", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
						});
					});
				})(jQuery);
			</script>
			<?php
			$script = ob_get_clean();

			return $script . '<ul class="ig-social-links">' . implode( '', $links ) . '</ul>';
		}

		/**
		 * Modify value in array
		 *
		 * @param type $value
		 * @param type $key
		 * @param type $filter_arr
		 */
		static function ig_arr_walk( &$value, $key, $filter_arr ) {
			if ( array_key_exists( $value['id'], $filter_arr ) )
				$value['std'] = $filter_arr[$value['id']];
		}

		/**
		 * Modify value in array of sub-shortcode
		 *
		 * @param type $value
		 * @param type $key
		 * @param type $filter_arr
		 */
		static function ig_arr_walk_subsc( &$value, $key, $filter_arr ) {
			$value['std'] = $filter_arr[$key];
		}

		// get image id
		public static function get_image_id( $image_url = '' ) {
			global $wpdb;
			$attachment_id = false;

			// If there is no url, return.
			if ( '' == $image_url )
				return;

			// Get the upload directory paths
			$upload_dir_paths = wp_upload_dir();

			// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
			if ( false !== strpos( $image_url, $upload_dir_paths['baseurl'] ) ) {

				// If this is the URL of an auto-generated thumbnail, get the URL of the original image
				$image_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url );

				// Remove the upload path base directory from the attachment URL
				$image_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $image_url );

				// Finally, run a custom database query to get the attachment ID from the modified attachment URL
				$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $image_url ) );
			}

			return $attachment_id;
		}

		// count post views.
		public static function set_postview( $postID ) {
			$count_key = '_ig_post_view_count';
			$count     = get_post_meta( $postID, $count_key, true );
			if ( $count == '' ) {
				$count = 0;
				delete_post_meta( $postID, $count_key );
				add_post_meta( $postID, $count_key, '0' );
			} else {
				$count ++;
				update_post_meta( $postID, $count_key, $count );
			}
		}

		// get post views.
		public static function get_postview( $postID ) {
			$count_key = '_ig_post_view_count';
			$count     = get_post_meta( $postID, $count_key, true );
			if ( empty( $count ) || intval( $count ) == 0 ) {
				delete_post_meta( $postID, $count_key );
				add_post_meta( $postID, $count_key, '0' );

				return '0 ' . __( 'View', IGPBL );
			}

			return $count . ' ' . ( ( intval( $count ) == 1 ) ? __( 'View', IGPBL ) : __( 'Views', IGPBL ) );
		}

		// Get current shortcode
		public static function current_shortcode() {
			if ( ! empty( $_GET['ig-gadget'] ) && $_GET['ig-gadget'] == 'edit-element' ) {
				$current_shortcode = ! empty( $_GET['ig_modal_type'] ) ? $_GET['ig_modal_type'] : ( ! empty( $_GET['ig_shortcode_name'] ) ? $_GET['ig_shortcode_name'] : '' );
				$current_shortcode = preg_replace( '/(ig_|item_)/', '', $current_shortcode );

				return $current_shortcode;
			}

			return NULL;
		}

		// check if current page is modal page
		public static function is_modal() {
			return ( ! empty( $_GET['ig-gadget'] ) && $_GET['ig-gadget'] == 'edit-element' );
		}

		// check if current page is modal page
		public static function is_modal_of_element( $shortcode ) {
			if ( empty ( $shortcode ) ) {
				return false;
			}

			return ( IG_Pb_Helper_Functions::is_modal() && isset( $_GET['ig_modal_type'] ) && $_GET['ig_modal_type'] == $shortcode );
		}

		// check if current page is modal/ preview page
		public static function is_preview() {
			return ( ! empty( $_GET['ig_shortcode_preview'] ) && $_GET['ig_shortcode_preview'] == '1' );
		}

		// get folder path
		public static function path( $folder = '', $uri = '' ) {
			$uri = empty ( $uri ) ? IG_PB_URI : $uri;

			return $uri . $folder;
		}

		// Common js/css file for IG PageBuilder/Ig Modal/Ig Preview Page
		public static function localize_js() {
			return array(
				'ajaxurl'      => admin_url( 'admin-ajax.php' ),
				'adminroot'    => admin_url(),
				'_nonce'       => wp_create_nonce( IGNONCE ),
				'ig_modal_url' => IG_EDIT_ELEMENT_URL,
				'save'         => __( 'Save', IGPBL ),
				'cancel'       => __( 'Cancel', IGPBL )
			);
		}

		// common scripts register at first
		public static function enqueue_scripts() {
			IG_Init_Assets::load( array( 'jquery', 'jquery-ui', 'jquery-ui-resizable', 'jquery-ui-sortable', 'jquery-ui-tabs', 'jquery-ui-dialog', 'jquery-ui-button', 'jquery-ui-slider', 'ig-pb-jquery-tipsy-js', 'ig-pb-bootstrap-js', 'ig-pb-jquery-easing-js' ) );
		}

		public static function enqueue_scripts_modal() {
			IG_Init_Assets::load( array( 'jquery', 'jquery-ui', 'jquery-ui-resizable', 'jquery-ui-tabs', 'ig-pb-jquery-tipsy-js', 'ig-pb-bootstrap-js' ) );
		}

		/**
		 * Method to enqueue needed scripts to handle
		 * elements on PageBuilder
		 */
		public static function enqueue_scripts_end() {
			// Load modal script
			IG_Init_Assets::load( 'ig-pb-modal-js' );

			if ( $_GET['ig_layout'] == 1 ) {
				// Load premade layout script
				IG_Init_Assets::load( 'ig-pb-premade-pages-js' );
			} else {
				// Load element editor script
				IG_Init_Assets::load( 'ig-pb-handleelement-js' );
			}

			// Localize necessary scripts
			self::ig_localize();
		}

		// common styles
		public static function enqueue_styles() {
			add_filter( 'ig_register_assets', array( __CLASS__, 'register_assets' ) );
			IG_Init_Assets::load( array( 'ig-pb-jquery-ui-css', 'ig-pb-joomlashine-css', 'ig-pb-font-icomoon-css', 'ig-pb-jquery-select2-css', 'ig-pb-admin-css' ) );
		}

		// register some custom assets
		public static function register_assets( $assets ) {
			$assets['ig-pb-modal-js']         = array(
				'src' => IG_Pb_Helper_Functions::path( 'assets/innogears' ) . '/js/modal.js',
				'ver' => '1.0.0',
			);
			$assets['ig-pb-handleelement-js'] = array(
				'src' => IG_Pb_Helper_Functions::path( 'assets/innogears' ) . '/js/handle_element.js',
				'ver' => '1.0.0',
			);
			$assets['ig-pb-premade-pages-js'] = array(
				'src' => IG_Pb_Helper_Functions::path( 'assets/innogears' ) . '/js/premade-pages/premade.js',
				'ver' => '1.0.0',
			);
			$assets['ig-pb-admin-css'] = array(
				'src' => IG_Pb_Helper_Functions::path( 'assets/innogears' ) . '/css/page_builder.css',
				'ver' => '1.0.0',
			);

			return $assets;
		}

		// localize for js files
		public static function ig_localize() {
			IG_Init_Assets::localize( 'ig-pb-handleelement', 'Ig_Translate', IG_Pb_Helper_Functions::js_translation() );
			IG_Init_Assets::localize( 'ig-pb-handleelement', 'Ig_Js_Html', IG_Pb_Helper_Shortcode::$item_html_template );
			IG_Init_Assets::localize( 'ig-pb-handleelement', 'Ig_Ajax', IG_Pb_Helper_Functions::localize_js() );

			// Localize scripts for premade layout modal.
			IG_Init_Assets::localize( 'ig-pb-premade-pages', 'Ig_Translate', IG_Pb_Helper_Functions::js_translation() );
			IG_Init_Assets::localize( 'ig-pb-premade-pages', 'Ig_Ajax', IG_Pb_Helper_Functions::localize_js() );

			IG_Init_Assets::localize( 'ig-pb-layout', 'Ig_Translate', IG_Pb_Helper_Functions::js_translation() );
			IG_Init_Assets::localize(
				'ig-pb-widget', 'Ig_Preview_Html', IG_Pb_Helper_Functions::get_element_item_html(
					array(
						'element_wrapper' => 'div',
						'modal_title'     => '',
						'element_type'    => 'data-el-type="element"',
						'name'            => 'Widget Element Setting',
						'shortcode'       => 'IG_SHORTCODE_CONTENT',
						'shortcode_data'  => 'IG_SHORTCODE_DATA',
						'content_class'   => 'ig-pb-element',
						'content'         => 'Widget Element Setting',
					)
				)
			);
		}

		// get list of defined widgets
		public static function list_widgets() {
			global $wp_widget_factory;
			$results = array();
			foreach ( $wp_widget_factory->widgets as $class => $info ) {
				$results[$info->id_base] = array(
					'class'       => $class,
					'name'        => __( $info->name, IGPBL ),
					'description' => __( $info->widget_options['description'], IGPBL )
				);
			}

			return $results;
		}

		// get all neccessary widgets information
		public static function widgets() {
			$Ig_Pb_Widgets = array();
			$widgets       = IG_Pb_Helper_Functions::list_widgets();
			foreach ( $widgets as $id => $widget ) {
				if ( $widget['class'] == 'IG_Pb_Objects_Widget' )
					continue;
				$config                          = array(
					'shortcode'     => $widget['class'],
					'name'          => $widget['name'],
					'identity_name' => __( 'Widget', IGPBL ) . ' ' . $widget['name'],
					'extra_'        => "data-value='" . $id . "' data-type='widget'",
				);
				$Ig_Pb_Widgets[$widget['class']] = $config;
			}

			return $Ig_Pb_Widgets;
		}

		/**
		 * Get html item
		 *
		 * @param array $data
		 *
		 * @return string
		 */
		static function get_element_item_html( $data ) {
			$default = array(
				'element_wrapper'       => '',
				'modal_title'           => '',
				'element_type'          => '',
				'name'                  => '',
				'shortcode'             => '',
				'shortcode_data'        => '',
				'content_class'         => '',
				'content'               => '',
				'action_btn'            => '',
				'is_prtbl'              => false,
				'exclude_gen_shortcode' => '',
				'has_preview'           => true,
				'this_'                 => '',
			);
			$data = array_merge( $default, $data );
			extract( $data );

			$input_html = '';
			if ( $is_prtbl ) {
				$input_html = '<input type="hidden" data-popover-item="yes" name="param-elements" id="param-elements" value="ig_item_pricingtable">';
			}
			$preview_html = '';
			if ( $has_preview ) {
				$preview_html = '<div class="shortcode-preview-container" style="display: none">
					<div class="shortcode-preview-fog"></div>
					<div class="jsn-overlay jsn-bgimage image-loading-24"></div>
				</div>';
			}
			$extra_class  = IG_Pb_Utils_Placeholder::get_placeholder( 'extra_class' );
			$custom_style = IG_Pb_Utils_Placeholder::get_placeholder( 'custom_style' );
			$other_class  = '';

			if ( ! empty( $this_ ) ) {
				$match = preg_match( "/\[$shortcode" . '\s' . '([^\]])*' . 'disabled_el="yes"' . '([^\]])*' . '\]/', $shortcode_data );
				if ( $match ) {
					$other_class = 'disabled';
				}
			}
			
			// Remove empty value attributes of shortcode tag.
			$shortcode_data	= preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*"")/', '', $shortcode_data );
			
			$buttons = array(
				'edit'       => '<a href="#" onclick="return false;" title="' . __( 'Edit element', IGPBL ) . '" data-shortcode="' . $shortcode . '" class="element-edit"><i class="icon-pencil"></i></a>',
				'clone'      => '<a href="#" onclick="return false;" title="' . __( 'Duplicate element', IGPBL ) . '" data-shortcode="' . $shortcode . '" class="element-clone"><i class="icon-copy"></i></a>',
				'deactivate'  => '<a href="#" onclick="return false;" title="' . __( 'Deactivate element', IGPBL ) . '" data-shortcode="' . $shortcode . '" class="element-deactivate"><i class="icon-checkbox-unchecked"></i></a>',
				'delete'     => '<a href="#" onclick="return false;" title="' . __( 'Delete element', IGPBL ) . '" class="element-delete"><i class="icon-trash"></i></a>'
			);
			if ( ! empty ( $other_class ) ) {
				$buttons = array_merge(
					$buttons, array(
					'deactivate'  => '<a href="#" onclick="return false;" title="' . __( 'Activate element', IGPBL ) . '" data-shortcode="' . $shortcode . '" class="element-deactivate"><i class="icon-checkbox-partial"></i></a>',
					)
				);
			}
			$action_btns = ( empty( $action_btn ) ) ? implode( '', $buttons ) : $buttons[$action_btn];
			$content     = balanceTags( $content );

			return "<$element_wrapper class='jsn-item jsn-element ui-state-default jsn-iconbar-trigger shortcode-container $extra_class $other_class' $modal_title $element_type data-name='$name' $custom_style>
				<textarea class='hidden $exclude_gen_shortcode shortcode-content' shortcode-name='$shortcode' data-sc-info='shortcode_content' name='shortcode_content[]' >$shortcode_data</textarea>
				<div class='$content_class'>$content</div>
				$input_html
				<div class='jsn-iconbar'>$action_btns</div>
				$preview_html
			</$element_wrapper>";
		}

		/**
		 * Get basedir of subfolder in UPLOAD folder
		 *
		 * @param type $sub_dir
		 *
		 * @return type
		 */
		static function get_wp_upload_folder( $sub_dir = '', $auto_create = true ) {
			$upload_dir = wp_upload_dir();
			if ( is_array( $upload_dir ) && isset ( $upload_dir['basedir'] ) ) {
				$upload_dir = $upload_dir['basedir'];
			} else {
				$upload_dir = WP_CONTENT_DIR . '/uploads';
				if ( ! is_dir( $upload_dir ) ) {
					mkdir( $upload_dir );
				}
			}
			if ( $auto_create && ! is_dir( $upload_dir . $sub_dir ) ) {
				mkdir( $upload_dir . $sub_dir, 0777, true );
			}

			return $upload_dir . $sub_dir;
		}

		/**
		 * Get baseurl of subfolder in UPLOAD folder
		 *
		 * @param type $sub_dir
		 *
		 * @return type
		 */
		static function get_wp_upload_url( $sub_dir = '' ) {
			$upload_dir = wp_upload_dir();
			if ( is_array( $upload_dir ) && isset ( $upload_dir['basedir'] ) ) {
				return $upload_dir['baseurl'] . $sub_dir;
			} else {
				return WP_CONTENT_URL . '/uploads' . $sub_dir;
			}
		}

		/**
		 * Store relation: array(file1, file2) => compressed file
		 *
		 * @param type $handle_info
		 * @param type $file_name
		 *
		 * @return type
		 */
		static function compression_data_store( $handle_info, $file_name ) {
			$cache_dir      = IG_Pb_Helper_Functions::get_wp_upload_folder( '/igcache/pagebuilder' );
			$file_to_write_ = "$cache_dir/ig-pb.cache";
			$fp             = fopen( $file_to_write_, 'a+' );
			if ( $fp ) {
				// get stored data
				$str = '';
				while ( ! feof( $fp ) ) {
					$str .= fread( $fp, 1024 );
				}
				$stored_data = unserialize( $str );
				$stored_data = $stored_data ? $stored_data : array();
				// check if $handle_info is existed in stored data
				$exist = '';
				foreach ( $stored_data as $handle_info_serialized => $compressed_file ) {
					$handle_info_old = unserialize( $handle_info_serialized );
					// check if handle names are same
					if ( ! count( array_diff( array_keys( $handle_info ), array_keys( $handle_info_old ) ) ) ) {
						// check if date modified are same
						if ( ! count( array_diff( $handle_info, $handle_info_old ) ) ) {
							$exist = $compressed_file;
							fclose( $fp );

							return array( 'exist', $compressed_file );
						}
					}
				}

				// close current handle
				fclose( $fp );

				// open new handle to write from beginning of file
				$fp                   = fopen( $file_to_write_, 'w' );
				$string               = serialize( $handle_info );
				$stored_data[$string] = $file_name;
				fwrite( $fp, serialize( $stored_data ) );

				fclose( $fp );

				return array( 'not exist', $file_name );
			}
		}

		/**
		 * Handle empty icon & heading for Carousel, ,Tab, Accordion, List item
		 *
		 * @param type $heading
		 * @param type $icon
		 */
		static function heading_icon( &$heading, &$icon, $heading_empty = false ) {
			if ( strpos( $heading, IG_Pb_Utils_Placeholder::get_placeholder( 'index' ) ) !== false ) {
				$heading = '';
			}
			if ( empty ( $icon ) && empty ( $heading ) )
				$heading = ! $heading_empty ? __( '(Untitled)', IGPBL ) : '';
		}

		/**
		 * Show alert box
		 *
		 * @param unknown $mgs
		 */
		static function alert_msg( $mgs ) {
			?>
			<div class="alert alert-<?php echo balanceTags( $mgs[0] ); ?>"><?php echo balanceTags( $mgs[1] ); ?></div>
		<?php
		}

		/**
		 * Load bootstrap 3, replace bootstrap 2
		 *
		 * @param type $assets
		 *
		 * @return string
		 */
		static function load_bootstrap_3( &$assets ) {
			if ( ! is_admin() || IG_Pb_Helper_Functions::is_preview() ) {
				$assets['ig-pb-bootstrap-css'] = array(
					'src' => IG_Pb_Helper_Functions::path( 'assets/3rd-party/bootstrap3' ) . '/css/bootstrap.min.css',
					'ver' => '3.0.2',
				);
				$assets['ig-pb-bootstrap-js'] = array(
					'src' => IG_Pb_Helper_Functions::path( 'assets/3rd-party/bootstrap3' ) . '/js/bootstrap.min.js',
					'ver' => '3.0.2',
				);
			}
		}

		/**
		 * Get custom CSS meta data of post
		 *
		 * @param type $post_id
		 * @param type $meta_key
		 * @param type $action : get / put
		 *
		 * @return type
		 */
		static function custom_css( $post_id, $meta_key, $action = 'get', $value = '' ) {
			switch ( $meta_key ) {

				case 'css_files':
					if ( $action == 'get' )
						$result = get_post_meta( $post_id, '_ig_page_builder_css_files', true );
					else {
						$result = update_post_meta( $post_id, '_ig_page_builder_css_files', $value );
					}
					break;

				case 'css_custom':
					if ( $action == 'get' )
						$result = get_post_meta( $post_id, '_ig_page_builder_css_custom', true );
					else
						$result = update_post_meta( $post_id, '_ig_page_builder_css_custom', $value );
					break;

				default:
					break;
			}
			return $result;
		}

		/**
		 * Get custom css data: Css files, Css code of a post
		 *
		 * @param type $post_id
		 */
		static function custom_css_data( $post_id ) {

			global $post;

			$arr = array( 'css_files' => '', 'css_custom' => '' );
			if ( isset ( $post_id ) ) {
				$arr['css_files']  = IG_Pb_Helper_Functions::custom_css( $post_id, 'css_files' );
				$arr['css_custom'] = IG_Pb_Helper_Functions::custom_css( $post_id, 'css_custom' );
			}

			return $arr;
		}

		/**
		 * Get custom information of plugin
		 *
		 * @param type $plugin_file : main file of plugin
		 * @param type $custom_info : custom date key
		 *
		 * @return type
		 */
		static function get_plugin_info( $plugin_file, $custom_info = '' ) {

			$plugin_data = get_plugin_data( $plugin_file );

			if ( $custom_info ) {
				return isset ( $plugin_data[$custom_info] ) ? $plugin_data[$custom_info] : NULL;
			}

			return $plugin_data;
		}

		/**
		 * Add google link to header
		 *
		 * @param type $font
		 *
		 * @return type
		 */
		static function add_google_font_link_tag( $font ) {
			ob_start();
			?>
			<script type="text/javascript">
				(function ($) {
					$(document).ready(function () {
						var font_val = '<?php echo esc_js( str_replace( ' ', '+', $font ) ); ?>';

						// check if has a link tag of this font
						var exist_font = 0;
						$('link[rel="stylesheet"]').each(function (i, ele) {
							var href = $(this).attr('href');
							if (href.indexOf('fonts.googleapis.com/css?family=' + font_val) >= 0) {
								exist_font++;
							}
						});

						// if this font is not included at head, add it
						if (!exist_font) {
							$('head').append("<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=<?php echo esc_attr( $font ); ?>' type='text/css' media='all' />");
						}
					});
				})(jQuery)
			</script>
			<?php
			return ob_get_clean();
		}

		/**
         * show script tag with custom code
         */
		static function script_box( $content = '' ) {
			ob_start();
			?>
			<script type="text/javascript">
				(function ($) {
					$(document).ready(function () {
                        <?php echo balanceTags( $content ); ?>
                    });
				})(jQuery)
			</script>
			<?php
			return ob_get_clean();
		}
	}

}
