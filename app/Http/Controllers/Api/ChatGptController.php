<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\ApiLibraries\ChatGptApi;
use App\Http\Controllers\Controller;


class ChatGptController extends Controller
{
    public function createThread() {
        $chatGptApi = new ChatGptApi();
        $threadId = $chatGptApi->createThread();
        return $threadId;
    }

    public function addMessage(Request $request, $threadId) {
        $chatGptApi = new ChatGptApi();
        $message = $request->input('message');
        $apiResponse = $chatGptApi->addMessage($threadId, $message);
       
        $jsonData = $apiResponse->getContent();
        $decodedData = json_decode($jsonData, true);

        return $decodedData;
    }
}