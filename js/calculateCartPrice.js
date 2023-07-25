$(document).ready(function () {
    // Function to update total price and quantity
    function updateTotal() {
        var total = 0;
        $('.quantity').each(function () {
            var quantity = $(this).val();
            var price = $(this).closest('tr').find('.price').text().replace('Rs. ', '');
            var totalQtyPrice = parseInt(quantity) * parseFloat(price);
            $(this).closest('tr').find('.total-qty-price').text('Rs. ' + totalQtyPrice.toFixed(2));
            total += totalQtyPrice;
        });
        $('.total-price').text('Rs. ' + total.toFixed(2));
    }

    // Event listener for quantity change
    $('.quantity').on('change', function () {
        updateTotal();
    });

    // Initial calculation
    updateTotal();
});
$(document).ready(function () {
    // Function to update total price and quantity
    function updateTotal() {
        var total = 0;
        $('.quantity').each(function () {
            var quantity = $(this).val();
            var price = $(this).closest('tr').find('.price').text().replace('Rs. ', '');
            var totalQtyPrice = parseInt(quantity) * parseFloat(price);
            $(this).closest('tr').find('.total-qty-price').text('Rs. ' + totalQtyPrice.toFixed(2));
            total += totalQtyPrice;
        });
        $('.total-price').text('Rs. ' + total.toFixed(2));
    }

    // Event listener for quantity change
    $('.quantity').on('change', function () {
        updateTotal();
    });

    // Initial calculation
    updateTotal();
});