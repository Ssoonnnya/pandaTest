<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscriptions;
use App\Models\olxLink;
use GuzzleHttp\Client;
use Mailgun\Mailgun;

class PriceChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:price-change';

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
        $links = Subscriptions::all();

        $client = new Client();

        foreach($links as $link){

            try {

                $url = $link->olx_url;


                $response = $client->get($url);
                $htmlContent = $response->getBody()->getContents();

                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($htmlContent);
                libxml_clear_errors();

                $xpath = new \DOMXPath($dom);
                $priceContainer = $xpath->query('//div[@data-testid="ad-price-container"]');
                $h3Price= $xpath->query('.//h3', $priceContainer->item(0));

                if ($h3Price->length > 0) {

                    $newPrice =  $h3Price->item(0)->textContent;

                    $parts = explode(' ', $newPrice);
                    $newPriceInt = intval($parts[0]);

                    $previousPrice = olxLink::where('url', $url)->value('price');

                    if ($previousPrice !== $newPriceInt) {

                        echo "Ціна змінилося: $newPriceInt" ;

                        olxLink::updateOrCreate([
                            'url' => $url,
                            'price' => $newPriceInt
                        ]);
                    }

                } else {
                    echo "Not found";
                }
            } catch (\Exception $e) {
                    echo 'Error ' . $e->getMessage();
            }

        }
    }
}
