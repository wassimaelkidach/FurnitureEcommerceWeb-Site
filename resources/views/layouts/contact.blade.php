@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
    <div class="contact-page">
        <!-- Hero Section -->
        <section class="about-hero">
        <div class="hero-content">
            <h1>Contact us</h1>
        </div>
    </section>

        <!-- Contact Form Section -->
        <section class="contact-form-section">
            <div class="container">
                <div class="contact-grid">
                    <!-- Contact Info -->
                    <div class="contact-info">
                        <h2>Informations de contact</h2>
                        <div class="contact-method">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h3>Adresse</h3>
                                <p>123 Rue du Design, Agadir 75001, Maroc</p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <h3>Téléphone</h3>
                                <p>+212 67 23 45 67 89</p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h3>Email</h3>
                                <p>dwirastyle@gmail.com</p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h3>Heures d'ouverture</h3>
                                <p>Lundi - Vendredi: 9h - 18h</p>
                                <p>Samedi: 10h - 15h</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="contact-form-container">
                        <h2>Envoyez-nous un message</h2>
                        <form id="contactForm" class="contact-form">
                            <div class="form-group">
                                <input type="text" id="name" name="name" required>
                                <label for="name">Nom complet</label>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" required>
                                <label for="email">Adresse email</label>
                            </div>
                            <div class="form-group">
                                <input type="tel" id="phone" name="phone">
                                <label for="phone">Téléphone (optionnel)</label>
                            </div>
                            <div class="form-group">
                                <textarea id="message" name="message" rows="5" required></textarea>
                                <label for="message">Votre message</label>
                            </div>
                            <button type="submit" class="submit-btn">Envoyer le message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="map-section">
            <div id="map"></div>
        </section>
    </div>

    <style>
        :root {
            --primary-color: #3b5d50;
            --secondary-color: #f9bf29;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --white: #ffffff;
            --transition: all 0.3s ease;
        }

        /* Hero Section */
        .about-hero {
            height: 50vh;
            min-height: 500px;
            background: #41729f;
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
            animation: fadeInDown 1s ease;
        }
        
        .about-hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease;
        }
        

        /* Contact Form Section */
        .contact-form-section {
            padding: 5rem;
            background-color: var(--light-gray);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .contact-info {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px #41729f;
        }

        .contact-info h2 {
            color: #41729f;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .contact-method {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .contact-method i {
            font-size: 1.5rem;
            color: var(--secondary-color);
            margin-right: 1.5rem;
            margin-top: 0.3rem;
        }

        .contact-method h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color:rgb(0, 77, 149);
        }

        .contact-method p {
            margin: 0;
            color:rgb(0, 0, 0);
            line-height: 1.6;
        }

        /* Form Styles */
        .contact-form-container {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px #41729f;
        }

        .contact-form-container h2 {
            color: #41729f;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: transparent;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-group label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: #777;
            transition: var(--transition);
            pointer-events: none;
            background-color: var(--white);
            padding: 0 0.5rem;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-group input:focus + label,
        .form-group textarea:focus + label,
        .form-group input:not(:placeholder-shown) + label,
        .form-group textarea:not(:placeholder-shown) + label {
            top: -0.6rem;
            font-size: 0.8rem;
            color: #41729f;
        }

        .submit-btn {
            background-color: #41729f;
            color: var(--white);
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            font-weight: 600;
        }

        .submit-btn:hover {
            background-color:rgb(177, 177, 177);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Map Section */
        .map-section {
            height: 400px;
            width: 100%;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 2.5rem;
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
          <!-- JavaScript -->
    
        document.addEventListener('DOMContentLoaded', function() {
            // Animation on scroll
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.feature, .team-member, .testimonial-card');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2;
                    
                    if(elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Initialize elements with hidden state
            const features = document.querySelectorAll('.feature');
            const teamMembers = document.querySelectorAll('.team-member');
            const testimonials = document.querySelectorAll('.testimonial-card');
            
            features.forEach(feature => {
                feature.style.opacity = '0';
                feature.style.transform = 'translateY(20px)';
                feature.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            teamMembers.forEach(member => {
                member.style.opacity = '0';
                member.style.transform = 'translateY(20px)';
                member.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            testimonials.forEach(testimonial => {
                testimonial.style.opacity = '0';
                testimonial.style.transform = 'translateY(20px)';
                testimonial.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            // Run once on load
            animateOnScroll();
            
            // Run on scroll
            window.addEventListener('scroll', animateOnScroll);
        });
   
        document.addEventListener('DOMContentLoaded', function() {
            // Form animation
            const formGroups = document.querySelectorAll('.form-group');
            
            formGroups.forEach(group => {
                const input = group.querySelector('input, textarea');
                
                // Initialize labels
                if (input.value) {
                    const label = group.querySelector('label');
                    label.style.top = '-0.6rem';
                    label.style.fontSize = '0.8rem';
                    label.style.color = '#3b5d50';
                }
            });

            // Form submission
            const contactForm = document.getElementById('contactForm');
            
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = new FormData(contactForm);
                    
                    // Here you would typically send the data to your server
                    // For demo purposes, we'll just show an alert
                    alert('Merci pour votre message! Nous vous contacterons bientôt.');
                    
                    // Reset form
                    contactForm.reset();
                    
                    // Reset labels
                    document.querySelectorAll('.form-group label').forEach(label => {
                        label.style.top = '1rem';
                        label.style.fontSize = '1rem';
                        label.style.color = '#777';
                    });
                });
            }

            // Initialize map (using Leaflet.js as an example)
            if (document.getElementById('map')) {
                // In a real implementation, you would initialize your map here
                // This is just a placeholder for the demo
                console.log('Map would be initialized here');
                
                // Example with Leaflet:
                // const map = L.map('map').setView([48.8566, 2.3522], 13);
                // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                // L.marker([48.8566, 2.3522]).addTo(map).bindPopup('Furni Store');
            }
        });
    </script>

    <!-- Uncomment to use Leaflet.js for maps -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> -->
@endsection