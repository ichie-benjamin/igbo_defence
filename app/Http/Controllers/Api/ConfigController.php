<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function getSettings(): JsonResponse
    {

        $data['faqs_url'] = null;
        $data['contact_url'] = "https://igbodefence.com/contact/";
        $data['support_url'] = "https://igbodefence.com/support-us/";
        $data['buy_url'] =  null;
        $data['partner_url'] = null;
        $data['terms_url'] = "https://igbodefence.com/privacy-policy/";
        $data['about_url'] = "https://igbodefence.com/about-igbodefence/";
        $data['privacy_url'] = "https://igbodefence.com/privacy-policy/";
        $data['insta_url'] = "https://www.instagram.com/IgboDefenceNews";
        $data['whatsapp_url'] = null;
        $data['fb_url'] = "https://www.facebook.com/igbodefencenews";
        $data['tiktok_url'] = null;
        $data['youtube'] =  "https://www.youtube.com/@IgboDefenceNews";
        $data['twitter_url'] = "https://twitter.com/iGboDefenceNews";

        $data['change_password_url'] = null;
        $data['forgot_password_url'] = url('password/reset').'?app';

        return $this->successResponse('config settings', $data);
    }

}
