# N1g3 EV Trader - Auto Trader Alternative

A dealer-first marketplace platform built with Laravel 12, Vue 3, and TypeScript.

## 🚀 Quick Setup

### Prerequisites
- PHP 8.4+
- MySQL 8.0+
- Node.js 18+
- Composer
- npm

### Installation

1. **Install dependencies**
```bash
composer install
npm install
```

2. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Update .env with your database credentials**
```env
DB_CONNECTION=mysql
DB_DATABASE=n1g3_ev_trader
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Create database and seed**
```bash
mysql -u root -p -e "CREATE DATABASE n1g3_ev_trader CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate --seed
```

5. **Build and run**
```bash
npm run build
php artisan serve
```

6. **Visit http://localhost:8000**

---

## 👥 Test Accounts

### Platform Admin
- Email: `admin@n1g3evtrader.com` / Password: `password`

### Dealers
- **Premium Motors**: `james@premiummotors.co.uk` / `password` (Phone & Email only)
- **Manchester Motor Group**: `sarah@mmgcars.co.uk` / `password` (All features enabled)
- **Edinburgh Elite**: `andrew@eliteautos.scot` / `password` (Email & Test Drive)
- **Birmingham Budget**: `david@bbmotors.co.uk` / `password` (Email only)

---

## 📊 Sample Data Included

- 4 Dealers with different buyer journey configs
- 8 Vehicles (BMW, Mercedes, Audi, Porsche, Range Rover, Ford, etc.)
- 15-24 Leads in various states
- Active subscriptions (Starter/Pro/Enterprise plans)

---

## 🎯 Key Feature: Custom Buyer Journeys

Each dealer configures their own buyer journey:
- Choose contact methods (phone, email, test drive, reservation)
- Set primary CTA
- Configure reservation deposits
- WhatsApp integration
- Response time commitments

**This is our killer differentiator vs Auto Trader!**

---

## 🔧 Development

```bash
# Backend
php artisan serve
php artisan migrate:fresh --seed  # Reset with fresh data
vendor/bin/pint                    # Format code

# Frontend
npm run dev    # Hot reload
npm run build  # Production build
```

---

## 🔒 Security

**Change all passwords before production!** Current passwords are `password` for demo.

