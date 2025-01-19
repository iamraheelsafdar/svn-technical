<?php
/**
* Plugin Name: Assesment Dashboard V3
* Plugin URI: https://webzonetech.com
* Description: This plugin is addon for Wheel of lift Pro plugin.
* Version: 2.0.0
* Author: Rana Sattar
* Author URI: https://web.facebook.com/rao.sajid198
* Text Domain: aa
* @package cud
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$mind_flix_perfomance = get_option('m
ind_flix_perfomance');
add_action( 'wp_enqueue_scripts', 'custom_enque_scripts' );
add_action("wp_ajax_wheeloflife_description", "wheeloflife_description_callback" );
add_action("wp_ajax_nopriv_wheeloflife_description","wheeloflife_description_callback" );
add_action("wp_ajax_wheel_submissions", "wheel_submissions_callback" );
add_action("wp_ajax_nopriv_wheel_submissions","wheel_submissions_callback" );
add_action("wp_ajax_assessment_result", "assessment_result_callback" );
add_action("wp_ajax_nopriv_assessment_result","assessment_result_callback" );
// add_action("wp_ajax_compelete_assessment", "compelete_assessment_callback" );
// add_action("wp_ajax_nopriv_compelete_assessment","compelete_assessment_callback" );

add_action("wp_ajax_check_auth_user", "check_auth_user_callback" );
add_action("wp_ajax_nopriv_check_auth_user","check_auth_user_callback" );

add_action('init','shortcode_setup');
add_filter( 'single_template', 'add_postType_slug_template', 10, 1 );
add_action('wp_footer', 'my_custom_script');
add_action('wp_head', 'my_custom_header');

add_action('admin_menu', 'my_menu_pages');
function my_menu_pages(){
  add_menu_page( 'Assessment Popup', 'Assessment Popup', 'manage_options', 'assessment-popup','assessment_popup_fun','dashicons-shortcode', 5);
}
function assessment_popup_fun(){
    ob_start();
    return require_once('assessment-popup.php');
    ob_get_contents();
    ob_get_clean();  
}
function custom_enque_scripts(){
    
    $hook = $_SERVER['REQUEST_URI'];
    if ( str_contains($hook, 'mindflix-assessment') || str_contains($hook, 'wheel-submissions/') ) {  
        // wp_enqueue_style('shortcode-w3-css',plugin_dir_url(__DIR__).'assessment-dashboard/w3.css?css-ver='.rand(0,9999));
    //     wp_enqueue_style('shortcode-style',plugin_dir_url(__DIR__).'assessment-dashboard/style.css?css-ver='.rand(0,9999));
        wp_enqueue_script('assessment-jquery',plugin_dir_url(__DIR__).'assessment-dashboard/jquery.min.js?v='.rand(0,9999));
        //     wp_enqueue_script('shortcode-style-js',plugin_dir_url(__DIR__).'assessment-dashboard/style.js?js-ver='.rand(0,9999));
        //     wp_enqueue_script('shortcode-style3',plugin_dir_url(__DIR__).'assessment-dashboard/style3.js?js-ver='.rand(0,9999));
        // wp_enqueue_style('shortcode-style2',plugin_dir_url(__DIR__).'assesment-dashboard/style2.css?css-ver='.rand(0,9999));
        wp_enqueue_script('assessment-js',plugin_dir_url(__DIR__).'assessment-dashboard/assessment.js?v='.rand(0,9999));
        wp_localize_script('assessment-js','ajax_var',array('ajaxurl'=>admin_url('admin-ajax.php')));
        wp_enqueue_script('functions-js',plugin_dir_url(__DIR__).'assessment-dashboard/functions.js?v='.rand(0,9999));
        wp_enqueue_style('assessment-css',plugin_dir_url(__DIR__).'assessment-dashboard/assessment.css?v='.rand(0,9999));
    }
    

    
}
function show_cpt_assesments(){
    $query = new WP_Query(array(
        'post_type' => 'wheels_of_life_submissions',
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        echo $post_id;
        echo "<br>";
        echo get_the_title( $post_id );
        echo "<br>";
    }
    wp_reset_query();
}
function custom_assesments_callback(){
   ob_start();
   echo '<style> .page-content { padding: 100px 0;} </style>';
   echo ' <div style="padding:  0px 0;"><h1>sajid sattar rana sattar</h1>';
   $args = array(
        'author'      => wp_get_current_user()->ID,
        'post_type'   => 'wheel-submissions',
        'posts_per_page' => 1,
        'orderby' => 'modified',
        'order' => 'DESC'
    );
    $cquery4 = new WP_Query( $args );

    $total_weight = 0;
    $total_answers = 0;
    $index_answers = 0;
    $ans_arr = array(); 
    $color_arr = array(); 
    $q_ans_arr = array();


    if ( $cquery4->have_posts() ) :
        while( $cquery4->have_posts() ) :
            $cquery4->the_post();
        $myvals = get_post_meta(get_the_ID());
        ?>
    <table style="max-width:500px;margin:auto;">
            <thead>
                <tr>
                    <th>QUESTION</th>
                    <th>ANSWER</th>
                    <th>TOTAL</th>
                    <th>COLOR</th>
                </tr>
            </thead>
            <tbody>
    <?php
    foreach($myvals as $key=>$val)
    {
        // echo '#'.$key . ' <<<>>> ' . $val[0] . '<br/>';
        $obj =  unserialize($val[0] );
        // print_r($obj);
        $q_labels = $obj->labels;
        $responsive = $val[0]->responsive;
        $q_dataset = $obj->datasets;
        $q_ans = $q_dataset[0]->data;
        $q_group_colors = $q_dataset[0]->backgroundColor;
        // print_r($q_group_colors);
        $q_ans_borderColor = $q_dataset[0]->borderColor;
        $q_ans_borderWidth = $q_dataset[0]->borderWidth;
    ?>
            <?php  $m = 0; $j = 0; foreach($q_ans as $answer){ $ans_sum = 0 ?>
                <tr>
                    <td><?php echo $q_labels[$j]; ?></td>
                    <td><?php echo $q_ans[$j]; ?></td>
                    <td><?php echo $total_answers += $answer; ?></td>
                    <td><?php echo $q_group_colors[$j]; ?></td>
                    <?php
                        if( !in_array($q_group_colors[$j],$color_arr) ){
                            $color_arr[$j] =  $q_group_colors[$j]; 
                            $ans_arr[$j] =  $answer; 
                            $m++;
                        }else{
                            $index = array_search($q_group_colors[$j], $color_arr);
                            $ans_arr[$index] = $ans_arr[$index] + $answer;
                            $m++;
                        }
                        $q_ans_arr['color'] = array_values($color_arr);
                        $q_ans_arr['ans'] = array_values($ans_arr);
                    ?>
                </tr>
            <?php $total_weight++; $j++; }  ?>
            <?php
                }

                endwhile;
                wp_reset_postdata();
            endif;
            ?>
                </tbody>
            </table>
            <?php
                $total_weight *= 5;
                echo '<br>';
                echo '<p style="width:100%;text-align:center;">TOTAL WEIGHT IS:'.$total_weight.'</p>';
                echo '<p style="width:100%;text-align:center;">ANSWER WEIGHT IS:'.$total_answers.'</p>';
                $total_score = $total_answers/$total_weight;
                $total_score *= 100;
                $total_score = round($total_score);
                echo '<h5 style="width:100%;text-align:center;">TOTAL SCORE IS:'.$total_score.'%</h5>';
                echo '<br>';
                // echo do_shortcode( '[group_points group="1"]' );

                echo '<h6 style="width:100%;text-align:center;">q_ans_arr IS:';
                print_r($q_ans_arr);
                echo '</h5>';
                echo '<br>';
                $color_code = strtolower('#EE00FF');
                echo '<h6 style="width:100%;text-align:center;">POINT FOR '.$color_code.' IS:';
                $n = 0;
                foreach($q_ans_arr['color'] as $color_item){
                    if( str_contains( $color_item, $color_code ) ){
                        echo $q_ans_arr['ans'][$n];
                        echo 'calling shortcode';
                        echo do_shortcode( '[group_points group="4"]' );
                    }
                    $n++;
                }
                echo '</h5>';
   echo '</div>';
   return ob_get_clean();

}
function assesment_total_score_callback(){
    ob_start();
    $request_uri = $_SERVER['REQUEST_URI'];
    $end_point = 'wheel-submissions/assessment-submission-';
    $current_user_id = get_current_user_id();
    if(str_contains($request_uri, $end_point)){
        global $wp_query; 
        $postid = $wp_query->post->ID;
        $args = array(
            'author'  => $current_user_id,
            'post__in'=> array($postid),
            'post_type'   => 'wheel-submissions',
            'posts_per_page' => 1,
            'orderby' => 'modified',
            'order' => 'DESC'
        );
    }else{
        $args = array(
            'author'      => $current_user_id,
            'post_type'   => 'wheel-submissions',
            'posts_per_page' => 1,
            'order' => 'DESC'
        );
    }
    $cquery4 = new WP_Query( $args );
    $total_weight = 0;
    $total_answers = 0;
    if ( $cquery4->have_posts() ) :
        while( $cquery4->have_posts() ) :
            $cquery4->the_post();
            $myvals = get_post_meta(get_the_ID());
            foreach($myvals as $key=>$val)
            {
                $obj =  unserialize($val[0] );
                $q_dataset = $obj->datasets;
                $q_ans = $q_dataset[0]->data;
                $j = 0; 
                foreach($q_ans as $answer)
                { 
                    $total_answers += $answer;
                    $total_weight++; 
                    $j++; 
                } 
            }
        endwhile;
        wp_reset_postdata();
    endif;
    $total_weight *= 5;
    $total_score = $total_answers/$total_weight;
    $total_score *= 100;
    $total_score = round($total_score);
    // echo $total_score;
    echo $total_answers;
   return ob_get_clean();
}

function check_auth_user_callback(){
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    wp_send_json_success(array(
        'status' => '200',
        'c_user_id' => $current_user_id,
    ));
}

function assessment_result_callback(){
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    $uri = $_SERVER['REQUEST_URI'];
    $user_meta = '<div class="custom-assessment-result">';
    $user_meta .= get_user_meta($current_user_id, 'assess_notice', true);
    $user_meta .= '</div>';
    wp_send_json_success(array(
        'status' => '200',
        'user_meta' => $user_meta,
    ));
}
function compelete_assessment_callback(){
    $mind_flix_perfomance = get_option('mind_flix_perfomance');
    $short_code = '<div class="custom-assessment-short_code">';
    $short_code .= do_shortcode($mind_flix_perfomance);
    $short_code .= '</div>';
    wp_send_json_success(array(
        'status' => '200',
        'short_code' => $short_code,
    ));

}
function wheeloflife_description_callback(){
    $assess_notice = $_POST['assess_notice'];
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    $meta_key = 'assess_notice';
    $meta_value = $assess_notice;
    update_user_meta($current_user_id, $meta_key, $meta_value);
    $assess_submission_id = $_POST['assess_submission_id'];
    $assess_submission_id = str_replace('Assessment Submission No: #','', $assess_submission_id);
    $meta_key = 'assess_submission_id';
    if (!empty($meta_key) && !empty($meta_value)) {
        add_post_meta($assess_submission_id, $meta_key, $meta_value, true);
    }
    wp_send_json_success(array(
        'status' => '200',
        'message' => "Recived Successfully",
        'assess_notice' => 'assess_notice => '.$meta_value,
        'assess_submission_id' => 'assess_submission_id => '.$assess_submission_id,
        'submission_number' => 'submission_number => '.$assess_submission_id,
    ));
}
function group_points_callback( $_atts ){
    ob_start();

    $request_uri = $_SERVER['REQUEST_URI'];
    $end_point = 'wheel-submissions/assessment-submission-';

    $defaults = array(
        'group' => 1,
    );
    $atts = shortcode_atts( $defaults, $_atts );
    $atts['group'] = absint( $atts['group'] );
    // echo require_once('group-shortcode.php');
    $current_user_id = get_current_user_id();
    if ( is_single() && str_contains( $request_uri,$end_point) ) {
        global $post;
        $post_id = $post->ID;
        // echo 'post id:'.$post_id;
        // echo '<br>';
        $args = array(
            'post__in'=> array($post_id),
            'author'      => $current_user_id,
            'post_type'   => 'wheel-submissions',
            'posts_per_page' => 1,
            'order' => 'DESC'
        );
    } else {
        $args = array(
            'author'      => $current_user_id,
            'post_type'   => 'wheel-submissions',
            'posts_per_page' => 1,
            'order' => 'DESC'
        );
    }
    $cquery4 = new WP_Query( $args );
    $total_weight = 0;
    $total_answers = 0;
    $total_weight = 0;
    $total_answers = 0;
    $index_answers = 0;
    $group_points = 0;
    $ans_arr = array(); 
    $color_arr = array(); 
    $q_ans_arr = array();
    if ( $cquery4->have_posts() ) :
        while( $cquery4->have_posts() ) :
            $cquery4->the_post();
            $myvals = get_post_meta(get_the_ID());
            foreach($myvals as $key=>$val){
                $obj =  unserialize($val[0] );
                $q_dataset = $obj->datasets;
                $q_ans = $q_dataset[0]->data;

                $q_group_colors = $q_dataset[0]->backgroundColor;

                $m = 0;
                $j = 0; 
                foreach($q_ans as $answer){
                    $total_answers += $answer;
                    if( !in_array($q_group_colors[$j],$color_arr) ){
                        $color_arr[$j] =  $q_group_colors[$j]; 
                        $ans_arr[$j] =  $answer; 
                        $m++;
                    }else{
                        $index = array_search($q_group_colors[$j], $color_arr);
                        $ans_arr[$index] = $ans_arr[$index] + $answer;
                        $m++;
                    }
                    $q_ans_arr['color'] = array_values($color_arr);
                    $q_ans_arr['ans'] = array_values($ans_arr);
                    $total_weight++; 
                    $j++; 
                } 
            }
        endwhile;
        wp_reset_postdata();
    endif;
    $total_weight *= 5;    
    $total_score = $total_answers/$total_weight;
    $total_score *= 100;
    $total_score = round($total_score);
        // echo $total_score;
       //  return $total_answers;
   
    $color_code = strtolower('#EE00FF');
    foreach($q_ans_arr['color'] as $color_item){
        if( str_contains( $color_item, $color_code ) ){
            $index = $atts['group']-1;
            $group_points = $q_ans_arr['ans'][$index];
        }
    //    $n++;
    }

    
    $point_percent = $group_points/absint(15);
    $point_percent *= absint(100); 
    $point_percent  =  round($point_percent);
    echo $point_percent;
    // exit;
    // echo ob_get_contents();
    return ob_get_clean();
 }
function get_author_post(){
    $current_user_id = get_current_user_id();
    $author_posts = new WP_Query(array(
        'author'         => $current_user_id,
        'posts_per_page' => -1,
        'post_type'   => 'wheel-submissions',
    ));

    if( $author_posts->have_posts() ) {
        $count = $author_posts->found_posts;
    }
    return $count;
}
function shortcode_setup(){
    // add_shortcode('custom_assesments','custom_assesments_callback');	
    $count = get_author_post();
    if($count> 0 ){
        add_shortcode('group_total_score','group_points_callback');	
        add_shortcode('assesment_total_score','assesment_total_score_callback');
    }
}
function add_ajax( $action = false, $callback = false ) {
    if ( ! $action || ! $callback ) {
        return;
    }
    add_action( "wp_ajax_{$action}", $callback );
    add_action( "wp_ajax_nopriv_{$action}", $callback );
}
function custom_post_content(){
    $mind_flix_perfomance = get_option('mind_flix_perfomance');
    $custom_post_content =  do_shortcode( $mind_flix_perfomance );
    echo "<div class='show-custom-post-content custom-d-none'>$custom_post_content</div>";
}
function add_posttype_slug_template( $single_template ) {
	$object = get_queried_object();
    if( $object->post_type == 'wheel-submissions'){
        custom_post_content();
    }
    return $single_template;
}
function my_custom_script() {
    $count = get_author_post();
    $uri =  $request_uri = $_SERVER['REQUEST_URI'];
    $end_point = '/mindflix-assessment';
    if( str_contains($request_uri, $end_point) && $count > 0){
        echo get_elementor_shortcode();
        echo get_assessment_links();
    }
    if ( str_contains($uri, 'wheel-submissions') || str_contains($uri, 'assessment-submission') ) {  
        $post_id = get_the_ID();
        $meta_key = 'assess_submission_id';
        $meta_value = get_post_meta($post_id, $meta_key, true);
        $meta_value = str_replace("I am a Certified Coach with experience of over 5 years. I can help you transform your life and get it run smoothly.","", $meta_value);
        $submission_data =  '<div class="custom-submission_data custom-d-none">'.$meta_value.'</div>';
        $submission_data = str_replace('See Below How You Rank Against The PROs' , '' , $submission_data);
        echo $submission_data;
    }
    if ( str_contains($uri, 'mindflix-assessment') ) {  
        $option = get_option('popup_shortcode');
        echo '<div id="id01" class="w3-modal">';
            echo '<div class="w3-modal-content">';
                echo do_shortcode($option);
            echo '</div>';
        echo '</div>';
    }
}
function get_assessment_links(){

    $current_user_id = get_current_user_id();
    $args = array(
        'author'  => $current_user_id,
        'post_type'   => 'wheel-submissions',
        'posts_per_page' => 10,
        'order' => 'DESC'
    );
    $postslist = get_posts( $args );
    $assessment_link = '';
    $assessment_link .='<ul class="hidden-assessment-link" style="display: none;">';
    foreach ($postslist as $post) :  setup_postdata($post);
        $assessment_link .='<li>'.$post->guid.'</li>';
    endforeach;
    $assessment_link .= '</ul>';
    return $assessment_link;
}
function get_elementor_shortcode(){
    $output = '';
    $mind_flix_perfomance = get_option('mind_flix_perfomance');
    $output .= '<div class="custom-shortcode-con custom-fade-in">';
    $output .= '<div class=""><h2 class="wol-title yes">Dashboard</h2></div>';
    $output .= do_shortcode($mind_flix_perfomance);
    $output .= '</div>';
    $output .= '<div class="custom-shortcode-con2 custom-fade-in">';
    $output .= '<div class=""><h2 class="wol-title yes">Dashboard</h2></div>';
    $output .= do_shortcode($mind_flix_perfomance);
    $output .= '</div>';
    return $output;
}
function my_custom_header(){
    echo '<script type="text/javascript">
            var ajaxurl = "' . admin_url('admin-ajax.php') . '";
    </script>';
    echo '<div class="result custom-fade-in"></div>';
}