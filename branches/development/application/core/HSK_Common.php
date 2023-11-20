<?php
/**
 * ユーザー定義共通関数
 *
 * ここで定義された関数は、view,modelなどアプリケーション内のどこからでも実行することが可能
 *
 */


	/**
	 * 指定された文字列を、base64エンコードし更にURLで使用できるようにエンコードする
	 *
	 * @param int $str		エンコードする文字列
	 * @return string
	 */
	function urlsafe_base64_encode( $str )
	{
		return str_replace(array('+', '/', '='), array('_', '-', '.'), base64_encode( $str ) );
	}

	/**
	 * urlsafe_base64_encode()でエンコードされた文字列を元の文字列に戻す
	 *
	 * @param int $str		urlsafe_base64_encode文字列
	 * @return string
	 */
	function urlsafe_base64_decode( $str )
	{
		return base64_decode( str_replace(array('_','-', '.'), array('+', '/', '='), $str ) );
	}

	/**
	 * ポイントの表示時のフォーマット共通化
	 *
	 * @param int $point		ポイント数
	 * @return string
	 */
	function point_fmt( $point )
	{
		$unit = ' pt';
		if( $point >= 2 )
		{
			$unit = ' pts';
		}

		return number_format( $point ).$unit;
	}

