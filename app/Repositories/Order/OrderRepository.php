<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends Controller implements OrderInterface
{
    private Order $orderModel;
    private Post $postModel;

    public function __construct(Order $orderModel, Post $postModel)
    {
        $this->orderModel = $orderModel;
        $this->postModel = $postModel;
    }

    public function get($request)
    {
        return $this->orderModel::paginate(config('constants.DATA_PER_PAGE'));
    }
    public function getByUserId($request)
    {
        $id = $request->id;

        return $this->orderModel
            ->where(function ($query) use ($id) {
                $query->where('user_id', $id)
                    ->orWhereHas('post', function ($subQuery) use ($id) {
                        $subQuery->where('user_id', $id);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.DATA_PER_PAGE'));
    }
    public function getByBuyerId($id)
    {
        return $this->orderModel::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.DATA_PER_PAGE'));
    }
    public function getBySellerId($id)
    {
        return $this->orderModel::whereHas('post', function ($query) use ($id) {
            $query->where('author_id', $id);
        })
            ->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->orderModel::find($id);
    }

    public function store($post_id)
    {
        try {
            $currentUserId = Auth::id();
            $currentOrderExist = $this->orderModel::where(['post_id' => $post_id, 'user_id' => $currentUserId])->first();

            if ($currentOrderExist) {
                return response()->json(['message' => __('order.you_have_already_order_this_post')], 500);
            }
            $post = $this->postModel::find($post_id);
            if (!$post) {
                return response()->json(['message' => __('post.not_found')], 500);
            }
            $orderData = [
                'user_id' => $currentUserId,
                'post_id' => $post->id,
                'price' => $post->price,
                'receive_support' => $post->receive_support,
                'expire_limit_month' => $post->expire_limit_month,
                'is_received' => false,
                'is_paid' => false,
            ];
            $post->update(['post_state' => 2]);
            $this->orderModel::create($orderData);
            return response()->json(['message' => __('message.create_success', ['name' => strtolower(__('order.order_in_lang'))])]);
        } catch (\Exception $e) {
            var_dump($e);
            return response()->json(['message' => __('message.server_error')], 500);
        }
    }

    public function update($request, $id)
    {
    }
    public function setPaid($id)
    {
        $order = $this->orderModel::find($id);

        if (!$order) {
            return null;
        }

        $order->update(['is_paid' => true]);

        return $order;
    }
    public function setReceived($id)
    {
        $order = $this->orderModel::find($id);

        if (!$order) {
            return null;
        }

        $order->update(['is_received' => true]);

        return $order;
    }
    public function destroy($id)
    {
        $order = $this->orderModel::find($id);

        if (!$order) {
            return false;
        }

        $order->delete();

        return true;
    }
}
