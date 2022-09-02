/**
* @package managementtodo
*/
// jQuery


function deleteItem(item_id){
	jQuery.ajax({
	     type : "post",
	     dataType : "json",
	     url : my_ajax_object.ajax_url,
	     data : {action: "delete_todo_item", item_id : item_id},
	     success: function(response) {
            if(response.type == "success") {
            	jQuery('#todo').DataTable().row(jQuery("#todo_"+item_id)).remove().draw();
            }
            else {
            	console.log("You could not delete.")
            }
	     }
	}) 
}