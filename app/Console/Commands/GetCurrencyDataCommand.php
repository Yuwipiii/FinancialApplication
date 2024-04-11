<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetCurrencyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-currency-data-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $currencyCodes = ['USD', 'EUR', 'CNY','KGS'];

        foreach ($currencyCodes as $baseCurrency) {
            foreach ($currencyCodes as $counterCurrency) {
                if ($baseCurrency !== $counterCurrency) { // Skip if base and counter currencies are the same
                    $response = Http::withHeaders([
                        'x-apikey' => env('CURRENCY_API_KEY'),
                        'host' => 'api.forexapi.eu'
                    ])->get("https://api.forexapi.eu/v2/live?base={$baseCurrency}&counter={$counterCurrency}&format=json");

                    if ($response->ok()) {
                        $dataJson = $response->json();
                        $mid = $dataJson['quotes'][$counterCurrency]['mid'];
                        $time = date('Y-m-d H:i:s', $dataJson['quotes'][$counterCurrency]['timestamp']);

                        Currency::updateOrCreate(
                            ['base' => $baseCurrency, 'counter' => $counterCurrency],
                            ['mid' => $mid, 'time' => $time]
                        );

                        $this->info("Currency conversion from $baseCurrency to $counterCurrency saved successfully.");
                    } else {
                        $this->error("Failed to fetch currency conversion from $baseCurrency to $counterCurrency.");
                    }
                }
            }
        }
    }
}
