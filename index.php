<?php
get_header();
 
get_template_part( 'loop', 'index' );

next_posts_link( __( '&larr; Older posts', 'twentyten' ) );
previous_posts_link( __( 'Newer posts &rarr;', 'twentyten' ) );

get_footer();
?>