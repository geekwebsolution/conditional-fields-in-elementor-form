<?php
if (!class_exists('CFIEF_Update_Checker')) {

    class CFIEF_Update_Checker {

        public $plugin_slug;
        public $plugin_base;
        public $version;
        public $cache_allowed;
        public $get_api;

        public function __construct() {
            $utility = cfief_updater_utility();

            $this->plugin_base   = $utility['get_base'];
            $this->plugin_slug   = $utility['get_slug'];
            $this->version       = $utility['get_version'];
            $this->get_api       = $utility['get_api'];
            $this->cache_allowed = true;

            add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_updates']);
            add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
        }

        /**
         * Request update information from the API.
         */
        public function request_info() {
            $response = wp_remote_get(
                $this->get_api . "info.php/?slug={$this->plugin_slug}",
                [
                    'timeout' => 10,
                    'headers' => ['Accept' => 'application/json'],
                ]
            );
            set_transient('afafa_transient', $this->get_api . "info.php/?slug={$this->plugin_slug}");
            if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
                return false;
            }

            $response_body = wp_remote_retrieve_body($response);
            $data = json_decode($response_body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return false;
            }

            return $data;
        }

        /**
         * Check for plugin updates.
         */
        public function check_for_updates($transient) {

            if (empty($transient->checked)) {
                return $transient;
            }

            $transient_name = 'cfief_plugin_updates';
            $cached_update = $this->cache_allowed ? get_transient($transient_name) : false;

            if ($cached_update !== false) {
                $transient->response[$this->plugin_base] = $cached_update;
                return $transient;
            }

            $remote = $this->request_info();

            if (!$remote || !isset($remote->new_version) || version_compare($this->version, $remote->new_version, '>=')) {
                return $transient;
            }

            // Ensure the response is a properly formatted stdClass object
            $plugin = new stdClass();
            $plugin->slug = $this->plugin_slug;
            $plugin->new_version = $remote->new_version;
            $plugin->package = $remote->package ?? '';
            $plugin->url = $remote->url ?? '';
            $plugin->tested = $remote->tested ?? '';
            $plugin->requires = $remote->requires ?? '';
            $plugin->icons = (array)$remote->icons ?? [];
            $transient->response[$this->plugin_base] = $plugin;

            if ($this->cache_allowed) {
                set_transient($transient_name, $plugin, DAY_IN_SECONDS);
            }

            return $transient;
        }

        /**
         * Provide plugin information for the 'View details' popup.
         */
        public function plugin_info($false, $action, $args) {
            if ($action !== 'plugin_information' || $args->slug !== $this->plugin_slug) {
                return $false;
            }

            $remote = $this->request_info();
            if (!$remote) {
                return $false;
            }

            $plugin_info = new stdClass();
            $plugin_info->name = $remote->name ?? '';
            $plugin_info->slug = $this->plugin_slug;
            $plugin_info->version = $remote->new_version;
            $plugin_info->author = $remote->author ?? '';

            $plugin_info->last_updated = $remote->last_updated ?? '';
            $plugin_info->requires = $remote->requires ?? '';
            $plugin_info->tested = $remote->tested ?? '';
            $plugin_info->requires_php = $remote->requires_php ?? '';
            $plugin_info->active_installs = $remote->active_installs ?? '';
            $plugin_info->banners = (array)$remote->banners ?? '';

            $plugin_info->homepage = $remote->url ?? '';
            $plugin_info->sections = [
                'description' => $remote->description ?? '',
                'changelog' => $remote->changelog ?? '',
            ];

            $plugin_info->download_link = $remote->package ?? '';

            return $plugin_info;
        }
    }

    new CFIEF_Update_Checker();
}
