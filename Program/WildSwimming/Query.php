<?php
include('Connect.php');

//$AdminDB = "
//Create table Admin
//(
//    AdminID int not null primary key auto_increment,
//    AdminName varchar(50),
//    AdminEmail varchar(50),
//    AdminPhoneNumber varchar(20),
//    AdminAddress varchar(50),
//    Password varchar(50)
//
//)";
//
//$query = mysqli_query($connect,$AdminDB);
//
//if($query)
//{
//    echo "Admin Table Success";
//}
//else
//{
//    echo "Error in Admin";
//}
//
//$Customers = "
//Create table Customers
//(
//    CustomerID int not null primary key AUTO_INCREMENT,
//    FirstName varchar(50),
//    SurName varchar(50),
//    Email varchar(20),
//    Addresses varchar(50),
//    PhoneNo varchar(20),
//    Password varchar(50)
//
//)";
//
//$query = mysqli_query($connect,$Customers);
//
//if($query)
//{
//    echo "Customers Table Success";
//}
//else
//{
//    echo "Error in Customers";
//}
//
//
//$Campsite = "
//Create table Campsite
//(
//    CampsiteID int not null primary key auto_increment,
//    CampsiteName varchar(50),
//    Location varchar(50)
//)";
//
//$query = mysqli_query($connect,$Campsite);
//
//if($query)
//{
//    echo "Campsite Table Success";
//}
//else
//{
//    echo "Error in Campsite";
//}
//
//$PitchType = "
//Create table PitchType
//(
//    PitchTypeID int not null primary key auto_increment,
//    TypeName varchar(50)
//
//)";
//
//$query = mysqli_query($connect,$PitchType);
//
//if($query)
//{
//    echo "Pitch Type Table Success";
//}
//else
//{
//    echo "Error in Pitch Type";
//}
//
//$Contact = "
//Create table Contact
//(
//    ContactID int not null primary key auto_increment,
//    ContactMessage LongText,
//    Email varchar(50)
//)";
//
//$query = mysqli_query($connect,$Contact);
//
//if($query)
//{
//    echo "Contact Table Success";
//}
//else
//{
//    echo "Error in Contact";
//}
//
//$Review = "
//Create table SiteReview
//(
//    ReviewID int not null primary key auto_increment,
//    CustomerID int,
//    Review varchar(250),
//    Rating int,
//    Date varchar(20),
//    FOREIGN KEY (CustomerID) references Customers (CustomerID)
//)";
//
//$query = mysqli_query($connect,$Review);
//
//if($query)
//{
//    echo "Review Table Successful";
//}
//else
//{
//    echo "Error in Review";
//}
//
//$LocalAttraction = "
//Create table LocalAttraction
//(
//    LocalAttractionID int not null primary key auto_increment,
//    LocalAttractionName varchar(50),
//    LocalAttractionIntroImage LONGTEXT,
//    LocalAttractionDescription LONGTEXT,
//    LocalAttractionFeatures varchar(255),
//    LocalAttractionImages LONGTEXT
//
//)";
//
//$query = mysqli_query($connect,$LocalAttraction);
//
//if($query)
//{
//    echo "LocalAttraction Table Successful";
//}
//else
//{
//    echo "Error in LocalAttraction";
//}

//$Pitches = "
//Create table Pitches
//(
//    PitchID int not null primary key auto_increment,
//    PitchName varchar(50),
//    PitchIntroImage text,
//    Location varchar(255),
//    LocationAddress LONGTEXT,
//    FacilitiesName LONGTEXT,
//    FacilitiesImage LONGTEXT,
//    Price int,
//    Description LONGTEXT,
//    Status varchar(10),
//    CampsiteID int,
//    PitchTypeID int,
//    LocalAttractionID int,
//    Duration varchar(20),
//    FacilitiesDescription LONGTEXT,
//    FOREIGN KEY (CampsiteID) references campsite (CampsiteID),
//    FOREIGN KEY (PitchTypeID) references pitchtype (PitchTypeID),
//    FOREIGN KEY (LocalAttractionID) references localattraction (LocalAttractionID)
//
//)";
//
//$query = mysqli_query($connect,$Pitches);
//
//if($query)
//{
//    echo "Pitches Table Successful";
//}
//else
//{
//    echo "Error in Pitches";
//}
//
//$Booking = "
//Create table Booking
//(
//    BookingCodeNo int not null primary key auto_increment,
//    BookingDate varchar(50),
//    PitchID int,
//    Status varchar(50),
//    Price int,
//    SubTotal int,
//    Tax int,
//    CustomerEmail varchar(50),
//    BookingQty int,
//    CustomerID int,
//    FOREIGN KEY (PitchID) references Pitches (PitchID),
//    FOREIGN KEY (CustomerID) references Customers (CustomerID)
//
//)";
//
//$query = mysqli_query($connect,$Booking);
//
//if($query)
//{
//    echo "Booking Table Successful";
//}
//else
//{
//    echo "Error in Booking";
//}
//
//$PitchReview = "
//Create table PitchReview
//(
//    PitchReviewID int not null primary key auto_increment,
//    PitchReview LongText,
//    PitchID int,
//    CustomerID int,
//    ReviewDate varchar(20),
//    FOREIGN KEY (PitchID) references Pitches (PitchID),
//    FOREIGN KEY (CustomerID) references Customers (CustomerID)
//
//)";
//
//$query = mysqli_query($connect,$PitchReview);
//
//if($query)
//{
//    echo "PitchReview Table Successful";
//}
//else
//{
//    echo "Error in PitchReview";
//}
//$CreateIP = "
//CREATE TABLE IPAddress (
//  ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
//  IP text NOT NULL
//
//)
//";
//$query = mysqli_query($connect,$CreateIP);
//if($query)
//{
//    echo "IP Tables Successful";
//}
//else
//{
//    echo "Error in IP";
//}
//$CreateRSS = "
//CREATE TABLE rssfeed (
//    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
//    title varchar(100) NOT NULL,
//    description text NOT NULL,
//    link varchar(100) NOT NULL
//)
//";
//$query = mysqli_query($connect,$CreateRSS);
//if($query)
//{
//    echo "RSS Tables Successful";
//}
//else
//{
//    echo "Error in RSS";
//}
