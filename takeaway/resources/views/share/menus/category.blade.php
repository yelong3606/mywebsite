<div class="card">
    <div class="card-header">Categories</div>
    <ul class="list-group list-group-flush">
        @foreach($categories as $category_id => $category_name)
        <li class="list-group-item">
            <a href="#category{{$category_id}}">
                {!!$category_name!!}
                (@php
                    echo isset($menus[$category_id]) ? count($menus[$category_id]) : 0;
                @endphp)
            </a>
        </li>
        @endforeach
    </ul>
</div>