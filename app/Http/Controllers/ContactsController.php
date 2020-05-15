<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contact::class);

        return ContactResource::collection(request()->user()->contacts);
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', Contact::class);

        $contact = request()->user()->contacts()->create($this->validateData());

        /*

        $this->validate(request('data'), [
            'name' => 'required',
            'email' => 'required|email',
            'company' => 'required',
            'birthday' => 'requird'
            ]);
     

        $input = $request->all();

        
        return($input);

 
 //       $contact = request('data')->user()->contacts()->create($this->validateData());


  //       $contact = request()->data;

//        var_dump($contact);

//    $contact = $this->validateData();

//           return($request->data->name);
 

        
  
        $contact['name']      = request()->data['name'];
        $contact['email']     = request()->data['email'];        
        $contact['company']   = request()->data['company'];
        $contact['birthday']   = request()->data['birthday'];
        $contact['user_id']   = request()->user()->id;
 //       return($contact);
        $contact->save();

        */
       return (new ContactResource($contact))
           ->response()
           ->setStatusCode(Response::HTTP_CREATED);

        

 //       $contact->save();
    }

//       return($request);

//        $contact = $jbelly->validateData();

//         return(request()->data);

 //       return($validatedData);

 //        $contact = request()->user()->contacts()->create($this->validateData());

  //      $contact = $data->user()->contacts()->create($this->validateData());

  //      return (new ContactResource($contact))
  //          ->response()
  //          ->setStatusCode(Response::HTTP_CREATED);
    

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return new ContactResource($contact);
    }

    public function update(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($this->validateData());

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData()
    {
        return request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required',
            'company' => 'required',
        ]);
    }


}
