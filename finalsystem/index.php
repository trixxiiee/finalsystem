<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'php/cdn.php'; ?>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php
    if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
            header("Location: admindashboard.php");
        } else {
            header("Location: userdashboard.php");
        }
        exit();
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar dishnav navbar-expand-lg sticky-top navbar-light bg-white shadow px-5">
        <div class="container-fluid d-flex justify-content-between">
            <div>
                <img src="images/logo.png" alt="logo" class="logo myLogo img-fluid">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#homeHero"><i class="fas fa-home"></i><span class="mx-2">Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#homeAbout"><i class="fas fa-info-circle"></i><span class="mx-2">About</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#homeFeatures"><i class="fas fa-concierge-bell"></i><span class="mx-2">Features</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#homeContact"><i class="fas fa-envelope"></i><span class="mx-2">Contact</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Home Hero Section -->
    <section class="homeHero d-flex justify-content-center align-items-center" id="homeHero">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="mb-4 text-quaternary text-shadow">DISH-COVERY: A social platform for recipe sharing and exploration</h1>
                    <p class="mb-4 text-white">Welcome to Dish-covery! Whether you're an aspiring chef, a seasoned home cook, or a passionate food lover, Dish-covery is here to inspire and elevate your culinary journey.</p>
                    <div class="d-flex gap-3">
                        <a href="login.php" class="btn dishbutton px-4">Login</a>
                        <a href="register.php" class="btn dishbutton-secondary px-4">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Home About Section -->
    <section class="homeAbout d-flex justify-content-center align-items-center" id="homeAbout">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
                    <img src="images/about.png" alt="Cooking Experience" class="img-fluid">
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000">
                    <h2 class="mb-4 text-quaternary ">About Us</h2>
                    <p class="lead">We believe that food is not just sustenance; it's an experience that brings people together. Our mission is to connect food lovers with delicious recipes, local dining experiences, and culinary inspiration from around the globe.</p>
                    <a href="#" class="btn dishbutton mt-3">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features d-flex justify-content-center align-items-center" id="homeFeatures">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="text-quaternary">Our Features</h2>
                    <p class="lead">Discover what makes Dish-covery special</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Post Recipe Online -->
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="bg-white p-4 text-center h-100">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-utensils fa-3x text-quaternary"></i>
                        </div>
                        <h3 class="h4 mb-3">Post Recipe Online</h3>
                        <p class="text-muted">Share your culinary creations with our community. Upload photos, ingredients, and step-by-step instructions for others to discover and enjoy.</p>
                    </div>
                </div>

                <!-- AI Integrated -->
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="bg-white p-4 text-center h-100">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-robot fa-3x text-quaternary"></i>
                        </div>
                        <h3 class="h4 mb-3">AI Integrated</h3>
                        <p class="text-muted">Get personalized recipe recommendations and ingredient substitutions powered by advanced AI technology to enhance your cooking experience.</p>
                    </div>
                </div>

                <!-- Meal Planning -->
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class=" bg-white p-4 text-center h-100">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-calendar-alt fa-3x text-quaternary"></i>
                        </div>
                        <h3 class="h4 mb-3">Meal Planning</h3>
                        <p class="text-muted">Plan your weekly meals effortlessly. Organize your favorite recipes, create shopping lists, and maintain a balanced diet with our meal planning tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact d-flex justify-content-center align-items-center" id="homeContact">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-8" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="text-quaternary">Contact Us</h2>
                    <p class="lead">Get in touch with us for any questions or suggestions</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Contact Form -->
                <div class="col-md-6">
                    <form class="contact-form bg-white p-4 rounded">
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" placeholder="Your Name" required>
                                    <label for="floatingName">Your Name</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingEmail" placeholder="Your Email" required>
                                    <label for="floatingEmail">Your Email</label>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingSubject" placeholder="Subject" required>
                                    <label for="floatingSubject">Subject</label>
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="floatingMessage" placeholder="Your Message" style="height: 150px" required></textarea>
                                    <label for="floatingMessage">Your Message</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center">
                                <button type="submit" class="btn dishbutton px-5">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Google Maps -->
                <div class="col-md-6">
                    <div class="map-container rounded">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.802548850011!2d121.04882157489424!3d14.632645377687572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b7afe6a39331%3A0xd367e6dc5e274032!2sEastwood%20City!5e0!3m2!1sen!2sph!4v1709703543651!5m2!1sen!2sph"
                            width="100%"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-5">
        <div class="container py-4">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-4">
                    <img src="images/logo.png" alt="Dishcovery Logo" class="logo img-fluid" style="max-width: 150px;">
                </div>
                <div class="col-md-4 text-center">
                    <p class="mb-0">&copy; 2024 Dishcovery. All rights reserved.</p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="#" class="text-quaternary"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-quaternary"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-quaternary"><i class="fab fa-twitter fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>