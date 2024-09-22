<?php

namespace App\Services;

class StatusMappingService
{
    public static function mapStatus($dbStatus)
    {
        $statusMappings = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'waiting' => 'Waiting',
            'in-queue' => 'In-Queue',
            'complete' => 'Completed',
            'start' => 'Started',
            'cancel' => 'Cancelled',
            'online' => 'Online',
            'in-call' => 'INCALL',
            'in-progress' => 'In Progress',
            'in-call-serving' => 'Serving Patient',
            'instant-consultation-video' => 'Video',
            'in-person' => 'In Person',

        ];

        return $statusMappings[$dbStatus] ?? 'Unknown';
    }
}
