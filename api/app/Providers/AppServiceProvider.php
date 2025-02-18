<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($message, $data = null) {
            $request = app(\Illuminate\Http\Request::class);
            return response()->json([
                'success' => true,
                'message' => $message,
                'result' => $data,
                'request' => [
                    'request_type' => $request->method(),
                    'payload' => $request->input(),
                ]
            ]);
        });

        Response::macro('error', function ($message, $code, array $arr = []) {
            $request = app(\Illuminate\Http\Request::class);
            $response = [
                'success' => false,
                'message' => $message,
                'request' => [
                    'request_type' => $request->method(),
                    'payload' => $request->input(),
                ],
            ];

            if (count($arr) > 0) {
                $response = array_merge($response, $arr);
            }

            return response()->json($response, $code);
        });

        Relation::enforceMorphMap([
            'comment' => 'App\Models\Comment',
            'feedback' => 'App\Models\Feedback',
            'user' => 'App\Models\User',
        ]);
        
    }
}
