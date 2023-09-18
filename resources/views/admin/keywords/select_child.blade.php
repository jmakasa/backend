<option value="{{ $child->id }}">&nbsp;&nbsp;-&nbsp;{{ $child->name[Config::get('app.locale')] }}</option>
    @foreach($child->children as $kid)
    <option value="{{ $kid->id }}">&nbsp;&nbsp;--&nbsp;{{ $kid->name[Config::get('app.locale')] }}</option>
    @endforeach