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
            ?><div class="hero-wrap"><div id="hero-prev"></div><div id="hero-next"></div><div class="home-heros"><?php

            
                
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
                        
        get_template_part('content-blocks-horizontal');

                        ?><div class="break-whole" style="margin-top:10px"></div><div class="clear" style="margin-bottom:10px;"></div><div class="section-wrap"><section class="col1"><?php

            if (have_posts()) {
                
               // query_posts('offset=5');
                
                while(have_posts()) {
                    the_post();
                    get_template_part('content-excerpt', get_post_format());
                }

                
                ?><nav class="home-pagination pagination"><a href="/archives/">See all posts &raquo;</a></nav><?php
            }
            
            
            
            
            ?></section><?php
                
                
                wp_reset_query();
                
                get_sidebar();
                
                
    get_footer();

