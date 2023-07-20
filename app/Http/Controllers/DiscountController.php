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

            $discount = null;
        }

        if (empty($discount)) {
            $discount = new Discount([
                'user_id' => $user->id,
                'value' => rand(1, 50),
                'code' => (string) rand(100000, 999999),
            ]);

            $discount->save();
        }

        $message = sprintf("Ваш код для получения скидки %d%s: %s", $discount->value, '%', $discount->code);

        return view('discount', compact('message'));
    }

    public function check(Request $request)
    {
        $code = $request->input('code');
        $user = auth()->user();
        $answer = 'Скидка недоступна';

        $discount = DB::table('discounts')
            ->where('code', '=', $code)
            ->where('user_id', '=', $user->id)
            ->where('created_at', '>', date('Y-m-d H:i:s', time() - 60 * 60 * 3))
            ->first();

        if (!empty($discount)) {
            $answer = sprintf("Размер вашей скидки: %d%s", $discount->value, '%');
        }

        return view('discount', compact('answer'));
    }
}
