<?php
    function save_campaign_callback() {
        global $wpdb;
        $success = 0;
        $table_name = $wpdb->prefix . "posts2newsletter_campaigns";
        $result = $wpdb->query( $wpdb->prepare("
                INSERT INTO $table_name
                ( name, post_ids )
                VALUES ( %s, %s )",
                $_POST['name'],
                $_POST['post_ids']
                ));

        if ($result > 0) {
            $success = 1;
        }

        echo $success;

        die();
    }