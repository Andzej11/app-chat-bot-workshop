<?php
include (__DIR__ . '/vendor/autoload.php');

$access_token = 'EAAWLvOawbK4BAJyABCAymjr5ghnRsOKvQvosaRGKA1EyTVZBGqQBsMdc7vh1EhsgsoOqvc9ZCTCqJ9JATiFQsBCMOIIB8NM6xZAtsFhVw3rXQrrPKV1ydZA8k0J24Nrrr8VjUJkS0VqlrZBZCvhwCWUoAhDgnwRNoxnZCyntO8ZANoT8BxZBdYMux';
$verify_token = 'TOKEN';
$appId = '1561018323987630';
$appSecret = '9a36b461b8e0e6554cb93fc37a660987';

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    if ($_REQUEST['hub_verify_token'] === $verify_token) {
        echo $challenge; die();
    }
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
    exit;
}

$message = $input['entry'][0]['messaging'][0]['message']['text'];
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];

$fb = new \Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
]);

$data = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
        'text' => 'You wrote: ' . $message,
    ]
];

$response = $fb->post('/me/messages', $data, $access_token);
