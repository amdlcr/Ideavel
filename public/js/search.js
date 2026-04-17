const form = document.getElementById('searchForm');

const searchBtn = form.querySelector('button[name="btn_search"]');
const cleanBtn = form.querySelector('button[name="clean"]');

cleanBtn.addEventListener('click', () => {
    window.location.href = '/ideas'; 
});

searchBtn.addEventListener('click', async (e) => {
    e.preventDefault();

    const inputText = document.getElementById('search_input').value;
    const seletedField = document.getElementById('search_field').value;
    const formulario = document.getElementById('searchForm');

    if(inputText != "" && seletedField != "" ){
        formulario.submit();
        return;
    };

    if (inputText == ""){
        const errorDiv = document.getElementById('errorBox');
        errorDiv.textContent = "Debes escribir el texto que quieres buscar";
    }

      if (seletedField == ""){
        const errorDiv = document.getElementById('errorBox');
        errorDiv.textContent = "Elige una opcion de busqueda válida";
    }
});