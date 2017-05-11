<?php
namespace App\Http\Controllers\External;
// controllers
use App\Http\Controllers\Controller;
use App\BitcoinBlockioWalletReceiving;
use App\TrailLog;
use Response;
use Illuminate\Http\Request;
class PassportApiController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
    	//userstemp
    	$ApiKey = $request->get('api_key');
    	$StartFrom = $request->get('StartFrom');
    	$Limit = $request->get('limit');
    	$Lists = BitcoinBlockioWalletReceiving::join('users as u','bitcoin_blockio_wallet_receiving.sender_user_id','=','u.id')
    				//->leftJoin('trail_log', 'bitcoin_blockio_wallet_receiving.sender_user_id', '=', 'trail_log.user_id')
    				->where(function ($sql)use($StartFrom){
    					$sql->where('bitcoin_blockio_wallet_receiving.id', '>', $StartFrom);
    					$sql->where('bitcoin_blockio_wallet_receiving.payment_type','P');
    					$sql->where('bitcoin_blockio_wallet_receiving.status',2);
    					$sql->where('bitcoin_blockio_wallet_receiving.value_in_btc','<=',0.1);
    					//$sql->where('trail_log.title','=','Register');
    				})->take($Limit)
    				->select('u.id','u.email','u.created_at as registeredON','u.firstname', 'bitcoin_blockio_wallet_receiving.id as recId','bitcoin_blockio_wallet_receiving.value_in_btc','bitcoin_blockio_wallet_receiving.receiving_address',
    						'bitcoin_blockio_wallet_receiving.sender_address','bitcoin_blockio_wallet_receiving.wallet_address','bitcoin_blockio_wallet_receiving.secret',
    						'bitcoin_blockio_wallet_receiving.forwarding_private_key','bitcoin_blockio_wallet_receiving.transaction_hash','bitcoin_blockio_wallet_receiving.network','bitcoin_blockio_wallet_receiving.created_at as orderOn')
    			    ->groupBy('recId')
    				->orderBy('orderOn','asc')->get();
    	$data = array();			
    	foreach ($Lists as $list){
    		$userId = $list->id;
    		/*
    		$ip = TrailLog::where(function($qr)use($userId){
    				$qr->where('user_id',$userId);
    				//$qr->where('title', 'like', 'Register%');
    				$qr->where('title','Register');
    		})->pluck('ip');*/
    		$ip = '';
    		
    		$data[] = ['user_id'=>$list->id,'email'=>$list->email,'reg_on'=>$list->registeredON,'firstname'=>$list->firstname, 'recId'=>$list->recId, 
    				'value_in_btc'=>$list->value_in_btc,'ip'=>$ip,
    				'receiving_address'=>$list->receiving_address,
    				'sender_address'=>$list->sender_address,
    				'wallet_address'=>$list->wallet_address,
    				'secret'=>$list->secret,'network'=>$list->network,
    				'forwarding_private_key'=>$list->forwarding_private_key,
    				'transaction_hash'=>$list->transaction_hash,
    				'order_on'=>$list->orderOn
    				
    		];
    	}				
    	//echo '<pre>',print_r($data),'</pre>';
    	return Response::json($data);
    	//return Response::json(['One'=>'1','Two'=>2,'ApiKey'=>$ApiKey,'startFrom'=>$StartFrom]);
    	
    }
    
   
}