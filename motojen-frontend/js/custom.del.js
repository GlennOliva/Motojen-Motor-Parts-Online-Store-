$(document).ready(function(){


    $('.delete_cartbtn').click(function (e){
        e.preventDefault();

     
        var id = $(this).val();

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
                    'cart_id': id,
                    'delete_cartbtn': true
                },
                success: function(response)
                {
                    if(response == 200)
                    {
                        swal("Success!","Cart Successfully delete" , "success");
                        $("#products").load(location.href + " #products");
                    }
                    else if (response == 500){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });



    //update cart

    $('.update_cart').click(function (e) {
        e.preventDefault();
    
        var id = $(this).val();
        var quantity = $('input[name="quantity"]').val();
        console.log("ID:", id);
        console.log("Quantity:", quantity);
    
        // Perform the AJAX request to update the cart
        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'cart_id': id,
                'update_cart': true
            },
            success: function (response) {
                console.log(response); // Add this line for debugging
                if (response == 300) {
                    swal("Success!", "Cart Successfully updated", "success");
                    // Optionally, you can update the cart display on the page
                    $("#products").load(location.href + " #products");
                } else if (response == 600) {
                    swal("Error!", "Failed to update", "error");
                }
            },
            error: function () {
                swal("Error!", "Failed to update", "error");
            }
        });
    });


    
    $('.deleteall-btn').click(function (e){
        e.preventDefault();

     
        var id = $(this).val();

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
                    'user_id': id,
                    'deleteall-btn': true
                },
                success: function(response)
                {
                    if(response == 400)
                    {
                        swal("Success!","Cart Successfully delete" , "success");
                        $("#products").load(location.href + " #products");
                    }
                    else if (response == 800){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });
    
    
    




});





