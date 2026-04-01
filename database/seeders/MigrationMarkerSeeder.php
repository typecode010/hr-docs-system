<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationMarkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $migrations = [
            '0001_01_01_000000_create_users_table',
            '0001_01_01_000001_create_cache_table',
            '0001_01_01_000002_create_jobs_table',
            '2026_02_04_000003_create_employees_table',
            '2026_02_04_000004_create_document_templates_table',
            '2026_02_04_000005_create_documents_table',
            '2026_02_04_000006_create_document_logs_table',
        ];

        foreach ($migrations as $migration) {
            DB::table('migrations')->insertOrIgnore([
                'migration' => $migration,
                'batch' => 1,
            ]);
        }
    }
}
