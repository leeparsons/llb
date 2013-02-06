<div class="meta meta-excerpt"><?php 
    
    $excerpt = explode(' ', 
                       str_replace(
                                   array('<p>', '</p>'), 
                                   ' ', 
                                   substr(strip_tags(get_the_excerpt(), '<p>,</p>'), 0, 350)
                                   )
                       );
    
    $strlen = 0;
    $str = '';                        
    foreach ($excerpt as $bit) {
        $strlen += strlen($bit) + 1;
        
        if ($strlen > 300) {
            break;
        }
        $str .= ' ' . $bit;
    }
    
    echo $str;
    
    ?></div>
<a href="<?php the_permalink() ?>" class="meta meta-readmore">read more</a>