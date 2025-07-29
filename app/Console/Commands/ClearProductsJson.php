<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearProductsJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'products:clear';

    /**
     * The console command description.
     *
     * @var string
     */
     protected $description = 'Clear the products.json file every 24 hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $path = 'products.json';

        if (Storage::exists($path)) {
            Storage::put($path, json_encode([]));
            $this->info("products.json has been cleared.");
        } else {
            $this->info("products.json does not exist.");
        }

       return self::SUCCESS;
    }
}
