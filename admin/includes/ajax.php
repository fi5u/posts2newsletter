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

        // Find the last inserted ID to use for settings
        $last_id = $wpdb->insert_id;

        // Update active campaign setting with last added ID
        $table_name = $wpdb->prefix . "posts2newsletter";
        $strQuery = "UPDATE $table_name SET campaign = %d WHERE id = 1";
        $wpdb->query($wpdb->prepare( $strQuery, $last_id ) );

        echo $success;

        die();
    }