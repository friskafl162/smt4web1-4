<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal Berita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        /* WRAPPER */
        #wrapper{
            width: 1100px;
            margin: 20px auto;
            background: #fff;
            min-height: calc(100vh - 40px);
            box-shadow: 0 3px 15px rgba(0,0,0,.1);
            border-radius: 10px;
            overflow: hidden;
        }

        /* HEADER */
        header {
            background: #fff;
            padding: 20px 30px;
            border-bottom: 1px solid #ddd;
        }

        header h1 {
            margin: 0;
            color: #777;
            font-size: 2rem;
        }

        /* NAVBAR */
        nav {
            background: #2f6fb2;
        }

        nav ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
        }

        nav ul li a {
            display: block;
            padding: 14px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        nav ul li a:hover {
            background: #1f5a97;
        }

        /* CONTENT */
        .container {
            max-width: 100% !important;
            padding: 30px;
            background: #fff;
            margin: 0 !important;
        }

        /* TABLE */
        table th {
            background: #5b8cc5 !important;
            color: white;
            text-align: center;
        }

        table td {
            vertical-align: middle;
        }

        /* BUTTON */
        .btn {
            border-radius: 5px;
        }

        /* FOOTER */
        footer {
            background: #1c1c1c;
            color: white;
            padding: 20px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>

<body>

<div id="wrapper">

<header>
    <h1>Admin Portal Berita</h1>
</header>

<nav>
    <ul>
        <li><a href="<?= base_url('/admin/artikel'); ?>">Dashboard</a></li>
        <li><a href="<?= base_url('/admin/artikel'); ?>">Artikel</a></li>
        <li><a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a></li>
    </ul>
</nav>

<div class="container">