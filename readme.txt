=== Config Email SMTP ===
Contributors: comzeradd
Donate link: https://liberapay.com/comzeradd/donate
Tags: email, smtp
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 0.2.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A simple Wordpress plugin to configure email SMTP preferences using wp-config variables.

== Description ==

This plugin is relying just on your `wp-config.php` file. It uses smtp connection details you will set up there to configure WordPress to relay all outgoing emails through that email server.

= Background =

There are plenty of similar type of plugins out there. Most of them are not focused on relaying emails to an SMTP server, but rather supporting specific mail services.

But the main incentive for this was the fact that the [official Wordpress docker image](https://hub.docker.com/_/wordpress) doesn't have support for sending out emails (eg. "forgot password").

== Installation ==

All you have to do is copy-paste the lines below at your `wp-config.php` and adjust the variables
with the proper values for the SMTP server you want to use.

```
/* SMTP configuration */
define('SMTP_HOST', 'mail.example.com'); // Mail server hostname
define('SMTP_PORT', 25); // SMTP port number (25, 465 or 587)
define('SMTP_SECURE', 'ssl'); // Encryption system to use (ssl or tls)
define('SMTP_USERNAME', 'myusername'); // SMTP Authentication Username
define('SMTP_PASSWORD', 'mypassword'); // SMTP Authentication Password
define('SMTP_FROMMAIL', 'noreply@example.com'); // From email address
define('SMTP_FROMNAME', 'WordPress'); // From email name
```
