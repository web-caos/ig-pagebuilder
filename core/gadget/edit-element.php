<?php
/**
 * @version    $Id$
 * @package    IG_PageBuilder
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 */

/**
 * Gadget class for loading editor for IG PageBuilder element.
 *
 * @package  IG_PageBuilder
 * @since    2.0.2
 */
class IG_Gadget_Edit_Element extends IG_Gadget_Base {
	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'edit-element';

	/**
	 * Load form for editing IG Page Builder element.
	 *
	 * @return  void
	 */
	public function form_action() {
		global $Ig_Pb;

		// Use output buffering to capture HTML code for element editor
		ob_start();

		if ( isset( $_GET['ig_shortcode_preview'] ) && 1 == $_GET['ig_shortcode_preview'] ) {
			$Ig_Pb->shortcode_iframe_preview();
		} else {
			$Ig_Pb->modal_page_content();
		}

		$this->set_response( 'success', ob_get_clean() );
	}

	/**
	 * Load HTML code for inserting element into  IG Page Builder area.
	 *
	 * @return  void
	 */
	public function insert_action() {
		global $Ig_Pb;

		// Use output buffering to hold all un-wanted output
		ob_start();

		// Get raw shortcode
		$raw_shortcode = isset( $_POST['raw_shortcode'] ) ? $_POST['raw_shortcode'] : null;

		if ( empty( $raw_shortcode ) ) {
			exit;
		}

		// Process raw shortcode then echo HTML code for insertion
		exit( IG_Pb_Helper_Shortcode::do_shortcode_admin( $raw_shortcode ) );
	}
}
