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
        <button class="action-bar__btn--new" id="btn-new-template">New Template</button>
    </section>

    <section class="active-template">
        <div class="active-template__header">
            <h3 class="active-template__title">Active Template</h3>
        </div>
        <div class="active-template__body">
            <label for="active-template__name">Name</label>
            <input type="text" class="active-template__name" name="input-active-name" id="input-active-name">
            <div class="active-template__base-html">
                <h4>Base HTML</h4>
                <textarea name="txt-active-base" id="txt-active-base" class="active-template__base-html-txt"></textarea>
            </div>
            <div class="active-template__post-html">
                <h4>Post layout HTML</h4>
                <textarea name="txt-active-post" id="txt-active-post" class="active-template__post-html-txt"></textarea>
            </div>
        </div>
        <footer class="active-template__footer">
            <button class="active-template__save" id="btn-save-template">Save Template</button>
        </footer>
    </section>
</div>
