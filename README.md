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

**Deskripsi:** Mendapatkan daftar semua user yang tersimpan di database.

**Respons Berhasil:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com",
            "created_at": "2025-01-04T12:00:00.000Z",
            "updated_at": "2025-01-04T12:00:00.000Z"
        },
        ...
    ]
}
```

---

### 2. Menambahkan User Baru
**Endpoint:** `/api/v1/users`

**Method:** `POST`

**Deskripsi:** Menambahkan user baru ke database.

**Header:**
- `Content-Type: application/json`

**Body:**
```json
{
    "name": "Jane Doe",
    "email": "jane.doe@example.com",
    "password": "password123"
}
```

**Respons Berhasil:**
```json
{
    "status": "success",
    "message": "User berhasil ditambahkan.",
    "data": {
        "id": 2,
        "name": "Jane Doe",
        "email": "jane.doe@example.com",
        "created_at": "2025-01-04T12:15:00.000Z",
        "updated_at": "2025-01-04T12:15:00.000Z"
    }
}
```

**Respons Gagal:**
```json
{
    "status": "error",
    "message": "Validasi gagal.",
    "errors": {
        "email": ["Email sudah digunakan."]
    }
}
```

---

### 3. Mendapatkan Detail User
**Endpoint:** `/api/v1/users/{id}`

**Method:** `GET`

**Deskripsi:** Mendapatkan detail user berdasarkan ID.

**Respons Berhasil:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john.doe@example.com",
        "created_at": "2025-01-04T12:00:00.000Z",
        "updated_at": "2025-01-04T12:00:00.000Z"
    }
}
```

**Respons Gagal:**
```json
{
    "status": "error",
    "message": "User tidak ditemukan."
}
```

---

### 4. Memperbarui Data User
**Endpoint:** `/api/v1/users/{id}`

**Method:** `PUT`

**Deskripsi:** Memperbarui data user berdasarkan ID.

**Header:**
- `Content-Type: application/json`

**Body:**
```json
{
    "name": "Jane Doe Updated",
    "email": "jane.doe.updated@example.com"
}
```

**Respons Berhasil:**
```json
{
    "status": "success",
    "message": "User berhasil diperbarui.",
    "data": {
        "id": 2,
        "name": "Jane Doe Updated",
        "email": "jane.doe.updated@example.com",
        "created_at": "2025-01-04T12:15:00.000Z",
        "updated_at": "2025-01-04T12:30:00.000Z"
    }
}
```

**Respons Gagal:**
```json
{
    "status": "error",
    "message": "Validasi gagal.",
    "errors": {
        "email": ["Email sudah digunakan."]
    }
}
```

---

### 5. Menghapus User
**Endpoint:** `/api/v1/users/{id}`

**Method:** `DELETE`

**Deskripsi:** Menghapus user berdasarkan ID.

**Respons Berhasil:**
```json
{
    "status": "success",
    "message": "User berhasil dihapus."
}
```

**Respons Gagal:**
```json
{
    "status": "error",
    "message": "User tidak ditemukan."
}
```

---

## Catatan Tambahan
- Endpoint yang dibuat tidak ada otentikasi, sehingga bisa langsung digunakan.
- Validasi data harus dilakukan menggunakan Laravel Validator untuk memastikan keamanan dan konsistensi data.
- Dokumentasi dan testing bisa di akses melalui endpoint http://localhost:8000/api/documentation yang sudah dibuat dengan menggunakan Swagger
