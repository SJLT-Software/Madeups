<div id="orderdetail_productdetailsform" hidden>
<form id="form_orderdetail_productdetails" action="orderdetailform_productdetailsprocess.php" method="post">
<label for="sales_order_no">Sales Order No.:</label>
        <input type="text" name="sales_order_no" id="sales_order_no" class="form-field salesorderno" required>

<h2> Product Details </h2>
        <div id="product_details">
        <table border="1" id="product_details_table">
            <thead>
                <tr>
                    <th>PO No</th>
                    <th>Buyer Product Code</th>
                    <th>Internal Product Code</th>
                    <th>Product Type</th>
                    <th>TC</th>
                    <th>Design/Weave</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Order Qty</th>
                    <th>Cut Size</th>
                    <th>Cut Plan Direction</th>
                    <th>Cut Width in Inches</th>
                    <th>Cutting Comments</th>
                    <th>Consumption</th>
                    <th>Thread Code</th>
                    <th>Label</th>
                    <th>Elastic</th>
                    <th>Label Placement</th>
                    <th class="buttonTc" colspan=2><button type='button' class='lockTable'> Lock Table</button></th>
                    <!-- <th class="buttonTc"></th> -->
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button type="button" id="addProductRow" class="button">Add Product Row</button>
        </div>
        <button type="submit" class="button">Submit</button>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('#addProductRow').click(function() {
                const newRow = $("<tr></tr>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='number' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                // newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td class='buttonTc'><button type='button' class='lockRow'>Lock</button></td>");
                newRow.append("<td class='buttonTc'><button type='button' class='removeRow'>Remove</button></td>");
                $('#product_details_table tbody').append(newRow);
            });
            $('#orderdetail_productdetailsform').on('click', '.removeRow', function() {
                $(this).parent().parent().remove();
            });
            $('#orderdetail_productdetailsform').on('click', '.lockRow', function() {
                $(this).parent().siblings().find('input').attr('readonly', true);
                $(this).parent().siblings().find('.removeRow').attr('disabled', true);
                $(this).text('Unlock').removeClass('lockRow').addClass('unlockRow');
            });
            $('#orderdetail_productdetailsform').on('click', '.unlockRow', function() {
                $(this).parent().siblings().find('input').attr('readonly', false);
                $(this).parent().siblings().find('.removeRow').attr('disabled', false);
                $(this).text('Lock').removeClass('unlockRow').addClass('lockRow');
                if ($('#product_details_table .unlockRow').length === 0) {
                    $('.unlockTable').text('Lock Table').removeClass('unlockTable').addClass('lockTable');
                }
            });
            $('#orderdetail_productdetailsform').on('click', '.lockTable', function() {
                $('#product_details_table input').attr('readonly', true);
                $('#product_details_table .removeRow').attr('disabled', true);
                $('#product_details_table .lockRow').text('Unlock').removeClass('lockRow').addClass('unlockRow');
                $(this).text('Unlock Table').removeClass('lockTable').addClass('unlockTable');
            });
            $('#orderdetail_productdetailsform').on('click', '.unlockTable', function() {
                $('#product_details_table input').attr('readonly', false);
                $('#product_details_table .removeRow').attr('disabled', false);
                $('#product_details_table .unlockRow').text('Lock').removeClass('unlockRow').addClass('lockRow');
                $(this).text('Lock Table').removeClass('unlockTable').addClass('lockTable');
            });
            
        });

</script>
</div>