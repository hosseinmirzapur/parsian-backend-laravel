<?php

use App\Exceptions\CustomException;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('successResponse')) {
    /**
     * @param array $data
     * @return JsonResponse
     */
    function successResponse(array $data = []): JsonResponse
    {
        return response()->json($data);
    }
}

if (!function_exists('errorResponse')) {
    /**
     * @param $data
     * @param int $status
     * @return JsonResponse
     */
    function errorResponse($data, int $status = 400): JsonResponse
    {
        return response()->json($data, $status);
    }
}

if (!function_exists('exists')) {
    /**
     * @param mixed $data
     * @return bool
     */
    function exists(mixed $data): bool
    {
        return isset($data) && $data != '' && $data != null;
    }
}

if (!function_exists('filterData')) {
    /**
     * @param array $data
     * @return array
     * @throws CustomException
     */
    function filterData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (!exists($value)) {
                unset($data[$key]);
            }
        }
        if (empty($data)) {
            throw new CustomException('invalid data');
        }
        return $data;

    }
}

if (!function_exists('handleFile')) {
    /**
     * @param $file
     * @return string
     * @throws CustomException
     */
    function handleFile($file): string
    {
        $filename = time() . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        $result = Storage::drive('liara')->put($filename, file_get_contents($file), 'public');

        if (!$result) {
            throw new CustomException('problem uploading file to s3');
        }
        return $filename;
    }
}

if (!function_exists('authUser')) {

    function authUser(): Authenticatable | User | Admin
    {
        return auth('sanctum')->user();
    }
}
