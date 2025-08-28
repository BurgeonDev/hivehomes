@extends('frontend.layouts.app')
@section('title', 'Terms & Conditions ')

@section('content')

    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 300px;">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">

        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Terms and Conditions</li>
                </ol>
            </nav>
        </div>
    </section>
    <section id="landingTerms" class="section-py bg-body landing-terms">
        <div class="container">
            <!-- Policy 2 -->
            <div class="card accordion-item">
                <h2 class="text-center accordion-header" id="policyTwo">
                    <button type="button" class="accordion-button justify-content-center" data-bs-toggle="collapse"
                        data-bs-target="#collapsePolicyTwo" aria-expanded="true" aria-controls="collapsePolicyTwo">
                        <i class="icon-base ti tabler-file-description me-2"></i>
                        Terms & Conditions
                    </button>
                </h2>

                <div id="collapsePolicyTwo" class="accordion-collapse collapse show" aria-labelledby="policyTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- Header -->
                        <div class="p-4 p-md-5 border-bottom">
                            <div class="flex-wrap gap-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1">Terms & Conditions of Use for <span class="fw-bold">HiveHomes</span>
                                    </h5>
                                    <div class="text-body-secondary small">Last Updated: <span class="fw-medium">August
                                            2025</span></div>
                                </div>
                                <span class="badge bg-label-info">Community Guidelines</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="row g-0">
                            <!-- TOC -->
                            <aside class="col-lg-4 col-xl-3 border-end">
                                <div class="top-0 p-4 position-sticky" style="z-index:1">
                                    <div class="mb-2 text-uppercase text-body-secondary small">Contents</div>
                                    <ol class="mb-0 list-unstyled policy-toc">
                                        <li><a href="#tc-1" class="policy-link">1. Acceptance of Terms</a></li>
                                        <li><a href="#tc-2" class="policy-link">2. Eligibility & Registration</a></li>
                                        <li><a href="#tc-3" class="policy-link">3. License to Use</a></li>
                                        <li><a href="#tc-4" class="policy-link">4. User Conduct</a></li>
                                        <li><a href="#tc-5" class="policy-link">5. User Content License</a></li>
                                        <li><a href="#tc-6" class="policy-link">6. Moderation & Enforcement</a></li>
                                        <li><a href="#tc-7" class="policy-link">7. Intellectual Property</a></li>
                                        <li><a href="#tc-8" class="policy-link">8. Disclaimers & Liability</a></li>
                                        <li><a href="#tc-9" class="policy-link">9. Indemnification</a></li>
                                        <li><a href="#tc-10" class="policy-link">10. Termination</a></li>
                                        <li><a href="#tc-11" class="policy-link">11. Governing Law</a></li>
                                        <li><a href="#tc-12" class="policy-link">12. Changes to Terms</a></li>
                                        <li><a href="#tc-13" class="policy-link">13. Contact Information</a></li>
                                    </ol>
                                </div>
                            </aside>

                            <!-- Body -->
                            <article class="col-lg-8 col-xl-9">
                                <div class="p-4 p-md-5 policy-doc">

                                    <section id="tc-1" class="mb-5">
                                        <h6 class="mb-2">1. Acceptance of Terms</h6>
                                        <p class="mb-0">
                                            This Agreement governs your use of the HiveHomes web application. By
                                            registering, accessing, or using the Service,
                                            you agree to be bound by these Terms and our Privacy Policy. If you do not
                                            agree, you may not use the Service.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-2" class="mb-5">
                                        <h6 class="mb-2">2. Eligibility & Account Registration</h6>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li class="mb-2"><span class="fw-medium">Eligibility:</span> Only residents
                                                and property owners of HiveHomes, aged 18+, may register.</li>
                                            <li class="mb-2"><span class="fw-medium">Accurate Information:</span> You
                                                agree to provide and maintain accurate details during registration.</li>
                                            <li class="mb-2"><span class="fw-medium">Account Security:</span> You are
                                                responsible for safeguarding your password and notifying admins of any
                                                unauthorized access.</li>
                                            <li><span class="fw-medium">One Account per Unit:</span> Normally one account
                                                per residence; extra family accounts may be granted at admins’ discretion.
                                            </li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-3" class="mb-5">
                                        <h6 class="mb-2">3. License to Use</h6>
                                        <p class="mb-0">
                                            You are granted a limited, non-exclusive, non-transferable, revocable license to
                                            use HiveHomes for personal,
                                            non-commercial purposes, subject to compliance with this Agreement.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-4" class="mb-5">
                                        <h6 class="mb-2">4. User Conduct & Content Guidelines</h6>
                                        <p class="mb-3">You agree not to upload, post, or share User Content that:</p>
                                        <ul class="mb-3 list-unstyled ps-3">
                                            <li>Is unlawful, harmful, abusive, defamatory, obscene, or objectionable.</li>
                                            <li>Constitutes hate speech or discrimination of any form.</li>
                                            <li>Violates intellectual property rights.</li>
                                            <li>Is false, misleading, or impersonates others.</li>
                                            <li>Contains spam, advertisements, or unauthorized promotions.</li>
                                            <li>Shares private information without consent.</li>
                                            <li>Contains malicious code or viruses.</li>
                                        </ul>
                                        <div class="mb-2 fw-medium">Marketplace Rules</div>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li>Buy/sell feature is for personal items only — no commercial sales.</li>
                                            <li>Transactions are solely between buyer and seller; HiveHomes assumes no
                                                liability.</li>
                                            <li>Members must transact safely and respectfully.</li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-5" class="mb-5">
                                        <h6 class="mb-2">5. User Content License</h6>
                                        <p class="mb-0">
                                            By posting, you grant HiveHomes a royalty-free, non-exclusive, perpetual license
                                            to use, display, and
                                            distribute content within the community app.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-6" class="mb-5">
                                        <h6 class="mb-2">6. Moderation & Enforcement</h6>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li>We may monitor, review, and moderate content.</li>
                                            <li>We may remove or edit content that violates this Agreement.</li>
                                            <li>We may warn, suspend, or terminate accounts at our discretion.</li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-7" class="mb-5">
                                        <h6 class="mb-2">7. Intellectual Property</h6>
                                        <p class="mb-0">
                                            All original features, design, and content of HiveHomes are intellectual
                                            property of the Management Committee
                                            or licensors, protected under copyright and other applicable laws.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-8" class="mb-5">
                                        <h6 class="mb-2">8. Disclaimer & Limitation of Liability</h6>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li>The Service is provided "AS IS" without warranties of any kind.</li>
                                            <li>We do not guarantee uninterrupted or error-free operation.</li>
                                            <li>We are not liable for indirect, incidental, or consequential damages,
                                                including those from user interactions, marketplace transactions, or
                                                unauthorized access.</li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-9" class="mb-5">
                                        <h6 class="mb-2">9. Indemnification</h6>
                                        <p class="mb-0">
                                            You agree to defend, indemnify, and hold HiveHomes harmless against any claims,
                                            losses, or liabilities
                                            resulting from your use of the Service, your violation of this Agreement, or
                                            your User Content.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-10" class="mb-5">
                                        <h6 class="mb-2">10. Termination</h6>
                                        <p class="mb-0">
                                            We may suspend or terminate your account without notice if you breach this
                                            Agreement. Upon termination,
                                            your right to use the Service ceases immediately.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-11" class="mb-5">
                                        <h6 class="mb-2">11. Governing Law & Dispute Resolution</h6>
                                        <p class="mb-0">
                                            These Terms are governed by applicable laws. Disputes will first be attempted to
                                            be resolved amicably
                                            through the Society Management Committee.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-12" class="mb-5">
                                        <h6 class="mb-2">12. Changes to Terms</h6>
                                        <p class="mb-0">
                                            We may update Terms from time to time by posting the revised version with a new
                                            "Last Updated" date.
                                            Continued use of the Service after changes means you accept them.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="tc-13" class="mb-4">
                                        <h6 class="mb-2">13. Contact Information</h6>
                                        <address class="mb-0">
                                            <div class="fw-medium">The Management Committee of HiveHomes</div>
                                            <div>Email: <a href="mailto:info@burgeon-grp.com">info@burgeon-grp.com</a>
                                            </div>
                                        </address>
                                    </section>

                                    <div class="pt-2 d-flex align-items-center justify-content-between">
                                        <small class="text-body-secondary">Please follow these Terms to keep HiveHomes
                                            respectful and safe.</small>
                                        <a href="#policyTwo" class="btn btn-sm btn-outline-primary">Back to top</a>
                                    </div>

                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
