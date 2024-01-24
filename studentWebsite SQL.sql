CREATE DATABASE studentwebsite;
USE studentwebsite;

CREATE TABLE users (
    username VARCHAR(64) NOT NULL PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    email VARCHAR(64) NOT NULL,
    type VARCHAR(8) NOT NULL,
    CONSTRAINT UC_email UNIQUE (email)
) ENGINE = InnoDB;

CREATE TABLE groups (
    groupid INT(10) NOT NULL PRIMARY KEY,
    groupname VARCHAR(128) NOT NULL,
    creatorname VARCHAR(64) NOT NULL,
    joincode VARCHAR(16) NOT NULL,
    CONSTRAINT fk_group_creator FOREIGN KEY (creatorname) REFERENCES users(username)
) ENGINE = InnoDB;

CREATE TABLE message (
    messageid INT(15) NOT NULL PRIMARY KEY,
    messageText VARCHAR(1024) NOT NULL,
    groupid INT(10) NOT NULL,
    user VARCHAR(64) NOT NULL,
    timeSent DATETIME NOT NULL,
    CONSTRAINT fk_group_messaged FOREIGN KEY (groupid) REFERENCES groups(groupid),
    CONSTRAINT fk_sender FOREIGN KEY (user) REFERENCES users(username)
) ENGINE = InnoDB;

CREATE TABLE groups2users (
    groupid INT(10) NOT NULL,
    user VARCHAR(64) NOT NULL,
    PRIMARY KEY (groupid, user),
    CONSTRAINT fk_group FOREIGN KEY (groupid) REFERENCES groups(groupid),
    CONSTRAINT fk_user FOREIGN KEY (user) REFERENCES users(username)
) ENGINE = InnoDB;

CREATE TABLE usersettings (
    user VARCHAR(64) NOT NULL PRIMARY KEY,
    CONSTRAINT fk_usersettings FOREIGN KEY (user) REFERENCES users(username)
) ENGINE = InnoDB;

CREATE TABLE groupsettings (
    groupid INT(10) NOT NULL PRIMARY KEY,
    CONSTRAINT fk_groupsettings FOREIGN KEY (groupid) REFERENCES groups(groupid)
) ENGINE = InnoDB;


//need table for announcements