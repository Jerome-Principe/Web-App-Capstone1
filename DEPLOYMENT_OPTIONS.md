# Deployment Options for FITDROID Laravel Application

## 🚀 Quick Start - Choose Your Hosting Platform

### Option 1: Hostinger (Recommended - Shared Hosting)

**Best for:** Beginners, budget-friendly, easy setup
**Cost:** ~$2-5/month

**Steps:**

1. ✅ Assets already built (run `npm run build` locally)
2. Upload entire project to Hostinger via File Manager or FTP
3. Set up database in Hostinger control panel
4. Configure `.env` file with production settings
5. Run Laravel commands via SSH or Terminal

**Pros:** Easy setup, good support, affordable
**Cons:** Limited server control, slower performance

---

### Option 2: Railway (Recommended - Modern Platform)

**Best for:** Developers, automatic deployments, good performance
**Cost:** Free tier available, then ~$5-20/month

**Steps:**

1. Connect your GitHub repository to Railway
2. Railway automatically detects Laravel and sets up environment
3. Add environment variables in Railway dashboard
4. Deploy automatically on every push

**Pros:** Automatic deployments, good performance, easy scaling
**Cons:** Can be more expensive for high traffic

---

### Option 3: Vercel (Frontend + API)

**Best for:** Modern web apps, excellent performance
**Cost:** Free tier available, then pay-as-you-go

**Steps:**

1. Connect GitHub repository to Vercel
2. Configure build settings for Laravel
3. Set environment variables
4. Deploy automatically

**Pros:** Excellent performance, global CDN, automatic HTTPS
**Cons:** Requires some configuration for Laravel

---

### Option 4: DigitalOcean App Platform

**Best for:** Developers, good control, reasonable pricing
**Cost:** ~$5-25/month

**Steps:**

1. Connect GitHub repository
2. Choose Laravel as application type
3. Configure environment variables
4. Deploy with one click

**Pros:** Good performance, reasonable pricing, developer-friendly
**Cons:** Requires some technical knowledge

---

### Option 5: Heroku (Classic Choice)

**Best for:** Developers, extensive documentation
**Cost:** Free tier discontinued, now ~$7-25/month

**Steps:**

1. Install Heroku CLI
2. Create Heroku app
3. Add PostgreSQL add-on
4. Deploy via Git

**Pros:** Excellent documentation, many add-ons
**Cons:** No free tier anymore, can be expensive

---

## 🛠️ Pre-Deployment Checklist

### 1. Environment Configuration

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=base64:your-generated-key

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Build Assets (Already Done)

```bash
npm run build
```

### 3. Database Migration

```bash
php artisan migrate --force
```

### 4. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Set Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 🎯 Recommended Deployment Steps

### For Hostinger (Your Current Setup):

1. **Prepare Files:**

    - Ensure `public/build` folder exists (✅ Done)
    - Create `.env` file for production

2. **Upload to Hostinger:**

    - Use File Manager or FTP
    - Upload entire project to `public_html` or root directory

3. **Database Setup:**

    - Create MySQL database in Hostinger control panel
    - Update `.env` with database credentials

4. **Run Commands:**

    ```bash
    composer install --optimize-autoloader --no-dev
    php artisan key:generate
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

5. **Set Permissions:**
    ```bash
    chmod -R 755 storage
    chmod -R 755 bootstrap/cache
    ```

---

## 🔧 Troubleshooting Common Issues

### 500 Server Error

-   Check `.env` file configuration
-   Verify file permissions
-   Check Laravel logs in `storage/logs/laravel.log`

### Assets Not Loading

-   Ensure `public/build` folder is uploaded
-   Clear browser cache
-   Check if manifest.json exists

### Database Connection Issues

-   Verify database credentials in `.env`
-   Check if database exists and is accessible
-   Ensure proper database permissions

### Permission Denied Errors

-   Set proper file permissions (755 for directories, 644 for files)
-   Ensure web server can write to `storage` and `bootstrap/cache`

---

## 📊 Performance Optimization

### For Production:

1. **Enable OPcache** (if available)
2. **Use Redis** for caching (if available)
3. **Optimize images** and assets
4. **Enable compression** (gzip)
5. **Use CDN** for static assets

### Laravel Optimizations:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

---

## 🚀 Next Steps

1. **Choose your hosting platform** from the options above
2. **Follow the specific deployment guide** for your chosen platform
3. **Set up your domain** and SSL certificate
4. **Configure email** for notifications
5. **Set up monitoring** and backups

---

## 💡 Pro Tips

-   **Always backup** your database before deployment
-   **Test locally** with production settings first
-   **Use environment-specific** configurations
-   **Monitor your application** after deployment
-   **Set up automated backups** if possible

---

## 🆘 Need Help?

If you encounter issues during deployment:

1. Check the Laravel logs in `storage/logs/laravel.log`
2. Verify your `.env` configuration
3. Ensure all required PHP extensions are installed
4. Check file permissions
5. Consult your hosting provider's documentation

Your application is ready for deployment! Choose the option that best fits your needs and budget.
