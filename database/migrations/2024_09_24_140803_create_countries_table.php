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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string(column: "code")->nullable();
            $table->string("currency")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('countries');
    }
};
