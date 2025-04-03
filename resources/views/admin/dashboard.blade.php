@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white p-4 rounded-3 shadow-sm">
                <h1 class="h3 text-primary mb-2">Bienvenue, Administrateur !</h1>
                <p class="text-muted mb-0">Gérez votre plateforme en toute simplicité</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Users Card -->
        <div class="col-md-4">
            <div class="card border-start border-primary border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">UTILISATEURS</h5>
                            <h2 class="mb-0 text-primary">150</h2>
                            <small class="text-muted">Inscrits</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-4">
            <div class="card border-start border-success border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">PRODUITS</h5>
                            <h2 class="mb-0 text-success">300</h2>
                            <small class="text-muted">En stock</small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-box-open fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-4">
            <div class="card border-start border-warning border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">COMMANDES</h5>
                            <h2 class="mb-0 text-warning">10</h2>
                            <small class="text-muted">En attente</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i> Activité récente</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i> Dernières activités</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <span class="badge bg-primary me-2">Nouveau</span>
                                <span>Utilisateur inscrit</span>
                            </div>
                            <small class="text-muted">2 min ago</small>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <span class="badge bg-success me-2">Vente</span>
                                <span>Nouvelle commande #1234</span>
                            </div>
                            <small class="text-muted">15 min ago</small>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <span class="badge bg-info me-2">Produit</span>
                                <span>Nouveau produit ajouté</span>
                            </div>
                            <small class="text-muted">1 heure ago</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2 text-warning"></i> Requêtes récentes</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show mb-3">
                        <strong>3 demandes de contact</strong> en attente
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show mb-3">
                        <strong>2 problèmes</strong> à résoudre
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show">
                        <strong>5 avis clients</strong> à modérer
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@section('styles')
<style>
/* Custom Bootstrap enhancements */
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.border-4 {
    border-width: 4px !important;
}

.card-header {
    background-color: rgba(194, 204, 238, 0.66);
    backdrop-filter: blur(5px);
}

.chart-container {
    position: relative;
}

.list-group-item {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.text-primary {
    color: #3498db !important;
}
.bg-primary {
    background-color: #3498db !important;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js implementation
    const ctx = document.getElementById('activityChart').getContext('2d');
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Utilisateurs',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }, {
                label: 'Commandes',
                data: [8, 15, 7, 12, 9, 14],
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                borderColor: 'rgba(46, 204, 113, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection