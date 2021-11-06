<?php

namespace App\Http\Controllers;

use App\Services\DiscordWebhookService;
use Illuminate\Http\Request;
use App\Services\Dto\NotifyDto;

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
class DiscordNotificationAPIController extends Controller
{
    private DiscordWebhookService $service;

    public function __construct(DiscordWebhookService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $notification = [
            'title' => 'help information',
            'send notify' => 'POST query from http://domain:89/api/notifications',
            'body query' => '{"who": "test_service", "message": "test message"}',
        ];

        return response()->json($notification, 200);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'who' => 'required|max:500',
            'message' => 'required|max:1000',
            'is_priority' => 'integer'
        ]);

        $notify = new NotifyDto();
        $notify->sender = $validated['who'];
        $notify->message = $validated['message'];
        $notify->isPriority = $validated['is_priority'] ?? 0;
        $notify->ip = $_SERVER['HTTP_CLIENT_IP'] ?? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']) ?? 'none';

        $this->service->send($notify);

        return response()->json(['success' => true], 200);
    }
}
