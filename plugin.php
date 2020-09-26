<?php
/*
Plugin Name: MarketingStarz
Plugin URI: https://www.marketingstarz.com/
Description: MarketingStarz Admin Theme & Settings
Version: 2.0.0
Author: MarketingStarz
Author URI: https://www.marketingstarz.com/
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // exit if accessed directly
}

/// Super Cool Comme nt --- ooohh

///////////////////////////////////////////////////////////////////////////

// enqueue scripts for admin area
function admin_theme_marketingstarz() {
  if ( is_user_logged_in() ) {
    wp_enqueue_style( 'admin_backend_styles', plugin_dir_url( __FILE__ ) . 'style.css', array(), '1.4.3' );
  }
}
add_action( 'admin_enqueue_scripts', 'admin_theme_marketingstarz' );

///////////////////////////////////////////////////////////////////////////

// enqueue scripts for login screen
// function login_scripts_and_styles() {
//  wp_enqueue_style( 'login_scripts_styles', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), '1.4.1' );
// }
// add_action( 'login_enqueue_scripts', 'login_scripts_and_styles' );

///////////////////////////////////////////////////////////////////////////

// remove default dashboard widgets
function remove_dashboard_screens() {

  // wordpress events and news
  remove_meta_box( 'dashboard_primary', get_current_screen(), 'side' );

  // quick draft
  remove_meta_box( 'dashboard_quick_press', get_current_screen(), 'side' );

  // at a glance
  remove_meta_box( 'dashboard_right_now', get_current_screen(), 'normal' );

  // welcome screen
  remove_action( 'welcome_panel', 'wp_welcome_panel' );

}
// remove screens from regular wordpress
add_action( 'wp_dashboard_setup', 'remove_dashboard_screens', 30 );

///////////////////////////////////////////////////////////////////////////

// should credit original source
// http://bit.ly/2EbnOgy
// show last modified date in wordpress for posts
function post_columns_data( $column, $post_id ) {
  switch ( $column ) {
  case 'modified':
    $m_orig   = get_post_field( 'post_modified', $post_id, 'raw' );
    $m_stamp  = strtotime( $m_orig );
    $modified = date('n/j/y @ g:i a', $m_stamp );
      $modr_id  = get_post_meta( $post_id, '_edit_last', true );
      $auth_id  = get_post_field( 'post_author', $post_id, 'raw' );
      $user_id  = !empty( $modr_id ) ? $modr_id : $auth_id;
      $user_info  = get_userdata( $user_id );
      echo '<p class="mod-date">';
      echo '<span>'.$modified.'</span><br />';
      echo 'by <span>'.$user_info->display_name.'</span>';
      echo '</p>';
    break;
  }
}
function post_columns_display( $columns ) {
  $columns['modified'] = 'Last Modified';
  return $columns;
}
add_action ( 'manage_posts_custom_column',  'post_columns_data',10,2);
add_filter ( 'manage_edit-post_columns',  'post_columns_display');

// show last modified date in wordpress for pages
function page_columns_data( $column, $post_id ) {
  switch ( $column ) {
  case 'modified':
    $m_orig   = get_post_field( 'post_modified', $post_id, 'raw' );
    $m_stamp  = strtotime( $m_orig );
    $modified = date('n/j/y @ g:i a', $m_stamp );
      $modr_id  = get_post_meta( $post_id, '_edit_last', true );
      $auth_id  = get_post_field( 'post_author', $post_id, 'raw' );
      $user_id  = !empty( $modr_id ) ? $modr_id : $auth_id;
      $user_info  = get_userdata( $user_id );
      echo '<p class="mod-date">';
      echo '<span>'.$modified.'</span><br />';
      echo 'by <span>'.$user_info->display_name.'</span>';
      echo '</p>';
    break;
  }
}
function page_columns_display( $columns ) {
  $columns['modified'] = 'Last Modified';
  return $columns;
}
add_action ( 'manage_pages_custom_column','page_columns_data',10,2);
add_filter ( 'manage_edit-page_columns','page_columns_display');

////////////////////////////////////////////////////////////////////

function remove_menu_items() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'new-content' );
    $wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'remove_menu_items' );

////////////////////////////////////////////////////////////////////

// Disable auto-update email notifications for plugins.
add_filter( 'auto_plugin_update_send_email', '__return_false' );

// Disable auto-update email notifications for themes.
add_filter( 'auto_theme_update_send_email', '__return_false' );