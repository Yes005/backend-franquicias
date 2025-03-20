<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpseclib3\Crypt\Random;
use Illuminate\Support\Facades\File;

class GenerateEncryptionKey extends Command
{
    protected $signature = 'generate:secret-key';

    protected $description = 'Generate a new encryption key and store it in the .env file';

    public function handle()
    {
        $key = bin2hex(Random::string(16));

        $this->info("Generated Encryption Key: $key");

        $path = base_path('.env');

        if (File::exists($path)) {
            $env = File::get($path);

            if (strpos($env, 'FRANQUICIA_ENCRYPTION_KEY=') !== false) {
                $env = preg_replace('/FRANQUICIA_ENCRYPTION_KEY=.*/', 'FRANQUICIA_ENCRYPTION_KEY=' . $key, $env);
            } else {
                $env .= "\nFRANQUICIA_ENCRYPTION_KEY=$key\n";
            }

            File::put($path, $env);

            $this->info('Encryption key set successfully.');
        } else {
            $this->error('.env file not found!');
        }

        return 0;
    }
}
