/// //// //// NOTES

/*


$options[][] = array('text' => 'Your text', 'callback_data' => 'test-data');
$replyMarkup = array('inline_keyboard' => $options);
$encodedMarkup = json_encode($replyMarkup, true);



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

$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

$keyboard = array(
  "inline_keyboard" => array( 
    array(
      array( 
        "text" => "Button1", 
        "callback_data" => "1", 
      ), 
      array( 
        "text" => "Button2", 
        "callback_data" => "2", 
      ), 
    )
  ) 
);



//$client = $result['callback_query']['from']['id'];
//$callback_query = $result['callback_query']['id'];
//$callback_data = $callback_query['data'];

*/

/*

function sms($data){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        file_get_contents($bot_url . "/sendMessage?{$data}");
    }  


// Worked sendMessage with keyboard
function sendMessage($chat_id, $msg){
$bot_url    = "https://api.telegram.org/bot".getenv('API');
$url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
    
$replyMarkup = array(
    'keyboard' => array(
        array("A", "B")
    )
);
$encodedMarkup = json_encode($replyMarkup);    

$post_fields = array(
    'chat_id'   => $chat_id,
    'reply_markup' => $encodedMarkup,
    'text'     => $msg 
); 
    
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:multipart/form-data"
));
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
$output = curl_exec($ch);
}


*/



// Simple Send Messsage file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('Welcom on ONSET'));
// //file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації. '));
