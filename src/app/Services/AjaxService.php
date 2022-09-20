<?php

namespace App\Services;

use App\Models\SalesDaily;
use App\Models\SalesMonthly;
use App\Models\Shop;

class AjaxService
{
    public function shopDaySaleCheck($day, $shop_id)
    {
        // 対象日
        $datas = SalesDaily::where('sales_date', 'like', "%$day%")
            ->where('shop_id', '=', $shop_id)
            ->get();
        // 報酬
        $sellers_reward = 0;
        $amount = 0;
        $quantity = 0;
        foreach($datas as $data) {
            $sellers_reward = $data->sellers_reward + $sellers_reward;
            $amount = $data->amount + $amount;
            $quantity = $data->quantity + $quantity;
        }
        // 指定日から前日
        $yesterday =  date('Y-m-d', strtotime("$day -1 day"));
        $yesterdayDatas = SalesDaily::where('sales_date', '=', $yesterday)
            ->where('shop_id', '=', $shop_id)
            ->get();

        $yesterday_amount = 0;
        foreach($yesterdayDatas as $yesterdayData) {
            $yesterday_amount = $yesterdayData->amount + $yesterday_amount;
        }
        // 前日比(カンマ区切り)
        $result['dayBeforeRatio'] = number_format($amount - $yesterday_amount);
        // 報酬(カンマ区切り)
        $result['sellers_reward'] = number_format($sellers_reward);
        // 注文総額(カンマ区切り)
        $result['amount'] = number_format($amount);
        // 売上個数(カンマ区切り)
        $result['quantity'] = number_format($quantity);

        return $result;
    }

    public function shopMonthSaleCheck($month, $shop_id){
        // 対象月
        $datas = SalesMonthly::where('sales_date', 'like', "%$month%")
            ->where('shop_id', '=', $shop_id)
            ->get();
        // 報酬
        $sellers_reward = 0;
        $amount = 0;
        $quantity = 0;
        foreach($datas as $data) {
            $sellers_reward = $data->sellers_reward + $sellers_reward;
            $amount = $data->amount + $amount;
            $quantity = $data->quantity + $quantity;
        }
        // (対象日を基準とした)前日
        $before_month = date("Y-m-d",strtotime("$month -1 months"));
        $MonthDatas = SalesMonthly::where('sales_date', '=', $before_month)
            ->where('shop_id', '=', $shop_id)
            ->get();
        $monthDataAmount = 0;
        foreach($MonthDatas as $MonthData) {
            $monthDataAmount = $MonthData->amount + $monthDataAmount;
        }
        // 前月比(カンマ区切り)
        $result['dayBeforeRatio'] = number_format($amount - $monthDataAmount);
        // 報酬(カンマ区切り)
        $result['sellers_reward'] = number_format($sellers_reward);
        // 注文総額(カンマ区切り)
        $result['amount'] = number_format($amount);
        // 売上個数(カンマ区切り)
        $result['quantity'] = number_format($quantity);

        return $result;
    }

    public function onceDaySaleCheck($day, $once_id){
        $shopList = Shop::where('once_id' ,'=', $once_id)->get();
        $sellers_reward = 0;
        $amount = 0;
        $quantity = 0;
        $yesterdayDatas = null;
        foreach($shopList as $shop) {
            // 対象日
            $datas = SalesDaily::where('sales_date', 'like', "%$day%")
            ->where('shop_id', '=', $shop->id)
            ->get();
            // 報酬
            foreach($datas as $data) {
                $sellers_reward = $data->sellers_reward + $sellers_reward;
                $amount = $data->amount + $amount;
                $quantity = $data->quantity + $quantity;
            }
            // 指定日から前日
            $yesterday =  date('Y-m-d', strtotime("$day -1 day"));
            $yesterdayDatas[] = SalesDaily::where('sales_date', 'like', "%$yesterday%")
                ->where('shop_id', '=', $shop->id)
                ->get();
        }
        $yesterday_amount = 0;
        foreach($yesterdayDatas as $yesterdayData) {
            foreach($yesterdayData as $data) {
                $yesterday_amount = $data->amount + $yesterday_amount;
            }
        }
        // 前日比(カンマ区切り)
        $result['dayBeforeRatio'] = number_format($amount - $yesterday_amount);
        // 報酬(カンマ区切り)
        $result['sellers_reward'] = number_format($sellers_reward);
        // 注文総額(カンマ区切り)
        $result['amount'] = number_format($amount);
        // 売上個数(カンマ区切り)
        $result['quantity'] = number_format($quantity);

        return $result;
    }

    public function onceMonthSaleCheck($month, $once_id){
        $shopList = Shop::where('once_id' ,'=', $once_id)->get();
        $sellers_reward = 0;
        $amount = 0;
        $quantity = 0;
        $MonthDatas = null;
        foreach($shopList as $shop) {
            // 対象日
            $datas = SalesMonthly::where('sales_date', 'like', "%$month%")
                ->where('shop_id', '=', $shop->id)
                ->get();
            // 報酬
            foreach($datas as $data) {
                $sellers_reward = $data->sellers_reward + $sellers_reward;
                $amount = $data->amount + $amount;
                $quantity = $data->quantity + $quantity;
            }
            // 指定日から前月
            $before_month = date("Y-m",strtotime("$month -1 months"));
            $MonthDatas[] = SalesMonthly::where('sales_date', 'like', "%$before_month%")
                ->where('shop_id', '=', $shop->id)
                ->get();
        }

        $monthDataAmount = 0;
        foreach($MonthDatas as $MonthData) {
            foreach($MonthData as $data) {
                $monthDataAmount = $data->amount + $monthDataAmount;
            }
        }
        // 前月比(カンマ区切り)
        $result['dayBeforeRatio'] = number_format($amount - $monthDataAmount);
        // 報酬(カンマ区切り)
        $result['sellers_reward'] = number_format($sellers_reward);
        // 注文総額(カンマ区切り)
        $result['amount'] = number_format($amount);
        // 売上個数(カンマ区切り)
        $result['quantity'] = number_format($quantity);

        return $result;
    }
}