<?php

namespace App\Services\Articles;

use Validator;
use ErrorMaker;
use App\ErrorMaker\ApiErrorCode;
use App\Services\Service;
use App\Services\HttpRequestConverter;
use App\Models\Article;
use BPLog;

class ArticleGetRequestDto
{
    public $articleId;

    public function __construct( $articleId ) { $this->articleId = $articleId; }
}

class ArticleGetService extends Service implements HttpRequestConverter
{
    public function requestConvert( $request ) {
        //形式バリデーション
        $validator = Validator::make(
            ['article_id' => $request->route('article_id')],
            ['article_id' => 'required']
        );

        if ( $validator->fails() ) {
            BPLog::notice( 'article get invalid request parameter.' . $this->validatorToErrorString( $validator ) );
            ErrorMaker::occurApiError( ApiErrorCode::COMMON['INVALID_REQUEST_PARAMETER'] );
        }

        return new ArticleGetRequestDto( $request->route('article_id') );
    }

    public function serve( $requestDto ) {
        BPLog::iStart();
        $article = Article::find( $requestDto->articleId );
        BPLog::iEnd();
        return $article;
    }
}