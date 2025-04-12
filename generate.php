<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$prompt = $_POST['prompt'] ?? '';

if (!$prompt) {
    echo json_encode(['error' => 'Prompt is required']);
    exit;
}

$api_key = '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'; // Replace with your token
$model = 'stabilityai/stable-diffusion-2';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-inference.huggingface.co/models/$model");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['inputs' => $prompt]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer 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",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

// return base64
echo json_encode(['image' => base64_encode($response)]);
?>
