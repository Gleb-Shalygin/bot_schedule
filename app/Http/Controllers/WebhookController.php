<?php

namespace App\Http\Controllers;

use App\Helpers\Telegram;
use App\Service\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    public function index(Request $request, WebhookService $webhookService)
    {
        return $webhookService->index($request->all());
    }

}
