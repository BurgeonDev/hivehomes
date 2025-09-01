@php
    use Illuminate\Support\Facades\DB;

    // Active societies
    $activeSocieties = DB::table('societies')->where('is_active', 1)->count();

    // Active members
    $activeMembers = DB::table('users')->where('is_active', 1)->count();

    // Marketplace listings
    $marketplaceListings = DB::table('products')->where('status', 'approved')->count();

    // Verified service providers
    $verifiedProviders = DB::table('service_providers')->where('is_approved', 1)->count();
@endphp

<style>
    .fun-card {
        transition: all 0.3s ease;
        border-radius: 1rem;
    }

    .fun-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .fun-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px auto;
    }

    .fun-title {
        font-size: 2rem;
        font-weight: 700;
    }

    .fun-sub {
        font-size: 1rem;
        color: #6c757d;
    }
</style>

<section id="landingFunFacts" class="section-py landing-fun-facts">
    <div class="container">
        <div class="row gy-4">

            <!-- Active Societies -->
            <div class="col-sm-6 col-lg-3">
                <div class="text-center border-0 shadow-sm card fun-card">
                    <div class="card-body">
                        <div class="text-white fun-icon bg-gradient-primary">
                            <i class="icon-base ti tabler-building fs-1 icon-xl"></i>
                        </div>
                        <h3 class="fun-title text-primary">{{ number_format($activeSocieties) }}+</h3>
                        <p class="fun-sub">Active Societies<br>On HiveHomes</p>
                    </div>
                </div>
            </div>

            <!-- Members Connected -->
            <div class="col-sm-6 col-lg-3">
                <div class="text-center border-0 shadow-sm card fun-card">
                    <div class="card-body">
                        <div class="text-white fun-icon bg-gradient-success">
                            <i class="icon-base ti tabler-users fs-1 icon-xl"></i>
                        </div>
                        <h3 class="fun-title text-success">{{ number_format($activeMembers) }}+</h3>
                        <p class="fun-sub">Members<br>Actively Engaged</p>
                    </div>
                </div>
            </div>

            <!-- Marketplace Listings -->
            <div class="col-sm-6 col-lg-3">
                <div class="text-center border-0 shadow-sm card fun-card">
                    <div class="card-body">
                        <div class="text-white fun-icon bg-gradient-info">
                            <i class="icon-base ti tabler-shopping-cart fs-1 icon-xl"></i>
                        </div>
                        <h3 class="fun-title text-info">{{ number_format($marketplaceListings) }}+</h3>
                        <p class="fun-sub">Marketplace<br>Listings</p>
                    </div>
                </div>
            </div>

            <!-- Verified Service Providers -->
            <div class="col-sm-6 col-lg-3">
                <div class="text-center border-0 shadow-sm card fun-card">
                    <div class="card-body">
                        <div class="text-white fun-icon bg-gradient-warning">
                            <i class="icon-base ti tabler-shield-check fs-1 icon-xl"></i>
                        </div>
                        <h3 class="fun-title text-warning">{{ number_format($verifiedProviders) }}+</h3>
                        <p class="fun-sub">Verified Service<br>Providers</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
