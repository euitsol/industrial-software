<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Session as Sessions;
use Carbon\Carbon;

use App\Models\CourseStudent;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function message($type, $message)
    {
        if ($type == 'success') {
            Session::flash('success', $message);
        } elseif ($type == 'error') {
            Session::flash('error', $message);
        }
    }

    protected function courseFeeCalculate($account, $course_fee)
    {
        if (isset($account->discount_percent) && $account->discount_percent > 0) {
            $course_fee = $course_fee - (($course_fee * $account->discount_percent) / 100);
        } elseif (isset($account->discount_amount) && $account->discount_amount > 0) {
            $course_fee = $course_fee - $account->discount_amount;
        }
        // $additional_fee = !empty($account->additional_fee) ? $account->additional_fee : 0;
        $total_fee = $course_fee;
        return $total_fee;
    }

    function containsDecimal($value)
    {
        if (strpos($value, ".") !== false) {
            return true;
        }
        return false;
    }


    public function sendSMS($mobile, $text)
    {
        $url = 'http://188.138.41.146:7788/sendtext';
        $apiKey = 'df9a749228ec5f00';
        $secretKey = '93826498';
        $senderID = 'European IT';
        $mobileNumber = $mobile;
        $messageContent = $text;

        $fields = array(
            'apikey' => urlencode($apiKey),
            'secretkey' => urlencode($secretKey),
            'callerID' => $senderID,
            'toUser' => urlencode($mobileNumber),
            'messageContent' => $messageContent,
        );

        $fieldsString = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if ($result === false) {
            $error = curl_error($ch);
            $responseText = $error;
        } else {
            $response = json_decode($result, true);
            if (isset($response['Status'])) {
                $status = $response['Status'];
                $text = $response['Text'];

                if ($status == 0) {
                    return true;
                } else {
                    $responseText = $text;
                }
            }
        }

        return $responseText;

        curl_close($ch);
    }


    // public function sendSms($mobile,$text)
    // {

    //     $url = 'http://users.sendsmsbd.com/smsapi';
    //     $fields = array(
    //         'api_key' => urlencode('C2004644606ace59057584.63934821'),
    //         // 'api_key' => urlencode('C2004644606ace59057584.6393482134535'),
    //         'type' => urlencode('text'),
    //         'contacts' => urlencode($mobile),
    //       'senderid' => 'European IT',  // for masking
    //     // 'senderid' => '8809601000500',  //for non-masking
    //         'msg' => $text
    //     );
    //     $fields_string='';
    //     foreach($fields as $key=>$value){
    //         $fields_string .= $key.'='.$value.'&';
    //     }
    //     rtrim($fields_string, '&');
    //     $ch = curl_init();
    //     curl_setopt($ch,CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //     curl_setopt($ch, CURLOPT_POST, count($fields));
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_FAILONERROR, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     $result = curl_exec($ch);
    //     curl_close($ch);

    //     if (strpos($result, 'SMS SUBMITTED: ID') !== false) {
    //         return true;
    //     } elseif ($result == '1002') {
    //         return "Sender Id/Masking Not Found";
    //     } elseif ($result == '1003') {
    //         return "API Not Found";
    //     } elseif ($result == '1004') {
    //         return "SPAM Detected";
    //     } elseif ($result == '1005' || $result == '1006') {
    //         return "Internal Error";
    //     } elseif ($result == '1007') {
    //         return "Balance Insufficient";
    //     } elseif ($result == '1008') {
    //         return "Message is empty";
    //     } elseif ($result == '1009') {
    //         return "Message Type Not Set (text/unicode)";
    //     } elseif ($result == '1010') {
    //         return "Invalid User & Password";
    //     } elseif ($result == '1011') {
    //         return "Invalid User Id";
    //     } elseif ($result == '1012') {
    //         return "Invalid Number Found";
    //     } elseif ($result == '1013') {
    //         return "API limit error";
    //     } elseif ($result == '1014') {
    //         return "No matching template";
    //     } elseif ($result == '1015') {
    //         return "SMS Content Validation Fails";
    //     }
    //     return "Something went wrong :(";
    // }

    // public function sendSms($mobile,$text)
    // {
    //     $url = "https://bulksmsbd.net/api/smsapi";
    //     $api_key = "ocd8ExRE1Nzet2xhsxXz";
    //     $senderid = "8809612443871";
    //     $number = $mobile;
    //     $message = $text;

    //     $data = [
    //         "api_key" => $api_key,
    //         "senderid" => $senderid,
    //         "number" => $number,
    //         "message" => $message
    //     ];
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $get = (json_decode($response,true));
    //     $result = $get['response_code'];   

    //     if ($result == 202) {
    //         return true;
    //     } elseif ($result == '1002') {
    //         return "Sender Id/Masking Not Found";
    //     } elseif ($result == '1003') {
    //         return "API Not Found";
    //     } elseif ($result == '1004') {
    //         return "SPAM Detected";
    //     } elseif ($result == '1005' || $result == '1006') {
    //         return "Internal Error";
    //     } elseif ($result == '1006') {
    //         return "Balance Validity Not Available";
    //     }elseif ($result == '1007') {
    //         return "Balance Insufficient";
    //     }elseif ($result == '1008') {
    //         return "Message is empty";
    //     } elseif ($result == '1009') {
    //         return "Message Type Not Set (text/unicode)";
    //     } elseif ($result == '1010') {
    //         return "Invalid User & Password";
    //     } elseif ($result == '1011') {
    //         return "Invalid User Id";
    //     } elseif ($result == '1012') {
    //         return "Masking SMS must be sent in Bengali";
    //     } elseif ($result == '1013') {
    //         return "Sender Id has not found Gateway by api key";
    //     } elseif ($result == '1014') {
    //         return "Sender Type Name not found using this sender by api key";
    //     } elseif ($result == '1015') {
    //         return "Sender Id has not found Any Valid Gateway by api key";
    //     } elseif ($result == '1016') {
    //         return "Sender Type Name Active Price Info not found by this sender id";
    //     } elseif ($result == '1017') {
    //         return "Sender Type Name Price Info not found by this sender id";
    //     }elseif ($result == '1018') {
    //         return "The Owner of this (username) Account is disabled";
    //     }elseif ($result == '1019') {
    //         return "The (sender type name) Price of this (username) Account is disabled";
    //     }elseif ($result == '1020') {
    //         return "The parent of this account is not found.";
    //     }elseif ($result == '1021') {
    //         return "The parent active (sender type name) price of this account is not found.";
    //     }

    //     return "Something went wrong :(";


    // }

    public function sendBulkSms($mobile, $text)
    {
        $url = "https://bulksmsbd.net/api/smsapi";
        $api_key = "ocd8ExRE1Nzet2xhsxXz";
        $senderid = "8809617612436";
        $number = $mobile;
        $message = $text;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $get = (json_decode($response, true));
        $result = $get['response_code'];

        if ($result == 202) {
            return true;
        } elseif ($result == '1002') {
            return "Sender Id/Masking Not Found";
        } elseif ($result == '1003') {
            return "API Not Found";
        } elseif ($result == '1004') {
            return "SPAM Detected";
        } elseif ($result == '1005' || $result == '1006') {
            return "Internal Error";
        } elseif ($result == '1006') {
            return "Balance Validity Not Available";
        } elseif ($result == '1007') {
            return "Balance Insufficient";
        } elseif ($result == '1008') {
            return "Message is empty";
        } elseif ($result == '1009') {
            return "Message Type Not Set (text/unicode)";
        } elseif ($result == '1010') {
            return "Invalid User & Password";
        } elseif ($result == '1011') {
            return "Invalid User Id";
        } elseif ($result == '1012') {
            return "Masking SMS must be sent in Bengali";
        } elseif ($result == '1013') {
            return "Sender Id has not found Gateway by api key";
        } elseif ($result == '1014') {
            return "Sender Type Name not found using this sender by api key";
        } elseif ($result == '1015') {
            return "Sender Id has not found Any Valid Gateway by api key";
        } elseif ($result == '1016') {
            return "Sender Type Name Active Price Info not found by this sender id";
        } elseif ($result == '1017') {
            return "Sender Type Name Price Info not found by this sender id";
        } elseif ($result == '1018') {
            return "The Owner of this (username) Account is disabled";
        } elseif ($result == '1019') {
            return "The (sender type name) Price of this (username) Account is disabled";
        } elseif ($result == '1020') {
            return "The parent of this account is not found.";
        } elseif ($result == '1021') {
            return "The parent active (sender type name) price of this account is not found.";
        }

        return "Something went wrong :(";
    }


    public function sendMaskingSms($mobile, $text)
    {
        $url = 'http://188.138.41.146:7788/sendtext';
        $apiKey = 'df9a749228ec5f00';
        $secretKey = '93826498';
        $senderID = 'European IT';
        $mobileNumber = $mobile;
        $messageContent = $text;

        $fields = array(
            'apikey' => urlencode($apiKey),
            'secretkey' => urlencode($secretKey),
            'callerID' => $senderID,
            'toUser' => urlencode($mobileNumber),
            'messageContent' => $messageContent,
        );

        $fieldsString = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if ($result === false) {
            $error = curl_error($ch);
            $responseText = $error;
        } else {
            $response = json_decode($result, true);
            if (isset($response['Status'])) {
                $status = $response['Status'];
                $text = $response['Text'];

                if ($status == 0) {
                    return true;
                } else {
                    $responseText = $text;
                }
            }
        }

        return $responseText;

        curl_close($ch);
    }

    public function sendNonMaskingSms($mobile, $text)
    {
        $url = 'http://188.138.41.146:7788/sendtext';
        $apiKey = 'df9a749228ec5f00';
        $secretKey = '93826498';
        $senderID = 'European IT';
        $mobileNumber = $mobile;
        $messageContent = $text;

        $fields = array(
            'apikey' => urlencode($apiKey),
            'secretkey' => urlencode($secretKey),
            'callerID' => $senderID,
            'toUser' => urlencode($mobileNumber),
            'messageContent' => $messageContent,
        );

        $fieldsString = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if ($result === false) {
            $error = curl_error($ch);
            $responseText = $error;
        } else {
            $response = json_decode($result, true);
            if (isset($response['Status'])) {
                $status = $response['Status'];
                $text = $response['Text'];

                if ($status == 0) {
                    return true;
                } else {
                    $responseText = $text;
                }
            }
        }

        return $responseText;

        curl_close($ch);
    }




    // public function sendMaskingSms($mobile,$text)
    // {

    //     $url = 'http://users.sendsmsbd.com/smsapi';
    //     $fields = array(
    //         'api_key' => urlencode('C2004644606ace59057584.63934821'),
    //         // 'api_key' => urlencode('C2004644606ace59057584.6393482145345'),
    //         'type' => urlencode('text'),
    //         'contacts' => urlencode($mobile),
    //       'senderid' => 'European IT',  // for masking
    //     // 'senderid' => '8809601000500',  //for non-masking
    //         'msg' => $text
    //     );
    //     $fields_string='';
    //     foreach($fields as $key=>$value){
    //         $fields_string .= $key.'='.$value.'&';
    //     }
    //     rtrim($fields_string, '&');
    //     $ch = curl_init();
    //     curl_setopt($ch,CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //     curl_setopt($ch, CURLOPT_POST, count($fields));
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_FAILONERROR, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     $result = curl_exec($ch);
    //     curl_close($ch);

    //     if (strpos($result, 'SMS SUBMITTED: ID') !== false) {
    //         return true;
    //     } elseif ($result == '1002') {
    //         return "Sender Id/Masking Not Found";
    //     } elseif ($result == '1003') {
    //         return "API Not Found";
    //     } elseif ($result == '1004') {
    //         return "SPAM Detected";
    //     } elseif ($result == '1005' || $result == '1006') {
    //         return "Internal Error";
    //     } elseif ($result == '1007') {
    //         return "Balance Insufficient";
    //     } elseif ($result == '1008') {
    //         return "Message is empty";
    //     } elseif ($result == '1009') {
    //         return "Message Type Not Set (text/unicode)";
    //     } elseif ($result == '1010') {
    //         return "Invalid User & Password";
    //     } elseif ($result == '1011') {
    //         return "Invalid User Id";
    //     } elseif ($result == '1012') {
    //         return "Invalid Number Found";
    //     } elseif ($result == '1013') {
    //         return "API limit error";
    //     } elseif ($result == '1014') {
    //         return "No matching template";
    //     } elseif ($result == '1015') {
    //         return "SMS Content Validation Fails";
    //     }
    //     return "Something went wrong :(";
    // }




    // public function sendNonMaskingSms($mobile,$text)
    // {

    //     $url = 'http://users.sendsmsbd.com/smsapi';
    //     $fields = array(
    //         'api_key' => urlencode('C2004644606ace59057584.63934821'),
    //         // 'api_key' => urlencode('C2004644606ace59057584.63934821453'),
    //         'type' => urlencode('text'),
    //         'contacts' => urlencode($mobile),
    //     // 'senderid' => 'European IT',  // for masking
    //        'senderid' => '8809601000500',  //for non-masking
    //         'msg' => $text
    //     );
    //     $fields_string='';
    //     foreach($fields as $key=>$value){
    //         $fields_string .= $key.'='.$value.'&';
    //     }
    //     rtrim($fields_string, '&');
    //     $ch = curl_init();
    //     curl_setopt($ch,CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //     curl_setopt($ch, CURLOPT_POST, count($fields));
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_FAILONERROR, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     $result = curl_exec($ch);
    //     curl_close($ch);

    //     if (strpos($result, 'SMS SUBMITTED: ID') !== false) {
    //         return true;
    //     } elseif ($result == '1002') {
    //         return "Sender Id/Masking Not Found";
    //     } elseif ($result == '1003') {
    //         return "API Not Found";
    //     } elseif ($result == '1004') {
    //         return "SPAM Detected";
    //     } elseif ($result == '1005' || $result == '1006') {
    //         return "Internal Error";
    //     } elseif ($result == '1007') {
    //         return "Balance Insufficient";
    //     } elseif ($result == '1008') {
    //         return "Message is empty";
    //     } elseif ($result == '1009') {
    //         return "Message Type Not Set (text/unicode)";
    //     } elseif ($result == '1010') {
    //         return "Invalid User & Password";
    //     } elseif ($result == '1011') {
    //         return "Invalid User Id";
    //     } elseif ($result == '1012') {
    //         return "Invalid Number Found";
    //     } elseif ($result == '1013') {
    //         return "API limit error";
    //     } elseif ($result == '1014') {
    //         return "No matching template";
    //     } elseif ($result == '1015') {
    //         return "SMS Content Validation Fails";
    //     }

    //     return "Something went wrong :(";
    // }    

    public function number_convert($number)
    {

        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($en, $bn, $number);
    }

    public function number_convert_to_eng($number)
    {

        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($bn, $en, $number);
    }
    public function active_session()
    {
        $session = Sessions::where('status', 1)->first();
        return $session;
    }

    public function temp_list(Request $request)
    {
        $gender = null;
        $year = null;
        $model = CourseStudent::query();
        if ($request->input('year')) {
            $year = $request->input('year');
            $startOfYear = Carbon::createFromFormat('Y', $year)->startOfYear();
            $endOfYear = Carbon::createFromFormat('Y', $year)->endOfYear();
            $model = $model->whereBetween('created_at', [$startOfYear, $endOfYear]);
        }

        if ($request->input('gender')) {
            $gender = $request->input('gender');
            if ($gender != 'all') {
                $model->whereHas('student', function ($query) use ($gender) {
                    $query->where('gender', $gender);
                });
            }
        }

        $count = $model->get()->count();

        $c_students = $model->get()->groupBy('course_id');
        return view('temp', compact('c_students', 'gender', 'year', 'count'));
    }
}