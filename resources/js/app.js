document.addEventListener('DOMContentLoaded', function() {
    // Correctly target the label/button that contains the icon
    const darkModeToggleButton = document.getElementById('darkModeToggleButton');
    const body = document.body;
    const currentTheme = localStorage.getItem('theme');

    // Initial check and icon adjustment
    if (currentTheme === 'dark-mode') {
        body.classList.add('dark-mode');
        if (darkModeToggleButton) { // Ensure the button exists before querying its children
            const icon = darkModeToggleButton.querySelector('i');
            if (icon) {
                icon.classList.replace('bxs-moon', 'bxs-sun');
            }
        }
    }

    // Add click listener
    if (darkModeToggleButton) { // Ensure the button exists before adding listener
        darkModeToggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            let theme = 'light-mode';
            const icon = darkModeToggleButton.querySelector('i'); // Get the icon
            if (body.classList.contains('dark-mode')) {
                theme = 'dark-mode';
                if (icon) {
                    icon.classList.replace('bxs-moon', 'bxs-sun');
                }
            } else {
                if (icon) {
                    icon.classList.replace('bxs-sun', 'bxs-moon');
                }
            }
            localStorage.setItem('theme', theme);
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {


   


    const icons = document.querySelectorAll('.animated-icons i');
    icons.forEach((icon, index) => {
        icon.style.left = `${Math.random() * 100}%`;
        icon.style.top = `${Math.random() * 100}%`;
        icon.style.animationDelay = `${index * 2}s`;
        icon.style.position = 'absolute';
        icon.style.animation = `moveIcon ${Math.random() * 10 + 5}s infinite alternate ease-in-out`;
    });
});


const progressBar = document.querySelector('.progress-bar');

window.addEventListener('scroll', () => {
    const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrolled = (window.scrollY / scrollHeight) * 100;
    progressBar.style.width = scrolled + '%';
});


document.addEventListener('DOMContentLoaded', function() {

    const swalConfig = {
        background: 'var(--bs-dark)',
        color: 'white',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    };


    document.querySelectorAll('.delete-product').forEach(btn => {
        btn.addEventListener('click', async function() {
            const { articleId, articleName, route: deleteUrl } = this.dataset;
            
            try {
                await handleArticleDeletion(articleId, articleName, deleteUrl);
            } catch (error) {
                console.error('Erreur globale:', error);
                showAlert('error', 'Erreur inattendue', error.message);
            }
        });
    });

  
    async function handleArticleDeletion(articleId, articleName, deleteUrl) {
        const { isConfirmed } = await showConfirmDialog(
            'Confirmer la suppression',
            `Êtes-vous sûr de vouloir supprimer <strong>"${articleName}"</strong> ?`,
            'warning'
        );
        
        if (!isConfirmed) return;
try{
        const result = await deleteArticle(deleteUrl);

  console.log(result);

        if (result.in_cart) {

            await handleArticleInCart(articleId, articleName, deleteUrl, result);

        } else if (result?.success) {
        

            await handleSuccess(result, articleName);
        }

    } catch (error) {

        Swal.fire('Erreur', error.message, 'error');
    }

}

    async function deleteArticle(url, force = false) {
        const finalUrl = force ? `${url}?force_delete=true` : `${url}?force_delete=false`;
        
        const swalInstance = Swal.fire({
        title: 'Suppression en cours',
        html: 'Veuillez patienter...',
         background: 'var(--bs-dark)',
        color: 'white',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        },
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
 
        try {
            const response = await fetch(finalUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            swalInstance.close();

            return await handleResponse(response);
        } catch (error) {
            return handleFetchError(error);
        }
    }


    async function handleArticleInCart(articleId, articleName, deleteUrl, result) {
        const { users, online_count, offline_count } = result;
        
        const usersList = users.map(user => `
            <li class="d-flex justify-content-between align-items-center mb-2">
                <span>
                    ${user.name} 
                    <small class="text-muted">${user.email}</small>
                </span>
                <span class="badge ${user.is_online ? 'bg-success' : 'bg-secondary'}">
                    ${user.is_online ? '🟢 En ligne' : '⚫ Hors ligne'}
                </span>
            </li>
        `).join('');

        const { isConfirmed } = await showConfirmDialog(
            'Article dans des paniers',
            `
            <div class="text-start">
                <p class="mb-3">"${articleName}" est présent dans ${users.length} paniers :</p>
                <div class="alert alert-dark mb-3">
                    ${online_count} utilisateur(s) connecté(s)<br>
                    ${offline_count} utilisateur(s) hors ligne
                </div>
                <ul class="list-unstyled mb-3 max-h-200 overflow-auto">${usersList}</ul>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="forceConfirm" required>
                    <label class="form-check-label" for="forceConfirm">
                        Je confirme la suppression forcée
                    </label>
                </div>
            </div>
            `,
            'warning',
            true
        );

        if (isConfirmed) {
            const forceResult = await deleteArticle(deleteUrl, true);
            await handleForceDeleteResult(forceResult, articleName);
        }
    }


    async function handleResponse(response) {
        const data = await response.json();
        
        if (!response.ok) {
            console.error('Erreur serveur:', {
                status: response.status,
                data
            });
            
            throw new Error(data.message || `Erreur serveur (${response.status})`);
        }

        return data;
    }


    function handleFetchError(error) {
        console.error('Erreur fetch:', error);
        
        let message = 'Une erreur est survenue';
        if (error instanceof TypeError) {
            message = 'Erreur réseau - Vérifiez votre connexion';
        } else if (error.message.includes('CSRF')) {
            message = 'Erreur de sécurité - Rafraîchissez la page';
        }

        showAlert('error', 'Erreur', message);
        return { success: false, message: error.message };
    }

  
    async function handleSuccess(result, articleName) {
        await showAlert(
            'success', 
            'Suppression réussie', 
            `"${articleName}" a été supprimé avec succès`
        );
        
        if (result.redirect) {
            setTimeout(() => window.location.href = result.redirect, 100);
        } else if (result.reload) {
            setTimeout(() => window.location.reload(), 100);
        }
    }

 
    async function handleForceDeleteResult(result, articleName) {
        if (result?.success) {
            await showAlert(
                'success',
                'Suppression forcée réussie',
                `"${articleName}" a été supprimé des paniers utilisateurs`
            );
            setTimeout(() => window.location.reload(), 1500);
        } else if (result?.message) {
            await showAlert('error', 'Erreur', result.message);
        }
    }

 
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    async function showConfirmDialog(title, html, icon, showCheckbox = false) {
        const config = {
            title,
            html,
            icon,
            showCancelButton: true,
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            ...swalConfig
        };

        if (showCheckbox) {
            config.preConfirm = () => {
                return document.getElementById('forceConfirm')?.checked;
            };
        }

        return await Swal.fire(config);
    }

    async function showAlert(icon, title, text, timer = 3000) {
        return await Swal.fire({
            icon,
            title,
            text,
            timer,
            timerProgressBar: true,
            ...swalConfig
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    let menuTimer;
    const menuDelay = 200;

    function handleMenuHover(menu, show) {
        clearTimeout(menuTimer);
        if (show) {
            menu.classList.add('show');
        } else {
            menuTimer = setTimeout(() => {
                menu.classList.remove('show');
            }, menuDelay);
        }
    }

   
    document.querySelectorAll('.mega-menu').forEach(menu => {
        const dropdown = menu.querySelector('.dropdown-menu');
        
        menu.addEventListener('mouseenter', () => handleMenuHover(dropdown, true));
        menu.addEventListener('mouseleave', () => handleMenuHover(dropdown, false));
    });


    document.querySelectorAll('.dropdown-item-container').forEach(container => {
        const submenu = container.querySelector('.submenu-level-1, .submenu-level-2');
        
        if (submenu) {
            container.addEventListener('mouseenter', () => handleMenuHover(submenu, true));
            container.addEventListener('mouseleave', () => handleMenuHover(submenu, false));
        }
    });

  
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                e.preventDefault();
                const menu = this.closest('.mega-menu').querySelector('.dropdown-menu');
                menu.classList.toggle('show');
            }
        });
    });



 const subcategoryItems = document.querySelectorAll('.subcategory-item');
    const container = document.getElementById('articlesContainer');
    
    subcategoryItems.forEach(item => {
        item.addEventListener('click', function() {
            const subcategoryId = this.dataset.subcategory;
            
           
            subcategoryItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            loadArticles(subcategoryId);
        });
    });
    
    function loadArticles(subcategoryId) {
     
        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>`;
        
        const url = new URL(window.location.href);
        if (subcategoryId) {
            url.searchParams.set('subcategory', subcategoryId);
        } else {
            url.searchParams.delete('subcategory');
        }
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.text())
.then(html => {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const newContainer = doc.getElementById('articlesContainer');
    

    if (!newContainer || newContainer.querySelector('.no-articles') || 
        newContainer.textContent.includes('Aucun article')) {
        
        container.innerHTML = `
            <div class="col-12 text-center py-5 no-articles">
                <div class="empty-state-animation">
                    <i class="fas fa-box-open fa-4x mb-3" style="
                        animation: bounce 2s infinite, shake 0.5s 3;
                        color: var(--or-metallise);
                    "></i>
                    <h4 >Aucun article dans cette catégorie</h4>
                    <p >Revenez plus tard ou explorez nos autres catégories</p>
                </div>
            </div>`;
    } else {
        
        const articles = newContainer.querySelectorAll('[data-subcategory]');
        if (articles.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5 no-articles">
                    <div class="empty-state-animation">
                        <i class="fas fa-box-open fa-4x mb-3" style="
                            animation: bounce 2s infinite, shake 0.5s 3;
                            color: var(--or-metallise);
                        "></i>
                        <h4 class="text-white">Aucun article dans cette catégorie</h4>
                        <p class="text-muted">Revenez plus tard ou explorez nos autres catégories</p>
                    </div>
                </div>`;
        } else {
            container.innerHTML = newContainer.innerHTML;
        }
    }
    
    window.history.pushState({}, '', url.toString());
})
.catch(error => {
    console.error('Error:', error);
   
});
    }

    
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const subcategoryId = urlParams.get('subcategory');
        
        subcategoryItems.forEach(item => {
            item.classList.remove('active');
            if (item.dataset.subcategory === subcategoryId || 
                (!subcategoryId && item.dataset.subcategory === '')) {
                item.classList.add('active');
            }
        });
        
        loadArticles(subcategoryId);
    });


    

});



document.addEventListener('DOMContentLoaded', function() {
  
 

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            let quantity = parseInt(input.value);

          
            
            if (this.classList.contains('quantity-up')) {
                quantity = Math.min(99, quantity + 1);
            } else {
                quantity = Math.max(1, quantity - 1);
            }
            
            
            await updateQuantity(itemId, quantity);
        });
    });


    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', async function() {
            const itemId = this.dataset.itemId;
            let quantity = parseInt(this.value) || 1;
            quantity = Math.min(99, Math.max(1, quantity));
            await updateQuantity(itemId, quantity);
        });
    });
});

async function updateQuantity(itemId, newQuantity) {

      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    try {

        const response = await fetch(`/cart/${itemId}/quantity`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: newQuantity, update: true })
        });


        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
            
        }

       

        const data = await response.json();
        
        if (data.success) {
         
        
            document.querySelector(`.quantity-input[data-item-id="${itemId}"]`).value = newQuantity;
            
         
            const totalElement = document.querySelector(`.item-total[data-item-id="${itemId}"]`);
            const price = parseFloat(totalElement.dataset.price);
            const totalCart = document.querySelector('.cart-total');

            totalElement.textContent = (price * newQuantity).toFixed(2) + ' FCFA';
totalCart.textContent = new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'XAF',
    minimumFractionDigits: 0,
    maximumFractionDigits: 2
}).format(data.cart.total);


           Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Quantité mise à jour',
                text: data.message,
                showConfirmButton: false,
                timer: 3000,
                background: '#1a1a2e',
                color: '#ffffff',
                toast: true
            });
        

        } else {
           

             Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Erreur',
            text: data.message,
            showConfirmButton: false,
            timer: 2000,
            background: '#1a1a2e',
            color: '#ffffff',
            toast: true
        });
        }
    } catch (error) {

         console.error('Erreur:', error);
        
         Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Erreur',
            text: error,
            showConfirmButton: false,
            timer: 2000,
            background: '#1a1a2e',
            color: '#ffffff',
            toast: true
        });
        
    }
}


document.querySelectorAll('.delete-item-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const itemId = this.dataset.itemId;
        const deleteRoute = this.dataset.route;
        
      
        Swal.fire({
            title: 'Confirmer la suppression',
            html: `<div style="color:var(--or);background:var;padding:1rem;border-radius:10px;border:1px solid var(--or)">
                     <p>Êtes-vous sûr de vouloir retirer cet article ?</p>
                     <small>Cette action est irréversible</small>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--or)',
            cancelButtonColor: '#ff4757',
            confirmButtonText: '<i class="fas fa-trash"></i> Oui, supprimer',
            cancelButtonText: '<i class="fas fa-times"></i> Annuler',
            background: 'transparent',
            customClass: {
                popup: 'futuristic-swal'
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(deleteRoute, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                       
                        const itemRow = document.querySelector(`[data-item-id="${itemId}"]`).closest('.row');
                        itemRow.style.animation = 'itemExit 0.5s ease forwards';
                        
                    
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.message || 'Article supprimé',
                                showConfirmButton: false,
                                timer: 2000,
                                background: '#1a1a2e',
                                color: '#ffffff',
                                toast: true
                            });

                            
                        setTimeout(() => {
                            itemRow.remove();
                         
                            document.getElementById('cart-total').textContent = 
                                parseFloat(data.cart.total).toFixed(2) + ' FCFA';
                           
                           
                            
                        }, 500);

                        setTimeout(() => window.location.reload(), 500);

                    }else{
                         Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'La suppression a échoué',
                        background: '#1a1a2e',
                        color: '#ffffff',
                        toast: true
                    });
                    
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'La suppression a échoué',
                        background: '#1a1a2e',
                        color: '#ffffff',
                        toast: true,
                    });
                }
            }
        });
    });
});


document.querySelectorAll('.add-to-favorite').forEach(btn => {
    btn.addEventListener('click', async function() {
        const articleId = this.dataset.articleId;
        const isFavorite = this.querySelector('i').classList.contains('like');
        const action = isFavorite ? 'remove' : 'add';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
       
        const icon = this.querySelector('i');
        this.disabled = true;
        icon.style.transform = 'scale(1.3)';
        
       
        if (isFavorite) {
            const { isConfirmed } = await Swal.fire({
                title: 'Retirer des favoris',
                html: `<div style="color:var(--or);background:var(--noir-profond);padding:1rem;border-radius:10px;border:1px solid var(--or)">
                         <p>Êtes-vous sûr de vouloir retirer cet article de vos favoris ?</p>
                         <small>Vous pourrez le rajouter plus tard</small>
                       </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--or)',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-heart-broken"></i> Oui, retirer',
                cancelButtonText: '<i class="fas fa-times"></i> Annuler',
                background: 'var(--noir-profond)',
                color: '#ffffff',
                customClass: {
                    popup: 'futuristic-swal'
                }
            });
            
            if (!isConfirmed) {
                this.disabled = false;
                icon.style.transform = '';
                return;
            }
        }
        
        try {
            const response = await fetch(`/favorites/${action}/${articleId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.success) {
               
                if (action === 'add') {
                    icon.classList.add('like');
                    icon.style.animation = 'heartBeat 0.6s';
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data.message || 'Ajouté aux favoris',
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#1a1a2e',
                        color: '#ffffff',
                        toast: true
                    });
                } else {
                    icon.classList.remove('like');
                    icon.style.animation = 'heartShrink 0.4s';
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: data.message || 'Retiré des favoris',
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#1a1a2e',
                        color: '#ffffff',
                        toast: true
                    });
                }
                
               
                const favCountElement = document.getElementById('favorites-count');
                if (favCountElement) {
                    favCountElement.textContent = data.favorites_count;
                    favCountElement.style.animation = 'bounce 0.5s';
                }
                
               
                setTimeout(() => {
                    icon.style.animation = '';
                    icon.style.transform = '';
                    this.disabled = false;
                    window.location.reload();
                }, 2000);
                
            } else {
                throw new Error(data.message || 'Action échouée');
            }
        } catch (error) {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Erreur',
                text: error.message,
                background: '#1a1a2e',
                color: '#ffffff',
                toast: true
            });
            this.disabled = false;
            icon.style.transform = '';
        }
    });
});



    document.addEventListener("DOMContentLoaded", function () {
  
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const articleId = this.getAttribute('id').replace('quantityModal', '').replace('varModal','');
            initModal(this,articleId);
        });
    });


     function initModal(modal, articleId) {
        initVariantSelectors(modal, articleId);
        initQuantityControls(modal, articleId);
         updateSelectedVariantsDisplay(modal, articleId);
        initValidation(modal, articleId);
    }

    
  const variantQuantities = {};

function initVariantSelectors(modal, articleId) {
    if (!variantQuantities[articleId]) {
        variantQuantities[articleId] = {
            variants: {},
            totalQuantity: parseInt(modal.querySelector(`.quantit-input[data-article-id="${articleId}"]`).value) || 1
        };
    }

    const selectedVariants = JSON.parse(modal.querySelector(`#selectedVariants${articleId}`).value) || {};

    modal.querySelectorAll('.variant-option, .color-option').forEach(option => {
        option.replaceWith(option.cloneNode(true));
    });

    modal.querySelectorAll('.variant-option, .color-option').forEach(option => {
        option.addEventListener('click', function (e) {
            e.stopPropagation();
            const type = this.dataset.type;
            const value = this.dataset.value;
            const key = `${type}_${value}`;
            const variants = variantQuantities[articleId].variants;
            const stive = this.closest('.stive');

            if (this.classList.contains('active')) {
                this.classList.remove('active');
                delete variants[key];
                stive?.querySelector('.variant-quantity-badge')?.remove();
            } else {
                this.classList.add('active');
                variants[key] = 1;
                updateVariantBadge(stive, 1);
            }

            updateSelectedVariantsDisplay(modal, articleId);
        });

        const type = option.dataset.type;
        const value = option.dataset.value;
        if (selectedVariants[type] && 
            (Array.isArray(selectedVariants[type]) ? 
                selectedVariants[type].includes(value) : 
                selectedVariants[type] === value)) {
            option.classList.add('active');
            const key = `${type}_${value}`;
            variantQuantities[articleId].variants[key] = variantQuantities[articleId].totalQuantity;
            const stive = option.closest('.stive');
            updateVariantBadge(stive, variantQuantities[articleId].totalQuantity);
        }
    });
}



function updateVariantBadge(element, quantity) {
    const container = element.closest('.stive') || element;
    let badge = container.querySelector('.variant-quantity-badge');

    if (quantity > 0) {
        if (!badge) {
            badge = document.createElement('div');
            badge.className = 'variant-quantity-badge';
            container.appendChild(badge);
        }
        badge.textContent = quantity;
        badge.style.display = 'flex';
    } else if (badge) {
        badge.remove();
    }
}


function updateSelectedVariants(modal, articleId) {
    const selectedVariants = {
        sizes: [],
        colors: [],
        materials: []
    };
    
  
    const variantsData = variantQuantities[articleId]?.variants || {};
    
  
    for (const [key, quantity] of Object.entries(variantsData)) {
        if (quantity > 0) { 
            const [type, value] = key.split('_');
            if (type && value && selectedVariants[type] !== undefined) {
                selectedVariants[type].push(value);
            }
        }
    }
    
    modal.querySelector(`#selectedVariants${articleId}`).value = JSON.stringify(selectedVariants);
    return selectedVariants;
}



function updateSelectedVariantsDisplay(modal, articleId) {
    const displayContainer = modal.querySelector('.selected-variants-display');
    const variants = variantQuantities[articleId]?.variants || {};
    const noSelectionElement = displayContainer.querySelector('.no');
    
    if (Object.keys(variants).length === 0) {
        noSelectionElement.classList.remove('d-none');
        displayContainer.querySelector('.selected-variants-grid').innerHTML = '';
        return;
    }
    
    noSelectionElement.classList.add('d-none');
    let html = '<div class="selected-variants-grid">';

    const groupedVariants = {};
    for (const [key, quantity] of Object.entries(variants)) {
        const [type, value] = key.split('_');
        if (!groupedVariants[type]) groupedVariants[type] = [];
        groupedVariants[type].push({value, quantity});
    }


    if (groupedVariants.sizes && groupedVariants.sizes.length > 0) {
        const sizeValues = groupedVariants.sizes.map(item => item.value).join(', ');
        const totalQuantity = groupedVariants.sizes.reduce((sum, item) => sum + item.quantity, 0);
        
        html += `
            <div class="variant-display">
                <span class="variant-label">Tailles:</span>
                <span class="variant-value">${sizeValues}</span>
                <span class="variant-quantity d-none">${totalQuantity}</span>
                <button style="background: var(--bs-red); border:none;width: 24px;
  height: 24px;" class="btn btn-outline-danger btn-sm remove-variant-btn" 
                        data-type="sizes" data-all="true">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>`;
    }
    
  
    if (groupedVariants.materials && groupedVariants.materials.length > 0) {
        const materialValues = groupedVariants.materials.map(item => item.value).join(', ');
        const totalQuantity = groupedVariants.materials.reduce((sum, item) => sum + item.quantity, 0);
        
        html += `
            <div class="variant-display">
                <span class="variant-label">Matières:</span>
                <span class="variant-value">${materialValues}</span>
                <span class="variant-quantity d-none">${totalQuantity}</span>
                <button style="background: var(--bs-red); border:none;width: 24px;
  height: 24px;" class="btn btn-sm btn-outline-danger remove-variant-btn" 
                        data-type="materials" data-all="true">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>`;
    }
    
    if (groupedVariants.colors && groupedVariants.colors.length > 0) {
        html += `<div class="color-variants-group">`;
        html += `<span class="variant-label">Couleurs:</span>`;
        html += `<div class="color-variants-list">`;
        
        groupedVariants.colors.forEach(({value, quantity}) => {
            html += `
                <div class="color-variant-item">
                    <span class="color-preview" style="background-color:${value}"></span>
                    <span class="variant-quantity d-none">${quantity}</span>
                    <button style="background: var(--bs-red); border:none;width: 24px;
  height: 24px;" class="btn btn-sm btn-outline-danger remove-variant-btn" 
                            data-type="colors" data-value="${value}">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>`;
        });
        
        html += `</div></div>`;
    }
    
    html += '</div>';
    displayContainer.querySelector('.selected-variants-grid').innerHTML = html;

    displayContainer.querySelectorAll('.remove-variant-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const type = this.dataset.type;
            const value = this.dataset.value;
            const removeAll = this.dataset.all === 'true';

            if (removeAll) {
              
                modal.querySelectorAll(`[data-type="${type}"]`).forEach(option => {
                    option.classList.remove('active');
                    const stive = option.closest('.stive');
                    stive?.querySelector('.variant-quantity-badge')?.remove();
                    
                    const optionValue = option.dataset.value;
                    delete variantQuantities[articleId].variants[`${type}_${optionValue}`];
                });
            } else {
              
                delete variantQuantities[articleId].variants[`${type}_${value}`];
                
                modal.querySelectorAll(`[data-type="${type}"][data-value="${value}"]`).forEach(option => {
                    option.classList.remove('active');
                    const stive = option.closest('.stive');
                    stive?.querySelector('.variant-quantity-badge')?.remove();
                });
            }

            updateSelectedVariantsDisplay(modal, articleId);
        });
    });
}

function initQuantityControls(modal, articleId) {
    
    const quantityInput = modal.querySelector(`.quantit-input[data-article-id="${articleId}"]`);
    const increaseBtn = modal.querySelector(`.quantit-up[data-article-id="${articleId}"]`);
    const decreaseBtn = modal.querySelector(`.quantit-down[data-article-id="${articleId}"]`);
const isUpdate = modal.querySelector('.update-cart-btn') !== null;
const itemId = isUpdate ? modal.querySelector('.update-cart-btn').dataset.itemId : null;

const newIncreaseBtn = increaseBtn.cloneNode(true);
const newDecreaseBtn = decreaseBtn.cloneNode(true);

increaseBtn.replaceWith(newIncreaseBtn);
decreaseBtn.replaceWith(newDecreaseBtn);



    function updateTotalQuantity(newQuantity) {
        newQuantity = Math.max(1, Math.min(99, newQuantity));
        quantityInput.value = newQuantity;
        variantQuantities[articleId].totalQuantity = newQuantity;

      
        for (const key in variantQuantities[articleId].variants) {
            variantQuantities[articleId].variants[key] = newQuantity;
        }

        modal.querySelectorAll('.variant-option.active, .color-option.active').forEach(option => {
            updateVariantBadge(option, newQuantity);
        });

        updateSelectedVariantsDisplay(modal, articleId);
        updatePrices(modal, articleId);
    }



     
    
    newIncreaseBtn.addEventListener('click', () => updateTotalQuantity(parseInt(quantityInput.value) + 1));
    newDecreaseBtn.addEventListener('click', () => updateTotalQuantity(parseInt(quantityInput.value) - 1));
    quantityInput.addEventListener('input', () => updateTotalQuantity(parseInt(quantityInput.value) || 1));
    
 
    updateTotalQuantity(parseInt(quantityInput.value) || 1);
    updateSelectedVariantsDisplay(modal, articleId);
}

function updatePrices(modal, articleId) {
    const priceElement = modal.querySelector('.totalArticle');
    const basePrice = parseFloat(priceElement.getAttribute('data-base-price'));
    const cartTotalElement = modal.querySelector(`.cart-total${articleId}`);
    const cartTotal = parseFloat(cartTotalElement.getAttribute('data-total-price'));
    const quantity = variantQuantities[articleId].totalQuantity;

    const totalPrice = (basePrice * quantity).toFixed(2);
    priceElement.textContent = `${totalPrice} FCFA`;

    const newCartTotal = parseFloat(cartTotal) + parseFloat(totalPrice);
    cartTotalElement.textContent = new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(newCartTotal) + ' FCFA';
}
       
        


function initValidation(modal, articleId) {
    const button = modal.querySelector(`.add-to-cart-btn, .update-cart-btn`);
    if (!button) return;

    const quantityInput = modal.querySelector(`.quantit-input[data-article-id="${articleId}"]`);
    const isUpdate = button.classList.contains('update-cart-btn');
    const itemId = button.dataset.itemId;

    button.addEventListener('click', async function() {
        const quantity = parseInt(quantityInput.value) || 1;

        const sizeOptions = modal.querySelector('[data-type="sizes"]');
        if (sizeOptions && !modal.querySelector('[data-type="sizes"].active')) {
            await showInfoAlert('Sélection requise', 'Veuillez sélectionner une taille avant de continuer');
            toggleButtonState(button, false);
            return;
        }

        toggleButtonState(button, true);

        try {
       
            const selectedVariants = updateSelectedVariants(modal, articleId);
            const customMessage = modal.querySelector('.custom-message')?.value || '';
            const { form, variantMessageHTML } = prepareVariantData(modal, articleId, quantity, selectedVariants, customMessage);

     
          
           
            
await showConfirmationDialog(
    'Confirmation',
    variantMessageHTML, 
   isUpdate ? 'question' : 'info', 
    isUpdate, 
    itemId, 
    articleId, 
    modal,
    form
);




        } catch (error) {
            console.error('Erreur:', error);
            if (error.message !== 'ACTION_CANCELLED') {
                await showErrorAlert('Erreur', error.message || "Une erreur est survenue");
            }
        }
    });
}



function toggleButtonState(button, isLoading) {
    button.disabled = isLoading;
    if (isLoading) {
        button.dataset.originalHtml = button.innerHTML;
        button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${button.classList.contains('update-cart-btn') ? 'Mise à jour...' : 'Ajout en cours...'}`;
    } else {
        button.innerHTML = button.dataset.originalHtml || button.innerHTML;
    }
}

async function showErrorAlert(title, text) {
  const result =  await Swal.fire({
        icon: 'error',
        title,
        text,
        background: '#1a1a2e',
        color: '#ffffff',
        toast: true,
        position: 'top-end',
        showConfirmButton: true,
        timer: 3000
    });

    if(result.isConfirmed) {
        window.location.reload();
    }

}
 
async function showInfoAlert(title, text) {
    const result = await Swal.fire({

        icon: 'info',
        title,
        text,
        background: '#1a1a2e',
        color: '#ffffff',
        toast: true,
        position: 'top-end',
        showConfirmButton: true,
    });

   

}

function prepareVariantData(modal, articleId, quantity, selectedVariants, customMessage) {
    const form = document.createElement('form');
    form.id = 'cartForm';
    form.style.display = 'none';
    
    addHiddenInput(form, 'quantity', quantity);
    if (customMessage) {
        addHiddenInput(form, 'custom_message', customMessage);
    }
    
    const variantQuantitiesData = variantQuantities[articleId]?.variants || {};
    

    if (selectedVariants.sizes && selectedVariants.sizes.length > 0) {
        const sizesQuantities = {};
        selectedVariants.sizes.forEach(size => {
            sizesQuantities[size] = variantQuantitiesData[`sizes_${size}`] || 1;
        });
        addHiddenInput(form, 'variants[sizes]', JSON.stringify(selectedVariants.sizes));
        addHiddenInput(form, 'variant_quantities[sizes]', JSON.stringify(sizesQuantities));
    } else {
        addHiddenInput(form, 'variants[sizes]', JSON.stringify([]));
        addHiddenInput(form, 'variant_quantities[sizes]', JSON.stringify({}));
    }
 
    if (selectedVariants.colors && selectedVariants.colors.length > 0) {
        const colorsQuantities = {};
        selectedVariants.colors.forEach(color => {
            colorsQuantities[color] = variantQuantitiesData[`colors_${color}`] || 1;
        });
        addHiddenInput(form, 'variants[colors]', JSON.stringify(selectedVariants.colors));
        addHiddenInput(form, 'variant_quantities[colors]', JSON.stringify(colorsQuantities));
    } else {
        addHiddenInput(form, 'variants[colors]', JSON.stringify([]));
        addHiddenInput(form, 'variant_quantities[colors]', JSON.stringify({}));
    }

    if (selectedVariants.materials && selectedVariants.materials.length > 0) {
        const materialsQuantities = {};
        selectedVariants.materials.forEach(material => {
            materialsQuantities[material] = variantQuantitiesData[`materials_${material}`] || 1;
        });
        addHiddenInput(form, 'variants[materials]', JSON.stringify(selectedVariants.materials));
        addHiddenInput(form, 'variant_quantities[materials]', JSON.stringify(materialsQuantities));
    } else {
        addHiddenInput(form, 'variants[materials]', JSON.stringify([]));
        addHiddenInput(form, 'variant_quantities[materials]', JSON.stringify({}));
    }
    
    let variantMessageHTML = generateConfirmationHTML(selectedVariants, variantQuantitiesData, quantity, customMessage);
    
    return { form, variantMessageHTML };
}

function addHiddenInput(form, name, value) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    form.appendChild(input);
}

function generateConfirmationHTML(selectedVariants, variantQuantities, totalQuantity, customMessage) {
    let html = '<div class="text-start">';
    html += '<p class="mb-2">Options sélectionnées :</p><ul class="list-unstyled">';

    if (selectedVariants.sizes && selectedVariants.sizes.length > 0) {
        html += `<div class="d-flex"><li class="mb-2"><strong class="me-2">Tailles:</strong></li>`;
        selectedVariants.sizes.forEach(size => {
            const qty = variantQuantities[`sizes_${size}`] || 1;
            html += `
                <li class="d-flex align-items-center mb-1 ps-3">
                    <span class="me-2">${size}</span>
                  
                </li>`;
               
        });
    } html += `</div>`


    if (selectedVariants.colors && selectedVariants.colors.length > 0) {
        html += `<li class="mb-2"><strong class="me-2">Couleurs:</strong></li>`;
        selectedVariants.colors.forEach(color => {
            const qty = variantQuantities[`colors_${color}`] || 1;
            html += `
                <li class="d-flex align-items-center mb-2 ps-3">
                    <span class="color-preview me-2" style="background-color:${color}"></span>
                    <span class="me-2">${color}</span>
              
                </li>`;
        });
    }

 
    if (selectedVariants.materials && selectedVariants.materials.length > 0) {
        html += `<div class="d-flex"> <li class="mb-2"><strong class="me-2">Matériaux:</strong></li>`;
        selectedVariants.materials.forEach(material => {
            const qty = variantQuantities[`materials_${material}`] || 1;
            html += `
                <li class="d-flex align-items-center mb-2 ps-3">
                    <span class="me-2">${material}</span>
                </li>`;
        });
         html += `</div>`
    }

    if (!selectedVariants.sizes && !selectedVariants.colors && !selectedVariants.materials) {
        html += '<li>Aucune option sélectionnée</li>';
    }

    html += `</ul><p class="mt-3"><strong>Quantité totale :</strong> ${totalQuantity}</p>`;

    if (customMessage) {
        html += `
            <div class="mt-3">
                <strong>Votre message :</strong>
                <p class="bg-dark p-2 rounded mt-1">${customMessage}</p>
            </div>`;
    }

    return html;
}

async function showConfirmationDialog(title, html, icon, isUpdate, itemId, articleId,modal, form) {
    return await Swal.fire({
        icon,
        title,
        html,
        background: 'var(--bs-dark)',
        color: '#ffffff',
        showCancelButton: true,
        confirmButtonText: 'Confirmer',
        cancelButtonText: 'Annuler',
        allowOutsideClick: false,
        focusConfirm: true,
        customClass: {
            popup: 'swal2-modal-overlay',
            container: 'swal2-container-override'
        },
        willOpen: () => {
            document.querySelectorAll('.swal2-container')
                .forEach(el => el.style.zIndex = '99999');
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
               
                document.body.appendChild(form);
                
           
                const response = await submitForm(form, isUpdate, itemId, articleId);
                await handleResponse(response, isUpdate);
                return response;
            } catch (error) {
                console.error('Erreur:', error);
                await showErrorAlert('Erreur', error.message || "Une erreur est survenue");
                throw error;
            } finally {

                if (form.parentNode) {
                    form.parentNode.removeChild(form);
                }
            }
        } else {
            const button = modal.querySelector(`.add-to-cart-btn, .update-cart-btn`);
            if (button) {
                button.innerHTML = button.dataset.original;
                button.disabled = false;
            }
            return null;
        }
    });
}


async function submitForm(form, isUpdate, itemId, articleId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const url = isUpdate ? `/cart/${itemId}` : `/cart/add/${articleId}`;
    

    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = isUpdate ? 'PUT' : 'POST';
    form.appendChild(methodInput);
    
 
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);
    
    form.method = 'POST';
    form.action = url;
    
    const response = await fetch(url, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'Accept': 'application/json'
        }
    });

    if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || `Erreur HTTP! statut: ${response.status}`);
    }

    return response.json();
}



async function handleResponse(response, isUpdate) {
    if (!response.success) {
        throw new Error(response.message);
    }

    return Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: isUpdate ? 'Mis à jour !' : 'Ajouté !',
        text: isUpdate ? 'Votre panier a été mis à jour' : 'Article ajouté au panier',
        timer: 1500,
        showConfirmButton: false,
        background: '#1a1a2e',
        color: '#ffffff',
        toast: true,
        timerProgressBar: true
    }).then(() => {
        location.reload();
    });
}



});

document.addEventListener("DOMContentLoaded", function () {

const basePriceInput = document.getElementById('base_price') ?? null;
const priceDisplay = document.getElementById('priceDisplay') ?? null;
const priceIncrementBtn = document.querySelector('.price-increment') ?? null;
const priceDecrementBtn = document.querySelector('.price-decrement') ?? null;
let invalidFeedback = basePriceInput ? basePriceInput.parentElement.querySelector('.invalid-feedback') : null;




    function updatePriceDisplay() {
        const price = parseInt(basePriceInput.value) || 0;
        priceDisplay.textContent = price.toLocaleString('fr-FR');
        validatePrice();
    }

    function validatePrice() {
        const price = parseInt(basePriceInput.value) || 0;
        const min = parseInt(basePriceInput.min) || 100;
        const max = parseInt(basePriceInput.max) || 1000000;

        if (price < min || price > max || isNaN(price)) {
            basePriceInput.classList.add('is-invalid');
            invalidFeedback.style.display = 'block';
            return false;
        } else {
            basePriceInput.classList.remove('is-invalid');
            invalidFeedback.style.display = 'none';
            return true;
        }
    }

    if(priceIncrementBtn){

    priceIncrementBtn.addEventListener('click', function() {
        let currentValue = parseInt(basePriceInput.value) || 0;
        const step = parseInt(basePriceInput.step) || 100;
        const max = parseInt(basePriceInput.max) || 1000000;
        
        if (currentValue + step <= max) {
            basePriceInput.value = currentValue + step;
            updatePriceDisplay();
        }
    });
}

  if(priceDecrementBtn){
  
    priceDecrementBtn.addEventListener('click', function() {
        let currentValue = parseInt(basePriceInput.value) || 0;
        const step = parseInt(basePriceInput.step) || 100;
        const min = parseInt(basePriceInput.min) || 100;
        
        if (currentValue - step >= min) {
            basePriceInput.value = currentValue - step;
            updatePriceDisplay();
        }
    });


}

if( basePriceInput){

    basePriceInput.addEventListener('input', function() {
        let cleanedValue = this.value.replace(/[^0-9]/g, '');
        
    
        if (!cleanedValue) {
            cleanedValue = this.min;
        }
  
        this.value = cleanedValue;
        updatePriceDisplay();
    });



    basePriceInput.addEventListener('blur', function() {
        const price = parseInt(this.value) || 0;
        const min = parseInt(this.min) || 100;
        
       
        if (price < min) {
            this.value = min;
        }
        
   
      
        
        updatePriceDisplay();
    });

}
  
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    if(description){
    description.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
}





const imageUploadArea = document.querySelector('.image-upload-frame');
const fileInput = document.getElementById('images');
const imagePreview = document.getElementById('imagePreview');
const imageError = document.getElementById('imageError');


let currentFiles = [];

if(imageUploadArea){

imageUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    imageUploadArea.classList.add('dragover');
});

imageUploadArea.addEventListener('dragleave', () => {
    imageUploadArea.classList.remove('dragover');
});

imageUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    imageUploadArea.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

imageUploadArea.addEventListener('click', () => {
    fileInput.value = ''; 
    fileInput.click();
});


fileInput.addEventListener('change', function() {
    if (this.files && this.files.length > 0) {
        handleFiles(this.files);
    }
});

function handleFiles(files) {
    if (!files || files.length === 0) return;
    
  
    if (fileInput.files.length !== currentFiles.length) {
        currentFiles = [];
        imagePreview.innerHTML = '';
    }

    document.getElementById('imageError').classList.add('d-none');
    

    const allowedFiles = Array.from(files)
        .filter(file => file.type.match('image.*'))
        .slice(0, 10 - currentFiles.length);
    

    if (allowedFiles.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Format non supporté',
            text: 'Seules les images sont acceptées'
        });
        return;
    }


    currentFiles = [...currentFiles, ...allowedFiles];
    updateFileInput();
    

    allowedFiles.forEach((file) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'image-preview-item';
            previewItem.innerHTML = `
                <div class="preview-image-container">
                    <img src="${e.target.result}" class="img-preview">
                    <div class="preview-overlay">
                        <button type="button" class="btn btn-danger btn-sm remove-image">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
         
            imagePreview.insertBefore(previewItem, imagePreview.firstChild);
            
     
            previewItem.querySelector('.img-preview').addEventListener('click', function() {
                Swal.fire({
                    imageUrl: e.target.result,
                    imageAlt: 'Aperçu image',
                    showConfirmButton: false,
                    background: 'rgba(0,0,0,0.9)',
                    backdrop: 'rgba(0,0,0,0.7)',
                    width: '50%',
                    padding: '0'
                });
            });
            
          
            previewItem.querySelector('.remove-image').addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                Swal.fire({
                    title: 'Supprimer cette image?',
                    text: "Cette action est irréversible",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        previewItem.classList.add('removing');
                        setTimeout(() => {
                          
                            currentFiles = currentFiles.filter(f => f !== file);
                            updateFileInput();
                            previewItem.remove();
                            
                         
                            if (imagePreview.children.length === 0) {
                                document.getElementById('imageError').classList.remove('d-none');
                            }
                            updatePreviewImage();
                        }, 300);
                    }
                });
            });
        };
        
        reader.readAsDataURL(file);
    });
    

    if (files.length > allowedFiles.length) {
        Swal.fire({
            icon: 'info',
            title: 'Limite atteinte',
            text: 'Seules les 10 premières images ont été sélectionnées'
        });
    }
    
    updatePreviewImage();
}

function updateFileInput() {
   
    const dataTransfer = new DataTransfer();
    currentFiles.forEach(file => dataTransfer.items.add(file));
    

    fileInput.files = dataTransfer.files;
 
    if (currentFiles.length > 0) {
        fileInput.setCustomValidity('');
    } else {
        fileInput.setCustomValidity('Veuillez ajouter au moins une image');
    }
}

function updatePreviewImage() {
    const imageCount = currentFiles.length;
    document.getElementById('preview-image-count').textContent = imageCount;
}


updatePreviewImage();

}





            
});




document.addEventListener('DOMContentLoaded', function() {
    const carouselImages = document.querySelectorAll('.product-carousel .carousel-item img');
    
    carouselImages.forEach(img => {
        img.addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                imageUrl: this.src,
                imageAlt: this.alt || 'Aperçu image',
                imageWidth: '80%',
                imageHeight: 'auto',
                showConfirmButton: false,
                background: 'rgba(0,0,0,0.9)',
                backdrop: 'rgba(0,0,0,0.8)',
                width: '90%',
                padding: '0',
                showCloseButton: true,
                closeButtonHtml: '&times;',
                customClass: {
                    container: 'image-preview-container',
                    popup: 'image-preview-popup',
                    closeButton: 'image-preview-close'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut'
                }
            });
        });
        
       
        img.style.cursor = 'zoom-in';
    });
});





function getCategoryIcon(categoryName) {
    const iconMap = {

 
    'Homme': 'fas fa-male',
    'Femme': 'fas fa-female',
    'Enfant': 'fas fa-child',
    'Durable': 'fas fa-leaf',
    'Collaborations': 'fas fa-handshake',

    'Vêtements': 'fas fa-tshirt',
    'Chaussures': 'fas fa-shoe-prints',
    'Accessoires': 'bx bx-shopping-bag',
    'Sport': 'fas fa-running',
    'Équipement outdoor': 'fas fa-mountain',
    'Lingerie': 'fas fa-tshirt',
    'Maillots de bain': 'fas fa-person-swimming',
    'Haute Couture': 'fas fa-crown', 
    'École': 'fas fa-school',

  
    'Vestes': 'fas fa-user-tie', 
    'Hauts': 'fas fa-tshirt',
    'Pantalons': 'fas fa-user', 
    'Robes': 'fas fa-person-dress', 
    'Jupes': 'fas fa-person-dress', 
    'T-shirts': 'fas fa-tshirt',
    'Chemises': 'fas fa-shirt',
    'Pulls': 'fas fa-sweater',
    'Blazers': 'fas fa-user-tie',
    'Vestes en cuir': 'fas fa-jacket',
    'Short de sport': 'fas fa-running',

    'Chaussures de ville': 'fas fa-shoe-prints',
    'Tennis': 'fas fa-person-running',
    'Sandales': 'bx bx-walk',
    'Escarpins': 'fas fa-shoe-prints', 
    'Baskets': 'fas fa-shoe-prints',
    'Bottes': 'fas fa-shoe-prints', 
    'Talons': 'fas fa-shoe-prints', 

    
    'Montres': 'fas fa-clock',
    'Parfums': 'fas fa-spray-can',
    'Ceintures': 'fas fa-grip-lines',
    'Chapeaux': 'fas fa-hat-cowboy',
    'Cravates': 'fas fa-user-tie',
    'Portefeuilles': 'fas fa-wallet',
    'Bijoux': 'fas fa-gem',
    'Sacs': 'fas fa-shopping-bag',
    'Écharpes': 'fas fa-mitten',
    'Lunettes': 'fas fa-glasses',
    'Colliers': 'fas fa-gem',
    'Bracelets': 'fas fa-gem',
    'Techwear': 'fas fa-microchip',

};
    
 
    if (iconMap[categoryName]) {
        return iconMap[categoryName];
    }
    
   
    const lowerName = categoryName.toLowerCase();
    for (const [key, value] of Object.entries(iconMap)) {
        if (lowerName.includes(key.toLowerCase())) {
            return value;
        }
    }
    
    
    return 'fas fa-tag';
}