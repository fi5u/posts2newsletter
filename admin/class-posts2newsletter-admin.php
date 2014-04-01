<?php
/**
 * Posts2Newsletter
 *
 * @package   Posts2newsletterAdmin
 * @author    Tommy Fisher <tommybfisher@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-posts2newsletter.php`
 *
 * @package Posts2newsletterAdmin
 * @author  Tommy Fisher <tommybfisher@gmail.com>
 */
class Posts2newsletterAdmin {

	/**
	 * Instance of this class.
	 *
	 * @since    0.0.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.0.1
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

    /**
     * Slug of the campaigns screen.
     *
     * @since    0.0.1
     *
     * @var      string
     */
    protected $plugin_screen_campaigns = null;

    /**
     * Slug of the templates screen.
     *
     * @since    0.0.1
     *
     * @var      string
     */
    protected $plugin_screen_templates = null;

    /**
     * Slug of the subscribers screen.
     *
     * @since    0.0.1
     *
     * @var      string
     */
    protected $plugin_screen_subscribers = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     0.0.1
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		$plugin = Posts2newsletter::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_filter( '@TODO', array( $this, 'filter_method_name' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.0.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     0.0.1
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Posts2newsletter::VERSION );
        }

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     0.0.1
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ($this->plugin_screen_hook_suffix == $screen->id || $this->plugin_screen_campaigns == $screen->id || $this->plugin_screen_templates == $screen->id || $this->plugin_screen_subscribers == $screen->id) {
            wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array('jquery'), Posts2newsletter::VERSION, true);
        }

        if ($this->plugin_screen_campaigns == $screen->id) {
            wp_register_script($this->plugin_slug . '-campaigns-script', plugins_url( 'assets/js/campaigns.js', __FILE__ ), array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-sortable'), Posts2newsletter::VERSION, true);
            wp_localize_script($this->plugin_slug . '-campaigns-script', $this->plugin_slug . '_campaigns_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'plugin_url' => plugin_dir_url( __DIR__ ) ));
            wp_enqueue_script($this->plugin_slug . '-campaigns-script');
        }
	}


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    0.0.1
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * @TODO:
		 *
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Posts2Newsletter', $this->plugin_slug ),
			__( 'Newsletter', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

        $this->plugin_screen_campaigns = add_submenu_page(
            $this->plugin_slug,
            __( 'Campaigns', $this->plugin_slug ),
            __( 'Campaigns', $this->plugin_slug ),
            'manage_options',
            $this->plugin_slug . '/campaigns',
            array( $this, 'display_plugin_campaigns_page' )
        );

        $this->plugin_screen_templates = add_submenu_page(
            $this->plugin_slug,
            __( 'Templates', $this->plugin_slug ),
            __( 'Templates', $this->plugin_slug ),
            'manage_options',
            $this->plugin_slug . '/templates',
            array( $this, 'display_plugin_templates_page' )
        );

        $this->plugin_screen_subscribers = add_submenu_page(
            $this->plugin_slug,
            __( 'Subscribers', $this->plugin_slug ),
            __( 'Subscribers', $this->plugin_slug ),
            'manage_options',
            $this->plugin_slug . '/subscribers',
            array( $this, 'display_plugin_subscribers_page' )
        );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    0.0.1
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

    public function display_plugin_campaigns_page() {
        include_once( 'views/campaigns.php' );
    }

    public function display_plugin_templates_page() {
        include_once( 'views/templates.php' );
    }

    public function display_plugin_subscribers_page() {
        include_once( 'views/subscribers.php' );
    }

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    0.0.1
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 *           Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    0.0.1
	 */
	public function action_method_name() {
		// @TODO: Define your action hook callback here
	}

	/**
	 * NOTE:     Filters are points of execution in which WordPress modifies data
	 *           before saving it or sending it to the browser.
	 *
	 *           Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    0.0.1
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}

}
