<?php
namespace App\Domains\GetCurrency\Adapters;

use App\Domains\GetCurrency\Ports\StrategyInterface;
use Symfony\Component\DomCrawler\Crawler;

class MultiNumbersFilterStrategy implements StrategyInterface {

    public function execute($html, $codes):array {
        $crawler = new Crawler($html);

        $currencyData = [];

        $crawler->filter('table')->filter('tbody')->filter('tr')->each(function ($tr) use ($codes, &$currencyData) {

            $currencyCodeNode = $tr->filter('td:nth-child(2)');

            if ($currencyCodeNode->count() == 0 || empty($currencyCodeNode->text())) {
                return;
            }

            $currencyCode = trim($currencyCodeNode->text());

            if(!in_array($currencyCode, $codes)) {
                return;
            }

            $code = $tr->filter('td:nth-child(1)')->text();
            $decimal = $tr->filter('td:nth-child(3)')->text();
            $currency = $tr->filter('td:nth-child(4)')->text();

            $currency_locations = [];

            $tr->filter('td:nth-child(5)')->each(function ($tdNode) use (&$currency_locations) {
                $locations = $tdNode->filter('a');
                $images = $tdNode->filter('img');

                $locations->each(function ($locationNode, $index) use ($images, &$currency_locations) {
                    $location = $locationNode->text();

                    $icon = $images->eq($index)->count() ? 'https:'.$images->eq($index)->attr('src'):'';

                    $currency_locations[] = [
                        'location' => $location,
                        'icon' => $icon
                    ];
                });
            });

            array_push($currencyData,[
                'code' => trim($code),
                'number' => intval($currencyCode),
                'decimal' => intval($decimal),
                'currency' => trim($currency),
                'currency_locations' =>$currency_locations,
            ]);
        });

        return $currencyData;
    }
}
