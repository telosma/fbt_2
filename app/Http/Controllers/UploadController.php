<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use RemoteImageUploader\Factory;
use Exception;

class UploadController extends Controller
{

    public function storageImage(Request $request)
    {
        try {
            $result = Factory::create(config('upload.image_upload.host'), config('upload.image_upload.auth'))
                ->upload($request->upload->path());

            return [
                'status' => true,
                'url' => $result,
                'message' => trans('admin.upload_response', ['response' => trans('general.responses.success')]),
            ];
        } catch (Exception $ex) {
            return [
                'status' => false,
                'url' => '',
                'message' => trans('admin.upload_response', ['response' => trans('general.responses.fail')]),
            ];
        }
    }

    public function storageImageCKEditor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|image',
            'CKEditorFuncNum' => 'required',
        ]);
        if ($validator->fails()) {
            $message = implode(' ', $validator->errors()->all());

            return view('uploadCKEditor', [
                'CKEditorFuncNum' => $request->CKEditorFuncNum,
                'data' => [
                    'url' => null,
                    'message' => $message,
                ],
            ]);
        }

        return view('uploadCKEditor', [
            'CKEditorFuncNum' => $request->CKEditorFuncNum,
            'data' => $this->storageImage($request),
        ]);
    }
}
