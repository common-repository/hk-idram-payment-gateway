<?php

add_action('admin_init', 'pluginActivateHKDIdram');
if (!function_exists('pluginActivateHKDIdram')) {
    function pluginActivateHKDIdram()
    {
        global $apiUrlIdram;
        global $pluginDataIdram;
        $pluginVersion = $pluginDataIdram['Version'];
        if (get_option('hkd_idram_version_option') !== $pluginVersion) {
            try {
                if (isset($_SERVER['SERVER_NAME']) || isset($_SERVER['REQUEST_URI'])) {
                    $url = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['REQUEST_URI'];
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $token = md5('hkd_init_banks_gateway_class');
                    $user = wp_get_current_user();
                    $email = (string)$user->user_email;
                    $data = ['version' => $pluginVersion, 'email' => $email, 'url' => $url, 'ip' => $ip, 'token' => $token, 'status' => 'inactive'];
                    update_option('hkd_idram_version_option', $pluginVersion);
                    wp_remote_post($apiUrlIdram . 'bank/idram/pluginActivate', [
                        'headers' => array('Accept' => 'application/json'),
                        'sslverify' => false,
                        'body' => $data]);
                }
            } catch (Exception $e) {
            }
        }
    }
}

