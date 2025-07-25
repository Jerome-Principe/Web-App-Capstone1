# 🚀 FITDROID Deployment Checklist

## ✅ Pre-Deployment (Local)

-   [x] **Assets Built**: `npm run build` completed successfully
-   [x] **Build Folder**: `public/build/` exists with manifest.json
-   [x] **Dependencies**: All Composer and npm dependencies installed
-   [x] **Testing**: Application works locally

## 📋 Hostinger Deployment Steps

### Step 1: Prepare Your Files

-   [ ] **Backup**: Create backup of your current project
-   [ ] **Compress**: Zip your entire project folder
-   [ ] **Verify**: Ensure `public/build/` folder is included

### Step 2: Hostinger Setup

-   [ ] **Login**: Access your Hostinger control panel
-   [ ] **Domain**: Point your domain to Hostinger (if not already done)
-   [ ] **Database**: Create MySQL database in Hostinger
    -   [ ] Note down: Database name, username, password, host
-   [ ] **File Manager**: Open File Manager or prepare FTP access

### Step 3: Upload Files

-   [ ] **Upload**: Upload your entire project to `public_html/` or root directory
-   [ ] **Extract**: If uploaded as zip, extract the files
-   [ ] **Verify**: Check that all folders are present (app, config, database, etc.)

### Step 4: Environment Configuration

-   [ ] **Create .env**: Copy `.env.example` to `.env` (if exists) or create new one
-   [ ] **Configure Database**:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=your-hostinger-db-host
    DB_PORT=3306
    DB_DATABASE=your-database-name
    DB_USERNAME=your-database-username
    DB_PASSWORD=your-database-password
    ```
-   [ ] **Configure App Settings**:
    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://yourdomain.com
    ```
-   [ ] **Configure Mail** (for notifications):
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=your-smtp-host
    MAIL_PORT=587
    MAIL_USERNAME=your-email
    MAIL_PASSWORD=your-password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=your-email
    MAIL_FROM_NAME="FITDROID"
    ```

### Step 5: Server Commands

Access Hostinger Terminal/SSH and run:

-   [ ] **Install Dependencies**:
    ```bash
    composer install --optimize-autoloader --no-dev
    ```
-   [ ] **Generate App Key**:
    ```bash
    php artisan key:generate
    ```
-   [ ] **Run Migrations**:
    ```bash
    php artisan migrate --force
    ```
-   [ ] **Cache Configuration**:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
-   [ ] **Set Permissions**:
    ```bash
    chmod -R 755 storage
    chmod -R 755 bootstrap/cache
    chmod 644 .env
    ```

### Step 6: Testing

-   [ ] **Visit Website**: Go to your domain
-   [ ] **Check Homepage**: Verify FITDROID loads correctly
-   [ ] **Test Login**: Try logging in with admin credentials
-   [ ] **Check Assets**: Verify CSS/JS loads properly
-   [ ] **Test Features**: Check if all features work

### Step 7: Post-Deployment

-   [ ] **SSL Certificate**: Enable SSL in Hostinger (if not automatic)
-   [ ] **Backup**: Create backup of deployed application
-   [ ] **Monitor**: Check logs in `storage/logs/laravel.log`
-   [ ] **Performance**: Test loading speed

## 🔧 Alternative: Railway Deployment

If you prefer Railway (easier deployment):

### Step 1: GitHub Setup

-   [ ] **Push to GitHub**: Upload your code to GitHub repository
-   [ ] **Verify**: Ensure all files are committed

### Step 2: Railway Setup

-   [ ] **Sign Up**: Create Railway account
-   [ ] **Connect GitHub**: Link your GitHub repository
-   [ ] **Create Project**: Create new project from GitHub repo
-   [ ] **Environment Variables**: Add all environment variables from above

### Step 3: Deploy

-   [ ] **Automatic Deploy**: Railway will automatically deploy
-   [ ] **Database**: Railway will provide database credentials
-   [ ] **Domain**: Railway provides free subdomain

## 🆘 Troubleshooting

### Common Issues:

**500 Server Error:**

-   [ ] Check `.env` file configuration
-   [ ] Verify file permissions
-   [ ] Check `storage/logs/laravel.log`

**Assets Not Loading:**

-   [ ] Ensure `public/build/` folder is uploaded
-   [ ] Clear browser cache
-   [ ] Check if manifest.json exists

**Database Connection:**

-   [ ] Verify database credentials in `.env`
-   [ ] Check if database exists
-   [ ] Ensure proper database permissions

**Permission Errors:**

-   [ ] Set proper file permissions (755 for dirs, 644 for files)
-   [ ] Ensure web server can write to `storage` and `bootstrap/cache`

## 📞 Support

If you encounter issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify your `.env` configuration
3. Contact your hosting provider
4. Check if all required PHP extensions are installed

## 🎉 Success!

Once deployed successfully:

-   Your FITDROID application will be live at your domain
-   All features should work as expected
-   Users can register, login, and use the fitness management system
-   Admin panel will be accessible for managing the application

**Congratulations! Your FITDROID application is now online! 🚀**
