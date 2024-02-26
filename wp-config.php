<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_procell_ui' );

/** Database username */
define( 'DB_USER', 'wordpress_wts' );

/** Database password */
define( 'DB_PASSWORD', 'W0rdpresstheh3llUar3!1?123' );

/** Database hostname */
define( 'DB_HOST', '192.168.2.55' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '<&WBnzG-r;d6p%QM-Mg?Y[{Yh+(/I.&O},^2x3E~}xD6vn4|~k^T~^eikSca5{V[' );
define( 'SECURE_AUTH_KEY',  '4y-@3:jat1A|M*Vr9^wFdjMyI*# IyZhwJRv{*P:CC56}=(B`ic~8{1&||vHp:]=' );
define( 'LOGGED_IN_KEY',    'axbB>,aF[TIy*F!)#3Yd@P06_&)KS<BC+ni@jIAA4>/)RC4BJ*pw32VSdKTN @^>' );
define( 'NONCE_KEY',        '{4_A*NVI3`MfaoML&BV-UD%a^(rh(|NmK5e*T{ZjQiRou[*.Za?p};bM6v;ne-;,' );
define( 'AUTH_SALT',        '9ap=f2C0(y)xa]P}`ZhpUP6lY8GOn2AB%r(:ZFT#xWN$9U c&U2%_m;HCul:[SVr' );
define( 'SECURE_AUTH_SALT', 'O+e1RWJxzUm1EMgiQT3j ;W$NvAqL-AGD-4W}*Qe=OUHPRgllY9C!9lU1T_ued:t' );
define( 'LOGGED_IN_SALT',   'h]Y]q 75(w5~]^,>SHgKj=,o/wzsh80_+4_mVA<;i bidC0U$d(+62&kyeL-{U86' );
define( 'NONCE_SALT',       'o(XJTzdv)g<y5/]0#WK0LvYQg=t~k?nVuJfAC,i=PzF1ESnK^M`NS$S[<A?O7|s-' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wtswp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
