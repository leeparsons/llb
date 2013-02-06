<?php
/*
 *  Template Name: Launch Party
 */
    if (!session_id()) {
        session_start();
    }
   // $ch = curl_init('https://stream.twitter.com/1/statuses/filter.json?delimited=length&track=twitterapi');
    

    
   
    /* If access tokens are not available redirect to connect page. 
    if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
        $_SESSION['redirect_me'] = $_SERVER['REQUEST_URI'];
        header('Location: /twitteroauth/clearsessions.php');
        die();
    } else {
        //we need to show the user the ability to login with twitter!
    }
    */
get_header(); 
    
    ?><div class="col1"><section><?php
        
        if (have_posts()) {
            while ( have_posts() ) {
    
                ?><article><header class="article-header"><h1 class="no-link article-title"><?php
                    
                    the_title();
                    
                    ?></h1></header><?php
                
                the_post();
            ?><div class="entry-content"><?php
                the_content();
             
              //  get_template_part('social-links');
                echo '</div></article>';
            }
        }

        //require_once $_SERVER['DOCUMENT_ROOT'] . '/twitteroauth/twitteroauth.php';
        //require_once $_SERVER['DOCUMENT_ROOT'] . '/twitteroauth/config.php';
        
        ?></section><div class="clear-with-margin"></div>
    <section class="twit-feed">
<article><header class="article-header"><h2 class="article-title no-link">Twitter: Latest 10 posts</h2></header>
<?php

    get_template_part('twitter-launch-home-feed');

    
    ?></article>
    </section>
</div><?php
    
    get_sidebar();
    
    get_footer();