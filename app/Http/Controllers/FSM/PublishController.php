<?php

namespace App\Http\Controllers\FSM;

use App\Http\Controllers\Controller;
use App\Models\ClientAccount;
use App\Models\Publish;
use App\Models\PublishClientAccount;
use Carbon\Carbon;
use Telegram\Bot\Api;

class PublishController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->addMinute(1);
        $results = Publish::dateSmaller($date)->notPublished()->get();
        foreach ($results as $result) {
            $publishClientAccounts = $this->publishClientAccounts($result->id);
            foreach ($publishClientAccounts as $publishClientAccount) {
                $clientAccount = $this->clientAccount($publishClientAccount->client_account_id);
                $template = $clientAccount->template;
                $this->$template($clientAccount, $result, $publishClientAccount);
            }
            $result->published = 1;
            $result->save();
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

    public function telegram($clientAccount, $result, $publishClientAccount)
    {
        $metas = json_decode($clientAccount->metas);
        try {
            $telegram = new Api($metas->bot_token);
            $response = $telegram->sendPhoto([
                'chat_id' => '@' . $metas->channel_username,
                'photo' => public_path('uploads' . $result->image),
                'caption' => $result->description
            ]);
            $publishClientAccount->logs = $response->getMessageId();
            $publishClientAccount->published = 1;
            $publishClientAccount->save();
        } catch (\Exception $e) {
            $publishClientAccount->logs = $e;
            $publishClientAccount->save();
        }
    }

    public function instagram($clientAccount, $result, $publishClientAccount)
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
            $publishClientAccount->logs = print_r($e->getMessage(), true);
            $publishClientAccount->save();
            exit(0);
        }
        try {
            $upload = $ig->timeline->uploadPhoto($photoFilename, ['caption' => $captionText]);
            $publishClientAccount->logs = print_r($upload, true);
            $publishClientAccount->published = 1;
            $publishClientAccount->save();
        } catch (\Exception $e) {
            $publishClientAccount->logs = print_r($e->getMessage(), true);
            $publishClientAccount->save();
            exit(0);
        }
    }
}
