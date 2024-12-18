<?php
if (!themename_redux_framework_activated()) {
    return;
}

class Xptheme_Widget_Socials extends Xptheme_Widget
{
    public function __construct()
    {
        parent::__construct(
            'themename_socials_widget',
            esc_html__('Themename Socials', 'themename'),
            array( 'description' => esc_html__('Socials for website.', 'themename'), )
        );
        $this->widgetName = 'socials';
    }

    public function getTemplate()
    {
        $this->template = 'socials.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
        $list_socials = apply_filters(
            'themename_socials_list_socials',array(
                'facebook'      => 'Facebook',
                'twitter'       => 'Twitter',
                'youtube-play'  => 'Youtube',
                'pinterest'     => 'Pinterest',
                'linkedin'      => 'LinkedIn'
            )
        );

        $defaults = array('title' => 'Find us on social networks', 'layout' => 'default', 'socials' => array());
        $instance = wp_parse_args((array) $instance, $defaults); ?>
    <div class="xptheme_socials">

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'themename'); ?></label>
            <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('socials')); ?>"><?php esc_html_e('Select socials:', 'themename'); ?></label>
            <br>
        <?php
            foreach ($list_socials as $key => $value):
                $checked = (isset($instance['socials'][$key]['status']) && ($instance['socials'][$key]['status'])) ? 1: 0;
        $link = (isset($instance['socials'][$key]['page_url'])) ? $instance['socials'][$key]['page_url']: ''; ?>
                <p>
                <input class="checkbox" type="checkbox" <?php checked($checked, 1); ?> id="<?php echo esc_attr($key); ?>"
                    name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][status]" />
                    <label for="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][status]">
                        <?php echo esc_html__('Show ', 'themename').esc_html($value); ?>
                    </label>
                <input type="hidden" name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][name]" value=<?php echo esc_attr($value); ?> />
                </p>

                <?php
                   $check_value =  ($checked)? 'block': 'none'; ?>
                <p style="display: <?php echo trim($check_value); ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" class="text_url <?php echo esc_attr($key); ?>">
                    <label for="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][page_url]">
                        <?php echo esc_html($value).' '.esc_html__('Page URL:', 'themename').' '; ?>
                    </label>
                    <input class="widefat" type="text"
                        id="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][page_url]"
                        name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][page_url]"
                        value="<?php echo esc_attr($link); ?>"
                    />
                </p>
            <?php endforeach; ?>
        </p>
    </div>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['socials'] = $new_instance['socials'];
        $instance['layout'] = (! empty($new_instance['layout'])) ? $new_instance['layout'] : 'default';

        return $instance;
    }
}
