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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('hotel_code', 20)->unique();
            $table->string('email', 100);
            $table->string('fax', 25);
            $table->string('company_name');
            $table->string('tax_code', 20);
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
