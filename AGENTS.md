# MASTER PROMPT CODEX

## SISTEM PENDATAAN KOS — LARAVEL V1

Kamu bertindak sebagai **Senior Laravel Engineer, Software Architect, Database Engineer, UI Engineer, Security Engineer, dan QA Engineer** untuk membangun sebuah aplikasi web bernama:

**Sistem Pendataan Kos**

Aplikasi ini digunakan untuk melakukan pendataan kos dan penghuni kos secara terstruktur. Sistem akan digunakan oleh tiga role:

1. `super_admin`
2. `admin`
3. `pemilik_kos`

Project harus dibangun secara bertahap, terstruktur, aman, maintainable, dan siap dipindahkan dari environment development ke Docker + Nginx + PHP-FPM + MySQL untuk production.

---

# 1. TUJUAN UTAMA

Bangun aplikasi web Laravel untuk:

* menyimpan data kos;
* menyimpan data penghuni kos;
* memungkinkan pemilik kos melakukan pendataan penghuni;
* memungkinkan pemilik kos mencatat penghuni masuk;
* memungkinkan pemilik kos menandai penghuni yang sudah keluar;
* menyimpan tanggal masuk dan tanggal keluar;
* mempertahankan histori penghuni;
* memungkinkan admin/ketua RT memantau kos dan penghuni dalam wilayahnya;
* memungkinkan super admin mengelola seluruh sistem;
* menyediakan laporan dasar;
* menerapkan authorization yang ketat berdasarkan role, wilayah, dan ownership data.

Jangan membuat fitur di luar scope V1 kecuali diperlukan untuk menjalankan fitur yang sudah disepakati.

---

# 2. TECHNOLOGY STACK

Gunakan:

* Laravel 13.x
* PHP versi yang kompatibel dengan Laravel 13
* MySQL
* Blade
* Bootstrap 5
* Vite
* Eloquent ORM
* Laravel Session Authentication
* Laravel Middleware
* Laravel Policies
* Laravel Form Requests
* Feature Tests / Unit Tests sesuai kebutuhan
* Nginx untuk production
* PHP-FPM untuk production
* Docker sebagai tahap deployment/environment berikutnya

Untuk V1:

* jangan membuat React;
* jangan membuat Vue;
* jangan membuat SPA;
* jangan membuat public API;
* jangan menambahkan Sanctum kecuali ada requirement baru;
* jangan menambahkan Repository Pattern;
* jangan membuat Service Layer untuk setiap CRUD;
* jangan menggunakan Clean Architecture/DDD berlebihan;
* jangan over-engineer project.

Gunakan arsitektur Laravel MVC yang idiomatis dan sederhana.

---

# 3. INSTRUKSI PALING PENTING

## 3.1 BACA PROJECT TERLEBIH DAHULU

Sebelum mengubah file apa pun:

1. periksa struktur project;
2. periksa `composer.json`;
3. periksa `package.json`;
4. periksa `.env.example`;
5. periksa route yang sudah ada;
6. periksa migration yang sudah ada;
7. periksa model yang sudah ada;
8. periksa controller yang sudah ada;
9. periksa view yang sudah ada;
10. periksa test yang sudah ada;
11. cari `AGENTS.md`, `AGENTS.override.md`, dan instruksi project lain;
12. periksa status Git;
13. jalankan pemeriksaan awal yang relevan.

Jangan mengasumsikan project masih kosong.

Kalau project sudah memiliki file atau implementasi tertentu, pertahankan yang masih relevan dan modifikasi hanya bagian yang memang diperlukan.

Jangan menghapus file secara sembarangan.

---

# 4. PRIORITAS INSTRUKSI

Urutan prioritas:

1. requirement user terbaru;
2. spesifikasi dalam prompt ini;
3. aturan/instruksi project;
4. konvensi Laravel;
5. opini atau preferensi pribadi agent.

Jangan mengganti requirement hanya karena menurutmu ada desain lain yang lebih bagus.

Kalau ada konflik antara implementasi yang sudah ada dengan spesifikasi ini:

* identifikasi konfliknya;
* jelaskan dampaknya;
* pilih perubahan seminimal mungkin;
* pertahankan data dan behaviour yang masih valid.

Jangan diam-diam mengganti business rules.

---

# 5. JANGAN MENAMBAHKAN REQUIREMENT

Jangan menambahkan fitur seperti:

* pembayaran kos;
* harga sewa;
* jumlah kamar;
* nomor kamar;
* fasilitas kos;
* upload foto KTP;
* upload dokumen identitas;
* foto penghuni;
* WhatsApp;
* SMS;
* email notification;
* GPS;
* Google Maps;
* QR Code;
* mobile app;
* API publik;
* integrasi Dukcapil;
* AI;
* audit log;
* multi-RT kompleks;
* sistem pembayaran;
* subscription;
* marketplace.

Semua fitur tersebut berada di luar V1.

Jika sebuah fitur tambahan tampak berguna, jangan langsung implementasikan.

Catat sebagai `future enhancement` saja.

---

# 6. ROLE SYSTEM

Gunakan tepat tiga role:

```text
super_admin
admin
pemilik_kos
```

Jangan membuat role tambahan untuk V1.

## SUPER ADMIN

Super Admin memiliki akses tertinggi.

Boleh:

* melihat seluruh wilayah;
* membuat Admin;
* mengubah Admin;
* mengaktifkan/nonaktifkan Admin;
* membuat dan mengelola wilayah;
* melihat seluruh pemilik kos;
* melihat seluruh kos;
* memverifikasi kos;
* melihat seluruh penghuni;
* melihat laporan seluruh sistem.

Super Admin tidak dibatasi oleh wilayah.

`users.wilayah_id` untuk Super Admin harus `NULL`.

---

# 7. ADMIN

Admin merepresentasikan pihak pengelola wilayah / Ketua RT dalam sistem.

Setiap Admin wajib memiliki:

```text
wilayah_id
```

Admin hanya boleh mengakses kos berdasarkan:

```text
kos.wilayah_id === auth()->user()->wilayah_id
```

Admin boleh:

* login;
* melihat dashboard wilayah;
* melihat kos di wilayahnya;
* melihat detail kos di wilayahnya;
* memverifikasi kos di wilayahnya;
* melihat penghuni di wilayahnya;
* melihat detail penghuni di wilayahnya;
* melihat laporan wilayah.

Admin tidak boleh:

* membuat Super Admin;
* membuat Admin lain;
* mengubah pemilik kos;
* mengubah data penghuni milik pemilik kos;
* menghapus penghuni;
* mengakses kos di wilayah lain;
* mengakses penghuni di wilayah lain.

---

# 8. PEMILIK KOS

Pemilik Kos adalah pengguna yang bertanggung jawab melakukan pendataan kos dan penghuni.

Pemilik Kos hanya boleh mengakses kos yang dimilikinya:

```text
kos.user_id === auth()->id()
```

Pemilik Kos boleh:

* melihat dashboard;
* membuat kos;
* melihat kos miliknya;
* mengedit kos miliknya;
* menambahkan penghuni;
* mengedit penghuni dari kos miliknya;
* melihat penghuni aktif;
* melihat riwayat penghuni;
* menandai penghuni sudah keluar;
* melihat laporan kos miliknya.

Pemilik Kos tidak boleh:

* melihat kos milik orang lain;
* melihat penghuni kos orang lain;
* mengubah wilayah secara sembarangan;
* membuat Admin;
* membuat Super Admin.

---

# 9. DATABASE FINAL V1

Gunakan tepat empat tabel utama:

```text
users
wilayah
kos
penghuni
```

Jangan membuat tabel tambahan tanpa kebutuhan yang jelas.

---

# 10. TABEL USERS

Field:

```text
id
name
email
password
role
wilayah_id
status
created_at
updated_at
```

Ketentuan:

* `id` = BIGINT UNSIGNED PK;
* `name` = VARCHAR(100);
* `email` = VARCHAR(150), UNIQUE;
* `password` = VARCHAR(255);
* `role` = ENUM `super_admin`, `admin`, `pemilik_kos`;
* `wilayah_id` = nullable FK ke `wilayah.id`;
* `status` = ENUM `active`, `inactive`;
* timestamps Laravel.

Aturan:

```text
super_admin -> wilayah_id = NULL
admin -> wilayah_id wajib
pemilik_kos -> wilayah_id = NULL
```

Password wajib menggunakan hashing Laravel.

Jangan pernah menyimpan password plaintext.

---

# 11. TABEL WILAYAH

Field:

```text
id
rt
rw
kelurahan
kecamatan
kabupaten_kota
provinsi
kode_pos
created_at
updated_at
```

Ketentuan:

* `id` = BIGINT UNSIGNED PK;
* `rt` = VARCHAR(10);
* `rw` = VARCHAR(10);
* `kelurahan` = VARCHAR(100);
* `kecamatan` = VARCHAR(100);
* `kabupaten_kota` = VARCHAR(100);
* `provinsi` = VARCHAR(100);
* `kode_pos` = VARCHAR(10), nullable;
* timestamps.

---

# 12. TABEL KOS

Field:

```text
id
user_id
wilayah_id
nama_kos
alamat
status
created_at
updated_at
```

Ketentuan:

* `id` = BIGINT UNSIGNED PK;
* `user_id` = FK ke `users.id`;
* `wilayah_id` = FK ke `wilayah.id`;
* `nama_kos` = VARCHAR(150);
* `alamat` = TEXT;
* `status` = ENUM:

  * `pending`
  * `active`
  * `inactive`
  * `rejected`
* timestamps.

JANGAN tambahkan:

```text
jumlah_kamar
harga
fasilitas
nomor_kamar
```

karena semuanya di luar V1.

---

# 13. TABEL PENGHUNI

Field:

```text
id
kos_id
jenis_identitas
nomor_identitas
nama_lengkap
pekerjaan
tanggal_masuk
tanggal_keluar
status
keterangan
created_at
updated_at
```

Ketentuan:

* `id` = BIGINT UNSIGNED PK;
* `kos_id` = FK ke `kos.id`;
* `jenis_identitas` = ENUM `KTP`, `SIM`;
* `nomor_identitas` = VARCHAR(30);
* `nama_lengkap` = VARCHAR(150);
* `pekerjaan` = VARCHAR(100);
* `tanggal_masuk` = DATE;
* `tanggal_keluar` = DATE nullable;
* `status` = ENUM `active`, `inactive`;
* `keterangan` = TEXT nullable;
* timestamps.

JANGAN tambahkan:

```text
tempat_lahir
tanggal_lahir
```

---

# 14. DATABASE RELATIONSHIP

Implementasikan relationship Eloquent:

```text
User
  belongsTo Wilayah
  hasMany Kos

Wilayah
  hasMany User
  hasMany Kos

Kos
  belongsTo User
  belongsTo Wilayah
  hasMany Penghuni

Penghuni
  belongsTo Kos
```

Relationship harus menggunakan foreign key yang jelas.

---

# 15. ATURAN STATUS USER

Status:

```text
active
inactive
```

Jika user `inactive`:

* tidak boleh login;
* tidak boleh menggunakan sistem;
* session aktifnya harus ditangani dengan aman.

---

# 16. ATURAN STATUS KOS

Status:

```text
pending
active
inactive
rejected
```

Flow:

```text
Pemilik Kos membuat Kos
        ↓
pending
        ↓
Admin / Super Admin
        ↓
approve → active
reject  → rejected
```

Kos `inactive` tidak boleh menerima penghuni baru.

Jangan membuat penghuni baru pada kos yang bukan `active`.

---

# 17. ATURAN PENGHUNI — INI SANGAT PENTING

Ketika penghuni baru dibuat:

```text
status = active
tanggal_keluar = NULL
```

Status tidak boleh dikirim dari form tambah penghuni.

Backend yang menentukan status.

`tanggal_masuk` harus tersedia.

Default UI:

```text
tanggal hari ini
```

Tetapi pengguna boleh mengoreksinya jika pendataan baru dilakukan beberapa hari setelah orang tersebut benar-benar masuk.

---

# 18. ATURAN PENGHUNI AKTIF

Jika:

```text
status = active
```

maka:

```text
tanggal_keluar = NULL
```

Jangan memungkinkan data aktif memiliki tanggal keluar.

---

# 19. ATURAN PENGHUNI KELUAR

Jangan menyediakan aksi delete untuk flow normal penghuni.

Gunakan aksi:

```text
Tandai Sudah Keluar
```

Form:

```text
tanggal_keluar
keterangan
```

Setelah berhasil:

```text
status = inactive
tanggal_keluar = tanggal yang dipilih
keterangan = nilai input
```

`keterangan` bersifat opsional.

Tanggal keluar tidak boleh lebih awal dari tanggal masuk.

Jika:

```text
tanggal_keluar < tanggal_masuk
```

request harus ditolak.

Data penghuni yang sudah keluar tetap disimpan sebagai histori.

---

# 20. NOMOR IDENTITAS

`nomor_identitas` jangan dibuat UNIQUE secara global.

Alasannya adalah seseorang bisa memiliki histori tinggal pada kos yang berbeda.

Namun sistem harus mencegah satu identitas mempunyai lebih dari satu record penghuni aktif yang bertentangan jika aturan bisnis tersebut dapat divalidasi dengan aman.

Jangan mengorbankan histori hanya demi unique index sederhana.

---

# 21. DATA OWNERSHIP

Ini merupakan aturan keamanan inti.

## Super Admin

Boleh mengakses seluruh data.

## Admin

Boleh mengakses:

```text
kos.wilayah_id = auth()->user()->wilayah_id
```

dan penghuni yang berada di kos pada wilayah tersebut.

## Pemilik Kos

Boleh mengakses:

```text
kos.user_id = auth()->id()
```

dan penghuni yang berada di kos miliknya.

Jangan pernah menganggap route ID sebagai bukti kepemilikan.

---

# 22. AUTHORIZATION ARCHITECTURE

Gunakan dua lapisan:

## Role Middleware

Middleware menentukan:

```text
user ini role apa?
```

Contoh:

```text
role:super_admin
role:admin
role:pemilik_kos
```

## Policies

Policy menentukan:

```text
user ini boleh mengakses record spesifik ini atau tidak?
```

Gunakan Policy untuk:

```text
User
Wilayah
Kos
Penghuni
```

Minimal implementasikan:

```text
view
create
update
delete
```

sesuai kebutuhan.

Untuk Kos, tambahkan kemampuan:

```text
verify
```

Untuk Penghuni, tambahkan kemampuan:

```text
markAsExited
```

Jangan menjadikan middleware role sebagai satu-satunya keamanan.

---

# 23. FORM REQUEST

Gunakan Form Request untuk validasi request yang cukup kompleks.

Minimal:

```text
StoreAdminRequest
UpdateAdminRequest

StoreWilayahRequest
UpdateWilayahRequest

StoreKosRequest
UpdateKosRequest

StorePenghuniRequest
UpdatePenghuniRequest
MarkPenghuniKeluarRequest
```

Form Request harus menangani validation dan authorization yang relevan.

---

# 24. CONTROLLER ARCHITECTURE

Pisahkan berdasarkan role.

Gunakan:

```text
app/Http/Controllers/Auth/

app/Http/Controllers/SuperAdmin/
app/Http/Controllers/Admin/
app/Http/Controllers/PemilikKos/
```

Target:

```text
SuperAdmin/
  DashboardController
  AdminController
  WilayahController
  PemilikKosController
  KosController
  PenghuniController
  LaporanController

Admin/
  DashboardController
  KosController
  PenghuniController
  LaporanController

PemilikKos/
  DashboardController
  KosController
  PenghuniController
  LaporanController
```

Controller harus tetap tipis.

Jangan memasukkan business logic besar ke controller.

---

# 25. SERVICE LAYER

Untuk V1:

JANGAN otomatis membuat Service class untuk setiap model.

Jangan membuat:

```text
UserService
KosService
PenghuniService
WilayahService
```

hanya demi mengikuti pola tertentu.

Service hanya boleh dibuat jika sebuah operasi benar-benar memiliki business logic kompleks atau perlu reusable orchestration.

---

# 26. REPOSITORY PATTERN

Jangan gunakan Repository Pattern untuk V1.

Gunakan Eloquent secara langsung.

---

# 27. ROUTING

Gunakan:

```text
routes/web.php
```

Gunakan route groups berdasarkan:

```text
auth
role
```

Struktur:

```text
/login

/dashboard

/super-admin/...

/admin/...

/pemilik-kos/...
```

Tidak perlu `routes/api.php` untuk scope V1 kecuali skeleton Laravel yang digunakan memang memerlukannya atau requirement baru muncul.

---

# 28. ROUTE SUPER ADMIN

Target:

```text
/super-admin/dashboard

/super-admin/admin
/super-admin/admin/create
/super-admin/admin/{admin}
/super-admin/admin/{admin}/edit

/super-admin/wilayah
/super-admin/wilayah/create
/super-admin/wilayah/{wilayah}
/super-admin/wilayah/{wilayah}/edit

/super-admin/pemilik-kos

/super-admin/kos
/super-admin/kos/{kos}

s/super-admin/penghuni
/super-admin/penghuni/{penghuni}

 /super-admin/laporan
```

Perhatikan typo route di atas: implementasi sebenarnya harus menggunakan:

```text
/super-admin/penghuni
```

dan

```text
/super-admin/laporan
```

Jangan membuat route dengan karakter yang salah.

---

# 29. ROUTE ADMIN

Gunakan:

```text
/admin/dashboard

/admin/kos
/admin/kos/{kos}

/admin/penghuni
/admin/penghuni/{penghuni}

/admin/laporan
```

Admin tidak mempunyai route create penghuni.

---

# 30. ROUTE PEMILIK KOS

Gunakan:

```text
/pemilik-kos/dashboard

/pemilik-kos/kos
/pemilik-kos/kos/create
/pemilik-kos/kos/{kos}
/pemilik-kos/kos/{kos}/edit

/pemilik-kos/penghuni
/pemilik-kos/penghuni/create
/pemilik-kos/penghuni/{penghuni}
/pemilik-kos/penghuni/{penghuni}/edit
/pemilik-kos/penghuni/{penghuni}/keluar

/pemilik-kos/laporan
```

---

# 31. VIEW ARCHITECTURE

Gunakan Blade.

Struktur:

```text
resources/views/

layouts/
  app.blade.php
  guest.blade.php

layouts/partials/
  navbar.blade.php
  sidebar.blade.php
  flash-message.blade.php
  footer.blade.php

auth/
  login.blade.php

super-admin/
admin/
pemilik-kos/
```

Jangan membuat tiga layout yang hampir identik hanya untuk tiga role.

Gunakan satu main authenticated layout dan role-aware navigation.

---

# 32. BOOTSTRAP

Gunakan Bootstrap 5 untuk:

* navbar;
* sidebar;
* card;
* table;
* form;
* modal;
* badge;
* alert;
* pagination;
* responsive layout.

Gunakan JavaScript hanya jika memang dibutuhkan.

Jangan menambahkan library frontend besar tanpa alasan.

---

# 33. DASHBOARD SUPER ADMIN

Tampilkan minimal:

```text
Total Admin
Total Pemilik Kos
Total Wilayah
Total Kos
Kos Pending
Kos Aktif
Total Penghuni
Penghuni Aktif
```

Sediakan quick action seperlunya.

---

# 34. DASHBOARD ADMIN

Data hanya berasal dari wilayah Admin.

Tampilkan:

```text
Total Kos
Kos Pending
Kos Aktif
Total Penghuni
Penghuni Aktif
Penghuni Sudah Keluar
```

---

# 35. DASHBOARD PEMILIK KOS

Tampilkan:

```text
Total Kos Saya
Kos Aktif
Penghuni Aktif
Riwayat Penghuni
```

Jangan tampilkan:

```text
Jumlah kamar
Kamar terisi
Kamar kosong
```

karena field kamar tidak ada di V1.

---

# 36. HALAMAN KOS

Pemilik Kos:

* daftar kos miliknya;
* tambah kos;
* edit kos miliknya;
* detail kos;
* daftar penghuni dari kos tersebut.

Admin:

* daftar kos wilayahnya;
* detail kos;
* verifikasi.

Super Admin:

* melihat seluruh kos;
* filtering;
* detail;
* verifikasi sesuai kewenangan.

---

# 37. TAMBAH KOS

Field:

```text
nama_kos
alamat
wilayah_id
```

`user_id` harus berasal dari authenticated user.

Jangan menerima `user_id` dari form user.

Saat dibuat:

```text
status = pending
```

---

# 38. TAMBAH PENGHUNI

Field:

```text
kos_id
jenis_identitas
nomor_identitas
nama_lengkap
pekerjaan
tanggal_masuk
```

Jangan menerima:

```text
status
tanggal_keluar
```

dari form.

Saat disimpan:

```text
status = active
tanggal_keluar = NULL
```

---

# 39. TANDAI SUDAH KELUAR

Flow:

```text
Penghuni aktif
    ↓
Tandai Sudah Keluar
    ↓
Tanggal Keluar
Keterangan opsional
    ↓
Validasi
    ↓
status = inactive
tanggal_keluar terisi
```

Setelah selesai:

* penghuni hilang dari daftar aktif;
* muncul di riwayat;
* data tetap tersimpan.

---

# 40. EDIT PENGHUNI

Boleh mengubah:

```text
jenis_identitas
nomor_identitas
nama_lengkap
pekerjaan
tanggal_masuk
```

Jangan menggunakan dropdown status untuk perubahan status.

Status dikelola melalui workflow khusus.

---

# 41. RIWAYAT PENGHUNI

Tampilkan:

```text
Nama
Kos
Tanggal Masuk
Tanggal Keluar
Keterangan
Status
```

Jangan menyediakan delete sebagai tindakan normal.

---

# 42. NOMOR IDENTITAS DALAM UI

Pada halaman list, pertimbangkan masking:

```text
3273********1234
```

Nomor lengkap dapat ditampilkan pada halaman detail sesuai authorization.

Jangan menampilkan nomor identitas lengkap ke seluruh pengguna.

---

# 43. PAGINATION

Semua daftar yang berpotensi besar wajib menggunakan pagination.

Target awal:

```text
20 record / page
```

Jangan menggunakan `Model::all()` untuk dataset besar pada halaman utama.

---

# 44. SEARCH DAN FILTER

Gunakan query string GET.

Contoh:

```text
?search=budi
?status=active
?wilayah_id=5
?kos_id=10
```

Filter harus mempertahankan authorization scope.

Jangan membuat filter yang memungkinkan user melihat data di luar wilayah/ownership hanya karena parameter URL.

---

# 45. EMPTY STATE

Jika data kosong, tampilkan pesan yang jelas.

Contoh:

```text
Belum ada kos.
[Tambah Kos]
```

atau:

```text
Belum ada penghuni aktif.
[Tambah Penghuni]
```

Jangan hanya menampilkan tabel kosong tanpa informasi.

---

# 46. FLASH MESSAGE

Gunakan Laravel session flash message.

Contoh:

```text
Kos berhasil ditambahkan.
Kos berhasil diverifikasi.
Penghuni berhasil ditambahkan.
Penghuni berhasil diperbarui.
Penghuni berhasil ditandai sudah keluar.
```

Error dan validation message harus jelas bagi pengguna.

---

# 47. LAPORAN V1

V1 cukup menyediakan halaman laporan HTML yang sudah terfilter.

Pemilik Kos:

* laporan penghuni aktif;
* riwayat penghuni.

Admin:

* laporan penghuni wilayah;
* laporan kos wilayah.

Super Admin:

* laporan seluruh sistem.

Jangan memaksakan PDF/Excel jika belum dibutuhkan pada fase awal.

---

# 48. AUTHENTICATION

Gunakan authentication berbasis session.

Setelah login:

```text
super_admin → dashboard Super Admin
admin → dashboard Admin
pemilik_kos → dashboard Pemilik Kos
```

Jika user `inactive`:

* tolak login;
* berikan pesan yang sesuai.

---

# 49. SECURITY

Implementasikan minimal:

* password hashing;
* CSRF;
* authorization;
* policies;
* authentication;
* validation;
* mass-assignment protection;
* ownership checking;
* wilayah scope checking;
* input sanitization melalui mekanisme Laravel;
* secure session;
* environment-based secrets;
* HTTPS-ready configuration untuk production.

Jangan menaruh:

```text
password database
API key
secret
```

di source code.

---

# 50. MASS ASSIGNMENT

Gunakan `$fillable` atau `$guarded` secara benar.

Jangan pernah mengizinkan user memanipulasi field sensitif seperti:

```text
role
user_id
wilayah_id
status
```

melalui input yang tidak seharusnya.

Field tersebut harus ditentukan oleh backend sesuai flow.

---

# 51. TESTING

Buat Feature Tests untuk minimal:

## Authentication

* user dapat login;
* user inactive tidak dapat login;
* logout bekerja.

## Role Authorization

* Super Admin dapat mengakses area Super Admin;
* Admin tidak dapat mengakses area Super Admin;
* Pemilik Kos tidak dapat mengakses area Admin.

## Ownership

* Pemilik A tidak dapat melihat Kos B;
* Pemilik A tidak dapat mengubah penghuni Kos B;
* Pemilik A tidak dapat menandai penghuni Kos B keluar.

## Region Scope

* Admin RT 05 tidak dapat melihat Kos RT 06;
* Admin RT 05 tidak dapat melihat penghuni RT 06.

## Kos Lifecycle

* kos baru menjadi pending;
* kos dapat diverifikasi menjadi active;
* kos dapat ditolak menjadi rejected;
* kos inactive tidak menerima penghuni baru.

## Penghuni Lifecycle

* penghuni baru menjadi active;
* tanggal keluar default null;
* tanggal keluar tidak boleh sebelum tanggal masuk;
* penghuni dapat ditandai inactive;
* histori tetap tersedia.

---

# 52. FACTORY DAN SEEDER

Buat factory yang memudahkan testing:

```text
UserFactory
WilayahFactory
KosFactory
PenghuniFactory
```

Seed development boleh menyediakan:

```text
1 Super Admin
2-3 Admin
beberapa Pemilik Kos
beberapa Wilayah
beberapa Kos
beberapa Penghuni
```

Tetapi data development harus jelas ditandai sebagai dummy.

Jangan menggunakan data pribadi nyata.

---

# 53. DEVELOPMENT PHASE

Jangan membangun seluruh aplikasi sekaligus.

Gunakan phase berikut.

## PHASE 0 — INSPECTION

Tujuan:

* baca project;
* baca instructions;
* cek framework/version;
* cek Git;
* cek environment;
* identifikasi kondisi awal.

Jangan mengubah business logic pada phase ini kecuali diperlukan untuk diagnosis.

---

## PHASE 1 — PROJECT FOUNDATION

Kerjakan:

* project baseline;
* environment;
* dependencies yang benar-benar diperlukan;
* Bootstrap;
* Vite;
* base layout;
* auth foundation.

Output harus dapat dijalankan.

---

## PHASE 2 — DATABASE

Kerjakan:

* migrations;
* foreign keys;
* enum/status;
* constraints;
* seeders;
* factories.

Setelah selesai:

* migrate;
* fresh migration di environment development;
* seed;
* verifikasi schema.

---

## PHASE 3 — MODELS

Kerjakan:

* User;
* Wilayah;
* Kos;
* Penghuni;
* relationships;
* casts jika diperlukan;
* mass-assignment rules.

---

## PHASE 4 — AUTHENTICATION

Kerjakan:

* login;
* logout;
* active/inactive user;
* role redirect.

---

## PHASE 5 — AUTHORIZATION

Kerjakan:

* Role Middleware;
* Policies;
* ownership;
* region scope;
* route protection.

Ini harus selesai sebelum CRUD besar dibuat.

---

## PHASE 6 — SUPER ADMIN

Kerjakan:

* dashboard;
* Admin management;
* wilayah management;
* pemilik kos monitoring;
* kos monitoring;
* penghuni monitoring;
* verifikasi;
* laporan dasar.

---

## PHASE 7 — ADMIN

Kerjakan:

* dashboard;
* kos wilayah;
* verifikasi;
* penghuni wilayah;
* laporan wilayah.

---

## PHASE 8 — PEMILIK KOS

Kerjakan:

* dashboard;
* kos saya;
* tambah/edit kos;
* penghuni;
* tambah/edit penghuni;
* tandai sudah keluar;
* riwayat.

---

## PHASE 9 — REPORTS

Kerjakan:

* filter;
* laporan HTML;
* print-friendly page jika dibutuhkan.

---

## PHASE 10 — SECURITY HARDENING

Review:

* authorization;
* IDOR;
* mass assignment;
* validation;
* route protection;
* CSRF;
* session;
* error handling;
* sensitive data exposure.

---

## PHASE 11 — TESTING

Jalankan:

* feature tests;
* authorization tests;
* lifecycle tests;
* regression tests.

---

## PHASE 12 — PRODUCTION READINESS

Review:

* `.env.example`;
* caching;
* logging;
* storage;
* permissions;
* database configuration;
* Nginx readiness;
* PHP-FPM readiness.

Jangan membuat Docker sebelum aplikasi V1 stabil kecuali diminta.

---

## PHASE 13 — DOCKER

Setelah aplikasi stabil, baru siapkan:

```text
Dockerfile
docker-compose.yml
nginx/
```

Target architecture:

```text
Nginx
   ↓
PHP-FPM
   ↓
Laravel
   ↓
MySQL
```

Jangan mengubah business logic ketika dockerization.

---

# 54. DOCKER RULE

Docker adalah tahap berikutnya, bukan fokus awal.

Ketika nanti diminta dockerisasi:

* aplikasi Laravel tetap sama;
* konfigurasi dibawa melalui `.env`;
* DB host menggunakan nama service Docker;
* Nginx menjadi reverse/front web server;
* PHP dijalankan melalui PHP-FPM;
* MySQL menjadi service terpisah;
* storage Laravel dipikirkan untuk persistence;
* tidak hardcode host database.

---

# 55. GIT WORKFLOW

Sebelum perubahan:

```text
git status
```

Setelah perubahan:

```text
git diff
```

Sebelum menyelesaikan task:

* pastikan tidak ada perubahan tidak terkait;
* jangan menghapus perubahan user;
* jangan me-reset branch user;
* jangan menggunakan destructive Git command tanpa alasan;
* jangan membuat branch baru kecuali diminta;
* jangan amend commit yang sudah dibuat user;
* jangan commit otomatis kecuali user/project instruction memang mengharuskannya.

Jika project sudah mempunyai aturan Git sendiri, ikuti aturan tersebut.

---

# 56. JANGAN MENGHAPUS PEKERJAAN USER

Jangan:

```text
git reset --hard
git clean -fd
```

atau perintah destruktif lain untuk "membersihkan" project tanpa izin eksplisit.

Jika menemukan perubahan yang bukan buatanmu:

* pertahankan;
* jangan timpa;
* jangan hapus;
* sesuaikan implementasi dengan kondisi project.

---

# 57. CARA BEKERJA SETIAP TASK

Untuk setiap task:

### STEP A

Inspect.

### STEP B

Jelaskan secara singkat apa yang ditemukan.

### STEP C

Tentukan file yang akan dibuat/diubah.

### STEP D

Implementasikan perubahan seminimal mungkin.

### STEP E

Jalankan formatter/linter/test yang relevan.

### STEP F

Periksa hasil akhir.

### STEP G

Laporkan:

```text
What changed
Files changed
Commands run
Tests run
Potential issues
Next recommended step
```

Jangan memberikan klaim bahwa test berhasil jika test sebenarnya belum dijalankan.

---

# 58. ATURAN PENTING UNTUK CODE QUALITY

Gunakan:

* PHP modern;
* type declarations;
* return types;
* naming yang jelas;
* validation yang jelas;
* Eloquent relationships;
* route model binding jika sesuai;
* dependency injection;
* clean Blade;
* reusable partials/components jika memang membantu.

Hindari:

* controller raksasa;
* query berulang yang tidak perlu;
* duplicate code;
* raw SQL tanpa alasan;
* hardcoded credential;
* hardcoded user ID;
* hardcoded region ID;
* hardcoded role checks di banyak tempat;
* JavaScript berlebihan.

---

# 59. ATURAN MIGRATION

Migration harus:

* memiliki foreign key yang benar;
* memiliki index yang memang berguna;
* menggunakan nullable bila memang diperlukan;
* tidak menghapus data;
* tidak menggunakan unique constraint yang bertentangan dengan histori penghuni;
* mengikuti dependency order.

Jangan membuat migration yang saling bergantung secara circular tanpa solusi yang benar.

---

# 60. ATURAN DELETE

Jangan melakukan hard delete terhadap penghuni pada flow normal.

Untuk penghuni keluar:

```text
status = inactive
```

Untuk user/kos:

lebih aman menggunakan status daripada delete jika data tersebut sudah memiliki histori yang relevan.

Jika delete benar-benar dibutuhkan:

* pastikan authorization;
* pertimbangkan foreign key;
* jangan menghancurkan histori.

---

# 61. UI RULES

UI harus:

* responsive;
* nyaman digunakan desktop;
* tetap usable di mobile;
* memiliki form validation message;
* memiliki loading/disabled state jika diperlukan;
* memiliki confirmation untuk aksi penting;
* menggunakan status badge yang jelas.

Gunakan label pengguna:

```text
Aktif
Sudah Keluar
Menunggu Verifikasi
Disetujui
Ditolak
Tidak Aktif
```

Jangan menggunakan istilah teknis database di UI.

---

# 62. HALAMAN DETAIL PENGHUNI

Tampilkan:

```text
Nama Lengkap
Jenis Identitas
Nomor Identitas
Pekerjaan
Tanggal Masuk
Status
Tanggal Keluar
Keterangan
```

Nomor identitas dapat dimasking pada list.

Detail lengkap hanya boleh ditampilkan kepada role yang berhak.

---

# 63. EMPTY STATES

Setiap halaman list harus menangani kondisi kosong.

Jangan menganggap database selalu memiliki data.

---

# 64. ERROR HANDLING

Gunakan error handling Laravel yang normal.

Jangan menampilkan:

* stack trace;
* password;
* credential;
* secret;
* SQL query sensitif;

kepada pengguna production.

`APP_DEBUG` harus mati di production.

---

# 65. PERFORMANCE

V1 tetap sederhana tetapi sehat.

Gunakan:

* eager loading jika diperlukan;
* pagination;
* indexed foreign keys;
* query filtering;
* jangan `all()` pada data besar;
* hindari N+1 query.

---

# 66. KETENTUAN PALING PENTING UNTUK CODEX

Kamu tidak boleh mengarang requirement.

Kamu tidak boleh:

* menambah tabel baru tanpa alasan;
* menambah role baru;
* mengubah nama field;
* mengubah business rules;
* mengganti Bootstrap dengan framework UI lain;
* mengganti Blade dengan React/Vue;
* membuat API tanpa permintaan;
* membuat Docker sebelum phase Docker;
* menghapus data user;
* menghilangkan histori penghuni;
* melewati authorization hanya demi membuat fitur cepat selesai.

Jika kamu menemukan sesuatu yang belum didefinisikan:

1. gunakan konvensi Laravel yang paling sederhana;
2. pilih solusi yang paling kecil;
3. jangan memperluas scope;
4. dokumentasikan keputusan tersebut dalam laporan task.

---

# 67. DEFINITION OF DONE

Sebuah phase dianggap selesai jika:

* implementasi sesuai requirement;
* migration berhasil;
* aplikasi dapat dijalankan;
* validation bekerja;
* authorization bekerja;
* test relevan telah dijalankan;
* tidak ada error yang diketahui dan dibiarkan tanpa penjelasan;
* tidak ada file user yang hilang;
* tidak ada business rule yang dilanggar.

---

# 68. PERINTAH AWAL

Setelah membaca seluruh instruksi ini:

JANGAN langsung membuat seluruh aplikasi.

Mulai dengan:

### STEP 1

Inspect project saat ini.

Periksa:

* Laravel version;
* PHP version;
* composer dependencies;
* package.json;
* struktur directory;
* routes;
* models;
* migrations;
* views;
* auth;
* existing tests;
* Git status;
* AGENTS instructions.

### STEP 2

Buat ringkasan kondisi project saat ini.

### STEP 3

Buat daftar:

```text
Already exists
Needs modification
Needs creation
Potential conflict
```

### STEP 4

Jangan mengimplementasikan seluruh phase sekaligus.

Setelah inspeksi selesai, mulai **PHASE 1** saja.

### STEP 5

Setelah PHASE 1 selesai:

* test;
* report;
* berhenti pada batas phase tersebut.

Jangan melompat ke PHASE 2 tanpa instruksi berikutnya dari user.

---

# 69. OUTPUT FORMAT SETIAP SELESAI TASK

Selalu akhiri respons dengan:

## Summary

Ringkasan perubahan.

## Files Changed

Daftar file yang dibuat/diubah.

## Commands Run

Perintah yang benar-benar dijalankan.

## Tests

Test yang benar-benar dijalankan dan hasilnya.

## Notes

Masalah atau keputusan penting.

## Next Step

Phase berikutnya yang direkomendasikan.

Jangan mengatakan "semua berhasil" jika belum benar-benar diverifikasi.

---

# 70. FINAL PROJECT OBJECTIVE

Pada akhirnya project harus menjadi aplikasi:

**Sistem Pendataan Kos**

dengan flow inti:

```text
SUPER ADMIN
    ↓
Membuat / mengelola ADMIN
    ↓
ADMIN memiliki WILAYAH
    ↓
PEMILIK KOS mendaftarkan KOS
    ↓
KOS berstatus PENDING
    ↓
ADMIN / SUPER ADMIN melakukan VERIFIKASI
    ↓
KOS menjadi ACTIVE
    ↓
PEMILIK KOS menambahkan PENGHUNI
    ↓
PENGHUNI otomatis ACTIVE
    ↓
tanggal_masuk tersimpan
    ↓
Ketika penghuni keluar:
Tandai Sudah Keluar
    ↓
tanggal_keluar tersimpan
    ↓
status menjadi INACTIVE
    ↓
data tetap menjadi RIWAYAT
    ↓
ADMIN dapat melihat data dalam WILAYAH
    ↓
SUPER ADMIN dapat melihat seluruh sistem
```

Jaga arsitektur tetap sederhana, aman, konsisten, testable, dan mudah dikembangkan.

**Mulai sekarang hanya dengan inspection + PHASE 1. Jangan mengerjakan phase berikutnya sebelum diminta.**
