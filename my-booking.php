<?php
session_start();
error_reporting(0);
include ('components/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
  ?><!DOCTYPE HTML>
  <html lang="en">

  <head>

    <link rel="stylesheet" href="style_source/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  </head>

  <body>
    <!--Header-->
    <?php include ('components/header.php'); ?>
    <!--Page Header-->
    <!-- /Header -->

    <!--Page Header-->
    <section class="page-header listing_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>My Booking</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- /Page Header-->
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-sm-8">
             
                <h5 class="textUppercase">My Booking List:</h5>
                <div class="my_vehicles_list">
                  <ul class="vehicle_listing">
                    <?php
                    $useremail = $_SESSION['login'];
                    $sql = "SELECT tblvehicles.Vimage1 as Vimage1,tblvehicles.VehiclesTitle,tblvehicles.id as vid,tblbrands.BrandName,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.Status,tblvehicles.PricePerDay,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays,tblbooking.BookingNumber  from tblbooking join tblvehicles on tblbooking.VehicleId=tblvehicles.id join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblbooking.userEmail=:useremail order by tblbooking.id desc";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                      foreach ($results as $result) { ?>

                        <li>
                          <h4 style="color:red">Booking No #<?php echo htmlentities($result->BookingNumber); ?></h4>
                          <div class="vehicle_img"> <a
                              href="vehical-detail.php?vhid=<?php echo htmlentities($result->vid); ?>"><img
                                src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="image"></a>
                          </div>
                          <div class="vehicle_title">

                            <h6><a href="vehical-detail.php?vhid=<?php echo htmlentities($result->vid); ?>">
                                <?php echo htmlentities($result->BrandName); ?> ,
                                <?php echo htmlentities($result->VehiclesTitle); ?></a></h6>
                            <p><b>From </b> <?php echo htmlentities($result->FromDate); ?> <b>To </b>
                              <?php echo htmlentities($result->ToDate); ?></p>
                            <div style="float: left">
                              <p><b>Message:</b> <?php echo htmlentities($result->message); ?> </p>
                            </div>
                          </div>
                          <?php if ($result->Status == 1) { ?>
                            <div class="vehicle_status"> <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                              <div class="clearfix"></div>
                            </div>

                          <?php } else if ($result->Status == 2) { ?>
                              <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Cancelled</a>
                                <div class="clearfix"></div>
                              </div>



                          <?php } else { ?>
                              <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Not Confirm yet</a>
                                <div class="clearfix"></div>
                              </div>
                          <?php } ?>

                        </li>

                        <h4>Invoice</h4>
                        <table>
                          <tr>
                            <th>Car Name</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Total Days</th>
                            <th>Rent / Day</th>
                          </tr>
                          <tr>
                            <td><?php echo htmlentities($result->VehiclesTitle); ?>,
                              <?php echo htmlentities($result->BrandName); ?>
                            </td>
                            <td><?php echo htmlentities($result->FromDate); ?></td>
                            <td> <?php echo htmlentities($result->ToDate); ?></td>
                            <td><?php echo htmlentities($tds = $result->totaldays); ?></td>
                            <td> <?php echo htmlentities($ppd = $result->PricePerDay); ?></td>
                          </tr>
                          <tr>
                            <th colspan="4" style="text-align:center;"> Grand Total</th>
                            <th><?php echo htmlentities($tds * $ppd); ?></th>
                          </tr>
                        </table>
                        <hr />
                      <?php }
                    } else { ?>
                      <h5 align="center" style="color:red">No booking yet</h5>
                    <?php } ?>
                  </ul>
                </div>
            </div>
          </div>
        </div>
    </section>
    <!--/my-vehicles-->
    <?php include ('components/footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>

  </html>
<?php } ?>