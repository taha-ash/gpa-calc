<?php
/*
Plugin Name: CGPA Calculator
Plugin URI: https://yourwebsite.com/cgpa-calculator
Description: A simple CGPA calculator for WordPress
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
License: GPL2
*/

// Register the CGPA Calculator shortcode
function cgpa_calculator_shortcode() {
    wp_enqueue_style( 'cgpa-calculator', plugin_dir_url( __FILE__ ) . 'css/cgpa-calculator.css' );
    wp_enqueue_script( 'cgpa-calculator', plugin_dir_url( __FILE__ ) . 'js/cgpa-calculator.js', array( 'jquery' ), false, true );
    ob_start();
    ?>
    <div id="cgpa-calculator-container">
        <form id="cgpa-calculator-form">
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Credit Hours</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="cgpa-calculator-row">
                        <td><input type="text" name="course_name[]" /></td>
                        <td><input type="number" name="credit_hours[]" min="1" /></td>
                        <td>
                            <select name="grade[]">
                                <option value="4.0">A</option>
                                <option value="3.7">A-</option>
                                <option value="3.3">B+</option>
                                <option value="3.0">B</option>
                                <option value="2.7">B-</option>
                                <option value="2.3">C+</option>
                                <option value="2.0">C</option>
                                <option value="1.7">C-</option>
                                <option value="1.3">D+</option>
                                <option value="1.0">D</option>
                                <option value="0.0">F</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="cgpa-calculator-button">Calculate</button>
        </form>
        <div id="cgpa-calculator-results"></div>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'cgpa_calculator', 'cgpa_calculator_shortcode' );

// Enqueue admin scripts and styles
function cgpa_calculator_admin_scripts() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'cgpa-calculator-admin', plugin_dir_url( __FILE__ ) . 'css/cgpa-calculator-admin.css' );
    wp_enqueue_script( 'cgpa-calculator-admin', plugin_dir_url( __FILE__ ) . 'js/cgpa-calculator-admin.js', array( 'jquery', 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'cgpa_calculator_admin_scripts' );

// Add the settings page
function cgpa_calculator_settings_page() {
    ?>
    <div class="wrap">
    <h1>CGPA Calculator Settings</h1>
    <form method="post" action="options.php">
    <?php settings_fields( 'cgpa_calculator_settings_group' ); ?>
    <?php do_settings_sections( 'cgpa_calculator_settings_group' ); ?>
    <table class="form-table">
    <tr>
    <th scope="row">Button Color</th>
    <td><input type="text" name="cgpa_calculator_button_color" value="<?php echo get_option( 'cgpa_calculator_button_color', '#0073aa' ); ?>" class="color-field" /></td>
    </tr>
    <tr>
    <th scope="row">Button Width</th>
    <td><input type="text" name="cgpa_calculator_button_width" value="<?php echo get_option( 'cgpa_calculator_button_width', 'auto' ); ?>" /></td>
    </tr>
    <tr>
    <th scope="row">Button Display</th>
    <td>
    <select name="cgpa_calculator_button_display">
    <option value="inline-block"<?php selected( get_option( 'cgpa_calculator_button_display', 'inline-block' ), 'inline-block' ); ?>>Inline-block</option>
    <option value="block"<?php selected( get_option( 'cgpa_calculator_button_display', 'inline-block' ), 'block' ); ?>>Block</option>
    <option value="inline"<?php selected( get_option( 'cgpa_calculator_button_display', 'inline-block' ), 'inline' ); ?>>Inline</option>
    </select>
    </td>
    </tr>
    <tr>
    <th scope="row">Row Color</th>
    <td><input type="text" name="cgpa_calculator_row_color" value="<?php echo get_option( 'cgpa_calculator_row_color', '#f2f2f2' ); ?>" class="color-field" /></td>
    </tr>
    <tr>
    <th scope="row">Column Width</th>
    <td><input type="number" name="cgpa_calculator_column_width" value="<?php echo get_option( 'cgpa_calculator_column_width', '30' ); ?>" min="1" max="100" />%</td>
    </tr>
    <tr>
    <th scope="row">Grade Column Width</th>
    <td><input type="number" name="cgpa_calculator_grade_column_width" value="<?php echo get_option( 'cgpa_calculator_grade_column_width', '40' ); ?>" min="1" max="100" />%</td>
    </tr>
    <tr>
    <th scope="row">Font Size</th>
    <td><input type="number" name="cgpa_calculator_font_size" value="<?php echo get_option( 'cgpa_calculator_font_size', '16' ); ?>" min="1" /></td>
    </tr>
    <tr>
    <th scope="row">Font Family</th>
    <td><input type="text" name="cgpa_calculator_font_family" value="<?php echo get_option( 'cgpa_calculator_font_family', 'Arial' ); ?>" /></td>
    </tr>
    <tr>
    <th scope="row">Font Weight</th>
    <td>
    <select name="cgpa_calculator_font_weight">
    <option value="normal"<?php selected( get_option( 'cgpa_calculator_font_weight', 'normal', 'normal' ), 'normal' ); ?>>Normal</option>
<option value="bold"<?php selected( get_option( 'cgpa_calculator_font_weight', 'normal' ), 'bold' ); ?>>Bold</option>
</select>
</td>
</tr>
<tr>
<th scope="row">Final Text</th>
<td><input type="text" name="cgpa_calculator_final_text" value="<?php echo get_option( 'cgpa_calculator_final_text', 'Congratulations!' ); ?>" /></td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<?php
}

// Register the settings page
function cgpa_calculator_register_settings() {
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_button_color' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_button_width' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_button_display' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_row_color' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_column_width' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_grade_column_width' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_font_size' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_font_family' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_font_weight' );
    register_setting( 'cgpa_calculator_settings_group', 'cgpa_calculator_final_text' );
    add_options_page( 'CGPA Calculator Settings', 'CGPA Calculator', 'manage_options', 'cgpa-calculator', 'cgpa_calculator_settings_page' );
    }
    add_action( 'admin_init', 'cgpa_calculator_register_settings' );
    add_action( 'admin_menu', 'cgpa_calculator_register_settings' );
    
    // AJAX callback function for form submission
    function cgpa_calculator_submit() {
    if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'cgpa_calculator_nonce' ) ) {
    $courses = $_POST['courses'];
    $total_grade_points = 0;
    $total_credit_hours = 0;
    foreach ( $courses as $course ) {
    $course_name = sanitize_text_field( $course['name'] );
    $credit_hours = intval( $course['credit_hours'] );
    $grade = floatval( $course['grade'] );
    $total_grade_points += $credit_hours * $grade;
    $total_credit_hours += $credit_hours;
    }
    if ( $total_credit_hours == 0 ) {
    $cgpa_text = '<p><span class="cgpa-calculator-error">Error: Invalid input!</span></p>';
    } else {
    $cgpa = round( $total_grade_points / $total_credit_hours, 2 );
    $cgpa_text = '<p><span class="cgpa-calculator-cgpa">' . $cgpa . '</span></p>';
    $cgpa_text .= '<p><span class="cgpa-calculator-final-text" style="font-size: ' . get_option( 'cgpa_calculator_font_size', '16' ) . 'px; font-family: ' . get_option( 'cgpa_calculator_font_family', 'Arial' ) . '; font-weight: ' . get_option( 'cgpa_calculator_font_weight', 'normal' ) . '">' . get_option( 'cgpa_calculator_final_text', 'Congratulations!' ) . '</span></p>';
}
echo $cgpa_text;
wp_die();
}
}
add_action( 'wp_ajax_cgpa_calculator_submit', 'cgpa_calculator_submit' );
add_action( 'wp_ajax_nopriv_cgpa_calculator_submit', 'cgpa_calculator_submit' );

// Shortcode button in Elementor
function cgpa_calculator_elementor_button() {
if ( ! did_action( 'elementor/loaded' ) ) {
return;
}
Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CGPA_Calculator_Elementor_Widget() );
}
add_action( 'elementor/widgets/widgets_registered', 'cgpa_calculator_elementor_button' );

// Elementor widget
class CGPA_Calculator_Elementor_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'cgpa-calculator';
    }
    
    public function get_title() {
        return __( 'CGPA Calculator', 'elementor' );
    }
    
    public function get_icon() {
        return 'fa fa-calculator';
    }
    
    public function get_categories() {
        return [ 'general' ];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Calculate CGPA', 'elementor' ),
                'placeholder' => __( 'Enter button text here', 'elementor' ),
            ]
        );
    
        $this->add_control(
            'courses',
            [
                'label' => __( 'Courses', 'elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => __( 'Course Name', 'elementor' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __( 'Course Name', 'elementor' ),
                        'placeholder' => __( 'Enter course name here', 'elementor' ),
                    ],
                    [
                        'name' => 'credit_hours',
                        'label' => __( 'Credit Hours', 'elementor' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => __( '3', 'elementor' ),
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                    [
                        'name' => 'grade',
                        'label' => __( 'Grade', 'elementor' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            '4.0' => 'A',
                            '3.7' => 'A-',
                            '3.3' => 'B+',
                            '3.0' => 'B',
                            '2.7' => 'B-',
                            '2.3' => 'C+',
                            '2.0' => 'C',
                            '1.7' => 'C-',
                            '1.3' => 'D+',
                            '1.0' => 'D',
                            '0.0' => 'F',
                        ],
                        'default' => '4.0',
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Color', 'elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .cgpa-calculator-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
                    $this->add_control(
                        'button_width',
                        [
                            'label' => __( 'Button Width', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => 'auto',
                            'selectors' => [
                                '{{WRAPPER}} .cgpa-calculator-button' => 'width: {{VALUE}};',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'button_display',
                        [
                            'label' => __( 'Button Display', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'inline-block',
                            'options' => [
                                'inline-block' => __( 'Inline-block', 'elementor' ),
                                'block' => __( 'Block', 'elementor' ),
                                'inline' => __( 'Inline', 'elementor' ),
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .cgpa-calculator-button' => 'display: {{VALUE}};',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'row_color',
                        [
                            'label' => __( 'Row Color', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'default' => '#f2f2f2',
                            'selectors' => [
                                '{{WRAPPER}} .cgpa-calculator-row' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'column_width',
                        [
                            'label' => __( 'Column Width', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => '30',
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                            'selectors' => [
                                '{{WRAPPER}} .cgpa-calculator-column' => 'width: {{VALUE}}%;',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'grade_column_width',
                        [
                            'label' => __( 'Grade Column Width', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => '40',
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                            'selectors' => [
                                '{{WRAPPER}} .cgpa-calculator-grade-column' => 'width: {{VALUE}}%;',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'font_size',
                        [
                            'label' => __( 'Font Size', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => '16',
                            'selectors' => [
                                '{{WRAPPER}} .cgpa-calculator-final-text' =>
                                'font-size: {{VALUE}}px;',
                            ],
                            ]
                            );    $this->add_control(
                                'font_family',
                                [
                                    'label' => __( 'Font Family', 'elementor' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'default' => 'Arial',
                                    'selectors' => [
                                        '{{WRAPPER}} .cgpa-calculator-final-text' => 'font-family: {{VALUE}};',
                                    ],
                                ]
                            );
                        
                            $this->add_control(
                                'font_weight',
                                [
                                    'label' => __( 'Font Weight', 'elementor' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => 'normal',
                                    'options' => [
                                        'normal' => __( 'Normal', 'elementor' ),
                                        'bold' => __( 'Bold', 'elementor' ),
                                    ],
                                    'selectors' => [
                                        '{{WRAPPER}} .cgpa-calculator-final-text' => 'font-weight: {{VALUE}};',
                                    ],
                                ]
                            );
                        
                            $this->end_controls_section();
                        }
                        
                        protected function render() {
                            $settings = $this->get_settings_for_display();
                            ?>
                            <div class="cgpa-calculator-container">
                                <table class="cgpa-calculator-table">
                                    <thead>
                                        <tr>
                                            <th class="cgpa-calculator-column" scope="col">#</th>
                                            <th class="cgpa-calculator-column" scope="col"><?php _e( 'Course Name', 'elementor' ); ?></th>
                                            <th class="cgpa-calculator-column cgpa-calculator-credit-hours-column" scope="col"><?php _e( 'Credit Hours', 'elementor' ); ?></th>
                                            <th class="cgpa-calculator-column cgpa-calculator-grade-column" scope="col"><?php _e( 'Grade', 'elementor' ); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ( $i = 1; $i <= 3; $i++ ) { ?>
                                            <tr class="cgpa-calculator-row">
                                                <td class="cgpa-calculator-column"><?php echo $i; ?></td>
                                                <td class="cgpa-calculator-column">
                                                    <input type="text" class="cgpa-calculator-course-name" name="courses[<?php echo $i - 1; ?>][name]" placeholder="<?php _e( 'Course Name', 'elementor' ); ?>" value="" />
                                                </td>
                                                <td class="cgpa-calculator-column cgpa-calculator-credit-hours-column">
                                                    <input type="number" class="cgpa-calculator-credit-hours" name="courses[<?php echo $i - 1; ?>][credit_hours]" placeholder="<?php _e( 'Credit Hours', 'elementor' ); ?>" value="" min="1" max="10" step="1" />
                                                </td>
                                                <td class="cgpa-calculator-column cgpa-calculator-grade-column">
                                                    <select class="cgpa-calculator-grade" name="courses[<?php echo $i - 1; ?>][grade]">
                                                        <option value="4.0"><?php _e( 'A', 'elementor' ); ?> (4.0)</option>
                                                        <option value="3.7"><?php _e( 'A-', 'elementor' ); ?> (3.7)</option>
                                                        <option value="3.3"><?php _e( 'B+', 'elementor' ); ?> (3.3)</option>
                                                        <option value="3.0"><?php _e( 'B', 'elementor' ); ?> (3.0)</option>
<option value="2.7"><?php _e( 'B-', 'elementor' ); ?> (2.7)</option>
<option value="2.3"><?php _e( 'C+', 'elementor' ); ?> (2.3)</option>
<option value="2.0"><?php _e( 'C', 'elementor' ); ?> (2.0)</option>
<option value="1.7"><?php _e( 'C-', 'elementor' ); ?> (1.7)</option>
<option value="1.3"><?php _e( 'D+', 'elementor' ); ?> (1.3)</option>
<option value="1.0"><?php _e( 'D', 'elementor' ); ?> (1.0)</option>
<option value="0.0"><?php _e( 'F', 'elementor' ); ?> (0.0)</option>
</select>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<div class="cgpa-calculator-button-container">
            <button class="cgpa-calculator-button"><?php echo $settings['button_text']; ?></button>
        </div>

        <div class="cgpa-calculator-final-text-container">
            <p><span class="cgpa-calculator-final-text"><?php echo get_option( 'cgpa_calculator_final_text', 'Congratulations!' ); ?></span></p>
        </div>
    </div>

    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            var button_text = '<?php echo $settings['button_text']; ?>';
            var cgpa_calculator_ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';

            $( document ).on( 'click', '.cgpa-calculator-button', function() {
                var courses = $( '.cgpa-calculator-course-name' ).map( function() {
                    return $( this ).val();
                } ).get();

                var credit_hours = $( '.cgpa-calculator-credit-hours' ).map( function() {
                    return $( this ).val();
                } ).get();

                var grades = $( '.cgpa-calculator-grade' ).map( function() {
                    return $( this ).val();
                } ).get();

                var data = {
                    action: 'cgpa_calculator_submit',
                    courses: courses,
                    credit_hours: credit_hours,
                    grades: grades,
                };

                $.post( cgpa_calculator_ajax_url, data, function( response ) {
                    $( '.cgpa-calculator-final-text' ).html( response );
                } );
            } );
        } );
    </script>
    <?php
}
}
function cgpa_calculator_submit() {
    $courses = $_POST['courses'];
    $credit_hours = $_POST['credit_hours'];
    $grades = $_POST['grades'];
    $total_credit_hours = array_sum( $credit_hours );
$total_grade_points = 0;

foreach ( $grades as $grade ) {
    $total_grade_points += $grade * $credit_hours[ array_search( $grade, $grades ) ];
}

$cgpa = round( $total_grade_points / $total_credit_hours, 2 );

$final_text = sprintf( __( 'Your CGPA is %s', 'elementor' ), $cgpa );

update_option( 'cgpa_calculator_final_text', $final_text );

echo $final_text;

wp_die();
}