# SiPeka — Sistem Skrining Risiko Kecemasan Mahasiswa

![SiPeka Dashboard](public/images/logo_stikom.png)

SiPeka adalah aplikasi berbasis web untuk mendeteksi secara dini risiko kecemasan pada mahasiswa STIKOM Yos Sudarso Purwokerto. Sistem ini dikembangkan sebagai bagian dari proyek skripsi (tugas akhir), dengan menggabungkan instrumen psikologis klinis dan kecerdasan buatan.

Aplikasi ini menggunakan perpaduan **HARS (Hamilton Anxiety Rating Scale)** untuk pengukuran objektif dan **IndoBERT** (Natural Language Processing) untuk menganalisis emosi dari teks curhatan (naratif) berbahasa Indonesia.

---

## ✨ Fitur Utama

- **Autentikasi Terbatas (Google OAuth):** Login mahasiswa terintegrasi penuh dengan akun Google kampus (`@student.stikomyos.ac.id`), memastikan hanya mahasiswa aktif yang dapat mengakses sistem tanpa perlu mendaftar manual.
- **Analisis Emosi Berbasis AI:** Sistem memproses teks keluhan secara *real-time* ke server *inference* IndoBERT (dihosting terpisah di Azure) untuk mendeteksi emosi dominan (seperti *Fear*, *Anger*, *Sadness*).
- **Validasi Kuesioner Klinis (HARS):** 14 indikator kecemasan yang diadopsi dari standar internasional dan telah divalidasi oleh psikolog klinis.
- **Privasi & Keamanan Tingkat Tinggi:** Data naratif (curhatan) mahasiswa dienkripsi di *database* menggunakan algoritma **AES-256**. Data keluhan tidak dapat dibaca oleh Administrator maupun Psikolog; mereka hanya melihat metrik hasil.
- **Dashboard Multi-Role:** Memiliki antarmuka khusus yang aman dan terpisah untuk `Mahasiswa`, `Admin`, dan `Psikolog`.
- **Notifikasi Email Otomatis:** Sistem akan mengirimkan email (SMTP Gmail) otomatis kepada mahasiswa jika psikolog meninggalkan pesan peringatan atau mengatur jadwal konseling darurat.
- **Sistem *Cooldown*:** Untuk menjaga integritas data dan mencegah manipulasi hasil kuesioner, pengisian HARS dikunci dengan *cooldown* selama 14 hari.

---

## 🚀 Teknologi yang Digunakan

**Frontend:**
- Blade Templates
- Tailwind CSS v4 (menggunakan skrip *standalone* untuk stabilitas *runtime*)
- Alpine.js (reaktivitas antarmuka interaktif tanpa *framework* berat)

**Backend:**
- Laravel (PHP 8.3/8.4)
- SQLite/MySQL Database
- Integrasi API IndoBERT (Python/FastAPI Server)

**Infrastruktur & Cloud:**
- Docker Containerization (Multi-stage build)
- Azure Container Apps
- GitHub Actions (CI/CD)

---

## 🛠️ Panduan Instalasi Lokal

1. **Clone Repositori**
   ```bash
   git clone https://github.com/Ryonandha/skripsi-indobert-final.git
   cd skripsi-indobert-final/web
   ```

2. **Install Dependensi**
   ```bash
   composer install
   ```

3. **Konfigurasi Lingkungan (.env)**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Buka file `.env` dan lengkapi bagian berikut:*
   - `DB_CONNECTION=sqlite` (Atau sesuaikan jika memakai MySQL)
   - Konfigurasi **Google OAuth** (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`)
   - Konfigurasi **IndoBERT API** (`INDOBERT_API_URL`, `INDOBERT_TOKEN`)
   - Konfigurasi **SMTP Gmail** (`MAIL_USERNAME`, `MAIL_PASSWORD`)

4. **Migrasi Database & Seeding (Akun Admin)**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di: `http://localhost:8000`

---

## ☁️ Panduan Deploy (Production)

Proyek ini telah dikonfigurasi untuk *deployment* otomatis menggunakan **Docker** dan **Azure Container Apps**.

Untuk panduan lengkap (dari membuat *resource* Azure, mengatur rahasia, hingga *pipeline* GitHub Actions), silakan baca:
👉 [**Panduan Deploy Azure (CARA-DEPLOY-WEB-AZURE.md)**](./deploy/CARA-DEPLOY-WEB-AZURE.md)

---

## 🔐 Keamanan & Ketentuan

Aplikasi ini ditujukan murni sebagai alat bantu **skrining dini**, BUKAN sebagai diagnosis medis definitif.
Semua data terenkripsi. Email pada profil mahasiswa dikunci secara paksa (*hard-coded readonly* & validasi *backend*) sesuai kebijakan OAuth untuk mencegah penyamaran (*impersonation*) identitas akun.

---

*Dikembangkan untuk penelitian Skripsi — STIKOM Yos Sudarso Purwokerto (2026).*
