<?php
/*
Plugin Name: SendGrid by Jannes & Mannes
Plugin URI: https://bitbucket.org/jannesenmannes/sendgrid-email-delivery-simplified/
Description: Email Delivery. Simplified. SendGrid's cloud-based email infrastructure relieves businesses of the cost and complexity of maintaining custom email systems. SendGrid provides reliable delivery, scalability and real-time analytics along with flexible APIs that make custom integration a breeze.
Version: 2.0.0
Author: Jannes & Mannes
Author URI: https://jannesmannes.nl
Text Domain: sendgrid-email-delivery-simplified
License: GPLv2
*/

require_once plugin_dir_path( __FILE__ ) . 'vendor/smtpapi-php/Smtpapi/Header.php';
require_once plugin_dir_path( __FILE__ ) . 'vendor/sendgrid-php/SendGrid/Email.php';
require_once plugin_dir_path( __FILE__ ) . 'vendor/is_mail.php';

// SendGrid configurations
define( 'SENDGRID_CATEGORY', 'wp_sendgrid_plugin' );
define( 'SENDGRID_PLUGIN_SETTINGS', 'settings_page_sendgrid-settings' );

if ( version_compare( phpversion(), '5.6.0', '<' ) ) {
  add_action( 'admin_notices', 'php_version_error' );

  /**
  * Display the notice if PHP version is lower than plugin need
  *
  * return void
  */
  function php_version_error()
  {
    echo '<div class="error"><p>' . __('SendGrid: Plugin requires PHP >= 5.6.0.') . '</p></div>';
  }

  return;
}

if ( function_exists('wp_mail') )
{
  /**
   * wp_mail has been declared by another process or plugin, so you won't be able to use SENDGRID until the problem is solved.
   */
  add_action( 'admin_notices', 'wp_mail_already_declared_notice' );

  /**
  * Display the notice that wp_mail function was declared by another plugin
  *
  * return void
  */
  function wp_mail_already_declared_notice()
  {
    echo '<div class="error"><p>' . __( 'SendGrid: wp_mail has been declared by another process or plugin, so you won\'t be able to use SendGrid until the conflict is solved.' ) . '</p></div>';
  }

  return;
}

// Load plugin files
require_once plugin_dir_path( __FILE__ ) . 'lib/class-sendgrid-tools.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/class-sendgrid-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/class-sendgrid-mc-optin.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/sendgrid/sendgrid-wp-mail.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/class-sendgrid-virtual-pages.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/class-sendgrid-filters.php';


// Initialize SendGrid Settings
new Sendgrid_Settings( plugin_basename( __FILE__ ) );

// Initialize SendGrid Filters
new Sendgrid_Filters();
