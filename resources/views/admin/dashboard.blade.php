@extends('layouts.admin')

@section('title', 'Tableau de bord dynamique')

@section('content')
<div class="container-fluid py-4">
    <!-- Header dynamique avec date -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white p-4 rounded-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-primary mb-2">Bienvenue, Administrateur !</h1>
                        <p class="text-muted mb-0" id="current-date"></p>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" id="refresh-btn">
                        <i class="fas fa-sync-alt me-1"></i> Actualiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards dynamiques -->
    <div class="row g-4 mb-4" id="stats-cards">
        <!-- Les cartes seront chargées dynamiquement -->
    </div>

    <!-- Charts Section dynamique -->
    <div class="row mb-4">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Performance des ventes</h5>
                        <select class="form-select form-select-sm w-auto" id="sales-period">
                            <option value="7">7 jours</option>
                            <option value="30" selected>30 jours</option>
                            <option value="90">90 jours</option>
                        </select>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h5 class="mb-0">Répartition par catégorie</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity dynamique -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i> Dernières activités</h5>
                        <button class="btn btn-sm btn-link text-primary" id="load-more-activities">
                            Voir plus
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush" id="activities-list">
                        <!-- Les activités seront chargées dynamiquement -->
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2 text-warning"></i> Alertes</h5>
                </div>
                <div class="card-body" id="alerts-container">
                    <!-- Les alertes seront chargées dynamiquement -->
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
/* Styles existants... */
.chart-container {
    position: relative;
    width: 100%;
    min-height: 300px;
}

#refresh-btn.rotating {
    animation: rotate 1s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.loading-spinner {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(0,0,0,.1);
    border-radius: 50%;
    border-top-color: #3498db;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// Variables globales
let salesChart, categoriesChart;
let activitiesPage = 1;

document.addEventListener('DOMContentLoaded', function() {
    // Afficher la date actuelle
    updateCurrentDate();
    
    // Charger les données initiales
    loadAllData();
    
    // Configurer les écouteurs d'événements
    document.getElementById('refresh-btn').addEventListener('click', loadAllData);
    document.getElementById('sales-period').addEventListener('change', updateSalesChart);
    document.getElementById('load-more-activities').addEventListener('click', loadMoreActivities);
});

function updateCurrentDate() {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('fr-FR', options);
}

async function loadAllData() {
    try {
        // Activer l'animation de rafraîchissement
        const refreshBtn = document.getElementById('refresh-btn');
        refreshBtn.innerHTML = '<span class="loading-spinner"></span> Chargement...';
        refreshBtn.classList.add('rotating');
        
        // Charger les données en parallèle
        await Promise.all([
            loadStatsCards(),
            initializeCharts(),
            loadRecentActivities(),
            loadAlerts()
        ]);
        
    } catch (error) {
        console.error('Erreur lors du chargement des données:', error);
        showAlert('danger', 'Erreur lors du chargement des données');
    } finally {
        // Désactiver l'animation de rafraîchissement
        const refreshBtn = document.getElementById('refresh-btn');
        refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-1"></i> Actualiser';
        refreshBtn.classList.remove('rotating');
    }
}

async function loadStatsCards() {
    try {
        // Simuler une requête API (remplacer par un appel réel)
        const response = await axios.get('/api/dashboard/stats');
        const stats = response.data || {
            users: { count: Math.floor(Math.random() * 200) + 100, trend: Math.floor(Math.random() * 20) - 5 },
            products: { count: Math.floor(Math.random() * 500) + 200, trend: Math.floor(Math.random() * 15) - 2 },
            orders: { count: Math.floor(Math.random() * 50) + 10, trend: Math.floor(Math.random() * 30) - 5 },
            revenue: { count: Math.floor(Math.random() * 20000) + 5000, trend: Math.floor(Math.random() * 25) - 3 }
        };
        
        // Générer le HTML des cartes
        const cardsHtml = `
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-primary border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">UTILISATEURS</h5>
                            <h2 class="mb-0 text-primary">${stats.users.count}</h2>
                            <small class="text-muted">Inscrits</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        ${renderTrendBadge(stats.users.trend, 'vs mois dernier')}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-success border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">PRODUITS</h5>
                            <h2 class="mb-0 text-success">${stats.products.count}</h2>
                            <small class="text-muted">En stock</small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-box-open fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        ${renderTrendBadge(stats.products.trend, 'vs mois dernier')}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-warning border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">COMMANDES</h5>
                            <h2 class="mb-0 text-warning">${stats.orders.count}</h2>
                            <small class="text-muted">Ce mois</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        ${renderTrendBadge(stats.orders.trend, 'vs mois dernier')}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-info border-4 h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">REVENUS</h5>
                            <h2 class="mb-0 text-info">$${(stats.revenue.count / 1000).toFixed(1)}K</h2>
                            <small class="text-muted">Ce mois</small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-dollar-sign fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        ${renderTrendBadge(stats.revenue.trend, 'vs mois dernier')}
                    </div>
                </div>
            </div>
        </div>`;
        
        document.getElementById('stats-cards').innerHTML = cardsHtml;
        
    } catch (error) {
        console.error('Erreur lors du chargement des statistiques:', error);
        throw error;
    }
}

function renderTrendBadge(value, text) {
    const isPositive = value >= 0;
    const icon = isPositive ? 'fa-arrow-up' : 'fa-arrow-down';
    const bgClass = isPositive ? 'bg-success' : 'bg-danger';
    
    return `
    <span class="badge ${bgClass}-subtle text-${isPositive ? 'success' : 'danger'}">
        <i class="fas ${icon} me-1"></i> ${Math.abs(value)}%
    </span>
    <span class="text-muted ms-2">${text}</span>`;
}

async function initializeCharts() {
    try {
        // Détruire les anciens graphiques s'ils existent
        if (salesChart) salesChart.destroy();
        if (categoriesChart) categoriesChart.destroy();
        
        // Charger les données des graphiques
        const period = document.getElementById('sales-period').value;
        const [salesData, categoriesData] = await Promise.all([
            fetchSalesData(period),
            fetchCategoriesData()
        ]);
        
        // Créer le graphique des ventes
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesData.labels,
                datasets: [{
                    label: 'Ventes',
                    data: salesData.values,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Ventes: $${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
        
        // Créer le graphique des catégories
        const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
        categoriesChart = new Chart(categoriesCtx, {
            type: 'doughnut',
            data: {
                labels: categoriesData.labels,
                datasets: [{
                    data: categoriesData.values,
                    backgroundColor: [
                        '#3498db',
                        '#2ecc71',
                        '#f39c12',
                        '#9b59b6',
                        '#e74c3c',
                        '#1abc9c'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${percentage}% (${context.raw})`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
        
    } catch (error) {
        console.error('Erreur lors de l\'initialisation des graphiques:', error);
        throw error;
    }
}

async function updateSalesChart() {
    try {
        const period = document.getElementById('sales-period').value;
        const salesData = await fetchSalesData(period);
        
        salesChart.data.labels = salesData.labels;
        salesChart.data.datasets[0].data = salesData.values;
        salesChart.update();
        
    } catch (error) {
        console.error('Erreur lors de la mise à jour du graphique:', error);
        showAlert('danger', 'Erreur lors de la mise à jour des données des ventes');
    }
}

async function fetchSalesData(period = '30') {
    // Simuler une requête API (remplacer par un appel réel)
    return new Promise(resolve => {
        setTimeout(() => {
            const days = parseInt(period);
            const labels = [];
            const values = [];
            
            for (let i = days; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                labels.push(date.toLocaleDateString('fr-FR', { month: 'short', day: 'numeric' }));
                values.push(Math.floor(Math.random() * 5000) + 1000);
            }
            
            resolve({ labels, values });
        }, 500);
    });
}

async function fetchCategoriesData() {
    // Simuler une requête API (remplacer par un appel réel)
    return new Promise(resolve => {
        setTimeout(() => {
            const categories = ['Vêtements', 'Chaussures', 'Accessoires', 'Électronique', 'Maison', 'Autres'];
            const values = categories.map(() => Math.floor(Math.random() * 100) + 20);
            
            resolve({ labels: categories, values });
        }, 500);
    });
}

async function loadRecentActivities(loadMore = false) {
    try {
        if (!loadMore) {
            activitiesPage = 1;
            document.getElementById('activities-list').innerHTML = '';
        }
        
        // Simuler une requête API (remplacer par un appel réel)
        const response = await axios.get(`/api/activities?page=${activitiesPage}`);
        const activities = response.data || generateRandomActivities(loadMore ? 5 : 3);
        
        const activitiesHtml = activities.map(activity => `
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                <div>
                    <span class="badge ${getActivityBadgeClass(activity.type)} me-2">
                        ${getActivityIcon(activity.type)} ${activity.type}
                    </span>
                    <span>${activity.description}</span>
                </div>
                <small class="text-muted">${formatTimeAgo(activity.time)}</small>
            </li>
        `).join('');
        
        if (loadMore) {
            document.getElementById('activities-list').insertAdjacentHTML('beforeend', activitiesHtml);
        } else {
            document.getElementById('activities-list').innerHTML = activitiesHtml;
        }
        
        activitiesPage++;
        
    } catch (error) {
        console.error('Erreur lors du chargement des activités:', error);
        showAlert('danger', 'Erreur lors du chargement des activités récentes');
    }
}

function loadMoreActivities() {
    loadRecentActivities(true);
}

function generateRandomActivities(count) {
    const types = ['Utilisateur', 'Commande', 'Produit', 'Paiement', 'Système'];
    const descriptions = [
        'Nouvel utilisateur inscrit',
        'Commande #${Math.floor(Math.random() * 1000)} passée',
        'Produit mis à jour',
        'Paiement reçu',
        'Mise à jour du système effectuée'
    ];
    
    return Array.from({ length: count }, (_, i) => ({
        type: types[Math.floor(Math.random() * types.length)],
        description: descriptions[Math.floor(Math.random() * descriptions.length)],
        time: new Date(Date.now() - Math.floor(Math.random() * 48 * 60 * 60 * 1000))
    }));
}

function getActivityBadgeClass(type) {
    const classes = {
        'Utilisateur': 'bg-primary',
        'Commande': 'bg-success',
        'Produit': 'bg-info',
        'Paiement': 'bg-warning',
        'Système': 'bg-secondary'
    };
    return classes[type] || 'bg-light text-dark';
}

function getActivityIcon(type) {
    const icons = {
        'Utilisateur': 'fa-user',
        'Commande': 'fa-shopping-cart',
        'Produit': 'fa-box',
        'Paiement': 'fa-credit-card',
        'Système': 'fa-cog'
    };
    return `<i class="fas ${icons[type] || 'fa-circle'}"></i>`;
}

function formatTimeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    
    if (seconds < 60) return 'à l\'instant';
    if (seconds < 3600) return `il y a ${Math.floor(seconds / 60)} min`;
    if (seconds < 86400) return `il y a ${Math.floor(seconds / 3600)} h`;
    return `il y a ${Math.floor(seconds / 86400)} j`;
}

async function loadAlerts() {
    try {
        // Simuler une requête API (remplacer par un appel réel)
        const response = await axios.get('/api/alerts');
        const alerts = response.data || [
            { type: 'warning', message: '3 demandes de contact en attente', icon: 'fa-envelope' },
            { type: 'danger', message: '2 problèmes à résoudre', icon: 'fa-exclamation-triangle' },
            { type: 'success', message: '5 avis clients à modérer', icon: 'fa-star' }
        ];
        
        const alertsHtml = alerts.map(alert => `
            <div class="alert alert-${alert.type} alert-dismissible fade show mb-3">
                <div class="d-flex align-items-center">
                    <i class="fas ${alert.icon} me-2"></i>
                    <div>
                        <strong>${alert.message}</strong>
                        ${alert.details ? `<div class="small mt-1">${alert.details}</div>` : ''}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `).join('');
        
        document.getElementById('alerts-container').innerHTML = alertsHtml;
        
    } catch (error) {
        console.error('Erreur lors du chargement des alertes:', error);
        showAlert('danger', 'Erreur lors du chargement des alertes');
    }
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show mb-3">
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Ajouter en haut du conteneur d'alertes
    document.getElementById('alerts-container').insertAdjacentHTML('afterbegin', alertHtml);
    
    // Supprimer automatiquement après 5 secondes
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 5000);
}
</script>
@endsection