PROGRAM WorkWithQueryString(INPUT, OUTPUT);
USES
  SysUtils,
  Dos;

FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR
  QueryString, Param, ParamKey, ParamValue, Result: STRING;
  PosAmp, PosEqual: INTEGER;
  Found: BOOLEAN;
BEGIN {GetQueryStringParameter}
  Result := '';
  Found := FALSE;
  QueryString := GetEnv('QUERY_STRING');

  PosAmp := Pos('&', QueryString);
  WHILE (Length(QueryString) > 0) AND NOT Found
  DO
    BEGIN
      IF PosAmp <> 0
      THEN
        BEGIN
          Param := Copy(QueryString, 1, PosAmp - 1);
          Delete(QueryString, 1, PosAmp)
        END
      ELSE
        BEGIN
          Param := QueryString;
          QueryString := ''
        END;

      PosEqual := Pos('=', Param);
      IF PosEqual <> 0
      THEN
        BEGIN
          ParamKey := Copy(Param, 1, PosEqual - 1);
          ParamValue := Copy(Param, PosEqual + 1, Length(Param) - PosEqual);
          
          IF ParamKey = Key
          THEN
            BEGIN
              Result := ParamValue;
              Found := TRUE
            END
        END;
      PosAmp := Pos('&', QueryString)
    END;
  GetQueryStringParameter := Result
END; {GetQueryStringParameter}

BEGIN {WorkWithQueryString}
  WRITELN('Content-Type: text/plain');
  WRITELN;
  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last Name: ', GetQueryStringParameter('last_name'));
  WRITELN('Age: ', GetQueryStringParameter('age'))
END. {WorkWithQueryString}