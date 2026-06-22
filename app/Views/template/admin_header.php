<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal Berita</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background: #f4f4f4;
        }

        /* HEADER */
        header {
            background: #ffffff;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        header h1 {
            margin: 0;
            color: #888;
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
            color: white;
            text-decoration: none;
        }

        nav ul li a:hover {
            background: #1f5a97;
        }

        /* CONTAINER */
        .container {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #5b8cc5;
            color: white;
            padding: 10px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        /* BUTTON */
        .btn {
            padding: 6px 10px;
            background: #999;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }

        .btn-danger {
            background: #e74c3c;
        }

        /* Footer */
        footer {
            clear: both; /* biar gak ketiban float */
            background-color: #1c1c1c;
            color: #ffffff;
            padding: 20px;
            font-size: 14px;
        }

        footer p {
            margin: 0;
        }
    </style>

</head>

<body>

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
    