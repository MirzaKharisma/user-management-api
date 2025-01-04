<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# User Management API

API ini dibuat menggunakan teknologi Laravel 8.x dengan database MySQL. Endpoint yang tersedia digunakan untuk melakukan operasi CRUD (Create, Read, Update, Delete) pada tabel `users`.

## Daftar Endpoint

### 1. Mendapatkan Daftar User
**Endpoint:** `/api/v1/users`

**Method:** `GET`

**Deskripsi:** Mendapatkan daftar semua user yang tersimpan di database. Pada endpoint ini, user bisa menyaring user yang ingin dicari menggunakan parameter name, email, phone_number, active_status, dan department.

---

### 2. Menambahkan User Baru
**Endpoint:** `/api/v1/users`

**Method:** `POST`

**Deskripsi:** Menambahkan user baru ke database. Data yang harus dimasukkan pada endpoint ini antara lain name, email, phone_number, active_status, dan department. Endpoint ini juga memiliki validasi pada kolom email yang harus memasukkan format email dan email harus unique, dan phone_number yang harus berupa angka dengan digit 10 sampai 15.

---

### 3. Mendapatkan Detail User
**Endpoint:** `/api/v1/users/{id}`

**Method:** `GET`

**Deskripsi:** Mendapatkan detail user berdasarkan ID. Jika ID yang dicari tidak ada, maka akan memunculkan error 404 not found, yang menunjukkan bahwa data yang dicari tidak ada.

---

### 4. Memperbarui Data User
**Endpoint:** `/api/v1/users`

**Method:** `PUT`

**Deskripsi:** Memperbarui data user berdasarkan ID. Data yang harus dimasukkan pada endpoint ini antara lain name, email, phone_number, active_status, dan department. Endpoint ini juga memiliki validasi pada kolom email yang harus memasukkan email dan phone_number yang harus berupa angka dengan digit 10 sampai 15. Yang menjadi pembeda dengan create adalah terletak pada validasi email yang tidak harus unique agar orang yang berniat tidak mengubah email tidak kesulitan dan harus ada ID pada body json.

---

### 5. Menghapus User
**Endpoint:** `/api/v1/users/{id}`

**Method:** `DELETE`

**Deskripsi:** Menghapus user berdasarkan ID, dimana jika berhasil akan memunculkan response status success dan massage user deleted successfully. Fitur ini menerapkan softdelete, dimana fitur ini memungkinkan untuk menghapus data pada API, namun tidak menghapus data pada database, sehingga data yang terhapus melalui API ini dapat dikembalikan jika diperlukan. Jika id tidak ditemukan, maka akan menghasilkan response berupa status failed, dan message User not found.

---

## Catatan Tambahan
- Endpoint yang dibuat tidak ada otentikasi, sehingga bisa langsung digunakan.
- Validasi data harus dilakukan menggunakan Laravel Validator untuk memastikan keamanan dan konsistensi data.
- Dokumentasi dan testing bisa di akses melalui endpoint http://localhost:8000/api/documentation yang sudah dibuat dengan menggunakan Swagger.
