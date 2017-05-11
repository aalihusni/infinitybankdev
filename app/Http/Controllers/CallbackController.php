<?php
namespace App\Http\Controllers;

use App\Classes\PAGBClass;
use App\Classes\PAGBFixClass;
use App\Classes\PairClass;
use App\Classes\SharesClass;
use App\Classes\UserClass;
use App\Classes\AdminClass;
use App\User;
use Auth;
use Crypt;
use App\Classes\BlockchainWalletClass;
use App\Classes\BlockchainCallbackClass;
use App\Classes\BlockioCallbackClass;
use App\Classes\BlockioWalletClass;
use App\Classes\PHGHClass;
use App\Classes\MicroPHGHClass;
use App\Classes\BitcoinWalletClass;
use App\Classes\PHPlusClass;
use App\Classes\BlockioManualCallbackClass;
use Request;
use Input;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use App\Classes\HierarchyClass;
use App\Classes\IPClass;
use DB;
use GeoIP;
use Aws\Laravel\AwsFacade;
use Storage;
use S3Files;

class CallbackController extends Controller
{
    public function withdraw()
    {
        echo "test<br>";
        //AdminClass::checkPH();
        $temp = PairClass::getCurrentPair(3322);
        echo "3322<br>";
        echo 'total_left = '.$temp['total_left']."<br>";
        echo 'total_middle = '.$temp['total_middle']."<br>";
        echo 'total_right = '.$temp['total_right']."<br><br>";

        //Total Previous Pair
        echo 'paired_left = '.$temp['paired_left']."<br>";
        echo 'paired_middle = '.$temp['paired_middle']."<br>";
        echo 'paired_right = '.$temp['paired_right']."<br><br>";

        //New Total
        echo 'balance_left = '.$temp['balance_left']."<br>";
        echo 'balance_middle = '.$temp['balance_middle']."<br>";
        echo 'balance_right = '.$temp['balance_right']."<br><br>";

        //New Pair
        echo 'pair_left = '.$temp['pair_left']."<br>";
        echo 'pair_middle = '.$temp['pair_middle']."<br>";
        echo 'pair_right = '.$temp['pair_right']."<br><br>";

        echo 'pair = '.$temp['pair']."<br>";
        echo 'flush = '.$temp['flush']."<br><br>";


        $temp = PairClass::getCurrentPair(13716);
        echo "13716<br>";
        echo 'total_left = '.$temp['total_left']."<br>";
        echo 'total_middle = '.$temp['total_middle']."<br>";
        echo 'total_right = '.$temp['total_right']."<br><br>";

        //Total Previous Pair
        echo 'paired_left = '.$temp['paired_left']."<br>";
        echo 'paired_middle = '.$temp['paired_middle']."<br>";
        echo 'paired_right = '.$temp['paired_right']."<br><br>";

        //New Total
        echo 'balance_left = '.$temp['balance_left']."<br>";
        echo 'balance_middle = '.$temp['balance_middle']."<br>";
        echo 'balance_right = '.$temp['balance_right']."<br><br>";

        //New Pair
        echo 'pair_left = '.$temp['pair_left']."<br>";
        echo 'pair_middle = '.$temp['pair_middle']."<br>";
        echo 'pair_right = '.$temp['pair_right']."<br><br>";

        echo 'pair = '.$temp['pair']."<br>";
        echo 'flush = '.$temp['flush']."<br><br>";
        //echo json_encode(PHPlusClass::getRecruitment(3926,Carbon::now()->addMonth(-3),Carbon::now()->addMonth(-2)));
        /*
        echo json_encode(PAGBClass::getUplineReferralWalletAddress(3687));
        echo Carbon::now()."<br>";
        echo Carbon::now()->endOfMonth()."<br>";

        PAGBFixClass::getPAGBFix();
        */
        //PHPlusClass::getPHPlus();
        //PairClass::processPair();
        /*
        PHGHClass::checkPHPaymentStatusAll();
        PHGHClass::checkGHPaymentStatusAll();
        PHGHClass::checkPHPaymentExpiredAll();

        PHGHClass::matchPHGH(50,1);
        PHGHClass::matchPHGH();

        MicroPHGHClass::checkPHPaymentStatusAll();
        MicroPHGHClass::checkGHPaymentStatusAll();
        MicroPHGHClass::checkPHPaymentExpiredAll();

        MicroPHGHClass::matchPHGH(50,1);
        MicroPHGHClass::matchPHGH();

        /*
        PHGHClass::checkPHPaymentStatusAll();
        PHGHClass::checkGHPaymentStatusAll();
        PHGHClass::checkPHPaymentExpiredAll();
        /*
        echo "#1";
        /*
        dd();
        echo json_encode(PAGBClass::getEmptySlotUplineUserID(3282));
        */
        /*
        $email = "user@bitregion.com";
        $template = 'emails.signup';
        $subject = 'Thank you for registering with BitRegion. Please confirm your email address.';
        $emailverificationcode = "1q2w3e";
        $data = array('email' => $email, 'verificationcode' => $emailverificationcode);
        $sendemail = 1;

        EmailClass::send_email($template, $email, $subject, $data, $sendemail);
        */
    }

    public function geoip($ip = "")
    {
        if (empty($ip)){
            //if (isset(Input::get('ip'))) {
                $ip = Input::get('ip');
            //}
        }
        $country_code = GeoIP::getLocation($ip)['isoCode'];
        //dd("ss");

        return json_encode(['country_code'=>$country_code]);
    }

    public function single_manual_callback($receiving_address)
    {
        BlockioManualCallbackClass::single_manual_callback($receiving_address);
    }

    public function generate_qr($receiving_address, $value_in_btc)
    {
        $qr_code = QrCode::size(200)->margin(1)->errorCorrection('L')->generate('bitcoin:'.$receiving_address.'?amount='.$value_in_btc);

        return $qr_code;
    }

    public function blockio_status($receiving_address)
    {
        $response = BlockioWalletClass::getWalletReceivingStatus($receiving_address);

        echo $response;
    }

    public function blockio_confirmations($receiving_address)
    {
        $response = BlockioWalletClass::getWalletReceivingDetails($receiving_address)['confirmations'];

        echo $response;
    }

    public function blockio_callback()
    {
        $input = json_encode(Input::all());

        $response = BlockioCallbackClass::getCallback($input);
    }

    public function blockchain_callback()
    {
        $transaction_hash = "";
        $input_transaction_hash = "";
        $input_address = "";
        $value_in_satoshi = "";
        $confirmations = "";
        $secret = "";
        $bitcoin_wallet_receiving_id = "";

        if (isset($_REQUEST['transaction_hash'])) $transaction_hash = $_REQUEST['transaction_hash'];
        if (isset($_REQUEST['input_transaction_hash'])) $input_transaction_hash = $_REQUEST['input_transaction_hash'];
        if (isset($_REQUEST['input_address'])) $input_address = $_REQUEST['input_address'];
        if (isset($_REQUEST['value_in_satoshi'])) $value_in_satoshi = $_REQUEST['value'];
        if (isset($_REQUEST['confirmations'])) $confirmations = $_REQUEST['confirmations'];
        if (isset($_REQUEST['secret'])) $secret = $_REQUEST['secret'];

        $referer_url = Request::server('HTTP_REFERER');
        $client_ip = Request::getClientIp();

        $response = BlockchainCallbackClass::getTransaction($transaction_hash, $input_transaction_hash, $input_address, $value_in_satoshi, $confirmations, $secret, $referer_url, $client_ip);
    }
}