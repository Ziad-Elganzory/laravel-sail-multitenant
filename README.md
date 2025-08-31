# 🐳 Laravel Sail Multi-Tenant Application

A cutting-edge multi-tenant Laravel application with containerized DNS resolution for seamless subdomain handling. This project demonstrates how to build a scalable multi-tenant architecture using the latest Laravel Sail, Docker, and custom DNS configuration with modern development tooling.

## ✨ Features

- **🏢 Multi-Tenant Architecture**: Automatic tenant detection via subdomains with real-time status display
- **🌐 Containerized DNS**: Custom DNSMasq server for wildcard subdomain resolution
- **🐳 Docker Environment**: Complete Docker setup with Laravel Sail
- **🧪 Interactive Testing Interface**: Comprehensive web interface for testing subdomain resolution with cURL examples
- **⚡ Modern Stack**: Laravel 12, PHP 8.4, MySQL 8.0, Redis, PHPMyAdmin
- **🎨 Tailwind CSS 4.0**: Beautiful, responsive UI with gradient designs
- **🔧 Advanced Development Tools**: Concurrent development workflow with Pail, Queue, and Vite

## 🏗️ Architecture

The application uses a sophisticated multi-tenant setup with enhanced development workflow:

- **🌐 DNS Service**: Custom DNSMasq container resolving `*.codezury.test` to the Laravel container
- **🖥️ Web Server**: Apache with wildcard virtual host configuration and custom server name
- **⚡ Laravel Application**: Automatic tenant detection with enhanced debugging interface
- **🗄️ Database**: MySQL 8.0 for data persistence with health checks
- **🚀 Cache**: Redis Alpine for session and cache management
- **🔧 Development Tools**: Integrated Pail logging, Queue processing, and Vite hot reload

### Network Configuration

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   DNS Server    │    │  Laravel App    │    │   MySQL DB      │    │   PHPMyAdmin    │
│  172.20.0.53    │    │  172.20.0.10    │    │                 │    │                 │
│   Port 5454     │────│    Port 80      │────│   Port 3306     │────│   Port 8080     │
└─────────────────┘    └─────────────────┘    └─────────────────┘    └─────────────────┘
                                   │
                       ┌─────────────────┐
                       │   Redis Cache   │
                       │                 │
                       │   Port 6379     │
                       └─────────────────┘
```

### Enhanced Testing Interface

The application includes a comprehensive testing dashboard that shows:
- 🏠 **Current Host & Tenant Detection**: Real-time subdomain identification
- 🎯 **Resolution Status**: Visual indicators for DNS resolution success
- 🧪 **Interactive cURL Examples**: Copy-paste ready commands for testing
- 📊 **Request Analytics**: Headers, server info, and environment details
- ⚡ **Quick Actions**: URL copying, debug export, and refresh utilities

## 🚀 Quick Start

### Prerequisites

- 🐳 Docker & Docker Compose
- 📦 Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd sail-mt
   ```

2. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

3. **Install dependencies**
   ```bash
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php84-composer:latest \
       composer install --ignore-platform-reqs
   ```

4. **Start the application with enhanced build**
   ```bash
   ./vendor/bin/sail up -d --build --force-recreate
   ```

5. **Generate application key and run migrations**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate
   ```

6. **Install and build frontend assets**
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

7. **🎯 Start enhanced development mode (Optional)**
   ```bash
   ./vendor/bin/sail composer dev
   ```
   This starts concurrent processes for:
   - 🖥️ Laravel server
   - 🔄 Queue worker
   - 📊 Pail logs
   - ⚡ Vite hot reload

### DNS Configuration (For Local Testing)

Add to your `/etc/hosts` file for testing:
```bash
127.0.0.1 codezury.test
127.0.0.1 tenant1.codezury.test
127.0.0.1 tenant2.codezury.test
127.0.0.1 demo.codezury.test
127.0.0.1 app.codezury.test
127.0.0.1 client1.codezury.test
```

## 🌐 Access Points & Testing

| URL | Description | Purpose |
|-----|-------------|---------|
| `http://codezury.test` | Main application dashboard | Multi-tenant testing interface |
| `http://tenant1.codezury.test` | Example tenant 1 | Test subdomain routing |
| `http://demo.codezury.test` | Demo tenant | Showcase multi-tenancy |
| `http://localhost:8080` | PHPMyAdmin interface | Database management |
| `http://localhost:5454` | DNS server port | DNS service status |

### 🧪 Testing Multi-Tenancy

#### Web Interface Features

Navigate to `http://codezury.test` to access the enhanced testing dashboard:

- **🎯 Tenant Detection**: Real-time subdomain identification with visual status
- **📊 Request Analytics**: Complete headers, server variables, and environment data
- **🧪 cURL Examples**: Ready-to-use commands for API testing
- **⚡ Quick Actions**: 
  - 🔄 Refresh page
  - 📋 Copy current URL
  - 💾 Export debug information
  - 🧪 Test different subdomains

#### API Endpoints

- **GET `/test`**: Interactive testing dashboard
- **GET `/info`**: JSON response with comprehensive tenant information
- **GET `/dns-test`**: DNS resolution test results with container networking info

#### Manual Testing Examples

```bash
# Test main domain
curl -H "Host: codezury.test" http://codezury.test/info

# Test tenant subdomains
curl -H "Host: tenant1.codezury.test" http://codezury.test/info
curl -H "Host: demo.codezury.test" http://codezury.test/info
curl -H "Host: app.codezury.test" http://codezury.test/info

# Test DNS resolution
curl http://codezury.test/dns-test
```

## 🛠️ Development

### Enhanced Development Workflow

The project includes an advanced concurrent development setup:

```bash
# Start enhanced development mode (recommended)
./vendor/bin/sail composer dev
```

This command simultaneously runs:
- 🖥️ **Laravel Server**: `php artisan serve`
- 🔄 **Queue Worker**: `php artisan queue:listen --tries=1`
- 📊 **Pail Logger**: `php artisan pail --timeout=0`
- ⚡ **Vite Dev Server**: `npm run dev`

### Available Commands

```bash
# Container Management
./vendor/bin/sail up -d                    # Start all services
./vendor/bin/sail up -d --build --force-recreate  # Rebuild and start
./vendor/bin/sail down                     # Stop all services
./vendor/bin/sail restart                  # Restart services

# Development
./vendor/bin/sail composer dev             # Enhanced development mode
./vendor/bin/sail artisan migrate         # Run migrations
./vendor/bin/sail artisan tinker          # Laravel tinker
./vendor/bin/sail artisan pail            # Real-time log viewer

# Testing & Quality
./vendor/bin/sail composer test           # Run tests with config clear
./vendor/bin/sail artisan test            # Run PHPUnit tests
./vendor/bin/sail composer pint           # Code formatting

# Frontend Assets
./vendor/bin/sail npm install            # Install dependencies
./vendor/bin/sail npm run dev            # Development build with watch
./vendor/bin/sail npm run build          # Production build

# Monitoring & Debugging
./vendor/bin/sail logs                   # View container logs
./vendor/bin/sail logs dns               # DNS container logs
./vendor/bin/sail logs laravel.test      # Application logs
```

### Project Structure

```
├── docker/                    # Custom Docker configurations
│   └── apache/               # Apache virtual host config
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── resources/
│   ├── css/                 # Tailwind CSS source
│   ├── js/                  # JavaScript assets
│   └── views/
│       ├── subdomain-test.blade.php  # Enhanced testing interface
│       └── welcome.blade.php         # Laravel welcome page
├── routes/
│   └── web.php              # Web routes with tenant logic
├── database/
│   ├── migrations/          # Database migrations
│   ├── factories/           # Model factories
│   └── seeders/            # Database seeders
├── docker-compose.yml       # Docker services configuration
├── package.json            # Frontend dependencies (Tailwind 4.0, Vite 7.0)
└── composer.json           # PHP dependencies (Laravel 12)
```

## 🔧 Configuration

### Advanced Docker Configuration

#### DNS Service Configuration
- **Image**: `andyshinn/dnsmasq:latest`
- **Function**: Resolves `*.codezury.test` to Laravel container IP
- **Network**: Custom bridge with static IP assignment
- **Fallback**: Google DNS (8.8.8.8) and Cloudflare (1.1.1.1)

#### Apache Configuration Enhancements
- **ServerName**: Dynamic based on `DOMAIN_NAME` environment variable
- **ServerAlias**: `*.codezury.test` for wildcard subdomain support
- **Modules**: `rewrite` and `headers` enabled
- **Logging**: Enhanced with hostname tracking for debugging

#### Container Networking
```yaml
networks:
  sail:
    driver: bridge
    ipam:
      config:
        - subnet: 172.20.0.0/16

# Static IP assignments:
# DNS Server: 172.20.0.53
# Laravel App: 172.20.0.10
```

## 🏢 Multi-Tenant Implementation

## 🏢 Multi-Tenant Implementation

### Enhanced Tenant Detection Logic

```php
// Extract subdomain from host with validation
if (str_contains($host, '.codezury.test')) {
    $parts = explode('.', $host);
    if (count($parts) >= 2 && $parts[0] !== 'codezury') {
        $subdomain = $parts[0]; // Tenant identifier
        
        // Additional tenant logic can be implemented here:
        // - Database connection switching
        // - Tenant-specific configuration loading
        // - Custom middleware execution
    }
}
```

### Real-time Testing Features

The enhanced testing interface provides:

```php
// Comprehensive tenant information
return [
    'host' => $request->getHost(),
    'subdomain' => $subdomain,
    'url' => $request->url(),
    'fullUrl' => $request->fullUrl(),
    'headers' => $request->headers->all(),
    'server_vars' => $_SERVER,
    'resolved_ip' => gethostbyname($host),
    'container_info' => [
        'server_addr' => $_SERVER['SERVER_ADDR'] ?? 'Unknown',
        'server_name' => $_SERVER['SERVER_NAME'] ?? 'Not set',
        'http_host' => $_SERVER['HTTP_HOST'] ?? 'Not set',
    ]
];
```

## 📝 Service Details

### 🌐 DNS Service
- **Image**: `andyshinn/dnsmasq:latest`
- **Function**: Resolves `*.codezury.test` to Laravel container (172.20.0.10)
- **Port**: 5454 (mapped to container port 53 TCP/UDP)
- **Fallback DNS**: Google (8.8.8.8) and Cloudflare (1.1.1.1)
- **Features**: Query logging enabled, supports wildcard resolution
- **Network**: Static IP 172.20.0.53 on custom bridge

### ⚡ Laravel Application
- **Base Image**: Laravel Sail PHP 8.4
- **Web Server**: Apache with mod_rewrite and headers
- **Port**: 80 (HTTP), 5173 (Vite HMR)
- **Network IP**: 172.20.0.10
- **Features**: XDebug support, custom virtual host, enhanced development tools
- **Environment**: Production-ready with development conveniences

### 🗄️ Database Services
- **MySQL**: `mysql/mysql-server:8.0` on port 3306
  - Health checks enabled
  - Custom database creation script
  - Performance optimized
- **PHPMyAdmin**: Web interface on port 8080
  - Pre-configured with database credentials
  - Full database management capabilities
- **Redis**: Alpine Redis for caching on port 6379
  - Health monitoring
  - Persistent storage volume

### 🔧 Development Services
- **Vite**: Hot Module Replacement on port 5173
- **Pail**: Real-time log streaming
- **Queue Worker**: Background job processing
- **Concurrent Mode**: All services running simultaneously

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Troubleshooting

### DNS Issues
```bash
# Check DNS container status
./vendor/bin/sail ps
./vendor/bin/sail logs dns

# Test DNS resolution manually
dig @127.0.0.1 -p 5454 tenant1.codezury.test
nslookup tenant1.codezury.test 127.0.0.1:5454

# Verify container networking
./vendor/bin/sail exec laravel.test ping 172.20.0.53
```

### Subdomain Not Working
```bash
# Verify Apache configuration
./vendor/bin/sail exec laravel.test cat /etc/apache2/sites-available/000-default.conf

# Check host resolution
./vendor/bin/sail exec laravel.test nslookup tenant1.codezury.test

# Test with cURL
curl -H "Host: tenant1.codezury.test" http://codezury.test/info
```

### Container Issues
```bash
# Force rebuild containers
./vendor/bin/sail down
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d --force-recreate

# Check resource usage
docker stats

# View all container logs
./vendor/bin/sail logs -f
```

### Development Mode Issues
```bash
# If concurrent dev mode fails
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

# Individual service testing
./vendor/bin/sail artisan serve
./vendor/bin/sail artisan queue:work
./vendor/bin/sail artisan pail
./vendor/bin/sail npm run dev
```

### Database Connection Issues
```bash
# Check MySQL status
./vendor/bin/sail mysql -e "SELECT 1"

# Verify environment variables
./vendor/bin/sail env | grep DB_

# Reset database
./vendor/bin/sail artisan migrate:fresh
```

### Performance Issues
```bash
# Clear all caches
./vendor/bin/sail artisan optimize:clear

# Monitor container performance
docker stats sail-mt-laravel.test-1

# Check disk usage
./vendor/bin/sail exec laravel.test df -h
```

---

## 🎯 Quick Reference

### Most Used Commands
```bash
# Start development
./vendor/bin/sail up -d --build --force-recreate
./vendor/bin/sail composer dev

# Stop everything
./vendor/bin/sail down

# View logs
./vendor/bin/sail logs -f

# Test subdomain
curl -H "Host: demo.codezury.test" http://codezury.test/info
```

### Key URLs
- 🏠 **Main App**: http://codezury.test
- 🗄️ **Database**: http://localhost:8080
- 🧪 **Testing Interface**: http://codezury.test/test 
- 🧪 **API Test**: http://codezury.test/info
- 🌐 **DNS Test**: http://codezury.test/dns-test

---

**Built with ❤️ using Laravel 12, Sail, and Docker** | **Powered by modern PHP 8.4 and cutting-edge development tools**
