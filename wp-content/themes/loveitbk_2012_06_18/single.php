<?php

get_header(); 
		?><section class="col1">

				<?php
                    
                    while ( have_posts() ) : 
                    
                    
                    the_post();


                    get_template_part( 'content', 'single' );

                    comments_template();
    
                    previous_post_link('<div class="prev-link">Previous Post:<br /><br/>%link</div>');
            
            

                    next_post_link('<div class="next-link">Next Post:<br /><br/>%link</div>');
        

                    

                    endwhile;
?>        
        </section>
<?php
    
    get_sidebar();
    get_footer();