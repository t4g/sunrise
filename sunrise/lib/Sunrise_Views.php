<?php
/**
 * Sunrise
 *
 * @author  Vladimir Anokhin <http://gndev.info/>
 * @license MIT
 */


 /**
 * Sunrise Views
 *
 * no comments, just some markup
 */
    class Sunrise_Views {

        function __construct() {}

        public static function notice( $msg = '', $class = '' ) {
            return '<div class="sunrise-notice ' . $class . '"><p>' . $msg . '</p></div>';
        }

        public static function type_opentab( $field, $config ) {
            return '<div class="sunrise-pane"><h3 class="hide-if-js sunrise-no-js-tab">' . $field['name'] . '</h3><table class="form-table">';
        }

        public static function type_closetab( $field, $config ) {
            $field = wp_parse_args( $field, array( 'actions' => true ) );
            $return = array();
            $return[] = '</table>';
            if ( $field['actions'] ) $return[] = '<div class="sunrise-actions-bar"><input type="submit" value="' . __( 'Save changes', $config['textdomain'] ) . '" class="sunrise-submit button-primary" /><span class="sunrise-spin"><img src="' . admin_url( 'images/wpspin_light.gif' ) . '" alt="" /> ' . __( 'Saving', $config['textdomain'] ) . '&hellip;</span><span class="sunrise-success-tip"><img src="' . admin_url( 'images/yes.png' ) . '" alt="" /> ' . __( 'Saved', $config['textdomain'] ) . '</span><a href="' . $_SERVER["REQUEST_URI"] . '&amp;sunrise_action=reset" class="sunrise-reset button alignright" title="' . esc_attr( __( 'This action will delete all your settings. Are you sure? This action cannot be undone!', $config['textdomain'] ) ) . '">' . __( 'Restore default settings', $config['textdomain'] ) . '</a></div>';
            $return[] = '</div>';
            return implode( '', $return );
        }

        public static function type_text( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'    => __( 'Text field', $config['textdomain'] ),
                'id'      => '',
                'desc'    => ''
            ) );
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="widefat" /><p class="description">' . $field['desc'] . '</p></td></tr>';
        }

        public static function type_textarea( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'    => __( 'Textarea field', $config['textdomain'] ),
                'id'      => '',
                'desc'    => '',
                'rows'    => 10
            ) );
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><textarea name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text widefat" rows="' . $field['rows'] . '">' . esc_textarea( stripslashes( get_option( $config['prefix'] . $field['id'] ) ) ) . '</textarea><p class="description">' . $field['desc'] . '</p></td></tr>';
        }

        public static function type_checkbox( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'  => __( 'Checkbox', $config['textdomain'] ),
                'id'    => '',
                'desc'  => '',
                'label' => __( 'Label', $config['textdomain'] )
            ) );
            $checked = ( get_option( $config['prefix'] . $field['id'] ) === 'on' ) ? ' checked="checked"' : '';
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><label><input type="checkbox" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '"' . $checked . ' />&nbsp;&nbsp;' . $field['label'] . '</label><span class="description">' . $field['desc'] . '</span></td></tr>';
        }

        public static function type_select( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'     => __( 'Select', $config['textdomain'] ),
                'id'       => '',
                'desc'     => '',
                'options'  => array(),
                'multiple' => false,
                'size'     => 1
            ) );
            $options = array();
            $value = get_option( $config['prefix'] . $field['id'] );
            if ( !$value ) $value = array();
            if ( !is_array( $value ) ) $value = array( $value );
            $name = ( $field['multiple'] ) ? 'sunrise[' . $field['id'] . '][]' : 'sunrise[' . $field['id'] . ']';
            $field['multiple'] = ( $field['multiple'] ) ? ' multiple="multiple"' : '';
            $field['size'] = ( $field['size'] > 1 ) ? ' size="' . $field['size'] . '"' : '';
            foreach ( $field['options'] as $option ) {
                $selected = ( in_array( $option['value'], $value ) ) ? ' selected="selected"' : '';
                $options[] = '<option value="' . $option['value'] . '"' . $selected . '>' . $option['label'] . '</option>';
            }
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><select name="' . $name . '" class="widefat" id="sunrise-field-' . $field['id'] . '"' . $field['size'] . $field['multiple'] . '>' . implode( '', $options ) . '</select><span class="description">' . $field['desc'] . '</span></td></tr>';
        }

        public static function type_radio( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'    => __( 'Checkbox group', $config['textdomain'] ),
                'options' => array(),
                'id'      => '',
                'desc'    => ''
            ) );
            $group = array();
            $value = get_option( $config['prefix'] . $field['id'] );
            if ( is_array( $field['options'] ) ) foreach ( $field['options'] as $single ) {
                $checked = ( $single['value'] === $value ) ? ' checked="checked"' : '';
                $group[] = '<label for="sunrise-field-' . $field['id'] . '-' . $single['value'] . '"><input type="radio" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '-' . $single['value'] . '" value="' . $single['value'] . '"' . $checked . ' />&nbsp;&nbsp;' . $single['label'] . '</label><br/>';
            }
            return '<tr><th scope="row">' . $field['name'] . '</th><td>' . implode( '', $group ) . '<span class="description">' . $field['desc'] . '</span></td></tr>';
        }

        public static function type_number( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'  => __( 'Text field', $config['textdomain'] ),
                'id'    => '',
                'desc'  => '',
                'min'   => 0,
                'max'   => 100,
                'step'  => 1
            ) );
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="number" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="widefat" min="' . (string) $field['min'] . '" max="' . (string) $field['max'] . '" step="' . (string) $field['step'] . '" /><p class="description">' . $field['desc'] . '</p></td></tr>';
        }

        public static function type_media( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'  => __( 'Media', $config['textdomain'] ),
                'id'    => '',
                'desc'  => ''
            ) );
            if ( function_exists( 'wp_enqueue_media' ) ) wp_enqueue_media();
            return '<tr class="sunrise-media"><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text sunrise-media-value" /> <a href="javascript:;" class="button sunrise-media-button hide-if-no-js"><img src="' . admin_url( 'images/media-button.png' ) . '" alt="" /> ' . __( 'Open media library', $config['textdomain'] ) . '</a><p class="description">' . $field['desc'] . '</p></td></tr>';
        }

        public static function type_color( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'  => __( 'Color picker', $config['textdomain'] ),
                'id'    => '',
                'desc'  => ''
            ) );
            /////////////////////////////////////////////////////////////////////////////////
            // DON'T PANIC - IT's NOT A MALWARE
            // this is base64-encoded image for color picker =)
            /////////////////////////////////////////////////////////////////////////////////
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><div class="sunrise-color-picker"><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text sunrise-color-picker-value" /><span class="sunrise-color-picker-wheel"></span> <a href="javascript:;" class="button sunrise-color-picker-button hide-if-no-js"><img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArFJREFUeNqkU01PE1EUPUOn004/hpmmhH6AFA2KRojxIzFoooK4calLXbhyTeLeEFe69Qe4wJiwcKMLo8Yag9EEIgsS0VpKsdOZ0hbaaUtp6cx0vAOkgbjkJefNnXn3nHvefW8Yy7JwlMHa06uXDM566SUB1JbQwxcx7tpwjEJ1hKDRQju6bhg9SzrCcRfOFE2cxib8uGZN7gkckLshnQw8kG7eGREGJ45x7pCARhdaSr1ajacz5TfKbbPEvqDMz4cc7EeTbKz/Uezcs8tcwxSwvAwk54GyDy7vUKDnysVA9/mrx9ee/uw1FYfN+2jTuuzJ4hFmwsLUwPiTMY7PCdheBPyUE40AkSjg6gb+6OCqfmHg4fUxyxeaaoELdxy0grjLhm+NsJLuAyeTIq15g4DbDwgCUO8FPCKwLoH1+3zsBXOk9CV7l6jPdx0U3ZhgpUvBdSYFzSfCDBO5j6rHBggxctGHdjCCmiggX6aenJCCWWCi42BVx3DT7XcVoUCABNHhhSiK8HgiYLwBNBke2hag8UClDTQ5t2sV+nBHIGXAqaKKEizQblHZR4BzwcHzKDFExh7s79skloLh7AhQf9I/6iv9Tr/HWUCTPOyg104Es9vlMqGwA5QaQLUFqGrdSEBPd05BLiL+Vllo5Cj+CwN50lXhoBhYo+qqA8hTKZnsJ6l6PKU0MqjHOw6sFGYWpV/3gpFRPiREnQyRm1TdQ7BHkx4VEimS6VS9qifVtNLG5kzHAW1ebmmt6U9zHworWs3IkW6GyGu2A0KGkKXMlS3NWJifKxh6fZrOVj58E03MNjIb+Fp4/Th8ajvaN+TlRSnKQjdQKZaN7PdkQ32XUIy8TmRx9v+rbA/dnDWWc9/kxPv7spQdp0swiFrAtpHG7604sq0ZtGPyQQpz1N/5nwADAEUXDAYgnuAXAAAAAElFTkSuQmCC" /> ' . __( 'Pick a color', $config['textdomain'] ) . '</a></div><span class="description">' . $field['desc'] . '</span></td></tr>';
        }

        public static function type_checkbox_group( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'    => __( 'Checkbox group', $config['textdomain'] ),
                'options' => array(),
                'id'      => '',
                'desc'    => ''
            ) );
            $group = array();
            $value = (array) get_option( $config['prefix'] . $field['id'] );
            if ( is_array( $field['options'] ) ) foreach ( $field['options'] as $single ) {
                $checked = ( isset( $value[$single['id']] ) && $value[$single['id']] === 'on' ) ? ' checked="checked"' : '';
                $group[] = '<label for="sunrise-field-' . $field['id'] . '-' . $single['id'] . '"><input type="checkbox" name="sunrise[' . $field['id'] . '][' . $single['id'] . ']" id="sunrise-field-' . $field['id'] . '-' . $single['id'] . '"' . $checked . ' />&nbsp;&nbsp;' . $single['label'] . '</label><br/>';
            }
            return '<tr><th scope="row">' . $field['name'] . '</th><td class="sunrise-checkbox-group">' . implode( '', $group ) . '<span class="description">' . $field['desc'] . '</span></td></tr>';
        }

        public static function type_html( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'content' => __( 'HTML field', $config['textdomain'] )
            ) );
            return '<tr><td colspan="2">' . $field['content'] . '</td></tr>';
        }

        public static function type_title( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name' => __( 'Title field', $config['textdomain'] )
            ) );
            return '<tr><td colspan="2"><h3 class="sunrise-title-field">' . $field['name'] . '</h3></td></tr>';
        }

        public static function type_image_radio( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'    => __( 'Image radio', $config['textdomain'] ),
                'id'      => '',
                'desc'    => '',
                'options' => array()
            ) );
            $options = array();
            foreach( $field['options'] as $option ) {
                $label = ( isset( $option['label'] ) ) ? $option['label'] : '';
                $options[] = '<a href="javascript:;" data-value="' . $option['value'] . '" title="' . $label . '"><img src="' . $option['image'] . '" alt="" /></a>';
            }
            return '<tr><th scope="row">' . $field['name'] . '</th><td><div class="sunrise-image-radio">' . implode( '', $options ) . '<input type="hidden" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" /></div><p class="description">' . $field['desc'] . '</p></td></tr>';
        }

        public static function type_size( $field, $config ) {
            $field = wp_parse_args( $field, array(
                'name'  => __( 'Size', $config['textdomain'] ),
                'id'    => '',
                'desc'  => '',
                'units' => array( 'px', 'em', '%' ),
                'min'   => 0,
                'max'   => 200,
                'step'  => 10
            ) );
            $value = get_option( $config['prefix'] . $field['id'] );
            if ( !is_array( $value ) || count( $value ) !== 2 ) $value = array( 0 => '0', 1 => 'px' );
            $units = array();
            foreach( $field['units'] as $unit ) {
                $units[] = '<option value="' . $unit . '">' . $unit . '</option>';
            }
            return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '-0">' . $field['name'] . '</label></th><td><input type="number" value="' . $value[0] . '" name="sunrise[' . $field['id'] . '][0]" id="sunrise-field-' . $field['id'] . '-0" class="regular-text" min="' . (string) $field['min'] . '" max="' . (string) $field['max'] . '" step="' . (string) $field['step'] . '" /> <select name="sunrise[' . $field['id'] . '][1]" id="sunrise-field-' . $field['id'] . '-1">' . str_replace( 'value="' . $value[1] . '"', 'value="' . $value[1] . '" selected="selected"', implode( '', $units ) ) . '</select><p class="description">' . $field['desc'] . '</p></td></tr>';
        }

        /**
         * Display options page tabs
         */
        public static function options_page_tabs( $options, $config ) {
            // Declare tabs array
            $tabs = array();
            // Loop through options
            foreach ( (array) $options as $option ) {
                // Current option is opentab
                if ( isset( $option['type'] ) && isset( $option['name'] ) && $option['type'] === 'opentab' ) $tabs[] = '<span class="nav-tab">' . $option['name'] . '</span>';
            }
            // Return resulting markup
            return ( count( $tabs ) ) ? '<div id="icon-options-general" class="icon32 hide-if-no-js"><br /></div><h2 id="sunrise-tabs" class="nav-tab-wrapper hide-if-no-js">' . implode( '', $tabs ) . '</h2>' : '';
        }

        /**
         * Display options page notices
         */
        public static function options_page_notices( $options, $config ) {
            // Setup messsages
            $msgs = apply_filters( 'sunrise/page/notices', array(
                __( 'For full functionality of this page it is reccomended to enable javascript.', $config['textdomain'] ),
                __( 'Settings saved successfully', $config['textdomain'] ),
                __( 'Settings reseted successfully', $config['textdomain'] )
            ) );
            // Prepare output variable
            $output = array();
            // Get current message
            $message = ( isset( $_GET['message'] ) && is_numeric( $_GET['message'] ) ) ? intval( sanitize_key( $_GET['message'] ) ) : 0;
            // Add no-js notice (will be hidden for js-enabled browsers)
            $output[] = self::notice( '<a href="http://enable-javascript.com/" target="_blank">' . $msgs[0] . '</a>.', 'error hide-if-js' );
            // Show notice
            if ( $message !== 0 ) $output[] = self::notice( $msgs[$message], 'updated' );
            // Return resulting markup
            return implode( '', $output );
        }

        /**
         * Display options panes
         */
        public static function options_page_panes( $options, $config ) {
            // Declare panes array
            $panes = array();
            // Loop through options
            foreach ( $options as $option ) {
                // Check option type definition
                if ( !isset( $option['type'] ) ) continue;
                // Try to call option from external source
                elseif ( isset( $option['callback'] ) && is_callable( $option['callback'] ) ) $panes[] = call_user_func( $option['callback'], $option, $config );
                // Try to call option from built-in class SunriseX_Views
                elseif ( is_callable( array( $config['views_class'], 'type_' . $option['type'] ) ) ) $panes[] = call_user_func( array( $config['views_class'], 'type_' . $option['type'] ), $option, $config );
                // Show error message
                else $panes[] = call_user_func( array( $config['views_class'], 'notice' ), 'Sunrise: ' . sprintf( __( 'option type %s is not callable', $config['textdomain'] ), '<b>' . $option['type'] . '</b>' ), 'error' );
            }
            // Return resulting markup
            return implode( '', $panes );
        }
    }

