<div class="search-bar pt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <form action="{{ route('adverts.index') }}" method="get">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="form-group">
                                <input type="text" class="form-control" name="text"
                                       value="{{ request('text') }}"
                                       placeholder="Поиск по сайту">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button class="btn btn-light border"><span class="fa fa-search"></span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3 text-end">
                <p><a href="{{ route('cabinet.adverts.create') }}" class="btn btn-primary">
                        <span class="fa fa-plus">&nbsp;Создать объявление</span>
                    </a></p>
            </div>
        </div>
    </div>
</div>
