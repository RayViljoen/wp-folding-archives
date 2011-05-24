<?php
/*
Plugin Name: Folding Archives
Description: Displays a animates collapsible archive list.
Author: <a href="http://www.fubra.com">Ray Viljoen</a>
Version: 1.0
Plugin URI: http://catn.com/community/plugins/folding-archives/
Usage: Requires jQuery 1.4 +.
*/
// � 2009-2010 Fubra Limited, all rights reserved.

class FoldingArchives extends WP_Widget {
	/** constructor */
	function FoldingArchives() {
		parent::WP_Widget(false, $name = 'Folding Archives');
	}

	function widget($args, $instance) {

		$title = apply_filters('widget_title', $instance['title']);
		$limit = $instance['limit'];
		$incl_jq = $instance['incl_jq'];

		$archives = get_posts('numberposts=-1&limit=orderby=date');
		echo '<li class="widget widget_folding_archives" id="collapsible-archives">';
		echo '<span class="archives-title">'.$title.'</span>';
		$date = 'starting-value';
		foreach($archives as $single_post)
		{
			$un_date = date_create($single_post->post_date);
			$month_pos = strrpos($single_post->post_date, '-');
			$new_date = substr($single_post->post_date, 0, $month_pos);
			$url_array = explode('-', $new_date);

			$time_diff = time() - date_timestamp_get($un_date);
			$days_old = floor($time_diff/(60*60*24));
			if($days_old <= $limit):
				if(($new_date !== $date) && ($date !== 'starting-value'))
				{
					echo '</ul>';
				}

			if($new_date !== $date)
			{
				echo '<p class="archive-title" >';
				echo '<a href="/'.$url_array[0].'/'.$url_array[1].'/" >';
				echo date_format($un_date, 'F ').'<span class="archive-year">';
				echo date_format($un_date, 'Y').'</span>';
				echo '</a></p><ul style="display:none;">';
			}
			echo '<li class="archive_post"><a href="';
			echo get_permalink($single_post->ID);
			echo '">';
			echo $single_post->post_title;
			echo '</a></li>';
			else: break;
			endif;

			$date = $new_date; // Set Date For Next Post
		}
		echo '</ul></li>';
		if($incl_jq){ echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" ></script>'; }
		echo '<script src="/wp-content/plugins/folding-archives/folding.js" type="text/javascript" ></script>';
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['incl_jq'] = strip_tags($new_instance['incl_jq']);

		return $instance;
	}

	function form($instance) {
		if(array_key_exists('title', $instance)){
			$title = esc_attr($instance['title']);
		}else{$title = '';}

		if(array_key_exists('limit', $instance)){
			$limit = esc_attr($instance['limit']);
		}else{$limit = 365;}

		if(array_key_exists('incl_jq', $instance)){
			$incl_jq = esc_attr($instance['incl_jq']);
		}else{$incl_jq = 0;}

?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><input id="<?php echo $this->get_field_id('incl_jq'); ?>" name="<?php echo $this->get_field_name('incl_jq'); ?>" <?php if($incl_jq){ echo 'checked="checked"'; } ?> type="checkbox" value= "1" ><label for="<?php echo $this->get_field_id('incl_jq'); ?>"> Include jQuery</label></p>
	        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit posts to'); ?> <input class="widenarrow" style="width:50px; text-align:center;" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /> days.</label></p>
        <?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("FoldingArchives");'));