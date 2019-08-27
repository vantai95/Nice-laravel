<?php
namespace App\Traits;
use App\Models\OrderLog;
use App\Models\Order;
use Auth;


trait OrderLogTrait{
    public function logHistory($data){
        OrderLog::create($data);
    }

    public function changeOrderStatus($data){
        try{
            $order = Order::findOrFail($data['order_id']);
        }catch(\Exception $exception){
            \Illuminate\Support\Facades\Log::error($exception->getMessage());
        }
        
        $old_order = clone $order;
        $order->status = $data['status'];
        $order->confirm_delivery_time = (isset($data['confirm_time'])) ? $data['confirm_time'] : null;                           
        $order->save();
        $this->saveOrderLog($old_order, $order, $data);
    }
    public function saveOrderLog($old_order, $order, $data){
        $reject_reason = isset($data['reject_reason']) ? "Order was rejected due to ".$data['reject_reason'] : "";        
        $log_data = [
            'order_id' => $order->id, 
            'user_id' => Auth::user()->id,
            'old_status' => $old_order->status, 
            'new_status' => $order->status, 
            'note' => (isset($data['note'])) ? $data['note'] : null,
            'confirm_time' => (isset($data['confirm_time'])) ? $data['confirm_time'] : null,
            'message' => Auth::user()->full_name." has change order from ".Order::STATUS_FILTER[$old_order->status]['name']." to ".Order::STATUS_FILTER[$order->status]['name'].". ".$reject_reason
        ];
        try{
            $this->logHistory($log_data);
        }catch(\Exception $exception){
            \Illuminate\Support\Facades\Log::error($exception->getMessage());
        }
    }
}