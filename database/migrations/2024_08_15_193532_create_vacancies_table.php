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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('title');
            $table->text('description')->nullable();
            // $table->text('resume')->nullable();
            // $table->text('application')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamp('expires_on')->nullable();
            $table->string('status')->nullable();
            $table->string('location')->nullable();
            $table->string('department')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('experience')->nullable();
            $table->unsignedBigInteger('job_type_id')->nullable();
            $table->text('footer')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            $table->string('contract_type')->nullable();
            $table->string('bid_security')->nullable();
            $table->text('about_company')->nullable();
            $table->text('summary')->nullable();
            $table->string('classification')->default('JOB');

            $table->timestamp('start_on')->nullable();
            $table->timestamp('ends_on')->nullable();
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
        Schema::dropIfExists('vacancies');
    }
};
