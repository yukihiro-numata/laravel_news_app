<?php

namespace App\Services\Articles;

use Validator;
use ErrorMaker;
use App\ErrorMaker\ApiErrorCode;
use App\Services\Service;
use App\Services\HttpRequestConverter;
use App\Models\Article;
use BPLog;

class ArticleDeleteRequestDto
{
    public $articleId;

    public function __construct( $articleId ) { $this->articleId = $articleId; }
}

class ArticleDeleteService extends Service implements HttpRequestConverter
{
    public function requestConvert( $request ) {
        // 形式バリデーション
        $validator = Validator::make(
            ['article_id' => $request->route('article_id')],
            ['article_id' => 'required']
        );

        if ( $validator->fails() ) {
            BPLog::notice( 'article delete invalid request parameter.' . $this->validatorToErrorString( $validator ) );
            ErrorMaker::occurApiError( ApiErrorCode::COMMON['INVALID_REQUEST_PARAMETER'] );
        }

        return new ArticleDeleteRequestDto( $request->route('article_id') );
    }

    public function serve( $requestDto ) {
        BPLog::iStart();
        $article = Article::find($requestDto->articleId);
        $article->delete();
        BPLog::iEnd();
    }
}