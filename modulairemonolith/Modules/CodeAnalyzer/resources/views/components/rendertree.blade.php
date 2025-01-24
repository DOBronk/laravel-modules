@props(['tree','recursed'])

@isset($recursed)
    <ul class="nested">
@else
    <ul id="treeView">
@endisset

@foreach ($tree as $key => $subTree)
    @isset($subTree['?'])
        <li><input type='checkbox' value="{{ $subTree['?'] }}|{{ $subTree['*'] }}" />{{ $key }}</li>
    @else
        <li><span class="carret">{{ $key }}</span><x-codeanalyzer::rendertree :tree="$subTree" recursed="1" />
    @endisset
@endforeach

</ul>