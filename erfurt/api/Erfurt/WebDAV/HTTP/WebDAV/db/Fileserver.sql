CREATE TABLE locks (
  token varchar(255) NOT NULL default '',
  path varchar(200) NOT NULL default '',
  expires int(11) NOT NULL default '0',
  owner varchar(200) default NULL,
  recursive int(11) default '0',
  writelock int(11) default '0',
  exclusivelock int(11) NOT NULL default 0,
  PRIMARY KEY  (token),
  UNIQUE KEY token (token),
  KEY path (path),
  KEY path_2 (path),
  KEY path_3 (path,token),
  KEY expires (expires)
) TYPE=MyISAM;


CREATE TABLE properties (
  path varchar(255) NOT NULL default '',
  name varchar(120) NOT NULL default '',
  ns varchar(120) NOT NULL default 'DAV:',
  value text,
  PRIMARY KEY  (path,name,ns),
  KEY path (path)
) TYPE=MyISAM;

