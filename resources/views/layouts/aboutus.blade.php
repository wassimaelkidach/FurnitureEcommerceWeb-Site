@extends('layouts.app')

@section('title', 'À propos de nous')

@section('content')
    <meta name="keywords" content="furniture, modern design, elegant home, quality craftsmanship">
    <meta name="description" content="Discover the story behind our premium furniture designs and our commitment to quality and sustainability.">

    <!-- Additional CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #3b5d50;
            --primary-dark: #2d473d;
            --secondary-color: #f9bf29;
            --light-color: #f8f9fa;
            --dark-color: #2f2f2f;
            --text-color: #555;
            --white: #ffffff;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        /* Hero Section */
        .about-hero {
            height: 60vh;
            min-height: 500px;
            background: linear-gradient(rgba(65, 114, 159, 0.8), rgba(65, 114, 159, 0.8)), 
                        url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }
        
        .about-hero h1 {
            color: #ffffff;
            font-size: 4.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease;
        }
        
        .about-hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 0;
            background: #41729f;
            color: var(--white);
        }
        
        .stat-item {
            text-align: center;
            padding: 3rem 2rem;
            transition: var(--transition);
        }
        
        .stat-item:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
            color: white;
        }
        
        .stat-label {
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }
      
        /* Why Choose Us Section */
        .why-choose-us {
            padding: 6rem ;
            background-color: #f9f9f9;
            position: relative;
            overflow: hidden;
        }
        
        .why-choose-us .container {
            position: relative;
            z-index: 2;
        }
        
        .why-choose-us h2 {
            font-size: 2.8rem;
            color: var(--primary-dark);
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 2rem;
        }
        
        .why-choose-us h2:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
        }
        
        .why-choose-us .lead {
            font-size: 1.2rem;
            color: var(--text-color);
            margin-bottom: 3rem;
            line-height: 1.6;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .feature-item {
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
            display: flex;
            align-items: flex-start;
        }
        
        .feature-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 1.8rem;
            color: var(--secondary-color);
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .feature-content h4 {
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }
        
        .divider {
            width: 30px;
            height: 2px;
            background: var(--secondary-color);
            margin: 1rem 0;
        }
        
        .feature-item p {
            color: var(--text-color);
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .why-choose-us .img-container {
            position: relative;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .why-choose-us .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .why-choose-us .img-container:hover img {
            transform: scale(1.05);
        }
        
        /* Team Section */
        .team-section {
            padding: 5rem 0;
            background-color: white;
            text-align: center;
        }
        
        .team-section h2 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }
        
        .subtitle {
            font-size: 1.2rem;
            color: #777;
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .team-member {
            background: white;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: var(--transition);
        }
        
        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        
        .team-member img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 5px solid rgba(249, 191, 41, 0.2);
            transition: var(--transition);
        }
        
        .team-member:hover img {
            border-color: var(--secondary-color);
        }
        
        .team-member h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }
        
        .team-member p {
            font-size: 1rem;
            color: #777;
            font-style: italic;
        }
        
        .social-links {
            margin-top: 15px;
        }
        
        .social-links a {
            color: var(--primary-dark);
            margin: 0 5px;
            font-size: 1.1rem;
            transition: var(--transition);
        }
        
        .social-links a:hover {
            color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 6rem ;
            background: linear-gradient(135deg, #f9f9f9 0%, #eef2f5 100%);
            position: relative;
        }
        
        .testimonials-section h2 {
            font-size: 2.8rem;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 10px;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 30px;
            position: relative;
        }
        
        .testimonial-card:before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 5rem;
            font-family: 'Playfair Display', serif;
            color: rgba(249, 191, 41, 0.1);
            line-height: 1;
            z-index: 1;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        
        .client-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }
        
        .client-avatar {
            width: 70px;
            height: 70px;
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .client-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--secondary-color);
        }
        
        .client-details h4 {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }
        
        .client-details p {
            color: #777;
            font-size: 0.9rem;
        }
        
        .rating {
            color: var(--secondary-color);
            margin-bottom: 15px;
            font-size: 1rem;
        }
        
        .testimonial-content {
            position: relative;
            z-index: 2;
        }
        
        .testimonial-content p {
            font-style: italic;
            color: var(--text-color);
            line-height: 1.7;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .about-hero h1 {
                font-size: 4rem;
            }
        }
        
        @media (max-width: 992px) {
            .about-hero {
                height: 50vh;
            }
            
            .about-hero h1 {
                font-size: 3.2rem;
            }
            
            .why-choose-us {
                padding: 4rem 0;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
            }
            
            .why-choose-us .img-container {
                height: 400px;
                margin-bottom: 3rem;
            }
        }
        
        @media (max-width: 768px) {
            .about-hero {
                height: 45vh;
                min-height: 400px;
            }
            
            .about-hero h1 {
                font-size: 2.5rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .stat-label {
                font-size: 1rem;
            }
            
            .why-choose-us h2,
            .team-section h2,
            .testimonials-section h2 {
                font-size: 2.2rem;
            }
            
            .team-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .about-hero {
                height: 40vh;
            }
            
            .stat-item {
                padding: 2rem 1rem;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
                max-width: 300px;
            }
            
            .testimonial-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="hero-content">
            <h1>Notre Histoire, Votre Intérieur</h1>
            <p class="lead">Depuis plus de 25 ans, nous créons des meubles qui transforment les maisons en foyers</p>
        </div>
    </section>


    <!-- Pourquoi Nous Choisir Section -->
    <section class="why-choose-us">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-lg-6">
                    <h2>Pourquoi Nous Choisir</h2>
                    <p class="lead">Nous combinons savoir-faire artisanal, design innovant et engagement écologique pour créer des meubles exceptionnels.</p>
                    
                    <div class="feature-grid">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Livraison Rapide</h4>
                                <p>Livraison express offerte en 48h pour toutes les commandes supérieures à 200€.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Expérience Client</h4>
                                <p>Interface intuitive et processus de commande simplifié pour un shopping sans stress.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Support Premium</h4>
                                <p>Notre équipe dédiée est disponible 7j/7 pour vous conseiller et vous accompagner.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-undo-alt"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Satisfaction Garantie</h4>
                                <p>30 jours pour changer d'avis avec retour et remboursement sans conditions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Notre Équipe Section -->
     <section class="team-section">
        <div class="container">
            <h2>Rencontrez Notre Équipe</h2>
            <p class="subtitle">Des passionnés du design et de l'artisanat qui mettent tout leur savoir-faire à votre service</p>
            
            <div class="team-grid">
                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Emma Dubois">
                    <h3>Emma Dubois</h3>
                    <p>Fondatrice & CEO</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Lucas Bernard">
                    <h3>Lucas Bernard</h3>
                    <p>Designer Principal</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-behance"></i></a>
                    </div>
                </div>

                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sophie Martin">
                    <h3>Sophie Martin</h3>
                    <p>Responsable Qualité</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>

                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/men/35.jpg" alt="Antoine Lefèvre">
                    <h3>Antoine Lefèvre</h3>
                    <p>Directeur Logistique</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">2+</div>
                        <div class="stat-label">ans d'expérience</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">100     </div>
                        <div class="stat-label">Clients satisfaits</div>
                    </div>
                </div>
               
              
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation on scroll
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.feature-item, .team-member, .testimonial-card, .stat-item');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;
                    
                    if(elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Initialize elements with hidden state
            const animateElements = document.querySelectorAll('.feature-item, .team-member, .testimonial-card, .stat-item');
            
            animateElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            // Run once on load
            setTimeout(animateOnScroll, 100);
            
            // Run on scroll
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
@endsection