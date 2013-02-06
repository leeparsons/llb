<?php
    
    if (get_post_type() == 'post' && comments_open()) {
        
        ?><h1 class="entry-title comments-enabled no-link no-search"><?php the_title(); ?><a href="<?php the_permalink(); ?>#comments" class="speech-bubble"><?php
            
            
            
            comments_number(0, 1, '%');
            
            
            ?></a></h1><?php
                
                
                } else {
                    
                    ?><h1 class="entry-title no-link no-search"><?php the_title(); ?></h1><?php                
                        
                        }

?>