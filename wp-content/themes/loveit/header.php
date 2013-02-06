<!DOCTYPE html><?php
//    include_once '/home/loveluxe/public_html/Mobile_Detect.php';
    
//    $MBD = new Mobile_Detect();
//    $isMobile = $MBD->isMobile();
//    unset($MBD);
  
    $isMobile = false;
    $browser = $_SERVER['HTTP_USER_AGENT'];  
    
    $ie7 = stripos($browser, 'MSIE 7');
    $ie6 = stripos($browser, 'MSIE 6');
    $ie8 = stripos($browser, 'MSIE 8');
    $ie9 = stripos($browser, 'MSIE 9');

    $ie = stripos($browser, 'MSIE');
    
  if ($ie) {

    if ($ie6 > 0) {
        ?><html id="ie6" <?php language_attributes(); ?>><?php 
    } elseif ($ie7 > 0) {
        ?><html id="ie7" <?php language_attributes(); ?>><?php
    } elseif ($ie8 > 0) {
        ?><html id="ie8" <?php language_attributes(); ?>><?php
            } else {
                //ie9 or above
                ?><html <?php language_attributes(); ?>><?php
            }
            } else {
                    ?><html <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/"
xmlns:fb="http://www.facebook.com/2008/fbml"><?php
    } 
    
    
    ?>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	wp_title('');    
	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/themes/loveit/style.css" />
<?php
    if ($isMobile === true) {
        ?><meta name="viewport" content="width=device-width" />
<link rel="stylesheet" media="only screen and (max-device-width: 1024px)" href="/wp-content/themes/loveit/ipad.css" type="text/css" />
<link rel="stylesheet" media="only screen and (max-device-width: 480px)" href="/wp-content/themes/loveit/iphone.css" type="text/css" />
<?php  
    }
    
    ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
    
    if ($ie > 0) {
    ?>
<!--[if lt IE 9]>
<script src="/wp-content/themes/loveit/js/html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="stylesheet" href="/wp-content/themes/loveit/ie.css"/>
<?php
    
        if ($ie7 > 0) {
        
            ?><link rel="stylesheet" href="/wp-content/themes/loveit/ie7.css"/><?php
        
        } elseif ($ie8 > 0) {
            ?><link rel="stylesheet" href="/wp-content/themes/loveit/ie8.css"/><?php

        }
    
    }
    ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script><?php
    
    
    
    
    if (is_home()) {
        ?><script type="text/javascript" src="/wp-content/plugins/nextgen-gallery/js/jquery.cycle.all.min.js?ver=2.9995"></script><?php
    } elseif (is_page('loveluxelaunch') || is_page('2700')) {
                        ?><link rel="stylesheet" href="/wp-content/themes/loveit/launch.css" /><?php
    } elseif (is_single()) {

        if (have_posts()) {
while (have_posts()) {
the_post();

          
$content = get_the_content();

$image = array();
// We will search for the src="" in the post content
$regular_expression = '~src="[^"]*"~';
$regular_expression1 = '~<img [^\>]*\ />~';
 
// WE will grab all the images from the post in an array $allpics using preg_match_all
preg_match_all( $regular_expression, $content, $allpics );
 
// Count the number of images found.
$NumberOfPics = count($allpics[0]);
 
 
// Check to see if we have at least 1 image
if ( $NumberOfPics > 0 )
{
 
for ( $i=0; $i < $NumberOfPics ; $i++ )
{           $str1=$allpics[0][$i];
$str1=trim($str1);
$len=strlen($str1);

$image[] = substr_replace(substr($str1,5,$len),"",-1);
}
}
if (!empty($image)) {
foreach ($image as $im) {
echo '<meta property="og:image" content="' . str_replace('"', "'", $im) . '"/>';
}
}
unset($image);

    ?><meta property="og:image" content="<?php 
  

            $atts = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail_name'); 

            
            echo $atts[0];
            ?>"/><meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php 

        echo str_replace(array('"', "\r\n", "\n", '[read more]'), array("'", ' ', ' ', ''), strip_tags(get_the_excerpt())); 

        ?>" /><?php

}
        }
    }


            
    ?>
<link href='http://fonts.googleapis.com/css?family=Amatic+SC:400,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
<?php

    
    /* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
    }
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
    if (!is_user_logged_in()) {
    ?><script type="text/javascript">/*<![CDATA[*/var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-32164851-1']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script');ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();/*]]>*/</script><?php
        
        }
        
        ?></head>
<body <?php body_class(); ?>>
<div class="inner">
<div id="page" class="hfeed">
<header>
            <?php
                
                if (is_home()) {
                
                ?><hgroup><h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-title"><?php echo the_title() . ' - '; bloginfo( 'name' ); ?></a></h1></hgroup>
            <?php
                
                } else {
                
                    
                ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-title"><?php echo the_title() . ' - '; bloginfo( 'name' ); ?></a><?php } ?>
			<nav id="access" role="navigation">
				<span class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></span>
				<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assiged to the primary position is the one used. If none is assigned, the menu with the lowest ID is used. */ ?>
                <?php $cats = wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '',   'menu_class'      => 'menu',  'echo' =>  false));

                    echo substr($cats, 0, strlen($cats) - 5);    
                    ?>
<li class="s"><div style="padding-top:3px" class="fb-like" data-href="http://www.facebook.com/LoveLuxeBlog" data-send="false" data-layout="button_count" data-show-faces="false" data-font="arial"></div></li>
<li class="s"><a href="<?php echo bloginfo('rss2_url'); ?>" class="rss"></a></li>
                <li class="s"><a href="http://twitter.com/LoveLuxeBlog/" class="twitter"></a></li>
                <li class="s"><a href="http://www.facebook.com/LoveLuxeBlog/" class="facebook"></a></li>
                <li class="s"><a href="http://www.pinterest.com/LoveLuxeBlog/" class="pinterest"></a></li>
            </ul>
        </nav>
	</header>
<?php
    if (is_user_logged_in()) {
        ?><div class="logout" style="width:100%;margin:10px; 0;float:left;"><?php wp_loginout(); ?></div><?php
    }

 if (!is_home()) { ?><div class="section-wrap"><?php }