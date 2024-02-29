<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\Wallet;
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
    public function handle()
    {
        $responseUSD = Http::withHeaders([
                'x-apikey' => env('CURRENCY_API_KEY'),
                'host' => 'api.forexapi.eu']
        )->get('https://api.forexapi.eu/v2/live?base=USD&counter=KGS&format=json');
        $responseKGS = Http::withHeaders([
                'x-apikey' => env('CURRENCY_API_KEY'),
                'host' => 'api.forexapi.eu']
        )->get('https://api.forexapi.eu/v2/live?base=KGS&counter=USD&format=json');

        if ($responseKGS->ok()) {
            $dataJson = $responseKGS->json();
            if (Currency::where('base', 'KGS')->exists()) {
                $currencyKGStoUSD = Currency::where('base', 'KGS')->first();
            } else {
                $currencyKGStoUSD = new Currency();
            }
            $currencyKGStoUSD->base = $dataJson['base'];
            $currencyKGStoUSD->counter = $dataJson['quotes']['USD']['counter'];
            $currencyKGStoUSD->mid = $dataJson['quotes']['USD']['mid'];
            $currencyKGStoUSD->time = date('Y-m-d H:i:s', $dataJson['quotes']['USD']['timestamp']);
            if (Currency::where('base', 'KGS')->exists()) {
                $currencyKGStoUSD->update();
            } else {
                $currencyKGStoUSD->save();
            }
        } else {
            echo $responseKGS;
        }
        if ($responseUSD->ok()) {
            $dataJson = $responseUSD->json();
            if (Currency::where('base', 'USD')->exists()) {
                $currencyUSDtoKGS = Currency::where('base', 'USD')->first();
            } else {
                $currencyUSDtoKGS = new Currency();
            }
            $currencyUSDtoKGS->base = $dataJson['base'];
            $currencyUSDtoKGS->counter = $dataJson['quotes']['KGS']['counter'];
            $currencyUSDtoKGS->mid = $dataJson['quotes']['KGS']['mid'];
            $currencyUSDtoKGS->time = date('Y-m-d H:i:s', $dataJson['quotes']['KGS']['timestamp']);
            if (Currency::where('base', 'USD')->exists()) {
                $currencyUSDtoKGS->update();
            } else {
                $currencyUSDtoKGS->save();
            }
        } else {
            echo $responseUSD;
        }


    }
}
