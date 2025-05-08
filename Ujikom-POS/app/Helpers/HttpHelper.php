<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class HttpHelper
{
    public static function postMultipart($url, array $formFields, $fileField = null, UploadedFile $file = null)
    {
        $multipart = [];

        // Tambahkan form fields ke multipart
        foreach ($formFields as $key => $value) {
            $multipart[] = [
                'name' => $key,
                'contents' => (string) $value,
            ];
        }

        // Tambahkan file jika ada
        if ($fileField && $file) {
            $multipart[] = [
                'name'     => $fileField,
                'contents' => fopen($file->getPathname(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        return Http::withHeaders([
            'Accept' => 'application/json',
        ])->send('POST', $url, [
            'multipart' => $multipart,
        ]);
    }

    public static function putMultipart($url, array $formFields, $fileField = null, UploadedFile $file = null)
    {
        $multipart = [];

        // Tambahkan form fields ke multipart
        foreach ($formFields as $key => $value) {
            $multipart[] = [
                'name' => $key,
                'contents' => (string) $value,
            ];
        }

        // Tambahkan file jika ada
        if ($fileField && $file) {
            $multipart[] = [
                'name'     => $fileField,
                'contents' => fopen($file->getPathname(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        return Http::withHeaders([
            'Accept' => 'application/json',
        ])->send('PUT', $url, [
            'multipart' => $multipart,
        ]);
    }
}
