<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */ 
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= '※{field}を入力してください。';
$lang['form_validation_isset']			= '※{field}に値を入力してください。';
$lang['form_validation_valid_email']	= '※{field}が正しくありません。';
$lang['form_validation_valid_emails']	= '※正しく{field}を入力してください。';
$lang['form_validation_valid_url']		= '※{field}に正しいURLを入力してください。';
$lang['form_validation_valid_ip']		= '※{field}に正しいURLを入力してください。';
$lang['form_validation_min_length']		= '※{field}に英数字{param}文字以上で入力してください。';
$lang['form_validation_max_length']		= '※{field}に半角英字{param}文字以内で入力してください。';
$lang['form_validation_exact_length']	= '※{field}に{param}桁の数字のみを入力してください。';
$lang['form_validation_alpha']			= '※{field}に半角英字と数字を混ぜて入力してください。';
$lang['form_validation_alpha_numeric']	= '※{field}に半角英字のみを入力してください。';
$lang['form_validation_alpha_numeric_spaces']	= '※{field}に半角英字及びスペースのみを入力してください。';
$lang['form_validation_alpha_dash']		= '※{field}に半角英字、数字、下線、正中線を混ぜて入力してください。';
$lang['form_validation_numeric']		= '※{field}に英数字のみを入力してください。';
$lang['form_validation_is_numeric']		= '※{field}に数字のみを入力してください。';
$lang['form_validation_integer']		= '※{field}整数のみを入力してください。';
$lang['form_validation_regex_match']	= '※{field}が正しくありません。';
$lang['form_validation_matches']		= '※{field}は{param}と一致していません';
$lang['form_validation_differs']		= '※{field}は{param}と同じ値で入力しないでください。';
$lang['form_validation_is_unique'] 		= '※{field}に一意の値を入力してください。';
$lang['form_validation_is_natural']		= '※{field}に数字のみを入力してください。';
$lang['form_validation_is_natural_no_zero']	= '※{field}に0より大きい数値のみを入力してください。';
$lang['form_validation_decimal']		= '※{field}小数を入力してください。';
$lang['form_validation_less_than']		= '※{field}に{param}文字以内で入力してください。';
$lang['form_validation_less_than_equal_to']	= '※{field}に{param}文字以内で入力してください。';
$lang['form_validation_greater_than']		= '※{field}には{param}英数字より大きい数値を入力してください。';
$lang['form_validation_greater_than_equal_to']	= '※{field}に{param}文字以上の英数字を入力してください。';
$lang['form_validation_error_message_not_set']	= '※{field}に不明なエラーが発生されてしまいます。';
$lang['form_validation_in_list']		= '※{field}は{param}のいずれかの値で入力してください。';
$lang['form_validation_postal']		= '※{field}は[NNN-NNNN]フォーマットで入力してください。';
$lang['form_validation_phone']		= '※{field}は[NNN-NNNN-NNNN]フォーマットで入力してください。。';


// Message validation for jquery

$lang['jquery_validation_required']	= '必須です。ご入力ください。';
$lang['jquery_validation_remote']	= 'このフィールドは既存しました。';
$lang['jquery_validation_email']	= 'メールアドレスを入力してください。';
$lang['jquery_validation_phone']	= '電話番号は正しくありません。';
$lang['jquery_validation_url']	= 'URLを入力してください。';
$lang['jquery_validation_date']	= '日付を入力してください。';
$lang['jquery_validation_dateISO']	= ' (ISO)日を入力してください。';
$lang['jquery_validation_number']	= '数字を入力してください。';
$lang['jquery_validation_digits']	= '数値を入力してください。';
$lang['jquery_validation_creditcard']	= 'クレジットカード番号を入力してください。';
$lang['jquery_validation_equalTo']	= '再度入力してください。';
$lang['jquery_validation_extension']	= '有効な拡張子の値を入力してください。';
$lang['jquery_validation_maxlength']	= '{0}文字以内を入力してください。';
$lang['jquery_validation_minlength']	= '{0}文字以上を入力してください。';
$lang['jquery_validation_rangelength']	= '{0}文字から{1}文字までを入力してください。';
$lang['jquery_validation_range']	= '{0}数字から{1}数字までを入力してください。';
$lang['jquery_validation_max']	= '{0}数字以下を入力してください。';
$lang['jquery_validation_min']	= '{0}数字以上を入力してください。';
$lang['jquery_validation_invalid']	= '入力した情報は正しくありません。';
$lang['jquery_validation_postal']	= '郵便番号はは正しくありません。';

