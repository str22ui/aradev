<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZWTJ8TKN7L"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ZWTJ8TKN7L');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Meta Content='@yield('desc')' Name='Description'/>
    <Meta Content='@yield('keyword')' Name='Keywords'/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aradev @yield('title')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type = "image/x-icon">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite('resources/css/app.css')

    <style>

    .swiper-container {
        width: 100%;
        height: 100%;
        border-radius: 12px; /* Sesuaikan dengan kebutuhan */
        overflow: hidden; /* Pastikan gambar tidak keluar dari container */
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Pastikan gambar menutupi area slide */
    }

    .swiper-slide span {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.8); /* Latar belakang teks */
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: bold;
    }

    .swiper-slide a {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

