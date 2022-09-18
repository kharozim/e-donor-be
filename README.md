<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### Auth

- Register

```
POST : http://localhost:8000/api/auth/register
body : 
{
	"name" : "Budi",
	"phone" : "081212",
	"age" : 6,
	"password" : "12121212",
	"blood_type" : "O",
	"token_fcm" : ""
}

```

- Login

```
POST : http://localhost:8000/api/auth/login
body : 
{
	
	"phone" : "081212",
	"password" : "12121212",
	"token_fcm" : ""
}

```

- Set Admin

```
POST : http://localhost:8000/api/auth/set-admin/{user_id}

```

- Request Reset

```
POST : http://localhost:8000/api/auth/request-reset
body : 
{
	
	"phone" : "081212",
}
response : 
{
	{
	"success": true,
	"data": {
		"token_reset_password": "QYd9e6633ZemHhgD9g79yzDg12YTeRIi",
		"phone": "123",
		"expired_at": "2022-08-26 18:29:14"
	}
}

```

- Reset Password

```
POST : http://localhost:8000/api/auth/reset-password
body : 
{
	"token" : { token_reset_password }
	"password" : "123123",
}

```

- Logout

```
POST : http://localhost:8000/api/auth/logout
auth : bearer token

```

### User

- Profile

```
GET : http://localhost:8000/api/user/profile
auth : bearer token
```

- Update Profile

```
POST : http://localhost:8000/api/user/update/profile
auth : bearer token
body : multipart

	name : text,
	phone : text,
	age : text,
	blood_type : text,
	image : file,

```

- Semua User

```
GET : http://localhost:8000/api/user/all
auth : bearer token admin
```

- Detail User

```
GET : http://localhost:8000/api/user/detail/{user id}
auth : bearer token admin
```

- Update User

```
PUT : http://localhost:8000/api/user/update/{user id}
auth : bearer token admin
body : 
{
	"name": "Budi edit ta",
	"phone": "123",
	"age": 160,
	"blood_type": "O editaa",
	"image": "https:\/\/thumbs.dreamstime.com\/b\/portrait-indian-people-street-puducherry-india-december-circa-years-man-serious-face-village-front-view-vibrant-174355138.jpg editaa",
	"token_fcm": "",
	"is_pendonor" : true
}
```


- Delete User

```
DELETE : http://localhost:8000/api/user/delete/{user id}
auth : bearer token admin
```

### Pendonor

- Mendaftar jadi Pendonor

```
POST : http://localhost:8000/api/donor/add-request
auth : bearer token
body : 
{
	"nik" : 252217212333,
	"phone" : "1234",
	"address" : "Kota barat Surakarta",
	"ttl" : "Surakarta / 20 Agustus 2000",
	"city" : "Surakarta"
}
```

- Cek status Pendaftaran saya

```
GET : http://localhost:8000/api/donor/me
auth : bearer token
```

- Semua pendaftar donor

```
GET : http://localhost:8000/api/donor/all
auth : bearer token admin
```

- Semua pendaftar donor yang belum dikonfirmasi

```
GET : http://localhost:8000/api/donor/all-request
auth : bearer token admin
```

- Detail pendonor

```
GET : http://localhost:8000/api/donor/detail/{donor id}
auth : bearer token admin
```

- Konfirmasi pendonor

```
POST : http://localhost:8000/api/donor/confirmation/{donor id}
auth : bearer token admin
body : 
{
	"status" : 1   // 1 = diterima, -1 = ditolak
}
```

- Hapus pendonor

```
DELETE : http://localhost:8000/api/donor/delete/{donor id}
auth : bearer token admin
```

### Bantuan

- Ajukan Bantuan

```
POST : http://localhost:8000/api/support/add
auth : bearer token
body : 
{
	"address" : "Solo Jawa Tengah",
	"blood_type_request" : "O"
}
```

- All Bantuan user

```
GET : http://localhost:8000/api/support/all-request
auth : bearer token
```

- ALl History user

```
GET : http://localhost:8000/api/support/all-take-by-me
auth : bearer token

```


- All Bantuan Admin
```
GET : http://localhost:8000/api/support/all
auth : bearer token admin
```

- Detail Bantuan
```
GET : http://localhost:8000/api/support/detail/{id}
auth : bearer token
```

- Ambil Bantuan
```
POST : http://localhost:8000/api/support/take/{id}
auth : bearer token
```

### Notification

- All

```
GET : http://localhost:8000/api/notification/all
auth : bearer token
```

- Read

```
POST : http://localhost:8000/api/notification/read/{notif id}
auth : bearer token
```

### Information PMI

- all 

```
GET : http://localhost:8000/api/information/all
auth : bearer token

```

- detail 

```
GET : http://localhost:8000/api/information/detail/{information id}
auth : bearer token

```

- add 

```
POST : http://localhost:8000/api/information/add
auth : bearer token (admin)
body : multipart
	title : text
	description : text
	date : text
	image : file

catatan : contoh format date "2022-12-30 14:00:12"

```

- update

```
POST : http://localhost:8000/api/information/update/{information id}
auth : bearer token (admin)
body : multipart
	title : text
	description : text
	date : text
	image : file

catatan : contoh format date "2022-12-30 14:00:12"

```

- delete

```
DELETE : http://localhost:8000/api/information/delete/{information id}
auth : bearer token
```


- GAMBAR TIDAK MUNCUL 

apabila gambar tidak muncul, lakukan symlink terlebih dulu folder  :

**{nama projek}/storate/app/information** -> **{nama projek}/public**

**{nama projek}/storate/app/profile** -> **{nama projek}/public**

 
cara symlink di windows : 
https://mastertipsorialindo.blogspot.com/2020/08/cara-membuat-symbolic-link-symlink-di.html

cara symlink di linux :
https://www.freecodecamp.org/news/symlink-tutorial-in-linux-how-to-create-and-remove-a-symbolic-link