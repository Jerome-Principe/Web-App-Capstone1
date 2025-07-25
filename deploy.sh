#!/bin/bash

# FITDROID Laravel Deployment Script for Hostinger
# Run this script after uploading files to your server

echo "🚀 Starting FITDROID Laravel Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "Laravel artisan file not found. Please run this script from your Laravel project root."
    exit 1
fi

print_status "Laravel project detected. Starting deployment process..."

# Step 1: Install Composer dependencies
print_status "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

if [ $? -eq 0 ]; then
    print_status "Composer dependencies installed successfully!"
else
    print_error "Failed to install Composer dependencies."
    exit 1
fi

# Step 2: Generate application key if not exists
if [ ! -f ".env" ]; then
    print_warning ".env file not found. Please create it first."
    exit 1
fi

if ! grep -q "APP_KEY=base64:" .env; then
    print_status "Generating application key..."
    php artisan key:generate --force
else
    print_status "Application key already exists."
fi

# Step 3: Run database migrations
print_status "Running database migrations..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    print_status "Database migrations completed successfully!"
else
    print_error "Failed to run database migrations. Please check your database configuration."
    exit 1
fi

# Step 4: Clear and cache configurations
print_status "Caching configurations..."
php artisan config:clear
php artisan config:cache

print_status "Caching routes..."
php artisan route:clear
php artisan route:cache

print_status "Caching views..."
php artisan view:clear
php artisan view:cache

# Step 5: Set proper permissions
print_status "Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env

# Step 6: Clear application cache
print_status "Clearing application cache..."
php artisan cache:clear

# Step 7: Optimize for production
print_status "Optimizing for production..."
php artisan optimize

# Step 8: Check if build assets exist
if [ -d "public/build" ]; then
    print_status "Build assets found in public/build/"
else
    print_warning "Build assets not found. Please run 'npm run build' locally and upload the public/build folder."
fi

# Step 9: Final checks
print_status "Performing final checks..."

# Check if storage is writable
if [ -w "storage" ]; then
    print_status "Storage directory is writable ✓"
else
    print_error "Storage directory is not writable!"
fi

# Check if bootstrap/cache is writable
if [ -w "bootstrap/cache" ]; then
    print_status "Bootstrap cache directory is writable ✓"
else
    print_error "Bootstrap cache directory is not writable!"
fi

# Check if .env exists and is readable
if [ -r ".env" ]; then
    print_status ".env file is readable ✓"
else
    print_error ".env file is not readable!"
fi

echo ""
echo "🎉 Deployment completed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Test your application by visiting your domain"
echo "2. Check if all features are working properly"
echo "3. Monitor the logs in storage/logs/laravel.log"
echo "4. Set up SSL certificate if not already done"
echo "5. Configure your domain DNS settings"
echo ""
echo "🔧 If you encounter issues:"
echo "- Check storage/logs/laravel.log for error messages"
echo "- Verify your .env configuration"
echo "- Ensure all required PHP extensions are installed"
echo "- Contact your hosting provider for support"
echo ""
echo "🚀 Your FITDROID application should now be live!" 