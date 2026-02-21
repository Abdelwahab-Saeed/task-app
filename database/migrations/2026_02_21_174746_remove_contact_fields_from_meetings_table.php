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
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['contact_person', 'company_name', 'contact_phone', 'contact_email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->string('contact_person')->nullable();
            $table->string('company_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
        });
    }
};
