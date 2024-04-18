<?php

namespace App\Http\Api\Controllers;
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

    public function addMessage($threadId) {
        $chatGptApi = new ChatGptApi();
        $apiResponse = $chatGptApi->addMessage($threadId);
       
        $jsonData = $apiResponse->getContent();
        $decodedData = json_decode($jsonData, true);

        return $decodedData;
    }
}