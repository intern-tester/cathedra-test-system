// INLINE MD
<?php 
$update = json_decode(file_get_contents('php://input'), TRUE);

    $botToken = getenv('API');
    $botAPI = "https://api.telegram.org/bot" . $botToken;

    // Check if callback is set
    if (isset($update['callback_query'])) {

        // Reply with callback_query data
        $data = http_build_query([
            'text' => 'Selected language: ' . $update['callback_query']['data'],
            'chat_id' => $update['callback_query']['from']['id']
        ]);
        file_get_contents($botAPI . "/sendMessage?{$data}");
    }

    // Check for normal command
    $msg = $update['message']['text'];
    if ($msg === "/start") {

        // Create keyboard
        $data = http_build_query([
            'text' => 'Please select language;',
            'chat_id' => $update['message']['from']['id']
        ]);
        $keyboard = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "english",
                        "callback_data" => "english"
                    ],
                    [
                        "text" => "russian",
                        "callback_data" => "russian"
                    ]
                ]
            ]
        ]);

        // Send keyboard
        file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
    }

?>
