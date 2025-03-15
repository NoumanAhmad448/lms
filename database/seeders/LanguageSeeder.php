<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Eren\Lms\Models\Language as ModelsLanguage;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if table exists before inserting
        if (!DB::getSchemaBuilder()->hasTable('languages')) {
            echo "⚠️ Table 'languages' does not exist. Skipping seeding.\n";
            return;
        }

        // Read JSON file
        $jsonPath = database_path('migrations/data/lang.json');
        echo $jsonPath;
        if (!File::exists($jsonPath)) {
            echo "⚠️ JSON file 'lang.json' not found. Skipping seeding.\n";
            return;
        }

        $languages = json_decode(File::get($jsonPath), true);

        foreach ($languages as $language) {
            ModelsLanguage::updateOrCreate(
                ['iso_639_1' => $language['iso_639_1']],
                ['name' => $language['name']]
            );
        }

        echo "✅ Languages seeded successfully.\n";
    }
}
