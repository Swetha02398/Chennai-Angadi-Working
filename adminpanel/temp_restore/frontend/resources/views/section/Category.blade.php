<style>
    .card-2 {
        height: 200px !important;
        min-height: 200px !important;
        max-height: 200px !important;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        overflow: hidden;
        padding: 10px !important;
        box-sizing: border-box;
    }

    .card-2 figure {
        /* height: 100px !important;
        min-height: 100px !important;
        max-height: 100px !important; */
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-2 figure img {
        width: 100%;
        height: 100px !important;
        max-height: 100px !important;
        object-fit: cover;
        border-radius: 6px;
    }

    .card-2 h6 {
        height: 40px !important;
        min-height: 40px !important;
        max-height: 40px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        overflow: hidden;
        text-align: center;
        font-size: 13px;
    }

    .card-2 h6 a {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .card-2 span {
        flex-shrink: 0;
        font-size: 12px;
    }
</style>
<div class="carausel-10-columns-cover arrow-center position-relative">
    <div class="slider-arrow slider-arrow-2 carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
    <div class="carausel-10-columns carausel-arrow-center" id="carausel-10-columns">
        @foreach($categories as $category)
            <div class="card-2 bg-{{ ($loop->index % 6) + 9 }} wow animate__animated animate__fadeInUp"
                data-wow-delay=".{{ $loop->iteration }}s">
                <figure class="img-hover-scale overflow-hidden">
                    <a href="{{ route('category.products', $category->id) }}">
                        <img src="{{ config('app.admin_asset_url') }}/maincategory/{{ basename($category->image) }}"
                            alt="{{ $category->name }}"
                            onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'" />
                    </a>
                </figure>

                <h6>
                    <a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a>
                </h6>

                <span>{{ $category->products_count }} Available</span>
            </div>
        @endforeach
    </div>
</div>