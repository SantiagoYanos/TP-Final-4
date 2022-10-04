<?php

    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;

    use Models\Owner as Owner;
    use Models\Pet as Pet;

    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();
    }


    

?>