<?php
    namespace DAO;

    use Models\Payment as Payment;

    interface IPaymentDAO
    {        
        function Add(Payment $pet);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }
?>