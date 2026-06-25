<?php

namespace App\Console\Commands;

use App\Models\Office;
use Illuminate\Console\Command;

class CleanCompanyNames extends Command
{
    protected $signature = 'ldb:clean-company-names';
    protected $description = 'Normalise les noms d\'entreprises (trim, espaces multiples, casse)';

    public function handle(): int
    {
        $updated = 0;

        Office::chunk(100, function ($offices) use (&$updated) {
            foreach ($offices as $office) {
                $cleaned = preg_replace('/\s+/', ' ', trim($office->company_name));
                $cleaned = mb_convert_case($cleaned, MB_CASE_TITLE, 'UTF-8');
                $cleaned = preg_replace('/\b(Dz|Algérie|Spa|Sarl|Eurl|Snc)\b/i', fn($m) => strtoupper($m[0]), $cleaned);

                if ($cleaned !== $office->company_name) {
                    $office->updateQuietly(['company_name' => $cleaned]);
                    $this->line("  {$office->id}: «{$office->company_name}» → «{$cleaned}»");
                    $updated++;
                }
            }
        });

        $this->info("{$updated} entreprise(s) nettoyée(s).");

        return self::SUCCESS;
    }
}
