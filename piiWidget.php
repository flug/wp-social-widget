<?php

class piiWidget extends WP_Widget {

    function __construct() {
	parent::__construct(
	    // Base ID of your widget
	    'piiWidget',

	    // Widget name will appear in UI
	    __('Personnal Social Data', 'wpb_widget_domain'),

	    // Widget description
	    array( 'description' => __( 'You personnal Social data', 'wpb_widget_domain' ), )
	);
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	    echo $args['before_title'] . $title . $args['after_title'];

	// This is where you run the code and display the output
	echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
	// Widget admin form
	?>
	<p>

	<?php foreach ($this->parametersList() as $key => $param ) {
	    if ( isset( $instance[ $key ] ) ) {
		$value = $instance[ $key ];
	    }
	    else {

		if(!empty($param['default_value']))
		    $value = $param['default_value'] ;
		else
		    $value = '';
	    }

	    echo $this->fieldsSet($key, $param['label'] , $param['type'], $value);
	}
	?>

	</p>
<?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
	$instance = array();
	foreach ($this->parametersList() as $key => $param){

	    $instance[$key] = ( ! empty( $new_instance[$key] ) ) ? strip_tags( $new_instance[$key] ) : '';

	}

	return $instance;
    }

    public  function parametersList()
    {
	return [
	    "title" => [
		"label" => "Title Widget",
		"type" => "text",
		"default_value" => "New Title"
	    ] ,
	    "facebook" => [
		"label" =>"Facebook",
		"type" => "text",
		"default_value" => "Url Facebook page"
	    ] ,
	    "twitter" =>[
		"label" => "Twitter",
		"type" => "text",
		"default_value" => "Url Twitter page"
	    ] ,
	    "pinterest" =>[
		"label"=>"Pinterest",
		"type"=>"text",
		"default_value" => "Url Pinterest page"
	    ],
	    "phone" =>[
		"label"=>"Phone",
		"type"=>"text",
	    ],
	    "fax" =>[
		"label"=>"Fax",
		"type"=>"text",
	    ],
	    "email" =>[
		"label"=>"Email",
		"type"=>"email",
	    ],
	    "address" =>[
		"label"=>"Address",
		"type"=>"textarea",
	    ],
	];

    }

    public function fieldsSet($key , $label , $type, $default_value = "")
    {
	$output = '<label for="'.$this->get_field_id( $key ).'">'. __($label.":" ).'</label>';
	if($type == "textarea"){

	    $output .= '<textarea class="widefat" id="'.$this->get_field_id( $key ).'"
		name="'.$this->get_field_name( $key ).'" >'.esc_attr( $default_value ).' </textarea>';

	}
	else{

	    $output .= '<input class="widefat" id="'. $this->get_field_id( $key ).'"
		name="'.$this->get_field_name( $key ).'" type="'.$type.'"
		value="'.esc_attr( $default_value ).'" />';

	}
	return $output;

    }

}
