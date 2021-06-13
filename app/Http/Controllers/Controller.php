<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Response padrão.
     *
     * @var array
     */
    protected $defaultResponse = [
        'message' => null,
        'data' => null,
        'errors' => null,
    ];

    /**
     * Muda os valores do response padrão.
     *
     * @param array $jsonData
     * @return array
     */
    private function makeResponse(array $jsonData)
    {
        $response = $this->defaultResponse;

        foreach ($jsonData as $key => $value) {
            $response[$key] = $value;
        }
        foreach ($response as $key => $value) {
            if (is_null($value)) {
                unset($response[$key]);
            }
        }

        return $response;
    }

    /**
     * Response de sucesso padrão [message, data].
     *
     * @param array $jsonData
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess(array $jsonData, int $code = Response::HTTP_OK)
    {
        $response = $this->makeResponse([
            'message' => $jsonData['message'],
            'data' => $jsonData['data'] ?? null,
        ]);

        return response()->json($response, $code);
    }

    /**
     * Response de coleta de dados padrão [data].
     *
     * @param array $jsonData
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseData(array $jsonData, int $code = Response::HTTP_OK)
    {
        $response = $this->makeResponse([
            'data' => $jsonData,
        ]);

        return response()->json($response, $code);
    }

    /**
     * Response de erro padrão [message, data?, errors].
     *
     * @param array $jsonData
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError(array $jsonData, int $code = Response::HTTP_BAD_REQUEST)
    {
        $response = $this->makeResponse([
            'message' => $jsonData['message'],
            'data' => $jsonData['data'] ?? null,
            'errors' => $jsonData['errors'] ?? null,
        ]);

        return response()->json($response, $code);
    }


    /**
     * Response de erro padrão [message, data?, errors, exception?].
     *
     * @param array $jsonData
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseErrorServer(array $jsonData, int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = $this->makeResponse([
            'message' => $this->makeMessageError($jsonData),
            'data' => $jsonData['data'] ?? null,
            'exception' => env('APP_DEBUG') ? $jsonData['exception'] : null,
        ]);

        return response()->json($response, $code);
    }

    /**
     * Monta a mensagem de erro.
     *
     * @param array $jsonData
     * @return string
     */
    private function makeMessageError(array $jsonData)
    {
        $messageEnd = ' Please try later!';

        if (array_key_exists('sentence_ending', $jsonData)) {
            if (is_bool($jsonData['sentence_ending']) && $jsonData['sentence_ending']) {
                $messageEnd = $jsonData['sentence_ending'];
            } else {
                $messageEnd = '';
            }
        }

        return $jsonData['message'] . $messageEnd;
    }
}
