<?php
return [ 
    'apiKey' => env('ALEPAY_TOKEN',''),//Là key dùng để xác định tài khoản nào đang được sử dụng.
    'encryptKey' => env('ALEPAY_DATA',''),//Là key dùng để mã hóa dữ liệu truyền tới Alepay.
    'checksumKey' => env('ALEPAY_CHECKSUM_KEY',''),//Là key dùng để tạo checksum data.
    'callbackUrl' => env('PAYMENT_CALLBACK_URL',''),
    'env' => env('ALEPAY_MODE','')
];
?>