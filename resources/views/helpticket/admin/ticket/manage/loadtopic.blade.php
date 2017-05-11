@foreach($Topics as $top)
<div class="form-check">
  <label class="form-check-label">
    <input class="form-check-input" type="checkbox" value="{{$top->id}}" name="topicIDS[]">
    {{$top->topic}} - {{$top->description}}
  </label>
</div>
@endforeach
