<?php

use Illuminate\Http\Request;
use App\Models\DiscountCode;

Route::get('/check-discount', function (Request $request) {
    $code = $request->get('code');
    $amount = $request->get('amount');
    $duration = $request->get('duration');

    $discountCode = DiscountCode::where('code', $code)
        ->where('is_active', true)
        ->first();

    if (!$discountCode || !$discountCode->isValid()) {
        return response()->json([
            'valid' => false,
            'message' => 'Ongeldige kortingscode'
        ]);
    }

    $discount = $discountCode->calculateDiscount($amount);

    return response()->json([
        'valid' => true,
        'discount' => $discount,
        'message' => match($discountCode->type) {
            'percentage' => "Korting van {$discountCode->value}% toegepast!",
            'fixed' => "Korting van €{$discountCode->value} toegepast!",
            'free' => "100% korting toegepast!",
            default => "Kortingscode toegepast!"
        }
    ]);
});
