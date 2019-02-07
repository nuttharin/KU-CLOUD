<div class="form-row">
    <div class="col-12">
        <label for="">Number of clusters</label>
        <input type="number" class="form-control" id="number_of_clusters" name="number_of_clusters" min="2" value="2">
    </div>
    <div class="col-12">
        <label for="">Initialization method to use.</label>
        <select name="method" id="method" class="form-control">
            <option value="1">k-means++</option>
            <option value="2">canopy</option>
            <option value="3">farthest first</option>
        </select>
    </div>
    <div class="col-12">
        <label for="max_candidates">Max candidates</label>
        <input type="number" class="form-control" id="max_candidates" name="max_candidates" value="100">
    </div>
    <div class="col-12">
        <label for="min_density">Min density</label>
        <input type="number" class="form-control" id="min_density" name="min_density" value="2">
    </div>
</div>
