<?php 

/**
 * Get absolute path
 * @var string asset
 * @return string absolute path
 */
function asset($asset = "") {
	if (isset($_SERVER['HTTPS'])) {
      return 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $asset;
    }
    
    return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $asset;
}

/**
 * Get a random password
 * @return string password
 */
function randomPassword() {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 *  Get an order ID 
 */
function randomOrderId() {
    $str = "";
    $characters = array_merge(range('A','Z'), range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < 5; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

/**
 * Display the span for boost : solo division, solo net win etc...
 * @param  array $order id, type etc..
 */
function displayDescriptionSpan($order) {
    // Span
    if ($order['type'] === "Division Boost") {
        if ($order['duo']) {
                 echo 'duo division'; 
        } else {
            echo 'solo division';
        }
    } else if ($order['type'] === "Net Wins") {
        if ($order['duo']) {
            echo 'duo net win'; 
        } else {
            echo 'solo net win';
        }
    } else if ($order['type'] === "Placement Matches") {
        if ($order['duo']) {
            echo 'duo placements'; 
        } else {
            echo 'solo placements';
        }
    }
}

/**
 * Display the description of a boost
 * @param  array $order id, type etc..
 */
function displayDescription($order) {
     // Text
     $description = App\Repository\OrderRepository::getInstance()->getOrderDetails($order['id'], $order['type']);
     if ($order['type'] === "Division Boost") {
          echo '<p>'.$description['start_league']." ".$description['start_division']." - ".$description['desired_league']." ".$description['desired_division'].'</p>';
     } else if ($order['type'] === "Net Wins") {
          echo '<p>'. $description['start_league'] . " " . $description['start_division'] . " - " . $description['game_amount']." Net Wins" . '</p>';
     } else if ($order['type'] === "Placement Matches") {
          echo '<p>'.$description['start_league'] . " " . $description['start_division'] . " - " . $description['game_amount']." Unranked Games".'</p>';
     } else if (strpos($order['type'], 'Coaching')) {
         echo '<p>'.$order['type'] . " - " . $description['start_league'] . " " . $description['start_division'] . "</p>";
     } else {
        echo '<p>Error, contact Webmaster to fix it.</p>';
     }
}

/**
 * Calculate the price with the percentage
 * @param  int $price      price
 * @param  int $percentage percentage
 * @return html             price
 */
function calcPrice($price, $percentage, $return = false) {
    if (!$return) {
        echo round(($percentage / 100) * $price, 2);
    } else {
        return round(($percentage / 100) * $price, 2);
    }
} 

/**
 * Return all champions of league of legends
 * @return array champions
 */
function getAllChampions() {
  return [
    'Aatrox',
    'Ahri',
    'Akali',
    'Alistar',
    'Amumu',
    'Anivia',
    'Annie',
    'Ashe',
    'Aurelion Sol',
    'Azir',
    'Bard',
    'Blitzcrank',
    'Brand',
    'Braum',
    'Caitlyn',
    'Camille',
    'Cassiopeia',
    'Cho Gath',
    'Corki',
    'Darius',
    'Diana',
    'Dr. Mundo',
    'Draven',
    'Ekko',
    'Elise',
    'Evelynn',
    'Ezreal',
    'Fiddlesticks',
    'Fiora',
    'Fizz',
    'Galio',
    'Gangplank',
    'Garen',
    'Gnar',
    'Gragas',
    'Graves',
    'Hecarim',
    'Heimerdinger',
    'Illaoi',
    'Irelia',
    'Ivern',
    'Janna',
    'Jarvan IV',
    'Jax',
    'Jayce',
    'Jhin',
    'Jinx',
    'Kai Sa',
    'Kalista',
    'Karma',
    'Karthus',
    'Kassadin',
    'Katarina',
    'Kayle',
    'Kayn',
    'Kennen',
    'Kha Zix',
    'Kindred',
    'Kled',
    'Kog Maw',
    'Leblanc',
    'Lee Sin',
    'Leona',
    'Lissandra',
    'Lucian',
    'Lulu',
    'Lux',
    'Malphite',
    'Malzahar',
    'Maokai',
    'Master Yi',
    'Miss Fortune',
    'Mordekaiser',
    'Morgana',
    'Nami',
    'Nasus',
    'Nautilus',
    'Nidalee',
    'Nocturne',
    'Nunu',
    'Olaf',
    'Orianna',
    'Ornn',
    'Pantheon',
    'Poppy',
    'Quinn',
    'Rakan',
    'Rammus',
    'Rek Sai',
    'Renekton',
    'Rengar',
    'Riven',
    'Rumble',
    'Ryze',
    'Sejuani',
    'Shaco',
    'Shen',
    'Shyvana',
    'Singed',
    'Sion',
    'Sivir',
    'Skarner',
    'Sona',
    'Soraka',
    'Swain',
    'Syndra',
    'Tahm Kench',
    'Taliyah',
    'Talon',
    'Taric',
    'Teemo',
    'Thresh',
    'Tristana',
    'Trundle',
    'Tryndamere',
    'Twisted Fate',
    'Twitch',
    'Udyr',
    'Urgot',
    'Varus',
    'Vayne',
    'Veigar',
    'Vel Koz',
    'Vi',
    'Viktor',
    'Vladimir',
    'Volibear',
    'Warwick',
    'Wukong',
    'Xayah',
    'Xerath',
    'Xin Zhao',
    'Yasuo',
    'Yorick',
    'Zac',
    'Zed',
    'Ziggs',
    'Zilean',
    'Zoé',
    'Zyra'
  ];
}