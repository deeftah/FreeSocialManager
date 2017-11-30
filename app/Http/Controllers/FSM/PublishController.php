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
                    $this->telegram($clientAccount, $result);
                }
                if ($clientAccount->template == "instagram") {
                    $this->instagram($clientAccount, $result);
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

    public function telegram($clientAccount, $result)
    {
        $metas = json_decode($clientAccount->metas);
        $telegram = new Api($metas->bot_token);
        $response = $telegram->sendPhoto([
            'chat_id' => '@' . $metas->channel_username,
            'photo' => public_path('uploads' . $result->image),
            'caption' => $result->description
        ]);
        Log::info($response->getMessageId());
    }

    public function instagram($clientAccount, $result)
    {
        $metas = json_decode($clientAccount->metas);
        $username = $metas->username;
        $password = $metas->password;
        $debug = true;
        $truncatedDebug = true;

        $photoFilename = public_path('uploads' . $result->image);
        $captionText = $result->description;

        $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
        try {
            $ig->login($username, $password);
        } catch (\Exception $e) {
            Log::alert('Something went wrong: ' . $e->getMessage() . "\n");
            exit(0);
        }
        try {
            $upload =$ig->timeline->uploadPhoto($photoFilename, ['caption' => $captionText]);
            Log::info(print_r($upload, true));
        } catch (\Exception $e) {
            Log::alert('Something went wrong: ' . $e->getMessage() . "\n");
        }
    }
}
