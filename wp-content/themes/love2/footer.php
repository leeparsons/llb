<?php
/**
 * The template for displaying the footer.
 *
 *
 */
?></div></div><div class="go-home"><a id="go-to-top" href="#">to the top</a></div>
</div>
<footer role="contentinfo">
    <div class="f-bg"></div>
    <p class="credit-warning">We have taken all efforts to request permission for all images featured on this site and to link back to the original source. However if we have used your images and you think we have not credited you please let us know as we will rectify it asap, or at your request we can remove the images. Thank you!</p>
    <div class="f-wrap">
        <nav class="f-cats"><h5>Popular Posts</h5><ul><?php
            
            //list only 3 posts!
            wp_reset_query();
            
            $res = $wpdb->get_results("SELECT postid FROM wp_post_views WHERE day >= CURDATE() - INTERVAL 30 DAY ORDER BY views DESC, last_viewed DESC, RAND() LIMIT 6");
            
            if ($res) {
                
                $arr = array();
                foreach ($res as $row) {
                    $arr[] = $row->postid;
                }
                
                query_posts(array('post__in'    =>  $arr));
                unset($arr);
            } else {   
                query_posts(array('showposts' => '3', 'category__not_in'    =>  array(261)));
            }
            unset($res);
            
            $posts = 0;
            while(have_posts()) {
                
                the_post();
                
                if ($image = love_image_cache('small-thumb', 50, 's-tmb', true, 'stack-img', '', '', true, false, false)) {
                    $posts++;
                    ?><li><?php
                        
                    echo $image;
                        
                    ?><a class="link" href="<?php the_permalink() ?>"><?php the_title(); ?></a><?php
                            
                    ?></li><?php
                }
                                
                if ($posts == 5) {
                    break;            
                }
                                
            }
            
            ?></ul></nav>
        <nav class="f-cats"><h5>Recent Posts</h5><ul><?php
            
            wp_reset_query();
            
            query_posts('showposts=10');
            $posts = 0;
            while(have_posts()) {
                    
                the_post();

                if ($image = love_image_cache('small-thumb', 50, 's-tmb', true, 'stack-img', '', '', true, false, false)) {
                    $posts++;
                    ?><li><?php

                    echo $image;

                    ?><a class="link" href="<?php the_permalink() ?>"><?php the_title(); ?></a><?php
                        
                    ?></li><?php
                }

                if ($posts == 5) {
                    break;            
                }
                        
            }
            
            
            ?></ul></nav>
        <nav class="social-nav">
            <a class="pinterest" href="http://www.pinterest.com/LoveLuxeBlog/"></a>
            <a class="facebook" href="http://www.facebook.com/LoveLuxeBlog/"></a>
            <a class="twitter" href="http://twitter.com/LoveLuxeBlog/"></a>
            <a class="rss" href="http://www.loveluxeblog.com/feed/"></a>
        </nav>
        <section class="f-search">
            <?php
                
                get_template_part('searchform-footer');
                
                ?>
            <?php
                
                get_template_part('footer-mailing-list-signup');
                
                ?>
        </section>
    </div>
</footer>
<?php
    wp_reset_query();
    
    ?><script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script><?php

 wp_footer(); ?><script type="text/javascript">/*<![CDATA[*/
pinitRender = function() {
    (function (w, d, load) {
     var script,
     first = d.getElementsByTagName('SCRIPT')[0],  
     n = load.length,
     i = 0,
     go = function () {
     for (i = 0; i < n; i = i + 1) {
     script = d.createElement('SCRIPT');
     script.type = 'text/javascript';
     script.async = true;
     script.src = load[i];
     first.parentNode.insertBefore(script, first);
     }
     }
     if (w.attachEvent) {
     w.attachEvent('onload', go);
     } else {
     w.addEventListener('load', go, false);
     }
     }(window, document,
       ['//assets.pinterest.com/js/pinit.js']
       ));    
}
/*]]>*/</script>
</body>
</html>