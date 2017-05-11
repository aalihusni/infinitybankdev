<?php

namespace App\Http\Controllers;

use App\Classes\UserClass;
use App\Classes\PAGBClass;
use App\Classes\MemberClass;
use App\Classes\BlockioWalletClass;
use App\User;
use App\Email;
use App\Passport;
use App\TrailLog;
use App\BitcoinBlockioCallback;
use App\BitcoinBlockioCallbackProcessLog;
use App\BitcoinBlockioWithdraw;
use App\BitcoinBlockioWallet;
use App\BitcoinBlockioWalletReceiving;
use App\PAGB;
use App\Shares;
use App\BankPH;
use Redirect;
use URL;
use DB;

class PoolController extends Controller
{
    public function poolaccount($from = "", $to = "")
    {
        /*
        $onbehalf_user_id = 2;
        if (empty($from))
        {
            $from = 1;
            $this->deleteaccount();

            $user = User::find(1);
            $user->wallet_address = "1DG1StGv8huQ7zeFQUBsUrbNbx1f45kCGW";
            $user->save();

            $user = User::find(2);
            $user->wallet_address = "1CCTj4sbsLTwCmD1BquTiWDyFATFDBTa34";
            $user->save();
        }
        if (empty($to))
        {
            $to = 25;
        }

        for ($i = $from; $i < ($to + 1); $i++) {
            if ($i > 3279) return;

            $getclass = $this->getclass($i);
            $email = $getclass['email'];
            $password = $getclass['password'];
            $user_class = $getclass['user_class'];

            $alias = $getclass['alias'];
            $firstname = $getclass['firstname'];
            $lastname = $getclass['lastname'];
            $country_code = $getclass['country_code'];
            $wallet_address = $getclass['wallet_address'];

            if (User::where('alias', '=', $alias)->count() == 0) {
                DB::beginTransaction();
                $user_id = UserClass::signUp($email, $password, $onbehalf_user_id, 0)['user_id'];
                MemberClass::setCompleteProfile($user_id, $alias, $firstname, $lastname, $country_code, $wallet_address);

                //Upgrade & Placement
                //=========================
                $upline = PAGBClass::getEmptySlotUplineUserID($user_id);
                $upline_user_id = $upline['id'];
                $upline_hierarchy = $upline['hierarchy'];
                $upline_global_level = $upline['global_level'];
                $empty_tree_position = PAGBClass::getUplineEmptyTreePosition($upline_user_id);

                $user = User::find($user_id);
                $user->upline_user_id = $upline_user_id;
                $user->referral_user_id = $upline_user_id;
                $user->hierarchy = "#" . $user_id . "#|" . $upline_hierarchy;
                $user->hierarchy_bank = "#" . $user_id . "#|" . $upline_hierarchy;
                $user->global_level = $upline_global_level + 1;
                $user->global_level_bank = $upline_global_level + 1;
                $user->tree_position = $empty_tree_position;
                PAGBClass::setUplineTreeSlot($upline_user_id, 1);
                $user->save();

                PAGBClass::setUserClass($user_id, $user_class);
                //=========================
                DB::commit();

                echo $i."=".$alias."<br>";
            }
        }

        $from = $to + 1;
        $to = $to + 25;
        echo "Next<br>";
        echo "<script>\r\n";
        echo "var myTimer = null;\r\n";
        echo "\r\n";
        echo "myTimer = setInterval(function(){\r\n";
        echo "clearInterval(myTimer);\r\n";
        echo "cotinueregister();\r\n";
        echo "}, 1000);\r\n";
        echo "\r\n";
        echo "function cotinueregister()\r\n";
        echo "{\r\n";
        echo "window.location.replace('".URL::to('/poolaccount/'.$from.'/'.$to)."');\r\n";
        echo "}\r\n";
        echo "</script>\r\n";

        //return Redirect::to('/poolaccount/'.$from.'/'.$to);
    }

    public function getclass($i)
    {
        if ($i > 3279)
        {
            $return['user_class'] = 1;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "1KWQDThh7azkhqivqnKbu3RgV2mnLvsRZE";
        }
        elseif ($i > 1092)
        {
            $return['user_class'] = 1;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "1KWQDThh7azkhqivqnKbu3RgV2mnLvsRZE";
        }
        elseif ($i > 363)
        {
            $return['user_class'] = 2;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "17y2U7KeJNnN5Wmvz6AJ6Y5MizWgbUT78K";
        }
        elseif ($i > 120)
        {
            $return['user_class'] = 3;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "19KPwNSx2m82uV5kFowikZsa5BBWpjsAcY";
        }
        elseif ($i > 39)
        {
            $return['user_class'] = 4;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "1HDgXVcnapZZWhtwbYnWJBVho2eBjhUKDs";
        }
        elseif ($i > 12)
        {
            $return['user_class'] = 5;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "1Jr4oXjQHcahrbb87NaHwbJgefN3wS53sC";
        }
        elseif ($i > 3)
        {
            $return['user_class'] = 6;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "1J4GUbYGmsmoWus1mTkVtjTsqP46eTq2Ru";
        } else {
            $return['user_class'] = 7;

            $return['email'] = "user+".$i."@bitregion.com";
            $return['password'] = "Br1q2w3e!@#";

            $return['alias'] = "user".$i;
            $return['firstname'] = $return['alias'];
            $return['lastname'] = $return['alias'];
            $return['country_code'] = "MY";

            $return['wallet_address'] = "1PAZtcUoofZnpmoeLZ8xF8d4QQfsedRiQy";
        }

        return $return;
        */
    }

    public function deleteaccount()
    {
        echo "#Start Deleting<br>";

        BlockioWalletClass::delAllCallback();
        echo "- Callback<br>";

        echo "- User<br>";
        $user = User::where('id', '>', 2)->delete();
        DB::update("ALTER TABLE users AUTO_INCREMENT = 3;");
        echo "- User<br>";

        $userbank = Email::truncate();
        DB::update("ALTER TABLE email AUTO_INCREMENT = 1;");
        echo "- Email<br>";

        $passport = Passport::truncate();
        DB::update("ALTER TABLE passport AUTO_INCREMENT = 1;");
        echo "- Passport<br>";

        $traillog = TrailLog::truncate();
        DB::update("ALTER TABLE trail_log AUTO_INCREMENT = 1;");
        echo "- Trail Log<br>";

        $blockio_callback = BitcoinBlockioCallback::truncate();
        DB::update("ALTER TABLE bitcoin_blockio_callback AUTO_INCREMENT = 1;");
        echo "- Callback<br>";

        $blockio_callback_process = BitcoinBlockioCallbackProcessLog::truncate();
        DB::update("ALTER TABLE bitcoin_blockio_callback_process_log AUTO_INCREMENT = 1;");
        echo "- Callback Process Log<br>";

        $blockio_withdraw = BitcoinBlockioWithdraw::truncate();
        DB::update("ALTER TABLE bitcoin_blockio_withdraw AUTO_INCREMENT = 1;");
        echo "- Blockio Withdraw<br>";

        $blockio_wallet = BitcoinBlockioWallet::truncate();
        DB::update("ALTER TABLE bitcoin_blockio_wallet AUTO_INCREMENT = 1;");
        echo "- Blockio Wallet<br>";

        $blockio_wallet_reciving = BitcoinBlockioWalletReceiving::truncate();
        DB::update("ALTER TABLE bitcoin_blockio_wallet_receiving AUTO_INCREMENT = 1;");
        echo "- Blockio Wallet Receiving<br>";

        $pagb = PAGB::truncate();
        DB::update("ALTER TABLE pagb AUTO_INCREMENT = 1;");
        echo "- PAGB<br>";

        $shares = Shares::truncate();
        DB::update("ALTER TABLE shares AUTO_INCREMENT = 1;");
        echo "- Shares<br>";

        $bank_ph = BankPH::truncate();
        DB::update("ALTER TABLE bank_ph AUTO_INCREMENT = 1;");
        echo "- Bank PH<br>";

        echo "- Set User 2 Tree To 0<br>";
        $user = User::where('id', '=', 2)->first();
        $user->tree_slot = 0;
        $user->save();
        echo "- Add User 2 Bank Account<br>";

        echo "#Finish Deleting<br>";
    }
}