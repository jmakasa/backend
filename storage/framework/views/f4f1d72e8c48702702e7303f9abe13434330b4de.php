<!-- Footer -->
<footer class="footer">
      <!-- Footer Links -->
      <div class="container">

        <!-- Grid row -->
        <div class="row">

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold">AKASA</h6>
            <form id="switch-lang-form" action="<?php echo e(route('switch-lang')); ?>" method="POST" ><?php echo csrf_field(); ?>
            <select name="locale" class="language-select" onchange="this.form.submit()">
            <?php $__currentLoopData = Config::get('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($locale); ?>" <?php echo e(($locale == app()->getLocale() ? " selected" : "")); ?>><i class="fa fa-globe"></i><?php echo e($lang[$locale]); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            </form>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Company</h6>
            <ul class="list-unstyled">
              <li><a class="dark-grey-text" href="<?php echo e(route('home.aboutus',app()->getLocale())); ?>">About Akasa</a></li>
              <li><a class="dark-grey-text" href="#">Where to Buy</a></li>
              <li><a class="dark-grey-text" href="#">Contact Us</a></li>
              <li><a class="dark-grey-text" href="#!">Giving Back</a></li>
            </ul>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Support</h6>
            <ul class="list-unstyled">
              <li><a class="dark-grey-text" href="#">Legacy Products</a></li>
              <li><a class="dark-grey-text" href="#!">Knowledge Base</a></li>
              <li><a class="dark-grey-text" href="#!">FAQ</a></li>
              <li><a class="dark-grey-text" href="#!">Downloads</a></li>
            </ul>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Community</h6>
            <ul class="list-unstyled">
              <li><a class="dark-grey-text" href="#!">Forum</a></li>
              <li><a class="dark-grey-text" href="#!">Press and Media</a></li>
            </ul>  
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-4 mb-md-0 mb-4">

            <!-- Links -->
            <h6 class="text-uppercase">CONTACT WITH US</h6>
            <div class="subscribe-wrapper">
              <div class="subscribe-form">
                <form action="#">
                  <input placeholder="email@example.com" type="text">
                  <button class="btn btn-outline-danger">subscribe <i class="fa fa-envelope"></i></button>
                </form>
              </div>
            </div>
            <div class="subscribe-check form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
              <label class="form-check-label" for="inlineCheckbox1">Subscribe Now! Free Alerts on newly added products</label>
            </div>
     
            <ul class="social list-unstyled">
              <li><a href="https://www.facebook.com/akasa.com.tw" target="_blank" class="iconFacebook"><i class="fa fa-facebook"></i></a></li> 
              <li><a href="https://twitter.com/akasa_tech" target="_blank" class="iconFacebook"><i class="fa fa-twitter"></i></a></li> 
              <li><a href="https://www.instagram.com/akasa_tech/" target="_blank" class="iconFacebook"><i class="fa fa-instagram"></i></a></li> 
              <li><a href="https://www.youtube.com/channel/UCc_ybZvt6lC7PF8wvGGp1jw" target="_blank" class="iconFacebook"><i class="fa fa-youtube"></i></a></li>
            </ul>
            
          </div>
          <!-- Grid column -->

        </div>
        <!-- Grid row -->
      
      

        <!-- Copyright -->
        <!--  <div class="copyright">© Akasa All Right Reserved. Akasa® is trading style of Akasa group of companies.</div> -->
        <div style="border-top: 1px solid #cccccc; padding: 1em 0; font-size: 13px">
          <div class="float-start">© Akasa All Right Reserved.</div>
          <div class="float-end">
            <ul class="list-inline">
              <li class="list-inline-item"><a href="#">Privacy Pollicy</a></li>| <li class="list-inline-item"><a href="#">Sitemap</a></li>
            </ul>
          </div>
        </div>
        <!-- Copyright -->
      </div>
      <!-- Footer Links -->
    </footer>
    <a href="#" class="back-to-top" id="btn-back-to-top"><i class="fa fa-chevron-up"></i></a>
<?php /**PATH /akasa/www/backend/resources/views/layouts/akasa_footer.blade.php ENDPATH**/ ?>