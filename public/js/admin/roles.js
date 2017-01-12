
function updaterec(obj) {
    
   var module = $("#" + obj.id).data('moduleid');
   var role = $("#" + obj.id).data('roleid');
 
     $.ajax({
        type: "POST",
        url: "roles/permission_action",
        data: {
            iModuleId: module,
            iRoleId: role,
            isRead: $('#chkbox1'+module).val(),
            isWrite: $('#chkbox2'+module).val(),
            isDelete: $('#chkbox3'+module).val()
        },
        success: function(result) {
         location.reload(true);
        }
    });
    
}

function chk(box)
{
    if(box.checked){
        box.value='1';
    }else{
         box.value='0';
    }
    
}