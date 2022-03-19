<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/blog",
     *     operationId="/blog",
     *     tags={"crud api using mongodb"},
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
    /**
     * @OA\Get(
     *     path="/blog/{id}",
     *     operationId="/blog/id",
     *     tags={"crud api using mongodb"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Blog",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
    /**
     * @OA\Post(
     *     path="/blog",
     *     operationId="/blog",
     *     tags={"crud api using mongodb"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Blog title",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="Blog content",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
    /**
     * @OA\Put(
     *     path="/blog/{id}",
     *     operationId="/blog/{id}",
     *     tags={"crud api using mongodb"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Blog",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Blog title",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="Blog content",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
    /**
     * @OA\Delete(
     *     path="/blog/{id}",
     *     operationId="/blog/id",
     *     tags={"crud api using mongodb"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Blog",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
    public function index()
    {
        $blogs = Blog::all();

        $response = $this->apiHelper->make_response(1, 'Retrieve data success!', $blogs->count(), $blogs);

        return response()->json($response);
    }

    public function show($id)
    {
        $blog = Blog::where('_id', $id);

        $response = $this->apiHelper->make_response(1, 'Retrieve data success!', $blog->count(), $blog->first());

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $rules = ['title' => 'required', 'content' => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = $this->apiHelper->make_response(0, $validator->errors()->messages());

            return response()->json($response, 400);
        }

        try {
            $blog = Blog::create($request->all());

            $response = $this->apiHelper->make_response(1, 'Data created!', 1, $blog);

            return response()->json($response);
        } catch (\Throwable $th) {
            \Sentry\captureException($th);
            $response = $this->apiHelper->make_response(0, $th->getMessage());

            return response()->json($response);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = ['title' => 'required', 'content' => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = $this->apiHelper->make_response(0, $validator->errors()->messages());

            return response()->json($response, 400);
        }

        try {
            $blog = Blog::where('_id', $id);

            if ($blog->count() > 0) {
                $blog->update($request->all());

                $response = $this->apiHelper->make_response(1, 'Data updated!', $blog->count(), $blog->first());
            } else {
                $response = $this->apiHelper->make_response(0, 'Data not found!', $blog->count());
            }
            return response()->json($response);
        } catch (\Throwable $th) {
            \Sentry\captureException($th);
            $response = $this->apiHelper->make_response(0, $th->getMessage());

            return response()->json($response);
        }
    }

    public function destroy($id)
    {
        try {
            $blog = Blog::where('_id', $id);

            if ($blog->count() > 0) {
                $blog->delete();

                $response = $this->apiHelper->make_response(1, 'Data deleted!', $blog->count(), $blog->first());
            } else {
                $response = $this->apiHelper->make_response(0, 'Data not found!', $blog->count());
            }

            return response()->json($response);
        } catch (\Throwable $th) {
            \Sentry\captureException($th);
            $response = $this->apiHelper->make_response(0, $th->getMessage());

            return response()->json($response);
        }
    }
}
