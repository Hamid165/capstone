# Dhawuh Bumi - E-Commerce Hidroponik

Project E-Commerce untuk penjualan sayuran hidroponik, dibangun menggunakan Framework **Laravel 12**, **Tailwind CSS**, dan Payment Gateway **Midtrans**.

## Prasyarat (Prerequisites)

Sebelum menginstal, pastikan komputer/server Anda sudah terinstall:

* **PHP** >= 8.2
* **Composer** (PHP Package Manager)
* **Node.js** & **NPM** (Untuk compile CSS/JS)
* **Database**: MySQL / MariaDB

## Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal (Localhost) atau Hosting.

### 1. Download / Clone Project

Download source code project ini dan ekstrak ke folder kerja Anda.

### 2. Install Dependencies

Buka terminal (Command Prompt/PowerShell) di dalam folder project, lalu jalankan perintah:

```bash
# Install Library PHP (Laravel)
composer install

# Install Library Javascript (Tailwind, dll)
npm install
```

### 3. Konfigurasi Environment (.env)

Copy file `.env.example` dan ubah namanya menjadi `.env`:

```bash
cp .env.example .env
```

Buka file `.env` di text editor, lalu sesuaikan konfigurasi berikut:

* **Database (Sesuaikan dengan DB Anda):**

  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=nama_database_anda
  DB_USERNAME=root
  DB_PASSWORD=
  ```
* **Midtrans (Payment Gateway):**

  ```env
  MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxx  (Isi dengan Server Key Anda)
  MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxx  (Isi dengan Client Key Anda)
  MIDTRANS_IS_PRODUCTION=false
  MIDTRANS_IS_SANITIZED=true
  MIDTRANS_IS_3DS=true
  ```

### 4. Generate App Key

Jalankan perintah ini untuk membuat kunci keamanan aplikasi:

```bash
php artisan key:generate
```

### 5. Setup Database

Pastikan Anda sudah membuat database kosong (sesuai nama di `.env`). Lalu jalankan migrasi untuk membuat tabel:

```bash
# Migrasi tabel + Isi data awal (User Admin, Kota, dll)
php artisan migrate:fresh --seed
```

> **Catatan:** Perintah `--seed` akan membuat akun Admin default:
>
> * **Email:** admin@dhawuhbumi.com
> * **Password:** password

### 6. Link Storage

Agar gambar produk bisa muncul, jalankan perintah:

```bash
php artisan storage:link
```

### 7. Compile Assets (CSS & JS)

Untuk tampilan yang rapi (Production Ready):

```bash
npm run build
```

### 8. Jalankan Server

Selesai! Sekarang jalankan server lokal:

```bash
php artisan serve
```

Buka browser dan akses: `http://localhost:8000`

---

## Deployment ke Hosting (cPanel)

1. Upload semua file ke File Manager.
2. Import database ke MySQL Database di cPanel.
3. Sesuaikan file `.env` dengan kredensial database hosting.
4. Pastikan folder `storage` dan `bootstrap/cache` memiliki permission 775/777.
5. Set Document Root domain Anda ke folder `/public`.
6. Pastikan symlink storage terhubung (bisa via terminal atau fitur cPanel : `ln -s ../storage/app/public public/storage`).
