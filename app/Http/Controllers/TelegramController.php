<?php

namespace App\Http\Controllers;

use App\ExternalServices\TelegramService;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Request as TelegramBotRequest;
use Longman\TelegramBot\Entities\InlineQuery\InlineQueryResultVoice;

class TelegramController extends Controller
{
    private TelegramService $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function webhook(Request $request)
    {
        $inlineQuery = $request->input('inline_query');
        $query = $inlineQuery['query'];

        TelegramBotRequest::initialize($this->telegramService->telegram());

        if (!$query) {
            Log::info('no inline query');

            TelegramBotRequest::answerInlineQuery([
                'inline_query_id' => $inlineQuery['id'],
                'results' => [],
                'cache_time' => 0
            ]);

            return;
        }

        /* Results */
        $queryWithTag = explode('#', $query);
        if (isset($queryWithTag[1])) {
            $tag = $queryWithTag[0];
            $query = $queryWithTag[1];

            $recordQuery = Record::with([
                'tags'
            ])
                ->whereHas('tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                })
                ->where('name', 'like', '%' . $query . '%');
        } else {
            $recordQuery = Record::where('name', 'like', '%' . $query . '%')
                ->where('default_search_available', 1);
        }

        $results = $recordQuery
            ->limit(50)
            ->get();

        $voices = $results->map(function ($record) {
            return new InlineQueryResultVoice([
                'type' => 'voice',
                'id' => $record->id,
                'voice_url' => $record->url(),
                'title' => $record->name
            ]);
        });

        Log::info($voices);

        TelegramBotRequest::answerInlineQuery([
            'inline_query_id' => $inlineQuery['id'],
            'results' => $voices,
            'cache_time' => 0
        ]);
    }

    public function setWebhook(Request $request)
    {
        $request->validate([
            'url' => [
                'required',
                'active_url'
            ]
        ]);

        // Set Webhook
        $result = $this
            ->telegramService
            ->telegram()
            ->setWebhook($request->input('url'));

        return response()
            ->json([
                'ok' => $result->isOk() ? 1 : 0,
                'data' => $result->getDescription()
            ]);
    }

    public function getWebhookInfo(Request $request)
    {
        TelegramBotRequest::initialize($this->telegramService->telegram());
        $result = TelegramBotRequest::getWebhookInfo();

        return response()
            ->json([
                'data' => $result->getRawData()
            ]);
    }
}
