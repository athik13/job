<?php


namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;

class DemoRestriction
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isDemo()) {
            $message = t('demo_mode_message');

            if ($request->ajax()) {
                $result = [
                    'success' => false,
                    'msg'     => $message,
                ];

                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                if (isFromAdminPanel()) {
                    Alert::info($message)->flash();
                } else {
                    flash($message)->info();
                }

                return redirect()->back();
            }
        }

        return $next($request);
    }
}
