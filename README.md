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
	"token" : {token_reset_password},
	"password" : "11112222"
}
```
