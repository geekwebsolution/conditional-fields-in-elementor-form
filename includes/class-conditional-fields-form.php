<?php
use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Classes;
use Elementor\Controls_Manager;
use ElementorPro\Plugin;
/**
 * The core plugin class.
 */
class Conditional_Fields_In_Elementor_Form {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      CFIEF_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CFIEF_VERSION' ) ) {
			$this->version = CFIEF_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'conditional-fields-in-elementor-form';
		$this->load_dependencies();
		$this->define_conditional_logic();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - CFIEF_Loader. Orchestrates the hooks of the plugin.
	 * - CFIEF_Conditional_Logic. Defines all hooks for Elementor Form Conditional Logic.
	 * - CFIEF_Admin. Defines all hooks for the admin area.
	 * - CFIEF_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-conditional-fields-loader.php';

		/**
		 * The class responsible for defining all actions that occur for elementor form conditional logic
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-conditional-fields-logic.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-conditional-fields-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-conditional-fields-public.php';

		$this->loader = new CFIEF_Loader();
	}

	/**
	 * Register all of the hooks related to elementor form conditional logic
	 */
	private function define_conditional_logic() {
		
		$plugin_conditional_logic = new CFIEF_Conditional_Logic( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'elementor-pro/forms/pre_render', $plugin_conditional_logic, 'form_pre_render', 10, 3 );
        $this->loader->add_action( 'elementor/element/form/section_form_fields/before_section_end', $plugin_conditional_logic, 'add_conditional_field_control', PHP_INT_MAX, 2 );
        $this->loader->add_action( 'elementor/controls/register', $plugin_conditional_logic, 'form_fields_register_controls' );
        $this->loader->add_action( 'elementor_pro/forms/validation/text', $plugin_conditional_logic, 'form_fields_validation', 9, 3 );
        $this->loader->add_filter( 'elementor_pro/forms/record/actions_before', $plugin_conditional_logic, 'custom_actions', 10, 2 );

		$this->loader->add_action( 'elementor_pro/forms/fields/register', $plugin_conditional_logic, 'add_new_html1_field' );
		$this->loader->add_filter( 'elementor_pro/forms/field_types', $plugin_conditional_logic, 'remove_html_field_type' );
		$this->loader->add_action( 'elementor_pro/forms/actions/register', $plugin_conditional_logic, 'register_new_form_actions' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new CFIEF_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'elementor/editor/before_enqueue_scripts', $plugin_admin, 'add_lib_backend' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new CFIEF_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    CFIEF_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}