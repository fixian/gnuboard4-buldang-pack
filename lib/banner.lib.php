<?
if (!defined('_GNUBOARD_')) exit;

// ��ʸ� �����´�
// bg_id : ��ʱ׷� id
// bn_id : ��� id (bn_id�� �����Ǹ� �� 1���� ��� �˴ϴ�. ������� ����� ����)
// rows : ����� ����� �� 
// sst : ���Ĺ��, 0: ����, 1 : �⺻����(����, ��� id ��������)
//       ������� ��쿡�� ��������, ���ο� �ǹ� �ְ� ����� ���� ������� �ϴ� ���� �����ϴ�.
function get_banner($bg_id, $skin="basic", $bn_id="", $rows=0, $sst=0, $opt="")
{
    global $g4;

    if ($sst == 1)
        $sst_sql = " bn_order, bn_id desc ";
    else
        $sst_sql = " rand() ";

    // ��¥�� ������ �ݴϴ�.
    $sql_datetime = " and '$g4[time_ymdhis]' > bn_start_datetime and bn_end_datetime > '$g4[time_ymdhis]' ";

    // bc_id�� �����Ǹ� bc_id�� ���� �ɴϴ�. �ƴϸ� n���� ���� �ɴϴ�. �������� ����� rand �Դϴ�.
    if ($bn_id) {
        $sql = " select * from $g4[banner_table] where bg_id='$bg_id' and bn_id='$bn_id' and bn_use = '1' $sql_datetime ";
    } else {
        $sql = " select * from $g4[banner_table] where bg_id='$bg_id' and bn_use = '1' $sql_datetime order by $sst_sql ";
        if ($rows)
            $sql .= "  limit 0, $rows ";
    }
    $result = sql_query($sql);

    // ��ʱ׷� ������ ���� �ɴϴ�.
    $sql = " select * from $g4[banner_group_table] where bg_id = '$bg_id' ";
    $bg = sql_fetch($sql);

    $list = array();
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $list[$i][bg_id] = $bg_id;
        $list[$i][bn_id] = $row[bn_id];
        $list[$i][bn_target] = $row[bn_target];
        $list[$i][bn_url] = $row[bn_url];
        $list[$i][bn_subject] = $row[bn_subject];
        $list[$i][bn_image] = $row[bn_image];
        $list[$i][bn_text] = $row[bn_text];
        $list[$i][bg_width] = $row[bg_width];
        $list[$i][bg_height] = $row[bg_height];
    }

    $banner_skin_path = "$g4[path]/skin/banner/$skin";

    ob_start();
    include "$banner_skin_path/banner.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// ��� �׷��� SELECT �������� ����
function get_banner_group_select($name, $selected='', $event='')
{
    global $g4, $is_admin, $member;

    $sql = " select bg_id, bg_subject from $g4[banner_group_table] a ";
    if ($is_admin == "group") {
        $sql .= " left join $g4[member_table] b on (b.mb_id = a.bg_admin)
                  where b.mb_id = '$member[mb_id]' ";
    }
    $sql .= " order by a.bg_id ";

    $result = sql_query($sql);
    $str = "<select name='$name' $event>";
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $str .= "<option value='$row[bg_id]'";
        if ($row[bg_id] == $selected) $str .= " selected";
        $str .= ">$row[bg_subject] ($row[bg_id])</option>";
    }
    $str .= "</select>";
    return $str;
}

// ��ʸ� SELECT �������� ����
function get_banner_select($name, $selected='', $event='')
{
    global $g4, $is_admin, $member;

    $sql = " select bn_id, bn_subject from $g4[banner_table] a ";
    $sql .= " order by a.bg_id ";

    $result = sql_query($sql);
    $str = "<select name='$name' $event>";
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $str .= "<option value='$row[bg_id]'";
        if ($row[bn_id] == $selected) $str .= " selected";
        $str .= ">$row[bn_subject] ($row[bn_id])</option>";
    }
    if ($selected == '')
        $str .= "<option value ='' selected>��ü</option>";
    else
        $str .= "<option value =''>��ü</option>";
    $str .= "</select>";
    return $str;
}
?>