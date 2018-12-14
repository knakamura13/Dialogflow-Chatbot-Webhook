<?php

// MARK: Webhook configuration and function-intent mapping

// Configure this file as a webhook for DialogFlow.
header('Content-Type: application/json');
$request = file_get_contents('php://input');

// Convert the raw JSON request to a PHP object.
$requestData = json_decode($request);

// Execute a function depending on the intent from the request.
$intent = $requestData->queryResult->intent->displayName;
switch ($intent) {
    case "Dining Account Balance":
        diningAccountBalanceIntent();
        break;
    case "Get Stock Price":
        stockPriceIntent();
        break;
    default:
        fallbackIntent();
        break;
}



// MARK: Intent-handling functions

function diningAccountBalanceIntent() {
    global $requestData;

}

function stockPriceIntent() {
    global $requestData;

    $newCard = messageCard("Stock Price Intent", "The response for the stock price intent", "https://mobile.apu.edu/images/gmail.jpeg", "Button Text", "https://google.com");
    createFulfillmentResponse([
        fulfillmentMessages([
            $newCard
        ])
    ]);
}

function fallbackIntent() {
    global $requestData;

    $newCard = messageCard("Fallback Intent", "The response for the fallback intent", "https://mobile.apu.edu/images/gmail.jpeg", "Button Text", "https://google.com");
    createFulfillmentResponse([
        fulfillmentMessages([
            $newCard
        ])
    ]);
}



// MARK: JSON response formatting functions

function createFulfillmentResponse($responseItems) {
    $response = "
        {
    ";

    foreach ($responseItems as $index => $item) {
        $response .= $item;

        if ($index < (count($responseItems) - 1)) {
            $response .= ",";
        }
    }

    $response .= "
        }
    ";

    echo $response;
}

function fulfillmentText($text) {
    $fulfillmentText = "
        'fulfillmentText': '$text'
    ";

    return $fulfillmentText;
}

function fulfillmentMessages($messages) {
    $fulfillmentMessages = "
        'fulfillmentMessages': [
    ";

    foreach ($messages as $index => $message) {
        $fulfillmentMessages .= $message;

        if ($index < (count($messages) - 1)) {
            $fulfillmentMessages .= ",";
        }
    }

    $fulfillmentMessages .= "
        ]
    ";

    return $fulfillmentMessages;
}

function messageCard($title, $subtitle, $imageURI, $buttonText, $buttonURL) {
    $messageCard = "
        {
            'card': {
                'title': '$title',
                'subtitle': '$subtitle',
                'imageUri': '$imageURI',
                'buttons': [
                    {
                        'text': '$buttonText',
                        'postback': '$buttonURL'
                    }
                ]
            }
        }
    ";

    return $messageCard;
}

?>
