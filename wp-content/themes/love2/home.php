<?php
    /**
     * The main template file.
     *
     */

    get_header(); 

    query_posts(
                array(
                      'category__not_in'    =>  array(261)
                      )
                );
        
    //list the first five posts!
    if (have_posts()) {
        ?><div class="hero-wrap"><div class="home-heros"><?php

        $homeHeros = (int)0;
                
        while (have_posts()) {
            $homeHeros++;
            the_post();            
            get_template_part( 'content-home', get_post_format() );

        }           
                
        ?></div></div><?php
                
        if ($homeHeros > 1) {
            ?><script type="text/javascript">/*<![CDATA[*/$(document).ready(function() {$('.home-heros').cycle({fx:'fade',prev:'#hero-prev',next:'#hero-next'});}).find('.hero').css({cursor:'pointer'}).click(function() {window.location = $(this).find('a').eq(0).prop('href');});/*]]>*/</script><?php
        }
    }

    if (have_posts()) {
                /*
        
        
        ?><div class="wide-section">
            <h2 class="section-title"><span>Popular Posts</span><span class="stripe"></span></h2>
            <div class="wide-wrap"><?php
        
                //list only 3 posts!
                wp_reset_query();
                        
                $res = $wpdb->get_results("SELECT DISTINCT(postid), SUM(views) AS v FROM wp_post_views AS vw
                                                                                    
                                          WHERE day >= CURDATE() - INTERVAL 30 DAY 
                                          
                                          
                                          ORDER BY v DESC, last_viewed DESC, RAND()  
                                          
                                          LIMIT 12");

                
                
                if ($res) {
                    
                    
                    
                    $arr = array();
                    foreach ($res as $row) {
                        $arr[] = $row->postid;
                    }
                    
                    //randomly sort this array!
                    shuffle($arr);
                    $arr = array_chunk($arr, 3);


                    
                    query_posts(array('post__in'    =>  $arr[0]));
                    unset($arr);
                } else {   
                    query_posts(array('showposts' => '3', 'category__not_in'    =>  array(261)));    
                }
                unset($res);
                
                while(have_posts()) {
                ?><div class="span3"><?php
                    the_post();
                    get_template_part('content-popular-excerpt', get_post_format());
                ?></div><?php
                }
            

                ?>
                <nav class="home-pagination pagination"><a href="/archives/">See all posts &raquo;</a></nav>
            </div>
        </div>
<?php
            
            */
    }
    wp_reset_query();
 
           
    $cat_arr = array(921, 924);
    
    include locate_template('homepage-2col-posts.php');
    
                
            
    ?><div class="wide-section">
            <h2 class="section-title"><span>Latest Video</span><span class="stripe"></span></h2>
            <div class="wide-wrap tc">
                <iframe width="658" height="369" style="margin:auto;border:0;" src="http://www.youtube-nocookie.com/embed/videoseries?list=UUt2hkAdH-yzARfjn4BCWUog"></iframe>
            </div>
        </div><?php
        
    $cat_arr = array(927, 928);
    
    include locate_template('homepage-2col-posts.php');

    $cat_arr = array(934);
            
    include locate_template('homepage-1col-posts.php');

    $cat_arr = array(940, 943);
            
    include locate_template('homepage-2col-posts.php');

        
    wp_reset_query();
             
        
    get_sidebar();
        
    get_footer();
