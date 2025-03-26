<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function showPostImagesForm ($postId) {
        $post = Post::findOrFail($postId);
        $title = 'Imagini Postare';
        return view('admin.posts.edit-post-images-form')->with('post', $post)->with('title', $title);
    }

    public function uploadPostImages (Request $request, $postId) {
        if ($request->hasFile('images')) {
            $orderNumber = 10;
            foreach ($request->images as $currentImage) {
                $photoExtension = $currentImage->getClientOriginalExtension();
                $photoName = $orderNumber . '_' . time() . Str::random(6) . '.' . $photoExtension;
                $currentImage->move('storage/images/post-images/' . $postId . '/', $photoName);
                
                $imageForDB = new Image();
                $imageForDB->post_id = $postId;
                $imageForDB->file = $photoName;
                $imageForDB->position = $orderNumber;
                $imageForDB->save();

                $orderNumber = $orderNumber + 10;
            }
            return back()->with('success', 'Imaginile au fost incarcate cu succes!');
        }
    }
}
