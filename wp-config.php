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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'premierdental' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'q;RU~-1j_e_3_gs@=F.jEDrI1)}C^TjR$}P7/>E1<o;N7ShKul(lKH)HZ];rn=_G' );
define( 'SECURE_AUTH_KEY',  'aPGRF,]14;q-ckE-QuNkn@4TV(>}3T`xxlvWs7sAY+=*yv#C!ba7%Y2rskrf#gR=' );
define( 'LOGGED_IN_KEY',    'H{Z*j8LUzy``o<.e1_!A^P^hIDFQZ6/rS^UzuaN2q?jsM29MBvdv ?gIA6[mr;6`' );
define( 'NONCE_KEY',        'E~;~5O?^@O/@`%1*>XlDOB]L5Q)rSZXN75jBFT#9^2_]$b?4x~+0X0E4uT8Ifp:l' );
define( 'AUTH_SALT',        'mK9#/WE$]Q?Z-+CDn%kx/cd[`DsH=Gd5%X?OY>PO0Apv~z~Zf 4[o=SJ+n:,`[|p' );
define( 'SECURE_AUTH_SALT', '6XGd;/l)^V+C=W@JIe`P?e=aYoGoE5e8%!lk`C*RYL2W8KXNzN`WZZ?wnr]7ur/H' );
define( 'LOGGED_IN_SALT',   'A*<ggeJ*zS+^+m_R88_tfe4R4z=kQQZRI!69.Los~tLe4eOhP{@:0z,{L0![QBG9' );
define( 'NONCE_SALT',       'F!6d=86<j;sX@0-5gfP?Ad0G~Weeij&Ky1Z@R26snB`Fcc5A>l=zPy|X5K_Zg|Vo' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
