# Deploy Web (Laravel/SiPeka) ke Azure Container Apps

Mengikuti pola yang sama dengan `deploy/CARA-DEPLOY-AZURE.md` (model IndoBERT):
satu resource group, satu ACR, satu Container Apps environment — web jadi
container app KEDUA di environment yang sama (`env-sipeka`, region `eastasia`).

Build image dilakukan di **GitHub Actions** (bukan `az acr build`), karena
ACR Tasks diblokir di langganan Azure for Students. Ini otomatis aman karena
build terjadi di runner GitHub, bukan di dalam Azure.

---

## 0. Prasyarat

- Resource group `rg-sipeka`, ACR `acrsipeka`, environment `env-sipeka` **sudah ada**
  (dibuat saat deploy model — lihat `deploy/CARA-DEPLOY-AZURE.md` di root proyek).
- **Azure Database for MySQL Flexible Server** — kalau belum ada, buat dulu
  (region `eastasia` juga, tier Burstable B1ms paling murah):

  ```bash
  az mysql flexible-server create \
    --resource-group rg-sipeka --name mysql-sipeka \
    --location eastasia --admin-user sipeka_admin \
    --admin-password "<PASSWORD_KUAT>" \
    --sku-name Standard_B1ms --tier Burstable \
    --storage-size 20 --version 8.0.21 \
    --public-access 0.0.0.0-255.255.255.255
  # (public-access di atas untuk demo/UAT; persempit ke IP Container Apps
  #  environment kalau mau lebih aman)

  az mysql flexible-server db create \
    --resource-group rg-sipeka --server-name mysql-sipeka --database-name sipeka
  ```

## 1. Buat Service Principal untuk GitHub Actions (SEKALI SAJA)

Scoped HANYA ke `rg-sipeka` (least privilege):

```bash
SUBSCRIPTION_ID=$(az account show --query id -o tsv)

az ad sp create-for-rbac --name "sp-github-sipeka-web" \
  --role Contributor \
  --scopes /subscriptions/$SUBSCRIPTION_ID/resourceGroups/rg-sipeka \
  --sdk-auth
```

Copy **seluruh output JSON**-nya, lalu simpan sebagai GitHub Secret:

`GitHub repo → Settings → Secrets and variables → Actions → New repository secret`
- Name: `AZURE_CREDENTIALS`
- Value: (paste JSON dari perintah di atas)

## 2. Buat Container App web (SEKALI SAJA, manual)

GitHub Actions (`deploy-web.yml`) hanya melakukan **update image** pada
container app yang sudah ada — pembuatan pertama tetap manual supaya semua
environment variable/secret bisa diisi dengan hati-hati.

```bash
ACRPASS=$(az acr credential show -n acrsipeka --query "passwords[0].value" -o tsv)

# Build & push image pertama secara manual (image awal sebelum CI aktif)
az acr login --name acrsipeka
docker build -t acrsipeka.azurecr.io/sipeka-web:v1 .
docker push acrsipeka.azurecr.io/sipeka-web:v1

az containerapp create \
  --name web-sipeka --resource-group rg-sipeka --environment env-sipeka \
  --image acrsipeka.azurecr.io/sipeka-web:v1 \
  --registry-server acrsipeka.azurecr.io --registry-username acrsipeka \
  --registry-password "$ACRPASS" \
  --target-port 8080 --ingress external \
  --min-replicas 0 --max-replicas 2 \
  --cpu 0.5 --memory 1.0Gi \
  --secrets \
      app-key="<HASIL php artisan key:generate --show>" \
      db-password="<PASSWORD_MYSQL>" \
      google-client-secret="<GOOGLE_CLIENT_SECRET>" \
      indobert-token="<TOKEN_API_MODEL>" \
      mail-password="<APP_PASSWORD_GMAIL_16_DIGIT>" \
  --env-vars \
      APP_NAME=SiPeka \
      APP_ENV=production \
      APP_DEBUG=false \
      APP_URL=https://web-sipeka.<random>.eastasia.azurecontainerapps.io \
      APP_KEY=secretref:app-key \
      LOG_CHANNEL=stderr \
      DB_CONNECTION=mysql \
      DB_HOST=mysql-sipeka.mysql.database.azure.com \
      DB_PORT=3306 \
      DB_DATABASE=sipeka \
      DB_USERNAME=sipeka_admin \
      DB_PASSWORD=secretref:db-password \
      CACHE_STORE=database \
      SESSION_DRIVER=database \
      QUEUE_CONNECTION=database \
      GOOGLE_CLIENT_ID="<GOOGLE_CLIENT_ID>" \
      GOOGLE_CLIENT_SECRET=secretref:google-client-secret \
      GOOGLE_REDIRECT_URI="https://web-sipeka.<random>.eastasia.azurecontainerapps.io/auth/google/callback" \
      GOOGLE_ALLOWED_DOMAIN=student.stikomyos.ac.id \
      INDOBERT_API_URL="https://api-indobert.<random>.eastasia.azurecontainerapps.io" \
      INDOBERT_TOKEN=secretref:indobert-token \
      SCREENING_RETENTION_MONTHS=6 \
      MAIL_MAILER=smtp \
      MAIL_HOST=smtp.gmail.com \
      MAIL_PORT=587 \
      MAIL_USERNAME="<EMAIL_GMAIL>" \
      MAIL_PASSWORD=secretref:mail-password \
      MAIL_ENCRYPTION=tls \
      MAIL_FROM_ADDRESS="<EMAIL_GMAIL>" \
      MAIL_FROM_NAME="Skrining Kecemasan STIKOM" \
  --query properties.configuration.ingress.fqdn -o tsv
```

> ⚠️ `APP_URL` & `GOOGLE_REDIRECT_URI` baru pasti setelah container app dibuat
> (Azure kasih tahu FQDN acak-nya). Alurnya: create dulu tanpa dua var itu →
> catat FQDN dari output → `az containerapp update` isi APP_URL/GOOGLE_REDIRECT_URI
> yang benar → update juga Authorized redirect URI di Google Cloud Console.

Setelah container app jadi, jalankan migrasi pertama kali (opsional — image
sudah otomatis migrate lewat `docker/entrypoint.sh` tiap kali container start):

```bash
az containerapp exec --name web-sipeka --resource-group rg-sipeka \
  --command "php artisan migrate --force"
```

## 3. Aktifkan CI/CD (GitHub Actions)

Setelah langkah 1–2 selesai, cukup **push ke branch `main`** — workflow
`.github/workflows/deploy-web.yml` otomatis build image baru & update
container app `web-sipeka` dengan revisi terbaru.

Cek progres di GitHub repo → tab **Actions**.

## 4. Uji

```bash
URL="https://web-sipeka.xxxx.eastasia.azurecontainerapps.io"
curl -I "$URL"   # harus 200/302, bukan 500
```

Kalau `min-replicas 0`, panggilan pertama akan cold-start (mirip API model).
Untuk demo sidang, hangatkan dulu beberapa menit sebelumnya.

## 5. Jaga biaya

- `web-sipeka` pakai `--cpu 0.5 --memory 1.0Gi` (lebih kecil dari API model
  yang butuh 1.0/2.0Gi untuk load model AI) — cukup untuk Laravel + Apache.
- MySQL Flexible Server Burstable B1ms ≈ $12–15/bulan (item baru, cek
  Cost Management → Budgets sesuai catatan di `deploy/CARA-DEPLOY-AZURE.md`).
- Matikan semua saat tidak dipakai:
  ```bash
  az containerapp delete --name web-sipeka --resource-group rg-sipeka -y
  az mysql flexible-server delete --name mysql-sipeka --resource-group rg-sipeka -y
  ```

## Langkah lanjutan (belum dikerjakan)

- **Retensi data otomatis** (`php artisan screenings:prune`): Azure Container
  Apps punya fitur **Scheduled Jobs** (cron) yang bisa langsung menjalankan
  command ini pakai image yang sama, tanpa perlu container web menyala terus.
  Ini rencana langkah berikutnya, belum dibuatkan di panduan ini.

---

## 6. Notifikasi Email (SMTP Gmail)

Notifikasi email dikirim otomatis ke mahasiswa saat:
1. Psikolog mengirim pesan/undangan konseling
2. Jadwal konseling baru dibuat

### Cara Mendapatkan App Password Gmail

1. Buka [myaccount.google.com/security](https://myaccount.google.com/security)
2. Aktifkan **2-Step Verification** (wajib)
3. Buka [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
4. Buat App Password baru → copy 16 digit password
5. Isi secret `mail-password` dengan password tersebut

### Update env vars email di Container App yang sudah berjalan

Kalau container app sudah ada dan ingin menambah/mengubah konfigurasi email:

```bash
az containerapp secret set \
  --name web-sipeka --resource-group rg-sipeka \
  --secrets mail-password="<APP_PASSWORD_GMAIL_16_DIGIT>"

az containerapp update \
  --name web-sipeka --resource-group rg-sipeka \
  --set-env-vars \
      MAIL_MAILER=smtp \
      MAIL_HOST=smtp.gmail.com \
      MAIL_PORT=587 \
      MAIL_USERNAME="<EMAIL_GMAIL>" \
      MAIL_PASSWORD=secretref:mail-password \
      MAIL_ENCRYPTION=tls \
      MAIL_FROM_ADDRESS="<EMAIL_GMAIL>" \
      MAIL_FROM_NAME="Skrining Kecemasan STIKOM"
```

> ⚠️ Gmail gratis memiliki batas **500 email/hari**. Untuk skripsi/demo,
> ini lebih dari cukup. Untuk skala production yang lebih besar, pertimbangkan
> SendGrid atau Mailgun (keduanya punya free tier).

---

## 7. Checklist Google OAuth untuk Production

Setelah container app jadi dan FQDN diketahui, update di **Google Cloud Console**:

1. **Authorized JavaScript Origins** — tambahkan:
   ```
   https://web-sipeka.<random>.eastasia.azurecontainerapps.io
   ```
   (dan/atau `https://student.stikomyos.ac.id` jika pakai custom domain)

2. **Authorized Redirect URIs** — tambahkan:
   ```
   https://web-sipeka.<random>.eastasia.azurecontainerapps.io/auth/google/callback
   ```
   (dan/atau `https://student.stikomyos.ac.id/auth/google/callback`)

3. **OAuth Consent Screen**:
   - Jika User type = **External** dan masih **Testing**: tambahkan test users
   - Untuk sidang/demo: pertimbangkan publish ke **In Production** agar semua
     mahasiswa bisa login tanpa harus didaftarkan satu per satu sebagai test user
