CREATE DATABASE tetris;
USE tetris;
CREATE TABLE Users (
    UserName varchar(255) NOT NULL UNIQUE,
    FirstName varchar(255),
    LastName varchar(255),
    Password varchar(255),
    Display int,
    PRIMARY KEY (Username)
);

CREATE TABLE Scores (
    Scoreid int NOT NULL AUTO_INCREMENT,
    Username varchar(255),
    Score int,
    PRIMARY KEY (Scoreid),
    FOREIGN KEY (Username) REFERENCES Users(Username)
);
