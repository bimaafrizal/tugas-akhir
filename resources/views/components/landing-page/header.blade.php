  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
      <div class="container d-flex justify-content-between align-items-center">

          <div class="logo">
              <a href="/">
                  @if ($page->logo != null)
                  <img class="img-thumbnail" src="{{ asset($page->logo) }}" alt="" style="max-height: 40px">
                  @else
                  <h1>
                      SoftLand
                  </h1>
                  @endif
              </a>
              <!-- Uncomment below if you prefer to use an image logo -->
              <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
          </div>

          <nav id="navbar" class="navbar">
              <ul>
                  <li><a class="active " href="/">Home</a></li>
                  <li><a href="/blog">Blog</a></li>
                  @guest
                  <li><a href="/login">Login</a></li>
                  @else
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                          aria-expanded="false">Welcome back, {{ auth()->user()->name }}</a>
                      <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="/dashboard"> My Dashboard</a></li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                          <li>
                              <form action="/logout" method="POST">
                                  @csrf
                                  <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                                      Logout</button>
                              </form>
                          </li>
                      </ul>
                  </li>
                  @endguest
              </ul>
              <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->

      </div>
  </header><!-- End Header -->
