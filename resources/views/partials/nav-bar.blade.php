  <div>
      <header>
          <nav id="navbar" class="navbar fixed-top navbar-expand-md {{request() -> is('supported-events*') || request()->is('contacts*') ? 'otherpages-nav':''}}">
              <div class="container-fluid mx-md-3 mx-lg-3 mx-xl-5">
                  <a class="navbar-brand" href="/">
                      <img src="{{ asset('img/eventsdon.svg') }}" alt="EventsDon Logo" style="width:160px; height:30px">
                  </a>

                  <div class="d-flex gap-2">
                      @if (Route::has('login'))
                          @auth
                              <button id="mobile-signin-button" class="navbar-toggler" type="button"
                                  data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                  aria-controls="navbarSupportedContent" aria-expanded="false"
                                  aria-label="Toggle navigation">
                                  <i class="bi bi-list"></i>
                              </button>
                          @else
                              <a class="p-2 nav-link fw-bold active ms-3 d-none d-sm-block d-md-none" aria-current="page"
                                  href="{{ route('login') }}">
                                  Log In</a>

                              <a class="p-2
                                            nav-link fw-bold
                                            active
                                            ms-3
                                            rounded
                                            signin
                                            d-none d-sm-block d-md-none
                                        "
                                  aria-current="page" href="{{ route('register') }}"><i class="bi bi-person"></i>
                                  Sign Up</a>


                              <button id="mobile-signin-button" class="navbar-toggler" type="button"
                                  data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                  aria-controls="navbarSupportedContent" aria-expanded="false"
                                  aria-label="Toggle navigation">
                                  <i class="bi bi-list"></i>
                              </button>


                          @endauth
                      @endif

                  </div>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">

                      @if (Route::has('login'))
                          <ul class="navbar-nav mb-2 mb-lg-0 text-center ms-auto pt-5 pt-sm-0">


                              <li class="nav-item pb-2 pb-lg-0 ">
                                  <a class="nav-link fw-bold " href="/#about-us">
                                      About

                                  </a>

                              </li>

                              <li class="nav-item pb-2 pb-lg-0 ">
                                  <a class="nav-link fw-bold " href="/#features">
                                      Features
                                  </a>
                              </li>

                              <li class="nav-item pb-2 pb-lg-0 ">
                                <a class="nav-link fw-bold " href="/supported-events">
                                    Events
                                </a>
                            </li>

                              <li class="nav-item pb-2 pb-lg-0 ">
                                  <a class="nav-link fw-bold " href="/#pricing">
                                      Pricing </a>
                              </li>

                              <li class="nav-item pb-2 pb-lg-0 ">
                                  <a class="nav-link fw-bold " href="/contacts">
                                      Contact Us </a>
                              </li>
                              @auth
                                  <li class="nav-item pb-2 pb-lg-0 create ms-3">
                                      @php
                                          $route = '';
                                          $label = '';
                                          
                                          switch (auth()->user()->role) {
                                              case 'client':
                                                  $route = route('events.create');
                                                  $label = 'Create an event';
                                                  break;
                                          
                                              case 'teller':
                                              case 'client_admin':
                                                  $route = route('events.index');
                                                  $label = 'Dashboard';
                                                  break;
                                          
                                              default:
                                                  $route = route('admin.home');
                                                  $label = 'Visit Dashboard';
                                                  break;
                                          }
                                      @endphp
                                      <a class="nav-link active" aria-current="page"
                                          href="{{ $route }}">{{ $label }}</a>
                                  </li>
                              @else
                                  <li class="nav-item pb-2 pb-lg-0 mx-auto p-0 ms-md-4 d-sm-none d-md-block">
                                      <a class="p-2
                                            nav-link fw-bold
                                            active
                                            ms-3

                                        "
                                          aria-current="page" href="{{ route('login') }}">
                                          Log In</a>
                                  </li>
                                  <li class="nav-item pb-2 pb-lg-0 mx-auto p-0 d-sm-none d-md-block">
                                      <a class="p-2
                                            nav-link fw-bold
                                            active
                                            ms-3
                                            rounded
                                            signin
                                        "
                                          aria-current="page" href="{{ route('register') }}"><i class="bi bi-person"></i>
                                          Sign Up</a>
                                  </li>
                              @endauth
                          </ul>
                      @endif
                  </div>
              </div>
          </nav>


      </header>
  </div>
