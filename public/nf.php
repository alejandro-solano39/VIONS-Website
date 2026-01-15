<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrusel estilo Netflix</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #141414;
            color: white;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 20px 0 10px 15px;
        }
        
        .carousel-container {
            position: relative;
            padding: 0 50px;
        }
        
        .carousel-inner {
            overflow: visible;
        }
        
        .carousel-item {
            transition: transform 0.5s ease;
        }
        
        .movie-card {
            margin: 0 5px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .movie-card:hover {
            transform: scale(1.1);
            z-index: 1;
        }
        
        .movie-card img {
            border-radius: 4px;
            width: 100%;
            height: auto;
        }
        
        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .carousel-container:hover .carousel-control-prev,
        .carousel-container:hover .carousel-control-next {
            opacity: 1;
        }
        
        .carousel-control-prev {
            justify-content: flex-start;
            left: 0;
        }
        
        .carousel-control-next {
            justify-content: flex-end;
            right: 0;
        }
        
        .carousel-control-prev-icon, 
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            padding: 20px;
            background-size: 30%;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <!-- Primer carrusel -->
        <h4 class="section-title">Tendencias ahora</h4>
        <div class="carousel-container">
            <div id="carousel1" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex">
                            <div class="movie-card">
                                <img src="images/about/pic1.webp" class="d-block w-100" alt="Película 1">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/333333/FFFFFF?text=Película+2" class="d-block w-100" alt="Película 2">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/333333/FFFFFF?text=Película+3" class="d-block w-100" alt="Película 3">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/333333/FFFFFF?text=Película+4" class="d-block w-100" alt="Película 4">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/333333/FFFFFF?text=Película+5" class="d-block w-100" alt="Película 5">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/333333/FFFFFF?text=Película+6" class="d-block w-100" alt="Película 6">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex">
                            <div class="movie-card">
                                <img src="images/about/pic1.webp" class="d-block w-100" alt="Película 7">
                            </div>
                            <div class="movie-card">
                                <img src="images/about/pic1.webp" class="d-block w-100" alt="Película 8">
                            </div>
                            <div class="movie-card">
                                <img src=images/about/pic1.webp" class="d-block w-100" alt="Película 9">
                            </div>
                            <div class="movie-card">
                                <img src="images/about/pic1.webp" class="d-block w-100" alt="Película 10">
                            </div>
                            <div class="movie-card">
                                <img src="images/about/pic1.webp" class="d-block w-100" alt="Película 11">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/333333/FFFFFF?text=Película+12" class="d-block w-100" alt="Película 12">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>

        <!-- Segundo carrusel -->
        <h4 class="section-title">Series populares</h4>
        <div class="carousel-container">
            <div id="carousel2" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex">
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+1" class="d-block w-100" alt="Serie 1">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+2" class="d-block w-100" alt="Serie 2">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+3" class="d-block w-100" alt="Serie 3">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+4" class="d-block w-100" alt="Serie 4">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+5" class="d-block w-100" alt="Serie 5">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+6" class="d-block w-100" alt="Serie 6">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex">
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+7" class="d-block w-100" alt="Serie 7">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+8" class="d-block w-100" alt="Serie 8">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+9" class="d-block w-100" alt="Serie 9">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+10" class="d-block w-100" alt="Serie 10">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+11" class="d-block w-100" alt="Serie 11">
                            </div>
                            <div class="movie-card">
                                <img src="https://via.placeholder.com/300x450/555555/FFFFFF?text=Serie+12" class="d-block w-100" alt="Serie 12">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel2" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Opcional: Puedes añadir más funcionalidades con JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto hover para las tarjetas
            const cards = document.querySelectorAll('.movie-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.zIndex = '1';
                });
            });
        });
    </script>
</body>
</html>