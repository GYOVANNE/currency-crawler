<?php
namespace App\Domains\Currency\Services;

use App\Domains\ClientRequest\Ports\ClientHttpRequestPort;
use App\Domains\Currency\Adapters\MultiCodesFilterStrategy;
use App\Domains\Currency\Adapters\MultiNumbersFilterStrategy;
use App\Domains\Currency\Adapters\SingleCodeFilterStrategy;
use App\Domains\Currency\Adapters\SingleNumberFilterStrategy;
use App\Domains\Currency\Events\CurrencyCreated;
use App\Domains\Currency\Repositories\GetCurrencyRepository;
use App\Domains\Currency\Resources\CurrencyResource;
use Exception;
use Illuminate\Support\Facades\Cache;

class GetCurrencyService {

    const CACHING_TIME = 5; // min
    const EXTERNAL_SOURCE = 'https://pt.wikipedia.org/wiki/ISO_4217';

    private ClientHttpRequestPort $clienteHttp;
    private DataFilterContext $context;
    private GetCurrencyRepository $repository;

    public function __construct(ClientHttpRequestPort $clienteHttp, DataFilterContext $context, GetCurrencyRepository $repository) {
        $this->clienteHttp = $clienteHttp;
        $this->context = $context;
        $this->repository = $repository;
    }

    /**
     * Facade to execute the crawl
     *
     * @param  mixed $codes
     */
    public function execute($codes):array {

        $strategyMap = [
            'code' => SingleCodeFilterStrategy::class,
            'code_list' => MultiCodesFilterStrategy::class,
            'number' => SingleNumberFilterStrategy::class,
            'number_list' => MultiNumbersFilterStrategy::class,
        ];

        $inputKeys = array_keys($codes);
        $this->_validateInput($inputKeys, $strategyMap);

        $strategy = app($strategyMap[$inputKeys[0]]);

        $inputKeysValue = $this->_generateCacheKey($codes);

        $currencies = $this->_getFromCacheOrDatabase($inputKeysValue, function () use ($strategy, $inputKeys, $codes) {
            $html = $this->clienteHttp->execute(self::EXTERNAL_SOURCE);
            $currencies = $this->context->setStrategy($strategy)->filterData($html, $codes[$inputKeys[0]]);
            CurrencyCreated::dispatch($currencies);
            return $currencies;
        });

        return $currencies;
    }

    private function _getFromCacheOrDatabase($cacheKey, $dataRetrievalCallback) {

        $currencies = Cache::get("currencies_{$cacheKey}");

        if (!is_null($currencies)) {
            return $currencies;
        }

        try {
            $currencies = $dataRetrievalCallback();
        } catch (\Exception $e) {
            $currencies = CurrencyResource::collection(
                $this->repository->getCurrenciesByCode(explode('_', $cacheKey))
            );
        } finally {
            $this->_saveCurrenciesCaching($currencies, $cacheKey);
        }

        return $currencies;
    }

    private function _saveCurrenciesCaching (array $currencies, $cacheKey) {
        if(count($currencies)){
            Cache::put("currencies_{$cacheKey}", $currencies, 60 * self::CACHING_TIME);
        }
    }

    private function _generateCacheKey(array $codes)
    {
        return implode('_', array_map(fn($v) => is_array($v) ? implode('_', $v) : $v, $codes));
    }

    private function _validateInput($inputKeys, $strategyMap){
        if (count($inputKeys) !== 1 || !isset($strategyMap[$inputKeys[0]])) {
            throw new Exception('Chave incorreta', 422);
        }
    }
}
