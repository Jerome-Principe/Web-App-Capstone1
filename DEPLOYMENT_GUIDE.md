# Deployment Guide for Hostinger

## Prerequisites

-   Node.js and npm installed locally
-   Composer installed locally
-   Access to your Hostinger hosting account

## Step 1: Build Assets Locally

Before uploading to Hostinger, you need to build the Vite assets:

```bash
# Install dependencies (if not already done)
npm install

# Build production assets
npm run build
```

This will create the `public/build` folder with the compiled assets.

## Step 2: Prepare Files for Upload

1. **Upload the entire project** to your Hostinger server
2. **Make sure to include the `public/build` folder** - this is crucial!

## Step 3: Server Configuration

### Set Environment Variables

Make sure your `.env` file on the server has:

```env
APP_ENV=production
APP_DEBUG=false
```

### Set Proper Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Run Laravel Commands

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Step 4: Alternative Solution (If Vite Still Fails)

If you continue to have issues with Vite, the application will automatically fall back to using Tailwind CSS CDN. The code has been updated to:

1. Check if the Vite manifest exists
2. Use Vite if available
3. Fall back to CDN if not available

## Troubleshooting

### Vite Manifest Not Found Error

-   **Solution 1**: Make sure you ran `npm run build` locally and uploaded the `public/build` folder
-   **Solution 2**: The application will automatically use CDN fallback

### 500 Server Error

-   Check your `.env` file configuration
-   Verify file permissions
-   Check Laravel logs in `storage/logs/laravel.log`

### Assets Not Loading

-   Clear browser cache
-   Check if the `public/build` folder exists on the server
-   Verify the manifest.json file is present

## File Structure After Deployment

Your server should have this structure:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── build/          # ← This folder is crucial!
│   │   ├── manifest.json
│   │   └── assets/
├── resources/
├── routes/
├── storage/
└── vendor/
```

## Notes

-   The application now automatically detects if Vite assets are available
-   If Vite assets are missing, it will use Tailwind CSS CDN as fallback
-   This ensures your application works both in development and production
-   No manual intervention required after deployment
