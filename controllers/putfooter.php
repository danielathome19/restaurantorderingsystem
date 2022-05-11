<?php
function putFooter() {
    echo '<link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/animsition.min.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/bootstrap.min.css" rel="stylesheet"> 
		<div id="footer">
            <div style="padding: 50px; text-align: left;">
               <footer class="footer">
               <div class="container">
                  <!-- top footer statrs -->
                  <div class="row top-footer">
                     <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                        <a href="#"></a> <span>Online Restaurant Ordering </span>
                     </div>
                     <div class="col-xs-12 col-sm-2 about color-gray">
                        <h5>About Us</h5>
                        <ul>
                           <li><a href="#">About us</a> </li>
                           <li><a href="#">Our Team</a> </li>
                        </ul>
                     </div>
                     <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                        <h5>How it Works</h5>
                        <ul>
                           <li><a href="#">Choose restaurant</a> </li>
                           <li><a href="#">Choose meal</a> </li>
                           <li><a href="#">Pay via credit card</a> </li>
                            <li><a href="#">Enter your location</a> </li>
                           <li><a href="#">Wait for delivery</a> </li>
                        </ul>
                     </div>
                      <div class="col-xs-12 col-sm-3 payment-options color-gray">
                          <h5>Payment Options</h5>
                          <ul>
                              <li>
                                  <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                              </li>
                              <li>
                                  <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                              </li>
                          </ul>
                      </div>

                      <div class="col-xs-12 col-sm-4 address color-gray">
                          <h5>Address</h5>
                          <p>Whitewater, Wisconsin, USA</p>
                          <h5>Phone: (123) 456 7891</a></h5>
                      </div>
                  </div>
                  <!-- top footer ends -->
               </div>
            </footer>
                <p style="color: white;">Website design &copy; Restaurant Ordering System Team (COMPSCI 776) '.date("Y").'</p>
            </div>
        </div>
		';
}
?>
