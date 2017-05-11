<?php

namespace App\Http\Controllers;

use Auth;
use App\Settings;
use App\Analytics;
use App\TrailLog;
use App\PAGB;
use App\BitcoinBlockioCallback;
use App\BitcoinBlockioWalletReceiving;
use App\Passport;
use App\Shares;
use App\MicroPassport;
use App\MicroShares;
use App\BankPH;
use App\BankGH;
use App\BankPHGH;
use App\MicroBankPH;
use App\MicroBankGH;
use App\MicroBankPHGH;
use App\User;
use App\Classes\HierarchyClass;
use App\Classes\AdminClass;
use DB;
use Mail;


class AdminViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function home()
    {
    	
        return view('admin.home');
    }
    
    public function logAddress()
    {
    	$LatestUpdatedRows = TrailLog::select(DB::raw('max(id) as id'))->where(function($sql){
    		$sql->where('title','Update Wallet Address');
    	})->groupBy('user_id')->orderBy('id', 'desc')->get();
    	 
    	$ChangedData = '';
    	foreach ($LatestUpdatedRows as $list)
    	{
    		$detail = TrailLog::whereId($list->id)->select('to','user_id')->first();
    		$UserRow = User::find($detail->user_id);
    		if($UserRow->wallet_address != $detail->to)
    		{
    			### Update The Wallet Address From Latest Trail Log #####
    			$ChangedData .=  'User ID : '.$detail->user_id.' User.Address : '.$UserRow->wallet_address.' , Latest : '.$detail->to."<br>";
    		}
    		 
    	}
    	Mail::raw(''.$ChangedData.'', function($message) {
    		$message->to('sesemeeee@gmail.com')
    		->subject('Wallet Address Checked from User.Address to Trail Log Latest Address ');
    	});
    	
    	/*
    	$LatestUpdatedRows = TrailLog::where(function($sql){
    			$sql->where('title','Update Wallet Address');
    	})->get();
    	dd($LatestUpdatedRows);
    	
    	$list = User::where('user_type', '=', 2)->paginate(200);
    	
    	$Records = array();
    	foreach($list as $l){
    		//$row =  'User ID : '.$l->id;$Records[] = $row;
    		
    		$userID = $l->id;
    		$latest = TrailLog::where(['user_id'=>$userID,'to'=>''.$l->wallet_address.''])->count();
    		
    		if($latest)
    			$row =  'User ID : '.$l->id;
    		else
    			$row =  'User ID : '.$l->id.' Not Record in Trail Log';
    		
    		
    		$latest = TrailLog::where(function($sql)use($userID){
    			$sql->where('user_id',$userID);
    			$sql->where('title', '=', 'Update Wallet Address');
    		})->orderBY('id','desc')->first(); 
    		
    		if(!is_null($latest)){
    			if($l->wallet_address != $latest->to)
    				$row =  'User ID : '.$l->id.' From '.$l->wallet_address.' To '.$latest->to.' On: '.$latest->created_at;
    			else
    				$row =  'User ID : '.$l->id;
    		}else
    			$row =  'User ID : '.$l->id;
    		$Records[] = $row;
    	} */
    	return view('admin.home')->with('lists',$Records);
    }
    
    
    

    public function personal_info()
    {
        return view('admin.personal_info');
    }

    public function communication_info()
    {
        return view('admin.communication_info');
    }

    public function user_referrer($user_id)
    {
        $referrers = HierarchyClass::getReferrers($user_id, 2);
        return view('admin.user_referrer')->with('referrers', $referrers);
    }

    public function user_analytics($user_id)
    {
        $analytics = Analytics::where('user_id', '=', $user_id)
            ->orderby('created_at', 'desc')
            ->take(50)
            ->get();

        return view('admin.user_analytics')->with('analytics', $analytics);
    }

    public function user_logs($user_id)
    {
        $logs = TrailLog::where('user_id', '=', $user_id)
            ->orderby('created_at', 'desc')
            ->take(50)
            ->get();

        return view('admin.user_logs')->with('logs', $logs);
    }

    public function user_payments($user_id = "")
    {
        if ($user_id)
        {
            $payments = PAGB::where('user_id', '=', $user_id)
                ->orwhere('sender_user_id', '=', $user_id)
                ->orderby('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $payments = PAGB::orderby('created_at', 'desc')
                ->take(50)
                ->get();
        }

        return view('admin.user_payments')->with('payments', $payments);
    }

    public function user_callbacks($user_id = "")
    {
        if ($user_id) {
            $callbacks = BitcoinBlockioCallback::where('sender_user_id', '=', $user_id)
                ->orderby('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $callbacks = BitcoinBlockioCallback::orderby('created_at', 'desc')
                ->take(50)
                ->get();
        }

        return view('admin.user_callbacks')->with('callbacks', $callbacks);
    }

    public function user_receivings($user_id = "")
    {
        if ($user_id) {
            $receivings = BitcoinBlockioWalletReceiving::where('sender_user_id', '=', $user_id)
                ->orderby('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $receivings = BitcoinBlockioWalletReceiving::orderby('created_at', 'desc')
                ->take(50)
                ->get();
        }

        return view('admin.user_receivings')->with('receivings', $receivings);
    }

    public function user_passports($user_id = "")
    {
        if ($user_id) {
            $passports = Passport::where('user_id', '=', $user_id)
                ->orderby('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $passports = Passport::orderby('created_at', 'desc')
                ->take(50)
                ->get();
        }

        return view('admin.user_passports')->with('passports', $passports);
    }

    public function user_shares($user_id = "")
    {
        if ($user_id) {
            $shares = Shares::where('user_id', '=', $user_id)
                ->orderby('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $shares = Shares::orderby('created_at', 'desc')
                ->take(50)
                ->get();
        }

        return view('admin.user_shares')->with('shares', $shares);
    }

    public function getphgh($type, $id)
    {
        if ($type == "ph") {
            /*
            $phgh_list = BankPHGH::where('ph_id', '=', $id)
                ->get();
            */

            $sql = BankPHGH::select('bank_phgh.*', 'users.alias', 'users.country_code');
            $sql->where('ph_id', '=', $id);
            $phgh_list = $sql->leftjoin('users', 'bank_phgh.gh_user_id', '=', 'users.id')
                ->get();
        } else {
            /*
            $phgh_list = BankPHGH::where('gh_id', '=', $id)
                ->get();
            */

            $sql = BankPHGH::select('bank_phgh.*', 'users.alias', 'users.country_code');
            $sql->where('gh_id', '=', $id);
            $phgh_list = $sql->leftjoin('users', 'bank_phgh.ph_user_id', '=', 'users.id')
                ->get();
        }

        if (count($phgh_list))
        {
            echo '<table class="table table-striped table-bordered table-hover" width="100%">';
            echo "<tr>";
            echo "<td>";
            echo ($type == "ph" ? "GH" : "PH")." ID";
            echo "</td>";
            echo "<td>";
            echo "User Details";
            echo "</td>";
            echo "<td>";
            echo "Value";
            echo "</td>";
            echo "<td>";
            echo "Status";
            echo "</td>";
            echo "</tr>";
            $complete_btc = 0;
            $queue_btc = 0;
            foreach ($phgh_list as $phgh)
            {
                if ($phgh->status == 2) {
                    $complete_btc = ($complete_btc + $phgh->value_in_btc);
                }
                if ($phgh->status == 0) {
                    $queue_btc = ($queue_btc + $phgh->value_in_btc);
                }
                echo "<tr>";
                echo "<td title'".$phgh->created_at."'>";
                if ($type == "ph") {
                    echo $phgh->gh_id;
                } else {
                    echo $phgh->ph_id;
                }
                echo "</td>";
                echo "<td>";
                if ($type == "ph") {
                    echo "<strong>ID:</strong> " . $phgh->gh_user_id . " (" . $phgh->alias . ")" . " <strong>Country:</strong> " . $phgh->country_code;
                } else {
                    echo "<strong>ID:</strong> " . $phgh->ph_user_id . " (" . $phgh->alias . ")" . " <strong>Country:</strong> " . $phgh->country_code;
                }
                echo "</td>";
                echo "<td>";
                echo $phgh->value_in_btc;
                echo "</td>";
                echo "<td>";
                echo $phgh->status;
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<p>Queue : ".number_format($queue_btc,8)."</p>";
            echo "<p>Complete : ".number_format($complete_btc,8)."</p>";
            echo "<p>Total : ".number_format(($complete_btc + $queue_btc),8)."</p>";
        }
    }

    public function ph($country = "")
    {
        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $queue_sum = $sql->where('status', '=', '0')
            ->where('priority', '<>', '100')
            ->first()->total;

        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $match_sum = $sql->where(function ($query) {
                $query->orwhere('status', '=', '1');
                $query->orwhere('status', '=', '2');
            })
            ->where('priority', '<>', '100')
            ->first()->total;

        $sql = BankPH::select(DB::raw('sum(bank_phgh.value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
        $sql->leftjoin('bank_phgh', function($join) {
            $join->on('bank_ph.id', '=', 'bank_phgh.ph_id');
            $join->on('bank_phgh.status', '<=', DB::raw("2"));
        });
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_paid_sum = $sql->where(function ($query) {
            $query->orwhere(DB::raw('bank_ph.status'), '=', '1');
            $query->orwhere(DB::raw('bank_ph.status'), '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $match_unpaid_sum = $match_sum - $match_paid_sum;

        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $active_sum = $sql->where('status', '=', '3')
            ->first()->total;

        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $onhold_sum = $sql->where('status', '=', '4')
            ->first()->total;

        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $released_sum = $sql->where('status', '=', '5')
            ->first()->total;

        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $ended_sum = $sql->where('status', '=', '6')
            ->first()->total;

        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $expired_sum = $sql->where('status', '=', '7')
            ->first()->total;


        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $queue_list = $sql->where('status', '=', '0')
            ->where('priority', '<>', '100')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $match_list = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $active_list = $sql->where('status', '=', '3')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $onhold_list = $sql->where('status', '=', '4')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $released_list = $sql->where('status', '=', '5')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $ended_list = $sql->where('status', '=', '6')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankPH::select('bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'bank_ph.user_id', '=', 'users.id');
	    if (!empty($country))
        {            
            $sql->where('country_code', '=', $country);
        }
        $expired_list = $sql->where('status', '=', '7')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        return view('admin.ph')
            ->with('queue_sum', $queue_sum)
            ->with('match_sum', $match_sum)
            ->with('match_paid_sum', $match_paid_sum)
            ->with('match_unpaid_sum', $match_unpaid_sum)
            ->with('active_sum', $active_sum)
            ->with('onhold_sum', $onhold_sum)
            ->with('released_sum', $released_sum)
            ->with('ended_sum', $ended_sum)
            ->with('expired_sum', $expired_sum)
            ->with('queue_list', $queue_list)
            ->with('match_list', $match_list)
            ->with('active_list', $active_list)
            ->with('onhold_list', $onhold_list)
            ->with('released_list', $released_list)
            ->with('ended_list', $ended_list)
            ->with('expired_list', $expired_list);
    }

    public function gh($country = "")
    {
        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $queue_sum = $sql->where('status', '=', '0')
            ->first()->total;

        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $match_sum = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $sql = BankGH::select(DB::raw('sum(bank_phgh.value_in_btc) as total'));
        $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        $sql->leftjoin('bank_phgh', function($join) {
            $join->on('bank_gh.id', '=', 'bank_phgh.gh_id');
            $join->on('bank_phgh.status', '<=', DB::raw("2"));
        });
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $match_paid_sum = $sql->where(function ($query) {
            $query->orwhere(DB::raw('bank_gh.status'), '=', '1');
            $query->orwhere(DB::raw('bank_gh.status'), '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $match_unpaid_sum = $match_sum - $match_paid_sum;

        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $active_sum = $sql->where('status', '=', '3')
            ->first()->total;

        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $onhold_sum = $sql->where('status', '=', '4')
            ->first()->total;

        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $released_sum = $sql->where('status', '=', '5')
            ->first()->total;

        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $ended_sum = $sql->where('status', '=', '6')
            ->first()->total;

        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'));
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $expired_sum = $sql->where('status', '=', '7')
            ->first()->total;


        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $queue_list = $sql->where('status', '=', '0')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $match_list = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $active_list = $sql->where('status', '=', '3')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $onhold_list = $sql->where('status', '=', '4')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $released_list = $sql->where('status', '=', '5')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $ended_list = $sql->where('status', '=', '6')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = BankGH::select('bank_gh.*', 'users.alias', 'users.country_code');
	    $sql->leftjoin('users', 'bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            if ($country == "pool")
            {
                $sql->where('bank_gh.user_id', '<=', 3281);
            } else {
                $sql->where('country_code', '=', $country);
            }
        }
        $expired_list = $sql->where('status', '=', '7')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        return view('admin.gh')
            ->with('queue_sum', $queue_sum)
            ->with('match_sum', $match_sum)
            ->with('match_paid_sum', $match_paid_sum)
            ->with('match_unpaid_sum', $match_unpaid_sum)
            ->with('active_sum', $active_sum)
            ->with('onhold_sum', $onhold_sum)
            ->with('released_sum', $released_sum)
            ->with('ended_sum', $ended_sum)
            ->with('expired_sum', $expired_sum)
            ->with('queue_list', $queue_list)
            ->with('match_list', $match_list)
            ->with('active_list', $active_list)
            ->with('onhold_list', $onhold_list)
            ->with('released_list', $released_list)
            ->with('ended_list', $ended_list)
            ->with('expired_list', $expired_list);
    }

    public function phgh()
    {
        $bankphgh = BankPHGH::where('status', '', '')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        return view('admin.phgh')->with('bankphgh', $bankphgh);
    }

    public function micro_getphgh($type, $id)
    {
        if ($type == "ph") {
            /*
            $phgh_list = MicroBankPHGH::where('ph_id', '=', $id)
                ->get();
            */

            $sql = MicroBankPHGH::select('micro_bank_phgh.*', 'users.alias', 'users.country_code');
            $sql->where('ph_id', '=', $id);
            $phgh_list = $sql->leftjoin('users', 'micro_bank_phgh.gh_user_id', '=', 'users.id')
                ->get();
        } else {
            /*
            $phgh_list = MicroBankPHGH::where('gh_id', '=', $id)
                ->get();
            */

            $sql = MicroBankPHGH::select('micro_bank_phgh.*', 'users.alias', 'users.country_code');
            $sql->where('gh_id', '=', $id);
            $phgh_list = $sql->leftjoin('users', 'micro_bank_phgh.ph_user_id', '=', 'users.id')
                ->get();
        }

        if (count($phgh_list))
        {
            echo '<table class="table table-striped table-bordered table-hover" width="100%">';
            echo "<tr>";
            echo "<td>";
            echo ($type == "ph" ? "GH" : "PH")." ID";
            echo "</td>";
            echo "<td>";
            echo "User Details";
            echo "</td>";
            echo "<td>";
            echo "Value";
            echo "</td>";
            echo "<td>";
            echo "Status";
            echo "</td>";
            echo "</tr>";
            $complete_btc = 0;
            $queue_btc = 0;
            foreach ($phgh_list as $phgh)
            {
                if ($phgh->status == 2) {
                    $complete_btc = ($complete_btc + $phgh->value_in_btc);
                }
                if ($phgh->status == 0) {
                    $queue_btc = ($queue_btc + $phgh->value_in_btc);
                }
                echo "<tr>";
                echo "<td title'".$phgh->created_at."'>";
                if ($type == "ph") {
                    echo $phgh->gh_id;
                } else {
                    echo $phgh->ph_id;
                }
                echo "</td>";
                echo "<td>";
                if ($type == "ph") {
                    echo "<strong>ID:</strong> " . $phgh->gh_user_id . " (" . $phgh->alias . ")" . " <strong>Country:</strong> " . $phgh->country_code;
                } else {
                    echo "<strong>ID:</strong> " . $phgh->ph_user_id . " (" . $phgh->alias . ")" . " <strong>Country:</strong> " . $phgh->country_code;
                }
                echo "</td>";
                echo "<td>";
                echo $phgh->value_in_btc;
                echo "</td>";
                echo "<td>";
                echo $phgh->status;
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<p>Queue : ".number_format($queue_btc,8)."</p>";
            echo "<p>Complete : ".number_format($complete_btc,8)."</p>";
            echo "<p>Total : ".number_format(($complete_btc + $queue_btc),8)."</p>";
        }
    }

    public function micro_ph($country = "")
    {
        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $queue_sum = $sql->where('status', '=', '0')
            ->where('priority', '<>', '100')
            ->first()->total;

        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_sum = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $sql = MicroBankPH::select(DB::raw('sum(micro_bank_phgh.value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        $sql->leftjoin('micro_bank_phgh', function($join) {
            $join->on('micro_bank_ph.id', '=', 'micro_bank_phgh.ph_id');
            $join->on('micro_bank_phgh.status', '<=', DB::raw("2"));
        });
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_paid_sum = $sql->where(function ($query) {
            $query->orwhere(DB::raw('micro_bank_ph.status'), '=', '1');
            $query->orwhere(DB::raw('micro_bank_ph.status'), '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $match_unpaid_sum = $match_sum - $match_paid_sum;

        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $active_sum = $sql->where('status', '=', '3')
            ->first()->total;

        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $onhold_sum = $sql->where('status', '=', '4')
            ->first()->total;

        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $released_sum = $sql->where('status', '=', '5')
            ->first()->total;

        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $ended_sum = $sql->where('status', '=', '6')
            ->first()->total;

        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $expired_sum = $sql->where('status', '=', '7')
            ->first()->total;


        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $queue_list = $sql->where('status', '=', '0')
            ->where('priority', '<>', '100')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_list = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $active_list = $sql->where('status', '=', '3')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $onhold_list = $sql->where('status', '=', '4')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $released_list = $sql->where('status', '=', '5')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $ended_list = $sql->where('status', '=', '6')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankPH::select('micro_bank_ph.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_ph.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $expired_list = $sql->where('status', '=', '7')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        return view('admin.ph')
            ->with('queue_sum', $queue_sum)
            ->with('match_sum', $match_sum)
            ->with('match_paid_sum', $match_paid_sum)
            ->with('match_unpaid_sum', $match_unpaid_sum)
            ->with('active_sum', $active_sum)
            ->with('onhold_sum', $onhold_sum)
            ->with('released_sum', $released_sum)
            ->with('ended_sum', $ended_sum)
            ->with('expired_sum', $expired_sum)
            ->with('queue_list', $queue_list)
            ->with('match_list', $match_list)
            ->with('active_list', $active_list)
            ->with('onhold_list', $onhold_list)
            ->with('released_list', $released_list)
            ->with('ended_list', $ended_list)
            ->with('expired_list', $expired_list);
    }

    public function micro_gh($country = "")
    {
        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $queue_sum = $sql->where('status', '=', '0')
            ->first()->total;

        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_sum = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $sql = MicroBankGH::select(DB::raw('sum(micro_bank_phgh.value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        $sql->leftjoin('micro_bank_phgh', function($join) {
            $join->on('micro_bank_gh.id', '=', 'micro_bank_phgh.gh_id');
            $join->on('micro_bank_phgh.status', '<=', DB::raw("2"));
        });
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_paid_sum = $sql->where(function ($query) {
            $query->orwhere(DB::raw('micro_bank_gh.status'), '=', '1');
            $query->orwhere(DB::raw('micro_bank_gh.status'), '=', '2');
        })
            ->where('priority', '<>', '100')
            ->first()->total;

        $match_unpaid_sum = $match_sum - $match_paid_sum;

        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $active_sum = $sql->where('status', '=', '3')
            ->first()->total;

        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $onhold_sum = $sql->where('status', '=', '4')
            ->first()->total;

        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $released_sum = $sql->where('status', '=', '5')
            ->first()->total;

        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $ended_sum = $sql->where('status', '=', '6')
            ->first()->total;

        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'));
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $expired_sum = $sql->where('status', '=', '7')
            ->first()->total;


        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $queue_list = $sql->where('status', '=', '0')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $match_list = $sql->where(function ($query) {
            $query->orwhere('status', '=', '1');
            $query->orwhere('status', '=', '2');
        })
            ->where('priority', '<>', '100')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $active_list = $sql->where('status', '=', '3')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $onhold_list = $sql->where('status', '=', '4')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $released_list = $sql->where('status', '=', '5')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $ended_list = $sql->where('status', '=', '6')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        $sql = MicroBankGH::select('micro_bank_gh.*', 'users.alias', 'users.country_code');
        $sql->leftjoin('users', 'micro_bank_gh.user_id', '=', 'users.id');
        if (!empty($country))
        {
            $sql->where('country_code', '=', $country);
        }
        $expired_list = $sql->where('status', '=', '7')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        return view('admin.gh')
            ->with('queue_sum', $queue_sum)
            ->with('match_sum', $match_sum)
            ->with('match_paid_sum', $match_paid_sum)
            ->with('match_unpaid_sum', $match_unpaid_sum)
            ->with('active_sum', $active_sum)
            ->with('onhold_sum', $onhold_sum)
            ->with('released_sum', $released_sum)
            ->with('ended_sum', $ended_sum)
            ->with('expired_sum', $expired_sum)
            ->with('queue_list', $queue_list)
            ->with('match_list', $match_list)
            ->with('active_list', $active_list)
            ->with('onhold_list', $onhold_list)
            ->with('released_list', $released_list)
            ->with('ended_list', $ended_list)
            ->with('expired_list', $expired_list);
    }

    public function micro_phgh()
    {
        $MicroBankPHgh = MicroBankPHGH::where('status', '', '')
            ->orderby('created_at', 'desc')
            ->paginate(50);

        return view('admin.phgh')->with('MicroBankPHgh', $MicroBankPHgh);
    }

    public function pagbstats()
    {
        $users = PAGB::select(DB::raw('users.country_code'), DB::raw('pagb.new_user_class'), DB::raw('year(pagb.created_at) as yearr'), DB::raw('month(pagb.created_at) as monthh'), DB::raw('day(pagb.created_at) as dayy'), DB::raw('count(pagb.id) as totall'))
            ->leftjoin('users', 'pagb.sender_user_id', '=' ,'users.id')
            ->where(DB::raw('users.id'), '>', '3281')
            ->where('user_type', '=', '2')
            ->where('type', '=', 'PA')
            ->groupby('country_code')
            ->groupby('new_user_class')
            ->groupby(DB::raw('year(created_at)'))
            ->groupby(DB::raw('month(created_at)'))
            ->groupby(DB::raw('day(created_at)'))
            ->orderby('country_code')
            ->orderby('new_user_class')
            ->orderby('yearr')
            ->orderby('monthh')
            ->orderby('dayy')
            ->get();

        $stats_summary = array();
        foreach ($users as $user) {
            $country_code = $user->country_code;
            $new_user_class = $user->new_user_class;
            $year = (string)$user->yearr;
            $month = (string)str_pad($user->monthh, 2, '0', STR_PAD_LEFT);;
            $day = (string)str_pad($user->dayy, 2, '0', STR_PAD_LEFT);;
            $total = $user->totall;

            if (!isset($stats_summary['data']["ALL"])) {
                $stats_summary['data']["ALL"] = 0;
            }
            if (!isset($stats_summary['data'][$year])) {
                $stats_summary['data'][$year] = 0;
            }
            if (!isset($stats_summary['data'][$year . $month])) {
                $stats_summary['data'][$year . $month] = 0;
            }
            if (!isset($stats_summary['data'][$country_code])) {
                $stats_summary['data'][$country_code] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $year])) {
                $stats_summary['data'][$country_code . $year] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $year . $month])) {
                $stats_summary['data'][$country_code . $year . $month] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $year . $month . $day])) {
                $stats_summary['data'][$country_code . $year . $month . $day] = 0;
            }


            if (!isset($stats_summary['data'][$new_user_class])) {
                $stats_summary['data'][$new_user_class] = 0;
            }
            if (!isset($stats_summary['data'][$new_user_class . $year . $month . $day])) {
                $stats_summary['data'][$new_user_class . $year . $month . $day] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $new_user_class])) {
                $stats_summary['data'][$country_code . $new_user_class] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $new_user_class . $year])) {
                $stats_summary['data'][$country_code . $new_user_class . $year] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $new_user_class . $year . $month])) {
                $stats_summary['data'][$country_code . $new_user_class . $year . $month] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $new_user_class . $year . $month . $day])) {
                $stats_summary['data'][$country_code . $new_user_class . $year . $month . $day] = 0;
            }

            $stats_summary['country'][] = $country_code;
            $stats_summary['new_user_class'][] = $new_user_class;
            $stats_summary['year'][] = $year;
            $stats_summary['month'][] = $year . $month;
            $stats_summary['day'][] = $year . $month . $day;
            $stats_summary['data']["ALL"] = $stats_summary['data']["ALL"] + $total;
            $stats_summary['data'][$year] = $stats_summary['data'][$year] + $total;
            $stats_summary['data'][$year . $month] = $stats_summary['data'][$year . $month] + $total;
            $stats_summary['data'][$country_code] = $stats_summary['data'][$country_code] + $total;
            $stats_summary['data'][$country_code . $year] = $stats_summary['data'][$country_code . $year] + $total;
            $stats_summary['data'][$country_code . $year . $month] = $stats_summary['data'][$country_code . $year . $month] + $total;
            $stats_summary['data'][$country_code . $year . $month . $day] = $stats_summary['data'][$country_code . $year . $month . $day] + $total;

            $stats_summary['data'][$new_user_class] = $stats_summary['data'][$new_user_class] + $total;
            $stats_summary['data'][$new_user_class . $year . $month . $day] = $stats_summary['data'][$new_user_class . $year . $month . $day] + $total;
            $stats_summary['data'][$country_code . $new_user_class] = $stats_summary['data'][$country_code . $new_user_class] + $total;
            $stats_summary['data'][$country_code . $new_user_class . $year] = $stats_summary['data'][$country_code . $new_user_class . $year] + $total;
            $stats_summary['data'][$country_code . $new_user_class . $year . $month] = $stats_summary['data'][$country_code . $new_user_class . $year . $month] + $total;
            $stats_summary['data'][$country_code . $new_user_class . $year . $month . $day] = $stats_summary['data'][$country_code . $new_user_class . $year . $month . $day] + $total;

        }

        $stats_summary['country'] = array_unique($stats_summary['country']);
        $stats_summary['new_user_class'] = array_unique($stats_summary['new_user_class']);
        $stats_summary['year'] = array_unique($stats_summary['year']);
        $stats_summary['month'] = array_unique($stats_summary['month']);
        $stats_summary['day'] = array_unique($stats_summary['day']);
        asort($stats_summary['country']);
        asort($stats_summary['new_user_class']);
        asort($stats_summary['year']);
        asort($stats_summary['month']);
        asort($stats_summary['day']);

        echo "<p>";
        $this->draw3($stats_summary);
        echo "</p>";
    }

    public function userstats()
    {
        $users = User::select('country_code', DB::raw('year(created_at) as yearr'), DB::raw('month(created_at) as monthh'), DB::raw('day(created_at) as dayy'), DB::raw('count(*) as totall'))
            ->where('id', '>', '3281')
            ->where('user_type', '=', '2')
            ->groupby('country_code')
            ->groupby(DB::raw('year(created_at)'))
            ->groupby(DB::raw('month(created_at)'))
            ->groupby(DB::raw('day(created_at)'))
            ->orderby('country_code')
            ->orderby('yearr')
            ->orderby('monthh')
            ->orderby('dayy')
            ->get();

        $stats_summary = array();
        foreach ($users as $user) {
            $country_code = $user->country_code;
            $year = (string)$user->yearr;
            $month = (string)str_pad($user->monthh, 2, '0', STR_PAD_LEFT);;
            $day = (string)str_pad($user->dayy, 2, '0', STR_PAD_LEFT);;
            $total = $user->totall;

            if (!isset($stats_summary['data']["ALL"])) {
                $stats_summary['data']["ALL"] = 0;
            }
            if (!isset($stats_summary['data'][$year])) {
                $stats_summary['data'][$year] = 0;
            }
            if (!isset($stats_summary['data'][$year . $month])) {
                $stats_summary['data'][$year . $month] = 0;
            }
            if (!isset($stats_summary['data'][$country_code])) {
                $stats_summary['data'][$country_code] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $year])) {
                $stats_summary['data'][$country_code . $year] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $year . $month])) {
                $stats_summary['data'][$country_code . $year . $month] = 0;
            }
            if (!isset($stats_summary['data'][$country_code . $year . $month . $day])) {
                $stats_summary['data'][$country_code . $year . $month . $day] = 0;
            }

            $stats_summary['country'][] = $country_code;
            $stats_summary['year'][] = $year;
            $stats_summary['month'][] = $year . $month;
            $stats_summary['day'][] = $year . $month . $day;
            $stats_summary['data']["ALL"] = $stats_summary['data']["ALL"] + $total;
            $stats_summary['data'][$year] = $stats_summary['data'][$year] + $total;
            $stats_summary['data'][$year . $month] = $stats_summary['data'][$year . $month] + $total;
            $stats_summary['data'][$country_code] = $stats_summary['data'][$country_code] + $total;
            $stats_summary['data'][$country_code . $year] = $stats_summary['data'][$country_code . $year] + $total;
            $stats_summary['data'][$country_code . $year . $month] = $stats_summary['data'][$country_code . $year . $month] + $total;
            $stats_summary['data'][$country_code . $year . $month . $day] = $stats_summary['data'][$country_code . $year . $month . $day] + $total;

        }

        $stats_summary['country'] = array_unique($stats_summary['country']);
        $stats_summary['year'] = array_unique($stats_summary['year']);
        $stats_summary['month'] = array_unique($stats_summary['month']);
        $stats_summary['day'] = array_unique($stats_summary['day']);
        asort($stats_summary['country']);
        asort($stats_summary['year']);
        asort($stats_summary['month']);
        asort($stats_summary['day']);

        echo "<p>";
        $this->draw1($stats_summary);
        echo "</p>";
        echo "<p>";
        $this->draw2($stats_summary);
        echo "</p>";
    }

    public function draw3($stats_summary)
    {
        echo "<table>";
        echo "<tr>";
        echo "<td>";
        echo "Date";
        echo "</td>";
        echo "<td width='25px'>";
        echo "&nbsp;";
        echo "</td>";
        echo "<td width='25px' colspan='".count($stats_summary['new_user_class'])."' align='center'>";
        echo "Total";
        echo "</td>";
        echo "<td width='25px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['country'] as $country)
        {
            echo "<td width='25px' colspan='".count($stats_summary['new_user_class'])."' align='center'>";
            echo $country;
            echo "</td>";
            echo "<td width='25px'>";
            echo "&nbsp;";
            echo "</td>";
        }
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "&nbsp;";
        echo "</td>";
        echo "<td width='25px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['new_user_class'] as $new_user_class) {
            echo "<td width='25px' align='center'>";
            echo $new_user_class;
            echo "</td>";
        }
        echo "<td width='25px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['country'] as $country) {
            foreach ($stats_summary['new_user_class'] as $new_user_class) {
                echo "<td width='25px' align='center'>";
                echo $new_user_class;
                echo "</td>";
            }
            echo "<td width='25px'>";
            echo "&nbsp;";
            echo "</td>";
        }
        echo "</tr>";
        $i = 0;
        foreach ($stats_summary['day'] as $day) {
            $i++;
            if ($i == 30)
            {
                $i = 0;
                echo "<tr>";
                echo "<td>";
                echo "Date";
                echo "</td>";
                echo "<td width='25px'>";
                echo "&nbsp;";
                echo "</td>";
                echo "<td width='25px' colspan='".count($stats_summary['new_user_class'])."' align='center'>";
                echo "Total";
                echo "</td>";
                echo "<td width='25px'>";
                echo "&nbsp;";
                echo "</td>";
                foreach ($stats_summary['country'] as $country)
                {
                    echo "<td width='25px' colspan='".count($stats_summary['new_user_class'])."' align='center'>";
                    echo $country;
                    echo "</td>";
                    echo "<td width='25px'>";
                    echo "&nbsp;";
                    echo "</td>";
                }
                echo "</tr>";

                echo "<tr>";
                echo "<td>";
                echo "&nbsp;";
                echo "</td>";
                echo "<td width='25px'>";
                echo "&nbsp;";
                echo "</td>";
                foreach ($stats_summary['new_user_class'] as $new_user_class) {
                    echo "<td width='25px' align='center'>";
                    echo $new_user_class;
                    echo "</td>";
                }
                echo "<td width='25px'>";
                echo "&nbsp;";
                echo "</td>";
                foreach ($stats_summary['country'] as $country) {
                    foreach ($stats_summary['new_user_class'] as $new_user_class) {
                        echo "<td width='25px' align='center'>";
                        echo $new_user_class;
                        echo "</td>";
                    }
                    echo "<td width='25px'>";
                    echo "&nbsp;";
                    echo "</td>";
                }
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td>";
            echo $day;
            echo "</td>";
            echo "<td width='25px'>";
            echo "&nbsp;";
            echo "</td>";
            foreach ($stats_summary['new_user_class'] as $new_user_class) {
                echo "<td width='25px' align='right'>";
                echo(isset($stats_summary['data'][$new_user_class . $day]) ? $stats_summary['data'][$new_user_class . $day] : 0);
                echo "</td>";
            }
            echo "<td width='25px'>";
            echo "&nbsp;";
            echo "</td>";
            foreach ($stats_summary['country'] as $country)
            {
                foreach ($stats_summary['new_user_class'] as $new_user_class) {
                    echo "<td width='25px' align='right'>";
                    echo(isset($stats_summary['data'][$country . $new_user_class . $day]) ? $stats_summary['data'][$country . $new_user_class . $day] : 0);
                    echo "</td>";
                }
                echo "<td width='25px'>";
                echo "&nbsp;";
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td>";
        echo "Total";
        echo "</td>";
        echo "<td width='25px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['new_user_class'] as $new_user_class) {
            echo "<td width='25px' align='right'>";
            echo(isset($stats_summary['data'][$new_user_class]) ? $stats_summary['data'][$new_user_class] : 0);
            echo "</td>";
        }
        echo "<td width='25px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['country'] as $country)
        {
            foreach ($stats_summary['new_user_class'] as $new_user_class) {
                echo "<td width='25px' align='right'>";
                echo(isset($stats_summary['data'][$country . $new_user_class]) ? $stats_summary['data'][$country . $new_user_class] : 0);
                echo "</td>";
            }
            echo "<td width='25px'>";
            echo "&nbsp;";
            echo "</td>";
        }
        echo "</tr>";
        echo "</table>";
    }

    public function draw2($stats_summary)
    {
        echo "<table>";
        echo "<tr>";
        echo "<td>";
        echo "Date";
        echo "</td>";
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['country'] as $country)
        {
            echo "<td width='25px'>";
            echo $country;
            echo "</td>";
        }
        foreach ($stats_summary['day'] as $day) {
            echo "<tr>";
            echo "<td>";
            echo $day;
            echo "</td>";
            echo "<td width='50px'>";
            echo "&nbsp;";
            echo "</td>";
            foreach ($stats_summary['country'] as $country)
            {
                echo "<td width='25px' align='right'>";
                echo (isset($stats_summary['data'][$country.$day]) ? $stats_summary['data'][$country.$day] : 0);
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function draw1($stats_summary)
    {

        echo "<table>";
        echo "<tr>";
        echo "<td>";
        echo "Country";
        echo "</td>";
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        echo "<td>";
        echo "Total";
        echo "</td>";
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['year'] as $year)
        {
            echo "<td>";
            echo $year;
            echo "</td>";
        }
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['month'] as $month)
        {
            echo "<td>";
            echo $month;
            echo "</td>";
        }
        echo "<tr>";
        foreach ($stats_summary['country'] as $country)
        {
            echo "<tr>";
            echo "<td>";
            echo $country;
            echo "</td>";
            echo "<td width='50px'>";
            echo "&nbsp;";
            echo "</td>";
            echo "<td align='right'>";
            echo $stats_summary['data'][$country];
            echo "</td>";
            echo "<td width='50px'>";
            echo "&nbsp;";
            echo "</td>";
            foreach ($stats_summary['year'] as $year)
            {
                echo "<td align='right'>";
                echo (isset($stats_summary['data'][$country.$year]) ? $stats_summary['data'][$country.$year] : 0);
                echo "</td>";
            }
            echo "<td width='50px'>";
            echo "&nbsp;";
            echo "</td>";
            foreach ($stats_summary['month'] as $month)
            {
                echo "<td align='right'>";
                echo (isset($stats_summary['data'][$country.$month]) ? $stats_summary['data'][$country.$month] : 0);
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td>";
        echo "TOTAL";
        echo "</td>";
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        echo "<td align='right'>";
        echo $stats_summary['data']["ALL"];
        echo "</td>";
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['year'] as $year)
        {
            echo "<td align='right'>";
            echo (isset($stats_summary['data'][$year]) ? $stats_summary['data'][$year] : 0);
            echo "</td>";
        }
        echo "<td width='50px'>";
        echo "&nbsp;";
        echo "</td>";
        foreach ($stats_summary['month'] as $month)
        {
            echo "<td align='right'>";
            echo (isset($stats_summary['data'][$month]) ? $stats_summary['data'][$month] : 0);
            echo "</td>";
        }
        echo "</tr>";
        echo "</table>";
    }

    public function help()
    {
        return view('admin.help');
    }

    public function cron($type = "")
    {
        $cron_log = AdminClass::listCron($type);

        return view('admin.cron')->with('cron_log',$cron_log);
    }

    public function settings()
    {
        $settings = Settings::first();

        return view('admin.settings')->with('settings',$settings);
    }

    public function ph_chart()
    {
        $ph_chart = BankPH::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"),DB::raw("sum(value_in_btc) as btc"))
            ->where('ph_type','=',1)
            ->groupby(DB::raw('year(created_at)'))
            ->groupby(DB::raw('month(created_at)'))
            ->groupby(DB::raw('day(created_at)'))
            ->get();

        return view('admin.ph_chart')->with('ph_chart',$ph_chart);
    }

    public function pledge_chart($type)
    {
        if (strtoupper($type) == "PH") {
            $charts = BankPH::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw("sum(value_in_btc) as btc"))
                ->groupby(DB::raw('year(created_at)'))
                ->groupby(DB::raw('month(created_at)'))
                ->groupby(DB::raw('day(created_at)'))
                ->get();
        } else {
            $charts = BankGH::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw("sum(value_in_btc) as btc"))
                ->groupby(DB::raw('year(created_at)'))
                ->groupby(DB::raw('month(created_at)'))
                ->groupby(DB::raw('day(created_at)'))
                ->get();
        }

        return view('admin.pledge_chart')->with('type',$type)->with('charts',$charts);
    }

    public function passport_chart()
    {
        $passport_chart = Passport::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"),DB::raw("sum(debit) as xtotal"))
            ->where('description','=','Purchased')
            ->groupby(DB::raw('year(created_at)'))
            ->groupby(DB::raw('month(created_at)'))
            ->groupby(DB::raw('day(created_at)'))
            ->get();

        $passport_chart_sum = Passport::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"),DB::raw("sum(debit) as xtotal"))
            ->where('description','=','Purchased')
            ->first();

        $passport_chart_btc = BitcoinBlockioWalletReceiving::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"),DB::raw("sum(value_in_btc) as xtotal"))
            ->where('payment_type','=','P')
            ->where('status','=','2')
            ->groupby(DB::raw('year(created_at)'))
            ->groupby(DB::raw('month(created_at)'))
            ->groupby(DB::raw('day(created_at)'))
            ->get();
        $passport_chart_btc_sum = BitcoinBlockioWalletReceiving::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"),DB::raw("sum(value_in_btc) as xtotal"))
            ->where('payment_type','=','P')
            ->where('status','=','2')
            ->first();

        return view('admin.passport_chart')->with('passport_chart',$passport_chart)->with('passport_chart_btc',$passport_chart_btc)->with('passport_chart_sum',$passport_chart_sum)->with('passport_chart_btc_sum',$passport_chart_btc_sum);
    }
}