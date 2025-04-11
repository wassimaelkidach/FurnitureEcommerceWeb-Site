@extends('layouts.admin')

@section('title', 'DIVIRA STYLE - Tableau de bord')

@section('content')
<div class="container-fluid px-0">
    <!-- Header avec indicateurs clés -->
    <div class="dashboard-header bg-white p-4 mb-4 shadow-sm rounded-3">
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-primary border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Chiffre d'affaires</h6>
                                <h3 class="mb-0">24,587MAD</h3>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-arrow-up me-1"></i>12.5%
                                </span>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-euro-sign fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-success border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Commandes</h6>
                                <h3 class="mb-0">324</h3>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-arrow-up me-1"></i>8.2%
                                </span>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-info border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Clients</h6>
                                <h3 class="mb-0">1,254</h3>
                                <span class="badge bg-danger bg-opacity-10 text-danger">
                                    <i class="fas fa-arrow-down me-1"></i>2.1%
                                </span>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-warning border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Panier moyen</h6>
                                <h3 class="mb-0">75.89MAD</h3>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-arrow-up me-1"></i>4.3%
                                </span>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shopping-basket fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
    <div class="card border-start border-danger border-4 h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-muted mb-2">Derniers Paiements</h6>
                    <div class="recent-payments">
                        @foreach($recentPayments as $payment)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">Payé</span>
                                <small>#{{ $payment->order_id }}</small>
                            </div>
                            <div>
                                <strong>{{ number_format($payment->amount, 2) }}MAD</strong>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-danger bg-opacity-10 p-3 rounded">
                    <i class="fas fa-credit-card fa-2x text-danger"></i>
                </div>
            </div>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-danger mt-3 w-100">
                Voir tous <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="row g-4">
        <!-- Performance Charts -->
        <div class="col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Performances Mensuelles
                    </h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary active">Mensuel</button>
                        <button class="btn btn-outline-secondary">Hebdo</button>
                        <button class="btn btn-outline-secondary">Quotidien</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i>
                        Répartition des Ventes
                    </h5>
                    <select class="form-select form-select-sm w-auto">
                        <option>30 jours</option>
                        <option>7 jours</option>
                        <option>Ce mois</option>
                    </select>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="salesDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Charts -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar text-info me-2"></i>
                        Activité des Utilisateurs
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Par semaine
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Par jour</a></li>
                            <li><a class="dropdown-item" href="#">Par semaine</a></li>
                            <li><a class="dropdown-item" href="#">Par mois</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="userActivityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area text-warning me-2"></i>
                        Tendance des Revenus
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="mb-0">24,587MAD</h3>
                            <span class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>12.5% vs période précédente
                            </span>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">Détails</button>
                    </div>
                    <div class="chart-container" style="height: 200px;">
                        <canvas id="revenueTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
:root {
    --chart-height-sm: 250px;
    --chart-height-lg: 300px;
}

.dashboard-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.chart-container {
    position: relative;
    min-height: var(--chart-height-sm);
    width: 100%;
}

.card {
    border-radius: 0.5rem;
    border: none;
    transition: all 0.3s ease;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.card-header {
    background-color: rgba(255,255,255,0.95);
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1rem 1.5rem;
}

.border-4 {
    border-width: 4px !important;
}

.text-primary {
    color: #4e73df !important;
}

.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}

/* Animation pour les cartes */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.card {
    animation: fadeIn 0.5s ease forwards;
}

/* Animation delay pour chaque carte */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }

@media (min-width: 992px) {
    .chart-container {
        min-height: var(--chart-height-lg);
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration commune des graphiques
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.85)',
                padding: 12,
                cornerRadius: 8,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) label += ': ';
                        if (context.parsed.y !== undefined) {
                            label += context.parsed.y.toLocaleString() + 'MAD';
                        } else {
                            label += context.parsed.toLocaleString();
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        }
    };

    // Performance Chart (Line)
    new Chart(document.getElementById('performanceChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Ventes (MAD)',
                data: [12000, 19000, 15000, 25000, 22000, 30000],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: chartOptions
    });

    // Sales Distribution (Doughnut)
    new Chart(document.getElementById('salesDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Salon', 'chambre', 'cuisine', 'Autres'],
            datasets: [{
                data: [45, 30, 20, 5],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                borderWidth: 0
            }]
        },
        options: {
            ...chartOptions,
            cutout: '70%',
            plugins: {
                ...chartOptions.plugins,
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value) => {
                        return value + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // User Activity (Bar)
    new Chart(document.getElementById('userActivityChart'), {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Visiteurs',
                data: [450, 600, 750, 800, 700, 950, 650],
                backgroundColor: '#4e73df',
                borderRadius: 4
            }]
        },
        options: chartOptions
    });

    // Revenue Trend (Line)
    new Chart(document.getElementById('revenueTrendChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenus (MAD)',
                data: [5000, 8000, 6000, 9000, 12000, 15000],
                borderColor: '#f6c23e',
                backgroundColor: 'rgba(246, 194, 62, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: chartOptions
    });

    // Gestion des boutons de filtre
    document.querySelectorAll('.btn-group button').forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            // Ici vous pourriez ajouter la logique pour filtrer les données
        });
    });
});
</script>
@endsection