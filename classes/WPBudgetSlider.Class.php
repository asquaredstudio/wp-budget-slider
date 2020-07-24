<?php
/**
 * WPBudgetSlider.Class
 */

class WPBudgetSlider {
	/**
	 * @var string
	 */
	private $pluginName;
	/**
	 * @var string
	 */
	private $pluginSlug;
	/**
	 * @var string
	 */
	private $pluginVersion;
	/**
	 * @var string
	 */
	private $pluginVersionOption;
	/**
	 * @var string
	 */
	private $pluginDirectory;

	/**
	 * @var string
	 */
	private $cptName;

	/**
	 * WPBudgetSlider.Class constructor.
	 */
	function __construct() {
		$this->pluginDirectory     = plugin_dir_path(__DIR__);
		$this->pluginURL           = plugin_dir_url(__DIR__);
		$this->pluginName          = "WP Budget Slider";
		$this->pluginSlug          = "wp_budget_slider";
		$this->pluginVersion       = '0.2';
		$this->cptName             = 'budget_slider';
		$this->pluginVersionOption = $this->pluginSlug . '_version';


		// Load assets properly
		add_action('activate_plugin', [$this, 'pluginActivate'], 10);
		add_action('init', [$this, 'pluginInit']);
		add_action('acf/init', [$this, 'addACFFields']);

		add_action('wp_enqueue_scripts', [$this, 'registerChildScripts']);
		add_action('wp_ajax_process_ajax', [$this, 'processAJAX']);

		// Register shortcodes
		add_shortcode('budget_slider', [$this, 'budgetSlider']);

		// Filter
		add_filter('acf/format_value/name=monthly_spend', [$this, 'formatCurrency'], 10, 3);
		add_filter('acf/format_value/name=potential_revenue', [$this, 'formatCurrency'], 10, 3);
	}


	/**
	 * Performs requirements check before activation
	 *
	 * @return void
	 */
	function pluginRequirementsCheck() {
		// Use this section to do a requirements check
		$error_messages = [];

		if (!class_exists('ACF')) {
			$error_messages[] = '<li>Advanced Custom Fields 5.0 PRO Required.</li>';
		}

		if (count($error_messages) > 0) {
			$output = 'Sorry! ' . $this->pluginName . ' could not be activated due to the following error(s):';
			$output .= '<ul>';
			$output .= implode('', $error_messages);
			$output .= '</ul>';
			die ($output);
		}


	}

	/**
	 * Plugin Init
	 *
	 * @return void
	 */
	function pluginInit() {
		$plugin_db_version = get_option($this->pluginVersionOption);

		if ($this->pluginVersion != $plugin_db_version) {
			$this->pluginUpdate();
		}


		/**
		 * Post Type: Budget Sliders.
		 */

		$labels = [
			"name"          => __("Budget Sliders", "twentytwenty"),
			"singular_name" => __("Budget Slider", "twentytwenty"),
		];

		$args = [
			"label"                 => __("Budget Sliders", "twentytwenty"),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			"rest_base"             => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive"           => false,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"delete_with_user"      => false,
			"exclude_from_search"   => true,
			"capability_type"       => "post",
			"map_meta_cap"          => true,
			"hierarchical"          => false,
			"rewrite"               => ["slug" => "budget_slider", "with_front" => true],
			"query_var"             => true,
			"supports"              => ["title"],
		];

		register_post_type($this->cptName, $args);


	}

	/**
	 * Plugin update tasks
	 *
	 * @return void
	 */
	protected function pluginUpdate() {
		update_option($this->pluginVersionOption, $this->pluginVersion);
	}


	/**
	 * Adds the necessary ACF Fields
	 */
	function addACFFields() {
		acf_add_local_field_group(array(
			'key' => 'group_5f19c83519ce5',
			'title' => 'Budget Slider',
			'fields' => array(
				array(
					'key' => 'field_5f19c83e3be4f',
					'label' => 'Conversion Table',
					'name' => 'conversion_table',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => 'Add Budget Row',
					'sub_fields' => array(
						array(
							'key' => 'field_5f19c8b13be50',
							'label' => 'Monthly Spend',
							'name' => 'monthly_spend',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array(
							'key' => 'field_5f19c8ef3be51',
							'label' => 'Number of Leads',
							'name' => 'number_of_leads',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array(
							'key' => 'field_5f19c9123be52',
							'label' => 'Number of Jobs',
							'name' => 'number_of_jobs',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array(
							'key' => 'field_5f19c92c3be53',
							'label' => 'Potential Revenue',
							'name' => 'potential_revenue',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'budget_slider',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));
	}


	/**
	 * Register and Enqueue Scripts
	 *
	 * @return void
	 */
	function registerChildScripts() {
		// JS & AJAX
		wp_enqueue_script($this->pluginSlug, $this->pluginURL . 'js/app.js', array('jquery'), $this->pluginVersion, true);
		wp_localize_script($this->pluginSlug, $this->pluginSlug, array('ajaxURL' => admin_url('admin-ajax.php')));

		// CSS
		wp_enqueue_style($this->pluginSlug, $this->pluginURL . 'css/main.css');
	}


	/**
	 * Budget Slider shortcode handler
	 *
	 * @param $attributes
	 *
	 * @return false|string
	 */
	function budgetSlider($attributes) {
		$a = shortcode_atts(array(
			'name' => 'default-table'
		), $attributes);

		$args = [
			'post_type'      => $this->cptName,
			'posts_per_page' => 1,
			'name'           => $a['name']
		];

		$sliders = get_posts($args);

		if (!empty($sliders)) :
			ob_start();

			$slider = $sliders[0];
			$table = get_field('conversion_table', $slider->ID);

			$dataAttributes = [];
			foreach ($table as $key => $value) {
				foreach ($value as $rowKey => $rowValue) {
					$dataAttributes['data-' . $key . '-' . $rowKey] = $rowValue;
				}
			}

			$sectionData = '';
			foreach ($dataAttributes as $k => $v) {
				$sectionData.= $k . '="' . $v .'"';
			}
			?>
			<div class="budget-slider" id="budget-slider-<?php echo $slider->ID; ?>" data-number-sections="<?php echo count($table); ?>" <?php echo $sectionData; ?>>
				<div class="budgets">
					<ul>
						<?php foreach ($table as $row): ?>
							<li><?php echo $row['monthly_spend']; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="slidecontainer">
					<input type="range" min="0" max="<?php echo count($table) - 1; ?>" value="0" class="slider">
				</div>

				<div class="budget-slider-table">

					<div class="leads metric">
						<span class="message">Calls Generated</span>
						<span class="number"></span>
					</div>
					<div class="jobs metric">
						<span class="message">Jobs Obtained</span>
						<span class="number"></span>
					</div>
					<div class="revenue metric">
						<span class="message">Potential Revenue</span>
						<span class="number"></span>
					</div>
				</div>
			</div>
			<?php


			return ob_get_clean();
		endif;
	}

	/**
	 * Returns the number in currency format
	 *
	 * @param $value
	 * @param $post_id
	 * @param $field
	 *
	 * @return string
	 */
	function formatCurrency( $value, $post_id, $field ) {
		// Render shortcodes in all textarea values.
		return '$' . number_format($value, 0);
	}
}
