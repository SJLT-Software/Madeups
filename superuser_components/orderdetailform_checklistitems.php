<div id="orderdetail_checklistitemsform" hidden>
    <h1>Order Detail Form</h1>
    <form id="form_orderdetail_checklistitems" action="orderdetailform_checklistitemsprocess.php" method="post" enctype="multipart/form-data">

        <!-- <label for="date">Date:</label>
        <input type="date" name="date" id="date" class="form-field" required> -->
        <label for="sales_order_no">Sales Order No.:</label>
        <input type="text" name="sales_order_no" id="sales_order_no" class="form-field salesorderno" required>
    <div id="sales_order_no_exists" class="salesorderexists" title="Sales Order Exists" hidden>
        <p>The Sales Order Number you entered already exists. Please enter a different Sales Order Number.</p>
    </div>
        <label for="buyer_code">Buyer Code:</label>
        <input type="text" name="buyer_code" id="buyer_code" class="form-field" required>

        <label for="work_order_number">Work Order Number:</label>
        <input type="text" name="work_order_number" id="work_order_number" class="form-field" required>
        <h2>Check list Items </h2>
        
        <label for="tech_pack">Tech Pack (PDF):</label>
        <div class="file-input-wrapper">
        <input type="file" name="tech_pack" id="tech_pack" class="form-field" accept="application/pdf" required>
        <button type="button" id="remove_tech_pack" class="remove-button">X</button>
        </div>
        <label for="sample_code">Sample Code:</label>
        <input type="text" name="sample_code" id="sample_code" class="form-field" required>

        <label for="first_piece_inspection">First Piece Inspection:</label>
        <textarea name="first_piece_inspection" id="first_piece_inspection" class="form-field" required></textarea>

        <label for="trim_accessories">Trim/Accessories:</label>
        <input type="text" name="trim_accessories" id="trim_accessories" class="form-field" required>

        <h2> Department Checklist </h2>
        <h2> Cutting </h2>
        <div id="cutting">
            <button type="button" id="addRowButton">Add Row</button>
            <div id="cuttingRows"></div>
        </div>

        <h2> Sewing </h2>
        <div id="Sewing">
            <label for="thread_code">Thread Code:</label>
            <input type="text" name="thread_code" id="thread_code" class="form-field" required>

            <label for="washcare_label">Washcare Label:</label>
            <input type="text" name="washcare_label" id="washcare_label" class="form-field" required>

            <label for="elastic">Elastic:</label>
            <input type="text" name="elastic" id="elastic" class="form-field" required>

            <button type="button" id="addRowButtonSewing">Add Row</button>
            <div id="sewingRows"></div>
        </div>
        <h2> OutSourcing </h2>
        <div id="outsourcing">
            <label for="duvet_button">Duvet Button:</label>
            <input type="text" name="duvet_button" id="duvet_button" class="form-field" required>

            <label for="embroidery_design">Embroidery Design:</label>
            <input type="text" name="embroidery_design" id="embroidery_design" class="form-field" required>

            <label for="embroidery_thread">Embroidery Thread:</label>
            <input type="text" name="embroidery_thread" id="embroidery_thread" class="form-field" required>

            <button type="button" id="addRowButtonOutsourcing">Add Row</button>
            <div id="outsourcingRows"></div>
        </div>

        <h2> Checking </h2>
        <div id="checking">
            
            <button type="button" id="addRowButtonChecking">Add Row</button>
            <div id="checkingRows"></div>
        </div>

        <h2> Ironing and Packing </h2>
        <div id="ironing_packing">
            <label for="insert_card">Insert Card:</label>
            <input type="text" name="insert_card" id="insert_card" class="form-field" required>

            <label for="tag">Tag:</label>
            <input type="text" name="tag" id="tag" class="form-field" required>

            <label for="poly_bag">Poly Bag:</label>
            <input type="text" name="poly_bag" id="poly_bag" class="form-field" required>

            <button type="button" id="addRowButtonIroningPacking">Add Row</button>
            <div id="ironingPackingRows"></div>
        </div>

        <h2> Master Packing </h2>
        <div id="master_packing">
            <label for="carton_box">Carton Box:</label>
            <input type="text" name="carton_box" id="carton_box" class="form-field" required>

            <label for="carton_box_sticker">Carton Box Sticker:</label>
            <input type="text" name="carton_box_sticker" id="carton_box_sticker" class="form-field" required>

            <button type="button" id="addRowButtonMasterPacking">Add Row</button>
            <div id="masterPackingRows"></div>
        </div>
        <input type="submit" value="Submit Order Detail" class="button">
        </form>
        
        
    <script>
        $(document).ready(function() {
            
            $('#remove_tech_pack').hide();
            $('#tech_pack').on('change', function() {
                if ($('#tech_pack').val() !== '') {
                    $('#remove_tech_pack').show();
                } else {
                    $('#remove_tech_pack').hide();
                }
            });
            $('#remove_tech_pack').click(function() {
                $('#tech_pack').val('');
                $(this).hide();
            });
            
            // Section-specific options
            const sections = {
                cuttingRows: ['Option-1', 'Option-2', 'Option-3'],
                sewingRows: ['Option-1', 'Option-2', 'Option-3'],
                outsourcingRows: ['Option-1', 'Option-2', 'Option-3'],
                checkingRows: ['Option-1', 'Option-2', 'Option-3'],
                ironingPackingRows: ['Option-1', 'Option-2', 'Option-3'],
                masterPackingRows: ['Option-1', 'Option-2', 'Option-3']
            };

            // Function to create dropdown with section-specific options
            function createDropdown(sectionId) {
                const select = $('<select class="form-field" required>');
                select.append($('<option value="" disabled selected>Select Option</option>'));
                
                sections[sectionId].forEach(option => {
                    select.append($(`<option value="${option}">${option}</option>`));
                });
                
                return select;
            }
            // Generic function to handle row addition
            function addRow(buttonId, targetDiv) {
                $(`#${buttonId}`).click(function() {
                    const newRow = $("<div class='row'></div>");
                    newRow.append(createDropdown(targetDiv));
                    newRow.append("<input type='text' class='form-field' required>");
                    newRow.append("<button type='button' class='removeRow'>Remove</button>");
                    $(`#${targetDiv}`).append(newRow);
                });
            }

            // Initialize row handlers for all sections
            addRow("addRowButton", "cuttingRows");
            addRow("addRowButtonSewing", "sewingRows");
            addRow("addRowButtonOutsourcing", "outsourcingRows");
            addRow("addRowButtonChecking", "checkingRows");
            addRow("addRowButtonIroningPacking", "ironingPackingRows");
            addRow("addRowButtonMasterPacking", "masterPackingRows");

            // Remove row functionality
            $('#orderdetail_checklistitemsform').on('click', '.removeRow', function() {
                $(this).parent().remove();
            });


            $('#form_orderdetail').on('submit', function(e) {
                const fileInput = document.getElementById('tech_pack');
                if (fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please upload the Tech Pack (PDF).');
                    return false;
                }
                const divIds = ['cuttingRows', 'sewingRows', 'outsourcingRows', 'checkingRows', 'ironingPackingRows', 'masterPackingRows'];
                
                for (const divId of divIds) {
                    const selections = $(`#${divId} select`).map(function() {
                        return $(this).val();
                    }).get();
                    
                    const uniqueSelections = new Set(selections);
                    if (selections.length !== uniqueSelections.size) {
                        e.preventDefault();
                        alert(`Duplicate selections found in ${divId.replace('Rows', '')} section. Please select different options.`);
                        return false;
                    }
                }
            });
        });
    </script>
</div>
