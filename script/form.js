// Fonction récupération continent pour récupérer la liste de pays associée.

async function getAPIc(link) {
    console.log(link);
    fetch(link).then
        (function (results) {
            results.json().then(function (country) {
                console.log(country);
                setHtml(country)

            })
        })
};

function setHtml(country) {
    let str = '';

    for (const c of country) {
        str += `
        <option value="${c.translations.fr}">${c.translations.fr}</option>
        `
    }
    document.getElementById('country').innerHTML = str
};

function getURLc() {
    let region = document.getElementById('region').value
    return `https://restcountries.eu/rest/v2/region/${region}`
};

document.getElementById('region').addEventListener('change', function () {
    getAPIc(getURLc(region))
});

//Pour des raisons pratiques, les seules adresses vérifiées sont celle de la France.

async function getAPIpostal(link) {
    if(link !== false){
        fetch(link).then
        (function (results) {
            results.json().then(function (x) {
                console.log(x.features);
                setHtmlpost(x.features);
            })
        })
    }
};



function setHtmlpost(x) {

    let str = '';
    for (const c of x) {
        str += `
        <li>${c.properties.label}</li>      
        `
    }
    document.getElementById('adresseComplete').innerHTML = str

};




function getURL() {
    let adress = document.getElementById('address').value;
    const regex = /['_^$ \-]/gm;
    const subst = `+`;

    const result = adress.replace(regex, subst);

    if(result !== ""){
        return `https://api-adresse.data.gouv.fr/search/?q=${result}`
    }else{
        return false;
    }
};



document.getElementById('address').addEventListener('keyup', function () {
    getAPIpostal(getURL());
});
document.getElementById('address').addEventListener('focus', function () {
    getAPIpostal(getURL());
});

document.getElementById('address').addEventListener('blur', function () {
    setTimeout(() => {
        document.getElementById('adresseComplete').innerHTML = "";
    }, 2000);
});


document.getElementById('adresseComplete').addEventListener('click', function (e) {

    let address = document.getElementById('address').value

    if (e.target.tagName === 'LI') {
        console.log(e.target.innerHTML);
        document.getElementById('address').value = e.target.innerHTML;
        document.getElementById('adresseComplete').innerHTML = "";

        //On split la réponse de l'api pour pouvoir la rentrer correctement dans la bdd
        
            fetch(`https://api-adresse.data.gouv.fr/search/?q=${address}`).then(function (results) {
                results.json().then(function (x) {
                    let properties = x.features[0].properties;
                    console.log(properties.street);
                    
                    document.getElementById('housenumber').value = properties.housenumber;
                    document.getElementById('street').value = properties.street;
                    document.getElementById('city').value = properties.city;
                    document.getElementById('postcode').value = properties.postcode;
                })
            })
        
    }

});



document.getElementById('envoi').addEventListener('click', e => {
    
    if(bordCol(e)===false){
        e.preventDefault();
        console.log("manque des infos");   
    }
});

function bordCol(e) {

    let j = 0
    let input = document.getElementById('inscription').getElementsByTagName('input')

    let fName = document.getElementById('firstname').value
    let lName = document.getElementById('lastname').value
    let pwd = document.getElementById('pswd').value
    let mdp = document.getElementById('mdp').value
    let phone = document.getElementById('phone').value
    let mail = document.getElementById('mail').value

    //Regex prenom

    const regexFName = /^[a-zA-ZÀ-ÖØ-öø-ÿ -']+$/g;
    let fN;
    while ((fN = regexFName.exec(fName)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (fN.index === regexFName.lastIndex) {
            regexFName.lastIndex++;
        }
        fN.forEach((match, groupIndex) => {
            console.log(`Found match, group firstname ${groupIndex}: ${match}`);
            j++
            console.log(j);
        });
    }

    //Regex nom

    const regexLName = /^[a-zA-ZÀ-ÖØ-öø-ÿ -']+$/g;
    let lN;
    while ((lN = regexLName.exec(lName)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (lN.index === regexLName.lastIndex) {
            regexLName.lastIndex++;
        }
        lN.forEach((match, groupIndex) => {
            console.log(`Found match, group lastname ${groupIndex}: ${match}`);
            j++
            console.log(j);
        });
    };

    // Regex password

    const regexPwd = /^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,32})\S$/gm;
    let pswd;

    if ((pswd = regexPwd.exec(pwd)) !== null) {
        pswd.forEach((match, groupIndex) => {
            console.log(`Found match, group pwd ${groupIndex}: ${match}`);
            j++
            console.log(j);
        });
    };

    if (mdp === pwd) {
        j++
    };


    //Regex phone

    const regexPhone = /\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/g;
    let p;
    while ((p = regexPhone.exec(phone)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (p.index === regexPhone.lastIndex) {
            regexPhone.lastIndex++;
        }
        p.forEach((match, groupIndex) => {
            console.log(`Found match, group phone ${groupIndex}: ${match}`);
            j++
            console.log(j);
        });
    };

    //Regex mail
    const regexMail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    let m;

    if ((m = regexMail.exec(mail)) !== null) {
        m.forEach((match, groupIndex) => {
            console.log(`Found match, group  mail ${groupIndex}: ${match}`);
        });
        j++
        console.log(j);
    };
let z = 0;
    for (let i = 0; i < 10; i++) {

        if (input[i].value == "") {
            input[i].style.border = "3px solid red";
            
            
        } else {
            input[i].style.border = "3px solid green";
            z++;
        }

    }
    if (z!==10){
        return false;
    }
};