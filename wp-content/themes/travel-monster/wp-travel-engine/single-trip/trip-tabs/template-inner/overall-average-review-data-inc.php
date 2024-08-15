<?php
$idNum = (!isset($id)) || (isset($id) && empty($id))? get_the_ID() : $id;
$review_obj                = new Wte_Trip_Review_Init();
$wp_travel_engine_settings = get_option('wp_travel_engine_settings');
$comment_datas             = $review_obj->pull_comment_data( $idNum );
$review_repsonse_texts     = $review_obj->overall_textlist_of_responses();
$review_emoticons_list     = $review_obj->emoticon_lists();
$emoticon_option           = isset( $wp_travel_engine_settings['trip_reviews']['show_emoticons'] ) ? esc_attr( $wp_travel_engine_settings['trip_reviews']['show_emoticons'] ) : '';

if (!empty($comment_datas)) {
remove_filter( 'the_content', 'wpautop' );
?>
<div class="overall-rating-wrap" id="tmp-overall-rating">
    <div class="rating-bar-outer-wrap">
        <?php if(!empty($emoticon_option)){ ?>
            <span class="review-emoji-icon"><?php echo apply_filters("the_content", $review_emoticons_list["excellent_icon"]);?></span>
        <?php } ?>
        <span class="trip-review-response-text"><?php echo $review_repsonse_texts['excellent_label'];?></span>
        <div class="rating-bar">
            <div class="rating-bar-inner" data-percent="<?php echo round($comment_datas['five_stars_percent'], 2);?>">
                <span class="percent"><?php echo $comment_datas['five_stars'];?></span>
            </div>
        </div>
    </div>
    <div class="rating-bar-outer-wrap">
        <?php if(!empty($emoticon_option)){ ?>
            <span class="review-emoji-icon"><?php echo apply_filters('the_content', $review_emoticons_list['vgood_icon']); ?></span>
        <?php } ?>
        <span class="trip-review-response-text"><?php echo $review_repsonse_texts['vgood_label'];?></span>
        <div class="rating-bar">
            <div class="rating-bar-inner" data-percent="<?php echo round($comment_datas['four_stars_percent'], 2);?>">
                <span class="percent"><?php echo $comment_datas['four_stars'];?></span>
            </div>
        </div>
    </div>
    <div class="rating-bar-outer-wrap">
        <?php if(!empty($emoticon_option)){ ?>
            <span class="review-emoji-icon"><?php echo apply_filters('the_content', $review_emoticons_list['average_icon']);?></span>
        <?php } ?>
        <span class="trip-review-response-text"><?php echo $review_repsonse_texts['average_label'];?></span>
        <div class="rating-bar">
            <div class="rating-bar-inner" data-percent="<?php echo round($comment_datas['three_stars_percent'], 2);?>">
                <span class="percent"><?php echo $comment_datas['three_stars'];?></span>
            </div>
        </div>
    </div>
    <div class="rating-bar-outer-wrap">
        <?php if(!empty($emoticon_option)){ ?>
        <span class="review-emoji-icon"><?php echo apply_filters('the_content', $review_emoticons_list['poor_icon']);?></span>
        <?php } ?>
        <span class="trip-review-response-text"><?php echo $review_repsonse_texts['poor_label'];?></span>
        <div class="rating-bar">
            <div class="rating-bar-inner" data-percent="<?php echo round($comment_datas['two_stars_percent'], 2);?>">
                <span class="percent"><?php echo $comment_datas['two_stars'];?></span>
            </div>
        </div>
    </div>
    <div class="rating-bar-outer-wrap">
        <?php if(!empty($emoticon_option)){ ?>
        <span class="review-emoji-icon"><?php echo apply_filters('the_content', $review_emoticons_list['terrible_icon']);?></span>
        <?php } ?>
        <span class="trip-review-response-text"><?php echo $review_repsonse_texts['terrible_label'];?></span>
        <div class="rating-bar">
            <div class="rating-bar-inner" data-percent="<?php echo round($comment_datas['one_stars_percent'], 2);?>">
                <span class="percent"><?php echo $comment_datas['one_stars'];?></span>
            </div>
        </div>
    </div>
</div>
<?php 
apply_filters( 'the_content', 'wpautop' );
}
