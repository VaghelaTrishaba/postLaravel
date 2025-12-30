<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

    class pageController extends Controller
    {
        public function showLogin()
        {
            return  view("welcome");
        }
        public function showPost()
        {
            return view("totalview");
        }

        public function showAbout()
        {
            return view('about');
        }

        public function showHome()
        {
            return view('home');
        }

    }
?>
