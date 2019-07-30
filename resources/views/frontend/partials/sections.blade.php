<li>
    {{ $section->description }} ({{ count($section->parts) }})
</li>
@if(count($section->children))
   <ul>
       @foreach($section->children as $child)
           @include('frontend.partials.sections', ['section' => $child])
       @endforeach
   </ul>
@endif
