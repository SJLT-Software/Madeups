<div id="skuform" class="container" hidden>
        <h1>SKU Details</h1>
        <form id="form_sku" action="skuprocess.php" method="post">
            
                <div><div class="form-input">
                    
                        <label for="sku">SKU:</label>
                        <input id="sku" name="sku" type="text" class="form-field skuField">
                    </div><div class="form-input">
                   
                    <label for="Name">Name:</label>
                    <input id="Name" name="Name" type="text" class="form-field" required>
                </div></div>
            
        <div><div>
           <label for="tc">Thread Count:</label>
            <input id="tc" name="tc" type="number" class="form-field" required>
            </div>
            <div>
            <label for="Color">Color:</label>
            <input id="Color" name="Color" type="text" class="form-field" required>
            </div>
            </div>
       <div><div>
            <label for="FabricContent">Fabric Content:</label>
            <input id="FabricContent" name="FabricContent" type="text" class="form-field" required>
            </div>
            <div>
            <label for="WeaveDesign">Weave Design:</label>
            <input id="WeaveDesign" name="WeaveDesign" type="text" class="form-field" required>
            </div></div>
            <div>
                <div>
            <h2>Finished Fabric Construction</h2>
                </div>
            <table>
                <tr>
                    <th><label for="Finished_WarpCount">Finished Warp Count:</label></th>
                    <th><label for="Finished_WarpComposition">Finished Warp Composition:</label></th>
                    <th><label for="Finished_WeftCount">Finished Weft Count:</label></th>
                    <th><label for="Finished_WeftComposition">Finished Weft Composition:</label></th>
                    <th><label for="Finished_EPI">Finished EPI:</label></th>
                    <th><label for="Finished_PPI">Finished PPI:</label></th>
                    <th><label for="Finished_Ply">Finished Ply:</label></th>
                </tr>
                <tr>
                    <td><input id="Finished_WarpCount" name="Finished_WarpCount" type="text" class="form-field" required></td>
                    <td><input id="Finished_WarpComposition" name="Finished_WarpComposition" type="text" class="form-field" required></td>
                    <td><input id="Finished_WeftCount" name="Finished_WeftCount" type="text" class="form-field" required></td>
                    <td><input id="Finished_WeftComposition" name="Finished_WeftComposition" type="text" class="form-field" required></td>
                    <td><input id="Finished_EPI" name="Finished_EPI" type="text" class="form-field" required></td>
                    <td><input id="Finished_PPI" name="Finished_PPI" type="text" class="form-field" required></td>
                    <td><input id="Finished_Ply" name="Finished_Ply" type="text" class="form-field" required></td>
                </tr>
            </table>
            </div>
            <div>
                <div>
            <h2>Greige Fabric Construction</h2>
                </div>
            <table>
                <tr>
                    <th><label for="Greige_WarpCount">Greige Warp Count:</label></th>
                    <th><label for="Greige_WarpComposition">Greige Warp Composition:</label></th>
                    <th><label for="Greige_WeftCount">Greige Weft Count:</label></th>
                    <th><label for="Greige_WeftComposition">Greige Weft Composition:</label></th>
                    <th><label for="Greige_EPI">Greige EPI:</label></th>
                    <th><label for="Greige_PPI">Greige PPI:</label></th>
                    <th><label for="Greige_Ply">Greige Ply:</label></th>
                    <th><label for="GSM">GSM:</label></th>
                </tr>
                <tr>
                    <td><input id="Greige_WarpCount" name="Greige_WarpCount" type="text" class="form-field" required></td>
                    <td><input id="Greige_WarpComposition" name="Greige_WarpComposition" type="text" class="form-field" required></td>
                    <td><input id="Greige_WeftCount" name="Greige_WeftCount" type="text" class="form-field" required></td>
                    <td><input id="Greige_WeftComposition" name="Greige_WeftComposition" type="text" class="form-field" required></td>
                    <td><input id="Greige_EPI" name="Greige_EPI" type="text" class="form-field" required></td>
                    <td><input id="Greige_PPI" name="Greige_PPI" type="text" class="form-field" required></td>
                    <td><input id="Greige_Ply" name="Greige_Ply" type="text" class="form-field" required></td>
                    <td><input id="GSM" name="GSM" type="text" class="form-field" required></td>
                </tr>
            </table>
            </div>
            <div><div>
            <label for="Finished_Width">Finished Width:</label>
            <input id="Finished_Width" name="Finished_Width" type="text" class="form-field" required>
            </div>
            <div>
            <label for="Greige_Width">Greige Width:</label>
            <input id="Greige_Width" name="Greige_Width" type="text" class="form-field" required>
            </div></div>
            <div>
            <input type="submit" value="Submit">
            </div>
        </form>
    </div>