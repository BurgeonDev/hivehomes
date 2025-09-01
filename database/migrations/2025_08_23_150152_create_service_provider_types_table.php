<?php

// database/migrations/xxxx_xx_xx_create_service_provider_types_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_provider_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Plumber, Electrician
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type');
        });
        Schema::dropIfExists('service_provider_types');
    }
};
