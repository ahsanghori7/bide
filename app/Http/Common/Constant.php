<?php

namespace App\Http\Common;

class Constant
{
    public const SUPER_ADMIN_ROLE_ID = 1;
    public const DOCTOR_ROLE_ID = 2;
    public const EDUCATOR_ROLE_ID = 3;

    public const APPOINTMENT_STATUS_PENDING = "pending";
    public const APPOINTMENT_STATUS_PROGRESS = "in-progress";
    public const APPOINTMENT_STATUS_COMPLETED = "complete";
    public const APPOINTMENT_STATUS_CANCELLED = "cancel";
    public const APPOINTMENT_STATUS_CANCELLED_BY_USER = "cancelled by educator";
    public const APPOINTMENT_STATUS_CANCELLED_BY_DOCTOR = "cancelled by doctor";
    public const APPOINTMENT_STATUS_CANCELLED_BY_CS = "cancelled by system";


    public const QUEUE_STATUS_PROGRESS = "in-progress";
    public const QUEUE_STATUS_COMPLETED = "complete";
    public const QUEUE_STATUS_CANCELLED = "cancel";
    public const QUEUE_STATUS_WAITING = "waiting";
    public const QUEUE_STATUS_INQUEUE = "in-queue";

    public const APPOINTMENT_INSTANT_TIME = 1800;
    public const APPOINTMENT_IN_PERSON = 1800;

    public const APPOINTMENT_TYPE_INSTANT_VIDEO = "instant-consultation-video";
    public const APPOINTMENT_TYPE_INPERSON = "in-person";

    public const WAITING_QUEUE_STATUS_MOVED = "moved";
    public const WAITING_QUEUE_STATUS_ADDED = "added";

    public const EDUCATOR_QUEUE_STATUS_START = "in-progress";
    public const EDUCATOR_QUEUE_STATUS_COMPLETE = "complete";
}
