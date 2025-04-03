@extends('layouts.app')
@section('content')

    <section class="landing-page-section">

        <div class="hero">

            <h1 class="buy">Buy your dream Furniture!</h1>
                <div class="stats">
                    <div class="stat stat1">
                        <span>50+</span>
                        <p>Home Furniture</p>
                    </div>
                    <div class="stat">
                        <span>100+</span>
                        <p>Customers</p>
                    </div>
                </div>
            

            <div class="cta">
                <div class="input-search-container">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="search" placeholder="What are you looking for?">
                        <button type="submit" class="button-search">
                        <div style="display: flex;">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_250_225)">
                                    <path d="M14.6776 12.93C15.888 11.2784 16.4301 9.23062 16.1955 7.19644C15.9609 5.16226 14.9668 3.29168 13.4123 1.95892C11.8577 0.626155 9.85727 -0.070492 7.81113 0.00834944C5.76499 0.0871909 3.82407 0.935706 2.37667 2.38414C0.929274 3.83257 0.0821478 5.7741 0.00477057 7.8203C-0.0726067 9.86649 0.625471 11.8665 1.95934 13.4201C3.29322 14.9737 5.16451 15.9663 7.19886 16.1995C9.2332 16.4326 11.2806 15.8891 12.9313 14.6775H12.9301C12.9676 14.7275 13.0076 14.775 13.0526 14.8213L17.8651 19.6338C18.0995 19.8683 18.4174 20.0001 18.749 20.0003C19.0806 20.0004 19.3987 19.8688 19.6332 19.6344C19.8678 19.4 19.9996 19.082 19.9997 18.7504C19.9998 18.4189 19.8682 18.1008 19.6338 17.8663L14.8213 13.0538C14.7766 13.0085 14.7286 12.968 14.6776 12.93ZM15.0001 8.125C15.0001 9.02784 14.8223 9.92184 14.4768 10.756C14.1313 11.5901 13.6248 12.348 12.9864 12.9864C12.348 13.6248 11.5901 14.1312 10.756 14.4767C9.92192 14.8222 9.02792 15 8.12508 15C7.22225 15 6.32825 14.8222 5.49414 14.4767C4.66002 14.1312 3.90213 13.6248 3.26373 12.9864C2.62532 12.348 2.11891 11.5901 1.77341 10.756C1.42791 9.92184 1.25008 9.02784 1.25008 8.125C1.25008 6.30164 1.97441 4.55296 3.26373 3.26364C4.55304 1.97433 6.30172 1.25 8.12508 1.25C9.94845 1.25 11.6971 1.97433 12.9864 3.26364C14.2758 4.55296 15.0001 6.30164 15.0001 8.125Z" fill="#1E1E1E"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_250_225">
                                        <rect width="20" height="20" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
        
    </section>

<section class="categories-section">

    <div class="container">
        <h2>Catégories</h2>

        <p>Find what you are looking for</p>
        <div class="categories-container">
            @foreach($categories as $category)
                <div class="categories">
                    <div class="category">
                        @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                        @else
                            <img src="{{ asset('images/category-placeholder.jpg') }}" class="card-img-top" alt="{{ $category->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <a href="{{ route('category.products', $category->id) }}" class="btn btn-primary">view products <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="15px" width="15px" class="icon">

                            <path stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" stroke="#292D32" d="M8.91016 19.9201L15.4302 13.4001C16.2002 12.6301 16.2002 11.3701 15.4302 10.6001L8.91016 4.08008"></path>

                            </svg></a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

    <section class="best-selling">
        <h2>Our best selling Furniture</h2>
        <div class="trendyproducts">
            <div class="products">
                <div class="product">

                </div>
            </div>

        </div>
    
    </section>

    <section class="delivery-section">
        <div class="delivery-container">
            <h2>Order now</h2>
            <div class="delivery-features">
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <h2>Large Assortment</h2>
                <p>We offer many different types of products with fewer variations in each category.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h2>Fast & Free Shipping</h2>
                <p>4-day or less delivery time, free shipping and an expedited delivery option.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h2>24/7 Support</h2>
                <p>Answers to any business related inquiry 24/7 and in real-time.</p>
            </div>
            </div> 
        </div>
    </section>


<section class="reviews-section">
    <div class="reviews-container">
        <h2>What customers say about us !</h2>
        
        <div class="reviews-grid">

            <div class="card">
                <div class="header">
                    <div class="image"><img src="{{ asset('images/john.png') }}" alt=""></div>
                    
                    <div class="stars">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
              
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
              
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    
                    </div>
                    <p class="name">John Doe</p>
            
                
                </div>

                <p class="message">
                “I absolutely love the furniture from Dwira! The designs are modern, stylish, and incredibly comfortable. The quality is outstanding, and the customer service was excellent. Highly recommended!”
               </p>
            </div>

            <div class="card">
                <div class="header">
                    <div class="image"><img src="{{ asset('images/crestina.png') }}" alt=""></div>
                    
                    <div class="stars">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>

                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
              
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    
                    </div>
                    <p class="name">crestina dauth</p>
            
                
                </div>

                <p class="message">
                “I absolutely love the furniture from Dwira! The designs are modern, stylish, and incredibly comfortable. The quality is outstanding, and the customer service was excellent. Highly recommended!”
               </p>
            </div>
            
        </div>
    </div>
</section>

<!-- Footer -->
    <footer>
        <div class="footer-brand">
            <h3 class="logo">dwira</h3>
        </div>
        <div class="footer-links">
            <a href="#">Home</a>
            <a href="#">Products</a>
            <a href="#">Categories</a>
            <a href="#">About us</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="footer-contact">
            <p>+212 (06) 644121800</p> <br>
            <p>&copy; 2025 Dwira Style. All rights are reserved</p>

        </div>
        
    </footer>
@endsection