<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HSK_csv
{

	public $file_id = '';
	public $csv = [];

	/**
	 * ファイルID付きcsvファイルを読み込み配列に格納し、ファイルIDを取得する。
	 *
	 * #から始まる行は無視。#から始まるカラム以右のカラムは無視。
	 *
	 * @param string $csv_file        csvファイルパス
	 * @param boolean $encoding	     Sjis-winからUTF8へ変換するか
	 * @param string $id_line_mark    ファイルIDがある行の1列目文字列
	 * @return array                 csv配列
	 */
	public function read_csv_wiz_id( $csv_file, $encoding = TRUE, $id_line_mark = 'csv_file_id' )
	{
		$_csv = [];
		$_file_id = '';

		if( $encoding )
		{
			stream_filter_register(
				'sjis_to_utf8_encoding_filter',
				SjisToUtf8EncodingFilter::class
			);
		}

		$fp = fopen( $csv_file, 'r' );
		if( $fp === FALSE )
		{
			return FALSE;
		}

		if( $encoding )
		{
			stream_filter_append($fp, 'sjis_to_utf8_encoding_filter');
		}

		while( $line = fgetcsv( $fp, 1024 ) )
		{
			// 行の先頭が#、または空行はスキップ
			if( substr( $line[ 0 ], 0, 1 ) == '#' || strlen( $line[ 0 ] ) == 0 )
			{
				continue;
			}

			// 一列目がファイルID記述行の目印だった場合、二列目のファイルIDを取得
			if( $line[ 0 ] == $id_line_mark )
			{
				$_file_id = trim( $line[ 1 ] );
			continue;
			}

			$new_line = array( $line[ 0 ] );
			$cnt = count( $line );
			for( $i = 1; $i <= ( $cnt - 1 ); ++$i )
			{
				// #から始まる列がある場合、次の行へ進む
				if( substr( $line[ $i ], 0, 1 ) == '#' )
				{
					break;
				}

				$new_line[] = $line[ $i ];
			}

			$_csv[] = $new_line;
		}
		fclose( $fp );

		// ファイルIDがない
		if( $_file_id == '' )
		{
			return FALSE;
		}

		$this->file_id = $_file_id;
		$this->csv = $_csv;

	return TRUE;
	}


	/**
	 * csvファイルを読み込み配列に格納する。
	 *
	 * #から始まる行は無視。#から始まるカラム以右のカラムは無視。
	 *
	 * @param string $csv_file        csvファイルパス
	 * @param boolean $encoding	     Sjis-winからUTF8へ変換するか
	 * @return array                 csv配列
	 */
	function read_csv( $csv_file, $encoding = TRUE )
	{
		$_csv = [];

		if( $encoding )
		{
			stream_filter_register(
				'sjis_to_utf8_encoding_filter',
				SjisToUtf8EncodingFilter::class
			);
		}

		$fp = fopen( $csv_file, 'r' );
		if( $fp === FALSE )
		{
			return FALSE;
		}

		if( $encoding )
		{
			stream_filter_append($fp, 'sjis_to_utf8_encoding_filter');
		}

		while( $line = fgetcsv( $fp, 1024 ) )
		{
			// 行の先頭が#、または空行はスキップ
			if( substr( $line[ 0 ], 0, 1 ) == '#' || strlen( $line[ 0 ] ) == 0 )
			{
				continue;
			}

			$new_line = array( $line[ 0 ] );
			$cnt = count( $line );
			for( $i = 1; $i <= ( $cnt - 1 ); ++$i )
			{
				// #から始まる列がある場合、次の行へ進む
				if( substr( $line[ $i ], 0, 1 ) == '#' )
				{
					break;
				}

				$new_line[] = $line[ $i ];
			}

			$_csv[] = $new_line;
		}
		fclose( $fp );

		$this->csv = $_csv;

	return TRUE;
	}

	/**
	 * 連想配列をcsvファイルに出力し、ダウンロードさせる。
	 *
	 * @param array  $content   連想配列
	 * @param array  $structure 連想配列データ構造定義
	 * @param string $file_name 出力csvファイル名
	 *
	 * e.g. $structure
	 * $contentに渡した連想配列のキーに対する項目名称を定義。出力するcsvファイルのヘッダー行に使用。
	 * $structure = [
	 * 	'user_id'    => 'ユーザーID',
	 * 	'address'    => '住所',
	 * 	'tel'        => '電話番号',
	 * ];
	 *
	 * @return void
	 */
	function output_csv( $content, $structure, $file_name )
	{
		// 出力するカラム
		$columns = array_keys( $structure );

		// CSVヘッダー行のエンコードをSJIS-winに変換
		$header = array_values( $structure );
		$res = mb_convert_variables( 'SJIS-win', 'UTF-8', $header );
		if ( $res === FALSE )
		{
			return FALSE;
		}

		// テンポラリストリーム作成
		$file = new SplTempFileObject();

		// CSVヘッダー書き込み
		$file->fputcsv( $header );

		// 内容行のエンコードをSJIS-winに変換
		foreach( $content as $row )
		{
			// 項目抽出
			$selected_row = [];
			foreach( $columns as $column )
			{
				$selected_row[] = $row[ $column ];
			}

			// エンコード
			$res = mb_convert_variables( 'SJIS-win', 'UTF-8', $selected_row );
			if ( $res === FALSE )
			{
				return FALSE;
			}

			// CSVボディ書き込み
			$file->fputcsv( $selected_row );
		}

		// ダウンロード用にHTTPレスポンスのヘッダー書き込み
		header( 'Pragma: public' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Cache-Control: private', FALSE );
		header( 'Content-Type: application/force-download' );
		header( 'Content-Disposition: attachment; filename='.basename( $file_name ).';' );

		//ファイルポインタを先頭へ戻す
		$file->rewind();

		// CSVファイルをBODYに書き込み
		foreach( $file as $line )
		{
			
			echo preg_replace( '/(\r\n|\r|\n)$/', "\r\n", $line );
		}
	}
}

// Sjis-winからUTF8へ変換するストリームフィルタクラス
final class SjisToUtf8EncodingFilter extends \php_user_filter
{
	/**
	 * Buffer size limit (bytes)
	 *
	 * @var int
	 */
	private static $bufferSizeLimit = 1024;

	/**
	 * @var string
	 */
	private $buffer = '';

	public static function setBufferSizeLimit(int $bufferSizeLimit): void
	{
		self::$bufferSizeLimit = $bufferSizeLimit;
	}

	/**
	 * @param resource $in
	 * @param resource $out
	 * @param int $consumed
	 * @param bool $closing
	 */
	public function filter($in, $out, &$consumed, $closing): int
	{
		$isBucketAppended = false;
		$previousData = $this->buffer;
		$deferredData = '';

		while ($bucket = \stream_bucket_make_writeable($in)) {
			$data = $previousData . $bucket->data; // 前回後回しにしたデータと今回のチャンクデータを繋げる
			$consumed += $bucket->datalen;

			// 受け取ったチャンクデータの最後から1文字ずつ削っていって、SJIS的に区切れがいいところまでデータを減らす
			while ($this->needsToNarrowEncodingDataScope($data)) {
				$deferredData = \substr($data, -1) . $deferredData; // 削ったデータは後回しデータに付け加える
				$data = \substr($data, 0, -1);
			}

			if ($data) { // ここに来た段階で $data は区切りが良いSJIS文字列になっている
				$bucket->data = $this->encode($data);
				\stream_bucket_append($out, $bucket);
				$isBucketAppended = true;
			}
		}

		$this->buffer = $deferredData; // 後回しデータ: チャンクデータの句切れが悪くエンコードできなかった残りを次回の処理に回す
		$this->assertBufferSizeIsSmallEnough(); // メモリ不足回避策: バッファを使いすぎてないことを保証する
		return $isBucketAppended ? \PSFS_PASS_ON : \PSFS_FEED_ME;
	}

	private function needsToNarrowEncodingDataScope(string $string): bool
	{
		return !($string === '' || $this->isValidEncoding($string));
	}

	private function isValidEncoding(string $string): bool
	{
		return \mb_check_encoding($string, 'SJIS-win');
	}

	private function encode(string $string): string
	{
		return \mb_convert_encoding($string, 'UTF-8', 'SJIS-win');
	}

	private function assertBufferSizeIsSmallEnough(): void
	{
		\assert(
			\strlen($this->buffer) <= self::$bufferSizeLimit,
			\sprintf(
				'Streaming buffer size must less than or equal to %u bytes, but %u bytes allocated',
				self::$bufferSizeLimit,
				\strlen($this->buffer)
			)
		);
	}
}
