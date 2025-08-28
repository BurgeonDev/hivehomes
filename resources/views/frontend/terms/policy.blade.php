@extends('frontend.layouts.app')
@section('title', 'Policies ')
@section('page-css')
    <style>
        .policy-toc li+li {
            margin-top: .25rem;
        }

        .policy-link {
            text-decoration: none;
        }

        .policy-link:hover {
            text-decoration: underline;
        }

        .policy-doc h6 {
            font-weight: 700;
            letter-spacing: .2px;
        }

        .policy-doc hr {
            opacity: .08;
        }

        @media (max-width: 991.98px) {
            .policy-doc {
                padding-top: 1rem !important;
            }
        }
    </style>

@endsection

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
                    <li class="breadcrumb-item active text-dark" aria-current="page">Policies</li>
                </ol>
            </nav>
        </div>
    </section>
    <section id="landingPolicy" class="section-py bg-body landing-policy">
        <div class="container">
            <!-- Policy 1 -->
            <div class="card accordion-item">
                <h2 class="accordion-header " id="policyOne">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePolicyOne" aria-expanded="true" aria-controls="collapsePolicyOne">
                        <i class="icon-base ti tabler-lock me-2"></i>
                        Privacy Policy
                    </button>
                </h2>
                <div id="collapsePolicyOne" class="accordion-collapse collapse show" data-bs-parent="#policyAccordion">
                    <div class="p-0 accordion-body">

                        <!-- Header -->
                        <div class="p-4 p-md-5 border-bottom">
                            <div class="flex-wrap gap-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1">Privacy Policy for <span class="fw-bold">HiveHomes</span></h5>
                                    <div class="text-body-secondary small">Last Updated: <span class="fw-medium">August
                                            2025</span>
                                    </div>
                                </div>
                                <span class="badge bg-label-primary">Private Community App</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="row g-0">
                            <!-- TOC -->
                            <aside class="col-lg-4 col-xl-3 border-end">
                                <div class="top-0 p-4 position-sticky" style="z-index:1">
                                    <div class="mb-2 text-uppercase text-body-secondary small">Contents</div>
                                    <ol class="mb-0 list-unstyled policy-toc">
                                        <li><a href="#pp-1" class="policy-link">1. Introduction</a></li>
                                        <li><a href="#pp-2" class="policy-link">2. Information We Collect</a></li>
                                        <li><a href="#pp-3" class="policy-link">3. How We Use Your Information</a></li>
                                        <li><a href="#pp-4" class="policy-link">4. How We Share Your Information</a></li>
                                        <li><a href="#pp-5" class="policy-link">5. Your Choices</a></li>
                                        <li><a href="#pp-6" class="policy-link">6. Data Retention</a></li>
                                        <li><a href="#pp-7" class="policy-link">7. Data Security</a></li>
                                        <li><a href="#pp-8" class="policy-link">8. Children’s Privacy</a></li>
                                        <li><a href="#pp-9" class="policy-link">9. Changes to This Policy</a></li>
                                        <li><a href="#pp-10" class="policy-link">10. Governing Law</a></li>
                                        <li><a href="#pp-11" class="policy-link">11. Contact Us</a></li>
                                    </ol>
                                </div>
                            </aside>

                            <!-- Body -->
                            <article class="col-lg-8 col-xl-9">
                                <div class="p-4 p-md-5 policy-doc">

                                    <section id="pp-1" class="mb-5">
                                        <h6 class="mb-2">1. Introduction</h6>
                                        <p class="mb-2">
                                            Welcome to <strong>HiveHomes</strong>, a private web application exclusively for
                                            the
                                            residents of your housing society.
                                            Your privacy is critically important to us. This Privacy Policy explains how we
                                            collect,
                                            use, disclose, and safeguard
                                            your information when you use our application to connect with neighbors, share
                                            news,
                                            announce events, and buy/sell items within our community.
                                        </p>
                                        <p class="mb-2">
                                            By creating an account and using HiveHomes, you consent to the practices
                                            described in
                                            this policy.
                                            This is a closed community. Your data is not used for public or commercial
                                            purposes
                                            beyond the essential functioning
                                            of this society-focused application.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-2" class="mb-5">
                                        <h6 class="mb-3">2. Information We Collect</h6>
                                        <p class="mb-3">We collect information that you provide directly to us and
                                            information
                                            about your use of the application.</p>

                                        <div class="mb-4">
                                            <div class="mb-2 fw-medium">a) Information You Provide</div>
                                            <ul class="mb-0 list-unstyled ps-3">
                                                <li class="mb-2">
                                                    <span class="fw-medium">Account Information:</span>
                                                    Your name, apartment/unit number, email address, and phone number used
                                                    to
                                                    register.
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium">Profile Information:</span>
                                                    Optional profile details you add (e.g., profile picture, family details,
                                                    other
                                                    contact methods).
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium">User Content:</span>
                                                    Content you post (news updates, event announcements, discussions,
                                                    marketplace
                                                    listings) visible to other verified members.
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium">Communications:</span>
                                                    Messages you send directly to other members via the in-app messaging
                                                    system.
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <div class="mb-2 fw-medium">b) Information Collected Automatically</div>
                                            <ul class="mb-0 list-unstyled ps-3">
                                                <li class="mb-2">
                                                    <span class="fw-medium">Usage Data:</span>
                                                    Pages you visit, timestamps, features used, and links clicked.
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium">Device Information:</span>
                                                    IP address, browser type, operating system (primarily for security and
                                                    diagnostics).
                                                </li>
                                            </ul>
                                        </div>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-3" class="mb-5">
                                        <h6 class="mb-3">3. How We Use Your Information</h6>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li class="mb-2"><span class="fw-medium">Provide & Maintain the
                                                    Service:</span> Create
                                                your account, verify residency, and enable participation.</li>
                                            <li class="mb-2"><span class="fw-medium">Enable Community Features:</span>
                                                Display
                                                posts, announcements, and marketplace listings to society members.</li>
                                            <li class="mb-2"><span class="fw-medium">Facilitate Communication:</span>
                                                Allow
                                                members to contact each other regarding events, sales, or society matters.
                                            </li>
                                            <li class="mb-2"><span class="fw-medium">Send Administrative
                                                    Information:</span>
                                                Account notices, policy updates, and critical service announcements.</li>
                                            <li class="mb-2"><span class="fw-medium">Ensure Security:</span> Monitor
                                                usage to
                                                prevent fraud/abuse and keep members safe.</li>
                                            <li class="mb-2"><span class="fw-medium">Improve the App:</span> Understand
                                                how
                                                features are used to enhance the experience.</li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-4" class="mb-5">
                                        <h6 class="mb-3">4. How We Share Your Information</h6>
                                        <p class="mb-3">We do <strong>not</strong> sell, rent, or trade your personal
                                            information
                                            to third parties for commercial purposes.</p>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li class="mb-3">
                                                <span class="fw-medium">With Other Society Members:</span>
                                                Your name, unit number, and posted content are shared within the verified
                                                community.
                                                Contact details may be shared if
                                                you include them in a public post or direct message.
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-medium">With Society Management Committee:</span>
                                                Admin access for community management, dispute resolution, and rule
                                                compliance.
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-medium">Service Providers:</span>
                                                Trusted vendors (e.g., cloud hosting) with limited, task-specific access
                                                under
                                                confidentiality obligations.
                                            </li>
                                            <li class="mb-0">
                                                <span class="fw-medium">Legal Reasons:</span>
                                                When required by law or in response to valid public-authority requests.
                                            </li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-5" class="mb-5">
                                        <h6 class="mb-3">5. Your Choices About Your Information</h6>
                                        <ul class="mb-0 list-unstyled ps-3">
                                            <li class="mb-2"><span class="fw-medium">Account Information:</span> Review
                                                and
                                                update in your account settings.</li>
                                            <li class="mb-2"><span class="fw-medium">Public Posting:</span> Edit or
                                                delete your
                                                posts. Deleted posts are removed from future view but may already have been
                                                seen.
                                            </li>
                                            <li class="mb-0"><span class="fw-medium">Deactivating Your Account:</span>
                                                Request
                                                deactivation from administrators. Your profile is disabled; past public
                                                posts may be
                                                retained for community history unless you request deletion.</li>
                                        </ul>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-6" class="mb-5">
                                        <h6 class="mb-2">6. Data Retention</h6>
                                        <p class="mb-0">
                                            We retain personal information while your account is active or as needed to
                                            provide
                                            services.
                                            Upon deletion, we remove personal data from active use but may keep limited
                                            information
                                            temporarily
                                            for legitimate purposes (security analysis, fraud prevention, or society-bylaw
                                            record-keeping).
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-7" class="mb-5">
                                        <h6 class="mb-2">7. Data Security</h6>
                                        <p class="mb-0">
                                            We implement appropriate technical and organizational measures to protect your
                                            information.
                                            No method of transmission or storage is 100% secure; we strive to use
                                            commercially
                                            acceptable safeguards
                                            but cannot guarantee absolute security.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-8" class="mb-5">
                                        <h6 class="mb-2">8. Children’s Privacy</h6>
                                        <p class="mb-0">
                                            HiveHomes is not directed to individuals under 18. We do not knowingly collect
                                            information from children.
                                            If we learn a child under 18 has provided data, we will delete it.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-9" class="mb-5">
                                        <h6 class="mb-2">9. Changes to This Privacy Policy</h6>
                                        <p class="mb-0">
                                            We may update this policy periodically. We will post updates here and revise the
                                            “Last
                                            Updated” date.
                                            Please review this page from time to time.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-10" class="mb-5">
                                        <h6 class="mb-2">10. Governing Law</h6>
                                        <p class="mb-0">
                                            This Privacy Policy is governed by the applicable laws of your locality, without
                                            regard
                                            to conflict of law provisions.
                                        </p>
                                    </section>

                                    <hr class="my-4">

                                    <section id="pp-11" class="mb-4">
                                        <h6 class="mb-2">11. Contact Us</h6>
                                        <address class="mb-0">
                                            <div class="fw-medium">The Management Committee of HiveHomes</div>
                                            <div>Email: <a href="mailto:info@burgeon-grp.com">info@burgeon-grp.com</a>
                                            </div>
                                            <div>Or send a message to the administrators within the application.</div>
                                        </address>
                                    </section>

                                    <div class="pt-2 d-flex align-items-center justify-content-between">
                                        <small class="text-body-secondary">Thanks for helping keep our community safe and
                                            respectful.</small>
                                        <a href="#policyOne" class="btn btn-sm btn-outline-primary">Back to top</a>
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
