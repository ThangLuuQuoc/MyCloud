<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Flag;
use App\Http\Controllers\Controller;
use App\Media;
use App\Page;
use App\Setting;
use App\User;
use View;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        View::share('menu', 'dashboard');
    }

    public function index()
    {
        $version = '1.4.0';

        $users = User::count();
        $categories = Category::count();
        $media = Media::count();
        $comments = Comment::count();
        $pages = Page::count();
        $flags = Flag::count();

        $ffmpeg = command_exist('ffmpeg --help');
        $handbrake = command_exist('HandBrakeCLI --help');
        $youtube_dl = command_exist('youtube-dl --help');
        $gdrive = command_exist('gdrive help');

        $shell_exec = isEnabled('shell_exec');
        $exec = isEnabled('exec');

        $attributes = json_decode(Setting::where('name', 'media')->value('attributes'));

        return view('admin.dashboard', compact('version', 'users', 'categories', 'media', 'comments', 'pages', 'flags', 'ffmpeg', 'handbrake', 'youtube_dl', 'gdrive', 'attributes', 'shell_exec', 'exec'));
    }
}
