<?php 
// Work with Heroku Config Vars
$namesite = getenv('copyright');
$token = getenv('API');
$bot_url = "https://api.telegram.org/bot" . $token;

$result = json_decode(file_get_contents('php://input'), true);

// Initialisation Bot
$bot = new BOT();

// CALLBACK QUERY HANDLER
if (isset($result['callback_query'])) {
        if($result['callback_query']['data'] == "data-access"){
                $bot->sendMessage($result['callback_query']['from']['id'], "Дякуємо. Ви надали доступ до персональної інформації");
        }elseif($result['callback_query']['data'] == "data-depression-start"){
                $bot->sendMessage($result['callback_query']['from']['id'], "Розпочинаємо тест депресії");
        }elseif($result['callback_query']['data'] == "data-end"){
                $bot->sendMessage($result['callback_query']['from']['id'], "Шкода, що ми не змогли Вам допомогти. ");
        }
        
        empty($result['callback_query']);
        //$bot->sendMessage($result['callback_query']['from']['id'], "Ви вибрали доступ:" . $result['callback_query']['data']);
}



if ($result['message']['text'] == '/start') {
    $bot->sendMessage($result['message']['chat']['id'], "Вітаємо Вас. Користуючись цим ботом ми можемо гарантувати Вам безмеку Ваших персональних даних, все що ви заповнюєте у даному боті є асолютно конфедінційними. Для продовження перейдіть до розділу надання конфедінційної інформації /access!");
}elseif ($result['message']['text'] == '/info') {
    $bot->sendMessage($result['message']['chat']['id'], 'Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації.');
}elseif ($result['message']['text'] == '/chat') {
    // NEW INLINE MESSAGE    
    $keyboard = [ ['text' => 'Yes', 'callback_data' => 'data-access'] ];
    $bot->sendNewButton($result['message']['chat']['id'], "Ви погоджуєтесь надати згоду на обробку персональних даних?", $keyboard);
    //$bot->sendInline($result['message']['chat']['id'], "Ви погоджуєтесь надати згоду на обробку персональних даних?");
    //$bot->sendMessage($result['message']['chat']['id'], 'Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації.');
}elseif ($result['message']['text'] == '/img') {
    //$img = 'https://picsum.photos/200/300?random='.mt_rand(1, 5);
    $bot->sendPhoto($result['message']['chat']['id'], 'https://nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/doc') {
    $bot->sendDocument($result['message']['chat']['id'], 'https://nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/access') {
    //$keyboard = ['text' => 'Так', 'callback_data' => 'data-access'];    
    $keyboard = [
        ['text' => 'Так', 'callback_data' => 'data-access'], ['text' => 'Ні', 'callback_data' => 'data-access']
    ]; 
            
    $bot->sendInline($result['message']['chat']['id'], "Я надаю згоду на обробку моєї персональної інформації. ", $keyboard);    
}elseif ($result['message']['text'] == '/keyboard') {
    $keyboard = [
        ['7', '8', '9'],
        ['4', '5', '6'],
        ['1', '2', '3']
       ];
    $bot->sendMessage($result['message']['chat']['id'], "Выберите чысло от 0 до 9?", $keyboard);
}elseif ($result['message']['text'] == '/newbutton') {  
    $keyboard = [ ['Yes', 'No'] ];
    $bot->sendNewButton($result['message']['chat']['id'], "Новая клавиатура.", $keyboard);    
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

class BOT {  

    function sendMessage($chat_id, $msg, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    

        $post_fields = array(
            'chat_id'   => $chat_id,
            'resize_keyboard' => true, 
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
        
    function sendInline($chat_id, $msg, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ; 
            
        ////////// OPTIONS ////////////////
        //$options[][] = array('text' => 'Так', 'callback_data' => 'data-access');
        $options[][] = $keyboard;  
        $replyMarkup = array('inline_keyboard' => $options);
        $encodedMarkup = json_encode($replyMarkup, true);    
        ///////////////////////////////////  

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
    
    // WORKED INLINE     
    function sendNewButton($chat_id, $msg, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;

        //$replyMarkup = array(
        //    'keyboard' => $keyboard
        //);
        
        //$encodedMarkup = json_encode($replyMarkup);    
            
        //////////////////////////
        $options[][] = array('text' => 'Так', 'callback_data' => 'data-access');
        $replyMarkup = array('inline_keyboard' => $options);
        $encodedMarkup = json_encode($replyMarkup, true);    
        /////////////////////////    

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
        // realpath("/path/to/image.png")   // if its real file on local server
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
?>
