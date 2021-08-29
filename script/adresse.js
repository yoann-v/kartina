
//Pour des raisons pratiques, les seules adresses vérifiées sont celle de la France.

async function getAPIpostal(link,id) {
    if(link !== false){
        fetch(link).then
        (function (results) {
            results.json().then(function (x) {
                setHtmlpost(x.features,id);
            })
        })
    }
  
};

function setHtmlpost(x,id) {

    let str = '';
    for (const c of x) {
        str += `
        <li>${c.properties.label}</li>      
        `
    }
    document.getElementById(id).innerHTML = str

};


function getURL(id) {
    let adress = document.getElementById(id).value;
    const regex = /['_^$ \-]/gm;
    const subst = `+`;

    const result = adress.replace(regex, subst);
    if(result !== ""){
        return `https://api-adresse.data.gouv.fr/search/?q=${result}`
    }else{
        return false;
    }  
};
window.addEventListener('keydown', function(e) {
    console.log(e.key)
    if(e.key == "Enter"){
        e.preventDefault();
    }
})
document.getElementById('address').addEventListener('keyup', function () {
    getAPIpostal(getURL('address'),'adresseComplete');
});
document.getElementById('address').addEventListener('focus', function () {
    getAPIpostal(getURL('address'),'adresseComplete');
});

document.getElementById('address').addEventListener('blur', function () {
    setTimeout(() => {
        document.getElementById('adresseComplete').innerHTML = "";
    }, 2000);
});

document.getElementById('address2').addEventListener('keyup', function () {
    getAPIpostal(getURL('address2'),'adresseComplete2');
});
document.getElementById('address2').addEventListener('focus', function () {
    getAPIpostal(getURL('address2'),'adresseComplete2');
});

document.getElementById('address2').addEventListener('blur', function () {
    setTimeout(() => {
        document.getElementById('adresseComplete2').innerHTML = "";
    }, 2000);
});

function split(e,a,address,adresseComplete,housenumber,street,city,postcode){
    if (e.target.tagName === 'LI') {
        document.getElementById(address).value = e.target.innerHTML;
        document.getElementById(adresseComplete).innerHTML = "";
        let add = document.getElementById(address).value
        //On split la réponse de l'api pour pouvoir la rentrer correctement dans la bdd
        
            fetch(`https://api-adresse.data.gouv.fr/search/?q=${add}`).then(function (results) {
                results.json().then(function (x) {
                    
                    let properties = x.features[0].properties; 
                    if(properties.housenumber == undefined){
                        document.getElementById(housenumber).value = "";
                        document.getElementById(street).value = properties.name;
                    }else {
                        document.getElementById(housenumber).value = properties.housenumber;
                        document.getElementById(street).value = properties.street;
                    }
                    document.getElementById(city).value = properties.city;
                    document.getElementById(postcode).value = properties.postcode;
                    console.log(properties);
                    setTimeout(function () {document.getElementById(a).hidden = false} , 500);
                })
            })   
    }
}

document.getElementById('adresseComplete').addEventListener('click', function (e){
    split(e,'envoi1','address','adresseComplete','housenumber','street','city','postcode');
});

document.getElementById('adresseComplete2').addEventListener('click', function (e){
    split(e,'envoi2','address2','adresseComplete2','housenumber2','street2','city2','postcode2');
});



