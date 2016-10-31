<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getThumb($link, $with = 100)
{
    $restLink = config('upload.image_upload.rest_link');
    $requests = [];
    $result = [
        'origin' => $link,
    ];
    $maxWithArray = config('upload.image_upload.max_with_array');
    $maxWithCount = count($maxWithArray);
    for ($i = 0; $i < $maxWithCount - 1; $i++) {
        $p = $with - $maxWithArray[$i];
        $q = $maxWithArray[$i + 1] - $with;
        if ($p >= 0 && $q >= 0) {
            if ($p < $q) {
                $with = $maxWithArray[$i];
            } else {
                $with = $maxWithArray[$i + 1];
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
            if ($size['width'] == $with) {
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
