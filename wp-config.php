<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'project' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '&M,0*X`po#{vur*CQe)YR[ ovLHl9M=Y4#4q6E ^,wDf9vk~&/b<Vt|uh%<+Cm$6' );
define( 'SECURE_AUTH_KEY',  'yxH-J@v+=#>YG-8|#H/$8! *r`wkn~T$D^pwgoSZO`sH@Ym;.,.-MB<5FJHQ $l!' );
define( 'LOGGED_IN_KEY',    'u2f *4 BpJ4/q_dyCh`j {Q~X6vHD|^m)TeB]Dp~JvV}xGj-~t`KluMpw=h|o<R=' );
define( 'NONCE_KEY',        'u8hhr_ZlnqjkEoI&UIP@jNawnMEh#Ro?=z,/bkEJoe&JPhnj8[)2q:SjR#S0Hs}4' );
define( 'AUTH_SALT',        'L29>[O9~Ra2e6ikUlNCe8h8H$g9`cJDPcN y<DZbpL?C^$jEakqC8`3vL1[^glU1' );
define( 'SECURE_AUTH_SALT', '9q6 z>;N}Y_TE<!sC@3PMUU(sh{R4k7!^^zBSIgjU<fKs$c<}QHJyrs,j.;FG&ZD' );
define( 'LOGGED_IN_SALT',   '2Bl=8(cq9xI|3RGNg^09uNKwWU?_&EiR<CXW%rz~qC2y.Uxqa3Ot8LOQDT_a#b0}' );
define( 'NONCE_SALT',       'p?f{@Pj9cuIe#k,4 a3<@dQwj;>L>Sx.!-oth+lnF8J`ZO-Du@5&&V/e7>VD&|^(' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
