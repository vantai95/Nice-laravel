<?php

namespace App\Console\Commands;

use App\Models\CommissionHistory;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\CommissionRule;
use Log;

class ChargeCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge commission every wednesday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $restaurants = Restaurant::get();

            $dateFrom = (new Carbon())->subWeeks(1)->startOfWeek();
            $dateTo = (new Carbon())->subWeeks(1)->endOfWeek();
            $firstSunday = new Carbon('first sunday of this month');
            foreach ($restaurants as $restaurant) {
                $isExist = false;
                $commissionHistory = CommissionHistory::where('restaurant_id',$restaurant->id)
                    ->whereDate('date_to',$dateTo)
                    ->first();
                if($commissionHistory){
                    $isExist = true;
                }
                if(!$isExist){
                    $isFirstWeek = false;
                    $lastCommissionOfThisMonth = null;
                    if ($dateTo->diffInSeconds($firstSunday->endOfDay()) == 0) {
                        $isFirstWeek = true;
                    } else {
                        $lastCommissionOfThisMonth = CommissionHistory::where('date_to', '>=', (new Carbon($dateTo))->startOfMonth())
                            ->where('date_to', '<=', (new Carbon($dateTo))->endOfMonth())
                            ->where('restaurant_id',$restaurant->id)
                            ->orderBy('date_to', 'desc')->first();
                        if (!$lastCommissionOfThisMonth) {
                            $isFirstWeek = true;
                        }

                    }
                    if ($isFirstWeek) {
                        $lastMonthStartDay = (new Carbon($dateTo))->subMonth()->startOfMonth();
                        $lastMonthEndDay = (new Carbon($dateTo))->subMonth()->endOfMonth();
                        $accepted = Order::whereDate('created_at', '>=', $lastMonthStartDay)
                            ->whereDate('created_at', '<=', $lastMonthEndDay)
                            ->whereNotIn('status', [4, 8])
                            ->where('restaurant_id', $restaurant->id)
                            ->sum('sub_total_amount');

                        $commissionRate = CommissionRule::where('total_from', '<=', $accepted)
                            ->where('total_to', '>', $accepted)->select('commission_rules.*')
                            ->where('restaurant_id', $restaurant->id)
                            ->first();

                        if (empty($commissionRate)) {
                            $commissionRate = 0;
                        } else {
                            $commissionRate = $commissionRate->rate;
                        }
                        $commissionTotal = (($accepted * $commissionRate) / 100) + ((($accepted * $commissionRate) / 100) * 10) / 100;
                    } else {
                        $commissionTotal = $lastCommissionOfThisMonth->unpaid_commission;
                    }
                    $onlinePayment = Order::join('order_transactions', 'orders.id', 'order_transactions.order_id')
                        ->where('orders.restaurant_id', $restaurant->id)
                        ->where('orders.created_at', '>=', $dateFrom)
                        ->where('orders.created_at', '<=', $dateTo)
                        ->where('order_transactions.status', 1)
                        ->where('orders.payment_method', Order::PAYMENT_METHOD['ONLINE_PAYMENT'])
                        ->sum('orders.sub_total_amount');

                    $unPaidCommission = $commissionTotal - $onlinePayment;


                    if($unPaidCommission > 0){
                        $moneyReturn = 0;
                        $payForCommission = $onlinePayment;
                    }else{
                        $payForCommission = $commissionTotal;
                        $moneyReturn = abs($unPaidCommission);
                        $unPaidCommission = 0;
                    }

//                    if ($onlinePayment >= $commissionTotal) {
//                        $payForCommission = $commissionTotal;
//                    } else {
//                        if ($onlinePayment < $commissionTotal) {
//                            $payForCommission = $onlinePayment;
//                        } else {
//                            $payForCommission = 0;
//                        }
//                    }
//
//                    $unPaidCommission = $commissionTotal - $payForCommission;
//
//                    if ($unPaidCommission != 0) {
//                        $moneyReturn = 0;
//                    } else {
//                        $moneyReturn = $onlinePayment - $payForCommission;
//
//                        if($lastCommissionOfThisMonth && $lastCommissionOfThisMonth->money_return != 0){
//                            $moneyReturn = $lastCommissionOfThisMonth->money_return;
//                        }
//                    }

                    CommissionHistory::insert([
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                        'restaurant_id' => $restaurant->id,
                        'commission' => $commissionTotal,
                        'online_payment' => $onlinePayment,
                        'pay_for_commission' => $payForCommission,
                        'unpaid_commission' => $unPaidCommission,
                        'money_returned' => $moneyReturn,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }else{
                    $this->info('Data of '.$restaurant->name_en .' already add in this week, no action required!');
                }
            }
            $this->info('Success!');

        } catch (\Exception $exception) {
            $this->error('Error: ' . $exception->getMessage());
        }

    }
}
