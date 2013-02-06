<?php
    remove_action('wp_head', 'wp_generator'); 
    
    function love_excerpt($text = '') {
        $rawText = $text;
        if ($text == '') {
            
            $text = get_the_content('');
            $text = strip_shortcodes($text);
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', '&gt;', $text);
        
            $text = strip_tags(nl2br($text), '<br>');
            $words = preg_split("/[\n\r\t ]+/", $text, 150 + 1, PREG_SPLIT_NO_EMPTY);
            
            if (count($words) > 0) {
                array_pop($words);
                $text = implode(' ', $words);
            } else {
                $text = implode(' ', $words);
            }
            
            
            $strippedText = str_replace(
                                        array(
                                              '&nbsp;',
                                              '&#8217;',
                                              '&#8211;',
                                              ' '
                                              ),
                                        '',
                                        $text
                                        );
            
            $posOfLastLineBreak = strpos(strrev($strippedText), '>/ rb<');
            
            
            
            if ($posOfLastLineBreak  - strlen($strippedText) < 45) {
                $text = strrev(substr(strrev($text), strpos(strrev($text), '>/ rb<')));
            }
            unset($words);
        
        } else {
            $text = '<div class="custom-excerpt"><p>' . nl2br($text) . '</p></div>';
        }
        $text = $text . '<a href="' . get_permalink() . '">[read more]</a>';

        

        
        return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
    }
    remove_filter('get_the_excerpt', 'wp_trim_excerpt');
    add_filter('get_the_excerpt', 'love_excerpt');
    
    function section() {
        $browser = $_SERVER['HTTP_USER_AGENT'];  
        
        
        if (strpos($browser, 'MSIE 7') > 0) {
            return 'div';
        } else {
            return 'section';        
        }
    }
    
    
    function article() {
        $browser = $_SERVER['HTTP_USER_AGENT'];  
        
        
        if (strpos($browser, 'MSIE 7') > 0) {
            return 'div';
        } else {
            return 'article';        
        }
    }
    
    function mySearchFilter($query) {
        if ($query->is_search) {
            $query->set('post_type', 'post');
        }
        return $query;
    }
    
    add_filter('pre_get_posts','mySearchFilter');
    
    function love_image_cache($cachePrefix = 'large-cache-', $cacheWidth = 600, $imgClass = '', $asLink = false, $class = '', $textToDisplay = '', $file = '', $squareCrop = false, $justSrc = false) {
        if ($file == '') {
            if (!$atts = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail_name')) {
                return '';
            }

        } else {
            $atts[0] = $file;
            list($atts[1], $atts[2]) = getimagesize($file);
        }
        $thumb = strrev($atts[0]);

        //get the file name:
        
        $fileName = strrev(substr($thumb, 0, strpos($thumb, '/')));
        
        $basePath = str_replace(get_bloginfo('url') . '/wp-content', '', str_replace($fileName, '', strrev($thumb)));
        
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/wp-content' . $basePath;
        
        
        //get the cachePath:
        $cachePath = $_SERVER['DOCUMENT_ROOT'] . '/cache' . $basePath;
        $cacheFile = $cachePath . $cachePrefix . '-' . get_the_ID() . '-' . $cacheWidth .'-' . $fileName;
        
        
        
        $newWidth = $cacheWidth;
        //see if the width is greater than 600?
        $startX = 0;
        $startY = 0;

        if ($atts[1] != $cacheWidth) {
            
            
            //need to determine if we're cropping
            
            //crop width automatically if it's larger than the current width:
            
            if ($atts[1] > $cacheWidth) {
                if ($squareCrop === true) {
                    
                    $int_width = 0;
                    $int_height = 0;
                    
                    $adjusted_height = $cacheWidth;
                    $adjusted_width = $cacheWidth;
                    
                    $width_old = $atts[1];
                    $height_old = $atts[2];
                    $wm = $width_old/$adjusted_width;
                    $hm = $height_old/$adjusted_height;
                    $h_height = $adjusted_height/2;
                    $w_height = $adjusted_width/2;
                    
                    $ratio = $adjusted_width/$adjusted_height;
                    $old_img_ratio = $width_old/$height_old;
                    
					if ($old_img_ratio > $ratio) 
					{
						$adjusted_width = $width_old / $hm;
						$half_width = $adjusted_width / 2;
						$int_width = $half_width - $w_height;
					} 
					else if($old_img_ratio <= $ratio) 
					{
						$adjusted_height = $height_old / $wm;
						$half_height = $adjusted_height / 2;
						$int_height = $half_height - $h_height;
					}
                
                    $newHeight = $cacheWidth;
                    $newWidth = $cacheWidth;
                    $startY = 0;
                    $startX = 0;
                
                } else {
                    $sourceWidth = $atts[1];
                    $sourceHeight = $atts[2];
                    $newHeight = $atts[2] * ($newWidth / $atts[1]);
                }
                
            } else {
                //resize!
                $newHeight = $atts[2] * ($newWidth / $atts[1]);
                $sourceWidth = $atts[1];
                $sourceHeight = $atts[2];
            }
        } else {
            $newHeight = $atts[2];                
            $sourceWidth = $atts[1];
            $sourceHeight = $atts[2];
        }
        
        
    
        
        $useCacheImage = false;
        $createImage = true;     

        if (!file_exists($cachePath)) {
            if (@mkdir($cachePath, 0777, true)) {
                @chmod($cachePath, 0777);
            } else {
                $createImage = false;
            }
        } elseif (!file_exists($cacheFile)) {
            $createImage = true;
        } else {
            $useCacheImage = true;
            $createImage = false;
        }
        
        
        if ($createImage === true) {
            //now copy the image!
            $useCacheImage = true;
            $src = imagecreatefromjpeg($filePath . $fileName);
            if ($squareCrop === false) {
                $dst = imagecreatetruecolor($newWidth, $newHeight);
            } else {
                $dst = imagecreatetruecolor($cacheWidth, $cacheWidth);
            }
            
            if ($squareCrop) {
               imagecopyresampled($dst, $src, -$old_width/4, 0, 0, 0, $adjusted_width, $adjusted_height, $width_old, $height_old);
            } else {
                imagecopyresampled($dst, $src, $startX, $startY, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
            }
            if (!imagejpeg($dst, $cacheFile, 100)) {
                $useCacheImage = false;
            }
            
            imagedestroy($dst);
            imagedestroy($src);
            
        } 
        
        if ($asLink === true) {
            ?><a href="<?php the_permalink(); ?>" class="<?php echo $class; ?>"><?php
                
                if ($textToDisplay != '') {
                    ?><span><?php echo $textToDisplay; ?></span><?php
                }
                
        }

        if ($useCacheImage === true) {
if ($justSrc === true) {
echo 'http://www.loveluxeblog.com' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $cacheFile);
} else {
            echo '<img width="' . $newWidth . '" height="' . $newHeight . '" src="' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $cacheFile) . '" alt="' . get_the_title() . '" class="wp-post-image ' . $imgClass . '" />';
}
        } else {
            the_post_thumbnail('large');
        }
        unset($atts);
     
        if ($asLink === true) {
            echo '</a>';
        }
        
    }
    
                        
                        
                        
/**
 * Tell WordPress to run twentyeleven_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'twentyeleven_setup' );

if ( ! function_exists( 'twentyeleven_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyeleven_setup() in a child theme, add your own twentyeleven_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_setup() {

	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	//add_editor_style();

	// Load up our theme options page and related code.
	//require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	//require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentyeleven' ) );

	// Add support for a variety of post formats
	//add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// Add support for custom backgrounds
	//add_custom_background();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );



	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.

	add_image_size( 'small-feature', 500, 300 ); // Used for featured posts if a large-feature doesn't exist
}
endif; // twentyeleven_setup

	
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function twentyeleven_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyeleven_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

	//register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => 'Adverts Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'As featured In Sidebar',
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the optional Showcase Template', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'twentyeleven_widgets_init' );

if ( ! function_exists( 'twentyeleven_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function twentyeleven_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // twentyeleven_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentyeleven_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'twentyeleven_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyeleven_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<section class="comment-meta">
				<div class="comment-author vcard">
					<?php
                        
/*                        
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );
*/
                        if (userphoto_exists($comment->user_id)) {
                            userphoto_comment_author_thumbnail('', '', array('width'    =>  40, 'height'    =>  40));
                        } else {
                            
                            $avatar_size = 40;
                            if ( '0' != $comment->comment_parent )
                                $avatar_size = 40;
                            
                            echo get_avatar( $comment, $avatar_size );                            
                        }
                        
                        echo '<div class="fl"><div class="ctext">';
                        //see if the user_id is set?
                        if ((int)$comment->user_id > 0) {                        
                            

                            $u = get_usermeta($comment->user_id);
                            if (is_array($u) && !empty($u)) {
                                
                                if (isset($u[2]) && $u[2] != '') {
                                    $name = $u[2];
                                    $cont = true;
                                } elseif (isset($u[0]) && $u[0] != '') {
                                    $name = $u[0];
                                    if (isset($u[2]) && $u[2] != '') {
                                        $name .= ' ' . $u[2];
                                    }
                                    $cont = true;
                                } else {
                                    $cont = false;
                                }
                                
                            }
                            
                            if ($cont === true) {
                                /* translators: 1: comment author, 2: date and time */
                                printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
                                       sprintf( '<span class="fn">%s</span>', '<a href="' . get_author_posts_url( $comment->user_id) . '">' . $name . '</a>' ),
                                       sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                               esc_url( get_comment_link( $comment->comment_ID ) ),
                                               get_comment_time( 'c' ),
                                               /* translators: 1: date, 2: time */
                                               sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
                                               )
                                       );

                            } else {
                                /* translators: 1: comment author, 2: date and time */
                                printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
                                       sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                       sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                               esc_url( get_comment_link( $comment->comment_ID ) ),
                                               get_comment_time( 'c' ),
                                               /* translators: 1: date, 2: time */
                                               sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
                                               )
                                       );    
                            }
                            unset($u);
                            
                        } else {
                            /* translators: 1: comment author, 2: date and time */
                            printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
                                   sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                   sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                           esc_url( get_comment_link( $comment->comment_ID ) ),
                                           get_comment_time( 'c' ),
                                           /* translators: 1: date, 2: time */
                                           sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
                                           )
                                   );
                        }
                        
                        ?></div><div class="ctext"><?php comment_text(); ?></div></div>
					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</section>


			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for twentyeleven_comment()

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'twentyeleven_body_classes' );

