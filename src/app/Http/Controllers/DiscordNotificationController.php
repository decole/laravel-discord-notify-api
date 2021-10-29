<?php

namespace App\Http\Controllers;

use App\Models\DiscordNotification;
use Illuminate\Http\Request;

/**
 * 200: OK. The standard success code and default option.
 * 201: Object created. Useful for the store actions.
 * 204: No content. When an action was executed successfully, but there is no content to return.
 * 206: Partial content. Useful when you have to return a paginated list of resources.
 * 400: Bad request. The standard option for requests that fail to pass validation.
 * 401: Unauthorized. The user needs to be authenticated.
 * 403: Forbidden. The user is authenticated, but does not have the permissions to perform an action.
 * 404: Not found. This will be returned automatically by Laravel when the resource is not found.
 * 500: Internal server error. Ideally you're not going to be explicitly returning this, but if something unexpected breaks, this is what your user is going to receive.
 * 503: Service unavailable. Pretty self explanatory, but also another code that is not going to be returned explicitly by the application.
 */
class DiscordNotificationController extends Controller
{
    public function index()
    {
        $notification = [
            'title' => 'help information',
            'send notify' => 'POST query from http://domain:89/api/notifications',
            'body query' => '{"who": "test_service", "message": "test message"}',
        ];

        return response()->json($notification, 200);
    }

    public function show($id)
    {
        $notification = DiscordNotification::find($id);

        if (!$notification) {
            return response()->json(['error' => 'resource not found'], 404);
        }

        return response()->json($notification, 200);
    }

    public function store(Request $request)
    {
        $notification = DiscordNotification::create($request->all());

        $ip = $_SERVER['HTTP_CLIENT_IP'] ?? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']) ?? 'none';
        $notification->ip = $ip;
        $notification->update();

        return response()->json($notification, 201);
    }

    public function update(Request $request, $id)
    {
        $notification = DiscordNotification::findOrFail($id);
        $notification->update($request->all());

        return response()->json($notification, 200);
    }

    public function delete(Request $request, $id)
    {
        $notification = DiscordNotification::find($id);

        if (!$notification) {
            return response()->json(['error' => 'notification not found to delete'], 404);
        }

        $notification->delete();

        return response()->json(null, 204);
    }
}
