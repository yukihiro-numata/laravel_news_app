<?php

namespace App\Services\Articles;

use Validator;
use ErrorMaker;
use App\ErrorMaker\ApiErrorCode;
use App\Services\Service;
use App\Services\HttpRequestConverter;
use App\Models\Article;
use BPLog;

class ArticleUpdateRequestDto
{
    public $articleId;
    public $title;
    public $body;

    public function __construct(
        $articleId,
        $title,
        $body
    ) {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->body = $body;
    }
}

class ArticleUpdateService extends Service implements HttpRequestConverter
{
    public function requestConvert( $request ) {
        // 形式バリデーション
        $validator = Validator::make(
            $request->all() + ['article_id' => $request->route('article_id')],
            [
                'article_id' => 'required',
                'title' => 'required | string',
                'body' => 'required | string'
            ]
        );

        if ( $validator->fails() ) {
            BPLog::notice( 'article update invalid request parameter.' . $this->validatorToErrorString( $validator ) );
            ErrorMaker::occurApiError( ApiErrorCode::COMMON['INVALID_REQUEST_PARAMETER'] );
        }

        return new ArticleUpdateRequestDto(
            $request->route('article_id'),
            $request->input('title'),
            $request->input('body')
        );
    }

    public function serve( $requestDto ) {
        BPLog::iStart();
        $article = Article::find( $requestDto->articleId );
        $article->title = $requestDto->title;
        $article->body = $requestDto->body;
        $article->save();
        BPLog::iEnd();
        return $article;
    }
}