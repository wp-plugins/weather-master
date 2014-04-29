<?php
//Hook Widget
add_action( 'widgets_init', 'weather_master_widget_basic' );
//Register Widget
function weather_master_widget_basic() {
register_widget( 'weather_master_widget_basic' );
}

class weather_master_widget_basic extends WP_Widget {
	function weather_master_widget_basic() {
	$widget_ops = array( 'classname' => 'Weather Master Basic', 'description' => __('Weather Master Basic Fast Loading Widget is easy to deploy and uses the latest weather forecast information. ', 'weather_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'weather_master_widget_basic' );
	$this->WP_Widget( 'weather_master_widget_basic', __('Weather Master Basic', 'weather_master'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		//Save WPOptions
		add_option('weather_master_view_basic_detail_choice', "12");
		$weather_master_load_basic_city = "12";
		update_option ('weather_master_load_basic_city', $weather_master_load_basic_city);
		$weather_master_load_basic_state = "7";
		//Set Tittle
		$weather_title = isset( $instance['weather_title'] ) ? $instance['weather_title'] :false;
		$weather_title_new = isset( $instance['weather_title_new'] ) ? $instance['weather_title_new'] :false;
		//Set Wide Map Options
		$weathermapsspacer ="'";
		$show_weather_master = isset( $instance['show_weather_master'] ) ? $instance['show_weather_master'] :false;
		$weather_master_weather_temp = isset( $instance['weather_master_weather_temp'] ) ? $instance['weather_master_weather_temp'] :false;
		$weather_height = isset( $instance['weather_height'] ) ? $instance['weather_height'] :false;
		$weather_latitude = isset( $instance['weather_latitude'] ) ? $instance['weather_latitude'] :false;
		$weather_longitude = isset( $instance['weather_longitude'] ) ? $instance['weather_longitude'] :false;
		echo $before_widget;
		
		// Display the widget title
	if ( $weather_title ){
		if (empty ($weather_title_new)){
		$weather_title_new = get_option('weather_master_name');
		}
		echo $before_title . $weather_title_new . $after_title;
	}
	else{
	}
	//Display Google Maps
	if ( $show_weather_master ){
		if (empty($weather_height)){
		$weather_height = '400';
		}
		if (empty($weather_latitude)){
		$weather_latitude = '32.720392';
		}
		if (empty($weather_longitude)){
		$weather_longitude = '-117.228778';
		}
		//PREPARE TEMP
		if ($weather_master_weather_temp){
			$weather_master_weather_temp_choice = "CELSIUS";
		}
		else{
			$weather_master_weather_temp_choice = "FAHRENHEIT";
		}
		echo '<div id="map_weather_basic" style="width:auto; height:'.$weather_height.'px;"></div>' .
		'<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=weather"></script>' .
		'<script type="text/javascript">' .
		'function initialize() {
		var mapOptions = {
		center: new google.maps.LatLng('.$weather_latitude.', '.$weather_longitude.'),
		zoom: 12,
		mapTypeControl: false,
		panControl: false,
		zoomControl: false,
		streetViewControl: false,
		};
		var map_weather_basic = new google.maps.Map(document.getElementById('.$weathermapsspacer.'map_weather_basic'.$weathermapsspacer.'),
		mapOptions);
		var weatherLayer = new google.maps.weather.WeatherLayer({
		temperatureUnits: google.maps.weather.TemperatureUnit.'.$weather_master_weather_temp_choice.'
		});
		weatherLayer.setMap(map_weather_basic);
		var cloudLayer = new google.maps.weather.CloudLayer();
		cloudLayer.setMap(map_weather_basic);
		}
		google.maps.event.addDomListener(window, '.$weathermapsspacer.'load'.$weathermapsspacer.', initialize);' .
		'</script>';
	}
	else{
	}
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['weather_title'] = strip_tags( $new_instance['weather_title'] );
		$instance['weather_title_new'] = $new_instance['weather_title_new'];
		//Store Wide Map Options
		$instance['show_weather_master'] = $new_instance['show_weather_master'];
		$instance['weather_master_weather_temp'] = $new_instance['weather_master_weather_temp'];
		$instance['weather_master_view_basic_detail_choice'] = $new_instance['weather_master_view_basic_detail_choice'];
		update_option('weather_master_view_basic_detail_choice', $new_instance['weather_master_view_basic_detail_choice']);
		$instance['weather_height'] = $new_instance['weather_height'];
		$instance['weather_latitude'] = $new_instance['weather_latitude'];
		$instance['weather_longitude'] = $new_instance['weather_longitude'];
		return $instance;
	}
	function form( $instance ) {
	//Set up some default widget settings.
	$defaults = array( 'weather_title_new' => __('Google Ads Master', 'weather_master'), 'weather_title' => true, 'weather_title_new' => false, 'show_weather_master' => false, 'weather_master_view_basic_detail_choice' => false, 'weather_master_weather_temp' => false, 'weather_height' => false, 'weather_latitude' => false, 'weather_longitude' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
		<b>Check the buttons to be displayed:</b>
		</p>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['weather_title'], true ); ?> id="<?php echo $this->get_field_id( 'weather_title' ); ?>" name="<?php echo $this->get_field_name( 'weather_title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'weather_title' ); ?>"><b><?php _e('Display Widget Title', 'weather_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_title_new' ); ?>"><?php _e('Change Title:', 'weather_master'); ?></label>
	<br>
	<input id="<?php echo $this->get_field_id( 'weather_title_new' ); ?>" name="<?php echo $this->get_field_name( 'weather_title_new' ); ?>" value="<?php echo $instance['weather_title_new']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<h2>Weather Options</h2>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_weather_master'], true ); ?> id="<?php echo $this->get_field_id( 'show_weather_master' ); ?>" name="<?php echo $this->get_field_name( 'show_weather_master' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_weather_master' ); ?>"><b><?php _e('Activate Weather Display', 'weather_master'); ?></b></label>
	</p>
	</p>
	<select id="<?php echo $this->get_field_id( 'weather_master_view_basic_detail_choice' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_view_basic_detail_choice' ); ?>" style="width:190px">
	<option value="<?php echo get_option('weather_master_load_basic_city'); ?>" <?php echo get_option('weather_master_view_basic_detail_choice') == '12' ? 'selected="selected"':''; ?>>City Weather Level</option>
	</select>
	<label for="<?php echo $this->get_field_id( 'weather_master_view_basic_detail_choice' ); ?>"><?php _e('Weather Detail Level', 'weather_master'); ?></label>
	</p>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['weather_master_weather_temp'], true ); ?> id="<?php echo $this->get_field_id( 'weather_master_weather_temp' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_weather_temp' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'weather_master_weather_temp' ); ?>"><b><?php _e('Activate Weather in Celsius', 'weather_master'); ?></b></label>
	<div class="description">Default <b>Off</b> temperature displayed in Fahrenheit.</div>
	</p>
	<p>
	<input id="<?php echo $this->get_field_id( 'weather_height' ); ?>" name="<?php echo $this->get_field_name( 'weather_height' ); ?>" value="<?php echo $instance['weather_height']; ?>" style="width:auto;" />
	<label for="<?php echo $this->get_field_id( 'weather_height' ); ?>"><?php _e('Plugin Height', 'weather_master'); ?></label>
	<div class="description">Default <b>400</b>. You can play with this value, does not affect responsiveness.</div>
	</p>
	<p>
	<input id="<?php echo $this->get_field_id( 'weather_latitude' ); ?>" name="<?php echo $this->get_field_name( 'weather_latitude' ); ?>" value="<?php echo $instance['weather_latitude']; ?>" style="width:auto;" />
	<label for="<?php echo $this->get_field_id( 'weather_latitude' ); ?>"><?php _e('Weather Latitude', 'weather_master'); ?></label>
	<div class="description">Example <b>32.720392</b>. Check below instructions.</div>
	</p>
	<p>
	<input id="<?php echo $this->get_field_id( 'weather_longitude' ); ?>" name="<?php echo $this->get_field_name( 'weather_longitude' ); ?>" value="<?php echo $instance['weather_longitude']; ?>" style="width:auto;" />
	<label for="<?php echo $this->get_field_id( 'weather_longitude' ); ?>"><?php _e('Weather Longitude', 'weather_master'); ?></label>
	<div class="description">Example <b>-117.228778</b>. Check below instructions.</div>
	</p>
	<p>
	<div class="description">Get Coordinates <a href="http://maps.google.com" target="_blank">Google Maps</a>. Right-click on the desired spot on the map to bring up a menu with options. Click What's here to get the latitude and longitude coordinates. Try to get coordinates roughly from the center of your city, state or country.</div>
	<div class="description"><a href="http://wordpress.techgasp.com/weather-master-documentation/" target="_blank">More about these settings</a>.</div>
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; width:16px; vertical-align:middle;" />
	&nbsp;
	<b><?php echo get_option('weather_master_name'); ?> Website</b>
	</p>
	<p><a class="button-secondary" href="http://wordpress.techgasp.com/weather-master/" target="_blank" title="<?php echo get_option('weather_master_name'); ?> Info Page">Info Page</a> <a class="button-secondary" href="http://wordpress.techgasp.com/weather-master-documentation/" target="_blank" title="<?php echo get_option('weather_master_name'); ?> Documentation">Documentation</a> <a class="button-primary" href="http://wordpress.techgasp.com/weather-master/" target="_blank" title="Visit Website">Get Add-Ons</a></p>
	<?php
	}
 }
?>