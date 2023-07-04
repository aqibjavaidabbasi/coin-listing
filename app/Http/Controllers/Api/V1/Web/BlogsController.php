<?php

namespace App\Http\Controllers\Api\V1\Web;

use Validator;
use App\Models\Blog;
use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\BaseController;

class BlogsController extends BaseController
{
    public function index(Request $request, $promoted = false)
    {

        $blogs = Blog::get();
       
        return $this->sendResponse($blogs, 'Blog retrieved successfully.');
    }

    public function getAllblogs(Request $request, $promoted = false)
    {

        $blogs = Blog::where('is_featured', 1)->latest()->get();

        return $this->sendResponse($blogs, 'Blog retrieved successfully.');
    }

    public function LatestFeaturedBlog(Request $request, $promoted = false)
    {
        $latestFeaturedBlog = Blog::where('is_active', 1)
            ->where('is_featured', 1)
            ->latest()
            ->first();

        if (!$latestFeaturedBlog) {
            return $this->sendError('Featured blog not found.', [], 404);
        }

        return $this->sendResponse($latestFeaturedBlog, 'Featured blog retrieved successfully.');
    }


    public function LatestFeaturedBlogs(Request $request, $promoted = false)
    {
        $latestFeaturedBlog = Blog::where('is_active', 1)
            ->where('is_featured', 1)
            ->latest()
            ->get();

        if (!$latestFeaturedBlog) {
            return $this->sendError('Featured blog not found.', [], 404);
        }

        return $this->sendResponse($latestFeaturedBlog, 'Featured blog retrieved successfully.');
    }

    public function getBlogBySlug(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_active', 1)->first();

        if (!$blog) {
            return $this->sendError('Blog not found.', [], 404);
        }

        return $this->sendResponse($blog, 'Blog retrieved successfully.');
    }


    public function store(Request $request)
    {


        $input = $request->all();

        $is_active = false;
        if ($request->has('source')) {
            unset($input['source']);
            $is_active = true;
        }

        if ($request->is_featured == true) {
            $is_featured = 1;
        } else {
            $is_featured = 0;
        }

        // $is_featured = $request->is_featured ? 1 : 0;


        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',

        ]);

        $slugify = new Slugify();
        $slug = $slugify->slugify($input['title']);

        // Check if the generated slug already exists in the database
        $existingBlog = Blog::where('slug', $slug)->first();
        if ($existingBlog) {
            $slug = $slug . '-' . Uuid::uuid4()->toString(); // Append UUID to make it unique
        }

        $extraValue = Uuid::uuid4()->toString();


        $input = array_merge($input, ['slug' => $slug, 'uuid' => $extraValue, 'is_featured' => $is_featured]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $blog = Blog::create($input);
        $imageName = 'blog_' . $blog->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/blog', $imageName);
        $blog->update(['image' => $imageName, 'is_active' => $is_active]);
        $blog->update(['image' => $imageName, 'is_active' => $is_active]);
        $blog->update(['is_featured' =>  $is_featured]);
        return $this->sendResponse($blog->toArray(), 'Blog created successfully.');
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        $is_active = false;
        if ($request->has('source')) {
            unset($input['source']);
            $is_active = true;
        }

        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $blog = Blog::find($id);
        if (!$blog) {
            return $this->sendError('Blog not found.');
        }

        $slugify = new Slugify();
        $slug = $slugify->slugify($input['title']);

        // Check if the generated slug already exists in the database, excluding the current blog
        $existingBlog = Blog::where('slug', $slug)->where('id', '!=', $blog->id)->first();
        if ($existingBlog) {
            $slug = $slug . '-' . Uuid::uuid4()->toString(); // Append UUID to make it unique
        }

        $extraValue = Uuid::uuid4()->toString();

        $input = array_merge($input, ['slug' => $slug, 'uuid' => $extraValue]);

        $blog->update($input);

        if ($request->hasFile('image')) {
            $imageName = 'blog_' . $blog->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/blog', $imageName);
            $blog->update(['image' => $imageName]);
        }

        $blog->update(['is_active' => $request->is_active]);

        return $this->sendResponse($blog->toArray(), 'Blog updated successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $input = $request->all();
        $blog = Blog::find($id);

        // Check and update the fields if they are true
        $updatedFields = [];
        $fieldMappings = [
            'is_featured' => 'Feature',
            'is_promoted' => 'Promotion',
            'visitors' => 'Visitors',
            'impressions' => 'Impressions',
        ];

        foreach ($fieldMappings as $field => $fieldName) {
            if (isset($input[$field])) {
                $blog->$field = $input[$field];
                if ($input[$field]) {
                    $updatedFields[] = $fieldName;
                }
            }
        }

        // Save the changes
        $blog->save();

        // Generate the success message dynamically
        // Generate the success message dynamically
        $message = '';
        if (empty($updatedFields)) {
            // $message = 'No fields updated.';
            $message = implode(', ', $updatedFields) . ' Dective successfully.';
        } else {
            $message = implode(', ', $updatedFields) . ' active successfully.';
        }


        // Include the updated fields in the response data
        $responseData = [
            'updatedFields' => $updatedFields,
            'blog' => $blog->toArray(),
        ];

        return $this->sendResponse($responseData, $message);
    }




    public function edit($id)
    {
        $group = Blog::find($id);

        return $this->sendResponse($group, 'Blog retrieved successfully.');
    }

    public function delete($id)
    {

        $blog = Blog::find($id);
        if (!$blog)
            return;
        $blog->delete();

        return $this->sendResponse($blog->toArray(), 'Blog deleted successfully.');
    }

    public function BlogView(Request $request, $id)
    {

        $blogs = Blog::find($id);
        return $this->sendResponse($blogs, 'Blog retrieved successfully.');
    }
}
