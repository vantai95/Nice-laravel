<?php

namespace App\Services;

use App;
use App\Models\Role;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\build_query;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Log;
use Lang;
use Session;
use GuzzleHttp\Client;
use Storage;

class CommonService
{
    public static function formatFullDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatShortDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatLongDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function formatFlightTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i Y-m-d', strtotime($date));
    }

    public static function formatShortFlightTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i', strtotime($date));
    }

    public static function formatSmsTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('d-m-Y/H:i', strtotime($date));
    }

    public static function formatEmailTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i d-m-Y', strtotime($date));
    }

    public static function formatDuration($minutes)
    {
        if (empty($minutes)) {
            return '';
        }

        if (!is_numeric($minutes)) {
            return '';
        }

        if ($minutes < 0){
            return '';
        }

        $hours = (int)($minutes / 60);
        $minutes = $minutes % 60;
        return $hours . 'h' . $minutes . "'";
    }

    public static function formatPrice($price)
    {
        if (empty($price)) {
            return '';
        }

        if (!is_numeric($price)) {
            return '';
        }

        if ($price < 0){
            return '';
        }
        return number_format($price, 0, ',', '.');
    }

    public static function formatPriceOnlinePayment($price)
    {
        if (empty($price)) {
            return 0.00;
        }

        if (!is_numeric($price)) {
            return 0.00;
        }

        if ($price < 0){
            return 0.00;
        }
        return number_format((float)$price, 2, '.', '');
    }

    public static function formatPriceVND($price)
    {
        if (empty($price)) {
            return '';
        }

        if (!is_numeric($price)) {
            return '';
        }

        if ($price < 0){
            return '';
        }
        return number_format($price, 0, ',', '.') . " VNĐ";
    }

    public static function formatInteger($number)
    {
        if (empty($number)) {
            return '';
        }

        if (!is_numeric($number)) {
            return '';
        }

        if ($number < 0){
            return '';
        }
        return number_format($number, 0, ',', '.');
    }


    public static function internationalPhoneNumber($text, $countryCode = '84')
    {
        if (empty($text)) {
            return $text;
        }

        if (starts_with($text, '0')) {
            return $countryCode . substr($text, 1);
        }

        if (starts_with($text, '+')) {
            return substr($text, 1);
        }

        return $text;
    }

    public static function getPreviousUrl($request)
    {
        $currentPage = explode('/', explode('admin/', $request->fullUrl())[1])[0];

        if (!empty(session('mainPage'))) {

            $pageAndQueries = explode('?', explode('admin/', session('mainPage'))[1]);

            $page = $pageAndQueries[0];

            $queries = isset($pageAndQueries[1]) ? $pageAndQueries[1] : null;

            if ($page == $currentPage) {

                return url("admin/$page?$queries");
            }
        }
        return url("admin/$currentPage");
    }

    public static function correctSearchKeyword($keyword)
    {
        $keyword = str_replace(' ', '%', $keyword);
        return "%$keyword%";
    }

    public static function formatSendDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('d-m-Y', strtotime($date));
    }

    public static function upperString($string){
        return strtoupper($string);
    }

    public static function containString($str,$substr){
        return strpos($str,$substr) !== false;
    }

    public static function formatLastLoginDate($date){
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d H:i', strtotime($date));
    }

    public static function formatToDate($date){
        $date = Carbon::parse($date)->toDateString();
        return date('F j, Y',strtotime($date));
    }

    public static function getDay($date){
        $date = Carbon::parse($date)->toDateString();
        return date('d', strtotime($date));
    }

    public static function getMonth($date){
        $date = Carbon::parse($date)->toDateString();
        return date('M', strtotime($date));
    }

    public static function getYear($date){
        $date = Carbon::parse($date)->toDateString();
        return date('Y', strtotime($date));
    }

    public static function formatDeliveryTime($date)
    {
        return empty($date) ? '' : date('H:i', strtotime($date));
    }

    public static function formatTime12Hours($date)
    {
        return empty($date) ? '' : date('g:i A', strtotime($date));
    }

    public static function checkRestaurantManagement($slug){
        if($slug =='unset')
            return false;
        return true;
    }

    public static function sendSMS($phoneNumber,$smsMessage) {
        $isSendSMS = env('ENABLE_SEND_SMS');
        if($isSendSMS){
            $clientNo = env('FIBO_SMS_CLIENT_NO');
            $clientPass = env('FIBO_SMS_CLIENT_PASSWORD');
            $endPoint = env('FIBO_SMS_ENDPOINT');
            $smsGUID = 0;
            $serviceType = 0;
            $senderName = env('FIBO_SENDER_NAME');

            $uri = $endPoint . '/SendMaskedSMS?';

            $params = array(
                'clientNo'      => $clientNo,
                'clientPass'    => $clientPass,
                'serviceType'   => $serviceType,
                'senderName'    => $senderName,
                'phoneNumber'   => $phoneNumber,
                'smsGUID'       => $smsGUID,
                'smsMessage'    => $smsMessage
            );

            $client = new Client();
            $body = $client->get(self::buildQuerySMS($uri,$params))->getBody();
            $docFormat = new \SimpleXMLElement($body);
            $doc = new \SimpleXMLElement($docFormat);
            Log::info("SEND SMS:".$doc->Code);
            if((int)$doc->Code == 200) {
                return true;
            }
            return false;
        }
        return true;
    }

    private static function buildQuerySMS($uri,$params) {
        $query = '';
        foreach ($params as $key => $value) {
            if (empty($query)) {
                $query .= "$key=$value";
            } else {
                $query .= "&$key=$value";
            }
        }
        return $uri.$query;
    }

    public static function generateOTP(){
        $generator = "KULRAY2547";

        $result = "";

        for ($i = 1; $i <= 4; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }

        return $result;
    }

    public static function array_columns($array, $keys) {
        $resArr = [];
        foreach ($array as $item) {
            $tempItem = [];
            foreach($keys as $key) {
                $tempItem[$key] = $item[$key];
            }
            array_push($resArr, $tempItem);
        }
        return $resArr;
    }

    public static function write_ini_file($assoc_arr, $path, $has_sections=FALSE) {
        $content = "";
        if ($has_sections) {
            foreach ($assoc_arr as $key=>$elem) {
                $content .= "[".$key."]\n";
                foreach ($elem as $key2=>$elem2) {
                    if(is_array($elem2))
                    {
                        for($i=0;$i<count($elem2);$i++)
                        {
                            $content .= $key2."[]=".$elem2[$i]."\n";
                        }
                    }
                    else if($elem2=="") $content .= $key2."=\n";
                    else $content .= $key2."=".$elem2."\n";
                }
            }
        }
        else {
            foreach ($assoc_arr as $key=>$elem) {
                if(is_array($elem))
                {
                    for($i=0;$i<count($elem);$i++)
                    {
                        $content .= $key."[]=".$elem[$i]."\n";
                    }
                }
                else if($elem=="") $content .= $key."=\n";
                else $content .= $key."=".$elem."\n";
            }
        }

        if (!$handle = fopen($path, 'w')) {
            return false;
        }

        $success = fwrite($handle, $content);
        fclose($handle);

        return $success;
    }

    public static function duplicateRow($tableName, $id, $changeProperties){
        $object = collect(\DB::table($tableName)->where('id', $id)->first());
        unset($object['id']);
        foreach($changeProperties as $pro)
            $object[$pro] = $object[$pro] . " Copy " . rand(1000, 9999);

        \DB::table($tableName)->insert($object->toArray());
    }

    public static function getError(\Exception $exception) {
        \Log::error($exception->getMessage() . ' -------- on file ' . $exception->getFile() . ' ---- at line ' . $exception->getLine());
    }

    public static function checkIfManageManyRestaurants($user_id){
        $userRes = App\Models\UsersRestaurant::where('user_id', $user_id)
            ->whereNotNull('restaurant_id')
            ->count();
//        dd($userRes);
        return $userRes >= 2 ? true : false;
    }

    public static function buildImageURL($image=NULL){
        return $image ? Storage::disk(ENV('FILESYSTEM_DRIVER'))->url($image) : url(config('constants.DEFAULT.RESTAURANT_IMAGE'));
    }

    public static function price2Number($price) {
        return !$price ? NULL : preg_replace('/[^0-9]/', '', $price);
    }

    public static function formatInvoiceDate($date){
        if (empty($date)) {
            return '';
        }
        return date('d-M-Y', strtotime($date));
    }

    public static function isTakeawayDomain() {

        $url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parse = parse_url($url);
        if((isset($parse['host']) && $parse['host'] == 'vntakeaway.com') ||(isset($parse['host']) && $parse['host'] == 'www.vntakeaway.com') ){
            return true;
        }
        return false;
    }
    public static function isMealRestDomain() {
        $url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parse = parse_url($url);
        if((isset($parse['host']) && $parse['host'] == 'mealrest.com') ||(isset($parse['host']) && $parse['host'] == 'www.mealrest.com') ){
            return true;
        }
        return false;
    }

    public static function getLogo() {
        if(CommonService::isMealRestDomain()){
            return 'logomealrest.png';
        }
        else if(CommonService::isTakeawayDomain()){
            return 'logotakeaway.png';
        }
        return 'logo_formlogin.png';
    }

    public static function getLogoHomePage() {
        if(CommonService::isMealRestDomain()){
            return 'logomealrest.png';
        }
        else if(CommonService::isTakeawayDomain()){
            return 'logotakeawayhome.png';
        }
        return 'logo.png';
    }
}
