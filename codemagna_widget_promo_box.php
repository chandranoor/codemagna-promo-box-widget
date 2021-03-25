<?php
/*
 * Plugin Name: Codemagna Promo Box Widget
 * Description: A widget that allows you to show your promo box
 * Version: 1.0
 * Author: Codemagna
 * Author URI: http://www.codemagna.com
 * License: GPL2

  Copyright 2020 Codemagna

 */
/**
 * Register the Widget
 */
add_action('widgets_init', 'codemagna_widget_promo_box_function');

function codemagna_widget_promo_box_function(){
    register_widget("codemagna_widget_promo_box");
}

class codemagna_widget_promo_box extends WP_Widget {

    /**
     * Constructor
     * */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'codemagna_widget_promo_box',
            'description' => 'A widget that allows you to show your promo box.'
        );

        parent::__construct('codemagna_widget_promo_box', 'CODEMAGNA - Promo Box', $widget_ops);

        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }

    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts() {

        wp_enqueue_media();
        wp_register_script('codemagna_widget_promo_box', plugin_dir_url( __FILE__ ) . 'codemagna_widget_promo_box.js', array('jquery'));
        wp_enqueue_script('codemagna_widget_promo_box');
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     * */
    public function widget($args, $instance) {
        // Add any html to output the image in the $instance array
        extract($args);
        extract($instance);

        /* Add Custom Class to Widget */
        if (strpos($before_widget, 'class') === false) {
            $before_widget = str_replace('>', 'class="'.$layout.' "', $before_widget);
        }
        // there is 'class' attribute - append width value to it
        else {
            $before_widget = str_replace('class="widget ', 'class="widget '.$layout.' ', $before_widget);
        }
        /* Before widget */
        echo $before_widget;

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        wp_enqueue_style( 'codemagna-widget-promo-box', plugin_dir_url( __FILE__ ) . 'codemagna_widget_promo_box.css');
        
        $widget_content  = "<a class='promo-box-wrapper' href='".$link."'>";
        $widget_content .= "<div class='promo-box-content'>";
        $widget_content .= "<h4 class='promo-box-title xf'>" . $header . "</h4>";
        $widget_content .= "<span class='promo-box-subheader tf'>".$subheader."</span>";
        $widget_content .= "</div>";
        $widget_content .= "<div class='background-image' style='--background: url(\"" . $image . "\");'>";
        $widget_content .= "</div>";
        $widget_content .= "</a>";
        $widget_content .= $after_widget;

        echo $widget_content;
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     * */
    public function update($new_instance, $old_instance) {

        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void
     * */
    public function form($instance) {
        $title = '';
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }

        $image = '';
        if (isset($instance['image'])) {
            $image = $instance['image'];
        }

        $header = '';
        if (isset($instance['header'])) {
            $header = $instance['header'];
        }

        $subheader = '';
        if (isset($instance['subheader'])) {
            $subheader = $instance['subheader'];
        }

        $link = '';
        if (isset($instance['link'])) {
            $link = $instance['link'];
        }

        $layout = '';
        if (isset($instance['layout'])) {
            $layout = $instance['layout'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title:', 'codemagna'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" type="text" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name('image'); ?>"><?php _e('Background:', 'codemagna'); ?></label>
            <?php
                if(isset($image)){
                    $image_url = $image;
                }else{
                    $image_url = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+P+/HgAFhAJ/wlseKgAAAABJRU5ErkJggg==';
                }
            ?>
            <img id="<?php echo $this->get_field_id('image').'_preview'; ?>" class="codemagna_widget_promo_box_image_display" style="max-width:100%; max-height:450px" src="<?php echo esc_url($image_url); ?>" alt="" />
            <br/>
            <input hidden name="<?php echo $this->get_field_name('image'); ?>" id="<?php echo $this->get_field_id('image'); ?>" class="widefat codemagna_widget_promo_box_image_url" type="text" size="36"  value="<?php echo esc_url($image); ?>" />
            <input style="margin-top:10px;" class="button button-primary codemagna_widget_promo_box_upload_image_button" type="button" value="<?php _e('Select Image', 'codemagna'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('header'); ?>"><?php _e('Header:', 'codemagna'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('header'); ?>" name="<?php echo $this->get_field_name('header'); ?>" value="<?php echo esc_attr($header); ?>" type="text" />
        </p>       
        <p>
            <label for="<?php echo $this->get_field_name('subheader'); ?>"><?php _e('Subheader:', 'codemagna'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('subheader'); ?>" name="<?php echo $this->get_field_name('subheader'); ?>" value="<?php echo esc_attr($subheader); ?>" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('link'); ?>"><?php _e('Link:', 'codemagna'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo esc_attr($link); ?>" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('layout'); ?>"><?php _e('Layout:', 'codemagna'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                <option <?php selected( $layout, 'w-full' ); ?> value="w-full">Full width </option>
                <option <?php selected( $layout, 'w-half' ); ?> value="w-half">1/2 width</option>
                <option <?php selected( $layout, 'w-one-third' ); ?> value="w-one-third">1/3 width</option>
            </select><!-- select -->
        </p>
        <?php
    }

}
?>