# BivaCars Production Deploy Rehberi

## 1) Sunucu Hazırlığı

### AlmaLinux 9
```bash
sudo dnf update -y
sudo dnf install -y epel-release
sudo dnf install -y nginx git unzip curl
sudo dnf module reset php -y
sudo dnf module enable php:8.2 -y
sudo dnf install -y php php-fpm php-cli php-mysqlnd php-mbstring php-xml php-curl php-zip php-gd
sudo dnf install -y mysql-server
sudo systemctl enable --now nginx php-fpm mysqld
```

### Debian 12
```bash
sudo apt update
sudo apt install -y nginx git unzip curl ca-certificates
sudo apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd
sudo apt install -y mysql-server
sudo systemctl enable --now nginx php8.2-fpm mysql
```

## 2) Uygulama Deploy
```bash
git clone <repo-url> /var/www/bivacarss
cd /var/www/bivacarss
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm ci && npm run build
```

## 3) Node.js / npm
- Build için Node 20 LTS önerilir.
- CI/CD içinde `npm ci` kullanın.

## 4) Dosya İzinleri
```bash
sudo chown -R www-data:www-data /var/www/bivacarss
sudo find /var/www/bivacarss -type f -exec chmod 644 {} \;
sudo find /var/www/bivacarss -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/bivacarss/storage /var/www/bivacarss/bootstrap/cache
```

## 5) SSL (Let's Encrypt)
```bash
sudo apt install -y certbot python3-certbot-nginx   # Debian
sudo dnf install -y certbot python3-certbot-nginx   # AlmaLinux
sudo certbot --nginx -d bivacars.com -d www.bivacars.com
```
- Sertifika yenilemesini `systemctl list-timers | grep certbot` ile doğrulayın.

## 6) Önerilen Son Kontrol
```bash
php artisan optimize
php artisan queue:restart
sudo nginx -t && sudo systemctl reload nginx
```
