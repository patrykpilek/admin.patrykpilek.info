<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    /**
     * BlogController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('auth');
        $this->middleware('check-permissions');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $onlyTrashed = FALSE;

        if (($status = $request->get('status')) && $status == 'trash') {
            $posts = Post::onlyTrashed()->with('category', 'author')->latest()->paginate($this->limit);
            $postCount = ($tmp = Post::onlyTrashed()) ? $tmp->count() : 0;
            $onlyTrashed = TRUE;
        } elseif ($status == 'published') {
            $posts = Post::published()->with('category', 'author')->latest()->paginate($this->limit);
            $postCount = ($tmp = Post::published()) ? $tmp->count() : 0;
        } elseif ($status == 'scheduled') {
            $posts = Post::scheduled()->with('category', 'author')->latest()->paginate($this->limit);
            $postCount = ($tmp = Post::scheduled()) ? $tmp->count() : 0;
        } elseif ($status == 'draft') {
            $posts = Post::draft()->with('category', 'author')->latest()->paginate($this->limit);
            $postCount = ($tmp = Post::draft()) ? $tmp->count() : 0;
        } elseif ($status == 'own') {
            $posts = $request->user()->posts()->with('category', 'author')->latest()->paginate($this->limit);
            $postCount = ($tmp = $request->user()->posts()) ? $tmp->count() : 0;
        } else {
            $posts = Post::with('category', 'author')->latest()->paginate($this->limit);
            $postCount = Post::count();
        }

        $statusList = $this->statusList($request);

        return view("blog.index", compact('posts', 'postCount', 'onlyTrashed', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Post $post
     * @return Response
     */
    public function create(Post $post)
    {
        return view('blog.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return Response
     */
    public function store(PostRequest $request)
    {
        $data = $this->handleRequest($request);

        $newPost = $request->user()->posts()->create($data);
        $newPost->createTags($data['post_tags']);

        return redirect('blog')->with('success', 'Your post was created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('view_count');
        $postComments = $post->comments()->simplePaginate(2);

        return view('blog.show', compact('post', 'postComments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view("blog.edit", compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param int $id
     * @return Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $oldImage = $post->image;
        $data = $this->handleRequest($request);

        $post->update($data);
        $post->createTags($data['post_tags']);

        if ($oldImage !== $post->image) {
            if($oldImage !== 'default_post_image.jpg') {
                $this->removeImage($oldImage);
            }
        }

        return redirect('blog')->with('success', 'Your post was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect('blog')->with('trash-message', ['Your post moved to Trash', $id]);
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function forceDestroy($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        if($post->image !== 'default_post_image.jpg') {
            $this->removeImage($post->image);
        }

        return redirect('blog?status=trash')->with('message', 'Your post has been deleted successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->back()->with('success', 'You post has been moved from the Trash');
    }

    /**
     * @param $request
     * @return array
     */
    private function statusList($request)
    {
        return [
            'own' => ($tmp = $request->user()->posts()) ? $tmp->count() : 0,
            'all' => Post::count(),
            'published' => ($tmp = Post::published()) ? $tmp->count() : 0,
            'scheduled' => ($tmp = Post::scheduled()) ? $tmp->count() : 0,
            'draft' => ($tmp = Post::draft()) ? $tmp->count() : 0,
            'trash' => ($tmp = Post::onlyTrashed()) ? $tmp->count() : 0,
        ];
    }

    /**
     * @param $request
     * @return mixed
     */
    private function handleRequest($request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $destination = storage_path(config('cms.image.post_image_directory'));

            $successUploaded = Storage::putFileAs('public/post_images', new File($image), $fileName);

            if ($successUploaded) {
                $width = config('cms.image.thumbnail.width');
                $height = config('cms.image.thumbnail.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . $fileName)->resize($width, $height)->save($destination . $thumbnail);
            }

            $data['image'] = $fileName;
        }

        return $data;
    }

    /**
     * @param $image
     */
    private function removeImage($image)
    {
        if ( ! empty($image) ) {
            $destination = storage_path(config('cms.image.post_image_directory'));
            $imagePath = $destination . $image;
            $ext = substr(strrchr($image, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $destination . $thumbnail;

            if ( file_exists($imagePath) ) unlink($imagePath);
            if ( file_exists($thumbnailPath) ) unlink($thumbnailPath);
        }
    }
}
