<div class="form-group">
    <label for="parent_id">{{__('general.status.name')}}</label>
    <select name="status" class="form-select">
        <option value="Active" {{ ($data->status == "Active" ? "selected" : "")}}>{{__('general.status.active')}}</option>
        <option value="Inactive" {{ ($data->status == "Inactive" ? "selected" : "")}}>{{__('general.status.inactive')}}</option>
        </option>
    </select>
</div>