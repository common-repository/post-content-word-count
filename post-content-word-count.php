<?php
/**
Plugin Name: Post Content Word Count
Plugin URI: www.rajtechbd.com
Description: This is the wordpress post content word count calculations.
Version: 1.0
Author: Md. Faisal Amir Mostafa
Author URI: www.faisal.rajtechbd.com
License: GPLv3
License URI: https://www.gnu.org/licenses/old-licenses/gpl-3.0.html
Text Domain: rtech
Domain Path: /langusges/
*/

/**
Post Content Word Count is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

Post Content Word Count is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Post Content Word Count.
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

function rtech_load_text_domain(){
    load_textdomain('rtech', false, dirname(__FILE__) . "/languages");
}
add_action('plugins_loaded', 'rtech_load_text_domain');

function rtech_word_count( $content ){
 $stripped_content = strip_tags( $content );
 $wornc = str_word_count( $stripped_content );
 $label = esc_html__('Total Number of Word', 'rtech');
 $label = apply_filters('rtech_heading', $label);
 $tag = apply_filters('rtech_tag', 'h2');
 $content .= sprintf('<%s>%s: %s</%s>',$tag, $label,$wornc, $tag);
    return $content;

}
add_filter("the_content", "rtech_word_count");

function rtech_reading_time( $content ) {
    $stripped_content = strip_tags( $content );
    $wornc = str_word_count( $stripped_content );
    $reading_minite = floor( $wornc / 200 );
    $reading_second = floor( $wornc % 200 / ( 200 / 60 ) );
    $is_visible = apply_filters( 'rtech_display_reading_time', 1 );
    if( $is_visible ){
        $label = __('Total Reading Time', 'rtech');
        $label = apply_filters('rtech_reading_heading', $label);
        $tag = apply_filters('rtech_reading_time_tag', 'h4');
        $content .= sprintf('<%s>%s: %s minutes %s seconds</%s>',$tag, $label,$reading_minite,$reading_second, $tag);
    }
    return $content;
}
add_filter("the_content", "rtech_reading_time");