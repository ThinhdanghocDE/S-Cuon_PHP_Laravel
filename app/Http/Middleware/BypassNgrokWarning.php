<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BypassNgrokWarning
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Thêm header vào request để bypass Ngrok warning page
        // Ngrok sẽ kiểm tra header này trong request và bỏ qua warning page
        $request->headers->set('ngrok-skip-browser-warning', 'true');
        
        // Set custom User-Agent để bypass (nếu cần)
        // Ngrok sẽ không hiển thị warning cho non-standard User-Agent
        if (!$request->headers->has('User-Agent') || 
            strpos($request->headers->get('User-Agent'), 'Mozilla') === false) {
            // Nếu không phải browser request, không cần làm gì
        }
        
        $response = $next($request);
        
        // Thêm header vào response (một số trường hợp cần)
        $response->headers->set('ngrok-skip-browser-warning', 'true');
        
        return $response;
    }
}

