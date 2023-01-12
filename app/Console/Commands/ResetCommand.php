<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);

        $path = public_path('storage/uploads/');
        $upload = scandir($path);
        foreach ($upload as $value) {
            if ($value != '.' && $value != '..' && $value != 'default') {
                foreach (scandir("$path/$value") as $file) {
                    if ($file != 'default.jpg' && $file != '.' && $file != '..' && $file != 'default-user.webp') {
                        Storage::delete("public/uploads/$value/$file");
                    }
                }
            }
        }
        session()->forget(['coupon_code', 'discount_amount_price', 'coupon_id']);
        $this->info('Reset successfully');

        return Command::SUCCESS;
    }
}
