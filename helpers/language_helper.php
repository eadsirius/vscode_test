<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* =================================================================
* 다국어 메시지
================================================================= */

function get_lang($lang='us') 
{
    $rtnLang = null;
    
    if ($lang == 'us') 
    {
        $rtnLang = array(
            '계정 정보'	=> 'Account Info',
            '홈 / 계정 정보'	=> 'Home / Account Info'
        );
            
    } 
    else if ($lang == 'kr') 
    {
        $rtnLang = array(
            '로그인'			=> '로그인',
            '회원 가입'		=> '회원 가입',
            '회원가입'			=> '회원가입',
            '국가 선택'		=> '국가 선택',
            '추천인 ID'		=> '추천인 ID',
            '후원인 ID'		=> '후원인 ID',
            '회원 ID'			=> '회원 ID',
            '비밀번호 확인'		=> '비밀번호 확인',
            '비밀번호'			=> '비밀번호',
            '이름'			=> '이름',
            '휴대폰'			=> '휴대폰',
            '휴대폰번호'		=> '휴대폰번호',
            
            '비밀번호를 잊어버렸습니까?'	=> '비밀번호를 잊어버렸습니까?',
            '회원이 아닙니까?'			=> '회원이 아닙니까?',
            '회원이신가요?'				=> '회원이신가요?',
            '지금 가입하세요'			=> '지금 가입하세요',
            
            'SNS 보내기'			=> 'SNS 보내기',
            'SNS 코드'			=> 'SNS 코드',
            '이용약관에 동의합니다'	=> '이용약관에 동의합니다',
            '더보기'				=> '더보기'
        );
            
    } 
    else if ($lang == 'jp') 
    {
        $rtnLang = array(
            '대쉬보드'	=> 'ダッシュボード',
            '홈 / 대쉬보드'	=> 'ホーム/ダッシュボード',
            '홈 / 계정 정보'	=> 'ホーム/アカウント情報',
            '계정 정보'	=> 'アカウント情報',
            '계정정보'	=> 'アカウント情報',
            'QRCODE'	=> 'QRCODE'
        );
            
    } 
    else if ($lang == 'cn') 
    {
        $rtnLang = array(
            '계정 정보'	=> '账户信息',
            '홈 / 계정 정보'	=> '主页/账户信息'
        );
    }

    return $rtnLang;
}

function get_msg($lang='us', $msg) 
{
    if (!isset($lang)) {
        $lang = 'us';
    }

    $lang = get_lang($lang);

    try
    {
        if (isset($lang[$msg])) {
            return $lang[$msg];
        } else {
            return $msg;
        }
    }
    catch(Exception $e)
    {
        return $msg;
    }
}

?>
