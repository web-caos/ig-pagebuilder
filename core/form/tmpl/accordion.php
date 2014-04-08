<?php
/**
 * @version    $Id$
 * @package    IG_Library
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 InnoGears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 */
?>
<div class="ig-form-accordion">
<?php foreach ( $this->current_accordion as $aid => $accordion ) : ?>
	<h3><?php esc_html_e( isset( $accordion['title'] ) ? $accordion['title'] : $aid, $this->text_domain ); ?></h3>
	<div id="ig-form-accordion-<?php esc_attr_e( $aid ); ?>" class="row">
	<?php
	if ( isset( $accordion['fields'] ) ) :
		$this->current_fields = $accordion['fields'];

		// Load fields template
		include IG_Loader::get_path( 'form/tmpl/fields.php' );
	endif;

	if ( isset( $accordion['fieldsets'] ) ) :
		$this->current_fieldsets = $accordion['fieldsets'];

		// Load fieldsets template
		include IG_Loader::get_path( 'form/tmpl/fieldsets.php' );
	endif;
	?>
	</div>
<?php endforeach; ?>
</div>
