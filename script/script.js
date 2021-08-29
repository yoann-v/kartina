function change(nom,div,div2){
    document.getElementById('section').style.display = "block";
    var article = document.querySelectorAll('article');
    document.getElementById(div).style.backgroundColor = 'white';
    document.getElementById(div2).style.backgroundColor = 'silver';
    for(var i=0; i<article.length; i++){
        if(article[i].className == nom){
            article[i].style.display= "block";
            
        } else {
            article[i].style.display= "none";
        }
    }
}

