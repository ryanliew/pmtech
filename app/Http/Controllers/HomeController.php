<?php

namespace App\Http\Controllers;

use App\Earning;
use App\Machine;
use App\Setting;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal_bitcoins = 0.00;
        $units = [];
        foreach(Machine::whereIn('id', auth()->user()->units->pluck('machine_id'))->get() as $machine)
        {
            $total = 0;
            foreach($machine->earnings as $earning)
            {
                $total += $earning->transactions()->profits()->where('user_id', auth()->id())->sum('amount');
                $personal_bitcoins += $earning->transactions()->profits()->where('user_id', auth()->id())->get()->sum(function($transaction){ return $transaction->bitcoin_earning; });
            }
            $all = auth()->user()->units()->where('machine_id', $machine->id)->get();
            $date = null;

            foreach( $all as $unit )
            {
                if($date == null or $date->gt($unit->updated_at))
                {
                    $date = $unit->updated_at;
                }
            }
            $units[$machine->id] = [
                "name"  => $machine->name,
                "status" => $machine->status,
                "total" => $total,
                "count" => $all->count(),
                "date"  => $date
            ];
        }

        return view('home', ['unverified_users' => User::inactive()->get(), 
                                'payments' => Earning::all()->sum('final_amount'),
                                'machines' => Machine::active()->count(),
                                'units' => $units,
                                'personaltotalbitcoins' => $personal_bitcoins,
                                'totalbitcoins' => Earning::sum('cryptocurrency_amount'),
                                'commision' => Transaction::commision()->current()->sum('amount'),
                                'power' => Setting::first()->hashing_power
                            ]);
    }

    public function repeater()
    {
        $url = request()->url;

        $client = new \GuzzleHttp\Client();

        $request = $client->get($url);

        $response = $request->getBody();
        
        return($response);   
    }

    public function getHistoricalData()
    {
        $coins = ['BTC', 'DASH', 'ETH'];

        $result['datasets'] = [];
        $result['labels'] = [];

        foreach($coins as $key => $coin)
        {
            $url = 'https://min-api.cryptocompare.com/data/histoday?fsym=' . $coin . '&tsym=USD&limit=30&aggregate=3';

            $client = new \GuzzleHttp\Client();

            $request = $client->get($url);

            $response = $request->getBody();

            $content = json_decode($response);

            $prepdata = collect($content->Data)->pluck('close')->all();
            
            $preplabel = collect($content->Data)->pluck('time')->all();

            $color = $this->getColor($key);
            $colorvalue = "rgba(" . $color[0] . "," . $color[1] . "," . $color[2] . ",1)";
            $result['datasets'][$key] = [
                "label" => $coin,
                "fill"  => false,
                "lineTension" => 0.1,
                "borderColor" => $colorvalue,
                "backgroundColor" => $colorvalue,
                "borderCapStyle" => "butt",
                "borderDash" => [],
                "borderJoinStyle" => 'miter',
                "pointBorderColor" => $colorvalue,
                "pointBackgroundColor" => "#fff",
                "pointBorderWidth" => 1,
                "pointHoverRadius" => 5,
                "pointHoverBackgroundColor" => $colorvalue,
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "pointHoverBorderWidth" => 2,
                "pointRadius" => 1,
                "pointHitRadius" => 10,
                "spanGaps" => false
            ];

            $result['datasets'][$key]['data'] = $prepdata;

            foreach($preplabel as $key => $time)
            {
                $preplabel[$key] = Carbon::createFromTimestamp($time)->toDateString();
            }

            $result['labels'] = $preplabel;
        }

        return $result;
    }

    function getColor($num) {
        $hash = md5('colors' . $num); // modify 'color' to get a different palette
        return array(
            hexdec(substr($hash, 0, 2)), // r
            hexdec(substr($hash, 2, 2)), // g
            hexdec(substr($hash, 3, 2))); //b
    }
}
