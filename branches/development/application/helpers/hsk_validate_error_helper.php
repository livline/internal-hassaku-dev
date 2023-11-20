<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ----------------- 必須項目

	// === 入力系(input type=text,textarea)

		// 半角英数か
		define( 'HSK_RULE_REQ_alpha_num', [
											'required|alpha_numeric',
											[ 'required' => '入力してください', 'alpha_numeric' => '半角英数で入力してください' ]
										]);

		// 半角数字か
		define( 'HSK_RULE_REQ_num', [
										'required|numeric',
										[ 'required' => '入力してください', 'numeric' => '半角数字で入力してください' ]
									]);

		// 半角整数か
		define( 'HSK_RULE_REQ_int', [
										'required|integer',
										[ 'required' => '入力してください', 'integer' => '半角整数で入力してください' ]
									]);

		// 1以上の半角数字か
		define( 'HSK_RULE_REQ_int_over1', [
										'required|integer|greater_than_equal_to[1]',
										[ 'required' => '入力してください', 'integer' => '半角整数で入力してください', 'greater_than_equal_to' => '1以上の半角整数で入力してください' ]
									]);

		// 小数点付き数値か
		define( 'HSK_RULE_REQ_deci', [
											'required|decimal',
											[ 'required' => '入力してください','decimal' => '小数点を含む半角数字で入力してください' ]
										]);

		// 1.0以上の小数点付き数値か
		define( 'HSK_RULE_REQ_deci_over1_0', [
												'required|decimal|greater_than_equal_to[1]',
												[ 'required' => '入力してください','decimal' => '小数点を含む半角数字で入力してください', 'greater_than_equal_to' => '小数点を含む1.0以上の半角数字で入力してください' ]
											]);

		// 0.01以上の小数点付き数値か
		define( 'HSK_RULE_REQ_deci_over0_01', [
												'required|decimal|greater_than_equal_to[0.01]',
												[ 'required' => '入力してください','decimal' => '小数点を含む半角数字で入力してください', 'greater_than_equal_to' => '小数点を含む0.01以上の半角数字で入力してください' ]
											]);

		// 3桁の数字か
		define( 'HSK_RULE_REQ_3digits', [
											'required|numeric|exact_length[3]',
											[ 'required' => '入力してください','numeric' => '半角数字を入力してください', 'exact_length' => '半角数字3桁で入力してください' ]
										]);
		// 4桁の数字か
		define( 'HSK_RULE_REQ_4digits', [
											'required|numeric|exact_length[4]',
											[ 'required' => '入力してください','numeric' => '半角数字を入力してください', 'exact_length' => '半角数字4桁で入力してください' ]
										]);

		// 3桁以内の数字か
		define( 'HSK_RULE_REQ_3digits_low', [
												'required|numeric|max_length[3]',
												[ 'required' => '入力してください', 'numeric' => '半角数字を入力してください', 'max_length' => '半角数字3桁以内で入力してください' ]
											]);
		// 4桁以内の数字か
		define( 'HSK_RULE_REQ_4digits_low', [
												'required|numeric|max_length[4]',
												[ 'required' => '入力してください', 'numeric' => '半角数字を入力してください', 'max_length' => '半角数字4桁以内で入力してください' ]
											]);

		// 最大文字数10文字まで
		define( 'HSK_RULE_REQ_maxlen10', [
											'required|max_length[10]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数20文字まで
		define( 'HSK_RULE_REQ_maxlen20', [
											'required|max_length[20]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数30文字まで
		define( 'HSK_RULE_REQ_maxlen30', [
											'required|max_length[30]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数40文字まで
		define( 'HSK_RULE_REQ_maxlen40', [
											'required|max_length[40]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数50文字まで
		define( 'HSK_RULE_REQ_maxlen50', [
											'required|max_length[50]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数100文字まで
		define( 'HSK_RULE_REQ_maxlen100', [
											'required|max_length[100]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数100文字まで
		define( 'HSK_RULE_REQ_maxlen200', [
											'required|max_length[200]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);
		// 最大文字数255文字まで
		define( 'HSK_RULE_REQ_maxlen255', [
											'required|max_length[255]',
											[ 'required' => '入力してください', 'max_length' => '文字数が超過しています' ]
										]);

		// メールアドレスが入力されてるか
		define( 'HSK_RULE_REQ_mailaddress', [
												'required|max_length[255]|valid_email',
												[ 'required' => '入力してください','max_length' => '文字数が超過しています', 'valid_email' => 'メールアドレスとして適切ではありません' ]
											]);

		// 日付のフォーマットチェック(YYYY-MM-DD)
		define( 'HSK_RULE_REQ_date_hyphen', [
												'required|regex_match[/^(\d\d\d\d)\-(\d\d)\-(\d\d)$/]',
												[ 'required' => '入力してください','regex_match' => 'パラメータが不正です' ]
											]);
		// 日付のフォーマットチェック(YYYY/MM/DD)
		define( 'HSK_RULE_REQ_date_slash', [
												'required|regex_match[/^(\d\d\d\d)\/(\d\d)\/(\d\d)$/]',
												[ 'required' => '入力してください','regex_match' => 'パラメータが不正です' ]
											]);

		// 時刻のフォーマットチェック(HH:MM:SS)
		define( 'HSK_RULE_REQ_time_hms', [
											'required|regex_match[/^(\d\d):(\d\d):(\d\d)$/]',
											[ 'required' => '入力してください','regex_match' => 'パラメータが不正です' ]
										]);
		// 時刻のフォーマットチェック(HH:MM)
		define( 'HSK_RULE_REQ_time_hm', [
											'required|regex_match[/^(\d\d):(\d\d)$/]',
											[ 'required' => '入力してください','regex_match' => 'パラメータが不正です' ]
										]);


	// === セレクトボックス・チェックボックス

		// 1以上の整数か(value="0"は未選択判定したい場合)
		define( 'HSK_RULE_REQ_over1', [
										'required|greater_than_equal_to[1]',
										[ 'required' => '選択してください', 'greater_than_equal_to' => '選択してください' ]
									]);

		// 何かしら選択されてるか(value=""は未選択判定したい場合))
		define( 'HSK_RULE_REQ_notempty', [
											'required',
											 [ 'required' => '選択してください' ]
										]);


// ----------------- 任意項目

	// 半角英数か
	define( 'HSK_RULE_alpha_num', [
										'alpha_numeric',
										[ 'alpha_numeric' => '半角英数で入力してください' ]
									]);

	// 半角数字か
	define( 'HSK_RULE_int', [
									'integer',
									[ 'integer' => '半角整数で入力してください' ]
								]);

	// 1以上の半角数字か
	define( 'HSK_RULE_int_over1', [
									'integer|greater_than_equal_to[1]',
									[ 'integer' => '半角整数で入力してください', 'greater_than_equal_to' => '1以上の半角整数で入力してください' ]
								]);

	// 小数点付き数値か
	define( 'HSK_RULE_deci', [
								'decimal',
								[ 'decimal' => '小数点を含む半角数字で入力してください' ]
							]);

	// 1.0以上の小数点付き数値か
	define( 'HSK_RULE_deci_over1_0', [
											'decimal|greater_than_equal_to[1]',
											[ 'decimal' => '小数点を含む半角数字で入力してください', 'greater_than_equal_to' => '小数点を含む1.0以上の半角数字で入力してください' ]
										]);

	// 0.01以上の小数点付き数値か
	define( 'HSK_RULE_deci_over0_01', [
											'decimal|greater_than_equal_to[0.01]',
											[ 'decimal' => '小数点を含む半角数字で入力してください', 'greater_than_equal_to' => '小数点を含む0.01以上の半角数字で入力してください' ]
										]);

	// 3桁の数字か
	define( 'HSK_RULE_3digits', [
										'numeric|exact_length[3]',
										[ 'numeric' => '半角数字を入力してください', 'exact_length' => '半角数字3桁で入力してください' ]
									]);
	// 4桁の数字か
	define( 'HSK_RULE_4digits', [
										'numeric|exact_length[4]',
										[ 'numeric' => '半角数字を入力してください', 'exact_length' => '半角数字4桁で入力してください' ]
									]);

	// 3桁以内の数字か
	define( 'HSK_RULE_3digits_low', [
											'numeric|max_length[3]',
											[ 'numeric' => '半角数字を入力してください', 'max_length' => '半角数字3桁以内で入力してください' ]
										]);
	// 4桁以内の数字か
	define( 'HSK_RULE_4digits_low', [
											'numeric|max_length[4]',
											[ 'numeric' => '半角数字を入力してください', 'max_length' => '半角数字4桁以内で入力してください' ]
										]);

	// 最大文字数10文字まで
	define( 'HSK_RULE_maxlen10', [
										'max_length[10]',
										[ 'max_length' => '文字数が超過しています' ]
									]);
	// 最大文字数20文字まで
	define( 'HSK_RULE_maxlen20', [
										'max_length[20]',
										[ 'max_length' => '文字数が超過しています' ]
									]);
	// 最大文字数30文字まで
	define( 'HSK_RULE_maxlen30', [
										'max_length[30]',
										[ 'max_length' => '文字数が超過しています' ]
									]);
	// 最大文字数40文字まで
	define( 'HSK_RULE_maxlen40', [
										'max_length[40]',
										[ 'max_length' => '文字数が超過しています' ]
									]);
	// 最大文字数255文字まで
	define( 'HSK_RULE_maxlen255', [
										'max_length[255]',
										[ 'max_length' => '文字数が超過しています' ]
									]);

	// メールアドレスが入力されてるか
	define( 'HSK_RULE_mailaddress', [
											'max_length[255]|valid_email',
											[ 'max_length' => '文字数が超過しています', 'valid_email' => 'メールアドレスとして適切ではありません' ]
										]);

	// 日付のフォーマットチェック(YYYY-MM-DD)
	define( 'HSK_RULE_date_hyphen', [
											'regex_match[/^(\d\d\d\d)\-(\d\d)\-(\d\d)$/]',
											[ 'regex_match' => 'パラメータが不正です' ]
										]);
	// 日付のフォーマットチェック(YYYY/MM/DD)
	define( 'HSK_RULE_date_slash', [
											'regex_match[/^(\d\d\d\d)\/(\d\d)\/(\d\d)$/]',
											[ 'regex_match' => 'パラメータが不正です' ]
									]);

	// 時刻のフォーマットチェック(HH:MM:SS)
	define( 'HSK_RULE_time_hms', [
										'regex_match[/^(\d\d):(\d\d):(\d\d)$/]',
										[ 'regex_match' => 'パラメータが不正です' ]
									]);

	// 時刻のフォーマットチェック(HH:MM)
	define( 'HSK_RULE_time_hm', [
										'regex_match[/^(\d\d):(\d\d)$/]',
										[ 'regex_match' => 'パラメータが不正です' ]
									]);






