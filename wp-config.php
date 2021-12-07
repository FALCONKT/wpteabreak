<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web hos　 ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'heroku_71454a5130b1d69' );
// define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'b588a4cf626806' );
// define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '6150cd80' );
// define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'us-cdbr-east-04.cleardb.com' );
// define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
// define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
// define( 'DB_COLLATE', '' );


/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

//  初期
// define('AUTH_KEY',         '8tXNfxqJEJmE33M0iaaKxB8whdPVYsFOSQ0eOBAyX63Ax4qqF3otDI2/l2qGd7s2BPg9VZoh/dTEPr6Tka4dsw==');
// define('SECURE_AUTH_KEY',  'G+r2n8R1F1UJ3OPFydmiZGry4cq7sdlHjJGjGcxjiMUFiCeefqVduMU/PYHSkiVZ3HFE+YUUB0lgjm8Q/ZXBfw==');
// define('LOGGED_IN_KEY',    '8qizM2uJIsK4NfUPxD9G5Z17/71BrRMVxpSAdREW5Rp04IJGRZ6A0+AyEEAeju9kNVvjodYgwl84S9I5H+GWiA==');
// define('NONCE_KEY',        'F4oRzHYd6INvgXRayF5hj30boO1BSppp/uRzjpNevPkyp2T9BIuaWjdDyswcZ/KJD6Ds2iydGd2Qs/EPyuA4lQ==');
// define('AUTH_SALT',        '/aO6CEVvQdVkLDEOj3EZFkPYCeAAL1njB7uDGuAyYO+psQLFJ6NFMrDhYHK19zHzOnLFabJn5P4lrPjOYMVs1A==');
// define('SECURE_AUTH_SALT', '8666xUlfsTu6nH6Is32k0NJEfNc6A9c2CP8pmyLhsygB5BPiaCV9gxaV0zK0U/W4RIPmN6K2dEkufemZpHkMCw==');
// define('LOGGED_IN_SALT',   'IyBpsmWM0Fpi6pUBp5naAT1goaQqB7I6xJnVIpqas/61AU8OS6+m31uwuBvspreY35DxOWAOnvPyCRl++UWkIg==');
// define('NONCE_SALT',       'XqkirJny9SCOlTY5IfAUIYTlmh1v/NxX3i8WEqwfB7JkdlmYIOKNvKdV25y8N831KfGxRrxB/8oh9wH1C1xlhA==');


define('AUTH_KEY',         '0dvE(-yx<Ou)[5iuF>>nNIeRBZ:bT:dW&91L96(c`WKX[:Fc*JE-Zx9ZJ-%XA(z`');
define('SECURE_AUTH_KEY',  'e{6!*s@]s3e16t>5}i-bh*s!+@2PoThjBB_mF-y81`ea#KOf|?(|iVgpom~@AB3I');
define('LOGGED_IN_KEY',    'cw#D/w85Py` x[=3Tor9iDWc;5tEvJc9051P@E>K|}7HP![Jc{po>{bMJx2NcN:R');
define('NONCE_KEY',        '|d@5r1Fa{Op2*KP(_<Big:1dQlLax+@-k0Ux8EoS?=_;:)BcBp-G8j}=`o:k|N-|');
define('AUTH_SALT',        'WVS^:|*N%A,;?Q(zE`tf<$NS&Nyshmct#X7cu:NlDJ^XXE#e+d#XHd#!<C35d$22');
define('SECURE_AUTH_SALT', 'zF(+t2X|,yq_Sh}4+t5k7`3-f`~_o9fCn`AQmkD,b(D||73-cU]QT4bzy;D7mf9/');
define('LOGGED_IN_SALT',   '+Tv|%@th>dPvC2HDt5rZ}P|=^Lia^rZ *F-g[eviIu-/<CyuEzI5s!`bE%ji|moa');
define('NONCE_SALT',       '(WwQPRi!]j|8stU7+!NUGeOemQnq1!Jx)Yb+}tUqJ[mZN?+2:~Qt d5#.nV^g)>N');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
