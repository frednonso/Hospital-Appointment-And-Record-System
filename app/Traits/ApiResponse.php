<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Carbon\Carbon;

trait ApiResponse
{
    /**
     * Standard success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param array $meta Optional additional metadata (pagination, etc.)
     * @param array $additional Optional extra fields (like is_auth)
     * @return JsonResponse
     */
    protected function successResponse(
        $data = null,
        string $message = 'Success',
        int $status = 200,
        array $meta = [],
        array $additional = []
    ): JsonResponse {
        // Convert any Carbon dates in data to ISO-8601
        $data = $this->formatDates($data);

        $response = array_merge([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $additional);

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    /**
     * Standard error response
     *
     * @param string $message
     * @param int $status
     * @param mixed $data
     * @param array $additional Optional extra fields
     * @return JsonResponse
     */
    protected function errorResponse(
        string $message = 'Error',
        int $status = 400,
        $data = null,
        array $additional = []
    ): JsonResponse {
        // Convert any Carbon dates in data to ISO-8601
        $data = $this->formatDates($data);

        $response = array_merge([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $additional);

        return response()->json($response, $status);
    }

    /**
     * Recursively convert Carbon instances to ISO-8601 strings
     *
     * @param mixed $data
     * @return mixed
     */
    private function formatDates($data)
    {
        if ($data instanceof Carbon) {
            return $data->toIso8601String();
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->formatDates($value);
            }
        }

        if (is_object($data)) {
            foreach ($data as $key => $value) {
                if ($value instanceof Carbon) {
                    $data->$key = $value->toIso8601String();
                } elseif (is_array($value) || is_object($value)) {
                    $data->$key = $this->formatDates($value);
                }
            }
        }

        return $data;
    }
}
