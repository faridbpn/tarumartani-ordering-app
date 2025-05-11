<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekMejaLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('meja_id')) {
            // return redirect()->route('scan.qrcode')->with('error', 'Silakan scan QR code meja terlebih dahulu.');
            abort(403, 'Silakan scan QR code meja terlebih dahulu.');
        }

        return $next($request);
    }
}
