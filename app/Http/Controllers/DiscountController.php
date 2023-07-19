<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        return view('discount');
    }

    public function create()
    {
        $user = auth()->user();
        $discount = $user->discount;

        if (!empty($discount) && $discount->created_at < date('Y-m-d H:i:s', time() - 60 * 60)) {
            $discount->delete();
        }

        if (empty($discount)) {
            $discount = new Discount([
                'user_id' => $user->id,
                'value' => rand(1, 50),
                'code' => (string) rand(100000, 999999),
            ]);

            $discount->save();
        }

        return view('discount', ['discount' => $discount]);
    }

    public function check($code)
    {
        $user = auth()->user();
        $answer = 'Скидка недоступна';

        $discount = DB::table('discount')
            ->where('code', '=', $code)
            ->where('user_id', '=', $user->id)
            ->where('created_at', '<', date('Y-m-d H:i:s', time() - 60 * 60 * 3))
            ->first();

        if (!empty($discount)) {
            $answer = sprintf("Размер вашей скидки: %d процентов", $discount->value);
        }

        return view('discount', ['discountValue' => $answer]);
    }
}
