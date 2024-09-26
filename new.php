<?php session_start() ?>
<?php

if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

?>

<?php
if ($_SESSION['usertype'] == "normaluser") {
    include("./inc/mainheader.php");
} else if ($_SESSION['usertype'] == "SystemAdmin") {
    include("./inc/adminheader.php");
} else if ($_SESSION['usertype'] == "operational") {
    include("./inc/opheader.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Gallery Cafe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: #fff;
            padding: 60px 0;
            text-align: center;
        }

        .header h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .section {
            padding: 50px 0;
        }

        .section h3 {
            color: #007bff;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .section p {
            color: #555;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 25px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
            background-color: #fff;
        }

        .card-custom img {
            border-bottom: 5px solid #007bff;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <h2>Welcome to the Gallery Cafe</h2>
        </div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card-custom">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348" class="img-fluid" alt="Coffee">
                        <div class="card-body">
                            <h3>Check Our Meals! <span class="badge bg-success">New</span></h3>
                            <p>Discover a variety of delicious meals prepared with the finest ingredients.</p>
                            <button class="btn btn-custom">Check Meals</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom">
                        <img src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90" class="img-fluid" alt="Burger">
                        <div class="card-body">
                            <h3>Special Food & Beverages <span class="badge bg-danger">HOT</span></h3>
                            <p>Enjoy our special dishes and refreshing beverages that will tantalize your taste buds.</p>
                            <button class="btn btn-custom">Explore Specials</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom">
                        <img src="https://images.unsplash.com/photo-1562183247-64e28c7730f9" class="img-fluid" alt="Reservation">
                        <div class="card-body">
                            <h3>Make a Reservation! <span class="badge bg-success">New</span></h3>
                            <p>Reserve your table today and enjoy an unforgettable dining experience.</p>
                            <button class="btn btn-custom">Reserve Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card-custom">
                        <img src="https://images.unsplash.com/photo-1542744095-291d1f67b221" class="img-fluid" alt="Community">
                        <div class="card-body">
                            <h3>Join Our Community! <span class="badge bg-primary">Join</span></h3>
                            <p>Become a part of our vibrant community and enjoy exclusive benefits and events.</p>
                            <button class="btn btn-custom">Join Now</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-custom">
                        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7" class="img-fluid" alt="Events">
                        <div class="card-body">
                            <h3>Upcoming Events! <span class="badge bg-warning">Exciting</span></h3>
                            <p>Stay tuned for our upcoming events and enjoy a memorable time with us.</p>
                            <button class="btn btn-custom">View Events</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>