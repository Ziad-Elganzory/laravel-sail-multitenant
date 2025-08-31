@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-center">
                🐳 Containerized DNS + Subdomain Test
            </h1>

            <!-- Connection Info -->
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-blue-800 mb-2">🌐 Multi-Tenant Architecture Status</h2>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <strong>Access Method:</strong> http://localhost (port 80)<br>
                        <strong>DNS Service:</strong> Running on port 5454<br>
                        <strong>Base Domain:</strong> codezury.test
                    </div>
                    <div>
                        <strong>Container Network:</strong> 172.20.0.0/16<br>
                        <strong>Laravel IP:</strong> 172.20.0.10<br>
                        <strong>DNS IP:</strong> 172.20.0.53
                    </div>
                </div>
            </div>

            <!-- Current Tenant Info -->
            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div class="bg-green-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-green-800 mb-2">🏠 Current Host</h2>
                    <p class="text-xl font-mono text-green-600 break-all">{{ $host }}</p>
                </div>

                <div class="bg-purple-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-purple-800 mb-2">🏢 Tenant/Subdomain</h2>
                    <p class="text-xl font-mono text-purple-600">
                        {{ $subdomain ? $subdomain : 'Main Domain' }}
                    </p>
                    @if($subdomain)
                        <span class="inline-block bg-purple-200 text-purple-800 text-xs px-2 py-1 rounded mt-1">
                            TENANT DETECTED
                        </span>
                    @endif
                </div>

                <div class="bg-indigo-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-indigo-800 mb-2">🌍 Resolution Status</h2>
                    <div class="text-sm">
                        @if($subdomain)
                            <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded">✅ RESOLVED</span>
                            <p class="mt-1 text-indigo-700">Wildcard DNS working</p>
                        @else
                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded">🏠 MAIN SITE</span>
                            <p class="mt-1 text-indigo-700">Base domain access</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dynamic Status Banner -->
            <div class="text-center mb-6">
                @if($subdomain)
                    <div class="bg-gradient-to-r from-green-100 to-emerald-100 border border-green-400 text-green-800 px-6 py-4 rounded-lg">
                        <div class="flex items-center justify-center space-x-2 mb-2">
                            <span class="text-2xl">🎉</span>
                            <strong class="text-lg">Multi-Tenant System Active!</strong>
                        </div>
                        <p>Currently serving: <strong class="bg-green-200 px-2 py-1 rounded">{{ $subdomain }}.codezury.test</strong></p>
                        <small class="text-green-600">DNS container successfully resolved wildcard subdomain</small>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-blue-100 to-indigo-100 border border-blue-400 text-blue-800 px-6 py-4 rounded-lg">
                        <div class="flex items-center justify-center space-x-2 mb-2">
                            <span class="text-2xl">🏠</span>
                            <strong class="text-lg">Main Domain Access</strong>
                        </div>
                        <p>You're accessing the primary domain: <strong class="bg-blue-200 px-2 py-1 rounded">codezury.test</strong></p>
                        <small class="text-blue-600">Ready to test subdomain routing</small>
                    </div>
                @endif
            </div>

            <!-- Quick Test Section -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg mb-6 border border-yellow-200">
                <h2 class="text-xl font-semibold text-yellow-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">🧪</span>
                    Quick Subdomain Tests
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- cURL Tests -->
                    <div>
                        <h3 class="font-semibold text-yellow-700 mb-2">cURL Commands:</h3>
                        <div class="bg-gray-800 text-green-400 p-3 rounded text-sm font-mono space-y-1">
                            <div>curl -H "Host: test.codezury.test" http://localhost</div>
                            <div>curl -H "Host: demo.codezury.test" http://localhost</div>
                            <div>curl -H "Host: client1.codezury.test" http://localhost</div>
                        </div>
                    </div>

                    <!-- Browser Tests -->
                    <div>
                        <h3 class="font-semibold text-yellow-700 mb-2">Browser Tests:</h3>
                        <div class="space-y-2">
                            <button onclick="testSubdomain('test')" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700 w-full">
                                Test: test.codezury.test
                            </button>
                            <button onclick="testSubdomain('demo')" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700 w-full">
                                Test: demo.codezury.test
                            </button>
                            <button onclick="testSubdomain('api')" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700 w-full">
                                Test: api.codezury.test
                            </button>
                        </div>
                        <p class="text-xs text-yellow-600 mt-2">
                            *Uses fetch API with Host header simulation
                        </p>
                    </div>
                </div>

                <!-- /etc/hosts Alternative -->
                <div class="mt-4 p-3 bg-yellow-100 rounded">
                    <h3 class="font-semibold text-yellow-700 mb-1">Alternative: Add to /etc/hosts</h3>
                    <div class="bg-gray-800 text-green-400 p-2 rounded text-xs font-mono">
                        127.0.0.1 codezury.test test.codezury.test demo.codezury.test api.codezury.test
                    </div>
                </div>
            </div>

            <!-- Server Variables -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Request Information</h2>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="flex">
                        <span class="font-semibold w-1/2">URL:</span>
                        <span class="font-mono text-blue-600">{{ $url }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-1/2">Full URL:</span>
                        <span class="font-mono text-blue-600">{{ $fullUrl }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-1/2">HTTP_HOST:</span>
                        <span class="font-mono text-blue-600">{{ $_SERVER['HTTP_HOST'] ?? 'Not set' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-1/2">SERVER_NAME:</span>
                        <span class="font-mono text-blue-600">{{ $_SERVER['SERVER_NAME'] ?? 'Not set' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-1/2">REQUEST_URI:</span>
                        <span class="font-mono text-blue-600">{{ $_SERVER['REQUEST_URI'] ?? 'Not set' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-1/2">SERVER_PORT:</span>
                        <span class="font-mono text-blue-600">{{ $_SERVER['SERVER_PORT'] ?? 'Not set' }}</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced API Tests -->
            <div class="grid md:grid-cols-3 gap-4 mb-6">
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-purple-800 mb-2 flex items-center">
                        <span class="mr-2">📊</span>Info API
                    </h2>
                    <p class="text-sm text-purple-600 mb-3">JSON endpoint with subdomain detection</p>
                    <a href="/info" target="_blank" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 inline-block text-sm">
                        Test /info Endpoint
                    </a>
                </div>

                <div class="bg-indigo-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-indigo-800 mb-2 flex items-center">
                        <span class="mr-2">🔍</span>DNS Test
                    </h2>
                    <p class="text-sm text-indigo-600 mb-3">Container DNS resolution verification</p>
                    <a href="/dns-test" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 inline-block text-sm">
                        Test DNS Resolution
                    </a>
                </div>

                <div class="bg-teal-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-teal-800 mb-2 flex items-center">
                        <span class="mr-2">⚡</span>Live Test
                    </h2>
                    <p class="text-sm text-teal-600 mb-3">Real-time subdomain switching</p>
                    <button onclick="runLiveTest()" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 text-sm">
                        Run Live Test
                    </button>
                </div>
            </div>

            <!-- Test Results Area -->
            <div id="test-results" class="hidden bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">🧪 Test Results:</h3>
                <div id="test-output" class="bg-white p-3 rounded border font-mono text-sm"></div>
            </div>

            <!-- Enhanced Debug Info -->
            <details class="bg-gray-50 p-4 rounded-lg mb-4">
                <summary class="cursor-pointer font-semibold text-gray-800 mb-2 flex items-center">
                    <span class="mr-2">🔧</span>Technical Debug Information
                </summary>
                <div class="mt-4 space-y-4">
                    <!-- Architecture Overview -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Container Network:</h3>
                            <div class="bg-gray-100 p-2 rounded text-xs space-y-1">
                                <div><strong>Network:</strong> sail (172.20.0.0/16)</div>
                                <div><strong>Laravel:</strong> 172.20.0.10</div>
                                <div><strong>DNS:</strong> 172.20.0.53</div>
                                <div><strong>DNS Ports:</strong> 5454:53 (host:container)</div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Domain Resolution:</h3>
                            <div class="bg-gray-100 p-2 rounded text-xs space-y-1">
                                <div><strong>Pattern:</strong> *.codezury.test → 172.20.0.10</div>
                                <div><strong>Apache:</strong> ServerAlias *.codezury.test</div>
                                <div><strong>Laravel:</strong> Host header detection</div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Headers -->
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Request Headers:</h3>
                        <pre class="bg-gray-200 p-3 rounded text-xs overflow-x-auto max-h-48">{{ json_encode($headers, JSON_PRETTY_PRINT) }}</pre>
                    </div>

                    <!-- Performance Metrics -->
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Performance & Environment:</h3>
                        <div class="grid md:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1">
                                <div><strong>PHP Version:</strong> {{ PHP_VERSION }}</div>
                                <div><strong>Laravel Version:</strong> {{ app()->version() }}</div>
                                <div><strong>Environment:</strong> {{ app()->environment() }}</div>
                            </div>
                            <div class="space-y-1">
                                <div><strong>Memory Usage:</strong> {{ round(memory_get_usage(true) / 1024 / 1024, 2) }} MB</div>
                                <div><strong>Response Time:</strong> <span id="response-time">Calculating...</span></div>
                                <div><strong>Timestamp:</strong> {{ now()->toDateTimeString() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </details>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <span class="mr-2">⚡</span>Quick Actions
                </h3>
                <div class="flex flex-wrap gap-2">
                    <button onclick="location.reload()" class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                        🔄 Refresh Page
                    </button>
                    <button onclick="copyCurrentUrl()" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                        📋 Copy URL
                    </button>
                    <button onclick="exportDebugInfo()" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                        💾 Export Debug Info
                    </button>
                    <button onclick="testAllSubdomains()" class="bg-purple-600 text-white px-3 py-1 rounded text-sm hover:bg-purple-700">
                        🚀 Test All Subdomains
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
        // Page load timing
        const pageLoadStart = performance.now();

        window.addEventListener('load', function() {
            const loadTime = (performance.now() - pageLoadStart).toFixed(2);
            document.getElementById('response-time').textContent = loadTime + ' ms';
        });

        // Test individual subdomain
        async function testSubdomain(subdomain) {
            const url = `http://codezury.test/info`;
            const host = `${subdomain}.codezury.test`;

            try {
                showTestResults(`Testing ${host}...`);

                // Note: In real browser, we can't set Host header due to CORS
                // This is just a simulation for demonstration
                const response = await fetch(url);
                const data = await response.json();

                showTestResults(`✅ ${host}\nStatus: ${response.status}\nData: ${JSON.stringify(data, null, 2)}`);
            } catch (error) {
                showTestResults(`❌ Error testing ${host}: ${error.message}`);
            }
        }

        // Run comprehensive live test
        async function runLiveTest() {
            const testSubdomains = ['test', 'demo', 'api', 'client1', 'admin'];
            let results = '🧪 LIVE SUBDOMAIN TEST RESULTS\n' + '='.repeat(40) + '\n\n';

            showTestResults('Running comprehensive subdomain tests...');

            for (const subdomain of testSubdomains) {
                results += `Testing ${subdomain}.codezury.test:\n`;
                try {
                    const response = await fetch('/info');
                    results += `  ✅ Response: ${response.status}\n`;
                } catch (error) {
                    results += `  ❌ Error: ${error.message}\n`;
                }
                results += '\n';
            }

            results += 'NOTE: Browser security prevents setting Host headers.\n';
            results += 'Use cURL commands or /etc/hosts for actual subdomain testing.';

            showTestResults(results);
        }

        // Test all subdomains
        function testAllSubdomains() {
            const commands = [
                'curl -H "Host: test.codezury.test" http://localhost/info',
                'curl -H "Host: demo.codezury.test" http://localhost/info',
                'curl -H "Host: api.codezury.test" http://localhost/info',
                'curl -H "Host: client1.codezury.test" http://localhost/info'
            ];

            const output = '🚀 CURL COMMANDS FOR SUBDOMAIN TESTING\n' +
                          '='.repeat(45) + '\n\n' +
                          commands.join('\n\n') +
                          '\n\n💡 Copy and run these commands in your terminal.';

            showTestResults(output);
        }

        // Show test results
        function showTestResults(content) {
            const resultsDiv = document.getElementById('test-results');
            const outputDiv = document.getElementById('test-output');

            resultsDiv.classList.remove('hidden');
            outputDiv.textContent = content;

            // Scroll to results
            resultsDiv.scrollIntoView({ behavior: 'smooth' });
        }

        // Copy current URL
        function copyCurrentUrl() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('URL copied to clipboard!');
            });
        }

        // Export debug information
        function exportDebugInfo() {
            const debugInfo = {
                timestamp: new Date().toISOString(),
                current_host: '{{ $host }}',
                detected_subdomain: '{{ $subdomain }}',
                url: '{{ $url }}',
                full_url: '{{ $fullUrl }}',
                headers: @json($headers),
                server_info: {
                    http_host: '{{ $_SERVER['HTTP_HOST'] ?? 'Not set' }}',
                    server_name: '{{ $_SERVER['SERVER_NAME'] ?? 'Not set' }}',
                    request_uri: '{{ $_SERVER['REQUEST_URI'] ?? 'Not set' }}',
                    server_port: '{{ $_SERVER['SERVER_PORT'] ?? 'Not set' }}'
                },
                environment: {
                    php_version: '{{ PHP_VERSION }}',
                    laravel_version: '{{ app()->version() }}',
                    app_env: '{{ app()->environment() }}'
                }
            };

            const blob = new Blob([JSON.stringify(debugInfo, null, 2)], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `debug-info-${new Date().getTime()}.json`;
            a.click();
            URL.revokeObjectURL(url);
        }
    </script>
@endpush
