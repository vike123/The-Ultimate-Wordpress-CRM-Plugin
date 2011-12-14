<?php

//Check to see if our class exists
if ( ! class_exists ( 'mojoMetaBoxes' ) ) {

	//If not let's get cracking
	class mojoMetaBoxes {
	
	//Define array
	public $mojo_meta_fields = array(
				array(
					'label'=> 'Text Input',
					'desc'	=> 'A description for the field.',
					'id'	=> '_mojo_text',
					'type'	=> 'text'
				),
				array(
					'label'=> 'Textarea',
					'desc'	=> 'A description for the field.',
					'id'	=> '_mojo_textarea',
					'type'	=> 'textarea'
				),
				array(
					'label'=> 'Checkbox Input',
					'desc'	=> 'A description for the field.',
					'id'	=> '_mojo_checkbox',
					'type'	=> 'checkbox'
				),
				array(
					'label'=> 'Select Box',
					'desc'	=> 'A description for the field.',
					'id'	=> '_mojo_select',
					'type'	=> 'select',
					'options' => array (
						'one' => array (
							'label' => 'Option One',
							'value'	=> 'one'
						),
						'two' => array (
							'label' => 'Option Two',
							'value'	=> 'two'
						),
						'three' => array (
							'label' => 'Option Three',
							'value'	=> 'three'
						)
					)
				)
			);		
	
		//Add the Meta Box
		function add_mojo_meta() {
			add_meta_box(
				'mojo_meta_box', //$id
				'Mojo Meta Box', //$title
				array( $this, 'show_mojo_meta_box' ), //$callback
				'post', //$page
				'normal', //$context
				'high' //$priority
			);	
		}
		
		//Constrcutor
		function __construct() {
		
			add_action( 'add_meta_boxes', array( $this, 'add_mojo_meta' ) );
			
			add_action('save_post', array( $this, 'save_mojo_meta' ) );
			
		}
			
		//The Callback
		function show_mojo_meta_box() {
			global $post;
			
			//Use nonce for verification
			echo '<input type="hidden" name="mojo_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
	
			// Begin the field table and loop
			echo '<table class="form-table">';
			//var_dump($this->mojo_meta_fields);
			foreach ( $this->mojo_meta_fields as $field ) {
				// get value of this field if it exists for this post
				$meta = get_post_meta( $post->ID, $field['id'], true );
				
				// begin a table row with
				echo '<tr>
						<th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
						<td>';
						
						switch( $field['type'] ) {
							
							//text
							case 'text' :
								echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" /><br /><span class="description">' . $field['desc'] . '</span>';
							break;
							
							//textarea
							case 'textarea' :
								echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="60" rows="4">' . $meta . '</textarea><br /><span class="description">' . $field['desc'] . '</span>';
							break;
							
							//checkbox
							case 'checkbox' :
								echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ', $meta ? ' checked="checked"' : '','/>
								<label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
							break;
							
							//select
							case 'select':
								echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
								
								foreach ( $field['options'] as $option ) {
									echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
								}
								
								echo '</select><br /><span class="description">' . $field['desc'] . '</span>';
							break;
							
						} //end switch
				
				echo '</td></tr>';
			
			} //end foreach
		
			echo '</table>'; //end table
		}
		
		//Save the Data
		function save_mojo_meta( $post_id ) {
		
			//verify nonce
			if ( isset( $_POST['mojo_meta_box_nonce'] ) ) {
				if ( ! wp_verify_nonce( $_POST['mojo_meta_box_nonce'], basename( __FILE__ ) ) )
					return $post_id;
			
			
				//check autosave
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
					return $post_id;
				
				//check permissions
				if ( 'page' == $_POST['post_type'] ) :
					
					if ( ! current_user_can( 'edit_page', $post_id ) ) : 
						return $post_id;
					elseif ( ! current_user_can( 'edit_post', $post_id ) ) :
						return $post_id;
					
					endif;
				endif;
			
				// loop through fields and save the data
				foreach ( $this->mojo_meta_fields as $field ) {
					
					$old = get_post_meta( $post_id, $field['id'], true );
					
					$new = $_POST[$field['id']];
					
					if ( $new && $new != $old ) :
						update_post_meta( $post_id, $field['id'], $new );
					elseif ('' == $new && $old) :
						delete_post_meta( $post_id, $field['id'], $old );
					endif;
				} // end foreach
			}
		}
		  
	}
}

$mojo_meta = new mojoMetaBoxes;