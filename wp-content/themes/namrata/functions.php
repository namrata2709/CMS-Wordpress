<?php
    function load_bootstrap(){
        wp_register_style('bootstrap',get_template_directory_uri() . 'css/bootstrap.min.css',array(),false,'all');
        wp_enqueue_style('bootstrap');
    }
    function load_style(){
        wp_register_style('defaultstyle',get_template_directory_uri() . '/style.css',array(),false,'all');
        wp_enqueue_style('defaultstyle');
    }
    add_action('wp_enqueue_scripts','load_bootstrap');
    add_action('wp_enqueue_scripts','load_style');
?>