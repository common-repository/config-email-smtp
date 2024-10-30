<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

/**
* @wordpress-plugin
* Plugin Name: Config Email SMTP
* Plugin URI:  https://codeberg.org/comzeradd/config-email-smtp
* Description: Sets email SMTP configuration out of wp-config variables.
* Version:     0.2.0
* Author:      Nikos Roussos
* Author URI:  https://roussos.cc
* Text Domain: config-email-smtp
* License:     GPL v3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

declare(strict_types=1);

namespace CONFIG_EMAIL_SMTP;

//  Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function display_config_email_smtp_page(): void
{
    $title = '<h1>Config Email SMTP</h1>';

    $message = __(
        'A simple Wordpress plugin to configure email SMTP preferences using wp-config variables.<br>
        All you have to do is copy-paste the lines below at your <code>wp-config.php</code> and adjust
        the variables with the proper values for the SMTP server you want to use.',
        'config-email-smtp'
    );

    $help_text = '<div class="card">
        /* SMTP configuration */<br>
        define(\'SMTP_HOST\', \'smtp.example.com\'); // Mail server hostname<br>
        define(\'SMTP_PORT\', 25); // SMTP port number (25, 465 or 587)<br>
        define(\'SMTP_SECURE\', \'ssl\'); // Encryption system to use (ssl or tls)<br>
        define(\'SMTP_USERNAME\', \'myusername\'); // SMTP Authentication Username<br>
        define(\'SMTP_PASSWORD\', \'mypassword\'); // SMTP Authentication Password<br>
        define(\'SMTP_FROMMAIL\', \'noreply@example.com\'); // From email address<br>
        define(\'SMTP_FROMNAME\', \'WordPress\'); // From email name<br>
        </div>';

    $allowed_html = array(
        'h1' => array(),
        'div' => array(
            'class' => [],
        ),
        'br' => array()
    );

    echo wp_kses($title . '<div>' . $message . '</div>' . $help_text, $allowed_html);
}

function config_email_smtp_admin_menu(): void
{
    add_menu_page(
        'Config Email SMTP',
        'Config Email SMTP',
        'manage_options',
        'config-email-smtp',
        'CONFIG_EMAIL_SMTP\\display_config_email_smtp_page',
        'dashicons-email',
    );
}

/**
    * Initialize phpmailer.
    *
    * @param object $phpmailer the phpmailer object.
*/
function send_smtp_email(object $phpmailer): void
{
    if (!defined('SMTP_HOST') || !defined('SMTP_FROMMAIL')) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host = SMTP_HOST;
    $phpmailer->Port = defined('SMTP_PORT') ? SMTP_PORT : 25;
    $phpmailer->SMTPSecure = defined('SMTP_SECURE') ? (string) SMTP_SECURE : 'ssl';

    if (defined('SMTP_USERNAME') && !empty(SMTP_USERNAME)) {
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = SMTP_USERNAME;
        $phpmailer->Password = SMTP_PASSWORD;
    }

    $phpmailer->From = SMTP_FROMMAIL;
    $phpmailer->FromName = defined('SMTP_FROMNAME') ? (string) SMTP_FROMNAME : '';
}

if (is_multisite()) {
    add_action('network_admin_menu', 'CONFIG_EMAIL_SMTP\\config_email_smtp_admin_menu');
} else {
    add_action('admin_menu', 'CONFIG_EMAIL_SMTP\\config_email_smtp_admin_menu');
}
add_action('phpmailer_init', 'CONFIG_EMAIL_SMTP\\send_smtp_email');
