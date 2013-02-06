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
                    
                ?><div class="entry-content"><article><header><h1 class="section-title"><span><?php
                    
                    the_title();
                    
                    ?></span><span class="stripe"></span></h1></header><?php
                
                the_post();
            ?><?php
                the_content();
             
              //  get_template_part('social-links');
                ?></article></div><?php
            }
        }

        //require_once $_SERVER['DOCUMENT_ROOT'] . '/twitteroauth/twitteroauth.php';
        //require_once $_SERVER['DOCUMENT_ROOT'] . '/twitteroauth/config.php';
        
        ?></section><div class="clear-with-margin"></div><?php
            wp_reset_query();
    query_posts(
                array(
                      'cat'         =>  261,
                      'posts_per_page'  =>  1
                      )
                );
    
    if (have_posts()) {
    ?><section><?php

        while (have_posts()) {
        
            the_post();
            
            ?><article><header><h2 class="section-title"><span>Latest Post</span><span class="stripe"></span></h2></header><?php

                
                
                /*
            if (get_the_title() != '') {
                
                the_title();
            }
                 */
                ?><div class="entry-content"><?php
                the_content();
                ?></div><?php
            ?></article><?php
        }
    
?></section><?php
    
    }


?><div class="clear-with-margin"></div>
    <section class="twit-feed">
        <?php
            

            
            
    get_template_part('twitter-launch-home-feed');

            
    
    ?>
    </section>
    <section>
    <?php
        
        //get list of posts in the launch category
        
        wp_reset_query();
        
        query_posts(
                    array(
//                          'cat'     =>  261,
                          'offset'  =>  0
                          )
                    );
        
        if (have_posts()) {
            
            ?><header><h3 class="section-title"><span>Older Posts</span><span class="stripe"></span></h3></header><?php
            
            while (have_posts()) {
                
                the_post();

                ?><article><header><h3 class="section-title"><span><?php the_title(); ?></span><span class="stripe"></span></h3></header><?php
                    
                    
                    
                    /*
                     if (get_the_title() != '') {
                     
                     the_title();
                     }
                     */
                    ?><div class="entry-content"><?php
                        the_content();
                        ?></div><?php
                            ?></article><?php
                
                
            }
            
            
        }
        
        wp_reset_query();
        
        ?>
    </section>
<script type="text/javascript">/*<![CDATA[*/!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");/*]]>*/</script>
</div>
<?php
    
    get_sidebar('launch');
    ?><div id="fb-root"></div>
<script type="text/javascript">/*<![CDATA[*/
window.fbAsyncInit = function() {
    FB.init({appId: '259581140813728', status: true, cookie: true,xfbml: true});
    FB.Event.subscribe('edge.create', function(url) {
                       _gaq.push(['_trackSocial', 'facebook', 'like', url]);
                       });
    FB.Event.subscribe('edge.remove', function(url) {
                       _gaq.push(['_trackSocial', 'facebook', 'unlike', url]);
                       });
};
(function() {
 var e = document.createElement('script'); e.async = true;
 e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
 document.getElementById('fb-root').appendChild(e);
 }());
/*]]>*/</script><?php
    get_footer();