function check(self){
    if (!self.checked){
        document.getElementById('enter_code').style.display = 'none';
    }else{
        document.getElementById('enter_code').style.display = 'block';
    }
}