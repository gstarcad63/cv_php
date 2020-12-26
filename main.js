function send_form( form_id )
{
    // ajax提交 错误显示到 div
    $.post( $("#"+form_id).attr("action") , $("#"+form_id).serialize() , function ( data ) {
        if ( $("#"+form_id+"_notice") )
            $("#"+form_id+"_notice").html( data );
    } );
}

function confirm_delete( id )
{
    // alert( id );
    if ( confirm("确认要删除这份简历吗？") )
    {
        $.post( 'resume_remove.php?id=' + id , null , function ( data ) {
            if ( data == 'done' )
            {
                $('#rlist-'+id).remove();
            }
        });
    }
}