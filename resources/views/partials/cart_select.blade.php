


<div class="variant-selector mb-4">
    @foreach(['sizes' => 'Taille', 'colors' => 'Couleur', 'materials' => 'Matière'] as $type => $label)
        @if(!empty($variants[$type]))
            <div class="mb-5 d-flex">
                <label class="text-or me-2">{{ $label }} :</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($variants[$type] as $option)
                        @php $isSelected = $selectedVariants[$type] === $option; @endphp

                        <div class="stive position-relative d-inline-block">
                            @if($type === 'colors')
                                <div class="color-option {{ $isSelected ? 'active' : '' }}" 
                                     style="background-color: <?= $option ?>"
                                     data-type="{{ $type }}"
                                     data-value="{{ $option }}"
                                     title="{{ $option }}">
                                </div>
                            @else
                                <button type="button" 
                                        class="btn btn-outline-or variant-option {{ $isSelected ? 'active' : '' }}"
                                        data-type="{{ $type }}"
                                        data-value="{{ $option }}">
                                    {{ $option }}
                                </button>
                            @endif

                         
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>


                        <input type="hidden" id="selectedVariants{{ $article->id }}" name="selected_variants" 
                               value="{{ json_encode($selectedVariants) }}">

  <div class="selected-variants-display mb-4 p-3 bg-dark rounded">
                                    <h6 class="text-or mb-3 no d-none">Aucune sélection </h6>
                                    <div class="selected-variants-grid">
                                       
                                    </div>
                                </div>