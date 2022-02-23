<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp;

class CurrencyRateConversionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencyrateconversion:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Currency rate conversion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currencies =  \App\Models\Currency::where(['status'=>'active'])->select('name','iso_code','symbol')->get();
        if($currencies->count())
        {
            foreach ($currencies as $key => $currency)
            {
                  $client = new GuzzleHttp\Client();
                  $res = $client->get('https://v6.exchangerate-api.com/v6/17a33c1add6e099696d8d489/latest/'.$currency->iso_code);
                  if($res->getStatusCode()==200)
                  {
                     $response =  $res->getBody();
                     $data =  json_decode($response);
                     $conversionRate = $data->conversion_rates;

                     $conversionRate = json_encode($conversionRate);

                     if(!empty($conversionRate))
                     {
                        $currencyConversion = \App\Models\CurrencyConversion::updateOrCreate(['iso_code' =>$currency->iso_code],
                          ['conversion_rate' => $conversionRate]);
                     }
                  }
                    
            }    
        }

        //\Log::info("Cron is working fine!");
        $this->info('CurrencyRateConversion:Cron Cummand Run successfully!');
    }
}
