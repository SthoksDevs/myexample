<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class Contacts extends Controller
{
    /*
     * Retrieves active contacts from database in alphabetical order.
     *
     * @return Response
     */
    public function index() {
        return Contact::where('active', 1)->orderBy('first_name', 'asc')->get();
    }

    /**
     * Stores a new contact in database.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $contact = new Contact;

        $contact->first_name = $request->input('first_name');
        $contact->last_name = $request->input('last_name');
        $contact->email = $request->input('email');
        $contact->mobile_number = $request->input('mobile_number');
        $contact->active = 1;
        $contact->save();
        //session()->flash("message","Contact successfully created");
        return;
    }

    /**
     * Searches contact by id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return Contact::findOrFail($id);
    }

    /**
     * Update a contact.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $contact = Contact::find($id);

        $contact->first_name = $request->input('first_name');
        $contact->last_name = $request->input('last_name');
        $contact->email = $request->input('email');
        $contact->mobile_number = $request->input('mobile_number');
        $contact->save();

        return;
    }

    /**
     * Deletes a contact.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $contact = Contact::findOrFail($id);

        $contact->delete();
        return ;
    }
}
