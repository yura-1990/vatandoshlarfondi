<?php

namespace App\Models\Notification;

class NotificationUser extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['user_id', 'notification_id', 'is_read',];

    protected $primaryKey = 'notification_id';

    public $timestamps = false;
}
