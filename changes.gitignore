<?php 
// Work with Heroku Config Vars
$namesite = getenv('copyright');
$token = getenv('API');
$bot_url = "https://api.telegram.org/bot" . $token;

$result = json_decode(file_get_contents('php://input'), true);


//if (isset($update['callback_query'])) {
//    $callback_query_data = $update['callback_query']['data'];
//}


// CALLBACK QUERY HANDLER
// $data = $data['callback_query']? $data['callback_query'] : $data['message'];
// $msg = mb_strtolower(($data['text']? $data['text'] : $data['data']), 'utf-8');


//$client = $result['callback_query']['from']['id'];
//$callback_query = $result['callback_query']['id'];
//$callback_data = $callback_query['data'];

// Initialisation Bot
$bot = new BOT();

if ($result['message']['text'] == '/start') {
    $bot->sendMessage($result['message']['chat']['id'], "Добро пожаловать!");
}elseif ($result['message']['text'] == '/info') {
    $bot->sendMessage($result['message']['chat']['id'], 'Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації.');
}elseif ($result['message']['text'] == '/img') {
    //$img = 'https://picsum.photos/200/300?random='.mt_rand(1, 5);
    $bot->sendPhoto($result['message']['chat']['id'], 'https://nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/doc') {
    $bot->sendDocument($result['message']['chat']['id'], 'https://nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/msg') {
    $bot->sendMessage($result['message']['chat']['id'], "Hello World!");
}elseif ($result['message']['text'] == '/inline') {
    //$bot->sendMessage($result['message']['chat']['id'], "Hello World!");
}elseif ($result['message']['text'] == '/message') {
    $keyboard = [
        ['7', '8', '9'],
        ['4', '5', '6'],
        ['1', '2', '3']
       ];
    $bot->sendMessage($result['message']['chat']['id'], "Выберите чысло от 0 до 9?", $keyboard);
}elseif ($result['message']['text'] == '/callback') {
    $bot->sendCallbackQuery($result['message']['chat']['id'], "CallBack?");
}

elseif ($result['message']['text'] == '/debug') {
    //file_put_contents('dump.txt', var_dump($result['message']));
    //sendDocument($result['message']['chat']['id'], 'dump.txt');
    //unlink('dump.txt');
}

//// Show Home Page Site. 
else{
  $content = '<h1>BOT SYSTEM v.0.1 alfa</h1>
<div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
      <p>© 2022 '.$namesite.', Inc. All rights reserved.</p>
      <ul class="list-unstyled d-flex"></ul>
    </div>
';
  
  print $bot->boostrap($content, 'Home page');
}


/*


'text' => 'Welcome ME!',
'reply_markup'=>[
    'resize_keyboard'=>true,
    'keyboard'=>[
        [
            ['text'=>'Button1'],
            ['text'=>'Button2'],
        ],
        [
            ['text'=>'Button3'],
            ['text'=>'Button4'],
        ]
    ]
]


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

*/

class BOT {
    
    //private $bot_url = "https://api.telegram.org/bot".getenv('API');

    function sendMessage($chat_id, $msg, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    

        $post_fields = array(
            'chat_id'   => $chat_id,
            //'resize_keyboard' => true, 
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
    
    function sendInlineKeyboard($chat_id, $msg){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
        
        $ReplyKeyboardMarkup = array(
            "keyboard" => array(
                array("1st row left", "1st row right"), 
                array("2nd row left", "2nd row right")
            )
        );
        
        //json_encode($ReplyKeyboardMarkup)

        //$replyMarkup = array(
        //    'keyboard' => $keyboard
        //);
        
        //$encodedMarkup = json_encode($replyMarkup); 
        
        

        //$post_fields = array(
        //    'chat_id'   => $chat_id,
        //    'resize_keyboard' => true, 
        //    'reply_markup' => json_encode($ReplyKeyboardMarkup),
        //    'text'     => $msg 
        //); 
        
        $post_fields = array(
            'chat_id' => $chat_id,
            'text' => $msg,
            'reply_markup' => json_encode(array(
            'keyboard' => array(
                array(
                    array(
                        'text' => 'YOUR BUTTON LABEL TEXT',
                        'url' => 'YOUR BUTTON URL',
                    ),
                )
            ),
            'one_time_keyboard' => TRUE,
            'resize_keyboard' => TRUE,
            )
         ));

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
    
    function sendCallbackQuery($chat_id, $reply, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
        
        $keyboard = array(
          "inline_keyboard" => array( // inline_keyboard not keyboard
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
          ) //Removed onetimekeyboard etc.
        );
        
        $postfields = array( 
          'chat_id' => $chat_id,
          'text' => $reply, 
          'reply_markup' => json_encode($keyboard) 
        );

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    

        $post_fields = array(
            'chat_id'   => $chat_id,
            //'resize_keyboard' => true, 
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
    
    function sendDocument($chat_id, $doc){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendDocument?chat_id=" . $chat_id ;

        $post_fields = array('chat_id'   => $chat_id,
            'document'     => new CURLFile($doc) 
        ); 
        // realpath("/path/to/image.png")
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
    
    function sendPhoto($chat_id, $photo){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendPhoto?chat_id=" . $chat_id ;

        $post_fields = array('chat_id'   => $chat_id,
            'photo'     => new CURLFile($photo) 
        ); 
        // realpath("/path/to/image.png")
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
    
    function boostrap($content, $title = "Home"){
    return '
        <!doctype html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>'.$title.'</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
          </head>
          <body>
            '.$content.'
          </body>
        </html>
    ';
}
}

/*
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
?>
