<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('site_name', 100)->default('CHRONOREX EXPRESS')->after('id');
            $table->text('meta_description')->nullable()->after('site_name');
            $table->string('hero_badge', 100)->default('Réseau de Bureaux Partenaires')->after('meta_description');
            $table->text('hero_title')->nullable()->after('hero_badge');
            $table->text('hero_subtitle')->nullable()->after('hero_title');
            $table->string('search_placeholder', 200)->default('Rechercher par wilaya, entreprise, téléphone...')->after('hero_subtitle');
            $table->string('footer_copyright', 200)->nullable()->after('search_placeholder');
            $table->string('footer_tagline', 200)->default('Livraison express dans toute l\'Algérie')->after('footer_copyright');
            $table->string('stats_wilayas_label', 100)->default('Wilayas couvertes')->after('footer_tagline');
            $table->string('stats_offices_label', 100)->default('Bureaux actifs')->after('stats_wilayas_label');
            $table->string('stats_partners_label', 100)->default('Partenaires agréés')->after('stats_offices_label');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name',
                'meta_description',
                'hero_badge',
                'hero_title',
                'hero_subtitle',
                'search_placeholder',
                'footer_copyright',
                'footer_tagline',
                'stats_wilayas_label',
                'stats_offices_label',
                'stats_partners_label',
            ]);
        });
    }
};
