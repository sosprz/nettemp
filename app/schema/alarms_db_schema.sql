CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER, name TEXT, unit TEXT, status TEXT, action TEXT, min FLOAT, max FLOAT, type TEXT);
CREATE INDEX time_index ON def(time);

