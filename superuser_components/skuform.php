<div id="skuform" class="container" hidden>
        <h1>SKU Form</h1>
        <form id="form_sku" action="skuprocess.php" method="post">
            <label for="sku">SKU:</label>
            <input id="sku" name="sku" type="text" class="form-field" required pattern="^(KJB|H|SA|B)[0-9]+$"
                title="SKU must start with 'KJB' or 'H' or 'B' or 'SA'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()">

            <label for="Name">Name:</label>
            <input id="Name" name="Name" type="text" class="form-field" required>

    
            <label for="tc">Thread Count:</label>
            <input id="tc" name="tc" type="number" class="form-field" required>

            <input type="submit" value="Submit">

        </form>
    </div>