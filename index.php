// INLINE MD
<?php 
$update = json_decode(file_get_contents('php://input'), TRUE);

$botToken = getenv('API');
$botAPI = "https://api.telegram.org/bot" . $botToken;

$bot = new Bot();

    // Callback Query Handler
    if (isset($update['callback_query'])) {
        if($update['callback_query']['data'] == "access"){
            $bot->sendMessage($update['callback_query']['from']['id'], "You send CALLBACKDATA:" . $update['callback_query']['data']);
        }else{
            
            $data = http_build_query([
                'text' => 'Log: ' . $update['callback_query']['data'],
                'chat_id' => $update['callback_query']['from']['id']
            ]);
        file_get_contents($botAPI . "/sendMessage?{$data}");
        
        }

        // Reply with callback_query data
        //$data = http_build_query([
        //    'text' => 'Selected language: ' . $update['callback_query']['data'],
        //    'chat_id' => $update['callback_query']['from']['id']
        //]);
        //file_get_contents($botAPI . "/sendMessage?{$data}");
    }

    // Check for normal command
    $msg = $update['message']['text'];
    if ($msg === "/start") {
        $bot->sendInline($update['message']['from']['id']); 
    }elseif($msg === "/chat"){
        $bot->sendInline($update['message']['from']['id'], "");
    }else{
        print "Hello World!";
    }

/*

$keyboard = array(
    array("text" => "Access", "callback_data" => "access"),
    array("text" => "Deny", "callback_data" => "false")
);

*/


class Bot(){
    
    function sendMessage($chat, $msg){
        $data = http_build_query([
            'text' => $msg,
            'chat_id' => $chat
        ]);
        file_get_contents($botAPI . "/sendMessage?{$data}");
    }

    function sendInline($chat, $msg){
        $botToken = getenv('API');
        $botAPI = "https://api.telegram.org/bot" . $botToken;
        
        $data = http_build_query([
            'text' => $msg,
            'chat_id' => $chat
        ]);
        $keyboard = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "Access",
                        "callback_data" => "access"
                    ],
                    [
                        "text" => "False",
                        "callback_data" => "false"
                    ]
                ]
            ]
        ]);

        // Send keyboard
        file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
    }

}

?>
