<?php
header('Content-Type: application/json');

// Read POST body and decode JSON
$input = json_decode(file_get_contents('php://input'), true);

// Check if question is present
if (!isset($input['question'])) {
    echo json_encode(['error' => 'No question provided']);
    exit;
}

// ✅ Your Hugging Face API key goes here
$api_key = "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";

// Model endpoint (you can use other models too)
$model_url = "https://api-inference.huggingface.co/models/google/flan-t5-small";

// Prepare request payload
$data = [
    "inputs" => $input['question']
];

// Send request to Hugging Face
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $model_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $api_key",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
} else {
    echo $response;
}
curl_close($ch);
?>
