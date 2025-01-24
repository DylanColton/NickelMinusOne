CREATE DATABASE nmo;
USE nmo;

CREATE TABLE Board (
	BoardName		VARCHAR(4)					NOT NULL,
	BoardDesc		VARCHAR(255)				NOT NULL,
	PruneLimit		INT				UNSIGNED	NOT NULL	DEFAULT(604800),
	FileSizeLimit	INT				UNSIGNED	NOT NULL	DEFAULT(5000000),
	ThreadBumpLimit	INT				UNSIGNED	NOT NULL	DEFAULT(300),
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
	LastUpdate		VARCHAR(23)				NOT NULL,
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
	PostTime    VARCHAR(23)                 NOT NULL,
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
VALUES ('test', "The /test/ Board");
