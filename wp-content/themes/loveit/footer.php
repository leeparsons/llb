<?php
/**
 * The template for displaying the footer.
 *
 *
 */
?></div><div class="go-home"><a id="go-to-top" href="#">to the top</a></div>
</div>
<footer role="contentinfo">
    <p class="credit-warning">We have taken all efforts to request permission for all images featured on this site and to link back to the original source. However if we have used your images and you think we have not credited you please let us know as we will rectify it asap, or at your request we can remove the images. Thank you!</p>
    <div class="f-wrap">
        <nav><ul class="f-pages"><?php
            
            wp_list_pages(
                          array(
                                'title_li'    =>  '<h5>Pages</h5>'
                                )
                          );
            
            ?></ul></nav>
        <nav><ul class="f-cats">
        <?php
            
            wp_list_categories( 
                               array(
                                     'title_li'    =>  '<h5>Categories</h5>'
                                     )
                               );
            
            ?></ul>
        </nav>
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
</div>
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