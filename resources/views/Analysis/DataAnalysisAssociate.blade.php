<div class="form-row">
    <div class="col-12">
        <label for="number_of_rules">Number of rules</label>
        <input type="number" name="number_of_rules" id="number_of_rules" class="form-control" value="10">
    </div>
    <div class="col-12">
        <label for="metric_type">Metric Type</label>
        <select name="metric_type" id="metric_type" class="form-control">
            <option value="0">confidence</option>
            <option value="1">lift</option>
            <option value="2">leverage</option>
            <option value="3">Conviction</option>
        </select>
    </div>
    <div class="col-12">
        <label for="minimum_confidence">Minimum confidence</label>
        <input type="number" step="0.1" name="minimum_confidence" id="minimum_confidence" class="form-control" value="0.9"
            min="0">
    </div>
    <div class="col-12">
        <label for="delta_for_minimum_support">Delta for minimum support</label>
        <input type="number" step="0.01" name="delta_for_minimum_support" id="delta_for_minimum_support" class="form-control"
            value="0.05" min="0">
    </div>
    <div class="col-12">
        <label for="upper_for_minimum_support">Upper for minimum support</label>
        <input type="number" step="0.1" name="upper_for_minimum_support" id="upper_for_minimum_support" class="form-control"
            value="0.1" min="1.0">
    </div>
    <div class="col-12">
        <label for="lower_for_minimum_support">Lower for minimum support</label>
        <input type="number" step="0.01" name="lower_for_minimum_support" id="lower_for_minimum_support" class="form-control"
            value="0.1" min="1.0">
    </div>
</div>
