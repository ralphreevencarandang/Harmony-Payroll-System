<?php


if (!function_exists('log_activity')) {
    function log_activity($activity, $user_id = null)
    {
        $activityLogModel = new \App\Models\ActivityLogModel();
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        if ($ipAddress === '::1') {
            $ipAddress = '127.0.0.1';
        }

        $data = [
            'user_id'  => $user_id,
            'activity' => $activity,
            'ip_address' => $ipAddress,
        ];

        $activityLogModel->insert($data);
    }
}


