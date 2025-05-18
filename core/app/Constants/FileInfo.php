<?php

namespace App\Constants;

class FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This class basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo()
    {
        $data['withdrawVerify'] = [
            'path' => 'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path' => 'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path' => 'assets/verify'
        ];
        $data['default'] = [
            'path' => 'assets/images/default.png',
        ];
        $data['ticket'] = [
            'path' => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path' => 'assets/images/logo_icon',
        ];
        $data['preloader'] = [
            'path' => 'assets/images/preloader',
        ];
        $data['notification_audio'] = [
            'path' => 'assets/file/notification_audio',
        ];
        $data['favicon'] = [
            'size' => '128x128',
        ];
        $data['extensions'] = [
            'path' => 'assets/images/extensions',
            'size' => '36x36',
        ];
        $data['seo'] = [
            'path' => 'assets/images/seo',
            'size' => '1180x600',
        ];
        $data['user'] = [
            'path' => 'assets/images/user',
            'size' => '350x300',
        ];
        $data['driver'] = [
            'path' => 'assets/images/driver',
            'size' => '350x300',
        ];
        $data['admin'] = [
            'path' => 'assets/admin/images/profile',
            'size' => '400x400',
        ];
        $data['push'] = [
            'path' => 'assets/images/push_notification',
        ];
        $data['appPurchase'] = [
            'path' => 'assets/in_app_purchase_config',
        ];
        $data['maintenance'] = [
            'path' => 'assets/images/maintenance',
            'size' => '600x600',
        ];
        $data['language'] = [
            'path' => 'assets/images/language',
            'size' => '80x80'
        ];
        $data['gateway'] = [
            'path' => 'assets/images/gateway',
            'size' => ''
        ];
        $data['withdrawMethod'] = [
            'path' => 'assets/images/withdraw_method',
            'size' => ''
        ];
        $data['pushConfig'] = [
            'path' => 'assets/admin',
        ];
        $data['service'] = [
            'path' => 'assets/images/service',
            'size' => '250x250',
        ];
        $data['brand'] = [
            'path' => 'assets/images/brand',
            'size' => '100x100',
        ];
        $data['promotional_notify'] = [
            'path' => 'assets/images/promotional_notify',
            'size' => '400x225',
        ];
        $data['message'] = [
            'path'      => 'assets/images/message',
        ];
        $data['vehicle'] = [
            'path'      => 'assets/images/vehicle',
        ];
        return $data;
    }
}
