
@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Lien vers le fichier CSS admin -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- Optionnel : Bootstrap ou autre CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<div class="dashboard-container">
    <!-- Sidebar -->

    <!-- Main content -->
    <main class="main-content">
        <header class="admin-header">
            <h1>Bienvenue, Administrateur !</h1>
        </header>
        <section class="stats">
            <div class="card">Total Utilisateurs: <span>150</span></div>
            <div class="card">Total Produits: <span>300</span></div>
            <div class="card">Commandes en attente: <span>10</span></div>
        </section>
    </main>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection
