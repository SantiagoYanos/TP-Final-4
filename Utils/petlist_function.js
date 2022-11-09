function myFunction($maxPets) {
    var cont=0;
    var checkBox = document;
        var stringPets='';

        while(cont < $maxPets){
            checkBox = document.getElementById(cont);
            if (checkBox.checked == true){
                stringPets = stringPets + checkBox.value + ',';
            }
        }

        return stringPets;
    }
