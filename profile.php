<?php
session_start();
error_reporting(0);
include ('components/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
  if (isset($_POST['updateprofile'])) {
    $name = $_POST['fullname'];
    $mobileno = $_POST['mobilenumber'];
    $dob = $_POST['dob'];
    $adress = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $email = $_SESSION['login'];
    $sql = "update tblusers set FullName=:name,ContactNo=:mobileno,dob=:dob,Address=:adress,City=:city,Country=:country where EmailId=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':adress', $adress, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':country', $country, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $msg = "Profile Updated Successfully";
  }

  ?>
  <!DOCTYPE HTML>
  <html lang="en">

  <head>
    <link rel="stylesheet" href="style_source/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
      }

      .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
      }
    </style>
  </head>

  <body>
    <!--Header-->
    <?php include ('components/header.php'); ?>
    <!-- /Header -->
    <!--Page Header-->
    <section class="page-header listing_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>My Profile</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- /Page Header-->


    <?php
    $useremail = $_SESSION['login'];
    $sql = "SELECT * from tblusers where EmailId=:useremail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
      foreach ($results as $result) { ?>
        <section class="user_profile inner_pages">
          <div class="container">
            <div class="user_profile_info gray-bg">
            </div>

            <div class="dealer_info">
              <h5><?php echo htmlentities($result->FullName); ?></h5>
              <p><?php echo htmlentities($result->Address); ?><br>
                <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country); ?></p>
            </div>
          </div>
          <div class="update_pass_section">
            <div class="row">
              <div class="col-md-12 col-sm-8">
                <div class="profile_wrap">
                  <h5 class="uppercase underline">Genral Settings</h5>
                  <?php
                  if ($msg) { ?>
                    <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                  <form method="post">
                    <div class="form-group">
                      <label class="control-label">Reg Date -</label>
                      <?php echo htmlentities($result->RegDate); ?>
                    </div>
                    <?php if ($result->UpdationDate != "") { ?>
                      <div class="form-group">
                        <label class="control-label">Last Update at -</label>
                        <?php echo htmlentities($result->UpdationDate); ?>
                      </div>
                    <?php } ?>
                    <div class="form-group">
                      <label class="control-label">Full Name</label>
                      <input class="form-control white_bg" name="fullname"
                        value="<?php echo htmlentities($result->FullName); ?>" id="fullname" type="text" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Email Address</label>
                      <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId); ?>"
                        name="emailid" id="email" type="email" required readonly>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Phone Number</label>
                      <input class="form-control white_bg" name="mobilenumber"
                        value="<?php echo htmlentities($result->ContactNo); ?>" id="phone-number" type="text" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Date of Birth&nbsp;(dd/mm/yyyy)</label>
                      <input class="form-control white_bg" value="<?php echo htmlentities($result->dob); ?>" name="dob"
                        placeholder="dd/mm/yyyy" id="birth-date" type="text">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Your Address</label>
                      <textarea class="form-control white_bg" name="address"
                        rows="4"><?php echo htmlentities($result->Address); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Country</label>
                      <input class="form-control white_bg" id="country" name="country"
                        value="<?php echo htmlentities($result->City); ?>" type="text">
                    </div>
                    <div class="form-group">
                      <label class="control-label">City</label>
                      <input class="form-control white_bg" id="city" name="city"
                        value="<?php echo htmlentities($result->City); ?>" type="text">
                    </div>
                  <?php }
    } ?>

                <div class="form-group">
                  <button type="submit" name="updateprofile" class="btn button-50">Save Changes <span class="angle_arrow"><i
                        class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/Profile-setting-->

    <<!--Footer -->
      <?php include ('components/footer.php'); ?>
      <!-- /Footer-->

      <!--Login-Form -->
      <?php include ('components/login.php'); ?>
      <!--/Login-Form -->

      <!--Register-Form -->
      <?php include ('components/registration.php'); ?>

      <!--/Register-Form -->

      <!--Forgot-password-Form -->
      <?php include ('components/forgotpassword.php'); ?>
      <!--/Forgot-password-Form -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>

  </html>
<?php } ?>