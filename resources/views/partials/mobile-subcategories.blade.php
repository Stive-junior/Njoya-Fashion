<ul class="list-unstyled ps-3">
    @foreach($subcategories as $subcategory)
        <li class="mb-2">
            @if(count($subcategory->children) > 0)
            <a href="{{ route('products', [ 'category' => $subcategory->parent->id , 'subcategory' => $subcategory->id]) }}" 
                   class="text-white nav-item d-block py-1 ps-2 text-decoration-none" style="margin-left: 25px;">

                       <i class="fas fa-caret-right me-2"></i>
                            {{ $subcategory->name }}
                            
            </a>
            @endif
        </li>
    @endforeach
</ul>

