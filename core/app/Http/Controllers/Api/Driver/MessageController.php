<?php

namespace App\Http\Controllers\Api\Driver;

use App\Events\Ride as EventsRide;
use App\Models\Ride;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function messages($id)
    {
        $messages = Message::where('ride_id', $id)->orderBy('id', 'desc')->get();
        $notify[] = 'Ride Messages';

        return apiResponse('ride_message', 'success', $notify, [
            'messages'   => $messages,
            'image_path' => getFilePath('message')
        ]);
    }


    public function messageSave(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $driver = auth()->user();
        $ride   = Ride::where('driver_id', $driver->id)->find($id);

        if (!$ride) {
            $notify[] = 'Invalid ride';
            return apiResponse('not_found', 'error', $notify);
        }

        $message            = new Message();
        $message->ride_id   = $ride->id;
        $message->driver_id = $ride->driver_id;
        $message->message   = $request->message;

        if ($request->hasFile('image')) {
            try {
                $message->image = fileUploader($request->image, getFilePath('message'), null, null);
            } catch (\Exception $exp) {
                $notify[] = "Couldn\'t upload your image";
                return apiResponse('exception', 'error', $notify);
            }
        }

        $message->save();

        $data['message'] = $message;
        event(new EventsRide("rider-user-$ride->user_id", "MESSAGE_RECEIVED", $data));

        $notify[] = 'Message send successfully';
        return apiResponse('message', 'success', $notify, $data);
    }
}
