<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Posts2newsletter
 * @author    Tommy Fisher <tommybfisher@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014
 */
?>

<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <section class="action-bar">
        <button class="action-bar__btn--new" id="btn-new-campaign">New Campaign</button>
    </section>

    <section class="active-campaign">
        <div class="active-campaign__header">
            <h3 class="active-campaign__title">Active Campaign</h3>
        </div>
        <div class="active-campaign__body">
            <label for="input-active-campaign-name">Name</label>
            <input type="text" class="active-campaign__name" name="input-active-campaign-name" id="input-active-campaign-name">
            <?php // Count regular published posts, if any exist show them
            $count_posts = wp_count_posts();
            $published_posts = $count_posts->publish;
            if ($published_posts > 0) :
            ?>
            <div class="active-campaign__select--from">
                <h4 class="active-campaign__select-title">Posts</h4>
                <ul class="active-campaign__select-group">
                    <?php // Display regular posts
                    $args = array( 'posts_per_page' => -1 );
                    $postslist = get_posts($args);
                    foreach ($postslist as $post) : setup_postdata($post);
                    ?>

                    <li class="active-campaign__select-item" id="post-<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></li>

                    <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <?php
            endif; // Are published posts
            ?>

            <?php
            $args = array(
               'public'   => true,
               '_builtin' => false
            );

            $output = 'objects';
            $post_types = get_post_types($args, $output);
            foreach ($post_types as $post_type) :
            ?>

            <?php // Count published custom posts, if any exist show them
            $count_posts = wp_count_posts($post_type->name);
            $published_posts = $count_posts->publish;
            if ($published_posts > 0) :
            ?>
            <div class="active-campaign__select--from">
                <h4 class="active-campaign__select-title"><?php echo $post_type->label; ?></h4>
                <ul class="active-campaign__select-group">
                    <?php
                    $args = array( 'posts_per_page' => -1, 'post_type' => $post_type->name );
                    $postslist = get_posts($args);
                    foreach ($postslist as $post) : setup_postdata( $post );
                    ?>

                    <li class="active-campaign__select-item" id="post-<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></li>

                    <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>

            <?php
            endif; // Are published custom posts
            ?>

            <?php
            endforeach;
            ?>

            <div class="active-campaign__select--to">
                <h4 class="active-campaign__select-title">Selected posts</h4>
                <ol class="active-campaign__select-group" id="active-campaign-posts">
                    <li class="placeholder">To here</li>
                </ol>
            </div>
        </div>
        <footer class="active-campaign__footer">
            <button class="active-campaign__save" id="btn-save-campaign">Save Campaign</button>
        </footer>
    </section>

</div>