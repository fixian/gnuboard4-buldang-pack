<?
// 사용방법 : echo me2do("http://buspang.kr/lib/me2do.lib.php");
// 참조문서 : http://opencode.co.kr/bbs/board.php?bo_table=gnu4_tips&wr_id=928
// key값은? : config.2.php 넣어주면 됩니다.

function me2do($url) {
    global $g4;

    // 네이버 openapi 서버경로 + urlencode된 주소(urlencode안하면 주소가 날아감)
  	$in = "http://openapi.naver.com/shorturl.xml?key=$g4[me2do_key]&url=" . urlencode($url);
    $xml = simplexml_load_file($in);
    return $xml->result->url;
}
?>