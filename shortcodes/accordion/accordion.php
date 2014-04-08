<?php
/**
 * @version	$Id$
 * @package	IG PageBuilder
 * @author	 InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 innogears.com. All Rights Reserved.
 * @license	GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 * Technical Support:  Feedback - http://www.innogears.com
 */
if ( ! class_exists( 'IG_Accordion' ) ) {

	class IG_Accordion extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode']        = strtolower( __CLASS__ );
			$this->config['name']             = __( 'Accordion', IGPBL );
			$this->config['cat']              = __( 'Typography', IGPBL );
			$this->config['icon']             = 'icon-paragraph-text';
			$this->config['has_subshortcode'] = 'IG_Item_' . str_replace( 'IG_', '', __CLASS__ );
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'action' => array(
					array(
						'id'      => 'btn_convert',
						'type'    => 'button_group',
						'bound'   => 0,
						'actions' => array(
							array(
								'std'         => __( 'Tab', IGPBL ),
								'action_type' => 'convert',
								'action'      => 'accordion_to_tab',
							),
							array(
								'std'         => __( 'Carousel', IGPBL ),
								'action_type' => 'convert',
								'action'      => 'accordion_to_carousel',
							),
							array(
								'std'         => __( 'List', IGPBL ),
								'action_type' => 'convert',
								'action'      => 'accordion_to_list',
							),
						)
					),
				),
				'content' => array(
					array(
						'name'    => __( 'Element Title', IGPBL ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => __( '', IGPBL ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily', IGPBL ),
					),
					array(
						'id'            => 'accordion_items',
						'type'          => 'group',
						'shortcode'     => ucfirst( __CLASS__ ),
						'sub_item_type' => $this->config['has_subshortcode'],
						'sub_items'     => array(
							array( 'std' => '' ),
							array( 'std' => '' ),
						),
					),
				),
				'styling' => array(
					array(
						'type' => 'preview',
					),
					array(
						'name'     => __( 'Initial Open', IGPBL ),
						'id'       => 'initial_open',
						'type'     => 'text_number',
						'std'      => '1',
						'class'    => 'input-mini',
						'validate' => 'number',
                        'tooltip' => __( 'Sets which item will be opened first', IGPBL ),
					),
					array(
						'name' => __( 'Allow Multiple Opening', IGPBL ),
						'id' => 'multi_open',
						'type' => 'radio',
						'std' => 'no',
						'options' => array( 'yes' => __( 'Yes', IGPBL ), 'no' => __( 'No', IGPBL ) ),
                        'tooltip' => __( 'Whether to opening multiple items or not', IGPBL ),
					),
					array(
						'name' => __( 'Enable Filter', IGPBL ),
						'id' => 'filter',
						'type' => 'radio',
						'std' => 'no',
						'options' => array( 'yes' => __( 'Yes', IGPBL ), 'no' => __( 'No', IGPBL ) ),
                        'tooltip' => __( 'Allowing to filter item using tags', IGPBL ),
					),
				)
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
			$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			$initial_open = intval( $arr_params['initial_open'] );
			$multi_open = ( $arr_params['multi_open'] );
			$filter = ( $arr_params['filter'] );
			$random_id = IG_Pb_Utils_Common::random_string();
			$script = '';
			if ( $multi_open == 'yes' ) {
				$script .= "<script type='text/javascript'>( function ($) {
					$( document ).ready( function ()
					{
						$( '#accordion_$random_id .panel-title a' ).click( function(e ){
							var collapse_item = $( '#accordion_$random_id '+this.hash )
							collapse_item.collapse( 'toggle' )
						});
					});
				} )( jQuery )</script>";
			} else {
				// some case the collapse doesn't work, need this code
				$script .= "<script type='text/javascript'>( function ($) {
					$( document ).ready( function ()
					{
						$( '#accordion_$random_id .panel-collapse' ).click( function(e ){
							var collapse_item = $( '#accordion_$random_id '+this.hash )
							$( '#accordion_$random_id .panel-body' ).each(function(){
								$( this ).addClass( 'panel-collapse' );
							});
							collapse_item.removeClass( 'panel-collapse' );
							collapse_item.attr( 'style', '' );
						});
					});
				} )( jQuery )</script>";
			}

			$sub_shortcode = IG_Pb_Helper_Shortcode::remove_autop( $content );
			$items = explode( '<!--seperate-->', $sub_shortcode );
			// remove empty element
			$items = array_filter( $items );
			$initial_open = ( $initial_open > count( $items ) ) ? 1 : $initial_open;
			foreach ( $items as $idx => $item ) {
				$open = ( $idx + 1 == $initial_open ) ? 'in' : '';
				$item = str_replace( '{index}', $random_id . $idx, $item );
				$item = str_replace( '{show_hide}', $open, $item );
				$items[$idx] = $item;
			}
			$sub_shortcode = implode( '', $items );


			$filter_html = '';
			if ( $filter == 'yes' ) {
				$sub_sc_data = IG_Pb_Helper_Shortcode::extract_sub_shortcode( $content );
				$tags = array();
				$tags[] = 'all';
				foreach ( $sub_sc_data as $shortcode ) {
					$extract_params = shortcode_parse_atts( $shortcode );
					$tags[] = $extract_params['tag'];
				}
				$tags = array_filter( $tags );
				if ( count( $tags ) > 1 ) {
					$tags = implode( ',', $tags );
					$tags = explode( ',', $tags );
					$tags = array_unique( $tags );
					$filter_html = IG_Pb_Helper_Shortcode::render_parameter( 'filter_list', $tags, $random_id );
					// remove "All" tag
					array_shift( $tags );
					$inner_tags = implode( ',', $tags );
					$script .= "<script type='text/javascript'>( function ($) {
					$( document ).ready( function ()
					{
						window.parent.jQuery.noConflict()( '#jsn_view_modal').contents().find( '#ig_share_data' ).text( '{$inner_tags}')
						var parent_criteria = '#filter_$random_id'
						var clientsClone = $( '#accordion_$random_id' );
						var tag_to_filter = 'div';
						var class_to_filter = '.panel-default';

						$( parent_criteria + ' a' ).click( function(e ) {
							// stop running filter
							$( class_to_filter ).each(function(){
								$( this ).stop( true )
							})
							e.preventDefault();

							//active clicked criteria
							$( parent_criteria + ' li' ).removeClass( 'active' );
							$( this ).parent().addClass( 'active' );

							var filterData = $( this ).attr( 'class' );
							var filters;
							if( filterData == 'all' ){
								filters = clientsClone.find( tag_to_filter );
							} else {
								filters = clientsClone.find( tag_to_filter + '[data-tag~='+ filterData +']' );
							}
							clientsClone.find( class_to_filter ).each(function(){
								$( this ).fadeOut()
							});
							filters.each(function(){
								$( this ).fadeIn()
							});
						});
					});
				} )( jQuery )</script>";
				}
			}


			$html = '<div class="panel-group" id="accordion_{ID}">' . $sub_shortcode . '</div>';
			$html = str_replace( '{ID}', $random_id, $html );

			return $this->element_wrapper( $html . $filter_html . $script, $arr_params );
		}

	}

}
