<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products', 'id_category')) {
                $table->unsignedBigInteger('id_category')->nullable()->after('id');
            }

            if (!Schema::hasColumn('products', 'id_brand')) {
                $table->unsignedBigInteger('id_brand')->nullable()->after('id_category');
            }

            if (!Schema::hasColumn('products', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('id_brand');
            }

            if (!Schema::hasColumn('products', 'image')) { // Fix lỗi 'imgae' bị sai chính tả
                $table->string('image')->nullable()->after('id_user');
            }

            if (!Schema::hasColumn('products', 'web_id')) {
                $table->string('web_id')->unique()->nullable()->after('name');
            }

            if (!Schema::hasColumn('products', 'status')) {
                $table->boolean('status')->after('price');
            }

            if (!Schema::hasColumn('products', 'sale')) {
                $table->decimal('sale', 10, 2)->nullable()->after('status');
            }

            if (!Schema::hasColumn('products', 'company_profile')) {
                $table->string('company_profile')->nullable()->after('description');
            }

            // Kiểm tra trước khi thêm khóa ngoại, tránh lỗi nếu đã có
            if (!Schema::hasColumn('products', 'id_category')) {
                $table->foreign('id_category')->references('id')->on('categories')->onDelete('set null');
            }

            if (!Schema::hasColumn('products', 'id_brand')) {
                $table->foreign('id_brand')->references('id')->on('brands')->onDelete('set null');
            }

            if (!Schema::hasColumn('products', 'id_user')) {
                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'id_category')) {
                $table->dropForeign(['id_category']);
                $table->dropColumn('id_category');
            }

            if (Schema::hasColumn('products', 'id_brand')) {
                $table->dropForeign(['id_brand']);
                $table->dropColumn('id_brand');
            }

            if (Schema::hasColumn('products', 'id_user')) {
                $table->dropForeign(['id_user']);
                $table->dropColumn('id_user');
            }

            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }

            if (Schema::hasColumn('products', 'web_id')) {
                $table->dropColumn('web_id');
            }

            if (Schema::hasColumn('products', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('products', 'sale')) {
                $table->dropColumn('sale');
            }

            if (Schema::hasColumn('products', 'company_profile')) {
                $table->dropColumn('company_profile');
            }
        });
    }
};
