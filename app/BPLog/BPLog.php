<?php

namespace App\BPLog;

use Log;
use Monolog\Logger;

class BPLog
{
	const APP_DIR = DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR;

    private $logLevel = Logger::INFO;
    private $uniqId;

    public function __construct() {
        $this->uniqId = getmypid() . uniqid();
    }

    /**
     * ログレベル設定
     */
    public function setLogLevel($logLevelStr){
        $levels = [
            'debug'     => Logger::DEBUG,
            'info'      => Logger::INFO,
            'notice'    => Logger::NOTICE,
            'warning'   => Logger::WARNING,
            'error'     => Logger::ERROR,
            'critical'  => Logger::CRITICAL,
            'alert'     => Logger::ALERT,
            'emergency' => Logger::EMERGENCY,
        ];

        // ログレベル文字列からログレベル値へ変換
        if( array_key_exists($logLevelStr, $levels) ){
            $this->logLevel = $levels[$logLevelStr];
        }
    }

    public function debug( $str ) {
        // デバッグでは呼び出し元の取得を行うコストがあるので、ここでログレベルをチェックする
        if ( $this->logLevel > Logger::DEBUG ) { return; }

        $str = $this->convertToString($str);
        $caller = $this->getCaller();

        Log::debug( $this->commonString() . "[FILE:${caller['file']} LINE:${caller['line']} ${str}" );
    }

    public function info( $str ) {
        $str = $this->convertToString( $str );
        Log::info( $this->commonString() . $str );
    }

    public function notice( $str ){
        $str = $this->convertToString( $str );
        Log::notice( $this->commonString() .$str );
    }

    public function iStart() {
        $caller = $this->getCallerFunction();
        Log::info( $this->commonString() . "${caller['class']} ${caller['func']}() start." );
    }

    public function iEnd() {
        $caller = $this->getCallerFunction();
        Log::info( $this->commonString() . "${caller['class']} ${caller['func']}() end." );
    }

    public function warning( $str ){
        $str = $this->convertToString( $str );
        Log::warning( $this->commonString() .$str );
    }

    public function error( $str ){
        $str = $this->convertToString( $str );
        Log::error( $this->commonString() .$str );
    }

    public function critical( $str ){
        $str = $this->convertToString( $str );
        Log::critical( $this->commonString() .$str );
    }

    public function fatal( $str ){
        $str = $this->convertToString( $str );
        Log::error( $this->commonString() ."[Fatal]".$str );
    }

    private function convertToString( $any ) {
        if ( gettype( $any ) === 'array' ) {
            return print_r( $any, true );
        } else if ( gettype( $any ) === 'object' ) {
            return json_encode( $any );
        } else {
            return $any;
        }
    }

    private function commonString() {
        $uniqId = $this->uniqId;
        return "[${uniqId}]";
    }

    private function getCaller() {
        $backtrace = debug_backtrace();

        // バックトレースから呼び出し元の情報が入ったLineを探す
        $foundLine = null;

        foreach( $backtrace as $line ) {
            if ( !array_key_exists('file', $line) ) continue; // ファイルを含まないものは無視する
            if ( strpos( $line['file'], self::APP_DIR ) !== FALSE ) { // アプリケーションディレクトリ外は無視
                if ( strpos( $line['class'], 'BPLog' ) !== FALSE ) continue;
                $foundLine = $line;
                break;
            }
        }

        if ( $foundLine ) {
            return [
                'file' => $foundLine['file'],
                'line' => $foundLine['line']
            ];
        }

        return [
            'file' => '',
            'line' => ''
        ];
    }

    /**
     * 呼び出し元関数を取得
     * @return array
     */
    private function getCallerFunction() {
        $backtrace = debug_backtrace();

        // バックトレースから呼び出し元の情報が入ったLineを探す
        try {
            // バックトレースの添字3がBPLogの呼び出し元
            $class = $backtrace[3]['class'];
            $func = $backtrace[3]['function'];
        } catch ( \Exception $e ) {
            $class = '';
            $func = '';
        }

        return [
            'class' => $class,
            'func' => $func
        ];
    }
}