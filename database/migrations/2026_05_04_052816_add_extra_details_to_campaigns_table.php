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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->text('reward_details')->nullable()->after('type');
            $table->text('equity_details')->nullable()->after('reward_details');
            $table->text('repayment_details')->nullable()->after('equity_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['reward_details', 'equity_details', 'repayment_details']);
        });
    }
};
