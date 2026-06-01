
<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'support-chat.{chatId}',
    function ($user, $chatId) {

        return true;
    }
);
