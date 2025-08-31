<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function() {
    return view('welcome');
});

Route::get('/test', function (Request $request) {
    $host = $request->getHost();
    $subdomain = null;

    // Extract subdomain from host
    if (str_contains($host, '.codezury.test')) {
        $parts = explode('.', $host);
        if (count($parts) >= 2 && $parts[0] !== 'codezury') {
            $subdomain = $parts[0];
        }
    }

    return view('subdomain-test', [
        'host' => $host,
        'subdomain' => $subdomain,
        'url' => $request->url(),
        'fullUrl' => $request->fullUrl(),
        'headers' => $request->headers->all(),
    ]);
});

Route::get('/info', function (Request $request) {
    return response()->json([
        'success' => true,
        'host' => $request->getHost(),
        'subdomain_detected' => str_contains($request->getHost(), '.codezury.test')
            ? explode('.', $request->getHost())[0]
            : 'none',
        'server_name' => $_SERVER['SERVER_NAME'] ?? 'Not set',
        'http_host' => $_SERVER['HTTP_HOST'] ?? 'Not set',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Not set',
        'timestamp' => now()->toDateTimeString(),
    ]);
});

Route::get('/dns-test', function () {
    $results = [];

    // Test DNS resolution from within the container
    $domains = ['codezury.test', 'test.codezury.test', 'demo.codezury.test', 'random.codezury.test'];

    foreach ($domains as $domain) {
        $ip = gethostbyname($domain);
        $results[$domain] = [
            'domain' => $domain,
            'resolved_ip' => $ip,
            'is_working' => $ip !== $domain,
        ];
    }

    return response()->json([
        'dns_test_results' => $results,
        'container_ip' => $_SERVER['SERVER_ADDR'] ?? 'Unknown',
        'timestamp' => now()->toDateTimeString(),
    ]);
});
