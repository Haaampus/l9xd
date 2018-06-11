<?php 

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Repository\BoosterRepository;
use App\Library\PHPMailer\PHPMailer;
use App\Config;
use App\Database;
use App\Mail;
use App\Router\Router;
use PayPal\Api\Order;

/**
 * Controller to manage order buy
 */
class OrderController extends Controller {

	public function getPrice() {
        /**
         * Variables to change prices of division boost, win boost, placement boost
        */

        // Duo percentage
        $duo_price = 1.5;

        /*
        DIVISION BOOST
        */

        // Unrankd Price :
        $Unranked = 5;

        // Bronze Prices :
        $Bronze_5 = 10; // Bronze 5 to Bronze 4
        $Bronze_4 = 10; // Bronze 4 to Bronze 3
        $Bronze_3 = 10; // Bronze 3 to Bronze 2
        $Bronze_2 = 10; // Bronze 2 to Bronze 1
        $Bronze_promo = 13; // Bronze 1 to Silver 5

        // Silver Prices :
        $Silver_5 = 14; // Silver 5 to Silver 4
        $Silver_4 = 15;// Silver 4 to Silver 3
        $Silver_3 = 16; // Silver 3 to Silver 2
        $Silver_2 = 17; // Silver 2 to Silver 1
        $Silver_promo = 21; // Silver 1 to Gold 5

        // Gold Prices :
        $Gold_5 = 23; // Gold 5 to Gold 4
        $Gold_4 = 25; // Gold 4 to Gold 3
        $Gold_3 = 28; // Gold 3 to Gold 2
        $Gold_2 = 31; // Gold 2 to Gold 1
        $Gold_promo = 35; // Gold 1 to Platinum 5

        // Platinum Prices :
        $Platinum_5 = 40; // Platinum 5 to Platinum 4
        $Platinum_4 = 44; // Platinum 4 to Platinum 3
        $Platinum_3 = 48; // Platinum 3 to Platinum 2
        $Platinum_2 = 54; // Platinum 2 to Platinum 1
        $Platinum_promo = 60; // Platinum 1 to Diamond 5

        // Diamond Prices :
        $Diamond_5 = 100; // Diamond 5 to Diamond 4
        $Diamond_4 = 120; // Diamond 4 to Diamond 3
        $Diamond_3 = 155; // Diamond 3 to Diamond 2
        $Diamond_2 = 180; // Diamond 2 to Diamond 1
        $Diamond_promo = 300; // Diamond 1 to Master 1

        // Challenger prices :
        $Challenger = 899;



        /**
         * WINS BOOST
         */

        // Bronze Prices
        $wins_Bronze_5 = 2.5; // Bronze 5 Price for 1 win
        $wins_Bronze_4 = 2.5; // Bronze 4 Price for 1 win
        $wins_Bronze_3 = 2.5; // Bronze 3 Price for 1 win
        $wins_Bronze_2 = 2.5; // Bronze 2 Price for 1 win
        $wins_Bronze_1 = 2.9; // Bronze 1 Price for 1 win

        // Silver Prices
        $wins_Silver_5 = 3.2; // Silver 5 Price for 1 win
        $wins_Silver_4 = 3.2; // Silver 4 Price for 1 win
        $wins_Silver_3 = 3.2; // Silver 3 Price for 1 win
        $wins_Silver_2 = 3.5; // Silver 2 Price for 1 win
        $wins_Silver_1 = 3.7; // Silver 1 Price for 1 win

        // Gold Prices
        $wins_Gold_5 = 4.5; // Gold 5 Price for 1 win
        $wins_Gold_4 = 4.6; // Gold 4 Price for 1 win
        $wins_Gold_3 = 5.1; // Gold 3 Price for 1 win
        $wins_Gold_2 = 5.5; // Gold 2 Price for 1 win
        $wins_Gold_1 = 6.1; // Gold 1 Price for 1 win

        // Platinum Prices
        $wins_Platinum_5 = 7.2; // Platinum 5 Price for 1 win
        $wins_Platinum_4 = 7.9; // Platinum 4 Price for 1 win
        $wins_Platinum_3 = 8.3; // Platinum 3 Price for 1 win
        $wins_Platinum_2 = 8.9; // Platinum 2 Price for 1 win
        $wins_Platinum_1 = 10; // Platinum 1 Price for 1 win

        // Diamond Prices
        $wins_Diamond_5 = 14; // Diamond 5 Price for 1 win
        $wins_Diamond_4 = 19; // Diamond 4 Price for 1 win
        $wins_Diamond_3 = 25; // Diamond 3 Price for 1 win
        $wins_Diamond_2 = 30; // Diamond 2 Price for 1 win
        $wins_Diamond_1 = 35.9; // Diamond 1 Price for 1 win

        // Master & Challenger Prices
        $wins_Master = 50.5;
        $wins_Challenger = 90;



        /**
         * PLACEMENT BOOST
         */

        // Prices
        $placement_Unranked = 4.5; // Unranked placement price for 1 win
        $placement_Bronze = 2.5; // Bronze placement price for 1 win
        $placement_Silver = 3.5; // Silver placement price for 1 win
        $placement_Gold = 4.0; // Gold placement price for 1 win
        $placement_Platinum = 5.5; // Platinum placement price for 1 win
        $placement_Diamond = 8; // Diamond placement price for 1 win

		/**
		 * Get price
		 */

		$tiers = array(
				"Unranked" => 0,
				"Bronze V" => 1,
				"Bronze IV" => 2,
				"Bronze III" => 3,
				"Bronze II" => 4,
				"Bronze I" => 5,
				"Silver V" => 6,
				"Silver IV" => 7,
				"Silver III" => 8,
				"Silver II" => 9,
				"Silver I" => 10,
				"Gold V"   => 11,
				"Gold IV"   => 12,
				"Gold III"   => 13,
				"Gold II"   => 14,
				"Gold I"   => 15,
				"Platinum V" => 16,
				"Platinum IV" => 17,
				"Platinum III" => 18,
				"Platinum II" => 19,
				"Platinum I" => 20,
				"Diamond V"  => 21,
				"Diamond IV"  => 22,
				"Diamond III"  => 23,
				"Diamond II"  => 24,
				"Diamond I"  => 25,
				"Master" => 26,
				"Challenger" => 27
			);

		$lp = array(
			"0-20"  => 0,
			"21-40" => 1,
			"41-60" => 2,
			"61-80" => 3,
			"81-100" => 4
		);

		// Cost of LP for a division
		$lpCost = array(
			0, 5, 10, 15, 20
		);

			// Division prices
			if($_POST['type'] === "division")
			{
				$costs = array(
					$Unranked,
					$Bronze_5,$Bronze_4,$Bronze_3,$Bronze_2,$Bronze_promo, // Bronze V, Bronze IV, Bronze III, Bronze II, Bronze I -> Silver V
		            $Silver_5,$Silver_4,$Silver_3,$Silver_2,$Silver_promo, // Silver V, Silver IV, Silver III, Silver II, Silver I -> Gold V
		            $Gold_5,$Gold_4,$Gold_3,$Gold_2,$Gold_promo, // Gold V, Gold IV, Gold III, Gold II, Gold I -> Platinum V
		            $Platinum_5,$Platinum_4,$Platinum_3,$Platinum_2,$Platinum_promo,// Platinum V, Platinum IV, Platinum III, Platinum II, Platinum I -> Diamond V
		            $Diamond_5,$Diamond_4,$Diamond_3,$Diamond_2,$Diamond_promo,  // Diamond V, Diamond IV, Diamond III, Diamond II, Diamond I -> Master I
		            $Challenger // Challenger price
				);

				// Get variables
				$actual = $_POST['current_rank'];
				$desired = $_POST['desired_rank'];
				$actual = $tiers[$actual];
				$desired = $tiers[$desired];

			$price = 0;
			if ($actual < $desired) 
			{
				for ($i = $actual ; $i < $desired ; $i++)
				{
					$price += $costs[$i];
				}

				if($_POST['isDuo'] == 1) {
					$price = $price * $duo_price;
				}

				echo $price;
				
			}else{
				echo $price;
			}

		} else if ($_POST['type'] === 'win') {

			$costs = array(
					0,$wins_Bronze_5,$wins_Bronze_4,$wins_Bronze_3,$wins_Bronze_2,$wins_Bronze_1,
		            $wins_Silver_5,$wins_Silver_4,$wins_Silver_3,$wins_Silver_2,$wins_Silver_1,
		            $wins_Gold_5,$wins_Gold_4,$wins_Gold_3,$wins_Gold_2,$wins_Gold_1,
		            $wins_Platinum_5,$wins_Platinum_4,$wins_Platinum_3,$wins_Platinum_2,$wins_Platinum_1,
		            $wins_Diamond_5,$wins_Diamond_4,$wins_Diamond_3,$wins_Diamond_2,$wins_Diamond_1,
		            $wins_Master, $wins_Challenger
				);

				$actual = $_POST['current_rank'];
				$actual = $tiers[$actual];
				$amount = $_POST['wins_number'];

				$price = $costs[$actual] * $amount;

				if($_POST['isDuo'] == 1) {
					$price = $price * $duo_price;
				}

				echo $price;

		} else if ($_POST['type'] === 'placement') {

			$tiers = array(
					"Unranked" => 0,
					"Bronze" => 1,
					"Silver" => 2,
					"Gold" => 3,
					"Platinum" => 4,
					"Diamond" => 5
				);

					$costs = array(
					$placement_Unranked, $placement_Bronze, $placement_Silver, $placement_Gold,
					$placement_Platinum, $placement_Diamond
				);

				$actual = $_POST['current_rank'];
				$actual = $tiers[$actual];
				$amount = $_POST['wins_number'];
				
				$price = $costs[$actual] * $amount;

				if($_POST['isDuo'] == 1) {
					$price = $price * $duo_price;
				}

				echo $price;

		}
	}

	public function countOrders($servers) {
	    if ($servers === "false") {
            echo OrderRepository::getInstance()->countOrders($servers);
        } else {
	        echo OrderRepository::getInstance()->countOrders($servers);
        }
    }

}