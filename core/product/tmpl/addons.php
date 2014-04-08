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
<div class="wrap jsn-master">
	<h2><?php _e( $plugin['Name'], IG_LIBRARY_TEXTDOMAIN ); ?> <?php _e( 'Add-ons', IG_LIBRARY_TEXTDOMAIN ); ?></h2>
	<p>
		<?php printf( __( 'Extend %s functionality with following add-ons', IG_LIBRARY_TEXTDOMAIN ), __( $plugin['Name'], IG_LIBRARY_TEXTDOMAIN ) ); ?>
	</p>
	<div class="jsn-bootstrap" id="ig-product-addons">
		<ul id="<?php echo '' . $plugin['Identified_Name']; ?>-addons" class="thumbnails">
			<?php foreach ( $plugin['Addons'] as $identified_name => $details ) : ?>
			<li class="thumbnail">
				<img src="<?php echo esc_url( $details->thumbnail ); ?>" alt="<?php esc_attr_e( $details->name, IG_LIBRARY_TEXTDOMAIN ) ?>" />
				<?php if ( ! $details->compatible ) : ?>
				<span class="label label-important"><?php _e( 'Incompatible', IG_LIBRARY_TEXTDOMAIN ); ?></span>
				<?php elseif ( $details->installed ) : ?>
				<span class="label label-success"><?php _e( 'Installed', IG_LIBRARY_TEXTDOMAIN ); ?></span>
				<?php endif; ?>
				<div class="caption">
					<h3><?php _e( $details->name, IG_LIBRARY_TEXTDOMAIN ) ?></h3>
					<p><?php _e( $details->description, IG_LIBRARY_TEXTDOMAIN ) ?></p>
					<div class="actions clearfix">
						<div class="pull-left">
							<?php if ( ! $details->installed ) : ?>
							<a class="btn btn-primary <?php if ( ! $details->compatible ) echo 'disabled'; ?>" href="javascript:void(0);" <?php if ( $details->compatible ) : ?>data-action="install" data-authentication="<?php echo absint( $details->authentication ); ?>" data-identification="<?php echo '' . $details->identified_name; ?>"<?php endif; ?>>
								<?php _e( 'Install', IG_LIBRARY_TEXTDOMAIN ); ?>
							</a>
							<?php else : if ( $details->updatable ) : ?>
							<a class="btn btn-primary <?php if ( ! $details->compatible ) echo 'disabled'; ?>" href="javascript:void(0);" data-action="update" <?php if ( $details->compatible ) : ?>data-authentication="<?php echo absint( $details->authentication ); ?>" data-identification="<?php echo '' . $details->identified_name; ?>"<?php endif; ?>>
								<?php _e( 'Update', IG_LIBRARY_TEXTDOMAIN ); ?>
							</a>
							<?php endif; ?>
							<a class="btn <?php if ( ! $details->updatable ) echo 'btn-primary'; ?> <?php if ( ! $details->compatible ) echo 'incompatible'; ?>" href="javascript:void(0);" data-action="uninstall" data-authentication="<?php echo absint( $details->authentication ); ?>" data-identification="<?php echo '' . $details->identified_name; ?>">
								<?php _e( 'Uninstall', IG_LIBRARY_TEXTDOMAIN ); ?>
							</a>
							<?php endif; ?>
						</div>
						<a class="btn pull-right" href="<?php echo esc_url( $details->url ); ?>" target="_blank">
							<?php _e( 'More Info', IG_LIBRARY_TEXTDOMAIN ); ?>
						</a>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div id="<?php echo '' . $plugin['Identified_Name']; ?>-authentication" title="<?php _e( 'InnoGears Customer Account', IG_LIBRARY_TEXTDOMAIN ); ?>" class="jsn-bootstrap ig-product-addons-authentication hidden">
	<form name="IG_Addons_Authentication" method="POST" class="form-horizontal" autocomplete="off">
		<div class="alert alert-block alert-error hidden">
			<a title="<?php _e( 'Close', IG_LIBRARY_TEXTDOMAIN ); ?>" onclick="jQuery(this).parent().hide();" href="javascript:void(0);" class="jsn-close-message close">
				×
			</a>
			<span class="message"></span>
		</div>
		<div class="control-group">
			<label class="control-label" for="username"><?php _e( 'Username', IG_LIBRARY_TEXTDOMAIN ); ?>:</label>
			<div class="controls">
				<input type="text" value="" class="input-xlarge" id="username" name="username" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password"><?php _e( 'Password', IG_LIBRARY_TEXTDOMAIN ); ?>:</label>
			<div class="controls">
				<input type="password" value="" class="input-xlarge" id="password" name="password" />
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label>
					<input type="checkbox" value="1" id="remember" name="remember" />
					<?php _e( 'Remember Me', IG_LIBRARY_TEXTDOMAIN ); ?>
				</label>
			</div>
		</div>
	</form>
</div>
<?php
// Load inline script initialization
$script = '
		new $.IG_ProductAddons({
			base_url: "' . esc_url( admin_url( 'admin-ajax.php?action=ig-addons-management' ) ) . '",
 			core_plugin: "' . $plugin['Identified_Name'] . '",
 			has_saved_account: ' . ( $has_customer_account ? 'true' : 'false' ) . ',
			language: {
				CANCEL: "' . __( 'Cancel', IG_LIBRARY_TEXTDOMAIN ) . '",
				INSTALL: "' . __( 'Install', IG_LIBRARY_TEXTDOMAIN ) . '",
				UNINSTALL: "' . __( 'Uninstall', IG_LIBRARY_TEXTDOMAIN ) . '",
				INSTALLED: "' . __( 'Installed', IG_LIBRARY_TEXTDOMAIN ) . '",
				INCOMPATIBLE: "' . __( 'Incompatible', IG_LIBRARY_TEXTDOMAIN ) . '",
				UNINSTALL_CONFIRM: "' . __( 'Are you sure you want to uninstall %s?', IG_LIBRARY_TEXTDOMAIN ) . '",
				AUTHENTICATING: "' . __( 'Verifying...', IG_LIBRARY_TEXTDOMAIN ) . '",
				INSTALLING: "' . __( 'Installing...', IG_LIBRARY_TEXTDOMAIN ) . '",
				UPDATING: "' . __( 'Updating...', IG_LIBRARY_TEXTDOMAIN ) . '",
				UNINSTALLING: "' . __( 'Uninstalling...', IG_LIBRARY_TEXTDOMAIN ) . '",
			}
		});';

IG_Init_Assets::inline( 'js', $script );
