CREATE DATABASE nmo;
USE nmo;

SHOW TABLES;

CREATE TABLE Board (
	BoardName	VARCHAR(4)		NOT NULL,
	BoardDesc	VARCHAR(255)	NOT NULL,
	PRIMARY KEY (BoardName)
);

CREATE TABLE Media (
	MediaID		INT				UNSIGNED	NOT NULL	AUTO_INCREMENT,
	MediaName	VARCHAR(255)				NOT NULL,
	Type		VARCHAR(4)					NOT NULL,
	Size		INT				UNSIGNED	NOT NULL,
	Dim			VARCHAR(9)					NOT NULL,
	PRIMARY KEY (MediaID)
);

CREATE TABLE Thread (
	ThreadNo		INT			UNSIGNED	NOT NULL,
	Board			VARCHAR(4)				NOT NULL,
	LastUpdate		TIMESTAMP				NOT NULL,
	PruneOrDeleted	BOOLEAN					NOT NULL,
	PRIMARY KEY (ThreadNo),
	FOREIGN KEY (Board) REFERENCES Board(BoardName)
);

CREATE TABLE Post (
	PostID      INT             UNSIGNED    NOT NULL    AUTO_INCREMENT,
    Type        BOOL                        NOT NULL,
	ThreadID    INT             UNSIGNED    NOT NULL,
	Title       VARCHAR(100),
	Name        VARCHAR(20),
	PostTime    TIMESTAMP                   NOT NULL,
	Media       INT				UNSIGNED,
	Message     TEXT(60000)                 	NULL,
	PRIMARY KEY (PostID),
	FOREIGN KEY (Media) REFERENCES Media(MediaID),
	FOREIGN KEY (ThreadID) REFERENCES Thread(ThreadNo)
);

CREATE TABLE Reference (
	Referer		INT		UNSIGNED	NOT NULL,
	Reference	INT		UNSIGNED	NOT NULL,
	FOREIGN KEY (Referer) REFERENCES Post(PostID),
	FOREIGN KEY (Reference) REFERENCES Post(PostID)
);

CREATE TABLE Report (
	ReportID	INT		UNSIGNED	NOT NULL,
	PostID		INT		UNSIGNED	NOT NULL,
	FOREIGN KEY (PostID) REFERENCES Post(PostID)
);

CREATE TABLE Janny (
	JannyID			INT			UNSIGNED	NOT NULL,
	JannyName		VARCHAR(30)				NOT NULL,
	JannyPassHex	VARCHAR(50)				NOT NULL,
	PRIMARY KEY (JannyID)
);

INSERT INTO Board (BoardName, BoardDesc)
VALUES ('a', "The /a/ Board");
INSERT INTO Board (BoardName, BoardDesc)
VALUES ('b', "The /b/ Board");
INSERT INTO Board (BoardName, BoardDesc)
VALUES ('c', "The /c/ Board");
INSERT INTO Board (BoardName, BoardDesc)
VALUES ('test', "The /test/ Board");

INSERT INTO Thread (ThreadNo, Board, LastUpdate, PruneOrDeleted)
VALUES (1, 'test', STR_TO_DATE('13/01/2025(Mon)13:00:00', '%d/%m/%Y(%a)%H:%i:%s'), FALSE);
INSERT INTO Media(MediaName, Type, Size, Dim)
VALUES ('kms.jpg', 'jpg', 43167, '680x561');
INSERT INTO Post (Type, ThreadID, Title, Name, PostTime, Media, Message)
VALUES (TRUE, 1, "A Thread", 'Saggy', STR_TO_DATE('13/01/2025(Mon)13:00:00', '%d/%m/%Y(%a)%H:%i:%s'), 1, "I hate myself and I want to die");
UPDATE Thread
SET LastUpdate = STR_TO_DATE('13/01/2025(Mon)13:00:00', '%d/%m/%Y(%a)%H:%i:%s')
WHERE ThreadNo = 1;

INSERT INTO Media(MediaName, Type, Size, Dim)
VALUES ('gotoreddit.png', 'png', 62531, '285x208');
INSERT INTO Post (Type, ThreadID, Name, PostTime, Media, Message)
VALUES (FALSE, 1, '', STR_TO_DATE('13/01/2025(Mon)13:15:07', '%d/%m/%Y(%a)%H:%i:%s'), 2, '>Talks about suicide.\n(go to reddit)[reddit.com]');
UPDATE Thread
SET LastUpdate = STR_TO_DATE('13/01/2025(Mon)13:15:07', '%d/%m/%Y(%a)%H:%i:%s')
WHERE ThreadNo = 1;

INSERT INTO Media(MediaName, Type, Size, Dim)
VALUES ('you rn.mp4', 'mp4', 240865, '480x480');
INSERT INTO Post (Type, ThreadID, Name, PostTime, Media, Message)
VALUES (FALSE, 1, '', STR_TO_DATE('13/01/2025(Mon)13:15:43', '%d/%m/%Y(%a)%H:%i:%s'), 3, 'This is you');
UPDATE Thread
SET LastUpdate = STR_TO_DATE('13/01/2025(Mon)13:15:43', '%d/%m/%Y(%a)%H:%i:%s')
WHERE ThreadNo = 1;

INSERT INTO Post (Type, ThreadID, Name, PostTime, Media, Message)
VALUES (FALSE, 1, '', STR_TO_DATE('13/01/2025(Mon)13:16:02', '%d/%m/%Y(%a)%H:%i:%s'), NULL, "Don't kill yourself. At least see what's good, and try not to veer into the dark");
UPDATE Thread
SET LastUpdate = STR_TO_DATE('13/01/2025(Mon)13:16:02', '%d/%m/%Y(%a)%H:%i:%s')
WHERE ThreadNo = 1;
INSERT INTO Reference (Referer, Reference)
VALUES (4, 1);
