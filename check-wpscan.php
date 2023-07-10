<?php

$wpscan_token = $_ENV['WPSCAN_TOKEN'];
$wp_content_path = $_ENV['WP_CONTENT_PATH'];

echo $wpscan_token;
echo $wp_content_path;
exit(1);