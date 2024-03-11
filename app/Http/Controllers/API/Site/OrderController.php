<?php

namespace App\Http\Controllers\API\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Order\OrderInterface;

class OrderController extends Controller
{
    private $orderRepo;
    private $supportTransactionRepo;
    public function __construct(OrderInterface $orderRepo){
        $this->orderRepo = $orderRepo;
    }
    public function createOrder(Request $request) {
        return $this->orderRepo->store($request->postId);
    }
}
