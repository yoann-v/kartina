//Selection des onglets de finition, cadre et format 

var currentStep = 'format';
var nextStep = 'finition';
var previousStep = '';

function selectionStep(fonction, nom, step) {
  document.getElementById(fonction + '-' + nom).addEventListener('click', truc.bind(null,nom,step))
}

function truc(nom, step) {

  if(step == "cadre" && document.getElementById("tirage-sur-papier-photo") == undefined){
  }else if (step == "cadre" && document.getElementById("tirage-sur-papier-photo").checked){
    return
  }

  let selects = document.getElementById('select').children
  let titres = document.getElementById('titre').children
  let previous = document.getElementById('previous').children
  let checks = document.getElementById('check').children
  currentStep = step;
  
  for (let prev of previous) {
    prev.style.display = 'none'
  }

  if (currentStep == 'format' || currentStep == 'checkout') {

  } else {
    document.getElementById('previous-' + step).style.display = 'block'

  }

  // On change les variables step
  if (currentStep == 'finition') {
    nextStep = 'cadre';
    previousStep = 'format';

  } else if (currentStep == 'cadre') {

    previousStep = 'finition';
    nextStep = 'checkout';

  } else if (currentStep == 'format') {
    nextStep = 'finition';
    previousStep = '';
  }

  for (let select of selects) {
    select.style.display = 'none'
  }

  for (let titre of titres) {
    titre.style.borderBottomColor = 'transparent'
  }

  for (let check of checks) {
    check.style.display = 'none'

  }

  for (let check of checks) {
    check.style.display = 'none'

  }


  if (step == 'checkout') {

    document.getElementById(nom).style.display = 'block'
    document.getElementById('check-' + step).style.display = 'block'
  } else {

    document.getElementById('titre-' + step).style.borderBottomColor = 'black'
    document.getElementById('check-' + step).style.display = 'block'
    document.getElementById(step).style.display = 'block'
  }


}

selectionStep('titre', 'format', 'format')

// API Personnalisation

function recupAPI(URL, param) {

  axios.get(`./personnalisation.php?${URL}`)
    .then(response => {
      let results = response.data;

      // Affichage de la div des finitions
      if (param == "format") {

        document.getElementById('finition').innerHTML = '';

        let finition = '<ul>';

        for (result of results) {

          finition += `
            <li>
            <input type="radio" name="filters[finition]" id="${changeChar(result.finition)}" value="${result.id}" data-prix = "${result.pourcentage}">
            <img src="./assets/image/finition/${changeChar(result.finition)}.jpg" alt="">
            <label for="${changeChar(result.finition)}">${firstCharUpperCase(result.finition)}</label>
            </li>
            `;
        }

        finition += '</ul>';
        document.getElementById('finition').innerHTML += finition;

        //Affichage de la div des cadres
      } else if (param == "finition") {

        //On vérifier que ça ne soit pas l'option 5 qui est sélectionné. Sinon on bloque l'accès à la div cadre.
        if (Array.isArray(results)) {

          document.getElementById('cadre').innerHTML = '';

          let cadre = '<ul>';

          for (result of results) {

            cadre += `
              <li>
              <input type="radio" name="filters[cadre]" id="${changeChar(result.cadre)}" value="${result.id}" data-prix = "${result.pourcentage}">
              <img src="./assets/image/cadre/${changeChar(result.cadre)}.jpg" alt="">
              <label for="${changeChar(result.cadre)}">${firstCharUpperCase(result.cadre)}</label>
              </li>
              `;
          }

          cadre += '</ul>';
          document.getElementById('cadre').innerHTML += cadre;

          document.getElementById('titre-cadre').style.filter = "opacity(100%)";

        } else {
          document.getElementById('titre-cadre').style.filter = "opacity(30%)";
        }

      }
    })
}

let forms = document.getElementsByTagName('form')

for (let form of forms) {

  form.addEventListener('change', e => {

    let formData = new FormData(e.currentTarget); // Toutes les données du form
    let params = new URLSearchParams(formData); // Permet de générer une URL avec les données
    let toto = params.toString();
    option = e.target.name

    const regex = /(filters)|(_id)|(%5D)|(%5B)|\[|\]|/gm;
    const subst = ``;

    let mod = e.target.dataset.prix;
    let price = document.getElementById('price').dataset.prix;

    option = option.replace(regex, subst)
    if (option == 'format') {

      selectionStep('titre', 'finition', 'finition')
      selectionStep('check', 'format', 'finition')
      selectionStep('previous', 'finition', 'format')

      prix = calculPrice(price, mod)

      document.getElementById('price').innerHTML = prix.toFixed(2) + '€';

    } else if (option == 'finition') {

      prixF = calculPrice(prix, mod)

      document.getElementById('price').innerHTML = prixF.toFixed(2) + '€';

      if (e.target.value == 5) {

        selectionStep('check', 'finition', 'checkout')
        document.getElementById('previous-finition').style.display = "block"
        for (el of document.getElementsByName('filters[cadre]')) {
          el.checked = false
        }
        selectionStep('previous', 'cadre', 'finition')

      } else {

        document.getElementById('check-checkout').style.display = "none"
        document.getElementById('check-finition').style.display = "block"
        document.getElementById('previous-finition').style.display = "block"
        selectionStep('titre', 'cadre', 'cadre')
        selectionStep('check', 'finition', 'cadre')
        selectionStep('previous', 'cadre', 'finition')

      }


    } else if (option == 'cadre') {

      let prixC = calculPrice(prixF, mod)

      document.getElementById('price').innerHTML = prixC.toFixed(2) + '€';

      selectionStep('check', 'cadre', 'checkout')

    }

    if (params.toString() != '') {
      recupAPI(toto, option)
    }

  })
}

//Changement de char
function changeChar(string) {

  let result = string.replace(/ /g, '-');

  return result;
}

function firstCharUpperCase(string) {
  return string.charAt(0).toUpperCase() + string.slice(1)
}

//Calcul prix 

function calculPrice(prixInit, mod) {
  prixInit = parseFloat(prixInit);
  mod = parseFloat(mod);
  mod = 1 + mod / 100;

  let price = prixInit * mod;
  return price;

}

// Carousel des miniatures









