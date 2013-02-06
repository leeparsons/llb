<?php
/*
 *  Template Name: Launch Party SubPage
 */
    if (!session_id()) {
        session_start();
    }


        
        get_header(); 
        
        ?><section class="col1"><?php
            if (have_posts()) {
                while ( have_posts() ) {
                    
                    
                    the_post();
                    
                    
                    get_template_part( 'content', 'page' );
                    
                    get_template_part('social-links', true);
                    comments_template();
                    
                }
            }
            ?></section><?php
                
                
       
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
/*]]>*/</script>
<?php
    get_footer();