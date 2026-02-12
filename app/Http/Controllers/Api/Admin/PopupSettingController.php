<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PopupSettingController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'popup_enabled' => filter_var(Setting::getValue('popup_enabled', 'true'), FILTER_VALIDATE_BOOLEAN),
            'popup_text' => Setting::getValue('popup_text', ''),
            'popup_repeat_hours' => (int) Setting::getValue('popup_repeat_hours', '24'),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $payload = $request->only(['popup_enabled', 'popup_text', 'popup_repeat_hours']);

        foreach ($payload as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        return $this->show();
    }
}
