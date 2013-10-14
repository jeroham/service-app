trait EmployeeDataTrait{
//validate data
    public function Validate() {
		$errors = "";
		if($this->first_name = "")
			$errors.= "<li>- First name is required</li>";
		if($this->username = "")
			$errors.= "<li>- Username is required</li>";
        return "";
    }

    //check existing conflicting data
    public function CheckExisting() {
        return $this->Search(
		"(first_name LIKE '%".$this->first_name.
		"%' AND last_name LIKE '%".$this->last_name.
		"%') OR (phone LIKE '%".$this->phone.
		"%') OR (email LIKE '%".$this->email.
		"%') OR (cell_phone LIKE '%".$this->cell_phone
		);
		
    }
	 public function CheckLogin($manager=false,$redirect="#"){
        //$query = "SELECT employeeid FROM employee WHERE employeeid='$employeeid' AND username='$username' AND password='$password'";
        $query = "SELECT employeeid FROM employee WHERE username='$this->username' AND password='$this->password'";
        
        if($manager){
            $query.= " AND roles like '%manager%'";
        }
        $query .= " LIMIT 1"; // query the person}

        $result = $this->Query($query);

        return $result->rowCount() > 0;
    }
}