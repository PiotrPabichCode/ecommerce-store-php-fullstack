$(document).ready(function () {

    $(document).on('click', '.increment-btn', function (e) {
        e.preventDefault();

        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;

        var max_qty = $(this).closest('.product_data').find('.prodID1').val();
        var max_value = parseInt(max_qty, 10);
        max_value = isNaN(max_value) ? 0 : max_value;

        if(value < max_value) {
            value++;
            $(this).closest('.product_data').find('.input-qty').val(value);
            if(value == 2) {
                $(this).closest('.product_data').find('#decrement_qty').removeAttr('disabled');
            }
            if(value == max_value) {
                $(this).closest('.product_data').find('#increment_qty').prop("disabled", true);
            }
        }

    });

    $(document).on('click', '.decrement-btn', function (e) {
        e.preventDefault();

        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;

        if(value > 1) {
            value--;
            $(this).closest('.product_data').find('.input-qty').val(value);
            if(value <= 1) {
                $(this).closest('.product_data').find('#decrement_qty').prop("disabled", true);
            }
            $(this).closest('.product_data').find('#increment_qty').removeAttr('disabled');
        }

    });

    $(document).on('click', '.addToCartBtn', function (e) {
        e.preventDefault();

        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var prod_id = $(this).val();
        
        $.ajax({
            method: "POST",
            url: "/controllers/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "add"
            },
            success: function(response) {
                if(response == 201) {
                    alertify.success("Product added to cart");
                    $('#cart-update').load(location.href + " #cart-update");
                } else if(response == "existing") {
                    alertify.success("Product already in cart");
                } else if(response == 401) {
                    alertify.success("Login to continue");
                } else if(response == 501) {
                    alertify.success("Something went wrong");
                }
            }
        });
    });

    $(document).on('click', '.addToFavorite', function (e) {
        e.preventDefault();

        var prod_id = this.id;
        
        $.ajax({
            method: "POST",
            url: "/controllers/handlefavorites.php",
            data: {
                "prod_id": prod_id,
                "scope": "add"
            },
            success: function(response) {
                if(response == 201) {
                    alertify.success("Product added to wishlist");
                } else if(response == "existing") {
                    alertify.success("Product already in wishlist");
                } else if(response == 401) {
                    alertify.success("Login to continue");
                } else if(response == 501) {
                    alertify.success("Something went wrong");
                }
            }
        });
    });

    $(document).on('click', '.update-qty', function () {
        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var prod_id = $(this).closest('.product_data').find('.prodID').val();

        $.ajax({
            method: "POST",
            url: "/controllers/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "update"
            },
            success: function (response) {
                $('#cart-update').load(location.href + " #cart-update");
            }
        });
    });

    $(document).on('click', '.delete-item', function () {
        var cart_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "/controllers/handlecart.php",
            data: {
                "cart_id": cart_id,
                "scope": "delete"
            },
            success: function (response) {
                if(response == 200) {
                    alertify.success("Item removed successfully");
                    $('#cart-update').load(location.href + " #cart-update");
                    $('#mycart').load(location.href + " #mycart");
                } else {
                    alertify.success(response);
                }
            }
        })
    });
    $(document).on('click', '.delete-favorite-item', function () {
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "/controllers/handlefavorites.php",
            data: {
                "prod_id": prod_id,
                "scope": "delete"
            },
            success: function (response) {
                if(response == 200) {
                    alertify.success("Item removed successfully");
                    $('#mywishlist').load(location.href + " #mywishlist");
                } else {
                    alertify.success(response);
                }
            }
        })
    });
    $(document).on('click', '.delete-item-books', function () {
        var prod_id = $(this).val();

        if(confirm("Do you want to delete this books")) {
            $.ajax({
                method: "POST",
                url: "/controllers/handleadmin.php",
                data: {
                    "prod_id": prod_id,
                    "scope": "delete"
                },
                success: function (response) {
                    if(response == 200) {
                        alertify.success("Item deleted successfully");
                        $('#mybooks').load(location.href + " #mybooks");
                    } else {
                        alertify.success(response);
                    }
                }
            })
        }
    });
    
});