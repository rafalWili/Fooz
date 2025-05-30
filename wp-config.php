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
define( 'DB_NAME', 'fooz' );

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
define( 'AUTH_KEY',         'vqr-L- 3$o,i8XP9Yo:<8d!P`Re%,{,! hZ6!UF-MQ4lOA53z,cqc$]#@+_VD^6e' );
define( 'SECURE_AUTH_KEY',  '03,tL^/d);LNoA/r#5)=I!YQv=Nug)pDmB)eT7 +dr7R1Y3&dy8>r}i*LNe@?_B{' );
define( 'LOGGED_IN_KEY',    '%k]q@z0x`VDhadxEYoSL#*g)W*#W#qI[(0xLI>9GHaauq4+7h]CPG?=AYJc325,_' );
define( 'NONCE_KEY',        '<m!z6/f^:bj2ZBvMon?FEd2$Y7[|J_SUC  h_~8YN]J0sB;VX#6f:4K+hm&^gU=f' );
define( 'AUTH_SALT',        'XD`FqRN21nC0lMm,/`o ]s@T5r =1gmRRLTiBl|K}(bUq&N<VcaV[S^LL l**9QK' );
define( 'SECURE_AUTH_SALT', '0%PAa8iN$o.Vz:Ao2@Bu&w91r9~L}Gb9@J.]^cqCU@vHYS9Uk]JYT!6BWZm>!h 9' );
define( 'LOGGED_IN_SALT',   't:tIV|^ZU8:;mLVj[=^/qci{o2S|@2;X7AHc.!B5cX>F{tO?ktU@]C;Y6g]jG1cf' );
define( 'NONCE_SALT',       'f^.c[O*_A~.8sAsgtWrWjC@j0B:n,a@Pf7vW14vVoI(Z,sdW%?>2fhD<y!64KD!1' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_fz';

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
