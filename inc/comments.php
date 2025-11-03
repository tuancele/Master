<?php
function html5blankcomments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    $tag = ('div' == $args['style']) ? 'div' : 'li';
    $add_below = ('div' == $args['style']) ? 'comment' : 'div-comment';
    ?>
    <div <?php comment_class(empty($args['has_children']) ? 'item_comment' : 'parent item_comment') ?> id="comment-<?php comment_ID() ?>">
        <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment_left"><svg><use xlink:href="#avatar"></use></svg></div>
        <div class="comment_right">
            <div class="comment-name">
                <?php printf(__('<span class="fn">%s</span>'), get_comment_author_link()); ?>
                <?php if (is_super_admin($comment->user_id)) { ?>
                    <b class="qtv"><?php _e('Moderator', 'master-gf') ?></b>
                <?php } ?>
            </div>
            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em><br />
            <?php endif; ?>
            <?php comment_text() ?>
            <div class="info_feeback">
                <?php printf(__('<span style="color:#000;font-size: 13px;">%1$s</span>'), get_comment_date()) ?>
                <?php if ($rating = get_comment_meta($comment->comment_ID, 'rating', true)) { ?>
                    <div class="pull-right"><i class="celeicon icon-star star<?php echo esc_attr($rating); ?>"></i></div>
                <?php } ?>
            </div>
        </div>
        <?php if ('div' != $args['style']) : ?>
        </div>
        <?php endif; ?>
    <?php
}
add_action('get_header', 'enable_threaded_comments');
function enable_threaded_comments() {
    if (!is_admin() && is_singular() && comments_open() && get_option('thread_comments') == 1) {
        wp_enqueue_script('comment-reply');
    }
}

function ci_comment_rating_rating_field() {
    ?>
    <label for="rating">Đánh giá cho dự án:</label>
    <fieldset class="comments-rating">
        <span class="rating-container">
            <?php for ($i = 10; $i >= 1; $i--) : ?>
                <input type="radio" id="rating-<?php echo esc_attr($i); ?>" name="rating" value="<?php echo esc_attr($i); ?>" /><label for="rating-<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></label>
            <?php endfor; ?>
            <input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0" /><label for="rating-0">0</label>
        </span>
    </fieldset>
    <?php
}
// add_action('comment_form_logged_in_after', 'ci_comment_rating_rating_field');
// add_action('comment_form_before_fields', 'ci_comment_rating_rating_field');

function ci_comment_rating_save_comment_rating($comment_id) {
    if (isset($_POST['phone']) && $_POST['phone'] != '') {
        $phone = wp_filter_nohtml_kses($_POST['phone']);
        add_comment_meta($comment_id, 'phone', $phone);
    }
    if (isset($_POST['rating']) && '' !== $_POST['rating']) {
        $rating = intval($_POST['rating']);
        add_comment_meta($comment_id, 'rating', $rating);
    }
}
add_action('comment_post', 'ci_comment_rating_save_comment_rating');

function ci_comment_rating_get_average_ratings($id) {
    $comments = get_approved_comments($id);
    if ($comments) {
        $i = 0;
        $total = 0;
        foreach ($comments as $comment) {
            $rate = get_comment_meta($comment->comment_ID, 'rating', true);
            if (isset($rate) && '' !== $rate) {
                $i++;
                $total += $rate;
            }
        }
        return ($i === 0) ? false : round($total / $i, 1);
    }
    return false;
}

function ci_comment_rating_get_total_ratings($id) {
    $comments = get_approved_comments($id);
    if ($comments) {
        $i = 0;
        foreach ($comments as $comment) {
            $rate = get_comment_meta($comment->comment_ID, 'rating', true);
            if (isset($rate) && '' !== $rate) {
                $i++;
            }
        }
        return ($i === 0) ? false : $i;
    }
    return false;
}

function wpsites_comment_form_fields($fields) {
    unset($fields['author']);
    unset($fields['email']);
    unset($fields['url']);
    unset($fields['cookies']);
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields['author'] = '<p class="comment-author"><input aria-label="Comment" placeholder="' . __('Your name (*)', 'master-gf') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />';
    $fields['phone'] = '<input aria-label="Your phone" placeholder="' . __('Your phone (*)', 'master-gf') . '" id="phone" name="phone" type="number" size="11"' . $aria_req . ' />';
    $fields['email'] = '<input id="email" aria-label="Your Name" placeholder="' . __('Your email (*)', 'master-gf') . '" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>';
    return $fields;
}
add_filter('comment_form_default_fields', 'wpsites_comment_form_fields');

function comment_add_meta_box() {
    add_meta_box('my-comment-title', __('Số điện thoại'), 'comment_meta_box_age', 'comment', 'normal', 'high');
}
add_action('add_meta_boxes_comment', 'comment_add_meta_box');

function comment_meta_box_age($comment) {
    $title = get_comment_meta($comment->comment_ID, 'phone', true);
    ?>
    <p>
        <label for="phone"><?php echo esc_attr($title); ?></label>
    </p>
    <?php
}
?>