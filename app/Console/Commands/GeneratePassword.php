<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Faker\Factory as Faker;

class GeneratePassword extends Command
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-password
    {--minLength=12 : The min length of the password}
    {--maxLength=20 : The max length of the password}
    {--variable=PASSWORD : The env variable for write}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a random password and save it to the .env file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minLength = $this->option('minLength');
        $maxLength = $this->option('maxLength');
        $envVariable = $this->option('variable');

        $faker = Faker::create();
        $password = $faker->regexify('[A-Za-z0-9\!@%&*]{' . $minLength . ',' . $maxLength . '}');

        // Update or add the password in the .env file
        write_env($envVariable, $password);

        $this->info('Random root user password generated and added to .env file: ');
    }
}
