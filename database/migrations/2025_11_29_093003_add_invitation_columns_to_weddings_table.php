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
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('bride_id');
            $table->string('partner_email')->nullable()->after('status');
            $table->string('invitation_token', 64)->nullable()->after('partner_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn(['status', 'partner_email', 'invitation_token']);
        });
    }
};
