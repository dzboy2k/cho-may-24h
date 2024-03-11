<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SupportTransaction\SupportTransactionInterface;
use App\Repositories\Order\OrderInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Exceptions\UserNotFound as UserNotFoundException;
use App\Exceptions\PostNotFound as PostNotFoundException;

class OrderController extends Controller
{
    private $orderRepo;
    private $supportTransactionRepo;

    public function __construct(OrderInterface $orderRepo, SupportTransactionInterface $supportTransactionRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->supportTransactionRepo = $supportTransactionRepo;
    }
    public function buyOrdersHistory()
    {
        try {
            $userId = Auth::id();
            $orderType = 'buy';
            $listOrder = $this->orderRepo->getByBuyerId($userId);
            return view('site.history.order_history', compact('listOrder', 'orderType'));
        } catch (\Exception $e) {
            return view('errors.500');
        }
    }

    public function sellOrdersHistory()
    {
        try {
            $userId = Auth::id();
            $orderType = 'sell';
            $listOrder = $this->orderRepo->getBySellerId($userId);
            return view('site.history.order_history', compact('listOrder', 'orderType'));
        } catch (\Exception $e) {
            return view('errors.500');
        }
    }

    public function detail(Request $request)
    {
        $order = $this->orderRepo->getById($request->id);
        if ($order) {
            return view('site.history.order_detail', compact('order'));
        } else {
            return back()->with('message', ['content' => __('order.not_found'), 'type' => 'error']);
        }
    }
    public function setPaid(Request $request)
    {
        return $this->handleOrderStatusUpdate($request->id, 'setPaid', 'order.order_set_paid_success');
    }

    public function setReceived(Request $request)
    {
        return $this->handleOrderStatusUpdate($request->id, 'setReceived', 'order.order_set_received_success');
    }
    protected function handleOrderStatusUpdate($orderId, $status, $successMessage)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepo->$status($orderId);
            if ($order) {
                $this->handleCreateSupportTransactionFromPost($order);
                DB::commit();
                return back()->with('message', ['content' => __($successMessage), 'type' => 'success']);
            } else {
                return back()->with('message', ['content' => __('order.not_found'), 'type' => 'error']);
            }


        } catch (\Exception $exception) {
            DB::rollBack();

            if ($exception instanceof UserNotFoundException || $exception instanceof PostNotFoundException) {
                $target = __('message.user');
                if ($exception instanceof PostNotFoundException) {
                    $target = __('post.post_in_lang');
                }
                return back()->with('message', ['content' => __('message.target_not_found', ['target' => $target]), 'type' => 'error']);
            } else {
                return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
            }
        }
    }
    private function handleCreateSupportTransactionFromPost($order)
    {
        if ($order->receive_support > 0 && $order->is_received && $order->is_paid) {
            $data = ['user_id' => $order->user_id, 'post_id' => $order->post_id];
            $this->supportTransactionRepo->createSupportTransactionForUserIdFromPost($data);
        }
    }
}
