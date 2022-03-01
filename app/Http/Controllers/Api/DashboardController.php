<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChartResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function chart()
    {
        Gate::authorize('view', 'orders');

        /* first way with eloquent */
//        return Order::select(['id', 'created_at'])
//            ->orderBy('created_at')
//            ->get()
//            ->transform(function ($order) {
//            return [
//                'created_at' => $order->created_at,
//                'total' => $order->total,
//            ];
//        })
//        ->toArray();

        /* second way with joins */
        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, SUM(order_items.quantity * order_items.price) as sum")
            ->groupBy('date')
            ->get();

        return ChartResource::collection($orders);
    }
}
