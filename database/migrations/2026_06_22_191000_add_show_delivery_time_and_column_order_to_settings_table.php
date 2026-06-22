<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('show_delivery_time')->default(true)->after('show_maps');
            $table->json('column_order')->nullable()->after('show_delivery_time');
        });

        Setting::whereNotNull('id')->update([
            'show_delivery_time' => true,
            'column_order' => json_encode(['wilaya', 'commune', 'delivery_time', 'code', 'company', 'phone', 'address', 'maps']),
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['show_delivery_time', 'column_order']);
        });
    }
};
