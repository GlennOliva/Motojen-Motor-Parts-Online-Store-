$(document).ready(function(){
    $('.delete_kitchenbtn').click(function (e){
        e.preventDefault();
        var id = $(this).val();

        console.log("Kitchen ID to Delete:", id); // Log the kitchen ID

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'kitchen_id': id,
                    'delete_kitchenbtn': true
                },
                success: function(response)
                {
                    console.log("Response from Server:", response); // Log the response
                    if(response == 10)
                    {
                        swal("Success!","Kitchen Successfully delete" , "success");
                        $("#admin_table").load(location.href + " #admin_table");
                    }
                    else if (response == 20){
                        swal("Error!","Failed to delete" , "error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown); // Log AJAX errors
                }
              });
            }
          });
    });
});
