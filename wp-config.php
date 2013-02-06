<?php
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
    define('DB_NAME', 'loveluxeblog_wp');
    
    /** MySQL database username */
    define('DB_USER', 'root');
    
    /** MySQL database password */
    define('DB_PASSWORD', '');
    
    /** MySQL hostname */
    define('DB_HOST', '127.0.0.1');
    
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
    define('AUTH_KEY',         '11!4N[U*#[7GInh_qMBQLh|Epl,CO-%:Rl7gb;:ZPszUL= z(>YT9(=)/:Xx-14g');
    define('SECURE_AUTH_KEY',  'BJ;S*SvonnhuQE._`bc9|!*>b9ZE*(tWwB- xKZ:}DS}k~~Tegf{iT yDCs+TyR~');
    define('LOGGED_IN_KEY',    '+gWN)-=3!LbtMn].pk{}ISd7%ZIOd-dcU:XYs$%D.G}jZCVM)Ih%L{t$b*7TSAV[');
    define('NONCE_KEY',        '<h}@p.$LWyJgt13Z_gtFSfm^.aSQN-IT(eRD|1E~>Pj[0+,,dB.f<xx3}-cZ#l^j');
    define('AUTH_SALT',        'WtgUY,?NFY ,,.@;g|YIB|IN(-9n7x(K%-j,ZqlGim}LSjy|:WCt]+X+@xViI#CP');
    define('SECURE_AUTH_SALT', '! ~AdO#:HKESYW|j*[`+;Y%Ck}V5*bJvRFGPJ!MyGUAZY?Q`yH1v})!NC?}|QQLK');
    define('LOGGED_IN_SALT',   '3!HiRULy3JdHT3s=wD=H$aT~y!W/a:p+Xl~mO&1Fz;%3]p~6O*R$l2Ir8PpZ=/O@');
    define('NONCE_SALT',       'YVn|yzw)%Ol]|_[c+.,FD`Jfx7&4_eY5DVg07ctxcN a<wBf5K|S+Nxz>BFj[4F$');
    
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
