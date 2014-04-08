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

foreach ( $this->current_fields as $field ) :

// Get field description
$desc = $field->get( 'desc', null, true );

if ( $field->get( 'type', '', true ) == 'hidden' ) :

$field->get( 'input' );

elseif ( 'horizontal' == $alignment ) :
?>
	<div class="control-group">
		<?php if ( null != $field->get( 'label', null, true ) ) : ?>
		<label class="control-label" for="<?php $field->get( 'id' ); ?>">
			<?php $field->get( 'label' ); ?>
			<i class="ig-form-field-help icon-help has-tips" title="<?php $field->get( 'desc' ); ?>"></i>
		</label>
		<?php endif; ?>
		<div class="controls">
			<?php $field->get( 'input' ); ?>
		</div>
	</div>
<?php else : ?>
	<label class="control-label" for="<?php $field->get( 'id' ); ?>">
		<?php $field->get( 'label' ); ?>
		<i class="ig-form-field-help icon-help has-tips" title="<?php $field->get( 'desc' ); ?>"></i>
	</label>
	<?php $field->get( 'input' ); ?>
<?php
endif;

endforeach;
