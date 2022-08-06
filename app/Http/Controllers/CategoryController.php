<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();

        return response()->json(
            [
                'success' => true,
                'data' => $data
            ]
        );
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
        $validators = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ],
            [
                'name.required' => 'Please Input Name!'
            ]
        );

        if ($validators->fails()) {
            return response()->json($validators->errors());
        } else {
            $data = Category::create(
                [
                    'name' => $request->input('name'),
                ]
            );

            if ($data) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Category Added!',
                        'data' => $data
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fail Adding Category'
                    ]
                );
            }
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
        $category = Category::whereId($id)->first();

        if ($category) {
            return response()->json(
                [
                    'success' => true,
                    'data' => $category
                ]
            );
        }
        return response()->json(
            [
                'success' => false,
                'message' => 'Data Not Found:('
            ],
            404
        );
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
        $validators = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ],
            [
                'name.required' => 'Please Input New Name!'
            ]
        );
        if ($validators->fails()) {
            return response()->json($validators->errors());
        }

        $update = Category::whereId($id)->update(
            [
                'name' => $request->input('name')
            ]
        );

        if ($update) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data Updated!',
                ]
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Update Failed'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Category::whereId($id)->delete();

        if ($delete) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data Deleted'
                ]
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Delete Failed'
            ]
        );
    }
}
