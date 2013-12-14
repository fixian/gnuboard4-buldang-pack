<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
?>

<!-- 게시판 목록 시작 -->
<div width="<?=$width?>" class="table-responsive"> 

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<div>
    <div class="btn-group">
    <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>" class="btn btn-default btn-sm"><?=$board[bo_subject]?></a>
    </div>

    <div class="btn-group">
    <? if ($write_href) { ?>
    <div class="btn-group">
        <a href="<?=$write_href?>" class="btn btn-sm btn-default"><i class='fa fa-edit'></i> 쓰기</a>
    </div>
    <? } ?>
    <? include("$g4[bbs_path]/my_menu_add_script.php");?>
    <? if ($rss_href) { ?><a href='<?=$rss_href?>' class="btn btn-default btn-sm"><i class='fa fa-rss'></i></a><?}?>
    <? if ($admin_href) { ?><a href="<?=$admin_href?>" class="btn btn-default btn-sm"><i class='fa fa-cog'></i></a><?}?>
    <? if ($is_category) { ?>
    <form name="fcategory" method="get" role="form" class="form-inline">
    <select class="form-control input-sm" name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
    <option value=''>전체</option><?=$category_option?></select>
    </form>
    <? } ?>
    </div>

    <div class="pull-right">
        Total <?=number_format($total_count)?>
    </div>

</div>

<!-- 제목 -->
<form name="fboardlist" method="post" role="form" class="form-inline">
<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
<input type='hidden' name='sfl'  value='<?=$sfl?>'>
<input type='hidden' name='stx'  value='<?=$stx?>'>
<input type='hidden' name='spt'  value='<?=$spt?>'>
<input type='hidden' name='page' value='<?=$page?>'>
<input type='hidden' name='sw'   value=''>
<input type='hidden' name='sca'   value=''>

<div class="table-responsive">
<table width=100% class="table table-hover">
<thead>
<tr class="success" align=center>
    <th width=50><?=subject_sort_link('wr_id', $qstr2, 1)?>번호</a></th>
    <? if ($is_checkbox) { ?><th width=40><INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox></th><?}?>
    <th>제목</th>
    <th width=110px>글쓴이</th>
    <th width=60px><?=subject_sort_link('wr_datetime', $qstr2, 1)?>날짜</a></th>
    <th width=60px><?=subject_sort_link('wr_hit', $qstr2, 1)?>조회</a></th>
    <? if ($is_good) { ?><th width=60px><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></th><?}?>
    <? if ($is_nogood) { ?><th width=60px><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></th><?}?>
</tr>
</thead>

<!-- 목록 -->
<tboby>
<? for ($i=0; $i<count($list); $i++) { ?>
<tr height=28 align=center> 
    <td>
        <? 
        if ($list[$i][is_notice]) // 공지사항 
            echo "<i class=\"fa fa-microphone\" title='notice'></i> ";
        else if ($wr_id == $list[$i][wr_id]) // 현재위치
            echo "<span style='font:bold 11px tahoma; color:#E15916;'>{$list[$i][num]}</span>";
        else
            echo "<span style='font:normal 11px tahoma; color:#BABABA;'>{$list[$i][num]}</span>";
        ?></td>
    <? if ($is_checkbox) { ?><td><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"></td><? } ?>
    <td align=left style='word-break:break-all;'>
        <? 
        echo $nobr_begin;
        echo $list[$i][reply];
        if ($list[$i][icon_reply]) echo "<i class=\"fa fa-reply\" title='reply'> ";
        if ($is_category && $list[$i][ca_name]) { 
            echo "<span class=small><font color=gray>[<a href='{$list[$i][ca_name_href]}'>{$list[$i][ca_name]}</a>]</font></span> ";
        }
        $style = "";
        if ($list[$i][is_notice]) $style .= " style='font-weight:bold;'";
        if ($list[$i][wr_singo]) $style .= " style='color:#B8B8B8;'";

        echo "<a href='{$list[$i][href]}' $style>";
        echo $list[$i][subject];
        echo "</a>";

        if ($list[$i][comment_cnt]) 
            echo " <a href=\"{$list[$i][comment_href]}\"><span style='font-family:Tahoma;font-size:10px;color:#EE5A00;'>{$list[$i][comment_cnt]}</span></a>";

        //echo " " . $list[$i][icon_new];
        if ($list[$i][icon_new]) echo " <i class=\"fa fa-bell\" title='new'>";
        if ($list[$i][icon_file]) echo " <i class=\"fa fa-file\" title='attached file'></i>";
        echo " " . $list[$i][icon_link];
        if (!$list[$i][is_notice]) {

        if ($list[$i][icon_hot]) echo " <i class=\"fa fa-fire\" title='hot article'></i>";
        }
        if ($list[$i][icon_secret]) echo " <i class=\"fa fa-lock\" title='new'></i>";
        echo $nobr_end;
        ?></td>
    <td><nobr style='display:block; overflow:hidden; width:105px;'><?=$list[$i][name]?></nobr></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][datetime2]?></span></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_hit]?></span></td>
    <? if ($is_good) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_good]?></span></td><? } ?>
    <? if ($is_nogood) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_nogood]?></span></td><? } ?>
</tr>
<?}?>

<? if (count($list) == 0) { echo "<tr><td colspan='$colspan' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>
</tboby>
</table>
</div>
</form>

<!-- 페이지 -->
<div class="center-block">
    <ul class="pagination">
    <? if ($prev_part_href) { echo "<li><a href='$prev_part_href'>이전검색</a></li>"; } ?>
    <?
    // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 다양하게 출력할 수 있습니다.
    $write_pages = str_replace("이전", "<i class='fa fa-angle-left'></i>", $write_pages);
    $write_pages = str_replace("다음", "<i class='fa fa-angle-right'></i>", $write_pages);
    $write_pages = str_replace("처음", "<i class='fa fa-angle-double-left'></i>", $write_pages);
    $write_pages = str_replace("맨끝", "<i class='fa fa-angle-double-right'></i>", $write_pages);
    ?>
    <?=$write_pages?>
    <? if ($next_part_href) { echo "<li><a href='$next_part_href'>이후검색</a></li>"; } ?>
    </ul>
</div>

<!-- 링크 버튼, 검색 -->
<form name=fsearch method=get role="form" class="form-inline">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca      value="<?=$sca?>">
<? if ($list_href) { ?>
<div class="btn-group">
    <a href="<?=$list_href?>" class="btn btn-default"><i class='fa fa-list'></i> 목록</a>
</div>
<? } ?>
<? if ($write_href) { ?>
<div class="btn-group">
    <a href="<?=$write_href?>" class="btn btn-default"><i class='fa fa-edit'></i> 쓰기</a>
</div>
<? } ?>
<? if ($is_checkbox) { ?>
<div class="btn-group hidden-sm hidden-xs">
    <a href="javascript:select_delete();" class="btn btn-default">선택삭제</a>
    <a href="javascript:select_copy('copy');" class="btn btn-default">선택복사</a>
    <a href="javascript:select_copy('move');" class="btn btn-default">선택이동</a>
    <? if ($is_category) { ?>
    <a href="javascript:select_category();"  class="btn btn-default">카테고리변경</a>
    <select name=sca2><?=$category_option?></select>
    <? } ?>
</div>
<? } ?>

<div class="pull-right">
    <div class="form-group">
        <label class="sr-only" for="sfl">sfl</label>
        <select name=sfl class="form-control">
        <option value='wr_subject'>제목</option>
        <option value='wr_content'>내용</option>
        <option value='wr_subject||wr_content'>제목+내용</option>
        <option value='mb_id,1'>회원아이디</option>
        <option value='mb_id,0'>회원아이디(코)</option>
        <option value='wr_name,1'>이름</option>
        <option value='wr_name,0'>이름(코)</option>
        </select>
    </div>
    <div class="form-group">
        <label class="sr-only" for="stx">stx</label>
        <input name=stx maxlength=15 size=10 itemname="검색어" required value='<?=stripslashes($stx)?>' class="form-control">
    </div>
    <div class="form-group">
        <label class="sr-only" for="sop">sop</label>
        <select name=sop class="form-control">
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary">검색</button>
    </div>
</div>
</form>

</div>

<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
    document.fsearch.sop.value = '<?=$sop?>';
}
</script>

<? if ($is_checkbox) { ?>
<script type="text/javascript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}

// 선택한 게시물 카테고리를 변경
function select_category() {
    var f = document.fboardlist;
    var f2 = document.fsearch;

    str = "카테고리변경";
    if (!check_confirm(str))
        return;

    str = f2.sca2.value;
    if (!confirm("선택한 게시물의 카테고리를 "+str+" 으로 변경 하시겠습니까?"))
        return;

    // sca에 값을 넣어줘야죠.
    f.sca.value = str;

    f.action = "./category_all.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
