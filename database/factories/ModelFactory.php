<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$faker = Faker\Factory::create('pt_BR');


//$factory->define(CodeProject\Entities\User::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\User::class, function () use($faker){
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


//$factory->define(CodeProject\Entities\Client::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\Client::class, function () use($faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});



//$factory->define(CodeProject\Entities\Project::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\Project::class, function () use($faker) {
    return [
        'owner_id' => rand(1,10),
        'client_id' => rand(1,10),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'progress' => rand(1,100),
        'status' => rand(1,3),
        'due_date' => $faker->dateTime('now'),
    ];
});

//$factory->define(CodeProject\Entities\ProjectNote::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\ProjectNote::class, function () use($faker) {
    return [
        'project_id' => rand(1,10),
        'title' => $faker->word,
        'note' => $faker->paragraph,
    ];
});

//$factory->define(CodeProject\Entities\ProjectTasks::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\ProjectTasks::class, function () use($faker) {
    return [
        'name' => $faker->word,
        'start_date' => $faker->dateTime('now'),
        'due_date' => $faker->dateTime('now'),
        'status' => rand(1,3),
        'project_id' => rand(1,10),

    ];
});


//$factory->define(CodeProject\Entities\ProjectMembers::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\ProjectMembers::class, function () use($faker) {
    return [
        'project_id' => rand(1,10),
        'member_id' => rand(1,10),
    ];
});


//$factory->define(CodeProject\Entities\OauthClients::class, function (Faker\Generator $faker) {
$factory->define(CodeProject\Entities\OauthClients::class, function () use($faker) {
    return [
        'id' => rand(1,10),
        'secret' => $faker->word,
        'name' => $faker->name
    ];
});
