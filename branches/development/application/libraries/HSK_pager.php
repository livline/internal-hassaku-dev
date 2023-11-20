<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ページングクラス
 *
 */
class HSK_pager
{
	/**
	 * DBから取得する際のオフセット値を算出
	 *
	 * @param int $now_page		現在のページ
	 * @param int $pagemax		1ページ中の表示件数
	 * @return int				オフセット値
	 */
	public function get_offset( $now_page, $pagemax )
	{
		if( $now_page )
		{
			$offset = ( $now_page - 1) * $pagemax;
		}
		else
		{
			$offset = 0;
		}

	return $offset;
	}

	/**
	 * 総ページ数を算出
	 *
	 * @param int $pagemax		1ページ中の表示件数
	 * @param int $all_count	全データ件数
	 * @return int				総ページ数
	 */
	public function get_pagecount( $pagemax, $all_count )
	{
		$_pagecnt = $all_count / $pagemax;


		$pagecnt = ceil( $_pagecnt );

	return ( int )$pagecnt;
	}

	/**
	 * 何件目から何件目を表示しているのか取得
	 *
	 * @param int $now_page		現在のページ
	 * @param int $pagemax		1ページ中の表示件数
	 * @param int $all_count	全データ件数
	 * @return array			[ n件目から, n件目まで ]
	 */
	public function get_itemcount( $now_page, $pagemax, $all_count )
	{
		$start = $now_page * $pagemax - $pagemax + 1;

		$end = $start + $pagemax - 1;
		if( $end > $all_count )
		{
			$end = $all_count;
		}

	return [ $start, $end ];
	}

	/**
	 * View用ページネーション配列を組み立てる
	 *
	 * @param int $now_page		現在のページ
	 * @param int $pagecnt		総ページ数
	 * @return array			View用ページネーション配列
	 */
	public function make_paging_array( $now_page, $pagecnt )
	{
		$paging_array = [];
		if( $pagecnt == 0 || $pagecnt == 1 )
		{
			return $paging_array;
		}
		$paging_array[ 0 ][ 'link' ] = ($now_page == 1)?FALSE:($now_page - 1);
		$paging_array[ 0 ][ 'label' ] = "<<";
		$paging_array[ 0 ][ 'current' ] = FALSE;

		if( $pagecnt >= 7 )
		{
			if( $now_page >= 3 )
			{
				$x=1;
				if( $now_page >= 4 )
				{
					$paging_array[ $x ][ 'link' ] = 1;
					$paging_array[ $x ][ 'label' ] = 1;
					$paging_array[ $x ][ 'current' ] = ($now_page == 1)?TRUE:FALSE;
					++$x;
				}
				if( $now_page >= 5 )
				{
					$paging_array[ $x ][ 'link' ] = FALSE;
					$paging_array[ $x ][ 'label' ] = "...";
					$paging_array[ $x ][ 'current' ] = FALSE;
					++$x;
				}
				if( $now_page >= ( $pagecnt - 1 ) )
				{
					$n = $pagecnt - $now_page;
					for( $i = $now_page - 4 + $n; $i <= $pagecnt; ++$i )
					{
						if( $now_page == $i )
						{
							$paging_array[ $x ][ 'link' ] = FALSE;
							$paging_array[ $x ][ 'current' ] = TRUE;
						}
						else
						{
							$paging_array[ $x ][ 'link' ] = $i;
							$paging_array[ $x ][ 'current' ] = FALSE;
						}
						$paging_array[ $x ][ 'label' ] = $i;
					++$x;
					}
					
				}
				else
				{
					for( $i = $now_page - 2; $i < $now_page + 3; ++$i )
					{
						if( $i <= ( $pagecnt ) )
						{
							if( $now_page == $i )
							{
								$paging_array[ $x ][ 'link' ] = FALSE;
								$paging_array[ $x ][ 'current' ] = TRUE;
							}
							else
							{
								$paging_array[ $x ][ 'link' ] = $i;
								$paging_array[ $x ][ 'current' ] = FALSE;
							}
							$paging_array[ $x ][ 'label' ] = $i;
						}
					++$x;
					}
				}
			}
			else
			{
				$x = 1;
				for( $i = 1; $i <= 5; ++$i )
				{
					if( $now_page == $i )
					{
						$paging_array[ $x ][ 'link' ] = FALSE;
						$paging_array[ $x ][ 'current' ] = TRUE;
					}
					else
					{
						$paging_array[ $x ][ 'link' ] = $i;
						$paging_array[ $x ][ 'current' ] = FALSE;
					}
					$paging_array[ $x ][ 'label' ] = $i;
				++$x;
				}
			}
			if( $now_page <= ( $pagecnt - 4 ) )
			{
				$paging_array[ $x ][ 'link' ] = FALSE;
				$paging_array[ $x ][ 'label' ] = "...";
				$paging_array[ $x ][ 'current' ] = FALSE;
				++$x;
			}
			if( $now_page <= ( $pagecnt - 3 ) )
			{
				$paging_array[ $x ][ 'link' ] = $pagecnt;
				$paging_array[ $x ][ 'label' ] = $pagecnt;
				$paging_array[ $x ][ 'current' ] = FALSE;
			}
		}
		else
		{
			$x = 1;
			for( $i = 1; $i <= $pagecnt; ++$i )
			{
				if( $now_page == $i )
				{
					$paging_array[ $x ][ 'link' ] = FALSE;
					$paging_array[ $x ][ 'current' ] = TRUE;
				}
				else
				{
					$paging_array[ $x ][ 'link' ] = $i;
					$paging_array[ $x ][ 'current' ] = FALSE;
				}
				$paging_array[ $x ][ 'label' ] = $i;
			++$x;
			}
		}

		$paging_array[] = [ 'link' => ( $now_page == $pagecnt )?FALSE:( $now_page + 1 ), 'label' => ">>", 'current' => FALSE ];

	return $paging_array;
	}

}
