<?php

add_action( 'customize_register', 'eye_catching_blog_customize_register', 999 );
function eye_catching_blog_customize_register( $wp_customize ){
    $wp_customize->get_section('homepage')->title = esc_html__( 'Homepage Blog Settings', 'eye-catching-blog' );
    $wp_customize->get_section('homepage')->priority = 1;
}

add_action( 'wp_enqueue_scripts', 'eye_catching_blog_chld_thm_parent_css' );
function eye_catching_blog_chld_thm_parent_css() {

    $my_theme = wp_get_theme();
    $theme_version = $my_theme->get( 'Version' );

    wp_enqueue_style( 
    	'eye_catching_blog_chld_css', 
    	trailingslashit( get_template_directory_uri() ) . 'style.css', 
    	array( 
    		'bootstrap',
    		'font-awesome-5',
    		'bizberg-main',
    		'bizberg-component',
    		'bizberg-style2',
    		'bizberg-responsive' 
    	)
    );

    wp_enqueue_script( 'eye_catching_blog_scripts', get_stylesheet_directory_uri() . '/script.js', array('jquery'), $theme_version );
    
}

/** 
* Enable Slick for this child theme
*/
add_filter( 'bizberg_slick_slider_status', function(){
    return true;
});

add_action( 'init', 'eye_catching_blog_colors' );
function eye_catching_blog_colors(){

    $options = array(
        'bizberg_slider_title_box_highlight_color',
        'bizberg_slider_arrow_background_color',
        'bizberg_slider_dot_active_color',
        'bizberg_read_more_background_color',
        'bizberg_theme_color', // Change the theme color
        'bizberg_header_menu_color_hover',
        'bizberg_header_button_color',
        'bizberg_header_button_color_hover',
        'bizberg_link_color',
        'bizberg_background_color_2',
        'bizberg_link_color_hover',
        'bizberg_sidebar_widget_title_color',
        'bizberg_blog_listing_pagination_active_hover_color',
        'bizberg_heading_color',
        'bizberg_sidebar_widget_link_color_hover',
        'bizberg_footer_social_icon_color',
        'bizberg_footer_copyright_background',
        'bizberg_header_menu_color_hover_sticky_menu'
    );

    foreach ( $options as $value ) {
        
        add_filter( $value , function(){
            return '#e91e63';
        });

    }

}

add_filter( 'bizberg_site_tagline_font', function(){
    return [
        'font-family'    => 'Montserrat',
        'variant'        => '500',
        'font-size'      => '12px',
        'line-height'    => '1.8',
        'letter-spacing' => '2px',
        'text-transform' => 'uppercase',
        'text-align'     => 'center'
    ];
});

add_filter( 'bizberg_site_title_font', function(){
    return [
        'font-family'    => 'Great Vibes',
        'variant'        => '400',
        'font-size'      => '70px',
        'line-height'    => '1.5',
        'letter-spacing' => '0',
        'text-transform' => 'none',
        'text-align'     => 'center'
    ];
});

add_filter( 'bizberg_primary_header_layout', function(){
    return 'center';
});

add_filter( 'bizberg_slider_banner_settings', function(){
    return 'none';
});

add_filter( 'bizberg_slider_gradient_primary_color', function(){
    return '#3a4cb4';
});

add_filter( 'bizberg_header_btn_border_radius', function(){
    return array(
        'top-left-radius'  => '0px',
        'top-right-radius'  => '0px',
        'bottom-left-radius' => '0px',
        'bottom-right-radius' => '0px'
    );
});

add_filter( 'bizberg_header_button_border_color', function(){
    return '#cc1451';
});

add_filter( 'bizberg_header_button_border_dimensions', function(){
    return array(
        'top-width'  => '0px',
        'bottom-width'  => '5px',
        'left-width' => '0px',
        'right-width' => '0px',
    );
});

add_filter( 'bizberg_slider_btn_border_radius', function(){
    return array(
        'border-top-left-radius'  => '0px',
        'border-top-right-radius'  => '0px',
        'border-bottom-right-radius' => '0px',
        'border-bottom-left-radius' => '0px'
    );
});

add_filter( 'bizberg_read_more_border_color', function(){
    return '#cc1451';
});

add_filter( 'bizberg_read_more_border_dimensions', function(){
    return array(
        'top-width'  => '0px',
        'bottom-width'  => '5px',
        'left-width' => '0px',
        'right-width' => '0px',
    );
});

add_filter( 'bizberg_header_2_spacing', function(){
    return [
        'padding-top'  => '50px',
        'padding-bottom'  => '60px'
    ];
});

add_filter( 'bizberg_header_columns_middle_style', function(){
    return 'col-sm-2|col-sm-8|col-sm-2';
});

add_filter( 'bizberg_site_title_font_sticky_menu', function(){
    return 27;
});

add_filter( 'bizberg_site_tagline_font_sticky_menu', function(){
    return 10;
});

add_action( 'bizberg_before_homepage_blog', 'eye_catching_blog_slider' );
function eye_catching_blog_slider(){ 

    $slider_status = bizberg_get_theme_mod( 'eye_catching_blog_slider_status' );

    if( !$slider_status ){
        return;
    }

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => bizberg_get_theme_mod( 'eye_catching_blog_slider_limit' ),
        'cat'                 => bizberg_get_theme_mod( 'eye_catching_blog_slider_category' ),
        'orderby'             => bizberg_get_theme_mod( 'eye_catching_blog_slider_orderby' ),
        'ignore_sticky_posts' => bizberg_get_theme_mod( 'eye_catching_blog_slider_sticky_posts_status' )
    ); 

    $slider_query = new WP_Query( $args );

    if( $slider_query->have_posts() ): ?>

        <section class="banner-style">

            <div class="container-fluid">

                <div class="row banner-slider eye_catching_blog_slider">

                    <?php 
                    while( $slider_query->have_posts() ): $slider_query->the_post();

                        global $post;

                        $category_detail = get_the_category( $post->ID );

                        $cat_name = !empty( $category_detail[0]->name ) ? $category_detail[0]->name : '';

                        $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url( $post, 'large' ) : get_template_directory_uri() . '/assets/images/placeholder.jpg'; ?>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="popular-item-wp">
                                <img src="<?php echo esc_url( $image_url ); ?>" class="ecb_slider_image">
                                <div class="pp-item-detail">

                                    <?php  
                                    if( !empty( $cat_name ) ){ ?>
                                        <div class="upper-item-dt">
                                            <a href="<?php echo esc_url( get_category_link( $category_detail[0]->term_id ) ); ?>" class="ecb_category">
                                                <?php echo esc_html( $cat_name ); ?>
                                            </a>
                                        </div>
                                        <?php 
                                    } ?>

                                    <div class="lower-item-dt">
                                        <a class="ecb_title" href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                        <div class="ecb_date">
                                            <?php echo esc_html( get_the_date() ); ?>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                        </div>

                        <?php

                    endwhile;?>

                </div>

            </div>

        </section>

        <?php

    endif;

    wp_reset_postdata();
}

add_action( 'bizberg_before_homepage_blog', 'eye_catching_blog_editor_choice', 30 );
function eye_catching_blog_editor_choice(){

    $editor_pick_section_status = bizberg_get_theme_mod( 'editor_pick_section_status' ); 

    if( !$editor_pick_section_status ){
        return;
    } 

    $editor_pick_section_title = bizberg_get_theme_mod( 'editor_pick_section_title' );

    $editor_pick_section_category = bizberg_get_theme_mod( 'editor_pick_section_category' );
    $editor_pick_post_per_page = bizberg_get_theme_mod( 'editor_pick_post_per_page' );
    $editor_pick_order_by = bizberg_get_theme_mod( 'editor_pick_order_by' );

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $editor_pick_post_per_page,
        'orderby'             => $editor_pick_order_by,
        'ignore_sticky_posts' => 1
    ); 

    if( !empty( array_filter( $editor_pick_section_category ) ) ){
        $args['category__in'] = $editor_pick_section_category;
    }

    $editor_pick_query = new WP_Query( $args );
    $flag = false;
    $count = 0; ?>

    <section id="bizberg_editor_choice">

        <?php 

        if( !empty( $editor_pick_section_title ) ){ ?>

            <div class="container">
                
                <div class="row">

                    <div class="col-xs-12">

                        <h2 class="editor_heading"><?php echo esc_html( $editor_pick_section_title ); ?></h2>

                    </div>

                </div>

            </div>

            <?php 

        } 

        if( $editor_pick_query->have_posts() ): ?>
        
            <div class="container business-event-flex-container">

                <div class="row">

                    <?php 

                    while( $editor_pick_query->have_posts() ): $editor_pick_query->the_post();

                        global $post;

                        $category_detail = get_the_category( $post->ID );

                        $cat_name = !empty( $category_detail[0]->name ) ? $category_detail[0]->name : '';

                        $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium_large' );

                        if( $flag == false ): ?>
                    
                            <div class="col-xs-12  col-sm-12 col-md-8 content2">
                                
                                <div class="big_left_post" style="background-image: linear-gradient(to right,rgb(0 0 0 / 0.4),rgb(0 0 0 / 0.4)),url(<?php echo esc_url( !empty( $image_attributes[0] ) ? $image_attributes[0] : '' ); ?>)">

                                    <div class="big_left_post_content">
                                        
                                        <?php 
                                        if( !empty( $cat_name ) ){ ?>
                                            <a href="<?php echo esc_url( get_category_link( $category_detail[0] ) ); ?>" class="post-cat1 editor_cat_background_<?php  echo absint( $category_detail[0]->term_id ); ?>">
                                                <?php echo esc_html( $cat_name ); ?>
                                            </a>
                                            <?php 
                                        } ?>

                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                        <div class="post_meta2">
                                            <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php 

                            $flag = true;

                        else: 

                            if( $count == 0 ){ ?> <div class="col-xs-12  col-sm-12 col-md-4 right"> <?php } ?>                                

                                <div class="bizberg-row">
                                    
                                    <?php 
                                    if( has_post_thumbnail() ){ ?>
                                        <div class="thumbnail3">
                                            <?php the_post_thumbnail( 'bizberg_medium' ); ?>
                                        </div>
                                        <?php 
                                    }?>

                                    <div class="content3">
                                        <?php 
                                        if( !empty( $cat_name ) ){ ?>
                                            <a 
                                            href="<?php the_permalink(); ?>" 
                                            class="post-cat1 editor_cat_background_<?php echo absint( $category_detail[0]->term_id ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                                            <?php 
                                        } ?>
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="post_meta2">
                                            <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                        </div>
                                    </div>

                                </div>

                                <?php

                                if( $editor_pick_query->found_posts == ( $count + 1 ) ){ ?> </div> <?php } ?>  

                            <?php

                            $count++;

                        endif;

                    endwhile; ?>

                </div>

            </div>

            <?php 

        endif;

        wp_reset_postdata(); ?>

    </section>

    <?php
}

add_action( 'bizberg_before_homepage_blog', 'eye_catching_blog_popular_posts', 20 );
function eye_catching_blog_popular_posts(){

    $popular_section_status = bizberg_get_theme_mod( 'popular_section_status' );

    if( !$popular_section_status ){
        return;
    }

    $popular_section_title = bizberg_get_theme_mod( 'popular_section_title' );
    $popular_section_subtitle = bizberg_get_theme_mod( 'popular_section_subtitle' ); 
    $popular_section_category = bizberg_get_theme_mod( 'popular_section_category' ); 
    $popular_section_category_posts_per_page = bizberg_get_theme_mod( 'popular_section_category_posts_per_page' );

    $section_header = true;
    if( empty( $popular_section_title ) && empty( $popular_section_subtitle ) ){
        $section_header = false;
    }

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $popular_section_category_posts_per_page,
        'ignore_sticky_posts' => 1
    );

    if( !empty( array_filter( $popular_section_category ) ) ){
        $args['category__in'] = $popular_section_category;
    }

    $popular_query = new WP_Query( $args );

    if( $popular_query->have_posts() ):

        ?>

        <section 
        id="business_event_popular_posts"
        style="<?php echo( !$section_header ? 'padding: 0 0 50px 0;' : '' ); ?>">
            
            <div class="container">
                
                <?php 
                if( $section_header ){ ?>

                    <div class="row">
                        
                        <div class="col-xs-12">

                            <div class="title_wrapper_1">
                                <h2 class="text-center"><?php echo esc_html( $popular_section_title ); ?></h2>
                                <p class="text-center"><?php echo esc_html( $popular_section_subtitle ); ?></p>
                            </div>

                        </div>

                    </div>

                    <?php 
                } ?>

                <div class="row business_event_popular_posts_wrapper">

                    <?php 

                    while( $popular_query->have_posts() ): $popular_query->the_post();

                        global $post;

                        $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium_large' );
                        $image_link = !empty( $image_attributes[0] ) ? $image_attributes[0] : '';

                        $category_detail = get_the_category( $post->ID );

                        $cat_name = !empty( $category_detail[0]->name ) ? $category_detail[0]->name : ''; ?>

                        <div class="col-xs-12 col-sm-6 col-md-4 pop_wrapper">

                            <a href="<?php the_permalink(); ?>">
                                <div 
                                class="thumb1" 
                                style="background-image: <?php echo empty( $image_link ) ? 'linear-gradient(to right,rgb(0 0 0 / 0.4),rgb(0 0 0 / 0.4))' : 'url(' . esc_url( $image_link ) . ')'; ?>">
                                    <?php 
                                    if( !empty( $cat_name ) ){ ?>
                                        <span class="cat1">
                                            <?php echo esc_html( $cat_name ); ?>
                                        </span>
                                        <?php 
                                    } ?>
                                </div>
                            </a>

                            <div class="content1">
                                
                                <h4>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>            
                                    </a>
                                </h4>
                                <div class="post_meta1">
                                    <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                </div>

                            </div>

                        </div>

                        <?php 

                    endwhile; ?>

                </div>

            </div>

        </section>

        <?php

    endif;

    wp_reset_postdata();
}

add_action( 'bizberg_before_homepage_blog', 'eye_catching_blog_3_col_posts' );
function eye_catching_blog_3_col_posts(){

    // Display from category / pages
    $post_type = bizberg_get_theme_mod( 'blog_featured_3_col_post_type' );

    $pages = bizberg_get_theme_mod('featured_post_3_column');

    if( $post_type == 'none' ){
        return;
    }

    $page_ids = array();
    foreach ( $pages as $key => $value ) {
        $page_ids[] = $value['page_id'];
    }

    $args = array(
        'posts_per_page'      => bizberg_get_theme_mod( 'eye_catching_blog_featured_limit' ),
        'post_status'         => 'publish',
        'ignore_sticky_posts' => bizberg_get_theme_mod( 'eye_catching_blog_featured_sticky_posts_status' )
    );

    // Include pages
    if( $post_type == 'page' ){
        $args['post__in']  = empty( $page_ids ) ? array( 'none' ) : $page_ids;
        $args['post_type'] = 'page';
        $args['orderby']   = 'post__in';
        $args['posts_per_page']   = -1;
    } else {
        // Includes category
        $args['cat']       = bizberg_get_theme_mod( 'featured_post_3_column_category' );
        $args['post_type'] = 'post';
    }

    $featured_post = new WP_Query( $args );

    if( $featured_post->have_posts() ): ?>

        <section id="featured_3_grid">

            <div class="container">

                <div class="row">

                    <?php 

                    while( $featured_post->have_posts() ): $featured_post->the_post();

                        global $post; ?>
                    
                        <div class="col-xs-12 col-sm-12 col-md-4 mb-30">

                            <?php 

                            if( has_post_thumbnail() ){ ?>
                            
                                <div class="bizberg_post_thumb">
                                    
                                    <a href="<?php the_permalink(); ?>">
                                        
                                        <?php 
                                        the_post_thumbnail( 'bizberg_medium' );
                                        ?>

                                    </a>

                                </div>

                                <?php 

                            } ?>

                            <div class="bizberg_post_text">
                                
                                <div class="bizberg_post_title">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                                <div class="bizberg_post_date">
                                    <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                </div>

                            </div>

                        </div>

                        <?php 

                    endwhile; ?>

                </div>

            </div>

        </section>

        <?php

    endif;

    wp_reset_postdata();

}

function eye_catching_blog_kirki_slider_options(){

    Kirki::add_section( 'eye_catching_blog_slider', array(
        'title'          => esc_html__( 'Slider', 'eye-catching-blog' ),
        'section'          => 'homepage'
    ) );

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'eye_catching_blog_slider_status',
        'label'       => esc_html__( 'Enable Slider ?', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => true,
    ] );

    Kirki::add_field( 'bizberg', array(
        'type'        => 'select',
        'settings'    => 'eye_catching_blog_slider_category',
        'label'       => esc_html__( 'Select Post Category', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'multiple'    => 99,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ) );

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'eye_catching_blog_slider_sticky_posts_status',
        'label'       => esc_html__( 'Exclude Sticky Posts ?', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => false,
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
            array(
                'setting'  => 'eye_catching_blog_slider_category',
                'operator' => '==',
                'value'    => ''
            ),
        )
    ] );

    Kirki::add_field( 'bizberg', array(
        'type'        => 'select',
        'settings'    => 'eye_catching_blog_slider_orderby',
        'label'       => esc_html__( 'Order By', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'multiple'    => 1,
        'default'     => 'date',
        'choices'     => array(
            'title' => esc_html__( 'Title', 'eye-catching-blog' ),
            'date'  => esc_html__( 'Date', 'eye-catching-blog' ),
            'rand'  => esc_html__( 'Rand', 'eye-catching-blog' )
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ) );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'eye_catching_blog_slider_limit',
        'label'       => esc_html__( 'Limit', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => 6,
        'choices'     => [
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'eye_catching_blog_slider_image_options',
        'section'     => 'eye_catching_blog_slider',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Image Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){
        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_image_height',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Image Height ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_image_height',
                            'default'     => 500,
                            'choices'     => [
                                'min'  => 100,
                                'max'  => 500,
                                'step' => 25,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'  => '.banner-style .popular-item-wp img',
                                    'property' => 'height',
                                    'value_pattern' => '$px'
                                ),
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Image Height ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_image_height',
                            'default'     => 400,
                            'choices'     => [
                                'min'  => 100,
                                'max'  => 500,
                                'step' => 25,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'  => '.banner-style .popular-item-wp img',
                                    'property' => 'height',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Image Height ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_image_height',
                            'default'     => 400,
                            'choices'     => [
                                'min'  => 100,
                                'max'  => 500,
                                'step' => 25,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'  => '.banner-style .popular-item-wp img',
                                    'property' => 'height',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );
    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'eye_catching_blog_slider_arrow_options',
        'section'     => 'eye_catching_blog_slider',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Arrow Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'eye_catching_blog_slider_arrow_background',
        'label'       => __( 'Background Color', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => '#fff',
        'transport' => 'auto',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
        'output' => array(
            array(
                'element'  => '.eye_catching_blog_slider .slick-prev, .eye_catching_blog_slider .slick-next',
                'property' => 'background'
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'eye_catching_blog_slider_arrow_background_hover',
        'label'       => __( 'Background Color Hover', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => '#e91e63',
        'transport' => 'auto',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
        'output' => array(
            array(
                'element'  => '.eye_catching_blog_slider .slick-prev:hover, .eye_catching_blog_slider .slick-next:hover',
                'property' => 'background'
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'eye_catching_blog_slider_arrow_color',
        'label'       => __( 'Arrow Color', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => '#333',
        'transport' => 'auto',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
        'output' => array(
            array(
                'element'  => '.eye_catching_blog_slider .slick-prev:before, .eye_catching_blog_slider .slick-next:before',
                'property' => 'color'
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'eye_catching_blog_slider_arrow_color_hover',
        'label'       => __( 'Arrow Color Hover', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => '#fff',
        'transport' => 'auto',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
        'output' => array(
            array(
                'element'  => '.eye_catching_blog_slider .slick-prev:hover:before, .eye_catching_blog_slider .slick-next:hover:before',
                'property' => 'color'
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'eye_catching_blog_slider_font_options',
        'section'     => 'eye_catching_blog_slider',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Font Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'typography',
        'settings'    => 'eye_catching_blog_slider_font_options_category',
        'label'       => esc_html__( 'Category Font', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => [
            'font-family'    => 'Rochester',
            'variant'        => 'regular',
            'line-height'    => '1.5',
            'letter-spacing' => '0',
            'color'          => '#333333',
            'text-transform' => 'none',
        ],
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => '.ecb_category',
            ],
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_category_font_size',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Category Font Size ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_category_font',
                            'default'     => 34,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_category',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Category Font Size ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_category_font',
                            'default'     => 34,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_category',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Category Font Size ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_category_font',
                            'default'     => 34, 
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_category',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_category_spacing_bottom',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Category Spacing Bottom ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_category_spacing_bottom',
                            'default'     => 0,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_category',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Category Spacing Bottom ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_category_spacing_bottom',
                            'default'     => 0,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_category',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Category Spacing Bottom ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_category_spacing_bottom',
                            'default'     => 0, 
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_category',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'typography',
        'settings'    => 'eye_catching_blog_slider_font_options_title',
        'label'       => esc_html__( 'Title Font', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => [
            'font-family'    => 'Montserrat',
            'variant'        => '500',
            'line-height'    => '1.5',
            'letter-spacing' => '1px',
            'color'          => '#333333',
            'text-transform' => 'uppercase',
        ],
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => '.ecb_title',
            ],
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_title_font_size',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Title Font Size ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_title_font_size',
                            'default'     => 14,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_title',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Title Font Size ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_title_font_size',
                            'default'     => 14,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_title',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Title Font Size ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_title_font_size',
                            'default'     => 14, 
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_title',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_title_spacing_bottom',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_title_spacing_bottom',
                            'default'     => 10,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_title',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_title_spacing_bottom',
                            'default'     => 10,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_title',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_title_spacing_bottom',
                            'default'     => 10, 
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '.ecb_title',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'typography',
        'settings'    => 'eye_catching_blog_slider_font_options_date',
        'label'       => esc_html__( 'Date Font', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => [
            'font-family'    => 'Montserrat',
            'variant'        => '500',
            'font-size'      => '11px',
            'line-height'    => '1.5',
            'letter-spacing' => '1px',
            'color'          => '#959595',
            'text-transform' => 'uppercase',
        ],
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => '.ecb_date',
            ],
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'eye_catching_blog_slider_options',
        'section'     => 'eye_catching_blog_slider',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Other Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_outer_spacing',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'dimensions' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Spacing ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_outer_spacing',
                            'default'     => [
                                'margin-top'  => '15px',
                                'margin-bottom'  => '0px',
                                'margin-left' => '100px',
                                'margin-right' => '100px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'margin-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'margin-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' ),
                                    'margin-left' => esc_html__( 'Left', 'eye-catching-blog' ),
                                    'margin-right' => esc_html__( 'Right', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '.banner-slider.eye_catching_blog_slider'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Spacing ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_outer_spacing',
                            'default'     => [
                                'margin-top'  => '35px',
                                'margin-bottom'  => '0px',
                                'margin-left' => '0px',
                                'margin-right' => '0px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'margin-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'margin-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' ),
                                    'margin-left' => esc_html__( 'Left', 'eye-catching-blog' ),
                                    'margin-right' => esc_html__( 'Right', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '.banner-slider.eye_catching_blog_slider',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Spacing ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_outer_spacing',
                            'default'     => [
                                'margin-top'  => '35px',
                                'margin-bottom'  => '0px',
                                'margin-left' => '0px',
                                'margin-right' => '0px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'margin-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'margin-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' ),
                                    'margin-left' => esc_html__( 'Left', 'eye-catching-blog' ),
                                    'margin-right' => esc_html__( 'Right', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '.banner-slider.eye_catching_blog_slider',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );
    
    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'eye_catching_blog_slider_drag',
        'label'       => esc_html__( 'Draggable ?', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => true,
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_slider',
                'settings' => 'eye_catching_blog_slider_slides_to_show_option',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'eye_catching_blog_slider_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Slides to Show ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_slidesToShow',
                            'default'     => 4,  
                            'choices'     => [
                                'min'  => 1,
                                'max'  => 6,
                                'step' => 1,
                            ]
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Slides to Show ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_slidesToShow_tablet',
                            'default'     => 3,  
                            'choices'     => [
                                'min'  => 1,
                                'max'  => 6,
                                'step' => 1,
                            ]
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Slides to Show ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_slider_slidesToShow_mobile',
                            'default'     => 1,  
                            'choices'     => [
                                'min'  => 1,
                                'max'  => 6,
                                'step' => 1,
                            ]
                        )
                    ),
                )
                
            ) 
        );

    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'eye_catching_blog_slider_autoplaySpeed',
        'label'       => esc_html__( 'Auto Play Speed', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => 3,
        'choices'     => [
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'eye_catching_blog_slider_speed',
        'label'       => esc_html__( 'Speed', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_slider',
        'default'     => 300,
        'choices'     => [
            'min'  => 300,
            'max'  => 10000,
            'step' => 100,
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'eye_catching_blog_slider_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

}

function eye_catching_blog_featured_posts(){

    Kirki::add_section( 'eye_catching_blog_featured_posts', array(
        'title'          => esc_html__( 'Featured Posts', 'eye-catching-blog' ),
        'section'          => 'homepage'
    ) );

    Kirki::add_field( 'bizberg', [
        'type'        => 'radio',
        'settings'    => 'blog_featured_3_col_post_type',
        'label'       => esc_html__( 'Display From', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_featured_posts',
        'default'     => 'category',
        'choices'     => [
            'category'   => esc_html__( 'Category', 'eye-catching-blog' ),
            'page' => esc_html__( 'Pages', 'eye-catching-blog' ),
            'none' => esc_html__( 'None', 'eye-catching-blog' )
        ]
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'repeater',
        'label'       => esc_attr__( 'Select Pages', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_featured_posts',
        'priority'    => 10,
        'row_label' => [
            'type'  => 'field',
            'value' => esc_html__( 'Page', 'eye-catching-blog' )
        ],
        'settings'    => 'featured_post_3_column',
        'fields' => [
            'page_id'  => [
                'type'        => 'select',
                'label'       => esc_html__( 'Page', 'eye-catching-blog' ),
                'choices'  => function_exists( 'bizberg_get_all_pages' ) ? bizberg_get_all_pages() : array()
            ],
        ],
        'default' => [],
        'choices' => [
            'limit' => 3
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'blog_featured_3_col_post_type',
                'operator' => '==',
                'value'    => 'page',
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', array(
        'type'        => 'select',
        'settings'    => 'featured_post_3_column_category',
        'label'       => esc_html__( 'Select Post Category', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_featured_posts',
        'multiple'    => 1,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'blog_featured_3_col_post_type',
                'operator' => '==',
                'value'    => 'category',
            ),
        ),
    ) );

     Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'eye_catching_blog_featured_sticky_posts_status',
        'label'       => esc_html__( 'Exclude Sticky Posts ?', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_featured_posts',
        'default'     => false,
        'active_callback'    => array(
            array(
                'setting'  => 'blog_featured_3_col_post_type',
                'operator' => '==',
                'value'    => 'category'
            ),
            array(
                'setting'  => 'featured_post_3_column_category',
                'operator' => '==',
                'value'    => 0
            )
        )
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'eye_catching_blog_featured_limit',
        'label'       => esc_html__( 'Limit', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_featured_posts',
        'default'     => 3,
        'choices'     => [
            'min'  => 1,
            'max'  => 12,
            'step' => 1
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'blog_featured_3_col_post_type',
                'operator' => '==',
                'value'    => 'category'
            )
        )
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_featured_posts',
                'settings' => 'eye_catching_blog_featured_posts_outer_spacing',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'blog_featured_3_col_post_type',
                        'operator' => '!=',
                        'value'    => 'none'
                    )
                ),
                'fields' => array(
                    'dimensions' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Spacing ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_featured_posts_outer_spacing',
                            'default'     => [
                                'padding-top'  => '60px',
                                'padding-bottom'  => '40px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#featured_3_grid'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Spacing ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_featured_posts_outer_spacing',
                            'default'     => [
                                'padding-top'  => '60px',
                                'padding-bottom'  => '40px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#featured_3_grid',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Spacing ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_featured_posts_outer_spacing',
                            'default'     => [
                                'padding-top'  => '60px',
                                'padding-bottom'  => '40px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#featured_3_grid',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

}

function eye_catching_blog_popular_news(){

    Kirki::add_section( 'eye_catching_blog_popular_news', array(
        'title'          => esc_html__( 'Popular Posts', 'eye-catching-blog' ),
        'section'          => 'homepage'
    ) );

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'popular_section_status',
        'label'       => esc_html__( 'Enable Popular Section ?', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => true,
    ] );

    Kirki::add_field( 'bizberg', [
        'type'     => 'text',
        'settings' => 'popular_section_title',
        'label'    => esc_html__( 'Title', 'eye-catching-blog' ),
        'default'  => current_user_can( 'edit_theme_options' ) ? esc_html__( 'Popular Section', 'eye-catching-blog' ) : '',
        'section'  => 'eye_catching_blog_popular_news',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'     => 'text',
        'settings' => 'popular_section_subtitle',
        'label'    => esc_html__( 'Subtitle', 'eye-catching-blog' ),
        'section'  => 'eye_catching_blog_popular_news',
        'default'  => current_user_can( 'edit_theme_options' ) ? esc_html__( 'Proactively administrate team building supply chains before virtual convergence.', 'eye-catching-blog' ) : '',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'popular_section_category',
        'label'       => esc_html__( 'Select Category', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'multiple'    => 10,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'popular_section_category_posts_per_page',
        'label'       => esc_html__( 'Limit', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => '3',
        'multiple'    => 1,
        'choices'     => [
            3 => 3,
            6 => 6,
            9 => 9,
            12 => 12
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'popular_section_category_background_color',
        'label'       => __( 'Category Background Color', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => '#e91e63',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
        'transport' => 'auto',
        'output' => array(
            array(
                'element'  => '#business_event_popular_posts span.cat1',
                'property' => 'background',
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'popular_section_category_img_height',
        'label'       => esc_html__( 'Image Height', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => 300,
        'choices'     => [
            'min'  => 100,
            'max'  => 500,
            'step' => 25,
        ],
        'output' => array(
            array(
                'element'  => '#business_event_popular_posts .thumb1',
                'property' => 'height',
                'suffix' => 'px'
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_popular_news',
                'settings' => 'eye_catching_blog_popular_news_outer_spacing',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'popular_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'dimensions' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Spacing ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_popular_news_outer_spacing',
                            'default'     => [
                                'padding-top'  => '50px',
                                'padding-bottom'  => '50px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Spacing ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_popular_news_outer_spacing',
                            'default'     => [
                                'padding-top'  => '0px',
                                'padding-bottom'  => '50px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Spacing ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_popular_news_outer_spacing',
                            'default'     => [
                                'padding-top'  => '0px',
                                'padding-bottom'  => '50px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'popular_section_font_settings',
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Font Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'typography',
        'settings'    => 'popular_section_title_font_settings',
        'label'       => esc_html__( 'Title Font', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => [
            'font-family'    => 'Lato',
            'variant'        => '700',
            'line-height'    => '1.1',
            'letter-spacing' => '0',
            'color'          => '#e91e63',
            'text-transform' => 'none'
        ],
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => '#business_event_popular_posts .title_wrapper_1 h2',
            ],
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_popular_news',
                'settings' => 'popular_section_title_font_size',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'popular_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Title Font Size ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_title_font_size',
                            'default'     => 36,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 h2',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Title Font Size ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_title_font_size',
                            'default'     => 28,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 h2',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Title Font Size ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_title_font_size',
                            'default'     => 24, 
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 h2',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_popular_news',
                'settings' => 'popular_section_title_bottom_spacing',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'popular_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_title_bottom_spacing',
                            'default'     => 0,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 h2',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_title_bottom_spacing',
                            'default'     => 0,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 h2',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_title_bottom_spacing',
                            'default'     => 0, 
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 h2',
                                    'property'      => 'padding-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'typography',
        'settings'    => 'popular_section_subtitle_font_settings',
        'label'       => esc_html__( 'Subtitle Font', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_popular_news',
        'default'     => [
            'font-family'    => 'inherit',
            'variant'        => 'inherit',
            'line-height'    => 'inherit',
            'letter-spacing' => 'inherit',
            'color'          => '#64686d',
            'text-transform' => 'inherit'
        ],
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => '#business_event_popular_posts .title_wrapper_1 p',
            ],
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){
        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_popular_news',
                'settings' => 'popular_section_subtitle_font_size',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'popular_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Subtitle Font Size ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_subtitle_font_size',
                            'default'     => 14,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 p',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Subtitle Font Size ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_subtitle_font_size',
                            'default'     => 14,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 p',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Subtitle Font Size ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'popular_section_subtitle_font_size',
                            'default'     => 14, 
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => '#business_event_popular_posts .title_wrapper_1 p',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );
    }

}

function eye_catching_blog_editors_choice(){

    Kirki::add_section( 'eye_catching_blog_editor_choice', array(
        'title'          => esc_html__( "Editor's Choice", 'eye-catching-blog' ),
        'section'          => 'homepage'
    ) );

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'editor_pick_section_status',
        'label'       => esc_html__( "Enable Editor's Choice Section ?", 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => true
    ] );

    Kirki::add_field( 'bizberg', [
        'type'     => 'text',
        'settings' => 'editor_pick_section_title',
        'label'    => esc_html__( 'Title', 'eye-catching-blog' ),
        'section'  => 'eye_catching_blog_editor_choice',
        'default'  => current_user_can( 'edit_theme_options' ) ? esc_html__( "Editor's Choice", 'eye-catching-blog' ) : '',
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'editor_pick_section_category',
        'label'       => esc_html__( 'Select Category', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'multiple'    => 10,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'editor_pick_post_per_page',
        'label'       => esc_html__( 'Limit', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => 5,
        'choices'     => [
            'min'  => 3,
            'max'  => 10,
            'step' => 1,
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'editor_pick_order_by',
        'label'       => esc_html__( 'Order By', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => 'date',
        'multiple'    => 1,
        'choices'     => [
            'date' => esc_html__( 'Date', 'eye-catching-blog' ),
            'title' => esc_html__( 'Title', 'eye-catching-blog' ),
            'rand' => esc_html__( 'Random', 'eye-catching-blog' )
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'eye_catching_blog_editor_choice_styling_options',
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Other Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'repeater',
        'label'       => esc_attr__( 'Select Category Background Colors', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'row_label' => [
            'type'  => 'field',
            'value' => esc_html__( 'Color', 'eye-catching-blog' )
        ],
        'settings'    => 'editor_pick_colors',
        'fields' => [
            'cat_id'  => [
                'type'        => 'select',
                'label'       => esc_html__( 'Category', 'eye-catching-blog' ),
                'choices'  => bizberg_get_post_categories()
            ],
            'color'  => [
                'type'        => 'color',
                'label'       => esc_html__( 'Color', 'eye-catching-blog' ),
                'default'     => '#0088CC'
            ],
        ],
        'default' => [
            [
                'cat_id' => '',
                'color' => '#0088CC' 
            ]
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){
        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_editor_choice',
                'settings' => 'eye_catching_blog_editor_choice_outer_spacing',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'editor_pick_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'dimensions' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Outer Spacing ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_outer_spacing',
                            'default'     => [
                                'padding-top'  => '100px',
                                'padding-bottom'  => '100px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#bizberg_editor_choice'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Outer Spacing ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_outer_spacing',
                            'default'     => [
                                'padding-top'  => '100px',
                                'padding-bottom'  => '100px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#bizberg_editor_choice',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Outer Spacing ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_outer_spacing',
                            'default'     => [
                                'padding-top'  => '100px',
                                'padding-bottom'  => '100px'
                            ],
                            'choices'     => [
                                'labels' => [
                                    'padding-top'  => esc_html__( 'Top', 'eye-catching-blog' ),
                                    'padding-bottom'  => esc_html__( 'Bottom', 'eye-catching-blog' )
                                ],
                            ],
                            'output' => array(
                                array(
                                    'element'       => '#bizberg_editor_choice',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );
    }

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'editor_pick_background_color',
        'label'       => __( 'Background Color', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => '#fdeedc',
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport' => 'auto',
        'output' => array(
            array(
                'element'  => '#bizberg_editor_choice',
                'property' => 'background',
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'eye_catching_blog_editor_choice_font_options',
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Font Options', 'eye-catching-blog' ) . '</div>',
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'typography',
        'settings'    => 'eye_catching_blog_editor_choice_title_font_settings',
        'label'       => esc_html__( 'Title Font', 'eye-catching-blog' ),
        'section'     => 'eye_catching_blog_editor_choice',
        'default'     => [
            'font-family'    => 'Lato',
            'variant'        => '700',
            'line-height'    => '1.1',
            'letter-spacing' => '0',
            'color'          => '#e91e63',
            'text-transform' => 'none'
        ],
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h2.editor_heading',
            ],
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_editor_choice',
                'settings' => 'eye_catching_blog_editor_choice_title_font_size',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'editor_pick_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Title Font Size ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_title_font_size',
                            'default'     => 36,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => 'h2.editor_heading',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Title Font Size ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_title_font_size',
                            'default'     => 28,  
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => 'h2.editor_heading',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Title Font Size ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_title_font_size',
                            'default'     => 24, 
                            'choices'     => [
                                'min'  => 10,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => 'h2.editor_heading',
                                    'property'      => 'font-size',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

    if( function_exists( 'bizberg_kirki_dtm_options' ) ){

        bizberg_kirki_dtm_options( 
            array(
                'display' => array(
                    'desktop' => 'desktop',
                    'tablet' => 'tablet',
                    'mobile' => 'mobile'
                ),
                'field_id' => 'bizberg',
                'section' => 'eye_catching_blog_editor_choice',
                'settings' => 'eye_catching_blog_editor_choice_title_bottom_spacing',
                'global_active_callback'    => array(
                    array(
                        'setting'  => 'editor_pick_section_status',
                        'operator' => '==',
                        'value'    => true
                    )
                ),
                'fields' => array(
                    'slider' => array(
                        'desktop' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Desktop )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_title_bottom_spacing',
                            'default'     => 20,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => 'h2.editor_heading',
                                    'property'      => 'margin-bottom',
                                    'value_pattern' => '$px'
                                )
                            ),
                        ),
                        'tablet' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Tablet )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_title_bottom_spacing',
                            'default'     => 20,  
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => 'h2.editor_heading',
                                    'property'      => 'margin-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 481px) and (max-width: 1024px)'
                                )
                            ),
                        ),
                        'mobile' => array(
                            'label' => esc_html__( 'Title Spacing Bottom ( Mobile )', 'eye-catching-blog' ),
                            'settings' => 'eye_catching_blog_editor_choice_title_bottom_spacing',
                            'default'     => 20, 
                            'choices'     => [
                                'min'  => 0,
                                'max'  => 50,
                                'step' => 1,
                            ],
                            'transport' => 'auto',
                            'output' => array(
                                array(
                                    'element'       => 'h2.editor_heading',
                                    'property'      => 'margin-bottom',
                                    'value_pattern' => '$px',
                                    'media_query'   => '@media (min-width: 320px) and (max-width: 480px)'
                                )
                            ),
                        )
                    ),
                )
                
            ) 
        );

    }

}

add_action( 'init' , 'eye_catching_blog_kirki_fields' );
function eye_catching_blog_kirki_fields(){

    if( !class_exists( 'Kirki' ) ){
        return;
    }

    /**
    * Slider Options
    */

    eye_catching_blog_kirki_slider_options();

    /**
    * Featured Post 3 Column
    */

    eye_catching_blog_featured_posts();

    /**
    * Start Popular News
    */

    eye_catching_blog_popular_news();

    /**
    * Start Editors Pick
    */

    eye_catching_blog_editors_choice();

}

add_filter( 'bizberg_inline_style', function( $inline_css ){

    $editor_pick_colors = bizberg_get_theme_mod( 'editor_pick_colors' );

    if( empty( $editor_pick_colors ) ){
        return $inline_css;
    }

    foreach ( $editor_pick_colors as $key => $value) {
        $inline_css .= '.editor_cat_background_' . absint( $value['cat_id'] ) . '{ background:' . esc_attr( $value['color'] ) . ' !important; }';
    }

    return $inline_css;

});

add_filter( 'bizberg_localize_scripts', function( $data ){

    $data['slidesToShowDesktop'] = bizberg_get_theme_mod( 'number_setting_desktop_eye_catching_blog_slider_slidesToShow' );
    $data['slidesToShowTablet'] = bizberg_get_theme_mod( 'number_setting_tablet_eye_catching_blog_slider_slidesToShow_tablet' );
    $data['slidesToShowMobile'] = bizberg_get_theme_mod( 'number_setting_mobile_eye_catching_blog_slider_slidesToShow_mobile' );

    $data['autoplaySpeed'] = bizberg_get_theme_mod( 'eye_catching_blog_slider_autoplaySpeed' );
    $data['speed'] = bizberg_get_theme_mod( 'eye_catching_blog_slider_speed' );
    $data['draggable'] = bizberg_get_theme_mod( 'eye_catching_blog_slider_drag' );

    return $data;

});