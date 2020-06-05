<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Booking;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Match;
use App\Player;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class PaymentAPIController extends Controller
{
    public $successStatus = 200;

    public function pay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => [
                'required',
            ],
//            'match_id' => [
//                'required',
//            ],
            'card_name' => [
                'required',
            ],
            'card_number' => [
                'required',
            ],
            'card_cvc' => [
                'required',
            ],
            'card_month' => [
                'required',
            ],
            'card_year' => [
                'required',
            ],
            'amount' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        // stripe payment
        $result = $this->checkPayment($request, $request['amount']);
        if( $result['success'] == false)
            return response()->json($result, 401);

        // if the charge is successful,  add one transaction and update credits in players
        $info = [
            'player_id' => $request['player_id'],
            'match_id' => 0,         // is ignored. this is valid in case of reservation
            'datetime' => now(),
            'event_name' => 'charge',
            'amount' => $request['amount'],     // virtual money
            'credit' => $request['amount'],     // real charged money
        ];

        // create one new transaction
        Transaction::create($info);

        // calculate sum the amount(virtual) to all transactions by player_id
        $purchases = Transaction::where('player_id', '=', $request['player_id'])
            ->sum('amount');

        // update credits of player by player_id
        $player = Player::where('id', '=', $request['player_id'])->first();
        $player->update(['credits' => $purchases]);

        return response()->json(['data' => ['success'=>true]], $this-> successStatus);

    }

    public function createReservations($match, $player)
    {
//        $match = Match::where('id', '=', $request['match_id'])
//            ->first();
//
//        $player = Player::where('id', '=', $request['player_id'])->first();

        // create a new Booking
        $booking  = new Booking;
        $booking['match_id'] = $match['id'];
        $booking['player_id'] = $player['id'];
        $booking->save();

        // increment reservations in Match and update.
        $reservations = $match['reservations']+1;
        $match['reservations'] = $reservations;
        $match->save();
    }

    public function searchBookingPlayers($matchId)
    {
        return
            Booking::selectRaw("*")
                ->leftJoin('players', 'bookings.player_id', '=', 'players.id')
                ->where('match_id', '=', $matchId)
                ->get();

    }
    public function checkReservations($request)
    {
        // check to exist already in Booking
        $tempBooking = Booking::where('match_id', '=', $request['match_id'])
            ->where('player_id', '=', $request['player_id'])
            ->first();
        if( !empty($tempBooking) )
            return ['error'=>'you have already reserved.'];

        $match = Match::where('id', '=', $request['match_id'])
            ->first();

        if( empty($match) )
            return ['error'=>'match is not exist.'];

        if( $match['max_players'] <= $match['reservations'])
            return ['error'=>'booking is full.'];

        if( now() >= Date($match['start_time']))
            return ['error'=>'The match is closed.'];

        $player = Player::where('id', '=', $request['player_id'])->first();

        if( empty($player) )
            return ['error'=>'player is not exist.'];

        return ['error'=> '', 'match' => $match, 'player' => $player];
    }
    public function checkPayment($request)
    {
        $player = Player::where('id', '=', $request['player_id'])->first();

        if(empty($player['email'])) {
            return [
                "success" => false,
                "msg" => "Player is not exist.",
            ];
        }

        $email = $player['email'];

        if($email == '') {
            return [
                "success" => false,
                "msg" => "Email is not exist.",
            ];
        }

        $name = 'unknown';
        $description = 'for football';
        $amount = $request['amount'];
        $card_number= $request['card_number'];
        $card_month= $request['card_month'];
        $card_year= $request['card_year'];
        $card_cvc= $request['card_cvc'];

        $card_info = [
            'number' => $card_number,
            'exp_month' => $card_month,
            'exp_year' => $card_year,
            'cvc' => $card_cvc,
        ];

        $stripe = new \Stripe\StripeClient(
            'sk_test_rDuaPiQJNKMm52cUpJrBVUid00aQqmkA16'
        );
        /**
         * 1. check the validation of the card information.
         */
        try{
            $token = $stripe->tokens->create([
                'card' => $card_info,
            ]);
        }
        catch(\Stripe\Exception\ApiErrorException $e){
            return [
                "success" => false,
                "msg" => "Card verification failed.",
            ];
        }

        /**
         * 1. find the customers by email
         */
        try {
            $customers = $stripe->customers->all([
                'email'=>$email,
                'limit'=>1,
            ]);
        } catch(\Stripe\Exception\ApiErrorException $e){
            return [
                "success" => false,
                "msg" => "Unknown internal error1",
            ];
        }

        /**
         * 3. if customer not exist, create new one.
         */
        if(count($customers->data) == 0){
            try{
                $customer = $stripe->customers->create([
                    'source' => $token,
                    'email' => $email,
                    'name' => $name,
                    'description' => $description,
                ]);
            }
            catch(\Stripe\Exception\ApiErrorException $e){
                return [
                    "success" => false,
                    "msg" => "Create customer failed",
                ];
            }
        }
        else{
            $customer = $customers->data[0];
        }

        try {
            $stripe->charges->create([
                'amount' => $amount*100,
                'currency' => 'gbp',
                'customer' => $customer['id'],
                'description' => 'For WORX',
                'receipt_email' => $email
            ]);

            return ['success'=>true];

        } catch ( \Exception $e ) {
            return [
                "success" => false,
                "msg" => "failed",
            ];
        }
    }

    // @TODO: must move this constant to global configurations.
    const PRODUCTS = [
        'silver' => 'SilverService',
        'gold' => 'GoldService',
    ];

    // @TODO: must replace this security API key with other.
    const API_KEY = 'sk_test_';

    public function createForSubscribe(Request $request)
    {
        /**
         * FIRST of all, set API key.
         */
        Stripe\Stripe::setApiKey(self::API_KEY);

        /**
         * 0. get all the information from user input on the client app or web browser.
         */
        // get card information: card number, expiry(month and year), cvc, and zip
        $card_number = $request->input('card_number', '');
        if(empty($card_number)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid card number",
            ], 400);
        }
        $card_exp_month = $request->input('card_exp_month', '');
        if(empty($card_exp_month)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid expiry (month)",
            ], 400);
        }
        $card_exp_year = $request->input('card_exp_year', '');
        if(empty($card_exp_year)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid expiry (year)",
            ], 400);
        }
        $card_cvc = $request->input('card_cvc', '');
        if(empty($card_cvc)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid card cvc",
            ], 400);
        }

        // manipulate the card information object to be passed to the Stripe.com.
        $card_info = [
            'number' => $card_number,
            'exp_month' => $card_exp_month,
            'exp_year' => $card_exp_year,
            'cvc' => $card_cvc,
        ];

        // if zip code is provided, add it into the card information object. (it's optional.)
        $card_zip = $request->input('card_zip', '');
        if(!empty($card_zip))
            $card_info['address_zip'] = $card_zip;

        // get the email address
        $email = $request->input('email', '');
        if(empty($email)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid email address",
            ], 400);
        }

        // get the user name
        $name = $request->input('name', '');
        if(empty($name)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid user name",
            ], 400);
        }

        // customer description
        $description = $request->input('description', 'create via API endpoint');

        // get the subscription type
        $type = strtolower($request->input('type', ''));
        if(empty($type) || (strcmp($type, 'silver') != 0 && strcmp($type, 'gold') != 0)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid subscription type",
            ], 400);
        }

        // get the subscription interval
        $interval = strtolower($request->input('interval', ''));
        if(empty($interval) || (strcmp($interval, 'month') != 0 && strcmp($interval, 'yearly') != 0)){
            return response()->json([
                "success" => false,
                "msg" => "Invalid subscription interval",
            ], 400);
        }

        // if forcibly = 'true', will replace the old subscription with new one.
        $forcibly = strcmp(strtolower($request->input('forcibly', 'true')), 'false') == 0 ? false : TRUE;

        /**
         * 1. check the validation of the card information.
         */
        try{
            $card_token = Stripe\Token::create([
                'card' => $card_info,
            ]);
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "Card verification failed.",
            ], 400);
        }

        /**
         * 2. Find the customer information from the Stripe.
         */
        try{
            $customers = Stripe\Customer::all([
                'email' => $email,
                'limit' => 1,
            ]);
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "Unknown internal error2",
            ], 500);
        }

        /**
         * 3. if customer not exist, create new one.
         */
        if(count($customers->data) == 0){
            try{
                $customer = Stripe\Customer::create([
                    'email' => $email,
//                    'name' => $name,
                    'description' => $description,
                ]);
            }
            catch(Stripe\Exception\ApiErrorException $e){
                return response()->json([
                    "success" => false,
                    "msg" => "Create customer failed",
                ], 400);
            }
        }
        else{
            $customer = $customers->data[0];
        }

        /**
         * 4. connect a customer with a card information
         */
        try{
            $cards = Stripe\Customer::allSources(
                $customer->id,
                ['object' => 'card', 'limit' => 3]
            );
        }
        catch(Stripe\Exception\ApiErrorException $e){
            // here should not be arrived.
        }

        // remove all the cards from the customer
        if(isset($cards) && count($cards->data) > 0){
            foreach($cards->data as $item){
                try{
                    Stripe\Customer::deleteSource(
                        $customer->id,
                        $item->id
                    );
                }
                catch(Stripe\Exception\ApiErrorException $e){
                }
            }
        }

        // add new card source to the customer
        try{
            Stripe\Customer::createSource(
                $customer->id,
                ['source' => $card_token]
            );
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "Create card source failed",
            ], 400);
        }

        /**
         * 5. Get product information
         */
        try{
            $products = Stripe\Product::all([
                'limit' => 10,
            ]);
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "The product(service) not found1",
            ], 400);
        }

        $product = NULL;
        if(count($products->data) == 0){
            return response()->json([
                "success" => false,
                "msg" => "The product(service) not found2",
            ], 400);
        }
        else{
            foreach($products->data as $item){
                if(strcmp($item->name, self::PRODUCTS[$type]) == 0){
                    $product = $item;
                    break;
                }
            }
        }

        if($product == NULL){
            return response()->json([
                "success" => false,
                "msg" => "The product(service) not found3",
            ], 400);
        }

        /**
         * 6. Get pricing plan.
         */
        try{
            $plans = Stripe\Plan::all([
                'product' => $product->id,
                'limit' => 10,
            ]);
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "For '{$product->name}', {$interval} pricing plan not defined (code: 1)",
            ], 400);
        }
        return response()->json([
            "success" => false,
            "msg" => $plans->data
        ], 400);

        $plan = NULL;
        if(count($plans->data) == 0){
            return response()->json([
                "success" => false,
                "msg" => "For '{$product->name}', {$interval} pricing plan not defined (code: 2)",
            ], 400);
        }
        else{
            foreach($plans->data as $item){
                if(strcmp($item->interval, $interval) == 0){
                    $plan = $item;
                    break;
                }
            }
        }

        if($plan == NULL){
            return response()->json([
                "success" => false,
                "msg" => "For '{$product->name}', {$interval} pricing plan not defined (code: 3)",
            ], 400);
        }

        /**
         * 7. Check the existence of the subscription. If exist and forcibly = false, not needed to create.
         */
        try{
            $subs = Stripe\Subscription::all([
                'customer' => $customer->id,
            ]);
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "Hmm... Something went wrong",
            ], 400);
        }

        if(count($subs->data) > 0 && !$forcibly){
            return response()->json([
                "success" => false,
                "msg" => "The subscription is already exist",
            ], 400);
        }

        /**
         * 8. Create new subscription. before that, remove all the subscription.
         */
        foreach($subs->data as $item){
            $item->delete();
        }

        try{
            Stripe\Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    [
                        'plan' => $plan->id,
                        'quantity' => 1,
                    ],
                ],
            ]);
        }
        catch(Stripe\Exception\ApiErrorException $e){
            return response()->json([
                "success" => false,
                "msg" => "Subscription not created",
            ], 500);
        }

        /**
         * 9. We did it!
         */
        return response()->json([
            "success" => TRUE
        ], 200);
    }
}
