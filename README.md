# SECURA - Risk Assessment System

## About
SECURA is a modern web-based risk assessment system built with Laravel and the Orchid Platform. It provides comprehensive tools for tracking, managing, and securing organizational assets.

## Features
- Risk assessment and asset management
- Search functionality with Laravel Scout
- File attachments support
- Asset valuation and threat assessment
- User management and access control
- Export capabilities (PDF)
- Modern UI with Livewire

## Tech Stack
- PHP 8.2+
- Laravel 11.x
- Orchid Platform 14.x
- Livewire 3.x
- Laravel Scout
- MySQL/PostgreSQL
- Tailwind CSS

## Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Web Server (Apache/Nginx)

## Installation
1. Clone the repository:
```bash
git clone [repository-url]
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

7. Build assets:
```bash
npm run build
```

8. Start the development server:
```bash
php artisan serve
```

## Key Components
- `app/Models/Management/AssetManagement.php`: Core asset management model
- `app/Orchid/Screens/Management/`: Asset management screens
- `app/Orchid/Presenters/`: Data presenters
- `app/Models/Assessment/`: Asset assessment models

## Features in Detail
1. **Asset Management**
   - Create, read, update, and delete assets
   - Track asset location, custodian, and ownership
   - Asset status monitoring
   - Quantity tracking

2. **Search & Filtering**
   - Full-text search using Laravel Scout
   - Advanced filtering options
   - Sortable columns

3. **File Management**
   - Attach documents to assets
   - Support for multiple file types
   - Secure file storage

4. **Export Options**
   - Excel export using Maatwebsite/Excel
   - PDF export using DomPDF
   - Customizable export formats

## Contributing
Please read our contributing guidelines before submitting pull requests.

## License
This project is licensed under the MIT License.