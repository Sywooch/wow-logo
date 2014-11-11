<?php

return [
    'adminEmail' => 'admin@example.com',
    'siteEmail' => 'robot@creativeLogo.com',
    'portfolioItemsPerPage' => 3,
//tariffs
    'priceForFixes' => 999,
    //TARIFF_START
    'tariff1Price' => 2999,
    'tariff1PriceNoDisc' => 4000,
    'tariff1LogoVariants' => 1,
    //TARIFF_BUSINESS
    'tariff2Price' => 12799,
    'tariff2PriceNoDisc' => 17500,
    'tariff2LogoVariants' => 3,
    //TARIFF_SCROOGE
    'tariff3Price' => 73999,
    'tariff3PriceNoDisc' => 80000,
    'tariff3LogoVariants' => 7,
//robokassa
    'baseUrl' => 'http://test.robokassa.ru/Index.aspx', //TODO: change URL from testserver to this one 'https://auth.robokassa.ru/Merchant/Index.aspx',
    'sMerchantLogin' => 'test_cl',
    'sMerchantPass1' => 'test_cl_1',
    'sMerchantPass2' => 'test_cl_2',
//clientReview
    'uploadPathClientReview' => '/web/uploads/client-review/',
    'uploadUrlClientReview' => '/uploads/client-review/',
//portfolio
    'uploadPathPortfolio' => '/web/uploads/portfolio/',
    'uploadUrlPortfolio' => '/uploads/portfolio/',
//order
    'uploadPathOrder' => '/web/uploads/order/',
    'uploadUrlOrder' => '/uploads/order/',
//questionAnswer
    'uploadPathQuestionAnswer' => '/web/uploads/question-answer/',
    'uploadUrlQuestionAnswer' => '/uploads/question-answer/',
];