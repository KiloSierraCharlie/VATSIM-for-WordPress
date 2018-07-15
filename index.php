<?php
/*
    Plugin Name:  VATSIM Content
    Description:  VATSIM Plugin for retrieving and displaying content from the VATSIM network, and it's dedicated platforms.
    Version:      1.0
    Author:       Kieran Samuel Cross, Malte Zwillus
    License:      GNU Affero General Public License 3
    License URI:  https://www.gnu.org/licenses/agpl-3.0.en.html
*/

// Automatically load all shortcodes.
foreach( scandir( dirname(__FILE__) . "/shortcodes" ) as $shortcode ){
    
    if( $shortcode[ 0 ] == "." ){ continue; }
    require( dirname(__FILE__) . "/shortcodes/" . $shortcode );
    
}