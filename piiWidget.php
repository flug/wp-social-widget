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

	unset($instance['title']);
	echo '<ul >';
	foreach($instance as $key => $value) {

	    if($this->is($key)== 'link')
		$value = '<a  class="link-soc link-soc-'.$key.'" href="'.$value.'" >'.$this->getLabel($key).'</a>';

	    echo '<li class="list-soc list-soc-'.$key.'">' .$value. '</li>';

	}
	echo '</ul>';

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
		"default_value" => "Url Facebook page",
		"is" => "link"
	    ] ,
	    "twitter" =>[
		"label" => "Twitter",
		"type" => "text",
		"is" => "link",
		"default_value" => "Url Twitter page"
	    ] ,
	    "pinterest" =>[
		"label"=>"Pinterest",
		"type"=>"text",
		"is"	=> "link",
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
	    ]

	];

    }

    public function fieldsSet($key , $label , $type, $default_value = "")
    {
	$output = '<label for="'.$this->get_field_id( $key ).'">'. __($label.":" ).'</label>';
	switch($type){
	case  "textarea":
	    $output .= '<textarea class="widefat" id="'.$this->get_field_id( $key ).'"
		name="'.$this->get_field_name( $key ).'" >'.trim(esc_attr( $default_value )).' </textarea>';
	    break;

	case 'checkbox' :
	    $output .= '<input class="widefat" id="'. $this->get_field_id( $key ).'"
		name="'.$this->get_field_name( $key ).'" type="'.$type.'"
		value="1" '. checked( '1', $default_value , false ).'  />';

	    break ;

	default:
	    $output .= '<input class="widefat" id="'. $this->get_field_id( $key ).'"
		name="'.$this->get_field_name( $key ).'" type="'.$type.'"
		value="'.esc_attr( $default_value ).'" />';
	    break;


	}


	return $output;

    }
    public function is ($key){
	$param = $this->parametersList()[$key];
	if(!isset($param['is']))
	    return;
	return $param['is'];
    }
    public function getLabel ($key){
	$param = $this->parametersList()[$key];
	return $param['label'];
    }
}
