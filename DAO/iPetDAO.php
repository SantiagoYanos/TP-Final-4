<?php
    namespace DAO;

    use Models\Pet as Pet;

    interface IPetDAO
    {        
        function Add(Pet $pet);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }
?>