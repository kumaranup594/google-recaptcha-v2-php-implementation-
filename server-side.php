<?php

$recaptchEnable = true;

function pushCURL($url, $formData = array(), $req_curl_output = 0)
{
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($formData)) {
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($formData));
    }
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
    if ($req_curl_output) {
        return $buffer;
    }
    $buffer = json_decode($buffer);
    return $buffer;
}

function getIP()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

if ($recaptchEnable) {

    if (!isset($_REQUEST['g-recaptcha-response'])) {
        $_REQUEST['err_msg'] = "Captacha is required";
    } else if ($_REQUEST['g-recaptcha-response'] == "") {
        $_REQUEST['err_msg'] = "Captacha is required";
    } else {
        $formData = [
            'secret' => '---',
            'response' => $_REQUEST['g-recaptcha-response'],
            'remoteip' => getIP()
        ];
        $res = pushCURL('https://www.google.com/recaptcha/api/siteverify', $formData, true);

        $res = json_decode($res, true);
        if (!isset($res['success'])) {
            $_REQUEST['err_msg'] = "Invalid Captacha";
        } else if ($res['success'] == false) {
            $_REQUEST['err_msg'] = "Invalid Captacha, or expired, please try again";
        }
    }

    if (isset($_REQUEST['err_msg'])) {
        $url = "/contact-form.php?" . http_build_query($_REQUEST);
        header('location:' . $url);
    }
}

