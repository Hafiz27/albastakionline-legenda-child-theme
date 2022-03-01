<?php
define( 'WP_CACHE', true ); // Added by WP Rocket


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

 * @link https://codex.wordpress.org/Editing_wp-config.php

 *

 * @package WordPress

 */


// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', "admin_ecraftme" );


/** MySQL database username */

define( 'DB_USER', "admin_ecraftme" );


/** MySQL database password */

define( 'DB_PASSWORD', "Hafizpassword" );


/** MySQL hostname */

define( 'DB_HOST', "localhost" );


/** Database Charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );


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

define('AUTH_KEY',         'SuiIL1LjlJL7iP4GkPMrZoodtNiIRUnYp5vIyTuEFJXdIxbvjJFcFLcZDZgeJyq1');

define('SECURE_AUTH_KEY',  'jm7P5JAVlY5iosObvyOACYZ61M0pyxjoV7kia4P4kVXdaNWaGEAB3vbHXYZLYBCA');

define('LOGGED_IN_KEY',    'OGDTeBj0dRWbJd4WKm33HPDSEvH0ZLTs4JrHERSVz1SIF3R5N21LBSbzMrgJ7AsJ');

define('NONCE_KEY',        'hFbGnHIaKJ4f1ySxzq3RpwVuz254nGUoHeamI4afYAYjTtnZgJu862750JtKAVFi');

define('AUTH_SALT',        'AscUKO0FHxax1fovtrHxQ0tqNXpRjn4VbwqYPmlvtOzWiq6OAdjmOPUz57hkDbx3');

define('SECURE_AUTH_SALT', 'mdTYvQH6631Hy7K4QfP5jewht6VOFt9efgOCnrDSHUqhlgSB8T11uEfOVZCXkIKo');

define('LOGGED_IN_SALT',   'ihIVKyzIJll2LcG3Ydx2GyMCpRs4JGTaENpHwK9lmer3W4z6jfmQlkBaiVOW3Zmj');

define('NONCE_SALT',       'CUnPS4AArpCfNoocRrjDrFp64OfzfChT6LnGKd1ahO8hKXQf0RMefxcKnHk55dy3');


/**

 * Other customizations.

 */

define('FS_METHOD','direct');

define('FS_CHMOD_DIR',0755);

define('FS_CHMOD_FILE',0644);

define( 'WP_TEMP_DIR', '/home/admin/public_html/wp-content/uploads' );


/**

 * Turn off automatic updates since these are managed externally by Installatron.

 * If you remove this define() to re-enable WordPress's automatic background updating

 * then it's advised to disable auto-updating in Installatron.

 */

define( 'AUTOMATIC_UPDATER_DISABLED', true );



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

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress

 */

define( 'WP_DEBUG', true );

define( 'WP_MEMORY_LIMIT', '256M' );

/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', dirname(__FILE__) . '/' );

}


/** Sets up WordPress vars and included files. */

define( 'UPLOADS', 'wp-content/uploads' );

require_once( ABSPATH . 'wp-settings.php' );

