<?php

namespace App\Http\Controllers\Seller;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\SendContactRequest;
use App\Models\Seller;
use App\Notifications\SendMailContactToAdmin;
use App\Notifications\SendMailContactToUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ContactController extends BaseController
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(SendContactRequest $request)
    {
        $data = [];

        if (SellerAuth::guard()->hasUser()) {
            $authUser = SellerAuth::user();
            $once = Seller::find($authUser->getUserId()->getInt());
            $data['user'] = $once;
        } else {
            $user = new Collection();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $data['user'] = $user;
        }

        $data['contact_category'] = $request->input('contact_category');
        $data['content'] = $request->input('content');

        Notification::route('mail', $data['user']->email)
            ->notify(new SendMailContactToUser($data));

        Notification::route('mail', 'hair_dev@hair.cm')
            ->notify(new SendMailContactToAdmin($data));

        return view('contact.result');
    }
}
