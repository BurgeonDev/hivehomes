<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesAndParentMarkersToCoreTables extends Migration
{
    /**
     * List of tables to add soft deletes and marker columns to.
     * Adjust this list if you want to include/exclude tables.
     */
    protected $tables = [
        'users',
        'societies',
        'posts',
        'comments',
        'post_user_likes',
        'products',
        'product_images',
        'service_providers',
        'service_provider_reviews',
        // Add more tables here later if required (e.g., notifications etc.)
    ];

    public function up()
    {
        // users table
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('users', 'deleted_by_parent_at')) {
                    // used when society deletes its users
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // societies table
        if (Schema::hasTable('societies')) {
            Schema::table('societies', function (Blueprint $table) {
                if (! Schema::hasColumn('societies', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                // societies generally won't need deleted_by_parent_at because they are top-level
            });
        }

        // posts table
        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                if (! Schema::hasColumn('posts', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('posts', 'deleted_by_parent_at')) {
                    // marker used if post was deleted because user or society was deleted
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // comments table
        if (Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                if (! Schema::hasColumn('comments', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('comments', 'deleted_by_parent_at')) {
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // post_user_likes table
        if (Schema::hasTable('post_user_likes')) {
            Schema::table('post_user_likes', function (Blueprint $table) {
                if (! Schema::hasColumn('post_user_likes', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('post_user_likes', 'deleted_by_parent_at')) {
                    // marker indicates the like was deleted because user or post was deleted
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // products table
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (! Schema::hasColumn('products', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('products', 'deleted_by_parent_at')) {
                    // marker used if product was deleted because user or society was deleted
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // product_images table
        if (Schema::hasTable('product_images')) {
            Schema::table('product_images', function (Blueprint $table) {
                if (! Schema::hasColumn('product_images', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('product_images', 'deleted_by_parent_at')) {
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // service_providers table
        if (Schema::hasTable('service_providers')) {
            Schema::table('service_providers', function (Blueprint $table) {
                if (! Schema::hasColumn('service_providers', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('service_providers', 'deleted_by_parent_at')) {
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // service_provider_reviews table
        if (Schema::hasTable('service_provider_reviews')) {
            Schema::table('service_provider_reviews', function (Blueprint $table) {
                if (! Schema::hasColumn('service_provider_reviews', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (! Schema::hasColumn('service_provider_reviews', 'deleted_by_parent_at')) {
                    $table->timestamp('deleted_by_parent_at')->nullable()->after('deleted_at');
                }
            });
        }

        // NOTE: countries, states, cities are treated as reference data.
        // We recommend NOT soft-deleting them; prefer is_active flags instead.
    }

    public function down()
    {
        // Reverse the additions carefully (only drop columns if they exist)
        if (Schema::hasTable('service_provider_reviews')) {
            Schema::table('service_provider_reviews', function (Blueprint $table) {
                if (Schema::hasColumn('service_provider_reviews', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('service_provider_reviews', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('service_providers')) {
            Schema::table('service_providers', function (Blueprint $table) {
                if (Schema::hasColumn('service_providers', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('service_providers', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('product_images')) {
            Schema::table('product_images', function (Blueprint $table) {
                if (Schema::hasColumn('product_images', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('product_images', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('products', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('post_user_likes')) {
            Schema::table('post_user_likes', function (Blueprint $table) {
                if (Schema::hasColumn('post_user_likes', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('post_user_likes', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                if (Schema::hasColumn('comments', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('comments', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                if (Schema::hasColumn('posts', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('posts', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('societies')) {
            Schema::table('societies', function (Blueprint $table) {
                if (Schema::hasColumn('societies', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'deleted_by_parent_at')) {
                    $table->dropColumn('deleted_by_parent_at');
                }
                if (Schema::hasColumn('users', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }
    }
}
