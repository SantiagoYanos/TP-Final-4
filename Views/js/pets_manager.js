let petsSet = new Set();

let petsList = document.getElementById("pets_ids");

function addPet(id) {
  if (petsSet.has(id)) {
    petsSet.delete(id);
  } else {
    petsSet.add(id);
  }

  let newValue = Array.from(petsSet).join(",");

  petsList.value = newValue;
}

//onChange("addPet(<?php $pet->getId()?>)")

//<script type="text/javascript" src="./js/pets_manager.js"></script>
