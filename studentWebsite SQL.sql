CREATE DATABASE studentwebsite;
USE studentwebsite;

CREATE TABLE users (
    username VARCHAR(64) NOT NULL PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    email VARCHAR(64) NOT NULL,
    type VARCHAR(8) NOT NULL,
    CONSTRAINT UC_email UNIQUE (email)
) ENGINE = InnoDB;

CREATE TABLE chatgroup (
    groupid INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    groupname VARCHAR(128) NOT NULL,
    creatorname VARCHAR(64) NOT NULL,
    joincode VARCHAR(16) NOT NULL,
    UNIQUE(joincode),
    CONSTRAINT fk_group_creator FOREIGN KEY (creatorname) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE educatorgroup (
    groupid INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    groupname VARCHAR(128) NOT NULL,
    creatorname VARCHAR(64) NOT NULL,
    joincode VARCHAR(16) NOT NULL,
    UNIQUE(joincode),
    CONSTRAINT fk_educatorgroup_creator FOREIGN KEY (creatorname) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE message (
    messageid INT(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    messageText VARCHAR(1024) NOT NULL,
    groupid INT(10) NOT NULL,
    user VARCHAR(64) NOT NULL,
    timeSent DATETIME NOT NULL,
    CONSTRAINT fk_group_messaged FOREIGN KEY (groupid) REFERENCES chatgroup(groupid) ON DELETE CASCADE,
    CONSTRAINT fk_sender FOREIGN KEY (user) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE groups2users (
    groupid INT(10) NOT NULL,
    user VARCHAR(64) NOT NULL,
    PRIMARY KEY (groupid, user),
    CONSTRAINT fk_group FOREIGN KEY (groupid) REFERENCES chatgroup(groupid) ON DELETE CASCADE,
    CONSTRAINT fk_user FOREIGN KEY (user) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE educatorgroups2users (
    groupid INT(10) NOT NULL,
    user VARCHAR(64) NOT NULL,
    PRIMARY KEY (groupid, user),
    CONSTRAINT fk_educatorgroup FOREIGN KEY (groupid) REFERENCES educatorgroup(groupid) ON DELETE CASCADE,
    CONSTRAINT fk_educatoruser FOREIGN KEY (user) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE usersettings (
    user VARCHAR(64) NOT NULL PRIMARY KEY,
    CONSTRAINT fk_usersettings FOREIGN KEY (user) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE groupsettings (
    groupid INT(10) NOT NULL PRIMARY KEY,
    CONSTRAINT fk_groupsettings FOREIGN KEY (groupid) REFERENCES chatgroup(groupid) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE educatorgroupsettings (
    groupid INT(10) NOT NULL PRIMARY KEY,
    CONSTRAINT fk_educatorgroupsettings FOREIGN KEY (groupid) REFERENCES educatorgroup(groupid) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE announcements (
    announcementid INT(12) PRIMARY KEY AUTO_INCREMENT,
    announcementtext VARCHAR(10000),
    sender VARCHAR(64),
    groupid INT(10),
    timesent DATETIME NOT NULL,
    CONSTRAINT fk_announcegroup FOREIGN KEY (groupid) REFERENCES educatorgroup(groupid) ON DELETE CASCADE,
    CONSTRAINT fk_userannouncement FOREIGN KEY (sender) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE userimage (
    username VARCHAR(64) NOT NULL PRIMARY KEY,
    groupimage LONGBLOB NOT NULL,
    CONSTRAINT fk_userimage FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE groupimage (
    groupid INT(10) NOT NULL PRIMARY KEY,
    groupimage LONGBLOB NOT NULL,
    CONSTRAINT fk_groupimage FOREIGN KEY (groupid) REFERENCES chatgroup(groupid) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE educatorgroupimage (
    groupid INT(10) NOT NULL PRIMARY KEY,
    groupimage LONGBLOB NOT NULL,
    CONSTRAINT fk_educatorgroupimage FOREIGN KEY (groupid) REFERENCES educatorgroup(groupid) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE discussions (
    discussionName VARCHAR(128),
    groupid INT(10),
    CONSTRAINT fk_discussiongroup FOREIGN KEY (groupid) REFERENCES educatorgroup(groupid) ON DELETE CASCADE,
    PRIMARY KEY(discussionName, groupid)
) ENGINE = InnoDB;

CREATE TABLE discussionmessage (
    messageid INT(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    messageText VARCHAR(1024) NOT NULL,
    groupid INT(10) NOT NULL,
    discussionName VARCHAR(128) NOT NULL,
    user VARCHAR(64) NOT NULL,
    timeSent DATETIME NOT NULL,
    CONSTRAINT fk_discussion_messaged FOREIGN KEY (groupid) REFERENCES educatorgroup(groupid) ON DELETE CASCADE,
    CONSTRAINT fk_discussionsender FOREIGN KEY (user) REFERENCES users(username) ON DELETE CASCADE,
    CONSTRAINT fk_discussionmessagename FOREIGN KEY (discussionName) REFERENCES discussions(discussionName) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE events (
    eventid INT(16) AUTO_INCREMENT NOT NULL,
    eventname VARCHAR(256) NOT NULL,
    maxparticipants INT(3) NOT NULL,
    participants INT(3) NOT NULL,
    starttime DATETIME NOT NULL,
    duration DECIMAL(5, 2) NOT NULL,
    organiser VARCHAR(64) NOT NULL,
    descript VARCHAR(256) NOT NULL,
    groupid INT(10) NOT NULL,
    PRIMARY KEY (eventid, eventname),
    CONSTRAINT fk_events_organiser FOREIGN KEY (organiser) REFERENCES users(username) ON DELETE CASCADE,
    CONSTRAINT fk_events_groupid FOREIGN KEY (groupid) REFERENCES chatgroup(groupid) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE events2users (
    eventid INT(16) NOT NULL,
    username VARCHAR(64) NOT NULL,
    CONSTRAINT fk_events2users_event FOREIGN KEY (eventid) REFERENCES events(eventid) ON DELETE CASCADE,
    CONSTRAINT fk_events2users_username FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE,
    PRIMARY KEY (eventid, username)
) ENGINE = InnoDB;

CREATE TABLE imagesent (
    groupid INT(10) NOT NULL,
    imagemessagesid INT(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    timeSent DATETIME NOT NULL,
    sender VARCHAR(64) NOT NULL,
    imagedata BLOB NOT NULL,
    CONSTRAINT fk_imagesent_groupid FOREIGN KEY (groupid) REFERENCES chatgroup(groupid) ON DELETE CASCADE,
    CONSTRAINT fk_imagesent_sender FOREIGN KEY (sender) REFERENCES users(username) ON DELETE CASCADE
) ENGINE = InnoDB;

/*all indexes are written in the form index_(table name)_(column name) */
CREATE INDEX index_chatgroup_creatorname ON chatgroup(creatorname);
CREATE INDEX index_educatorgroup_creatorname ON educatorgroup(creatorname);
CREATE INDEX index_message_timesent ON message(timeSent);
CREATE INDEX index_announcements_timesent ON announcements(timesent);
CREATE INDEX index_imagesent_timesent ON imagesent(timeSent);
CREATE INDEX index_events_starttime ON events(starttime);
