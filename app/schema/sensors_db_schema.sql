CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER);
CREATE INDEX time_index ON def(time);

