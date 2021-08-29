function openMenu(event) {

    let parent = event.target.innerHTML


    let dispParent = document.getElementById("filtre" + parent)

    if (dispParent.style.display == "block") {
        dispParent.style.display = "none"
    } else {
        dispParent.style.display = "block"
    }
}

function firstCharUpperCase(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
}

function addButton(event) {

    let tag = event.currentTarget
    let filtre = tag.innerText;
    console.log(tag);



    if (tag.tagName === "LI") {

        let button = `<button><span>${firstCharUpperCase(tag.className)} : ${firstCharUpperCase(filtre)}</span><span>X</span></button
        `
        document.getElementById('filtre').innerHTML += button
    }


}

function closeButton(event) {
    let tag = event.target
    console.log(tag);

    if (tag.tagName == 'SPAN') {
        tag = tag.parentElement
        tag.remove()
    }
}

let theme = document.getElementsByClassName('theme');
for (let li of theme) {
    li.addEventListener("change", (event) => { addButton(event) })
}
let format = document.getElementsByClassName('format');
for (let li of format) {
    li.addEventListener("change", (event) => { addButton(event) })
}
let orientations = document.getElementsByClassName('orientation');
for (let li of orientations) {
    li.addEventListener("change", (event) => { addButton(event) })
}
let price = document.getElementsByClassName('prix');
for (let li of price) {
    li.addEventListener("change", (event) => { addButton(event) })
}



class Produit {
    constructor(photo){
        this.url = photo.url;
        this.artist_id = photo.artiste_id;
        this.theme_id = photo.theme_id;
       this.artist = firstCharUpperCase(photo.prenom) + ' ' + firstCharUpperCase(photo.nom);
        this.title = firstCharUpperCase(photo.titre);
        this.price = parseFloat(photo.prix);
        this.devise = '€';
        this.id = photo.photo_id;      
    }


    view() {

        let price = this.price.toFixed(2)
        let title = this.title.replace(/ /g, '-');
        return `       
            <article>
                <figure>
                    <div>
                    <a href="produit.php?photo=${title}&id=${this.id}"><img src="${this.url}"alt="${this.title}"></a>
                    
                    </div>
                    <figcaption>
                        <div>
                            <div>
                                <p><span><a href="">${this.artist},</a></span> <span><a href="produit.php?photo=${title}&id=${this.id}"> ${this.title}</a></span></p>
                                <p>Edition limitée</p>
                            </div>
                                <div><span>à partir de </span><span>${price} ${this.devise}</span></div>
                        </div>
                    </figcaption>
                </figure>
            </article>
        `;
    }
}



let forms = document.getElementsByTagName('form')

let concat = false;
let end = false;
for (let form of forms) {

    form.addEventListener('change', e => {

        let formData = new FormData(e.currentTarget); // Toutes les données du form
        let params = new URLSearchParams(formData); // Permet de générer une URL avec les données
        let toto = params.toString();
        console.log(params.toString());

        const regex = /(filters)|(_id)|(%5D)|(%5B)/gm;
        const subst = ``;

        // The substituted value will be contained in the result variable
        const result = toto.replace(regex, subst);

        newURL = 'http://localhost/projetfilrouge/catalogue.php?' + result;

        history.pushState(null, null, newURL);

        document.querySelector('#post-loading').hidden = false;

// On vérifie si on charge une nouvelle page ou si on initialise une nouvelle recherche.
        if (concat == false) {
            document.getElementById('photographies').innerHTML = ''
        }

        if(params.toString() != ''){
            recupAPI(params.toString(), 'photographies')
        }
    })
}


function recupAPI(URL, zone) {
    
    axios.get(`./photographies.php?${URL}`)
        .then(response => {
            let photos = response.data;
            console.log(photos);
                if(photos.length == 0){

                    document.getElementById(zone).innerHTML += '<div>La recherche n\'as pas abouti.</div>';
                    end = true;

                }else{
                    for (photo of photos) {
                        product = new Produit(photo);
                        document.getElementById(zone).innerHTML += product.view()
                        isLoading = false;

                    }
                }
        
            let loaders = document.querySelectorAll('.loader')
            loaders.forEach(loader => {
                loader.hidden = true;
            })
        })
}

let isLoading = false

document.addEventListener('scroll', e => {
    const el = e.target.scrollingElement;
    if (Math.abs(el.scrollHeight - el.scrollTop - el.clientHeight) < 1) {
        
        if (isLoading == false && end == false) {
            document.getElementById('offset').value++;
            document.querySelector('#loadPages').hidden = false;

            isLoading = true;

            for (let form of forms) {
                concat = true;
                form.dispatchEvent(new Event("change"));
                document.querySelector('#post-loading').hidden = true;
            }
        }
    }
})


