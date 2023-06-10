  <!-- ======= Footer ======= -->
  <footer class="footer" role="contentinfo">
    <hr>
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <h3>Tentang Awas Bencana</h3>
          <p>{{ $page->footer }}</p>
          <p class="social">
            <a href="{{ $page->twitter != null ? $page->twitter : '#' }}"><span class="bi bi-twitter"></span></a>
            <a href="{{ $page->facebook != null ? $page->facebook : '#' }}"><span class="bi bi-facebook"></span></a>
            <a href="{{ $page->instagram  != null ? $page->instagram : '#' }}"><span class="bi bi-instagram"></span></a>
            <a href="{{ $page->linkedin != null ? $page->linkedin : '#' }}"><span class="bi bi-linkedin"></span></a>
          </p>
        </div>
        {{-- <div class="col-md-7 ms-auto">
          <div class="row site-section pt-0">
            <div class="col-md-4 mb-4 mb-md-0">
              <h3>Navigation</h3>
              <ul class="list-unstyled">
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Features</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
              <h3>Services</h3>
              <ul class="list-unstyled">
                <li><a href="#">Team</a></li>
                <li><a href="#">Collaboration</a></li>
                <li><a href="#">Todos</a></li>
                <li><a href="#">Events</a></li>
              </ul>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
              <h3>Downloads</h3>
              <ul class="list-unstyled">
                <li><a href="#">Get from the App Store</a></li>
                <li><a href="#">Get from the Play Store</a></li>
              </ul>
            </div>
          </div>
        </div> --}}
      </div>

      <div class="row justify-content-center text-center">
        <div class="col-md-7">
          <p class="copyright">&copy;2023 Awas Bencana</p>
          <div class="credits">
  
          </div>
        </div>
      </div>

    </div>
  </footer>