<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/payments",
     *     summary="Create a payment intent",
     *     tags={"Payments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount", "currency", "payment_method"},
     *             @OA\Property(property="amount", type="integer", example=1000, description="Amount in smallest currency unit (e.g., cents for USD)"),
     *             @OA\Property(property="currency", type="string", example="usd", description="Currency code (e.g., usd, eur)"),
     *             @OA\Property(property="payment_method", type="string", example="pm_card_visa", description="Stripe payment method ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment intent created",
     *         @OA\JsonContent(
     *             @OA\Property(property="clientSecret", type="string", example="pi_1FHeJX2eZvKYlo2C1mz8oC6h_secret_Jhd9s9d")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'amount' => 'required|integer',
            'currency' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Set Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $validated['amount'],
                'currency' => $validated['currency'],
                'payment_method' => $validated['payment_method'],
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
