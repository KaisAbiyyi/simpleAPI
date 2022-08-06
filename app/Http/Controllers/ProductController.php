<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('category')->get();

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
                'name' => 'required',
                'price' => 'required|numeric',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id|numeric',
            ],
            [
                'name.required' => 'Please Input Name!',
                'price.required' => 'Please Input Price',
                'description.required' => 'Please Input Description',
                'category_id.required' => 'Please Input Category Id'
            ]
        );

        if ($validators->fails()) {
            return response()->json($validators->errors());
        } else {
            $data = Product::create(
                [
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'description' => $request->input('description'),
                    'category_id' => $request->input('category_id')
                ]
            );

            if ($data) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Product Added!',
                        'data' => $data
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fail Adding Product'
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
        $category = Product::whereId($id)->first();

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
                'name' => 'required',
                'price' => 'required|numeric',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id|numeric',
            ],
            [
                'name.required' => 'Please Input New Name!',
                'price.required' => 'Please Input Price',
                'description.required' => 'Please Input Description',
                'category_id.required' => 'Please Input Category Id'
            ]
        );
        if ($validators->fails()) {
            return response()->json($validators->errors());
        }

        $update = Product::whereId($id)->update(
            [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id')
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
        $delete = Product::whereId($id)->delete();

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
