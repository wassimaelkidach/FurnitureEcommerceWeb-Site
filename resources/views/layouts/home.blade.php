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
                            <a href="{{ route('category.products', $category->id) }}" class="btn btn-primary">Voir les produits</a>
                        </div>
                    </div>
                </div>
            @endforeach

            
            <!-- From Uiverse.io by vinodjangid07 --> 
            <div class="button">
                <button class="button">
                    <svg class="svgIcon" viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm50.7-186.9L162.4 380.6c-19.4 7.5-38.5-11.6-31-31l55.5-144.3c3.3-8.5 9.9-15.1 18.4-18.4l144.3-55.5c19.4-7.5 38.5 11.6 31 31L325.1 306.7c-3.2 8.5-9.9 15.1-18.4 18.4zM288 256a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"></path></svg>
                    <a href="#">Explore</a>
                </button>
            </div>

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


@endsection