<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesController extends Controller
{
    public function list(Request $request) {
        return $this->usualServe( 'Articles\ArticleListService', $request, \App\Http\Resources\ArticleCollection::class );
    }

    public function create(Request $request) {
        return $this->usualServe( 'Articles\ArticleCreateService', $request, \App\Http\Resources\Article::class );
    }

    public function get(Request $request) {
        return $this->usualServe( 'Articles\ArticleGetService', $request, \App\Http\Resources\Article::class );
    }

    public function update(Request $request) {
        return $this->usualServe( 'Articles\ArticleUpdateService', $request, \App\Http\Resources\Article::class );
    }

    public function delete(Request $request) {
        return $this->usualServe( 'Articles\ArticleDeleteService', $request );
    }
}
