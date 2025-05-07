<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Requests\UploadImagesRequest;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function showPostImagesForm ($postId) {
        $post = Post::findOrFail($postId);
        $title = 'Imagini Postare';
        $postImages = $post->images()->paginate(4);
        return view('admin.posts.edit-post-images-form')->with('post', $post)->with('title', $title)->with('postImages', $postImages);
    }

    public function uploadPostImages (UploadImagesRequest $request, $postId) {
        if ($request->hasFile('images')) {
            $orderNumber = 10;
            foreach ($request->images as $currentImage) {
                $imageExtension = $currentImage->getClientOriginalExtension();
                $imageName = $orderNumber . '_' . time() . Str::random(6) . '.' . $imageExtension;
                $currentImage->move('storage/images/post-images/' . $postId . '/', $imageName);
                
                $imageForDB = new Image();
                $imageForDB->post_id = $postId;
                $imageForDB->file = $imageName;
                $imageForDB->position = $orderNumber;
                $imageForDB->save();

                $orderNumber = $orderNumber + 10;
            }
            return back()->with('success', 'Imaginile au fost incarcate cu succes!');
        }
        return back();
    }

    public function updatePostImageFromGallery(UpdateImageRequest $request, $imageId) {
        $image = Image::findOrFail($imageId);

        if (request('title')) {
            $image->title = $request->title;
        }

        if (request('description')) {
            $image->description = $request->description;
        }

        $image->position = $request->position;

        if (request('published')) {
            $image->published = $request->published;
        } else {
            $image->published = 0;
        }

        if ($request->hasFile('image')) {
            if (File::exists($image->filePath())) {
                File::delete($image->filePath());
            }

            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageName = $request->position . '_' . time() . Str::random(5) . '.' . $imageExtension;
            $request->file('image')->move('storage/images/post-images/' . $image->post_id . '/', $imageName);
            $image->file = $imageName;
        }

        $image->save();

        return back()->with('success', 'Imagininea a fost actualizată cu succes!');
    }

    public function deleteAllPostImages($imageId) {
        $post = Post::findOrFail($imageId);

        // Dacă postarea are imagini în galerie le vom șterge pe toate atât din baza de date și de pe HDD:
        if ($post->images()->count() > 0) {
            foreach ($post->images as $image) {
                $image->delete();
            }

            File::deleteDirectory('storage/images/post-images/' . $post->id);

            return back()->with('success', 'Galeria de imagini a fost ștearsă cu succes!');
        }

        return back()->with('success', 'Nu există imagini în galeria de imagini pentru ștergere!');
    }

    public function deleteSinglePostImage($imageId) {
        $image = Image::findOrFail($imageId);

        if (File::exists($image->filePath())) {
            File::delete($image->filePath());
        }

        $image->delete();

        return back()->with('success', 'Imaginea a fost ștearsă din galerie!');
    }
}
