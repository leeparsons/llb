<?php
    
    if (comments_open()) {
    
    ?><h2 class="entry-title comments-enabled"><a class="title-small" href="<?php the_permalink(); ?>"><?php the_title(); ?></a><a href="<?php the_permalink(); ?>#comments" class="speech-bubble"><?php
    
    
    
    comments_number(0, 1, '%');
    
    
    ?></a></h2><?php
    
    
} else {
    
    ?><h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php                
    
}

