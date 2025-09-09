

<div class="cart-item-variants mt-3 d-flex gap-2">

    @if(!empty($variants))
        <div class="variants-display d-flex gap-2">
            @foreach($variants as $type => $value)
                
                    <div class="variant-item d-flex align-items-center mb-1 @if($editable) data-type="{{ $type }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#varModal{{ $articleId }} @endif">

                        <span class="text-or me-2">{{ ucfirst($type) }}:</span>
                        @if($value)
            @if($type === 'colors')
       
                @foreach((array)$value as $color)
                    <span class="color-dot me-2" style="background-color: <?= $color ?>"></span>
                @endforeach
            @else
           
                <span class="text-white me-2">
                    {{ is_array($value) ? implode(', ', $value) : $value }}
                </span>
            @endif
                      
                 @else
                <span class="text-white me-2"> -</span>
                @endif
                        @if($editable)
                            <button class="btn btn-sm  ms-2 text-white edit-variant-btn"
                                    data-type="{{ $type }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#varModal{{ $articleId }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endif
                    
                    </div>
               
            @endforeach
        </div>
    @endif



     <div class="variant-item d-flex align-items-center mb-1" @if($editable) data-bs-toggle="modal" data-bs-target="#messageModal{{ $itemId }}" @endif>

            <div class="d-flex align-items-center">
                <span class="text-or me-2">Message:</span>
                
                <span class="text-white" id="message{{ $itemId }}"> @if($customMessage) {{ Str::limit($customMessage, 10); }} @else - @endif</span>
          

                @if($editable)
                    <button class="btn btn-sm text-white ms-2 edit-message-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#messageModal{{ $itemId }}">
                        <i class="fas fa-edit"></i>
                    </button>
                @endif
            </div>
        </div>
   
</div>





<style>
    .color-dot {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 1px solid #fff;
    }
    
    .variant-item, .custom-message-display {
        padding: 8px;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }
    
    .edit-variant-btn, .edit-message-btn {
        padding: 0.15rem 0.3rem;
        font-size: 0.8rem;
    }

    .custom-message-display:hover,.variant-item:hover {
        background: rgba(0, 0, 0, 0.4);
        cursor: pointer;
    }

    .cart-item-variants{
    overflow-x: auto;
  overflow-y: hidden;
  white-space: nowrap;
    }
</style>

<script>

    document.addEventListener('DOMContentLoaded', function() {
  
    document.querySelectorAll('.save-variants-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const articleId = this.dataset.articleId;
            const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
            const selectedVariants = getSelectedVariants(articleId);
            
       
 
          
            Swal.fire({
                title: 'Mise à jour en cours',
                html: 'Veuillez patienter...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: 'var(--blanc-casse)'
            });
            
            updateCartItem(itemId, { variants: selectedVariants });
        });
    });
    

    document.querySelectorAll('.save-message-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
            const message = document.getElementById(`messageInput${itemId}`).value;
            

            Swal.fire({
                title: 'Enregistrement du message',
                html: 'Veuillez patienter...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: 'var(--blanc-casse)'
            });
            
            updateCartItem(itemId, { custom_message: message });
        });
    });
    
    function getSelectedVariants(articleId) {
      
        const variants = {};
        document.querySelectorAll(`#variantModal${articleId} .variant-option.active`).forEach(option => {
            const type = option.dataset.type;
            variants[type] = option.dataset.value;
        });
        return variants;
    }
    
    function updateCartItem(itemId, data) {
        const message = data.custom_message;
       

        fetch(`/cart/up/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            
            if (data.success) {
               
                Swal.fire({
                    icon: 'success',
                    title: data.message,
                    html: `<p class="text-center">Nous vous remercions pour la précision.</p>`,
                    background: 'var(--blanc-casse)',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    },
                    allowOutsideClick: false
                });
                
             
               
                    const messageElement = document.getElementById(`message${itemId}`);
                    if (messageElement) {
    messageElement.textContent = message.length > 10 ? message.substring(0, 10) + '...' : message;
}

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: data.message || 'Une erreur est survenue',
                    background: 'var(--blanc-casse)'
                });
            }
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Une erreur réseau est survenue',
                background: 'var(--blanc-casse)'
            });
        });
    }
});


</script>