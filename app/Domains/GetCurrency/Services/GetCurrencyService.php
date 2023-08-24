<?php
namespace App\Domains\GetCurrency\Services;

use App\Domains\ClientRequest\Ports\ClientHttpRequestPort;
use App\Domains\GetCurrency\Adapters\MultiCodesFilterStrategy;
use App\Domains\GetCurrency\Adapters\MultiNumbersFilterStrategy;
use App\Domains\GetCurrency\Adapters\SingleCodeFilterStrategy;
use App\Domains\GetCurrency\Adapters\SingleNumberFilterStrategy;
use Illuminate\Http\Request;

class GetCurrencyService {

    private ClientHttpRequestPort $clienteHttp;
    private DataFilterContext $context;

    public function __construct(ClientHttpRequestPort $clienteHttp, DataFilterContext $context) {
        $this->clienteHttp = $clienteHttp;
        $this->context = $context;
    }

    /**
     * Facade to execute the crawl
     *
     * @param  mixed $request
     * @return void
     */
    public function execute(Request $request) {
        $strategyMap = [
            'code' => SingleCodeFilterStrategy::class,
            'code_list' => MultiCodesFilterStrategy::class,
            'number' => SingleNumberFilterStrategy::class,
            'number_list' => MultiNumbersFilterStrategy::class,
        ];

        $inputKeys = $request->keys();

        $this->_validateInput($inputKeys, $strategyMap);

        $strategy = app($strategyMap[$inputKeys[0]]);

        $html = $this->clienteHttp->execute('https://pt.wikipedia.org/wiki/ISO_4217');

        return $this->context->setStrategy($strategy)->filterData($html, $request->get($inputKeys[0]));
    }

    /**
     * Validate inputs
     *
     * @param  mixed $inputKeys
     * @param  mixed $strategyMap
     * @return void
     */
    private function _validateInput($inputKeys, $strategyMap){
        if (count($inputKeys) !== 1 || !isset($strategyMap[$inputKeys[0]])) {
            abort(422, "Chave incorreta");
        }
    }
}
