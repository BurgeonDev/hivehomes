  <footer class="landing-footer bg-body footer-text">
      <div class="overflow-hidden footer-top position-relative z-1">
          <img src="{{ asset('assets/img/front-pages/backgrounds/footer-bg.png') }}" alt="footer bg"
              class="footer-bg banner-bg-img z-n1" />
          <div class="container">
              <div class="row gx-0 gy-6 g-lg-10">
                  <div class="col-lg-5">
                      <a href="landing-page.html" class="mb-6 app-brand-link">
                          <span class="app-brand-logo demo">
                              <span class="text-primary">
                                  <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                          fill="currentColor" />
                                      <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                          d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                          fill="#161616" />
                                      <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                          d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                          fill="#161616" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                          fill="currentColor" />
                                  </svg>
                              </span>
                          </span>
                          <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">HiveHomes</span>
                      </a>
                      <p class="mb-6 footer-text footer-logo-description">
                          Designed and Developed by
                          <a href="https://burgeon-grp.com" target="_blank" rel="noopener noreferrer">
                              Burgeon Group
                          </a>.
                      </p>

                      {{-- <form class="footer-form">
                          <label for="footer-email" class="small">Subscribe to newsletter</label>
                          <div class="mt-1 d-flex">
                              <input type="email"
                                  class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                                  id="footer-email" placeholder="Your email" />
                              <button type="submit"
                                  class="shadow-none btn btn-primary rounded-0 rounded-end-bottom rounded-end-top">
                                  Subscribe
                              </button>
                          </div>
                      </form> --}}
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6">
                      <h6 class="mb-6 footer-title">Pages</h6>
                      <ul class="list-unstyled">
                          <li class="mb-4">
                              <a href="{{ route('home') }}" class="footer-link">Home</a>
                          </li>
                          <li class="mb-4">
                              <a href="{{ route('faq') }}" class="footer-link">FAQ's</a>
                          </li>
                          <li class="mb-4">
                              <a href="{{ route('contact') }}" class="footer-link">Contact Us</a>
                          </li>


                      </ul>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6">
                      <h6 class="mb-6 footer-title">Terms &amp; Conditions</h6>
                      <ul class="list-unstyled">
                          <li class="mb-4">
                              <a href="{{ route('terms') }}" class="footer-link">Terms of Service</a>
                          </li>
                          <li class="mb-4">
                              <a href="{{ route('policy') }}" class="footer-link">Privacy Policy</a>
                          </li>

                      </ul>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6">
                      <h6 class="mb-6 footer-title">Contact Us</h6>
                      <ul class="list-unstyled">
                          <li class="mb-4">
                              <a href="mailto:info@burgeon-grp.com" class="footer-link">
                                  <i class="menu-icon icon-base ti tabler-mail me-2"></i> info@burgeon-grp.com
                              </a>
                          </li>
                          <li class="mb-4">
                              <a href="tel:+923331342525" class="footer-link">
                                  <i class="menu-icon icon-base ti tabler-phone me-2"></i> +92-333-134-2525
                              </a>
                          </li>
                      </ul>
                  </div>



              </div>
          </div>
      </div>

  </footer>
