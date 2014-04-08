<?php
/**
 * @version    $Id$
 * @package    IG_Library
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 InnoGears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 * Technical Support: Feedback - http://www.innogears.com/contact-us/get-support.html
 */

/**
 * IG PageBuilder Settings
 *
 * @package  IG_Library
 * @since    1.0.0
 */
class IG_Pb_Product_Plugin {
	/**
	 * Define pages.
	 *
	 * @var  array
	 */
	public static $pages = array( 'ig-pb-settings', 'ig-pb-addons' );

	/**
	 * Initialize IG PageBuilder plugin.
	 *
	 * @return  void
	 */
	public static function init() {
		global $pagenow;

		// Get product information
		$plugin = IG_Product_Info::get( IG_PB_FILE );

		// Generate menu title
		$menu_title = __( 'IG PageBuilder', IGPBL );

		if ( $plugin['Available_Update'] && ( 'admin.php' != $pagenow || ! isset( $_GET['page'] ) || ! in_array( $_GET['page'], self::$pages ) ) ) {
			$menu_title .= " <span class='ig-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>";
		}

		// Define admin menus
		$admin_menus = array(
			'page_title' => __( 'IG PageBuilder', IGPBL ),
			'menu_title' => $menu_title,
			'capability' => 'manage_options',
			'menu_slug'  => 'ig-pb-settings',
			'icon_url'   => IG_Pb_Helper_Functions::path( 'assets/innogears' ) . '/images/ig-pgbldr-icon-white.png',
			'function'   => array( __CLASS__, 'settings' ),
			'children'   => array(
				array(
					'page_title' => __( 'IG PageBuilder - Settings', IGPBL ),
					'menu_title' => __( 'Settings', IGPBL ),
					'capability' => 'manage_options',
					'menu_slug'  => 'ig-pb-settings',
					'function'   => array( __CLASS__, 'settings' ),
				),
			),
		);

		if ( $plugin['Addons'] ) {
			// Generate menu title
			$menu_title = __( 'Add-ons', IGPBL );

			if ( $plugin['Available_Update'] && ( 'admin.php' == $pagenow && isset( $_GET['page'] ) && in_array( $_GET['page'], self::$pages ) ) ) {
				$menu_title .= " <span class='ig-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>";
			}

			// Update admin menus
			$admin_menus['children'][] = array(
				'page_title' => __( 'IG PageBuilder - Add-ons', IGPBL ),
				'menu_title' => $menu_title,
				'capability' => 'manage_options',
				'menu_slug'  => 'ig-pb-addons',
				'function'   => array( __CLASS__, 'addons' ),
			);
		}

		// Initialize necessary IG Library classes
		IG_Init_Admin_Menu::hook();
		IG_Product_Addons ::hook();

		// Register admin menus
		IG_Init_Admin_Menu::add( $admin_menus );

		// Load required assets
		if ( 'admin.php' == $pagenow && isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'ig-pb-settings', 'ig-pb-addons' ) ) ) {
			// Load common assets
			IG_Init_Assets::load( array( 'ig-bootstrap-css', 'ig-jsn-css' ) );

			switch ( $_GET['page'] ) {
				case 'ig-pb-addons':
					// Load addons style and script
					IG_Init_Assets::load( array( 'ig-addons-css', 'ig-addons-js' ) );
				break;
			}
		}
	}

	public static function load_assets() {
		IG_Pb_Helper_Functions::enqueue_styles();
		IG_Pb_Helper_Functions::enqueue_scripts_end();
	}

	/**
	 * Render addons installation and management screen.
	 *
	 * @return  void
	 */
	public static function addons() {
		// Instantiate product addons class
		IG_Product_Addons::init( IG_PB_FILE );
	}

	/**
	 * Product settings page
	 *
	 * @return  void
	 */
	public static function settings() {
		// Load update script
		IG_Init_Assets::load( array( 'ig-pb-settings-js', 'ig-pb-jquery-tipsy-css', 'ig-pb-jquery-tipsy-js' ) );

		include IG_PB_TPL_PATH . '/settings.php';
	}

	/**
	 * Show settings form
	 */
	public static function settings_form() {
		// Add the section to reading settings so we can add our
		// fields to it
		$page    = 'ig-pb-settings';
		$section = 'ig-pb-settings-form';

		add_settings_section(
			$section,
			'',
			array( __CLASS__, 'ig_pb_section_callback' ),
			$page
		);

		// Add the field with the names and function to use for our new
		// settings, put it in our new section

		$fields = array(
			array(
				'id'    => 'cache',
				'title' => __( 'Enable Caching', IGPBL ),
			),
			array(
				'id'     => 'bootstrap',
				'title'  => __( 'Load Bootstrap Assets', IGPBL ),
				///// for multiple fields in a setting box
				'params' => array( 'ig_pb_settings_boostrap_js', 'ig_pb_settings_boostrap_css' ),
			),
			array(
				'id'    => 'ig_customer_account',
				'title' => 'InnoGears Customer Account',
			),
		);

		foreach ( $fields as $field ) {
			// Preset field id
			$field_id = $field['id'];

			// Do not add prefix for InnoGears Customer Account settings
			if ( 'ig_customer_account' != $field['id'] ) {
				$field_id = str_replace( '-', '_', $page ) . '_' . $field['id'];
			}

			// Register settings field
			add_settings_field(
				$field_id,
				$field['title'],
				array( __CLASS__, 'ig_pb_setting_callback_' . $field['id'] ),
				$page,
				$section,
				isset ( $field['args'] ) ? $field['args'] : array()
			);

			// Register our setting so that $_POST handling is done for us and callback function just has to echo the <input>
			register_setting( $page, $field_id );

			foreach ( (array) $field['params'] as $field_id ) {
				register_setting( $page, $field_id );
			}
		}

	}

	public static function ig_pb_settings_options() {
		$options  = array( 'ig_pb_settings_cache', 'ig_pb_settings_boostrap_js', 'ig_pb_settings_boostrap_css' );
		$settings = array();
		// get saved options value
		foreach ( $options as $key ) {
			$settings[$key] = get_option( $key, 'enable' );
		}

		return $settings;
	}

	/**
	 * check/select saved options
	 *
	 * @param type $value
	 * @param type $compare
	 * @param type $check
	 */
	public static function ig_pb_setting_show_check( $value, $compare, $check ) {
		echo esc_attr( ( $value == $compare ) ? "$check='$check'" : '' );
	}

	public static function ig_pb_section_callback() {

	}

	public static function ig_pb_setting_callback_cache() {
		$settings = self::ig_pb_settings_options();
		extract( $settings );
		?>
        <div>
            <select name="ig_pb_settings_cache">
                <option value="enable" <?php selected( $ig_pb_settings_cache, 'enable' ); ?>><?php _e( 'Yes', IGPBL ); ?></option>
                <option value="disable" <?php selected( $ig_pb_settings_cache, 'disable' ); ?>><?php _e( 'No', IGPBL ); ?></option>
            </select>
            <button class="button button-default" id="ig-pb-clear-cache"><?php _e( 'Clear cache', IGPBL ); ?></button>
            <!-- don't use Div tag here -->
            <span class="hidden layout-loading"><i class="jsn-icon16 jsn-icon-loading"></i></span>
            <span class="hidden layout-message alert"></span>
        </div>
		<p class="description">
			<?php _e( "Select 'Yes' if you want to cache CSS and JS files of IG PageBuilder", IGPBL ); ?>
		</p>
	<?php
	}

	public static function ig_pb_setting_callback_bootstrap() {
		$settings = self::ig_pb_settings_options();
		extract( $settings );
		?>
		<label>
			<input type="checkbox" name="ig_pb_settings_boostrap_js" value="enable" <?php checked( $ig_pb_settings_boostrap_js, 'enable' ); ?>> <?php _e( 'JS', IGPBL ); ?>
		</label>
		<br>
		<label>
			<input type="checkbox" name="ig_pb_settings_boostrap_css" value="enable" <?php checked( $ig_pb_settings_boostrap_css, 'enable' ); ?>> <?php _e( 'CSS', IGPBL ); ?>
		</label>
        <p class="description">
            <?php _e( 'You should choose NOT to load Bootstrap CSS / JS if your theme or some other plugin installed on your website already loaded it.', IGPBL ); ?>
        </p>
	<?php
	}

	/**
	 * Render input fields for saving InnoGears Customer Account.
	 *
	 * @return  void
	 */
	public static function ig_pb_setting_callback_ig_customer_account() {
		// Get saved InnoGears Customer Account
		$username         = '';
		$password         = '';
		$customer_account = get_option( 'ig_customer_account', null );

		if ( ! empty( $customer_account ) ) {
			$username = $customer_account['username'];
			$password = $customer_account['password'];
		}
		?>
		<div>
			<label for="username">
				<?php _e( 'Username', IG_LIBRARY_TEXTDOMAIN ); ?>:
				<input type="text" value="<?php esc_attr_e( $username ); ?>" class="input-xlarge" id="username" name="ig_customer_account[username]" autocomplete="off" />
			</label>
			<label for="password">
				<?php _e( 'Password', IG_LIBRARY_TEXTDOMAIN ); ?>:
				<input type="password" value="<?php esc_attr_e( $password ); ?>" class="input-xlarge" id="password" name="ig_customer_account[password]" autocomplete="off" />
			</label>
            <p class="description">
                <?php _e( "Insert the customer account you registered on <a href='http://www.innogears.com' target='_blank'>www.innogears.com</a>. This account is only required when you want to update commercial plugins purchased from innogears.com.", IGPBL ); ?>
            </p>
		</div>
		<?php
	}
}
