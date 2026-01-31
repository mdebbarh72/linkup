<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Profile::factory()->count(10)->create();

         Profile::updateOrCreate(
            ['pseudo' => 'neo'], 
            [
                'user_id' => '4',
                'bio' => 'there are no men like me, there only me',
                'lien_photo' => '/../user/images',
            ]
        );
    }
}
