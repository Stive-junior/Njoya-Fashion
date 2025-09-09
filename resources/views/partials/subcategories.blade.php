@foreach($subcategories as $subcategory)
    @php
        $hasChildren = $subcategory->children->isNotEmpty();

        $url = route('products') . '?' . http_build_query([
        'category' => $category->id,
        'subcategory' => $subcategory->id
    ]);

    
       if (Auth::check() && Auth::user()->hasRole('manager')) {
    $url = request()->fullUrlWithQuery([
        'category' => $category->id, 
        'subcategory' => $subcategory->id
    ]);
}

    @endphp

    <div class="col-lg-3 mb-3">
        <div class="dropdown-item-container">
            <a href="{{ $url }}" 
               class="dropdown-item {{ $hasChildren ? 'has-children' : '' }}">
                {{ $subcategory->name }}
            </a>
        </div>
    </div>
    
@endforeach

