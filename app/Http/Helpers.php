<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getThumb($link, $length = 100)
{
    $restLink = config('upload.image_upload.rest_link');
    $requests = [];
    $result = [
        'origin' => $link,
    ];
    $maxLengthArray = config('upload.image_upload.max_length_array');
    $maxLengthCount = count($maxLengthArray);
    for ($i = 0; $i < $maxLengthCount - 1; $i++) {
        $p = $length - $maxLengthArray[$i];
        $q = $maxLengthArray[$i + 1] - $length;
        if ($p >= 0 && $q >= 0) {
            if ($p < $q) {
                $length = $maxLengthArray[$i];
            } else {
                $length = $maxLengthArray[$i + 1];
            }
            break;
        }
    }
    $path = pathinfo($link);
    $photoInfo = explode('_', $path['filename']);
    $flickAuth = config('upload.image_upload.auth');
    $attributes = [
        'api_key' => $flickAuth['api_key'],
        'photo_id' => $photoInfo[0],
        'method' => 'flickr.photos.getSizes',
        'format' => 'php_serial',
    ];
    foreach ($attributes as $k => $v) {
        $requests[] = urlencode($k) . '=' . urlencode($v);
    }
    $response = file_get_contents($restLink . '?' . implode('&', $requests));
    $responseObject = unserialize($response);
    if ($responseObject['stat'] == 'ok') {
        $result['status'] = true;
        foreach ($responseObject['sizes']['size'] as $size) {
            if ($size['width'] == $length || $size['height'] == $length) {
                $result['thumbnail'] = $size['source'];
                break;
            }
        }
    } else {
        $result['status'] = false;
        $result['message'] = $responseObject['message'];
    }

    return $result;
}
