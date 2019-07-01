<ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info"
            aria-selected="true">Infomation</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="opening-tab" data-toggle="tab" href="#opening" role="tab" aria-controls="opening"
            aria-selected="false">Opening Hours</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
        <div class="row">
            <div class="col-5">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" value="{{$shop->title}}" class="form-control"
                                placeholder="Shop title">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" rows="10">{{$shop->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" name="addr_1" value="{{$shop->addr_1}}" class="form-control mb-2"
                                placeholder="Address line 1">
                            <input type="text" name="addr_2" value="{{$shop->addr_2}}" class="form-control mb-2"
                                placeholder="Address line 2 (optional)">
                            <input type="text" name="addr_3" value="{{$shop->addr_3}}" class="form-control"
                                placeholder="Address line 3 (optional)">
                        </div>
                        <div class="form-group">
                            <label for="">Town / Dublin Postcode</label>
                            <div class="autocomplete" style="width:300px;">
                                <input type="text" id="regionsAutoComplete" name="addr_town"
                                    value="{{$shop->addr_town}}" class="form-control" placeholder="e.g. Clonsilla">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Logo</label>
                            <input type="file" name="shop_logo" class="form-control">
                            <br>
                            @if ($shop->shop_logo)
                            <img src="{{ asset('storage/' . $shop->shop_logo) }}" alt="Shop Logo">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="opening" role="tabpanel" aria-labelledby="opening-tab">
        <div class="row">
            <div class="col-4">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="opening" class="form-control" rows="8">{{$opening}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mb-2 border-info">
                    <div class="card-body">
                        <div class="card-title">
                            Format: Day From - To
                        </div>
                        <div class="card-text text-info">
                            Monday 16:00 - 23:00<br>
                            Tuesday 16:30 - 23:30<br>
                            Wednesday 16:00 - 23:00<br>
                            Thursday 16:00 - 23:00<br>
                            Friday 15:00 - 02:00<br>
                            Saturday 15:00 - 02:00<br>
                            Sunday 15:00 - 00:00<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>