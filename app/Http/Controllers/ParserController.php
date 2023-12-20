<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriptions;
use GuzzleHttp\Client;

class ParserController extends Controller
{
    public function index(Request $request) {

        $url = "https://www.olx.ua/d/uk/obyavlenie/kniga-dm-zeml-ta-krov-IDTVQ0z.html";

        $client = new Client();

        try {
            $response = $client->get($url);
            $htmlContent = $response->getBody()->getContents();

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlContent);
            libxml_clear_errors();

            $xpath = new \DOMXPath($dom);
            $element = $xpath->query('//div[@data-testid="ad-price-container"]');

                if ($element->length > 0) {

                    echo $element->item(0)->textContent;
                } else {
                    echo "Not found";
                }
            } catch (\Exception $e) {
                echo 'Error ' . $e->getMessage();
            }

        }
}
