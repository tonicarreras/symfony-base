<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiResponse
 * This abstract class extends the JsonResponse class from Symfony and is used to create API responses.
 * It provides a constructor to format the data to be returned in the response.
 */
abstract class ApiResponse extends JsonResponse
{

    /**
     * ApiResponse constructor.
     * @param mixed|null $data The data to be returned in the response.
     * @param int $status The HTTP status code for the response.
     * @param string $message The message to be included in the response.
     * @param string $type The type of the response.
     * @param bool $error Indicates whether the response is an error response.
     */
    public function __construct(
        $data,
        int $status,
        string $message,
        string $type,
        bool $error
    )
    {
        $formattedData = [
            'error' => $error,
            'type' => $type,
            'message' => $message,
            'data' => $data,
        ];
        parent::__construct($formattedData, $status);
    }
}