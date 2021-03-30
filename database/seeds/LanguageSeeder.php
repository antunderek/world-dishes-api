<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            [
                'lang' => 'en',
                'locale' => 'en_US',
            ],
            [
                'lang' => 'de',
                'locale' => 'de_DE',
            ],
            [
                'lang' => 'fr',
                'locale' => 'fr_FR',
            ],
            [
                'lang' => 'ar',
                'locale' => 'ar_SA',
            ],
            [
                'lang' => 'ja',
                'locale' => 'ja_JP',
            ],
        ]);
    }
}
