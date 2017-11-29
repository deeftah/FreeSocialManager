<?php

namespace App\Http\Controllers\FSM;

use App\Http\Controllers\Controller;
use App\Models\ClientAccount;
use App\Models\Publish;
use App\Models\PublishClientAccount;
use DateTime;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class PublishController extends Controller
{
    public function index()
    {
        $date = new DateTime;
        $date->modify('+1 minute');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $results = Publish::whereDate('datetime', '<=', $formatted_date)
            ->where('published', 0)
            ->get();

        foreach ($results as $result) {
            $publishClientAccounts = $this->publishClientAccounts($result->id);
            foreach ($publishClientAccounts as $publishClientAccount) {
                $clientAccount = $this->clientAccount($publishClientAccount->client_account_id);
                if ($clientAccount->template == "telegram") {
                    $metas = json_decode($clientAccount->metas);
                    $telegram = new Api($metas->bot_token);
                    $response = $telegram->sendPhoto([
                        'chat_id' => '@' . $metas->channel_username,
                        'photo' => public_path('uploads' . $result->image),
                        'caption' => $result->description
                    ]);
                    Log::info($response->getMessageId());
                }
            }

        }
    }

    public function publishClientAccounts($publish_id)
    {
        return PublishClientAccount::where('publish_id', $publish_id)->get();
    }

    public function clientAccount($client_account_id)
    {
        return ClientAccount::find($client_account_id);
    }
}
