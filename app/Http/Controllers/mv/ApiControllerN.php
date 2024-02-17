<?php

namespace App\Http\Controllers\mv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApiControllerN extends Controller
{
    public function fetchAndSaveData()
    {   
        set_time_limit(300);
        $allProductIds = $this->getAllProductIds();
        $uniqueIds = array_unique($allProductIds);
        $productInfo = $this->getProductInfo($uniqueIds); 
        $pp=$this->getProductsPrice($uniqueIds);

        $combinedProducts = [];
        foreach ($productInfo as $info) {
            foreach ($pp as $price) {
                if ($info['productId'] === $price['productId']) {
                    $combinedProducts[] = array_merge($info, $price);
                    break;
                }
            }
        }
        $dataToSave = [
            'product'=> $combinedProducts,
        ];

        $jsonOptions = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;
        $jsonData = json_encode($dataToSave, $jsonOptions);
        $jsonFilePath = public_path('json/mvn.json');
        file_put_contents($jsonFilePath, $jsonData);
    
        if (file_put_contents($jsonFilePath, $jsonData) !== false) {
            return response()->json(['message' => 'Данные успешно сохранены в json/mvn.json']);
        } else {
            return response()->json(['message' => 'Ошибка при сохранении данных'], 500);
        }
    }

    public function getAllProductIds()
    { 
            $offset = 0;
            $limit = 24;
            $allProducts = [];
            while (true) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.mvideo.ru/bff/products/listing?categoryId=118&offset={$offset}&limit={$limit}&filterParams=WyJ0b2xrby12LW5hbGljaGlpIiwiLTEyIiwiZGEiXQ%3D%3D&doTranslit=true");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'authority: www.mvideo.ru',
                    'accept: application/json',
                    'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                    'baggage: sentry-environment=production,sentry-public_key=1e9efdeb57cf4127af3f903ec9db1466,sentry-trace_id=60b3c79f561a44c1a6e135bceaa7209c,sentry-sample_rate=0.5,sentry-transaction=%2F**%2F,sentry-sampled=true',
                    'referer: https://www.mvideo.ru/noutbuki-planshety-komputery-8/noutbuki-118',
                    'sec-ch-ua: "Chromium";v="118", "Opera GX";v="104", "Not=A?Brand";v="99"',
                    'sec-ch-ua-mobile: ?0',
                    'sec-ch-ua-platform: "Windows"',
                    'sec-fetch-dest: empty',
                    'sec-fetch-mode: cors',
                    'sec-fetch-site: same-origin',
                    'sentry-trace: 60b3c79f561a44c1a6e135bceaa7209c-a14786da0d19da9b-1',
                    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36 OPR/104.0.0.0',
                    'x-set-application-id: 00bf7e8e-5ffa-4a73-8f77-6742759e4de1',
                    'accept-encoding: gzip',
                ]);
                curl_setopt($ch, CURLOPT_COOKIE, 'MVID_GUEST_ID=23238538005; MVID_VIEWED_PRODUCTS=; wurfl_device_id=generic_web_browser; MVID_CALC_BONUS_RUBLES_PROFIT=false; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=false; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=true; HINTS_FIO_COOKIE_NAME=2; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; flacktory=no; BIGipServeratg-ps-prod_tcp80=2466569226.20480.0000; bIPs=-314595793; MVID_ENVCLOUD=prod2; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; MVID_GEOLOCATION_NEEDED=false; BIGipServeratg-ps-prod_tcp80_clone=2466569226.20480.0000; utm_term=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; _ym_uid=1700639495957897813; _ym_d=1700639495; advcake_click_id=; uxs_uid=0db82990-890c-11ee-907d-97f26918b974; MVID_AB_UPSALE=true; MVID_ALFA_PODELI_NEW=true; MVID_CASCADE_CMN=true; MVID_CHAT_VERSION=4.16.4; MVID_CREDIT_DIGITAL=true; MVID_CREDIT_SERVICES=true; MVID_FILTER_CODES=true; MVID_FLOCKTORY_ON=true; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PODELI_PDP=true; MVID_SERVICES=111; MVID_SERVICE_AVLB=true; MVID_SINGLE_CHECKOUT=true; MVID_SP=true; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_TRANSACTIONS_RATE=0.5; _ga=GA1.1.1465051681.1700639494; SMSError=; authError=; __SourceTracker=google__organic; admitad_deduplication_cookie=google__organic; __cpatrack=google_organic; __sourceid=google; __allsource=google; advcake_track_id=0e5d5e9d-4ae7-b527-58d6-8d9810502d72; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2Fnoutbuki-planshety-komputery-8%2Fnoutbuki-118%3Freff%3Dmenu_main%26utm_source%3Dgoogle%26utm_medium%3Dorganic%26utm_campaign%3Dgoogle%26utm_referrer%3Dgoogle; advcake_utm_partner=google; advcake_utm_webmaster=; MVID_CITY_ID=CityR_27; MVID_REGION_ID=27; MVID_REGION_SHOP=S966; MVID_TIMEZONE_OFFSET=5; MVID_KLADR_ID=7400000900000; MVID_FILTER_TOOLTIP=1; MVID_LAYOUT_TYPE=1; MVID_EMPLOYEE_DISCOUNT=true; __lhash_=ee484b0ec31fb068935cf82d6a302f4b; cfidsgib-w-mvideo=HtR+D0fdG2aMacvkqXjWyvAWdvx+RhVRkpHhpsp6Mp5QYD/byUChkqD5DB62yUGTQOR8SQIWLueXLh6kUFn97jJIBsgrByqoxa1BWeI4cTthBHiO2Wg+20bJDkojIGzE+8r9CzNeOrdclIs/rb1rYFUNHHWRasNCAIT15LA=; __hash_=7cac287abcf2bd1ee76600d84b6ad0e0; MVID_AB_PERSONAL_RECOMMENDS=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_CROSS_POLLINATION=true; MVID_DISPLAY_ACCRUED_BR=1; MVID_IS_NEW_BR_WIDGET=true; MVID_MINDBOX_DYNAMICALLY=true; SENTRY_ERRORS_RATE=0.1; _sp_ses.d61c=*; MVID_CITY_CHANGED=false; JSESSIONID=hbyjlsLYbdhG1l67B8RWzLhbcQttqJkFg6BjvbQ2XvTRJLhWknSz!1383105283; CACHE_INDICATOR=true; _ym_isad=2; _sp_id.d61c=7afa0d0d-341c-4606-b1c2-d8a00afa047c.1700639494.23.1701612388.1701279401.c586f891-a244-4afc-9d25-7a78185f9180.af3bd627-8bda-42c6-ac5d-f65189be4c9d.3c6ac57d-ce63-4ebd-864a-b095b4347014.1701612375384.28; gsscgib-w-mvideo=AupTgqhbaBnQN7mt5zuarmm83m6JBLyFaNhduD0fOpwCwaNVXpBF8JyjVcUa0qQ1WNvitntE4M3CeOQpQx1uVKSb1JahudMsiPHEfA7zKIFdsAUW2RBCWVeY43aV+cVmITEf1d+CABA9NPsoHMS5+iCBErCyXzWIIHbDo5FmEvaloPpkLaih5WOKvUBRUzNnYyz/KLab51ptgW1ivzr53bmXQaqK+0OjXiJvW+UudtDNqHGZpGhFiM7ihQpEjg==; gsscgib-w-mvideo=AupTgqhbaBnQN7mt5zuarmm83m6JBLyFaNhduD0fOpwCwaNVXpBF8JyjVcUa0qQ1WNvitntE4M3CeOQpQx1uVKSb1JahudMsiPHEfA7zKIFdsAUW2RBCWVeY43aV+cVmITEf1d+CABA9NPsoHMS5+iCBErCyXzWIIHbDo5FmEvaloPpkLaih5WOKvUBRUzNnYyz/KLab51ptgW1ivzr53bmXQaqK+0OjXiJvW+UudtDNqHGZpGhFiM7ihQpEjg==; advcake_session_id=e1e6a0ba-fcdb-adcb-148b-7640587d4696; fgsscgib-w-mvideo=2COiefa385561c1ad0aed7955e3b6f32e6cb6ed1; fgsscgib-w-mvideo=2COiefa385561c1ad0aed7955e3b6f32e6cb6ed1; _ga_CFMZTSS5FM=GS1.1.1701612375.23.1.1701612396.0.0.0; _ga_BNX5WPP3YK=GS1.1.1701612375.23.1.1701612396.39.0.0');

                $response = curl_exec($ch);
                $response = gzdecode($response);
                $data = json_decode($response, true);
                $products = $data['body']['products'];
                $allProducts = array_merge($allProducts, $products);
                curl_close($ch);
                $offset += $limit;

                if (count($products) < $limit) {
                    echo '<h1>Общее количество';
                    echo count($allProducts);
                    echo '</h1>';
                    return $allProducts;
                }

            }
        }
    public function getProductInfo($products)
    {   
        $result = [];
        $chunkSize = 24;
        $productChunks = array_chunk($products, $chunkSize);
        foreach ($productChunks as $productChunk) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.mvideo.ru/bff/product-details/list');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'authority: www.mvideo.ru',
                'accept: application/json',
                'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                'baggage: sentry-environment=production,sentry-public_key=1e9efdeb57cf4127af3f903ec9db1466,sentry-trace_id=bb606a2cdc464279b1ee708e57d49aa7,sentry-sample_rate=0.5,sentry-transaction=%2F**%2F,sentry-sampled=true',
                'content-type: application/json',
                'origin: https://www.mvideo.ru',
                'referer: https://www.mvideo.ru/noutbuki-planshety-komputery-8/noutbuki-118/f/tolko-v-nalichii=da?reff=menu_main&page=3',
                'sec-ch-ua: "Chromium";v="118", "Opera GX";v="104", "Not=A?Brand";v="99"',
                'sec-ch-ua-mobile: ?1',
                'sec-ch-ua-platform: "Android"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'sentry-trace: bb606a2cdc464279b1ee708e57d49aa7-b66a5552fbdbe054-1',
                'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Mobile Safari/537.36',
                'x-gib-fgsscgib-w-mvideo: kmU678b547f49977423a62247261f2f38067335f',
                'x-gib-gsscgib-w-mvideo: nZKnMfvqLycEjS9mW6BK3dWIWXIUmz46u9ClD032suakCMDwNrpNcGJIKYcDOj0RPH9TR7ZHFTZju8Fj6QR3JWA2HiOX6dkH0wBxsChmhibh6kSQ4/ucE+qYLSDWUH+sa1anq3WX8FKTvXbmqOMFa48zcxQLIacfQUgDkOQHGxv4uFM9/CFrQ6MuPi0XNuhfVpMVpNW7wqSSPXO6SXpIVvFxVoJ4twBRRxkJxo/W4gV+fEhkKn6xEC8N0gqJTD6P0aO/3h0XQuwrc1ACzOo=',
                'x-set-application-id: fca5af97-cfba-4a4f-9305-ddbac6f9d082',
                'accept-encoding: gzip',
            ]);
            curl_setopt($ch, CURLOPT_COOKIE, '__lhash_=2f48602d05fa90e5f08e9bbfe606b329; MVID_CITY_ID=CityCZ_975; MVID_GUEST_ID=23238538005; MVID_VIEWED_PRODUCTS=; wurfl_device_id=generic_web_browser; JSESSIONID=JpzYldzBG7DTJLsvs44kr27Q2QqMn0B58pfqH5kfLVtXYWRpSCJd!1094297638; MVID_CALC_BONUS_RUBLES_PROFIT=false; MVID_REGION_ID=1; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=false; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=true; HINTS_FIO_COOKIE_NAME=2; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; flacktory=no; BIGipServeratg-ps-prod_tcp80=2466569226.20480.0000; bIPs=-314595793; MVID_ENVCLOUD=prod2; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; MVID_GEOLOCATION_NEEDED=false; BIGipServeratg-ps-prod_tcp80_clone=2466569226.20480.0000; admitad_uid=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; utm_term=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; _ym_uid=1700639495957897813; _ym_d=1700639495; advcake_session_id=58b1e79c-2fc4-92ad-89c9-3533d7bb68f0; advcake_click_id=; uxs_uid=0db82990-890c-11ee-907d-97f26918b974; MVID_AB_PERSONAL_RECOMMENDS=true; MVID_AB_UPSALE=true; MVID_ALFA_PODELI_NEW=true; MVID_CASCADE_CMN=true; MVID_CHAT_VERSION=4.16.4; MVID_CREDIT_DIGITAL=true; MVID_CREDIT_SERVICES=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_CROSS_POLLINATION=true; MVID_DISPLAY_ACCRUED_BR=true; MVID_EMPLOYEE_DISCOUNT=true; MVID_FILTER_CODES=true; MVID_FILTER_TOOLTIP=1; MVID_FLOCKTORY_ON=true; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_IS_NEW_BR_WIDGET=true; MVID_KLADR_ID=7700000000000; MVID_LAYOUT_TYPE=1; MVID_MINDBOX_DYNAMICALLY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PODELI_PDP=true; MVID_REGION_SHOP=S002; MVID_SERVICES=111; MVID_SERVICE_AVLB=true; MVID_SINGLE_CHECKOUT=true; MVID_SP=true; MVID_TIMEZONE_OFFSET=3; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_ERRORS_RATE=0.1; SENTRY_TRANSACTIONS_RATE=0.5; _ga=GA1.1.1465051681.1700639494; SMSError=; authError=; CACHE_INDICATOR=true; _sp_ses.d61c=*; _ym_isad=2; __SourceTracker=google__organic; admitad_deduplication_cookie=google__organic; __cpatrack=google_organic; __sourceid=google; __allsource=google; advcake_track_id=0e5d5e9d-4ae7-b527-58d6-8d9810502d72; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2Fnoutbuki-planshety-komputery-8%2Fnoutbuki-118%3Freff%3Dmenu_main%26utm_source%3Dgoogle%26utm_medium%3Dorganic%26utm_campaign%3Dgoogle%26utm_referrer%3Dgoogle; advcake_utm_partner=google; advcake_utm_webmaster=; __hash_=3c3b4192ac30bc774760a727b4ca43da; __rhash_=b165b4b59fc31c774762927aaf619cdb; gssc218=; gsscgib-w-mvideo=33PGgNGMGItaX6wvKVaOJLBYu+dDMtbcuwbSviPhWEzYgIzbEE+KjF0xlkjvZ308z3Of6kXzMFf1EUx6XRrEVw8M77nsdv7OCYSMouaOSDEJx82cHtnqU6iHA1wYsVNkOx8jM6WEU6JnE9G5fQA1LQyHscyKWHs1aK8j4FMEXhZL8iktKmsFQ2pps16ZBgGyP3WBWj1lWI2EQTmbpRmKn5XJ8EhLl4IYuUrP+o0VB6dCgNxhD+QKE954EkLkGQvxVK6IRPH8plT4c93hFPWaWL7BFKgSLQ==; gsscgib-w-mvideo=33PGgNGMGItaX6wvKVaOJLBYu+dDMtbcuwbSviPhWEzYgIzbEE+KjF0xlkjvZ308z3Of6kXzMFf1EUx6XRrEVw8M77nsdv7OCYSMouaOSDEJx82cHtnqU6iHA1wYsVNkOx8jM6WEU6JnE9G5fQA1LQyHscyKWHs1aK8j4FMEXhZL8iktKmsFQ2pps16ZBgGyP3WBWj1lWI2EQTmbpRmKn5XJ8EhLl4IYuUrP+o0VB6dCgNxhD+QKE954EkLkGQvxVK6IRPH8plT4c93hFPWaWL7BFKgSLQ==; _sp_id.d61c=7afa0d0d-341c-4606-b1c2-d8a00afa047c.1700639494.2.1700926141.1700640965.d6ee129e-9e7e-4164-b4f1-ec36a188781e.24cdc5c4-f71a-4bfd-b4b6-41f5185b0851.b7465793-c7b8-4dad-9371-3adc081e9494.1700925715385.17; fgsscgib-w-mvideo=4a4Ga590b3649a2a9cb3dbb49f35ef2294b1b26a; fgsscgib-w-mvideo=4a4Ga590b3649a2a9cb3dbb49f35ef2294b1b26a; cfidsgib-w-mvideo=MS8fXj0lPTerJiG+l6PGauICGUPKuPdeVqk0zs+O7BmqblysxV0wSd3c3Lnb5Em6dQOMdpya8huwoEBjdDqNR8E/XMD9n/KZoA8JY+m4X+wobk7kA/b7flTe4WimFATkClv13+nTvP0pW9381Mft59IYFMG8+BNxFFuNWw==; _ga_CFMZTSS5FM=GS1.1.1700925715.2.1.1700926147.0.0.0; _ga_BNX5WPP3YK=GS1.1.1700925715.2.1.1700926147.60.0.0');
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"productIds":' . json_encode($productChunk) . ',"mediaTypes":["images"],"category":true,"status":true,"brand":true,"propertyTypes":["KEY"],"propertiesConfig":{"propertiesPortionSize":5},"multioffer":false}');

            $response = curl_exec($ch);
            $response = gzdecode($response);
            if ($response === false) {
                echo 'Ошибка при декодировании данных.';
            } else {
                $data = json_decode($response, true);   
                $decodedProducts = $data['body']['products'];
    
                foreach ($decodedProducts as $product) {
                    $productId = $product['productId'];
                    $productName = $product['name'];
                    $productCharacteristics = [];
    
                    foreach ($product['propertiesPortion'] as $property) {
                        $propertyId = $property['id'];
                        $propertyName = $property['name'];
                        $propertyValue = $property['value'];
    
                        $productCharacteristics[] = [
                            'propertyId' => $propertyId,
                            'propertyName' => $propertyName,
                            'propertyValue' => $propertyValue,
                        ];
                    }
    
                    $result[] = [
                        'productId' => $productId,
                        'productName' => $productName,
                        'characteristics' => $productCharacteristics,
                    ];
                }
            }
    
            curl_close($ch);
        }
    
        return $result;
    }


public function getProductsPrice($products){
    $chunkSize = 24;
    $productChunks = array_chunk($products, $chunkSize);
    $result = [];
    foreach ($productChunks as $productChunk) {
        $idsString = implode('%2C', $productChunk); 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.mvideo.ru/bff/products/prices?productIds={$idsString}&addBonusRubles=true&isPromoApplied=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'authority: www.mvideo.ru',
            'accept: application/json',
            'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'baggage: sentry-environment=production,sentry-public_key=1e9efdeb57cf4127af3f903ec9db1466,sentry-trace_id=60b3c79f561a44c1a6e135bceaa7209c,sentry-sample_rate=0.5,sentry-transaction=%2F**%2F,sentry-sampled=true',
            'referer: https://www.mvideo.ru/noutbuki-planshety-komputery-8/noutbuki-118',
            'sec-ch-ua: "Chromium";v="118", "Opera GX";v="104", "Not=A?Brand";v="99"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-origin',
            'sentry-trace: 60b3c79f561a44c1a6e135bceaa7209c-bd27eb52b4c8ba4a-1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36 OPR/104.0.0.0',
            'x-set-application-id: 00bf7e8e-5ffa-4a73-8f77-6742759e4de1',
            'accept-encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'MVID_GUEST_ID=23238538005; MVID_VIEWED_PRODUCTS=; wurfl_device_id=generic_web_browser; MVID_CALC_BONUS_RUBLES_PROFIT=false; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=false; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=true; HINTS_FIO_COOKIE_NAME=2; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; flacktory=no; BIGipServeratg-ps-prod_tcp80=2466569226.20480.0000; bIPs=-314595793; MVID_ENVCLOUD=prod2; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; MVID_GEOLOCATION_NEEDED=false; BIGipServeratg-ps-prod_tcp80_clone=2466569226.20480.0000; utm_term=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; _ym_uid=1700639495957897813; _ym_d=1700639495; advcake_click_id=; uxs_uid=0db82990-890c-11ee-907d-97f26918b974; MVID_AB_UPSALE=true; MVID_ALFA_PODELI_NEW=true; MVID_CASCADE_CMN=true; MVID_CHAT_VERSION=4.16.4; MVID_CREDIT_DIGITAL=true; MVID_CREDIT_SERVICES=true; MVID_FILTER_CODES=true; MVID_FLOCKTORY_ON=true; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PODELI_PDP=true; MVID_SERVICES=111; MVID_SERVICE_AVLB=true; MVID_SINGLE_CHECKOUT=true; MVID_SP=true; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_TRANSACTIONS_RATE=0.5; _ga=GA1.1.1465051681.1700639494; SMSError=; authError=; __SourceTracker=google__organic; admitad_deduplication_cookie=google__organic; __cpatrack=google_organic; __sourceid=google; __allsource=google; advcake_track_id=0e5d5e9d-4ae7-b527-58d6-8d9810502d72; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2Fnoutbuki-planshety-komputery-8%2Fnoutbuki-118%3Freff%3Dmenu_main%26utm_source%3Dgoogle%26utm_medium%3Dorganic%26utm_campaign%3Dgoogle%26utm_referrer%3Dgoogle; advcake_utm_partner=google; advcake_utm_webmaster=; MVID_CITY_ID=CityR_27; MVID_REGION_ID=27; MVID_REGION_SHOP=S966; MVID_TIMEZONE_OFFSET=5; MVID_KLADR_ID=7400000900000; MVID_FILTER_TOOLTIP=1; MVID_LAYOUT_TYPE=1; MVID_EMPLOYEE_DISCOUNT=true; __lhash_=ee484b0ec31fb068935cf82d6a302f4b; cfidsgib-w-mvideo=HtR+D0fdG2aMacvkqXjWyvAWdvx+RhVRkpHhpsp6Mp5QYD/byUChkqD5DB62yUGTQOR8SQIWLueXLh6kUFn97jJIBsgrByqoxa1BWeI4cTthBHiO2Wg+20bJDkojIGzE+8r9CzNeOrdclIs/rb1rYFUNHHWRasNCAIT15LA=; __hash_=7cac287abcf2bd1ee76600d84b6ad0e0; MVID_AB_PERSONAL_RECOMMENDS=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_CROSS_POLLINATION=true; MVID_DISPLAY_ACCRUED_BR=1; MVID_IS_NEW_BR_WIDGET=true; MVID_MINDBOX_DYNAMICALLY=true; SENTRY_ERRORS_RATE=0.1; _sp_ses.d61c=*; MVID_CITY_CHANGED=false; JSESSIONID=hbyjlsLYbdhG1l67B8RWzLhbcQttqJkFg6BjvbQ2XvTRJLhWknSz!1383105283; CACHE_INDICATOR=true; _ym_isad=2; _sp_id.d61c=7afa0d0d-341c-4606-b1c2-d8a00afa047c.1700639494.23.1701612388.1701279401.c586f891-a244-4afc-9d25-7a78185f9180.af3bd627-8bda-42c6-ac5d-f65189be4c9d.3c6ac57d-ce63-4ebd-864a-b095b4347014.1701612375384.28; gsscgib-w-mvideo=AupTgqhbaBnQN7mt5zuarmm83m6JBLyFaNhduD0fOpwCwaNVXpBF8JyjVcUa0qQ1WNvitntE4M3CeOQpQx1uVKSb1JahudMsiPHEfA7zKIFdsAUW2RBCWVeY43aV+cVmITEf1d+CABA9NPsoHMS5+iCBErCyXzWIIHbDo5FmEvaloPpkLaih5WOKvUBRUzNnYyz/KLab51ptgW1ivzr53bmXQaqK+0OjXiJvW+UudtDNqHGZpGhFiM7ihQpEjg==; gsscgib-w-mvideo=AupTgqhbaBnQN7mt5zuarmm83m6JBLyFaNhduD0fOpwCwaNVXpBF8JyjVcUa0qQ1WNvitntE4M3CeOQpQx1uVKSb1JahudMsiPHEfA7zKIFdsAUW2RBCWVeY43aV+cVmITEf1d+CABA9NPsoHMS5+iCBErCyXzWIIHbDo5FmEvaloPpkLaih5WOKvUBRUzNnYyz/KLab51ptgW1ivzr53bmXQaqK+0OjXiJvW+UudtDNqHGZpGhFiM7ihQpEjg==; advcake_session_id=e1e6a0ba-fcdb-adcb-148b-7640587d4696; fgsscgib-w-mvideo=2COiefa385561c1ad0aed7955e3b6f32e6cb6ed1; fgsscgib-w-mvideo=2COiefa385561c1ad0aed7955e3b6f32e6cb6ed1; _ga_CFMZTSS5FM=GS1.1.1701612375.23.1.1701612396.0.0.0; _ga_BNX5WPP3YK=GS1.1.1701612375.23.1.1701612396.39.0.0');

        $response = curl_exec($ch);
        $response = gzdecode($response);
        if ($response === false) {
            echo 'Ошибка при декодировании данных.';
        } else {
            $data = json_decode($response, true);
            $productChunk = $data['body']['materialPrices'];
            foreach ($productChunk as $product) {
                $productData = [
                    'productId' => $product['productId'],
                    'basePrice' =>$product['price']['basePrice'],
                    'salePrice' =>$product['price']['salePrice'],
                ];
                $result[] = $productData;
        } 
        }  
        curl_close($ch);
        sleep(5);
    }
    return $result;
}
   
}