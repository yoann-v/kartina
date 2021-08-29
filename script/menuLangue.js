document.getElementById('langue').addEventListener("click", function () {


    if (document.getElementById('ln').style.display == "none") {
        document.getElementById('ln').style.display = "flex"
        document.getElementById('langue').innerHTML = `        
        <img src="./assets/image/header/globe-solid.svg" alt="">
        `,
        document.getElementById('langue').style.backgroundColor = "white",
        document.getElementById('langue').style.padding = "10px",
        console.log();
        
        
    } else {
        document.getElementById('ln').style.display = "none";
        document.getElementById('langue').innerHTML = `        
        <img src="./assets/image/header/Flag_of_France.svg" alt="">
        `,
        document.getElementById('langue').style.backgroundColor = "#2e2e3f"

    }


})