<?php

namespace App\Services\Articles;

use Validator;
use ErrorMaker;
use App\ErrorMaker\ApiErrorCode;
use App\Services\Service;
use App\Services\HttpRequestConverter;
use App\Models\Article;
use BPLog;

class ArticleCreateRequestDto
{
    public $title;
    public $body;

    public function __construct(
        $title,
        $body
    ) {
        $this->title = $title;
        $this->body = $body;
    }
}

class ArticleCreateService extends Service implements HttpRequestConverter
{
    public function requestConvert( $request ) {
        // 形式バリデーション
        $validator = Validator::make( $request->all(), [
            'title' => 'required | string',
            'body' => 'required | string'
        ]);

        if ( $validator->fails() ) {
            BPLog::notice( 'article create invalid request parameter.' . $this->validatorToErrorString( $validator ) );
            ErrorMaker::occurApiError( ApiErrorCode::COMMON['INVALID_REQUEST_PARAMETER'] );
        }

        return new ArticleCreateRequestDto(
            $request->input('title'),
            $request->input('body')
        );
    }

    public function serve( $requestDto ) {
        BPLog::iStart();
        $article = new Article;
        $article->title = $requestDto->title;
        $article->body = $requestDto->body;
        $article->save();
        BPLog::iEnd();
        return $article;
    }
}