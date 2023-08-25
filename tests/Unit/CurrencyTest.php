<?php

namespace Tests\Unit;

use App\Domains\ClientRequest\Adapters\ClientGuzzleRequestAdapter;
use App\Domains\Currency\Repositories\GetCurrencyRepository;
use App\Domains\Currency\Services\DataFilterContext;
use App\Domains\Currency\Services\GetCurrencyService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_should_be_able_to_get_a_currency_by_single_code()
    {
        $data = [
            'code' => 'BRL',
        ];

        $httpClient = new ClientGuzzleRequestAdapter();
        $context = new DataFilterContext();
        $repository = new GetCurrencyRepository();

        $currencyService = new GetCurrencyService($httpClient, $context, $repository);

        $createdCurrency = $currencyService->execute($data);
        $this->assertIsArray($createdCurrency);
        $this->assertEquals('BRL', $createdCurrency[0]['code']);
    }

    /**
     * @test
     */
    public function test_should_be_able_to_get_a_currency_by_single_number()
    {
        $data = [
            'number' => 986,
        ];

        $httpClient = new ClientGuzzleRequestAdapter();
        $context = new DataFilterContext();
        $repository = new GetCurrencyRepository();

        $currencyService = new GetCurrencyService($httpClient, $context, $repository);

        $createdCurrency = $currencyService->execute($data);
        $this->assertIsArray($createdCurrency);
        $this->assertEquals(986, $createdCurrency[0]['number']);
    }

    /**
     * @test
     */
    public function test_should_be_able_to_get_a_currency_by_multi_code()
    {
        $data = [
            'code_list' => ['BRL','EUR'],
        ];

        $httpClient = new ClientGuzzleRequestAdapter();
        $context = new DataFilterContext();
        $repository = new GetCurrencyRepository();

        $currencyService = new GetCurrencyService($httpClient, $context, $repository);

        $createdCurrency = $currencyService->execute($data);
        $this->assertIsArray($createdCurrency);
        $this->assertEquals('BRL', $createdCurrency[0]['code']);
        $this->assertEquals('EUR', $createdCurrency[1]['code']);
    }


    /**
     * @test
     */
    public function test_should_be_able_to_get_a_currency_by_multi_numbers()
    {
        $data = [
            'number_list' => [986,978],
        ];

        $httpClient = new ClientGuzzleRequestAdapter();
        $context = new DataFilterContext();
        $repository = new GetCurrencyRepository();

        $currencyService = new GetCurrencyService($httpClient, $context, $repository);

        $createdCurrency = $currencyService->execute($data);
        $this->assertIsArray($createdCurrency);
        $this->assertEquals(986, $createdCurrency[0]['number']);
        $this->assertEquals(978, $createdCurrency[1]['number']);
    }


    /**
     * @test
     */
    public function test_should_not_be_able_to_get_a_currency_with_invalid_keys()
    {
        $data = [
            'codes' => 'BRL',
        ];

        $httpClient = new ClientGuzzleRequestAdapter();
        $context = new DataFilterContext();
        $repository = new GetCurrencyRepository();

        $currencyService = new GetCurrencyService($httpClient, $context, $repository);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Chave incorreta');

        $currencyService->execute($data);
    }

}
