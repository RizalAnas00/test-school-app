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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
            $table->foreignId('academic_class_id')->constrained('academic_classes')->onDelete('cascade');
            $table->string('nisn', 20)->unique();
            $table->string('address', 500);
            $table->string('phone_number', 20);
            $table->integer('age');
            $table->dateTime('birth_date');
            $table->dateTime('enrollment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
