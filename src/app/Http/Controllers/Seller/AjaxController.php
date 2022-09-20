<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Base\BaseController;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Shop;
use App\Services\AjaxService;
use Illuminate\Http\Request;

class AjaxController extends BaseController
{
    private $ajaxService;

    public function __construct(AjaxService $ajaxService)
    {
        $this->ajaxService = $ajaxService;
    }

    public function dispShopNameCheck(Request $request)
    {
        $shop = Shop::where('shop_name', '=', $request['dispShopName'])
            ->where('display_flag', '=', 1)
            ->where('delete_flag', '=', 0)
            ->first();
        $result = false;
        if(is_null($shop)) {
            $result = true;
        }
        return response()->json($result);
    }

    public function urlShopIdCheck(Request $request)
    {
        $shop = Shop::where('display_shop_id', '=', $request['urlShopId'])
            ->where('display_flag', '=', 1)
            ->where('delete_flag', '=', 0)
            ->first();
        $result = false;
        if(is_null($shop)) {
            $result = true;
        }
        return response()->json($result);
    }

    public function shopSaleCheck(Request $request)
    {
        $selectDay = $request['selectDay'];
        $today = $request['today'];
        $beforeDay = $request['beforeDay'];
        $afterDay = $request['afterDay'];
        $selectMonth = $request['selectMonth'];
        $month = $request['month'];
        $beforeMonth = $request['beforeMonth'];
        $afterMonth = $request['afterMonth'];
        (int)$shop_id = $request['shop_id'];

        if($selectDay) {
            $result = $this->ajaxService->shopDaySaleCheck($selectDay, $shop_id);
            return response()->json($result);
        }
        if($today) {
            $result = $this->ajaxService->shopDaySaleCheck($today, $shop_id);
            return response()->json($result);
        }
        if($beforeDay) {
            $result = $this->ajaxService->shopDaySaleCheck($beforeDay, $shop_id);
            return response()->json($result);
        }
        if($afterDay) {
            $result = $this->ajaxService->shopDaySaleCheck($afterDay, $shop_id);
            return response()->json($result);
        }
        if($month) {
            $result = $this->ajaxService->shopMonthSaleCheck($month, $shop_id);
            return response()->json($result);
        }
        if($selectMonth) {
            $result = $this->ajaxService->shopMonthSaleCheck($selectMonth, $shop_id);
            return response()->json($result);
        }
        if($beforeMonth) {
            $result = $this->ajaxService->shopMonthSaleCheck($beforeMonth, $shop_id);
            return response()->json($result);
        }
        if($afterMonth) {
            $result = $this->ajaxService->shopMonthSaleCheck($afterMonth, $shop_id);
            return response()->json($result);
        }
    }

    public function onceSaleCheck(Request $request)
    {
        $selectDay = $request['selectDay'];
        $today = $request['today'];
        $beforeDay = $request['beforeDay'];
        $afterDay = $request['afterDay'];
        $selectMonth = $request['selectMonth'];
        $month = $request['month'];
        $beforeMonth = $request['beforeMonth'];
        $afterMonth = $request['afterMonth'];
        (int)$once_id = $request['once_id'];

        if($selectDay) {
            $result = $this->ajaxService->onceDaySaleCheck($selectDay, $once_id);
            return response()->json($result);
        }
        if($today) {
            $result = $this->ajaxService->onceDaySaleCheck($today, $once_id);
            return response()->json($result);
        }
        if($beforeDay) {
            $result = $this->ajaxService->onceDaySaleCheck($beforeDay, $once_id);
            return response()->json($result);
        }
        if($afterDay) {
            $result = $this->ajaxService->onceDaySaleCheck($afterDay, $once_id);
            return response()->json($result);
        }
        if($month) {
            $result = $this->ajaxService->onceMonthSaleCheck($month, $once_id);
            return response()->json($result);
        }
        if($selectMonth) {
            $result = $this->ajaxService->onceMonthSaleCheck($selectMonth, $once_id);
            return response()->json($result);
        }
        if($beforeMonth) {
            $result = $this->ajaxService->onceMonthSaleCheck($beforeMonth, $once_id);
            return response()->json($result);
        }
        if($afterMonth) {
            $result = $this->ajaxService->onceMonthSaleCheck($afterMonth, $once_id);
            return response()->json($result);
        }
    }

    public function onceOrderCheck(Request $request) {
        $shop_id = $request['shop_id'];
        $start_day = $request['start_day'];
        $end_day = $request['end_day'];
        $last_id = $request['last_id'];
        if(is_null($start_day)) {
            $start_day = date("Y-m-01");
        }
        if(is_null($end_day)) {
            $end_day = date("Y-m-d");
        }
        if(is_null($last_id)) {
            $last_id = 0;
        }
        $orders = Order::where('shop_id', '=', $shop_id)
        ->whereBetween('order_date', [$start_day, $end_day])
        ->where('id', '>', $last_id)
        ->limit(20)
        ->get();
        $result = [];
        $total_amount = 0;
        foreach($orders as $order_index => $order) {
            $total_amount = $order->amount + $total_amount;
            $result['orders'][$order_index]['amount'] = $order->amount;
            $result['orders'][$order_index]['order_date'] = $order->order_date;
            $result['orders'][$order_index]['order_status'] = $order->order_status;
            // 1オーダー総額計算処理追加
            $products = OrderProduct::where('order_id', '=', $order->id)
            ->get();
            foreach($products as $product_index => $product) {
                $result['orders'][$order_index]['products'][$product_index]['product_id'] = $product->product_id;
                $result['orders'][$order_index]['products'][$product_index]['product_name'] = $product->product_name;
                $result['orders'][$order_index]['products'][$product_index]['quantity'] = $product->quantity;
            }
            $member = Member::where('id', '=', $order->member_id)->first();
            if(is_null($member)) {
                $result['orders'][$order_index]['first_name'] = 'first_name';
                $result['orders'][$order_index]['last_name'] = 'last_name';
            } else {
                $result['orders'][$order_index]['first_name'] = $member->first_name;
                $result['orders'][$order_index]['last_name'] = $member->last_name;
            }
            $result['last_id'] = $order->id;
        }
        if(is_null($orders)) {
            $result['no_data'] = 'no_data';
        }
        $result['total_amount'] = number_format($total_amount);
        return response()->json($result);
    }
}
