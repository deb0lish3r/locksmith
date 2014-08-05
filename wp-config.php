<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'a1loc142_wp696');

/** MySQL database username */
define('DB_USER', 'a1loc142_wp696');

/** MySQL database password */
define('DB_PASSWORD', '22v2.P36-S');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'qilrr8gwslcfokfvuehj9ok2rigrccr1w8ubmsea8zhbufyayyh94jfxoesaq8gz');
define('SECURE_AUTH_KEY',  'j5rehvhlt9zfk6rde7r7j1jcmxrrea9ekeobjutopll4isczwdkdae4w4fsn7vsv');
define('LOGGED_IN_KEY',    'cp7ggr3n7fpmrfhmhbwpyawpij937lruqeoycdx9svaqjvumgcn4lwtwb0s78osk');
define('NONCE_KEY',        'jymah7mvn8rgkxi59nwbbwahze6tclj8loy4lfzeddu1uodxajur8nlm8wp7420y');
define('AUTH_SALT',        'phgxvxozr5ixptxc2zeikk5utnlwpdqu7fxbqbrwn5rxvwbok3idx1w3viavhvqc');
define('SECURE_AUTH_SALT', 'tqzcrysy6sydrbajcxwlg3u38rslmfqtvhttdrkfv3hp19avvacxiqahfjigh49i');
define('LOGGED_IN_SALT',   '1xuelc4mvh6gckzhsiobspi3gve5wabplpufl54cpt4rwtdgi8fznvlxruzdfchm');
define('NONCE_SALT',       'ybpmycnik57lxzhbcs5pl3kkwxal9hst7tnn3jsc2brmq8jjqqhvs8kzrc4benjx');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
