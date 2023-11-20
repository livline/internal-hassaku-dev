<?php
/**
 * レポートログ出力クラス
 * 履歴系等ファイルに書き出し、バッチ処理でDBに取り込むログを生成する
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class HSK_report_log
{
	public $fp;
	public $log_root_dir;
	private $exception;
	private $rotate;

	public function __construct( $rotate = 1, $exception = FALSE, $log_root_dir = '../report/' )
    {
		// ログファイルローテション時間
		$this->rotate = $rotate;
		// エラー時の挙動
		$this->exception = $exception;
		// ログディレクトリ
		$this->log_root_dir = $log_root_dir;
		// ログファイルをオープン
		$this->fp = $this->report_log_open( $log_root_dir );
		// ファイルロック
		flock( $this->fp, LOCK_EX );
	}

	// ログファイルにcsv形式で書き込む
	public function output( $rep_array )
	{
		if( !is_array( $rep_array ) )
		{
			if( $this->exception )
			{
				throw new Exception( 'Invalid argument 1 for output()' );
			}
			else
			{
				return FALSE;
			}
		}

		fputcsv( $this->fp, $rep_array );

		return TRUE;
	}

	// レポートログを明示的にクローズさせる（基本的に必要がなくなった時点でクローズさせた方が良い）
	public function close()
	{
		fflush( $this->fp );
		flock( $this->fp, LOCK_UN );
		fclose( $this->fp );
		unset( $this->fp );

		return TRUE;
	}

	// ログファイルをオープン
	private function report_log_open()
	{
		$nowtime = time();
		$log_dir = date( 'Ym', $nowtime );
		$log_file = date( 'Ymd', $nowtime )."_".$this->get_time_no( $this->rotate, NULL, $nowtime ).".csv";

		if( !is_dir( $this->log_root_dir.$log_dir ) )
		{
			if( !mkdir( $this->log_root_dir.$log_dir, 0777 ) )
			{
				if( $this->exception )
				{
					throw new Exception( 'Unable to create directory. DIR='.$this->log_root_dir.$log_dir );
				}
				else
				{
					return FALSE;
				}
			}
		}

		$fp = fopen( $this->log_root_dir.$log_dir.'/'.$log_file, 'a' );
		if( !$fp )
		{
			if( $this->exception )
			{
				throw new Exception( 'File can not open. FILE='.$this->log_root_dir.$log_dir.'/'.$log_file );
			}
			else
			{
				return FALSE;
			}
		}

		return $fp;
	}

	// 24時間をrotate毎に分割し、0から番号を振る
	static function get_time_no( $rotate = 3, $hour = NULL, $base_time = NULL )
	{
		if( $base_time == NULL )
		{
			$base_time = time();
		}

	    if( $hour == NULL )
	    {
	        $hour = date( 'G', $base_time );
	    }

	    $no = ( int )( $hour / $rotate );
		return $no;
	}

	// マイクロ秒付きで現時刻を取得 YYYY-MM-DD HH:NN:SS.FFFFFF
	static function micro_datetime()
	{
		$mt = microtime( true );
		$micro = sprintf( '%06d', ( $mt - floor( $mt ) ) * 1000000 ) ;
		$date = date_create_from_format( 'Y-m-d H:i:s.u', date( 'Y-m-d H:i:s', $mt ).'.'.$micro );

	return $date->format( 'Y-m-d H:i:s.u' );
	}
}
