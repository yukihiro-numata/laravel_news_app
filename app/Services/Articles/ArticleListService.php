<?php

namespace App\Services\Articles;

use App\Services\Service;
use App\Services\HttpRequestConverter;
use App\Models\Article;
use BPLog;

class ArticleListRequestDto{}

class ArticleListService extends Service implements HttpRequestConverter
{
    public function requestConvert($request) {
        return new ArticleListRequestDto;
    }

    public function serve($requestDto) {
        BPLog::iStart();
        $articles = Article::all();
        BPLog::iEnd();
        return $articles;
    }
}