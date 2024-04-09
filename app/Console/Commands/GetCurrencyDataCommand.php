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
        $currencyCodes = ['USD', 'EUR', 'CNY'];

        foreach ($currencyCodes as $currencyCode) {
            $responseKGS = Http::withHeaders([
                'x-apikey' => env('CURRENCY_API_KEY'),
                'host' => 'api.forexapi.eu'
            ])->get("https://api.forexapi.eu/v2/live?base=KGS&counter={$currencyCode}&format=json");

            if ($responseKGS->ok()) {
                $dataJsonKGS = $responseKGS->json();
                $midKGS = $dataJsonKGS['quotes'][$currencyCode]['mid'];
                $timeKGS = date('Y-m-d H:i:s', $dataJsonKGS['quotes'][$currencyCode]['timestamp']);

                Currency::updateOrCreate(
                    ['base' => 'KGS', 'counter' => $currencyCode],
                    ['mid' => $midKGS, 'time' => $timeKGS]
                );

                $this->info("Currency conversion from KGS to $currencyCode saved successfully.");
            } else {
                $this->error("Failed to fetch currency conversion from KGS to $currencyCode.");
            }

            $responseCurrency = Http::withHeaders([
                'x-apikey' => env('CURRENCY_API_KEY'),
                'host' => 'api.forexapi.eu'
            ])->get("https://api.forexapi.eu/v2/live?base={$currencyCode}&counter=KGS&format=json");

            if ($responseCurrency->ok()) {
                $dataJsonCurrency = $responseCurrency->json();
                $midCurrency = $dataJsonCurrency['quotes']['KGS']['mid'];
                $timeCurrency = date('Y-m-d H:i:s', $dataJsonCurrency['quotes']['KGS']['timestamp']);

                Currency::updateOrCreate(
                    ['base' => $currencyCode, 'counter' => 'KGS'],
                    ['mid' => $midCurrency, 'time' => $timeCurrency]
                );

                $this->info("Currency conversion from $currencyCode to KGS saved successfully.");
            } else {
                $this->error("Failed to fetch currency conversion from $currencyCode to KGS.");
            }
        }
    }
}
