<?php
/**
 * Registering meta boxes
 *
 * In this file, I'll show you how to extend the class to add more field type (in this case, the 'taxonomy' type)
 * All the definitions of meta boxes are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value instead of boolean as before
 *
 * You also should read the changelog to know what has been changed
 *
 * For more information, please visit: http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 *
 */

/********************* BEGIN EXTENDING CLASS ***********************/

require_once 'meta-box-3.2.2.class.php'; //The class to handle our CPT Meta Boxes

/**
 * Extend VTP_Meta_Box class
 * Add field type: 'taxonomy'
 */
class UWPCRM_Meta_Box_Taxonomy extends UWPCRM_Meta_Box {
	
	function add_missed_values() {
		parent::add_missed_values();
		
		// add 'multiple' option to taxonomy field with checkbox_list type
		foreach ( $this->_meta_box['fields'] as $key => $field) {
			if (' taxonomy' == $field['type'] && 'checkbox_list' == $field['options']['type'] ) {
				$this->_meta_box['fields'][$key]['multiple'] = true;
			}
		}
	}
	
	// show taxonomy list
	function show_field_taxonomy( $field, $meta ) {
		global $post;
		
		if ( ! is_array( $meta ) ) $meta = ( array ) $meta;
		
		$this->show_field_begin( $field, $meta );
		
		$options = $field['options'];
		$terms = get_terms( $options['taxonomy'], $options['args'] );
		
		// checkbox_list
		if ( 'checkbox_list' == $options['type'] ) {
			foreach ( $terms as $term ) {
				echo "<input type='checkbox' name='{$field['id']}[]' value='$term->slug'" . checked( in_array( $term->slug, $meta ), true, false ) . " /> $term->name<br/>";
			}
		}
		// select
		else {
			echo "<select name='{$field['id']}" . ( $field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'" ) . ">";
		
			foreach ($terms as $term) {
				echo "<option value='$term->slug'" . selected( in_array( $term->slug, $meta ), true, false ) . ">$term->name</option>";
			}
			echo "</select>";
		}
		
		$this->show_field_end( $field, $meta );
	}
	
}

/**
 * Extend VTP_Meta_Box_Taxonomy class
 * Add field type: 'users'
 */
class UWPCRM_Meta_Box_Mojowill extends UWPCRM_Meta_Box {
	
	//Get Users
	function show_field_users( $field, $meta ) {
		global $post;
		
		if ( ! is_array( $meta) ) $meta = ( array ) $meta;
		
		$this->show_field_begin( $field, $meta );
		
		$options = $field['options'];
		
		$users = get_users( 'role=' . $options['role'] );
		
		echo "<select name='{$field['id']}" . ( $field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'" ) . ">";
		
		foreach ( $users as $user ) {
			echo "<option value='$user->ID'" . selected( in_array( $user->ID, $meta ), true, false ) . ">$user->display_name</option>";
		}
		
		echo "</select>";
	}
	
	//Get Posts
	function show_field_posts( $field, $meta ) {
		global $post;
		
		if ( ! is_array( $meta ) ) $meta = ( array ) $meta;
		
		$this->show_field_begin( $field, $meta );
		
		$options = $field['options'];
		
		$args = array(
			'post_type' => $options['post_type'],
			'post_status' => 'publish'	
		);
		
		$posts = get_posts( $args );
		
		echo "<select name='{$field['id']}" . ( $field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'" ) . ">";
		
		foreach ( $posts as $post ) {
			echo "<option value='$post->ID'" . selected( in_array( $post->ID, $meta ), true, false ) . ">$post->post_title</option>";
		}
		
		echo "</select>";
	}

}
 
/********************* END EXTENDING CLASS ***********************/

/********************* BEGIN DEFINITION OF META BOXES ***********************/

// prefix of meta keys, optional
// use underscore (_) at the beginning to make keys hidden, for example $prefix = '_rw_';
// you also can make prefix empty to disable it
$prefix = '_uwpcrm_';

$meta_boxes = array();

//Meta Boxes for Accounts
$meta_boxes[] = array(
	'id' => 'primary_info',						// meta box id, unique per meta box
	'title' => __( 'Primary Information', 'uwpcrm' ),			// meta box title
	'pages' => array('account'),				// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => __( 'Email', 'uwpcrm' ),					// field name
			'id' => $prefix . 'email',				// field id, i.e. the meta key
			'type' => 'text',						// text box
		),
		array(
			'name' => __( 'Website', 'uwpcrm' ),
			'id' => $prefix . 'url',
			'type' => 'text'
		),
		array(
			'name' => __( 'Telephone Number', 'uwpcrm' ),
			'id' => $prefix . 'telephone',
			'type' => 'text',
		),
		array(
			'name' => __( 'Address Line 1', 'uwpcrm' ),
			'id' => $prefix . 'address1',
			'type' => 'text',
		),
		array(
			'name' => __( 'Address Line 2', 'uwpcrm' ),
			'id' => $prefix . 'address2',
			'type' => 'text',
		),
		array(
			'name' => __( 'Town/City', 'uwpcrm' ),
			'id' => $prefix . 'city',
			'type' => 'text',
		),
		array(
			'name' => __( 'County', 'uwpcrm' ),
			'id' => $prefix . 'county',
			'type' => 'text',
		),
		array(
			'name' => __( 'Country', 'uwpcrm' ),
			'id' => $prefix . 'country',
			'type' => 'select',						// select box
			'options' => array(						// array of key => value pairs for select box
				'AL'=>'ALBANIA',
				'DZ'=>'ALGERIA',
				'AS'=>'AMERICAN SAMOA',
				'AD'=>'ANDORRA',
				'AO'=>'ANGOLA',
				'AI'=>'ANGUILLA',
				'AQ'=>'ANTARCTICA',
				'AG'=>'ANTIGUA AND BARBUDA',
				'AR'=>'ARGENTINA',
				'AM'=>'ARMENIA',
				'AW'=>'ARUBA',
				'AU'=>'AUSTRALIA',
				'AT'=>'AUSTRIA',
				'AZ'=>'AZERBAIJAN',
				'BS'=>'BAHAMAS',
				'BH'=>'BAHRAIN',
				'BD'=>'BANGLADESH',
				'BB'=>'BARBADOS',
				'BY'=>'BELARUS',
				'BE'=>'BELGIUM',
				'BZ'=>'BELIZE',
				'BJ'=>'BENIN',
				'BM'=>'BERMUDA',
				'BT'=>'BHUTAN',
				'BO'=>'BOLIVIA',
				'BA'=>'BOSNIA AND HERZEGOVINA',
				'BW'=>'BOTSWANA',
				'BV'=>'BOUVET ISLAND',
				'BR'=>'BRAZIL',
				'IO'=>'BRITISH INDIAN OCEAN TERRITORY',
				'BN'=>'BRUNEI DARUSSALAM',
				'BG'=>'BULGARIA',
				'BF'=>'BURKINA FASO',
				'BI'=>'BURUNDI',
				'KH'=>'CAMBODIA',
				'CM'=>'CAMEROON',
				'CA'=>'CANADA',
				'CV'=>'CAPE VERDE',
				'KY'=>'CAYMAN ISLANDS',
				'CF'=>'CENTRAL AFRICAN REPUBLIC',
				'TD'=>'CHAD',
				'CL'=>'CHILE',
				'CN'=>'CHINA',
				'CX'=>'CHRISTMAS ISLAND',
				'CC'=>'COCOS (KEELING) ISLANDS',
				'CO'=>'COLOMBIA',
				'KM'=>'COMOROS',
				'CG'=>'CONGO',
				'CD'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
				'CK'=>'COOK ISLANDS',
				'CR'=>'COSTA RICA',
				'CI'=>'COTE D IVOIRE',
				'HR'=>'CROATIA',
				'CU'=>'CUBA',
				'CY'=>'CYPRUS',
				'CZ'=>'CZECH REPUBLIC',
				'DK'=>'DENMARK',
				'DJ'=>'DJIBOUTI',
				'DM'=>'DOMINICA',
				'DO'=>'DOMINICAN REPUBLIC',
				'TP'=>'EAST TIMOR',
				'EC'=>'ECUADOR',
				'EG'=>'EGYPT',
				'SV'=>'EL SALVADOR',
				'GQ'=>'EQUATORIAL GUINEA',
				'ER'=>'ERITREA',
				'EE'=>'ESTONIA',
				'ET'=>'ETHIOPIA',
				'FK'=>'FALKLAND ISLANDS (MALVINAS)',
				'FO'=>'FAROE ISLANDS',
				'FJ'=>'FIJI',
				'FI'=>'FINLAND',
				'FR'=>'FRANCE',
				'GF'=>'FRENCH GUIANA',
				'PF'=>'FRENCH POLYNESIA',
				'TF'=>'FRENCH SOUTHERN TERRITORIES',
				'GA'=>'GABON',
				'GM'=>'GAMBIA',
				'GE'=>'GEORGIA',
				'DE'=>'GERMANY',
				'GH'=>'GHANA',
				'GI'=>'GIBRALTAR',
				'GR'=>'GREECE',
				'GL'=>'GREENLAND',
				'GD'=>'GRENADA',
				'GP'=>'GUADELOUPE',
				'GU'=>'GUAM',
				'GT'=>'GUATEMALA',
				'GN'=>'GUINEA',
				'GW'=>'GUINEA-BISSAU',
				'GY'=>'GUYANA',
				'HT'=>'HAITI',
				'HM'=>'HEARD ISLAND AND MCDONALD ISLANDS',
				'VA'=>'HOLY SEE (VATICAN CITY STATE)',
				'HN'=>'HONDURAS',
				'HK'=>'HONG KONG',
				'HU'=>'HUNGARY',
				'IS'=>'ICELAND',
				'IN'=>'INDIA',
				'ID'=>'INDONESIA',
				'IR'=>'IRAN, ISLAMIC REPUBLIC OF',
				'IQ'=>'IRAQ',
				'IE'=>'IRELAND',
				'IL'=>'ISRAEL',
				'IT'=>'ITALY',
				'JM'=>'JAMAICA',
				'JP'=>'JAPAN',
				'JO'=>'JORDAN',
				'KZ'=>'KAZAKSTAN',
				'KE'=>'KENYA',
				'KI'=>'KIRIBATI',
				'KP'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
				'KR'=>'KOREA REPUBLIC OF',
				'KW'=>'KUWAIT',
				'KG'=>'KYRGYZSTAN',
				'LA'=>'LAO PEOPLES DEMOCRATIC REPUBLIC',
				'LV'=>'LATVIA',
				'LB'=>'LEBANON',
				'LS'=>'LESOTHO',
				'LR'=>'LIBERIA',
				'LY'=>'LIBYAN ARAB JAMAHIRIYA',
				'LI'=>'LIECHTENSTEIN',
				'LT'=>'LITHUANIA',
				'LU'=>'LUXEMBOURG',
				'MO'=>'MACAU',
				'MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
				'MG'=>'MADAGASCAR',
				'MW'=>'MALAWI',
				'MY'=>'MALAYSIA',
				'MV'=>'MALDIVES',
				'ML'=>'MALI',
				'MT'=>'MALTA',
				'MH'=>'MARSHALL ISLANDS',
				'MQ'=>'MARTINIQUE',
				'MR'=>'MAURITANIA',
				'MU'=>'MAURITIUS',
				'YT'=>'MAYOTTE',
				'MX'=>'MEXICO',
				'FM'=>'MICRONESIA, FEDERATED STATES OF',
				'MD'=>'MOLDOVA, REPUBLIC OF',
				'MC'=>'MONACO',
				'MN'=>'MONGOLIA',
				'MS'=>'MONTSERRAT',
				'MA'=>'MOROCCO',
				'MZ'=>'MOZAMBIQUE',
				'MM'=>'MYANMAR',
				'NA'=>'NAMIBIA',
				'NR'=>'NAURU',
				'NP'=>'NEPAL',
				'NL'=>'NETHERLANDS',
				'AN'=>'NETHERLANDS ANTILLES',
				'NC'=>'NEW CALEDONIA',
				'NZ'=>'NEW ZEALAND',
				'NI'=>'NICARAGUA',
				'NE'=>'NIGER',
				'NG'=>'NIGERIA',
				'NU'=>'NIUE',
				'NF'=>'NORFOLK ISLAND',
				'MP'=>'NORTHERN MARIANA ISLANDS',
				'NO'=>'NORWAY',
				'OM'=>'OMAN',
				'PK'=>'PAKISTAN',
				'PW'=>'PALAU',
				'PS'=>'PALESTINIAN TERRITORY, OCCUPIED',
				'PA'=>'PANAMA',
				'PG'=>'PAPUA NEW GUINEA',
				'PY'=>'PARAGUAY',
				'PE'=>'PERU',
				'PH'=>'PHILIPPINES',
				'PN'=>'PITCAIRN',
				'PL'=>'POLAND',
				'PT'=>'PORTUGAL',
				'PR'=>'PUERTO RICO',
				'QA'=>'QATAR',
				'RE'=>'REUNION',
				'RO'=>'ROMANIA',
				'RU'=>'RUSSIAN FEDERATION',
				'RW'=>'RWANDA',
				'SH'=>'SAINT HELENA',
				'KN'=>'SAINT KITTS AND NEVIS',
				'LC'=>'SAINT LUCIA',
				'PM'=>'SAINT PIERRE AND MIQUELON',
				'VC'=>'SAINT VINCENT AND THE GRENADINES',
				'WS'=>'SAMOA',
				'SM'=>'SAN MARINO',
				'ST'=>'SAO TOME AND PRINCIPE',
				'SA'=>'SAUDI ARABIA',
				'SN'=>'SENEGAL',
				'SC'=>'SEYCHELLES',
				'SL'=>'SIERRA LEONE',
				'SG'=>'SINGAPORE',
				'SK'=>'SLOVAKIA',
				'SI'=>'SLOVENIA',
				'SB'=>'SOLOMON ISLANDS',
				'SO'=>'SOMALIA',
				'ZA'=>'SOUTH AFRICA',
				'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
				'ES'=>'SPAIN',
				'LK'=>'SRI LANKA',
				'SD'=>'SUDAN',
				'SR'=>'SURINAME',
				'SJ'=>'SVALBARD AND JAN MAYEN',
				'SZ'=>'SWAZILAND',
				'SE'=>'SWEDEN',
				'CH'=>'SWITZERLAND',
				'SY'=>'SYRIAN ARAB REPUBLIC',
				'TW'=>'TAIWAN, PROVINCE OF CHINA',
				'TJ'=>'TAJIKISTAN',
				'TZ'=>'TANZANIA, UNITED REPUBLIC OF',
				'TH'=>'THAILAND',
				'TG'=>'TOGO',
				'TK'=>'TOKELAU',
				'TO'=>'TONGA',
				'TT'=>'TRINIDAD AND TOBAGO',
				'TN'=>'TUNISIA',
				'TR'=>'TURKEY',
				'TM'=>'TURKMENISTAN',
				'TC'=>'TURKS AND CAICOS ISLANDS',
				'TV'=>'TUVALU',
				'UG'=>'UGANDA',
				'UA'=>'UKRAINE',
				'AE'=>'UNITED ARAB EMIRATES',
				'GB'=>'UNITED KINGDOM',
				'US'=>'UNITED STATES',
				'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS',
				'UY'=>'URUGUAY',
				'UZ'=>'UZBEKISTAN',
				'VU'=>'VANUATU',
				'VE'=>'VENEZUELA',
				'VN'=>'VIET NAM',
				'VG'=>'VIRGIN ISLANDS, BRITISH',
				'VI'=>'VIRGIN ISLANDS, U.S.',
				'WF'=>'WALLIS AND FUTUNA',
				'EH'=>'WESTERN SAHARA',
				'YE'=>'YEMEN',
				'YU'=>'YUGOSLAVIA',
				'ZM'=>'ZAMBIA',
				'ZW'=>'ZIMBABWE'			
			),
			'multiple' => false,						// select multiple values, optional. Default is false.
			'std' => array('GB'),						// default value, can be string (single value) or array (for both single and multiple values)
		),
		array(
			'name' => __( 'Account Manager', 'uwpcrm' ),
			'id' => $prefix . 'account_manager',
			'type' => 'users',							// lists users
			'options' => array(
				'role' => 'Administrator',				// Role to look for
				'type' => 'select',						// how to show users? 'select' (default) or 'checkbox_list'
				'args' => array()						// arguments to query users, see http://goo.gl/tkq5o
			),
			'desc' => __( 'Choose A User as the account manager', 'uwpcrm' )
		)			
	)
);

//Meta Boxes for Service
$meta_boxes[] = array(
	'id' => 'service_info',						// meta box id, unique per meta box
	'title' => __( 'Service Information', 'uwpcrm' ),			// meta box title
	'pages' => array('service'),				// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => __( 'Account', 'uwpcrm' ),
			'id' => $prefix . 'service_account',
			'type' => 'posts',							// lists users
			'options' => array(
				'post_type' => 'account',				// Role to look for
				'type' => 'select',						// how to show users? 'select' (default) or 'checkbox_list'
				'args' => array()						// arguments to query users, see http://goo.gl/tkq5o
			),
			'desc' => __( 'Choose an account', 'uwpcrm' )
		)			
	)
);

foreach ( $meta_boxes as $meta_box ) {
	new UWPCRM_Meta_Box_Mojowill( $meta_box );
}

/********************* END DEFINITION OF META BOXES ***********************/

/********************* BEGIN VALIDATION ***********************/

/**
 * Validation class
 * Define ALL validation methods inside this class
 * Use the names of these methods in the definition of meta boxes (key 'validate_func' of each field)
 */
class UWPCRM_Meta_Box_Validate {
	function check_name($text) {
		if ( $text == 'Anh Tran' ) {
			return 'He is Rilwis';
		}
		return $text;
	}
}

/********************* END VALIDATION ***********************/
?>