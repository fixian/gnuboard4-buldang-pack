<?
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ� 

// ���ÿɼ����� ���� ����ġ�Ⱑ ���������� ����
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
?>

<!-- �Խ��� ��� ���� -->
<table width="<?=$width?>" align=center><tr><td>

<!-- �з� ����Ʈ �ڽ�, �Խù� ���, ������ȭ�� ��ũ -->
<div>
    <div class="btn-group">
    <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>" class="btn btn-default btn-sm"><?=$board[bo_subject]?></a>
    <? include("$g4[bbs_path]/my_menu_add_script.php");?>
    <? if ($rss_href) { ?><a href='<?=$rss_href?>' class="btn btn-default btn-sm"><i class='fa fa-rss'></i></a><?}?>
    <? if ($admin_href) { ?><a href="<?=$admin_href?>" class="btn btn-default btn-sm"><i class='fa fa-cog'></i></a><?}?>
    <? if ($is_category) { ?>
    <form name="fcategory" method="get" role="form" class="form-inline">
    <select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
    <option value=''>��ü</option><?=$category_option?></select>
    </form>
    <? } ?>
    </div>

    <div class="pull-right">
        Total <?=number_format($total_count)?>
    </div>

</div>

<!-- ���� -->
<form name="fboardlist" method="post" role="form" class="form-horizontal">
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
    <th width=50><?=subject_sort_link('wr_id', $qstr2, 1)?>��ȣ</a></th>
    <? if ($is_checkbox) { ?><th width=40><INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox></th><?}?>
    <th>����</th>
    <th width=110px>�۾���</th>
    <th width=60px><?=subject_sort_link('wr_datetime', $qstr2, 1)?>��¥</a></a></th>
    <th width=60px><?=subject_sort_link('wr_hit', $qstr2, 1)?>��ȸ</a></th>
    <? if ($is_good) { ?><th width=60px><?=subject_sort_link('wr_good', $qstr2, 1)?>��õ</a></th><?}?>
    <? if ($is_nogood) { ?><th width=60px><?=subject_sort_link('wr_nogood', $qstr2, 1)?>����õ</a></th><?}?>
</tr>
</thead>

<!-- ��� -->
<tboby>
<? for ($i=0; $i<count($list); $i++) { ?>
<tr height=28 align=center> 
    <td>
        <? 
        if ($list[$i][is_notice]) // �������� 
            echo "<i class=\"fa fa-microphone\" title='notice'></i> ";
        else if ($wr_id == $list[$i][wr_id]) // ������ġ
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
        if ($list[$i][icon_file]) echo " <i class=\"fa fa-file\" title='attached file'>";
        echo " " . $list[$i][icon_link];
        if (!$list[$i][is_notice]) {

        if ($list[$i][icon_hot]) echo " <i class=\"fa fa-fire\" title='hot article'>";
        }
        if ($list[$i][icon_secret]) echo " <i class=\"fa fa-lock\" title='new'>";
        echo $nobr_end;
        ?></td>
    <td><nobr style='display:block; overflow:hidden; width:105px;'><?=$list[$i][name]?></nobr></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][datetime2]?></span></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_hit]?></span></td>
    <? if ($is_good) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_good]?></span></td><? } ?>
    <? if ($is_nogood) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_nogood]?></span></td><? } ?>
</tr>
<?}?>

<? if (count($list) == 0) { echo "<tr><td colspan='$colspan' height=100 align=center>�Խù��� �����ϴ�.</td></tr>"; } ?>
</tboby>
</table>
</form>

<!-- ������ -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr> 
    <td width="100%" align="center" height=30 valign=bottom>
        <ul class="pagination">
        <? if ($prev_part_href) { echo "<li><a href='$prev_part_href'>�����˻�</a></li>"; } ?>
        <?
        // �⺻���� �Ѿ���� �������� �Ʒ��� ���� ��ȯ�Ͽ� �پ��ϰ� ����� �� �ֽ��ϴ�.
        $write_pages = str_replace("����", "<i class='fa fa-angle-left'></i>", $write_pages);
        $write_pages = str_replace("����", "<i class='fa fa-angle-right'></i>", $write_pages);
        $write_pages = str_replace("ó��", "<i class='fa fa-angle-double-left'></i>", $write_pages);
        $write_pages = str_replace("�ǳ�", "<i class='fa fa-angle-double-right'></i>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<li><a href='$next_part_href'>���İ˻�</a></li>"; } ?>
        </ul>
    </td>
</tr>
</table>
</div>

<!-- ��ũ ��ư, �˻� -->
<form name=fsearch method=get role="form" class="form-inline">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca      value="<?=$sca?>">
<div class="btn-group">
    <? if ($list_href) { ?><a href="<?=$list_href?>" class="btn btn-default"><i class='fa fa-list'></i> ���</a><? } ?>
    <? if ($write_href) { ?><a href="<?=$write_href?>" class="btn btn-default"><i class='fa fa-edit'></i> ����</a><? } ?>
</div>
<? if ($is_checkbox) { ?>
<div class="btn-group">
    <a href="javascript:select_delete();" class="btn btn-default">���û���</a>
    <a href="javascript:select_copy('copy');" class="btn btn-default">���ú���</a>
    <a href="javascript:select_copy('move');" class="btn btn-default">�����̵�</a>
    <? if ($is_category) { ?>
    <a href="javascript:select_category();"  class="btn btn-default">ī�װ�������</a>
    <select name=sca2><?=$category_option?></select>
    <? } ?>
</div>
<? } ?>

<div class="pull-right">
    <div class="form-group">
        <label class="sr-only" for="sfl">sfl</label>
        <select name=sfl class="form-control">
        <option value='wr_subject'>����</option>
        <option value='wr_content'>����</option>
        <option value='wr_subject||wr_content'>����+����</option>
        <option value='mb_id,1'>ȸ�����̵�</option>
        <option value='mb_id,0'>ȸ�����̵�(��)</option>
        <option value='wr_name,1'>�̸�</option>
        <option value='wr_name,0'>�̸�(��)</option>
        </select>
    </div>
    <div class="form-group">
        <label class="sr-only" for="stx">stx</label>
        <input name=stx maxlength=15 size=10 itemname="�˻���" required value='<?=stripslashes($stx)?>' class="form-control">
    </div>
    <div class="form-group">
        <label class="sr-only" for="sop">sop</label>
        <select name=sop class="form-control">
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary">�˻�</button>
    </div>
</div>
</form>

</td></tr></table>

<script language="JavaScript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
    document.fsearch.sop.value = '<?=$sop?>';
}
</script>

<? if ($is_checkbox) { ?>
<script language="JavaScript">
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
        alert(str + "�� �Խù��� �ϳ� �̻� �����ϼ���.");
        return false;
    }
    return true;
}

// ������ �Խù� ����
function select_delete() {
    var f = document.fboardlist;

    str = "����";
    if (!check_confirm(str))
        return;

    if (!confirm("������ �Խù��� ���� "+str+" �Ͻðڽ��ϱ�?\n\n�ѹ� "+str+"�� �ڷ�� ������ �� �����ϴ�"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// ������ �Խù� ���� �� �̵�
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "����";
    else
        str = "�̵�";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}

// ������ �Խù� ī�װ����� ����
function select_category() {
    var f = document.fboardlist;
    var f2 = document.fsearch;

    str = "ī�װ�������";
    if (!check_confirm(str))
        return;

    str = f2.sca2.value;
    if (!confirm("������ �Խù��� ī�װ����� "+str+" ���� ���� �Ͻðڽ��ϱ�?"))
        return;

    // sca�� ���� �־������.
    f.sca.value = str;

    f.action = "./category_all.php";
    f.submit();
}
</script>
<? } ?>
<!-- �Խ��� ��� �� -->