<?php
/*
Plugin Name: The Ultimate Wordpress CRM
Plugin URI: http://www.mojowill.com/developer/the-ultimate-wordpress-crm-plugin/
Description: A self contained CRM plugin for Wordpress with modular based extensions.
Version: 0.1
Author: theMojoWill
Author URI: http://www.mojowill.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( 'UWPCRM_ROOT', dirname( __FILE__ ) );

//Include the setup
require_once UWPCRM_ROOT . '/conf/setup.php';

//Global Variables
$uwpcrm_options = get_option( 'uwpcrm_settings');