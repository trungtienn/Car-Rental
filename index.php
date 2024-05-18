<?php
session_start();
include ('components/config.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Car Rental</title>
    <link rel="stylesheet" href="style_source/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <!--Header-->
    <?php include ('components/header.php'); ?>
    <!-- /Header -->

    <!-- Banners -->
    <section id="banner" class="banner-section">
        <div class="container">
            <div class="div_zindex">
                <div class="row">
                    <div class="col-md-5 col-md-push-7">
                        <div class="banner_content">
                            <h1>&nbsp;</h1>
                            <p>&nbsp; </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Banners -->

    <!-- Resent Cat-->
    <section class="section-padding gray-bg">
        <div class="container">
            <div class="section-header text-center">
                <h2>BEST CAR <span>With Good Price</span></h2>
            </div>
            <div class="row">

                <!-- Recently Listed Cars -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="resentnewcar">

                        <?php $sql = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,tblvehicles.Vimage1 from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand limit 9";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                ?>

                                <div class="col-list-3">
                                    <div class="recent-car-list">
                                        <div class="car-box"> <a
                                                href="vehical-detail.php?vhid=<?php echo htmlentities($result->id); ?>"><img
                                                    src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>"
                                                    alt="image" class="car_img"></a>
                                            <ul>
                                                <li><i class="fa fa-car"
                                                        aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?>
                                                </li>
                                                <li><i class="fa fa-calendar"
                                                        aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?>
                                                    Model</li>
                                                <li><i class="fa fa-user"
                                                        aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?>
                                                    seats</li>
                                            </ul>
                                        </div>
                                        <div class="car-title">
                                            <h6><a href="vehical-detail.php?vhid=<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->VehiclesTitle); ?></a></h6>
                                            <span class="price">$<?php echo htmlentities($result->PricePerDay); ?> /Day</span>
                                        </div>
                                        <div class="inventory_info_m">
                                            <p><?php echo substr($result->VehiclesOverview, 0, 70); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>

                    </div>
                </div>
            </div>
    </section>
    <!-- /Resent Car -->



    <!--Footer -->
    <?php include ('components/footer.php'); ?>
    <!-- /Footer-->

    <!--Login-Form -->
    <?php include ('components/login.php'); ?>
    <!--/Login-Form -->

    <!--Register-Form -->
    <?php include ('components/registration.php'); ?>

    <!--Forgot-password-Form -->
    <?php include ('components/forgotpassword.php'); ?>
    <!--/Forgot-password-Form -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>