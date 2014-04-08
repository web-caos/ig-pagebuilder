<?php
/**
 * Main class for add on
 *
 * Define properties & methods
 *
 * @author		InnoGears Team <support@www.innogears.com>
 * @package		IGPGBLDR
 * @version		$Id$
 */
class IG_Pb_Addon {

	// prodiver name
	protected $provider;
	// register assets (js/css)
	protected $assets_register;
	// enqueue assets for Admin pages
	protected $assets_enqueue_admin;
	// enqueue assets for Modal setting iframe
	protected $assets_enqueue_modal;
	// enqueue assets for Frontend
	protected $assets_enqueue_frontend;

	// GET functions
	public function get_provider(){
		return $this->provider;
	}
	public function get_assets_register(){
		return $this->assets_register;
	}
	public function get_assets_enqueue_admin(){
		return $this->assets_enqueue_admin;
	}
	public function get_assets_enqueue_modal(){
		return $this->assets_enqueue_modal;
	}
	public function get_assets_enqueue_frontend(){
		return $this->assets_enqueue_frontend;
	}

	// SET FUNCTIONS
	/**
     *
     * @param type $provider
     */
	public function set_provider( $provider ){
		$this->provider = $provider;
	}
	/**
	 *
	 * @param array $assets
	 */
	public function set_assets_register( $assets ){
		$this->assets_register = $assets;
	}
	/**
	 *
	 * @param array $assets
	 */
	public function set_assets_enqueue_admin( $assets ){
		$this->assets_enqueue_admin = $assets;
	}
	/**
	 *
	 * @param array $assets
	 */
	public function set_assets_enqueue_modal( $assets ){
		$this->assets_enqueue_modal = $assets;
	}
	/**
	 *
	 * @param array $assets
	 */
	public function set_assets_enqueue_frontend( $assets ){
		$this->assets_enqueue_frontend = $assets;
	}

	// constructor
	public function __construct() {
		add_filter( 'ig_pb_provider', array( &$this, 'this_provider' ) );
		add_filter( 'ig_register_assets', array( &$this, 'this_assets_register' ) );
		add_filter( 'ig_pb_assets_enqueue_admin', array( &$this, 'this_assets_enqueue_admin' ) );
		add_filter( 'ig_pb_assets_enqueue_modal', array( &$this, 'this_assets_enqueue_modal' ) );
		add_filter( 'ig_pb_assets_enqueue_frontend', array( &$this, 'this_assets_enqueue_frontend' ) );
	}

	// filter providers
	public function this_provider( $providers ){
		$provider = $this->get_provider();
		if ( empty ( $provider ) || empty ( $provider['file'] ) ){
			return $providers;
		}
		$file = $provider['file'];
		$path = plugin_dir_path( $file );
		$uri  = plugin_dir_url( $file );
		$shortcode_dir    = empty ( $provider['shortcode_dir'] ) ? 'shortcodes' : $provider['shortcode_dir'];
		$js_shortcode_dir = empty ( $provider['js_shortcode_dir'] ) ? 'assets/js/shortcodes' : $provider['js_shortcode_dir'];

		// Check if path is absolute
		if ( ! is_dir( $shortcode_dir ) ) {
			$shortcode_dir = $path . $shortcode_dir;
		}

		//get plugin name & main file
		$main_file = pathinfo( $file );
		$folder    = basename( $main_file['dirname'] );
		$main_file = $folder . '/' . $main_file['basename'];
		$providers[$path] = array(
			'path' => $path,
			'uri' => $uri,
			'file' => $main_file,
			'file_path' => $file,
			'folder' => $folder,
			'name' => $provider['name'],
			'shortcode_dir' => $shortcode_dir,
			'js_shortcode_dir' => array( 'path' => $path . $js_shortcode_dir, 'uri' => $uri . $js_shortcode_dir ),
		);
		return $providers;
	}
	// register assets
	public function this_assets_register( $assets ){
		$this_asset = $this->get_assets_register();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );
		return $assets;
	}
	// assets enqueue for admin
	public function this_assets_enqueue_admin( $assets ){
		$this_asset = $this->get_assets_enqueue_admin();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );
		return $assets;
	}
	// assets enqueue for modal
	public function this_assets_enqueue_modal( $assets ){
		$this_asset = $this->get_assets_enqueue_modal();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );
		return $assets;
	}
	// assets enqueue for frontend
	public function this_assets_enqueue_frontend( $assets ){
		$this_asset = $this->get_assets_enqueue_frontend();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );
		return $assets;
	}

	/**
	 * Register Path to extended Parameter type
	 * @param string $path
	 */
	public function register_extended_parameter_path( $path ) {
		IG_Loader::register( $path, 'IG_Pb_Helper_Html_' );
	}

	/**
	 * Show admin notice
	 *
	 * @param type $addon_name
	 * @param type $core_required
	 *
	 * @return type
	 */
	static function show_notice( $data, $action, $type = 'error' ) {

		// show message
		ob_start();

		switch ( $action ) {

			// show message about core version required
			case 'core_required':
				extract( $data );

				?>
				<div class="<?php echo esc_attr( $type ); ?>">
					<p>
						<?php _e( "You can not activate this IG PageBuilder's Addon:", IGPBL ); ?> <br>
						<b><?php echo esc_html( $addon_name ); ?></b>
					</p>

					<p>
						<?php _e( "It requires IG PageBuilder's version:", IGPBL ); ?> <br>
						<b><?php echo esc_html( $core_required ); ?></b> <br>
						<?php echo esc_html( 'or above to work. Please update IG PageBuilder to newest version.' ); ?>
						<br>
					</p>
				</div>

                <!-- custom js to hide "Plugin actived" -->

				<?php
				$js_code = "$('#message.updated').hide();";
				echo balanceTags( IG_Pb_Helper_Functions::script_box( $js_code ) );

				break;

			default:
				break;
		}

		$message = ob_get_clean();

		return $message;
	}

	/**
	 * Get Constant name defines core version required of this addon plugin
	 *
	 * @param type $addon_file
	 */
	static function core_version_constant( $addon_file ) {
		$path_parts = pathinfo( $addon_file );
		if ( $path_parts ) {
			// get dir name of add on
			$dirname = basename( $path_parts['dirname'] );
			$dirname = str_replace( '-', '_', $dirname );

			// return the Constant defines core version required of this add on
			return strtoupper( $dirname ) . '_CORE_VERSION';
		}

		return '';
	}

	/**
	 * Get Constant value of Constant defines core version required
	 *
	 * @param type $provider
	 * @param type $addon_file
	 *
	 * @return type
	 */
	static function core_version_requied_value( $provider, $addon_file ) {

		// include defines.php from Addon plugin folder, where defines core version required by addon
		if ( file_exists( $provider['path'] . 'defines.php' ) ) {
			include_once $provider['path'] . 'defines.php';
		}

		// get constant name defines core version required
		$constant = IG_Pb_Addon::core_version_constant( $addon_file );

		// get value of core version required
		return ( defined( $constant ) ) ? constant( $constant ) : NULL;
	}

	/**
	 *
	 * @param type $core_required : required version of core
	 * @param type $core_version  : current version of core
	 * @param type $addon_file    : addon main file
	 */
	static function compatibility_handle( $core_required, $core_version, $addon_file ) {

		// if current core version < core version required
		if ( version_compare( $core_required, $core_version, '>' ) ) {
			// deactivate addon
			deactivate_plugins( array( $addon_file ) );

			return FALSE;
		}

		return TRUE;
	}

}