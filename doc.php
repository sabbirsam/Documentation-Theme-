<?php 
/**
 * Documentation
 */

 /**
  * Beganing
  */
/*
1. Theme name folder 
2. markup 
3. style.css and use all header part. 
4. functions.php
5. index.php


*/



/**
 * Style.css======================================================================================================================================================
 */
/*
Theme Name: 
Theme URI: 
Author: Sabbir Ahmed
Author URI: 
Description:
Requires at least: 4.9.6
Requires PHP: 5.2.4
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: 
Tags: one-column, flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, rtl-language-support

*/


/**
 * Functions.php======================================================================================================================================================
 */

/**
 * Require once
 */
require_once(get_theme_file_path( "/Inc/tgm.php" ));
require_once(get_theme_file_path( "/Inc/attachments.php" ));
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Text Domain
 */
if( site_url() == "http://localhost/sam/Theme_1/"){
    define( "VERSION" , time());
}else{
    define( "VERSION" , wp_get_theme()->get( "VERSION" ));
}
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * After setup Theme
 */
function philosophy_theme_setup(){
    load_theme_textdomain( "philosophy" );
    
    add_theme_support( "post-thumbnails" );
    
    add_theme_support( "title-tag" );

    add_theme_support( "automatic-feed-links" );

    add_theme_support( 'html5', array( 'search-form','comment-list','comment-form','gallery', 'caption' ) );

    add_theme_support( "post-formats", array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat') );

    add_theme_support( "custom-logo" );

    add_editor_style( "/assets/css/editor-style.css" );  

    register_nav_menu( "topmenu", __("Top Menu", "philosophy") );

    add_image_size( "philosophy-home-square", 400, 400, true );

}
add_action( "after_setup_theme", "philosophy_theme_setup");
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Asset 
 */
function philosophy_assets(){
    // css which is included on base.css:
    wp_enqueue_style( "fontawesome-css",get_theme_file_uri( '/assets/css/font-awesome/css/font-awesome.css' ),null,1.0); //handle | location | dependency | version | footer load 

    wp_enqueue_style( "philosophy-css",get_stylesheet_uri(), null, VERSION ); // add main css

     wp_enqueue_script( "philosophy-main-js",get_theme_file_uri( "/assets/js/custom.js" ), array("jquery"), 1.0, true ); 
 

}
 add_action( "wp_enqueue_scripts", "philosophy_assets" );
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * index.html
 */
language_attributes();

wp_head(); //remove upper and set

// image set 
echo get_template_directory_uri();
// /assets/

 wp_footer(); //remoce all js file from bottom and set
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


 /**
  * Widget
  */
// call 
if(is_active_sidebar( "contact_page" )){
    dynamic_sidebar( "contact_page" );
}

// f: 
function philosophy_about_widget() {

    register_sidebar( array(
        'name'          => __( 'About Page','philosophy' ),
        'id'            => 'about_page',
        'description'   => 'Sidebar displaying in About Page.',
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Contact Page','philosophy' ),
        'id'            => 'contact_page',
        'description'   => 'Sidebar displaying in Contact Page.',
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );

}

add_action( 'widgets_init', 'philosophy_about_widget' );

// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * images set 
 */

echo get_template_directory_uri();
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * header and footer seperator 
 */

//  header.php  
get_header();

// end 

//  footer.php
get_footer(); 
//  end ---------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Search Forom
 */
// call:
get_search_form();

// f: 
function philosophy_search_form($form){

    $newform=<<<FORM

    //here template
FORM;

return $newform;

}
add_filter( "get_search_form", "philosophy_search_form" );
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * acf used as a sortcode
 */
if(get_field("contact_form_shortcode")){
    echo do_shortcode(get_field("contact_form_shortcode"));
}
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Pagination
 */
// call 
philosophy_pagination(); 

// f: 
function philosophy_pagination(){
    global $wp_query;
    $links=  paginate_links( array(
       'current' => max(1,get_query_var( 'paged' )),
       'total' => $wp_query->max_num_pages,
       'type' => 'list',
       'mid_size'=>3
    ) );

    $links = str_replace("page-numbers","pgn__num" ,$links);
    $links = str_replace("<ul class='pgn__num'>","<ul>" ,$links);

    $links = str_replace("next pgn__num","pgn__next" ,$links);
    $links = str_replace("prev pgn__num","pgn__prev" ,$links);
    echo $links;
}

// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * comment List/List of comment  
*/
// call 
wp_list_comments( 'type=comment&callback=mytheme_comment' );

//f:
function mytheme_comment($comment, $args, $depth) {

    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>

    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>
    

            <div class="comment__avatar">
                <?php 
                    if ( $args['avatar_size'] != 0 ) {
                        echo get_avatar( $comment, $args['avatar_size'] ); 
                    } 
                    ?>
             </div>
             <div class="comment__content">
                <div class="comment__info">
                    <?php
                        printf( __( '<cite class="fn">%s</cite> <span class="says"> </span>' ), get_comment_author_link() ); 
                    ?>
                </div>
            </div>
        <?php 
        if ( $comment->comment_approved == '0' ) { ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/><?php 
        } ?>
        <div class="comment-meta commentmetadata">
            <time class="comment__time">
            
                <?php
                    /* translators: 1: date, 2: time */
                    printf( 
                        // __('%1$s at %2$s'), 
                        get_comment_date(),  
                        get_comment_time() 
                    ); 
                ?>
           </time><?php 
            edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
            <a class="reply"> 
            
            <?php 
                comment_reply_link( 
                    array_merge( 
                        $args, 
                        array( 
                            'add_below' => $add_below, 
                            'depth'     => $depth, 
                            'max_depth' => $args['max_depth'] 
                        ) 
                    ) 
                ); ?></a>
        </div>

        <div class="comment__text">
        <?php comment_text(); ?>            
        </div>
 
        
        <?php 
        if ( 'div' != $args['style'] ) : ?>
            </div>
        <?php 
        endif;
}
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * comment pagination
 */
// call 
the_comments_pagination(array(
    'screen_reader_text'=>__("pagination", "philosophy"),
    'prev_text'=> '<'.__("Previous", "philosophy"),
    'prev_text'=> '>'.__("Previous", "philosophy"),
));
// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Get total comment number
 */
$philosophy_cn= get_comments_number();

if($philosophy_cn<=1){
    echo $philosophy_cn." ".__("Comment","philosophy");
}else{
    echo $philosophy_cn." ".__("Comments","philosophy");
}

// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Comment Form box
 */
// call 
if(!comments_open()){
    _e( "Commets are clsoed", "philosophy" );
}

$comments_args = array(
    // change the title of send button 
    'label_submit'=>'Send',
    // change the title of the reply section
    'title_reply'=>'Write a Reply or Comment',
    // remove "Text or HTML to be displayed after the set of comment fields"
    'comment_notes_after' => '',
    // redefine your own textarea (the comment body)
    'comment_field' => '<div class="message form-field">
                            <label for="comment">' . _x( 'Comment', 'noun' ) . '</label>
                           
                            <textarea id="comment" name="comment" class="full-width" placeholder="Your Message" aria-required="true">
                            </textarea>
                        </div>',
);

comment_form($comments_args);
//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Escapping title or any text
 */
// call 
_e( "Popular Posts", "philosophy" );
//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * Get all popular post by comment. which post have more comment It will show 
 */
// call 

$philosophy_popular_post = new WP_Query(array(
    'posts_per_page' => 6,
    'ignore_sticky_posts'=>1,
    'orderby'=>"comment_count",
));

while($philosophy_popular_post->have_posts()){
    $philosophy_popular_post->the_post();

    ?>
    <article class="col-block popular__post">
        <a href="<?php the_permalink(); ?>" class="popular__thumb">
           <?php the_post_thumbnail(); ?>
        </a>
        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <section class="popular__meta">
                <span class="popular__author"><span><?php _e( "By", "philosophy" ); ?></span> <a href="<?php echo esc_url( get_the_author_meta( "ID" ) ); ?>"> <?php the_author();?></a></span>
            <span class="popular__date"><span><?php _e( "On", "philosophy" ); ?></span> <time datetime="2017-12-19"><?php echo get_the_date(); ?></time></span>
        </section>
    </article>

    <?php
}
wp_reset_query();

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * Get all tags 
 */
// call 
the_tags('','',''); 
//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------




/**
 * Show any separate template 
 */
// call 
get_template_part( "template-parts/common/navigation" );
//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------




/**
 * show template if its home only
 */
// call 
if(is_home()){
    get_template_part( "template-parts/blog-home/featured" );
}
//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------




/**
 * Post show
 */

// call 
the_title( );
echo get_the_date(); 
// or 
echo esc_html(  get_the_date() ) ;
// post permalink 
the_permalink();

the_post_thumbnail( "philosophy-home-square");

the_excerpt();

echo get_the_tag_list();

echo get_the_category_list(" ");
the_post_thumbnail( "large" );
the_content(); 
echo get_the_tag_list();

// author image
echo get_avatar( get_the_author_meta( "ID" ) );
// author url 
echo esc_url(get_author_posts_url(get_the_author_meta( "ID" )));

// author name 
the_author();
//author description
the_author_meta("description") ;
//author specific facebook or socaial icon link show with acf
$philosophy_facebook= get_field("facebook", "user_".get_the_author_meta("ID"));
echo esc_url( $philosophy_facebook );



// comment template call 
if(!post_password_required()){
    comments_template();
}


//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Custom image size
 */
// call 
the_post_thumbnail( "philosophy-home-square");
//f:
add_image_size( "philosophy-home-square", 400, 400, true );

// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------




/**
 * Previosu and next post show prev next
 */
// call 
// previous =-==
$philosophy_prev_post = get_previous_post( );
if($philosophy_prev_post){
    // link 
    echo get_the_permalink($philosophy_prev_post);
    // escape 
    _e( "Previous Post", "philosophy" );

    // title 
    echo get_the_title( $philosophy_prev_post ); 
}
// Next =-==
$philosophy_next_post = get_next_post( );
  if($philosophy_next_post){
    echo get_the_permalink($philosophy_next_post);
    _e( "Next Post", "philosophy" );
    echo get_the_title( $philosophy_next_post );
  }

//   comment template call 
if(!post_password_required()){
    comments_template();
}

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * Category show 
 */
// call 
single_cat_title();
echo category_description();
// show post by category 
if( ! have_posts() ){
    _e( "There is no post in this category", "philosophy" );
}else{
    while(have_posts()){
        the_post();

        get_template_part( "template-parts/post-formats/post",get_post_format()); // call post by category like video, audio and so on
        
    }
}

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Show audio by url ussing acf 
 */
// call 
$philosophy_audio_file = "";

if(function_exists("the_field")){
    $philosophy_audio_file = get_field("source_file");
}
echo esc_url($philosophy_audio_file);  // inside    <audio id="player" src="<?php echo esc_url($philosophy_audio_file); ?" width="100%" height="42" controls="controls"></audio>
//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Attatchment slider
 */
// call 
if(class_exists("Attachments")): 

    $attachments = new Attachments("gallery");
    if($attachments->exist()):

        while($attachment = $attachments->get()):

            echo $attachments->image("philosophy-home-square");
        endwhile;
    endif;
endif;

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Menu
 */
// call 
$args = array(
                        
    'theme_location'=> 'topmenu',
    'menu_id'=>'topmenu',
    'menu_class'=>'header__nav',

    // 'add_li_class'  => 'has-children'
    );

wp_nav_menu($args);

//f:
register_nav_menu( "topmenu", __("Top Menu", "philosophy") );

// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------



/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * 
 */
// call 

//f:


// end ----------------------------------------------------------------------------------------------------------------------------------------------------------------










