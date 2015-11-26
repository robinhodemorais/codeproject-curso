<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeProject\Entities\OauthClients::class)->create([
            'id' => 'appid1',
            'secret' => 'secret',
            'name' => 'AppLaravelAngularJS'
        ]);
    }
}
