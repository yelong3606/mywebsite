@php
    $side_options = isset($menu) ? json_decode($menu->side_options) : array();
@endphp

<div class="card">
    <div class="card-header">
        Options
        <div class="btn-group-sm float-right" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Add Option
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                @foreach ($options as $option)
                <a class="dropdown-item" href="#" onclick="return addOption({{$loop->index}});">{{$option->option_name}}</a>
                @endforeach
                <a class="dropdown-item" href="#" onclick="return addOption(-1);">Other</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p>Example with additional price: <strong>Fried Rice(+1.00)</strong><br>
        Example without additional price: <strong>Noodle</strong></p>
        <ul class="list-group list-group-flush" id="ulOptions">
            @foreach ($side_options as $side_option)
            <li class="list-group-item">
                option {{$loop->index + 1}} 
                <a href="#" onclick="return removeOption(this);" class="btn btn-sm btn-secondary float-right">[-]</a>
                <textarea name="side_options[]" class="form-control" rows="10"><?php
                    foreach ($side_option as $item) {
                        echo $item->name;
                        if ($item->price > 0) {
                            echo "(+" . $item->price . ")";
                        }
                        echo "\r\n";
                    }
                    ?></textarea>
            </li>
            @endforeach
        </ul>
    </div>
</div>

@section('scripts1')
<script>
    var options = @json($options);

    /**
     * @param btn
     * @param index of $options
     */
    function addOption(index) {
        var ul = $('#ulOptions');
        var li = $('<li>')
            .appendTo(ul)
            .addClass('list-group-item');
        li.append('option ' + ul.children().length);
        $('<a>')
            .append('Remove')
            .appendTo(li)
            .addClass('btn btn-sm btn-secondary float-right')
            .attr('href', '#')
            .click(function() {
                return removeOption(this);
            });
        $('<textarea>').appendTo(li)
            .addClass('form-control')
            .attr('name', 'side_options[]')
            .val(options[index].option_values);

        return false;
    }

    function removeOption(btn) {
        $(btn).parents('li')[0].remove();
    }
</script>
@endsection