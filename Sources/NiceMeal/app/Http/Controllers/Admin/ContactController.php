<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Role;
use App\Models\ContactCategory;
use Illuminate\Http\Request;
use Log, Auth, Session;
use App\Mail\SendMailable;
use App\Services\CommonService;
use phpDocumentor\Reflection\Types\Integer;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.contacts.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contacts_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        // get search params
        $keyword = $request->get('q');

        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $contacts = Contact::select('contacts.*' )->orderBy('contacts.id', 'desc');


        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $contacts = $contacts->where(function ($query) use ($keyword) {
                $query->orWhere('contacts.title', 'LIKE', $keyword);
                $query->orWhere('contacts.name', 'LIKE', $keyword);
                $query->orWhere('contacts.email', 'LIKE', $keyword);
                $query->orWhere('contacts.phone', 'LIKE', $keyword);
            });
        }
        $contacts = $contacts->paginate($perPage);
        return view ('admin.contacts.index',compact('contacts','breadcrumbs', 'lang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_user()
    {
        $contact_categories = ContactCategory::all();
        return view('user.contact-us',compact('contact_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        // save file
        if($request->hasFile('file_attach')) {
            $file = $request->file('file_attach');
            $name_file = time().'-'.$file->getClientOriginalName();
            $path = $request->file('file_attach')->storeAs('public/contacts',$name_file,'local');
        }
        if(!empty($path)) {
            $requestData['file_attach'] = $path;
        }
        // remove token
        unset($requestData['_token']);
        Contact::create($requestData);
        // Send mail admin
        // Get List User Admin
        $users = Role::find(1)->users()->get();
        foreach ($users as $user) {
            $this->sendMail($user->email,'New Contact - '. $requestData['title'],$requestData['message']);
        }
        Session::flash('flash_message', trans('Thank you, we will contact you soon'));
        return redirect('contact-us');

    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contacts_index')
                ],
                [
                    'href' => url('admin/contacts/' . $id),
                    'text' => __('admin.contacts.breadcrumbs.show_contact')
                ]
            ]
        ];
        $contact = Contact::findOrFail($id);
        if(!$contact->is_read) {
            $contact->update(['is_read' => 1]);
        }
        return view ('admin.contacts.show',compact('contact','breadcrumbs', 'lang'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $contact = Contact::findOrFail($id);
//
//        \Storage::delete($contact->file_attach);
//
//        $contact->delete();
//
//        Session::flash('flash_message', trans('admin.contacts.flash_messages.destroy'));
//        return redirect('admin/contacts');
    }

    public function download($id) {
        $contact = Contact::findOrFail($id);
        return \Storage::download($contact->file_attach);
    }

    private function sendMail($email,$subject,$message)
    {
        return \Mail::to($email)->send(new SendMailable([
            'email' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME'),
            'subject' => $subject,
            'message' => $message,
            'view_path' => 'emails.contact'
        ]));
    }
}
