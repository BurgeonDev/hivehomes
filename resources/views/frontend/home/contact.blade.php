  <section id="landingContact" class="section-py bg-body landing-contact">
      <div class="container">
          <div class="mb-4 text-center">
              <span class="badge bg-label-primary">Contact US</span>
          </div>
          <h4 class="mb-1 text-center">
              <span class="position-relative fw-extrabold z-1">Let's Connect
                  <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="laptop charging"
                      class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
              </span>
              together
          </h4>
          <p class="mb-12 text-center pb-md-4">Any question or remark? just write us a message</p>
          <div class="row g-6">
              <div class="col-lg-5">
                  <div class="p-2 border contact-img-box position-relative h-100">
                      <img src="{{ asset('assets/img/front-pages/icons/contact-border.png') }}" alt="contact border"
                          class="contact-border-img position-absolute d-none d-lg-block scaleX-n1-rtl" />
                      <img src="{{ asset('assets/img/front-pages/landing-page/contact-customer-service.png') }}"
                          alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl" />
                      <div class="p-4 pb-2">
                          <div class="row g-4">
                              <div class="col-md-6 col-lg-12 col-xl-6">
                                  <div class="d-flex align-items-center">
                                      <div class="rounded badge bg-label-primary p-1_5 me-3">
                                          <i class="icon-base ti tabler-mail icon-lg"></i>
                                      </div>
                                      <div>
                                          <p class="mb-0">Email</p>
                                          <h6 class="mb-0">
                                              <a href="mailto:example@gmail.com" class="text-heading">
                                                  info@burgeon-grp.com</a>
                                          </h6>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6 col-lg-12 col-xl-6">
                                  <div class="d-flex align-items-center">
                                      <div class="rounded badge bg-label-success p-1_5 me-3">
                                          <i class="icon-base ti tabler-phone-call icon-lg"></i>
                                      </div>
                                      <div>
                                          <p class="mb-0">Phone</p>
                                          <h6 class="mb-0"><a href="tel:+1234-568-963"
                                                  class="text-heading">+92-333-134-2525</a></h6>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-7">
                  <div class="card h-100">
                      <div class="card-body">
                          <h4 class="mb-2">Send a message</h4>

                          <form method="POST" action="{{ route('contact.store') }}">
                              @csrf
                              <div class="row g-4">
                                  <div class="col-md-6">
                                      <label class="form-label">Full Name</label>
                                      <input type="text" class="form-control" name="name" required
                                          placeholder="john" />
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label">Phone</label>
                                      <input type="text" class="form-control" name="phone" required
                                          placeholder="+92-312-1234567" />
                                  </div>
                                  <div class="col-md-12">
                                      <label class="form-label">Email</label>
                                      <input type="email" class="form-control" name="email" required
                                          placeholder="johndoe@gmail.com" />
                                  </div>


                                  <div class="col-12">
                                      <label class="form-label">Message</label>
                                      <textarea class="form-control" name="message" required rows="7" placeholder="Write a message"></textarea>
                                  </div>
                                  <div class="col-12">
                                      <button type="submit" class="btn btn-primary">Send inquiry</button>
                                  </div>
                              </div>
                          </form>

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
