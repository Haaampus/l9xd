<?php 

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Repository\BoosterRepository;
use App\Library\PHPMailer\PHPMailer;
use App\Config;
use App\Database;
use App\Mail;
use App\Router\Router;

/**
 * Controller to manage pages
 */
class PageController extends Controller {

	public function home() {
		$this->view('website.home');
	}

	public function terms_of_services() {
		$this->view('website.termsofservices');
	}

	public function our_services() {
		$this->view('website.ourservices');
	}

	public function our_team() {
		$this->view('website.ourteam');
	}

	public function past_orders() {
		$this->view('website.pastorders');
	}

	public function faq() {
		$this->view('website.faq');
	}

	public function contact() {
		$this->view('website.contact');
	}

	public function coaching() {
	    $this->view('website.coaching');
    }

	public function postContact() {
		try {
			$html_message = "<p>New contact from the form on the website :</p><br/>";
			$html_message .= "<ul>";
			$html_message .= "<li>Email : " . $_POST['email'] . "</li>";
			$html_message .= "<li>Subject : " . $_POST['subject'] . "</li>";
			$html_message .= "<li>Message : " . $_POST['message'] . "</li>";
			$html_message .= "</ul><br>";

			Mail::send(Config::WEBSITE_NAME . ' - Contact Form', Config::YOUR_EMAIL, $html_message);
			$status = 'success';
			$message = 'Mail has been sent.';
		} catch (\Exception $e) {
			$status = 'error';
			$message = 'Mail couldn\'t be send, try again.';
		}
		return $this->redirect->route('contact')->with($status, $message);
	}

	public function join_our_team() {
		$this->view('website.joinourteam');
	}

	public function post_join_our_team() {
		var_dump($_POST['regions']);
		try {
			$html_message = "<p>Someone want to join your team :</p><br/>";
			$html_message .= "<ul>";
			$html_message .= "<li>Email : " . $_POST['email'] . "</li>";
			$html_message .= "<li>Subject : " . $_POST['subject'] . "</li>";
			$html_message .= "<li>Current rank : " . $_POST['current_rank'] . "</li>";
			$html_message .= "<li><ul>Regions:";
			foreach ($_POST['regions'] as $region => $value) {
				$html_message .= "<li>$region</li>";
			}
			$html_message .= "</ul></li>";
			$html_message .= "<li><ul>Availability:";
			foreach ($_POST['availability'] as $availability => $value) {
				$html_message .= "<li>$availability</li>";
			}
			$html_message .= "</ul></li>";
			$html_message .= "<li>Message : " . $_POST['message'] . "</li>";
			$html_message .= "<li>op.gg : " . $_POST['opgg'] . "</li>";
			$html_message .= "<li>Screenshots : " . $_POST['screenshot'] . "</li>";
			$html_message .= "<li><ul>Boosting:";
			foreach ($_POST['boosting'] as $boosting => $value) {
				$html_message .= "<li>$boosting</li>";
			}
			$html_message .= "</ul></li>";
			$html_message .= "</ul><br>";

			Mail::send(Config::WEBSITE_NAME . ' - Join Our Team Form', Config::YOUR_EMAIL, $html_message);
			$status = 'success';
			$message = 'Mail has been sent.';
		} catch (\Exception $e) {
			$status = 'error';
			$message = 'Mail couldn\'t be send, try again.';
		}
		return $this->redirect->route('join-our-team')->with($status, $message);
	}

	public function order() {
		$this->view('website.order');
	}

}