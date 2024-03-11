<form action="{{ route('site.search') }}"
    class="rounded bg-neutral-100 p-1 d-flex justify-content-center align-items-center">
    <div class="input-group">
        <input type="text" class="form-control border-0 neutral-300 bg-transparent shadow-none caption"
            placeholder="{{ setting('site.placeholder_search_form') }}" name="search_query" aria-label="search form">
        <div class="input-group-append">
            <button class="btn btn-outline-none border-0 btn-primary px-3" type="submit">
                <span class="fa fa-search neutral-300 caption-no-font text-white"></span></button>
        </div>
    </div>
</form>
