<option value="{{ $child->id }}"  {{(isset($getCategory->parent_id) && $getCategory->parent_id == $child->id ? " Selected" : "")}}>&nbsp;&nbsp;-&nbsp;{{ $child->name[Config::get('app.locale')] }}</option>
    @foreach($child->children as $kid)
    <option value="{{ $kid->id }}"  {{(isset($getCategory->parent_id) && $getCategory->parent_id == $kid->id ? " Selected" : "")}}>&nbsp;&nbsp;--&nbsp;{{ $kid->name[Config::get('app.locale')] }}</option>
    @endforeach