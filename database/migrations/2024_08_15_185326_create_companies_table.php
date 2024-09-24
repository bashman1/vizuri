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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('nature_of_business')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('p_o_box')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('company_size_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('alt_phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('zip_code')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('status')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('headquarter')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('updated_on')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
