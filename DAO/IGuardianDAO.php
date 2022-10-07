<?php
    namespace DAO;

    use Models\Guardian as Guardian;
    
    interface IGuardianDAO 
    {
        function Add(Guardian $guardian);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }




?>