<?php

namespace App\Http\Controllers\mv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApiControllerT extends Controller
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
        $jsonFilePath = public_path('json/mvnT.json');
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
                curl_setopt($ch, CURLOPT_URL, "https://www.mvideo.ru/bff/products/listing?categoryId=65&offset={$offset}&limit={$limit}&filterParams=WyLQotC%2B0LvRjNC60L4g0LIg0L3QsNC70LjRh9C40LgiLCItOSIsItCU0LAiXQ%3D%3D&filterParams=WyLQl9Cw0LHRgNCw0YLRjCDRh9C10YDQtdC3IDE1INC80LjQvdGD0YIiLCItMTEiLCJTOTY2Il0%3D");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'authority: www.mvideo.ru',
                    'accept: application/json',
                    'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                    'baggage: sentry-environment=production,sentry-public_key=1e9efdeb57cf4127af3f903ec9db1466,sentry-trace_id=19281951fbe3402db1c6b0b41f71b66c,sentry-sample_rate=0.5,sentry-transaction=%2F**%2F,sentry-sampled=true',
                    'referer: https://www.mvideo.ru/televizory-i-cifrovoe-tv-1/televizory-65/f/tolko-v-nalichii=da/zabrat-cherez-15-minut=s966',
                    'sec-ch-ua: "Chromium";v="118", "Opera GX";v="104", "Not=A?Brand";v="99"',
                    'sec-ch-ua-mobile: ?0',
                    'sec-ch-ua-platform: "Windows"',
                    'sec-fetch-dest: empty',
                    'sec-fetch-mode: cors',
                    'sec-fetch-site: same-origin',
                    'sentry-trace: 19281951fbe3402db1c6b0b41f71b66c-b9f50ab06773aa0a-1',
                    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36 OPR/104.0.0.0',
                    'x-gib-fgsscgib-w-mvideo: ed4mc1abcc13ed428ab846a9eb6a5f4bb8c113c4',
                    'x-gib-gsscgib-w-mvideo: h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==',
                    'x-set-application-id: 7329eb56-51ef-47a2-8580-f034fd33e843',
                    'accept-encoding: gzip',
                ]);
                curl_setopt($ch, CURLOPT_COOKIE, 'MVID_GUEST_ID=23238538005; MVID_VIEWED_PRODUCTS=; wurfl_device_id=generic_web_browser; MVID_CALC_BONUS_RUBLES_PROFIT=false; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=false; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=true; HINTS_FIO_COOKIE_NAME=2; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; flacktory=no; BIGipServeratg-ps-prod_tcp80=2466569226.20480.0000; bIPs=-314595793; MVID_ENVCLOUD=prod2; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; MVID_GEOLOCATION_NEEDED=false; BIGipServeratg-ps-prod_tcp80_clone=2466569226.20480.0000; utm_term=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; _ym_uid=1700639495957897813; _ym_d=1700639495; uxs_uid=0db82990-890c-11ee-907d-97f26918b974; MVID_ALFA_PODELI_NEW=true; MVID_CASCADE_CMN=true; MVID_CHAT_VERSION=4.16.4; MVID_CREDIT_DIGITAL=true; MVID_CREDIT_SERVICES=true; MVID_FILTER_CODES=true; MVID_FLOCKTORY_ON=true; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PODELI_PDP=true; MVID_SERVICES=111; MVID_SERVICE_AVLB=true; MVID_SINGLE_CHECKOUT=true; MVID_SP=true; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_TRANSACTIONS_RATE=0.5; _ga=GA1.1.1465051681.1700639494; SMSError=; authError=; MVID_CITY_ID=CityR_27; MVID_REGION_ID=27; MVID_REGION_SHOP=S966; MVID_TIMEZONE_OFFSET=5; MVID_KLADR_ID=7400000900000; MVID_FILTER_TOOLTIP=1; MVID_LAYOUT_TYPE=1; MVID_EMPLOYEE_DISCOUNT=true; MVID_AB_PERSONAL_RECOMMENDS=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_CROSS_POLLINATION=true; MVID_DISPLAY_ACCRUED_BR=1; MVID_IS_NEW_BR_WIDGET=true; SENTRY_ERRORS_RATE=0.1; MVID_CITY_CHANGED=false; advcake_session_id=e1e6a0ba-fcdb-adcb-148b-7640587d4696; JSESSIONID=Jm20lv1D5st1yh91tdNn6cgsj2VGpTflnfpqvHMrwVGL2CzxkxGQ!854513258; CACHE_INDICATOR=true; admitad_uid=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; __cpatrack=yandex_cpc; __sourceid=yandex; __allsource=yandex; advcake_track_id=a7e235b1-e4d0-9bb5-ad4c-5d84eff4a1f8; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2Fpromo%2Fpromocatalog%3Fpid%3Dyandexdirect_int%26c%3Dmg_image_name_p_urfo%26af_c_id%3D81880955%26is_retargeting%3Dtrue%26af_reengagement_window%3D30d%26af_click_lookback%3D7d%26clickid%3D2006396715851317247%26utm_medium%3Dcpc%26utm_source%3Dyandex%26utm_campaign%3Dcn%3Amg_image_name_p_urfo%7Ccid%3A81880955%26utm_term%3D%25D0%25BC%2520%25D0%25B2%25D0%25B8%25D0%25B4%25D0%25B5%25D0%25BE%26utm_content%3Dph%3A42727661913%7Cre%3A42727661913%7Ccid%3A81880955%7Cgid%3A5107957236%7Caid%3A13283666569%7Cadp%3Ano%7Cpos%3Apremium1%7Csrc%3Asearch_none%7Cdvc%3Adesktop%7Ccoef_goal%3A0%7Cregion%3A235%7C%25D0%259C%25D0%25B0%25D0%25B3%25D0%25BD%25D0%25B8%25D1%2582%25D0%25BE%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA%26etext%3D2202.q5CR2piX3PXqExWA3rJfV4i0Dt-_iY2rcRdXDwbQWbtzY2ZrYXFucW1pZmFscnBk.230cd1cf1349c65cae70654b3fefb2b44190bf75%26yclid%3D2006396715851317247; advcake_utm_partner=cn%3Amg_image_name_p_urfo%7Ccid%3A81880955; advcake_utm_webmaster=ph%3A42727661913%7Cre%3A42727661913%7Ccid%3A81880955%7Cgid%3A5107957236%7Caid%3A13283666569%7Cadp%3Ano%7Cpos%3Apremium1%7Csrc%3Asearch_none%7Cdvc%3Adesktop%7Ccoef_goal%3A0%7Cregion%3A235%7C%25D0%259C%25D0%25B0%25D0%25B3%25D0%25BD%25D0%25B8%25D1%2582%25D0%25BE%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA; advcake_click_id=; flocktory-uuid=50e4ed36-4d28-4411-8cd4-fdc65182ae0e-0; tmr_lvid=a817078acab45a4b868a6eb2882748ec; tmr_lvidTS=1701805841326; gdeslon.ru.__arc_domain=gdeslon.ru; gdeslon.ru.user_id=e804396d-a630-48e0-81e4-60541cf8697c; afUserId=83e0db08-8cfc-45e6-996b-345e6687f217-p; AF_SYNC=1701805848945; mindboxDeviceUUID=1dad040d-dc11-433a-9022-00113e3288fc; directCrm-session=%7B%22deviceGuid%22%3A%221dad040d-dc11-433a-9022-00113e3288fc%22%7D; adrcid=AbD_h64m1ziWKelMKzCjh1A; _gpVisits={"isFirstVisitDomain":true,"idContainer":"100025D5"}; __hash_=f9ae0638b2aabdc2f760ee5c1ad91835; __lhash_=23287e176ed390ecbd8f156a6003b1c6; MVID_AB_UPSALE=true; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; cfidsgib-w-mvideo=o8cAgXkRDWBhnEdkbMbVt1oE/ABrsc1oLDLogJph42jontJ5X7FUZnDU/5AWPCv5YkxyuJYFctqdryQH58q9jtTs9+RVkWY+XdfE61QKDzESzQC19pfLFm1ER9sELJxeYcX1NLa2laNab4a36/n1PwWFwrDoe8xUFRmzhTM=; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; _sp_ses.d61c=*; __SourceTracker=yandex.ru__organic; admitad_deduplication_cookie=yandex.ru__organic; _ym_visorc=w; _ym_isad=2; _ga_BNX5WPP3YK=GS1.1.1702316762.25.1.1702316765.57.0.0; _ga_CFMZTSS5FM=GS1.1.1702316762.25.1.1702316765.0.0.0; _sp_id.d61c=7afa0d0d-341c-4606-b1c2-d8a00afa047c.1700639494.25.1702316767.1701805874.a4107f22-4967-4bc0-ad67-1a2172c1ff65.9f4917f2-6b62-4ed2-8cea-2f714dfff47c.cf9808c1-022b-44c6-8b6a-00236d1bf1c7.1702316761091.24; fgsscgib-w-mvideo=ed4mc1abcc13ed428ab846a9eb6a5f4bb8c113c4; fgsscgib-w-mvideo=ed4mc1abcc13ed428ab846a9eb6a5f4bb8c113c4');
                
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
                'baggage: sentry-environment=production,sentry-public_key=1e9efdeb57cf4127af3f903ec9db1466,sentry-trace_id=19281951fbe3402db1c6b0b41f71b66c,sentry-sample_rate=0.5,sentry-transaction=%2F**%2F,sentry-sampled=true',
                'content-type: application/json',
                'origin: https://www.mvideo.ru',
                'referer: https://www.mvideo.ru/televizory-i-cifrovoe-tv-1/televizory-65/f/tolko-v-nalichii=da/zabrat-cherez-15-minut=s966',
                'sec-ch-ua: "Chromium";v="118", "Opera GX";v="104", "Not=A?Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'sentry-trace: 19281951fbe3402db1c6b0b41f71b66c-a696e6e72214d398-1',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36 OPR/104.0.0.0',
                'x-gib-fgsscgib-w-mvideo: VLja0e8221952d0bf3fdbef968be073da6b9103c',
                'x-gib-gsscgib-w-mvideo: h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==',
                'x-set-application-id: 7329eb56-51ef-47a2-8580-f034fd33e843',
                'accept-encoding: gzip',
            ]);
            curl_setopt($ch, CURLOPT_COOKIE, 'MVID_GUEST_ID=23238538005; MVID_VIEWED_PRODUCTS=; wurfl_device_id=generic_web_browser; MVID_CALC_BONUS_RUBLES_PROFIT=false; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=false; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=true; HINTS_FIO_COOKIE_NAME=2; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; flacktory=no; BIGipServeratg-ps-prod_tcp80=2466569226.20480.0000; bIPs=-314595793; MVID_ENVCLOUD=prod2; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; MVID_GEOLOCATION_NEEDED=false; BIGipServeratg-ps-prod_tcp80_clone=2466569226.20480.0000; utm_term=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; _ym_uid=1700639495957897813; _ym_d=1700639495; uxs_uid=0db82990-890c-11ee-907d-97f26918b974; MVID_ALFA_PODELI_NEW=true; MVID_CASCADE_CMN=true; MVID_CHAT_VERSION=4.16.4; MVID_CREDIT_DIGITAL=true; MVID_CREDIT_SERVICES=true; MVID_FILTER_CODES=true; MVID_FLOCKTORY_ON=true; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PODELI_PDP=true; MVID_SERVICES=111; MVID_SERVICE_AVLB=true; MVID_SINGLE_CHECKOUT=true; MVID_SP=true; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_TRANSACTIONS_RATE=0.5; _ga=GA1.1.1465051681.1700639494; SMSError=; authError=; MVID_CITY_ID=CityR_27; MVID_REGION_ID=27; MVID_REGION_SHOP=S966; MVID_TIMEZONE_OFFSET=5; MVID_KLADR_ID=7400000900000; MVID_FILTER_TOOLTIP=1; MVID_LAYOUT_TYPE=1; MVID_EMPLOYEE_DISCOUNT=true; MVID_AB_PERSONAL_RECOMMENDS=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_CROSS_POLLINATION=true; MVID_DISPLAY_ACCRUED_BR=1; MVID_IS_NEW_BR_WIDGET=true; SENTRY_ERRORS_RATE=0.1; MVID_CITY_CHANGED=false; advcake_session_id=e1e6a0ba-fcdb-adcb-148b-7640587d4696; JSESSIONID=Jm20lv1D5st1yh91tdNn6cgsj2VGpTflnfpqvHMrwVGL2CzxkxGQ!854513258; CACHE_INDICATOR=true; admitad_uid=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; __cpatrack=yandex_cpc; __sourceid=yandex; __allsource=yandex; advcake_track_id=a7e235b1-e4d0-9bb5-ad4c-5d84eff4a1f8; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2Fpromo%2Fpromocatalog%3Fpid%3Dyandexdirect_int%26c%3Dmg_image_name_p_urfo%26af_c_id%3D81880955%26is_retargeting%3Dtrue%26af_reengagement_window%3D30d%26af_click_lookback%3D7d%26clickid%3D2006396715851317247%26utm_medium%3Dcpc%26utm_source%3Dyandex%26utm_campaign%3Dcn%3Amg_image_name_p_urfo%7Ccid%3A81880955%26utm_term%3D%25D0%25BC%2520%25D0%25B2%25D0%25B8%25D0%25B4%25D0%25B5%25D0%25BE%26utm_content%3Dph%3A42727661913%7Cre%3A42727661913%7Ccid%3A81880955%7Cgid%3A5107957236%7Caid%3A13283666569%7Cadp%3Ano%7Cpos%3Apremium1%7Csrc%3Asearch_none%7Cdvc%3Adesktop%7Ccoef_goal%3A0%7Cregion%3A235%7C%25D0%259C%25D0%25B0%25D0%25B3%25D0%25BD%25D0%25B8%25D1%2582%25D0%25BE%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA%26etext%3D2202.q5CR2piX3PXqExWA3rJfV4i0Dt-_iY2rcRdXDwbQWbtzY2ZrYXFucW1pZmFscnBk.230cd1cf1349c65cae70654b3fefb2b44190bf75%26yclid%3D2006396715851317247; advcake_utm_partner=cn%3Amg_image_name_p_urfo%7Ccid%3A81880955; advcake_utm_webmaster=ph%3A42727661913%7Cre%3A42727661913%7Ccid%3A81880955%7Cgid%3A5107957236%7Caid%3A13283666569%7Cadp%3Ano%7Cpos%3Apremium1%7Csrc%3Asearch_none%7Cdvc%3Adesktop%7Ccoef_goal%3A0%7Cregion%3A235%7C%25D0%259C%25D0%25B0%25D0%25B3%25D0%25BD%25D0%25B8%25D1%2582%25D0%25BE%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA; advcake_click_id=; flocktory-uuid=50e4ed36-4d28-4411-8cd4-fdc65182ae0e-0; tmr_lvid=a817078acab45a4b868a6eb2882748ec; tmr_lvidTS=1701805841326; gdeslon.ru.__arc_domain=gdeslon.ru; gdeslon.ru.user_id=e804396d-a630-48e0-81e4-60541cf8697c; afUserId=83e0db08-8cfc-45e6-996b-345e6687f217-p; AF_SYNC=1701805848945; mindboxDeviceUUID=1dad040d-dc11-433a-9022-00113e3288fc; directCrm-session=%7B%22deviceGuid%22%3A%221dad040d-dc11-433a-9022-00113e3288fc%22%7D; adrcid=AbD_h64m1ziWKelMKzCjh1A; _gpVisits={"isFirstVisitDomain":true,"idContainer":"100025D5"}; __hash_=f9ae0638b2aabdc2f760ee5c1ad91835; __lhash_=23287e176ed390ecbd8f156a6003b1c6; MVID_AB_UPSALE=true; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; cfidsgib-w-mvideo=o8cAgXkRDWBhnEdkbMbVt1oE/ABrsc1oLDLogJph42jontJ5X7FUZnDU/5AWPCv5YkxyuJYFctqdryQH58q9jtTs9+RVkWY+XdfE61QKDzESzQC19pfLFm1ER9sELJxeYcX1NLa2laNab4a36/n1PwWFwrDoe8xUFRmzhTM=; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; _sp_ses.d61c=*; __SourceTracker=yandex.ru__organic; admitad_deduplication_cookie=yandex.ru__organic; _ym_visorc=w; _ym_isad=2; _sp_id.d61c=7afa0d0d-341c-4606-b1c2-d8a00afa047c.1700639494.25.1702316767.1701805874.a4107f22-4967-4bc0-ad67-1a2172c1ff65.9f4917f2-6b62-4ed2-8cea-2f714dfff47c.cf9808c1-022b-44c6-8b6a-00236d1bf1c7.1702316761091.24; _ga_BNX5WPP3YK=GS1.1.1702316762.25.1.1702316776.46.0.0; _ga_CFMZTSS5FM=GS1.1.1702316762.25.1.1702316776.0.0.0; fgsscgib-w-mvideo=VLja0e8221952d0bf3fdbef968be073da6b9103c; fgsscgib-w-mvideo=VLja0e8221952d0bf3fdbef968be073da6b9103c');
            
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
            'baggage: sentry-environment=production,sentry-public_key=1e9efdeb57cf4127af3f903ec9db1466,sentry-trace_id=19281951fbe3402db1c6b0b41f71b66c,sentry-sample_rate=0.5,sentry-transaction=%2F**%2F,sentry-sampled=true',
            'referer: https://www.mvideo.ru/televizory-i-cifrovoe-tv-1/televizory-65/f/tolko-v-nalichii=da/zabrat-cherez-15-minut=s966',
            'sec-ch-ua: "Chromium";v="118", "Opera GX";v="104", "Not=A?Brand";v="99"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-origin',
            'sentry-trace: 19281951fbe3402db1c6b0b41f71b66c-aff7ec0c6b647c9f-1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36 OPR/104.0.0.0',
            'x-gib-fgsscgib-w-mvideo: i7j002d478f744a6610598dd88ae11fcc667f884',
            'x-gib-gsscgib-w-mvideo: h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==',
            'x-set-application-id: 7329eb56-51ef-47a2-8580-f034fd33e843',
            'accept-encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'MVID_GUEST_ID=23238538005; MVID_VIEWED_PRODUCTS=; wurfl_device_id=generic_web_browser; MVID_CALC_BONUS_RUBLES_PROFIT=false; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=false; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=true; HINTS_FIO_COOKIE_NAME=2; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; flacktory=no; BIGipServeratg-ps-prod_tcp80=2466569226.20480.0000; bIPs=-314595793; MVID_ENVCLOUD=prod2; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; MVID_GEOLOCATION_NEEDED=false; BIGipServeratg-ps-prod_tcp80_clone=2466569226.20480.0000; utm_term=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; _ym_uid=1700639495957897813; _ym_d=1700639495; uxs_uid=0db82990-890c-11ee-907d-97f26918b974; MVID_ALFA_PODELI_NEW=true; MVID_CASCADE_CMN=true; MVID_CHAT_VERSION=4.16.4; MVID_CREDIT_DIGITAL=true; MVID_CREDIT_SERVICES=true; MVID_FILTER_CODES=true; MVID_FLOCKTORY_ON=true; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PODELI_PDP=true; MVID_SERVICES=111; MVID_SERVICE_AVLB=true; MVID_SINGLE_CHECKOUT=true; MVID_SP=true; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_TRANSACTIONS_RATE=0.5; _ga=GA1.1.1465051681.1700639494; SMSError=; authError=; MVID_CITY_ID=CityR_27; MVID_REGION_ID=27; MVID_REGION_SHOP=S966; MVID_TIMEZONE_OFFSET=5; MVID_KLADR_ID=7400000900000; MVID_FILTER_TOOLTIP=1; MVID_LAYOUT_TYPE=1; MVID_EMPLOYEE_DISCOUNT=true; MVID_AB_PERSONAL_RECOMMENDS=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_CROSS_POLLINATION=true; MVID_DISPLAY_ACCRUED_BR=1; MVID_IS_NEW_BR_WIDGET=true; SENTRY_ERRORS_RATE=0.1; MVID_CITY_CHANGED=false; advcake_session_id=e1e6a0ba-fcdb-adcb-148b-7640587d4696; JSESSIONID=Jm20lv1D5st1yh91tdNn6cgsj2VGpTflnfpqvHMrwVGL2CzxkxGQ!854513258; CACHE_INDICATOR=true; admitad_uid=%D0%BC%20%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE; __cpatrack=yandex_cpc; __sourceid=yandex; __allsource=yandex; advcake_track_id=a7e235b1-e4d0-9bb5-ad4c-5d84eff4a1f8; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2Fpromo%2Fpromocatalog%3Fpid%3Dyandexdirect_int%26c%3Dmg_image_name_p_urfo%26af_c_id%3D81880955%26is_retargeting%3Dtrue%26af_reengagement_window%3D30d%26af_click_lookback%3D7d%26clickid%3D2006396715851317247%26utm_medium%3Dcpc%26utm_source%3Dyandex%26utm_campaign%3Dcn%3Amg_image_name_p_urfo%7Ccid%3A81880955%26utm_term%3D%25D0%25BC%2520%25D0%25B2%25D0%25B8%25D0%25B4%25D0%25B5%25D0%25BE%26utm_content%3Dph%3A42727661913%7Cre%3A42727661913%7Ccid%3A81880955%7Cgid%3A5107957236%7Caid%3A13283666569%7Cadp%3Ano%7Cpos%3Apremium1%7Csrc%3Asearch_none%7Cdvc%3Adesktop%7Ccoef_goal%3A0%7Cregion%3A235%7C%25D0%259C%25D0%25B0%25D0%25B3%25D0%25BD%25D0%25B8%25D1%2582%25D0%25BE%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA%26etext%3D2202.q5CR2piX3PXqExWA3rJfV4i0Dt-_iY2rcRdXDwbQWbtzY2ZrYXFucW1pZmFscnBk.230cd1cf1349c65cae70654b3fefb2b44190bf75%26yclid%3D2006396715851317247; advcake_utm_partner=cn%3Amg_image_name_p_urfo%7Ccid%3A81880955; advcake_utm_webmaster=ph%3A42727661913%7Cre%3A42727661913%7Ccid%3A81880955%7Cgid%3A5107957236%7Caid%3A13283666569%7Cadp%3Ano%7Cpos%3Apremium1%7Csrc%3Asearch_none%7Cdvc%3Adesktop%7Ccoef_goal%3A0%7Cregion%3A235%7C%25D0%259C%25D0%25B0%25D0%25B3%25D0%25BD%25D0%25B8%25D1%2582%25D0%25BE%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA; advcake_click_id=; flocktory-uuid=50e4ed36-4d28-4411-8cd4-fdc65182ae0e-0; tmr_lvid=a817078acab45a4b868a6eb2882748ec; tmr_lvidTS=1701805841326; gdeslon.ru.__arc_domain=gdeslon.ru; gdeslon.ru.user_id=e804396d-a630-48e0-81e4-60541cf8697c; afUserId=83e0db08-8cfc-45e6-996b-345e6687f217-p; AF_SYNC=1701805848945; mindboxDeviceUUID=1dad040d-dc11-433a-9022-00113e3288fc; directCrm-session=%7B%22deviceGuid%22%3A%221dad040d-dc11-433a-9022-00113e3288fc%22%7D; adrcid=AbD_h64m1ziWKelMKzCjh1A; _gpVisits={"isFirstVisitDomain":true,"idContainer":"100025D5"}; __hash_=f9ae0638b2aabdc2f760ee5c1ad91835; __lhash_=23287e176ed390ecbd8f156a6003b1c6; MVID_AB_UPSALE=true; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; cfidsgib-w-mvideo=o8cAgXkRDWBhnEdkbMbVt1oE/ABrsc1oLDLogJph42jontJ5X7FUZnDU/5AWPCv5YkxyuJYFctqdryQH58q9jtTs9+RVkWY+XdfE61QKDzESzQC19pfLFm1ER9sELJxeYcX1NLa2laNab4a36/n1PwWFwrDoe8xUFRmzhTM=; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; gsscgib-w-mvideo=h0dkSdUQPUC889Sxi/I3uKBq1LdoJopnkImaV/PS3y54kCUTeBklxRJ7lpNHT7kf2CW8SvfF0tcV2uJypchnmRAXeM9Yz28RMmdvmJuz1MjMlCt/94c2ngxovcxBvQd6/KNADzhjm0vrHJVsQA4B6fqrbFdJcXxCuGGvEiXHPqioRsLNGfXrlBoAyCoQLoQhmrjqk0xg20fXvXyUGCzfKsQTv0C6gIPngwTljIcLmiho9uNHjDssmyuq7mnm/w==; _sp_ses.d61c=*; __SourceTracker=yandex.ru__organic; admitad_deduplication_cookie=yandex.ru__organic; _ym_visorc=w; _ym_isad=2; _sp_id.d61c=7afa0d0d-341c-4606-b1c2-d8a00afa047c.1700639494.25.1702316767.1701805874.a4107f22-4967-4bc0-ad67-1a2172c1ff65.9f4917f2-6b62-4ed2-8cea-2f714dfff47c.cf9808c1-022b-44c6-8b6a-00236d1bf1c7.1702316761091.24; _ga_BNX5WPP3YK=GS1.1.1702316762.25.1.1702316776.46.0.0; _ga_CFMZTSS5FM=GS1.1.1702316762.25.1.1702316776.0.0.0; fgsscgib-w-mvideo=i7j002d478f744a6610598dd88ae11fcc667f884; fgsscgib-w-mvideo=i7j002d478f744a6610598dd88ae11fcc667f884');
        
        
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