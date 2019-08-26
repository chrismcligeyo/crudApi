<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::all();
        //we are going to return a response
        return response()->json($items); //return a response with items in database formatted as json
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
        // ensure you include all api/ urls in middleware/VerifyCsrfToken at $protected except. this is to avid getting an error 500 while using postman. error caused because laravel includes csrf tokens while using POST request to send forms. this does work with postman, so disable crsf for all api/ route urls
//        $this->validate($request, [
//        'text' => 'required'
//        ]); //if we validate as shown we wont be able to handle errors,we cant say what happens if it fails or not. do below

        $validator = Validator::make($request->all(), [
           'text' => 'required'
        ]);

        //test to  see if validATOR fails, if it does return json response
        if($validator->fails()){//means form is submitted without entering value in text field
            $response = array('response' => $validator->messages(), 'success' => false ); //success set to false because it did not validate
            return $response;
        } else {//if there is text field continue inserting in database
            //createform
            $item = new Item;

            $item->text = $request->input('text');
            $item->body = $request->input('body');
            $item->save();//saves in database

            //respond with item it saves in database
            return response()->json($item);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //to show a single item from api from(database)
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        //test to  see if validATOR fails, if it does return json response
        if($validator->fails()){//means form is submitted without entering value in text field
            $response = array('response' => $validator->messages(), 'success' => false ); //success set to false because it did not validate
            return $response;
        } else {//if there is text field continue inserting in database



            //Find an item
            $item = Item::find($id);

            $item->text = $request->input('text');
            $item->body = $request->input('body');
            $item->save();//saves in database

            //respond with item it saves in database
            return response()->json($item);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $item->delete();

        $response = ['response' => 'item Deleted', 'success' => true];

        return $response;


    }
}
