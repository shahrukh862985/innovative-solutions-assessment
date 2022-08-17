<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Str;
class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'email' => 'test@innovative-solutions.com',
        ],[
            'name' => 'test',
            'password' => Hash::make("123123123"),
        ]);

        $film = Film::firstOrCreate([
            'name' => 'Raksha Bandhan',
            'slug' => Str::slug('Raksha Bandhan','-'),
            'description' => "Lala Kedarnath, the eldest and only brother of 4 sisters, runs a chaat shop that was started by his father. Lala promises his frail mother on her deathbed that he will get married only after he fulfills the responsibility of marrying his sisters into suitable homes first. What follows is Lala's relentless efforts of getting his sisters married while upholding his family values.",
            'release_date' => '2022-08-16',
            'rating' => 4.6,
            'price' => 800,
            'country' => "India",
            'genre' => json_encode(['Comedy','Drama','Family']),
            'photo' => null,
            'created_by' => $user->id,
        ]);

        $film = Film::firstOrCreate([
            'name' => 'Laal Singh Chaddha',
            'slug' => Str::slug('Laal Singh Chaddha','-'),
            'description' => "Laal Singh Chaddha a man with low IQ level is travelling in a train and happens to tell his story to his co passenger with background of current events happening in India finding it interesting more fellow passengers join in.He was born during the Indo Pak war where his grandfather was a martyr hence he was named after him having a low IQ level no school wants to admit him but finally a priest of Catholic school does so seeing...",
            'release_date' => '2022-08-11',
            'rating' => 4.6,
            'price' => 900,
            'country' => "India",
            'genre' => json_encode(['Comedy','Drama','Family']),
            'photo' => null,
            'created_by' => $user->id,
        ]);

        $film = Film::firstOrCreate([
            'name' => 'Day Shift',
            'slug' => Str::slug('Day Shift','-'),
            'description' => "A hard-working, blue-collar dad who just wants to provide a good life for his quick-witted 8-year-old daughter. His mundane San Fernando Valley pool cleaning job is a front for his real source of income: hunting and killing vampires.",
            'release_date' => '2022-08-12',
            'rating' => 4.8,
            'price' => 1000,
            'country' => "United States",
            'genre' => json_encode(['Action','Comedy','Fantasy','Horror','Thriller']),
            'photo' => null,
            'created_by' => $user->id,
        ]);
    }
}
