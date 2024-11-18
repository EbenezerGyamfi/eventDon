<?php

return [

    /*
Cost of creating an event
    */

    'eventCost' => (float) env('EVENT_COST', 50),

    'smsCost' => (float) env('SMS_COST', 0.25),

    'voiceMessageCost' => (float) env('VOICE_MESSAGE_COST', 0.20),

    'devMail' => env('DEV_MAIL', 'dev@eventsdon.com'),

    'apiLimit' => (int) env('API_LIMIT', 10000),

    'enableBackups' => (bool) env('ENABLE_BACKUP', true),

];
