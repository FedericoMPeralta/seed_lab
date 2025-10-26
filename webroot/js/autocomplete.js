function initMuestraAutocomplete(muestrasData) {
    const searchInput = document.getElementById('muestra-search');
    const hiddenInput = document.getElementById('muestra-id');
    const suggestionsDiv = document.getElementById('suggestions');
    
    if (!searchInput || !hiddenInput || !suggestionsDiv) return;
    
    searchInput.addEventListener('input', function() {
        const searchValue = this.value;
        suggestionsDiv.innerHTML = '';
        
        if (searchValue.length === 0) {
            hiddenInput.value = '';
            return;
        }
        
        const filtered = muestrasData.filter(m => m.codigo.includes(searchValue));
        
        if (filtered.length > 0) {
            filtered.slice(0, 10).forEach(muestra => {
                const div = document.createElement('div');
                div.textContent = muestra.codigo;
                div.className = 'suggestion-item';
                div.onclick = function() {
                    searchInput.value = muestra.codigo;
                    hiddenInput.value = muestra.id;
                    suggestionsDiv.innerHTML = '';
                };
                suggestionsDiv.appendChild(div);
            });
        } else {
            hiddenInput.value = '';
        }
    });
    
    document.addEventListener('click', function(e) {
        if (e.target !== searchInput) {
            suggestionsDiv.innerHTML = '';
        }
    });
}