<?php

/**
 * How to use REST API Client
 * to create and get contacts
 *
 * @author Hardik Shah<hardiks059@gmail.com>
 * @since June 16, 2014
 *
 **/

include "apiNew.class.php";

# create object
$api = new apiNew();

# create a new contact
$data = array();

$data['AnniversaryDate'] = date("c", strtotime($_POST["AnniversaryDate"]));
$data['Company'] = $_POST["Company"];
$data['Designation'] = $_POST["Designation"];
$data['Family'] = $_POST["Family"];
$data['Familyname'] = $_POST["Familyname"];
$data['Firstname'] = $_POST["Firstname"];
$data['Gender'] = $_POST["Gender"];
$data['JobTitle'] = $_POST["JobTitle"];
$data['Lastname'] = $_POST["Lastname"];
$data['MaritalStatus'] = $_POST["MaritalStatus"];
$data['Middlename'] = $_POST["Middlename"];
$data['Name'] = $_POST["Name"];
$data['Nickname'] = $_POST["Nickname"];
$data['ReferredBy'] = $_POST["ReferredBy"];
$data['Suffix'] = $_POST["Suffix"];
$data['DateOfBirth'] = date("c", strtotime($_POST["DateOfBirth"]));

$response = $api->createContact($data);
d($response);


# get the contact
$contacts = $api->getContacts();
d($contacts);

die;