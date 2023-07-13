<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
## Instalacion del proyecto
Para empezar el proyecto se utilizaor las siguientes tecnologias:
-FRONT: Vue.js 3, Bootstrap 5 (framework visual), SweetAlert 2 (notificaciones)
-BACKEND: Laravel 10, Eloquent ORM, base de datos mysql y desarrollo local en localhost con XAMPP
al sistema se le cambio el lenguaje a español por lo cual no hay ninguna alerta o validacion en ingles
debe tener PHP 8> para poder usar laravel 10 y una conexion con base de datos mysql, puede ver el archivo .env como ejemplo base
debe tener node y npm instalado en su equipo de manera global asi como la libreria composer
la unica rama que hay es main, se tiene un archivo .gitignore donde esta el <b>node_modules</b> y <b>vendor</b>
para instalar las dependencias y correr el proyecto se necesitaran los siguientes comandos
##### Composer y npm
```bash
composer install
```
```bash
npm install
```
```bash
npm run dev
```
para correr el proyecto con informacion precargada debe correr los siguientes comandos solo funcionara si tiene revisada la configuracion con la base de datos
```bash
php artisan migrate
```
```bash
php artisan db:seed
```
este comando solo lo puede correr si tiene configurado su archivo .env
```bash
php artisan serve
```
