<?php

get_header(); 
    
    ?><section class="col1"><?php
        if (have_posts()) {
        while ( have_posts() ) {
    
            
            the_post();
            

            get_template_part( 'content', 'page' );


        }
        }
?></section><?php
    
    get_sidebar();
    
    get_footer();