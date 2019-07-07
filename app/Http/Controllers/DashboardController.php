<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $ownPosts = Auth::user()->posts()->count();
        $allPosts = Post::count();
        $published = Post::published()->count();
        $scheduled = Post::scheduled()->count();
        $draft = Post::draft()->count();
        $trash = Post::onlyTrashed()->count();

        $allCategories = Category::count();

        $allUsers = User::count();
        $admin = User::whereHas('roles', function($q) { $q->where('name' , 'admin');})->count();
        $author = User::whereHas('roles', function($q) { $q->where('name' , 'author');})->count();
        $editor = User::whereHas('roles', function($q) { $q->where('name' , 'editor');})->count();
        $users = User::whereHas('roles', function($q) { $q->where('name' , 'user');})->count();


        return view('dashboard.index', compact(
            'ownPosts', 'allPosts', 'published', 'scheduled', 'draft', 'trash',
            'allCategories', 'allUsers', 'admin', 'author', 'editor', 'users'));
    }
}
